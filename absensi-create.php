<?php

try {
    require_once('connection.php');

    $iduser         = $con->real_escape_string($_REQUEST["iduser"]);
    $latitude       = $con->real_escape_string($_REQUEST["latitude"]);
    $longitude      = $con->real_escape_string($_REQUEST["longitude"]);
    $lokasi         = $con->real_escape_string($_REQUEST["lokasi"]);
    $tipe           = $con->real_escape_string($_REQUEST["tipe"]);
    $taskid         = $con->real_escape_string($_REQUEST["taskid"]);

    ## upload foto check-in atau check-out
    $target_dir = "uploads/";

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $ext = "." . pathinfo($_FILES["filename"]["name"], PATHINFO_EXTENSION);
    
    $target_file_name = $iduser . "-" . date("Y-m-d-h-i-s") . $ext;
    
    if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file_name)) {
        $sql = "INSERT INTO absensi (id_user, taskid, longitude, latitude, lokasi, filename, tanggal, tipe)
                VALUES ('$iduser', '$taskid', '$longitude', '$latitude','$lokasi', '$target_file_name', now(), '$tipe')";
        if (mysqli_query($con, $sql)) {
            ## Berhasil Absensi
            $data = ['status' => "succeeded", 'message' => 'Berhasil melakukan absensi ' . $tipe];
        } else {
            ## Rollback transaction
            $data = ['status' => "failed", 'message' => 'Gagal melakukan absensi ' . $tipe];
        }
    } else {
        ## gagal upload foto
        $data = ['status' => "failed", 'message' => 'Gagal upload foto.'];
    }
    
    
    echo json_encode($data);
    // Close connection
    mysqli_close($con);
} catch (Exception $ex) {
    echo 'Error: ' . $ex->getMessage();
}
?>