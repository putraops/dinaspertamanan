<?php

try {
    require_once('connection.php');
    $data = [];

    $taskiddetail = $con->real_escape_string($_REQUEST["taskiddetail"]);
    $userid = $con->real_escape_string($_REQUEST["userid"]);
    $latitude = $con->real_escape_string($_REQUEST["latitude"]);
    $longitude = $con->real_escape_string($_REQUEST["longitude"]);
    $lokasi = $con->real_escape_string($_REQUEST["lokasi"]);

    $target_dir = "uploads/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    ## Set autocommit to off
    mysqli_autocommit($con, FALSE);
    
    $ext = "." . pathinfo($_FILES["filename"]["name"], PATHINFO_EXTENSION);

    $targetfilename = "pengerjaan-" . date("Y-m-d-h-i-s") . $ext;

    if (isset($_FILES["filename"])) {
        if (move_uploaded_file($_FILES["filename"]["tmp_name"], $targetfilename)) {
            ## Berhasil upload
            #
            ## INSERT PEKERJAAN
            $sql = " INSERT INTO pengerjaan (taskiddetail, userid, filename, latitude, longitude, lokasi, created_at, updated_at)
                        VALUES ('$taskiddetail', '$userid', '$targetfilename', '$latitude', '$longitude', '$lokasi', now(), now())";

            if (mysqli_query($con, $sql)) {
                $data = ['status' => "Succeeded", 'message' => 'Pengeluaran berhasil ditambahkan.'];
                mysqli_commit($con);
            } else {
                // Rollback transaction
                mysqli_rollback($con);
                $data = ['status' => "failed", 'message' => 'Pengeluaran gagal ditambahkan.'];
            }

        } else {
            mysqli_rollback($con);
            $data = ['status' => "failed", 'message' => 'Gagal upload foto.'];
        }
    } else {
        $data = ['status' => "failed", 'message' => 'Foto belum ditambahkan.'];
    }

    echo json_encode($data);
    ## Close connection
    mysqli_close($con);
} catch (Exception $ex) {
    echo 'Error: ' . $ex->getMessage();
}
?>