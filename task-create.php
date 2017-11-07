<?php

try {
    require_once('connection-task.php');

    $useronduty = "";
    $tujuan = "";
    $noError = true;

    $taskname    = $taskconnection->real_escape_string($_REQUEST["taskname"]);
    $detail      = $taskconnection->real_escape_string($_REQUEST["detailtask"]);
    $userid      = $taskconnection->real_escape_string($_REQUEST["userid"]);
    $kendaraanid = $taskconnection->real_escape_string($_REQUEST["kendaraanid"]);

    if (isset($_REQUEST["useronduty"])) {
        $useronduty = $taskconnection->real_escape_string($_REQUEST["useronduty"]);
        $useronduty = str_replace('\\', '', $useronduty);
    }
    if (isset($_REQUEST["tujuan"])) {
        $tujuan = $taskconnection->real_escape_string($_REQUEST["tujuan"]);
        $tujuan = str_replace('\\', '', $tujuan);
    }

    
    $myJsonPekerja = json_decode($useronduty);
    $myJsonTujuan = json_decode($tujuan);


    if (count($myJsonPekerja) <= 0) {
        $data = ['status' => "failed", 'message' => 'Silahkan pilih petugas yang akan ditugaskan.'];
        $noError = false;
    } else {
        if (count($myJsonTujuan) <= 0) {
            $data = ['status' => "failed", 'message' => 'Silahkan pilih tujuan yang akan dituju.'];
            $noError = false;
        }
    }
    
    
    if ($noError) {
        mysqli_autocommit($taskconnection, FALSE);
        $SQLTASK = "INSERT INTO task (TaskName, TanggalDibuat, DetailTask, StatusTask, CreatedUser)
                    VALUES ('$taskname',  now(), '$detail', 'Baru', '$userid')";

        if (mysqli_query($taskconnection, $SQLTASK)) {
            $taskid = $taskconnection->insert_id;
            $taskkendaraanid = 0;
            
            $SQLTASKKENDARAAN = "INSERT INTO TaskKendaraan (taskid, kendaraanid)
                                 VALUES ('$taskid', '$kendaraanid')";
            
            if (mysqli_query($taskconnection, $SQLTASK)) {
                $taskkendaraanid = $taskconnection->insert_id;
                
                ## Tambahkan Tujuan Task
                foreach ($myJsonTujuan as $value) {
                    $SQLTUJUANTASK = "INSERT INTO task_detail (taskid, lokasi, latitude, longitude, status, created_at, updated_at)
                                      VALUES ('$taskid', '$value->lokasi', '$value->latitude', '$value->longitude', 'Belum', now(), now())";
                    $taskconnection->query($SQLTUJUANTASK);
                }

                ## Tambahkan Pekerja
                foreach ($myJsonPekerja as $value) {
                    $SQLPEKERJA = "INSERT INTO pekerja (taskkendaraanid, userid, status)
                                   VALUES ('$taskkendaraanid', '$value->iduser', '$value->status')";
                    $taskconnection->query($SQLPEKERJA);
                }
                
                ## Commit transaction
                mysqli_commit($taskconnection);
                $data = ['status' => "succeeded", 'message' => 'Task baru berhasil dibuat.'];
            } else {
                $data = ['status' => "failed", 'message' => 'Gagal pada penambahan kendaraan yang digunakan dalam task.'];
            }
        } else {
            ## Rollback transaction
            mysqli_rollback($taskconnection);
            $data = ['status' => "failed", 'message' => 'Task baru gagal dibuat.'];
        }
    }

    echo json_encode($data);
    ## Close connection
    mysqli_close($taskconnection);
} catch (Exception $ex) {
    echo 'Error: ' . $ex->getMessage();
}
?>