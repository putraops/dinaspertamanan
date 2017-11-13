<?php

try {
    require_once('connection.php');

    $iduser         = $con->real_escape_string($_REQUEST["iduser"]);
    $latitude       = $con->real_escape_string($_REQUEST["latitude"]);
    $longitude      = $con->real_escape_string($_REQUEST["longitude"]);
    $lokasi         = $con->real_escape_string($_REQUEST["lokasi"]);
    $tipe           = $con->real_escape_string($_REQUEST["tipe"]);
    $taskid         = $con->real_escape_string($_REQUEST["taskid"]);
    //$taskdetailid   = $con->real_escape_string($_REQUEST["taskdetailid"]);

    // Set autocommit to off
    mysqli_autocommit($main_connection, FALSE);
    mysqli_autocommit($inner_connection, FALSE);
    mysqli_autocommit($subinner_connection, FALSE);

    ## upload foto check-in atau check-out
    $target_dir = "uploads/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $ext = "." . pathinfo($_FILES["filename"]["name"], PATHINFO_EXTENSION);
    
    $sql = " INSERT INTO pengerjaan (TaskDetailID, ext, Tipe, created_at, updated_at)
             VALUES ('$taskdetailid', '$ext', '$tipe', now(), now())";

    if (mysqli_query($con, $sql)) {
        $last_id = $con->insert_id;
        $target_file_name = $target_dir . $last_id . $ext;
        if (isset($_FILES["filename"])) {
            //echo 123;
            if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file_name)) {
            //echo 0000; exit;
                ## berhasil upload foto
                ##
                ## Update Status Task
                $statusdetailtask = 'Sedang Dikerjakan';
                if ($tipe == "checkout") {
                    $statusdetailtask = 'Menunggu Pengecekan';
                }
                
                $sql  = "UPDATE task_detail SET status = '$statusdetailtask', updated_at = now() ";
                $sql .= "WHERE id = '$taskdetailid'";
                if (mysqli_query($con, $sql)) {
                    ## Berhasil ubah status task
                    ##
                    ## Jalankan Absensi
                    
                    if ($tipe == "pengerjaan" || $tipe == "ulangipengerjaan") {
                        $data = ['status' => "succeeded", 'message' => 'Berhasil upload hasil pekerjaan.'];
                    } else {
                        $sql = "INSERT INTO absensi (id_user, TaskID, longitude, latitude, lokasi, tanggal, tipe)
                                VALUES ('$iduser', '$taskid', '$longitude', '$latitude','$lokasi', now(), '$tipe')";
    
                        if (mysqli_query($con, $sql)) {
                            ## Berhasil Absensi
                            $data = ['status' => "succeeded", 'message' => 'Berhasil melakukan ' . $tipe];
                        } else {
                            ## Rollback transaction
                            $data = ['status' => "failed", 'message' => $tipe .' absen gagal.'];
                        }
                    }
                } else {
                    ## gagal ubah status task
                    $data = ['status' => "failed", 'message' => $tipe .' absen gagal.'];
                }
            } else {
                ## gagal upload foto
                $data = ['status' => "failed", 'message' => 'Gagal upload foto.'];
            }
        }
    } else {
        // Rollback transaction
        mysqli_rollback($main_connection);
        mysqli_rollback($inner_connection);
        mysqli_rollback($subinner_connection);
        $data = ['status' => "failed", 'message' => 'Pengerjaan gagal ditambahkan.'];
    }

    echo json_encode($data);
    // Close connection
    mysqli_close($con);
} catch (Exception $ex) {
    echo 'Error: ' . $ex->getMessage();
}
?>