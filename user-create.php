<?php

try {
    require_once('connection.php');

    $username = $con->real_escape_string($_REQUEST["username"]);
    $password = $con->real_escape_string($_REQUEST["password"]);
    $nama = $con->real_escape_string($_REQUEST["nama"]);
    $telp = $con->real_escape_string($_REQUEST["telp"]);
    $id_jabatan = $con->real_escape_string($_REQUEST["idjabatan"]);

    $hashpassword = md5($password);

    // Set autocommit to off
    mysqli_autocommit($con, FALSE);

    $sql = "INSERT INTO user (username, password, nama, telepon, id_jabatan, is_active, created_at, updated_at)
                VALUES ('$username', '$hashpassword', '$nama', '$telp', '$id_jabatan', 1, now(), now())";


    if ($con->query($sql)) {
        $last_purchase_id = $con->insert_id;
        // Commit transaction
        mysqli_commit($con);
        $data = [
            'status' => "succeeded",
            'message' => 'Register user berhasil.',
            'data' => $last_purchase_id
        ];
        mysqli_commit($con);
    } else {

        mysqli_rollback($con);
        $data = ['status' => "failed", 'message' => 'Register user gagal.'];
    }

    echo json_encode($data);
    // Close connection
    mysqli_close($con);
} catch (Exception $ex) {
    echo 'Error: ' . $ex->getMessage();
}
?>