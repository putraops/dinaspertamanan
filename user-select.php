<?php

try {
    require_once('connection.php');

    $id = "";
    $jabatanid = "";

    if (isset($_REQUEST["id"])) {
        $id = $con->real_escape_string($_REQUEST["id"]);
    }

    //echo "----".$id;
    if (isset($_REQUEST["jabatanid"])) {
        $jabatanid = $con->real_escape_string($_REQUEST["jabatanid"]);
    }

    //echo "----".$jabatanid;

    $arrResult = array();

    $sql = "Select u.id as id, u.username as username, u.nama as namauser, u.telepon as telepon, j.id as kodejabatan, j.nama as namajabatan 
                from user u
                INNER JOIN jabatan j ON j.id = u.id_jabatan 
                where u.is_active = 1";

    if ($id > 0 || $id != "") {
        $sql .= " AND u.id = '$id';";
    }
    if ($jabatanid > 0 || $jabatanid != "") {
        $sql .= " AND j.id = '$jabatanid';";
    }
    

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data = [
                'id' => $row['id'],
                'username' => $row['username'],
                'namauser' => $row['namauser'],
                'telepon' => $row['telepon'],
                'kodejabatan' => $row['kodejabatan'],
                'namajabatan' => $row['namajabatan']
            ];
            array_push($arrResult, $data);
        }
        $data = ['status' => "succeeded", 'message' => 'User didapatkan', 'Data' => $arrResult];
    } else {
        $data = ['status' => "failed", 'message' => 'User gagal didapatkan.'];
    }

    echo json_encode($data);
    ## Close connection
    mysqli_close($con);
} catch (Exception $ex) {
    echo 'Error: ' . $ex->getMessage();
}
?>