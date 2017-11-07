<?php

try {
    require_once('connection.php');

    $id = "";
    $nama = "";
    $no_polisi = "";
    $userid = "";

    if (isset($_REQUEST["id"])) {
        $id = $con->real_escape_string($_REQUEST["id"]);
    }
    if (isset($_REQUEST["penanggungjawabuserid"])) {
        $userid = $con->real_escape_string($_REQUEST["penanggungjawabuserid"]);
    }
    if (isset($_REQUEST["nama"])) {
        $nama = $con->real_escape_string($_REQUEST["nama"]);
    }
    if (isset($_REQUEST["no_polisi"])) {
        $no_polisi = $con->real_escape_string($_REQUEST["no_polisi"]);
    }


    ## Set autocommit to off
    mysqli_autocommit($con, FALSE);

    $sql = "UPDATE kendaraan ";
    $sql .= "SET updated_at = now()";
    
    if ($userid != "") {
        $sql .= ", penanggungjawabuserid = '$userid'";
    }
    if ($nama != "") {
        $sql .= ", nama = '$nama'";
    }
    if ($no_polisi != "") {
        $sql .= ", no_polisi = '$no_polisi'";
    }
    $sql .= "WHERE ID = '$id'";



    if (mysqli_query($con, $sql)) {
        ## Commit transaction

        mysqli_commit($con);
        $data = ['status' => "succeeded", 'message' => 'Berhasil ubah data kendaraan.'];
    } else {
        ## Rollback transaction
        mysqli_rollback($con);
        $data = ['status' => "failed", 'message' => 'Gagal ubah data kendaraan.'];
    }


    echo json_encode($data);
    ## Close connection
    mysqli_close($con);
} catch (Exception $ex) {
    echo 'Error: ' . $ex->getMessage();
}
?>