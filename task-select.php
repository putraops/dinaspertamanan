<?php

try {
    require_once('connection.php');

    $id = "";
    $status = "";
    $iduser = "";
    $idsalesmanager = "";

    if (isset($_REQUEST["id"])) {
        $id = $con->real_escape_string($_REQUEST["id"]);
    }
    if (isset($_REQUEST["iduser"])) {
        $iduser = $con->real_escape_string($_REQUEST["iduser"]);
    }
    if (isset($_REQUEST["status"])) {
        $status = $con->real_escape_string($_REQUEST["status"]);
    }

    ## Array Declare
    $arrResult = array();
    $arrPekerja = array();
    $arrTodoList = array();
    $arrPengerjaan = array();
    $arrAbsensi = array();
    $totalPekerja = 0;

    $sql  = "Select t.id as id, 
                    t.taskname as namatask,
                    t.detailtask as detailtask,
                    t.tanggaldibuat as tanggaldibuat, 
                    t.statustask as statustask,  
                    u.nama as creatednameuser, 
                    u.id as createduserid, 
                    up.nama as namasopir, 
                    up.id as sopirid,
                    k.nama as namakendaraan,
                    k.no_polisi as nopolis
            FROM task t 
            INNER JOIN taskkendaraan tk ON tk.taskid = t.id
            INNER JOIN kendaraan k ON k.id = tk.kendaraanid
            INNER JOIN user up ON up.id = tk.userid
            INNER JOIN user u ON t.createduser = u.id";
    $sql .= " WHERE t.id > 0 AND t.statustask != 'Closed'";
    //echo $sql;exit;
    if ($status != "") {
        $sql .= " AND t.statustask = '$status'";
    }
    if ($iduser != "") {
        $sql .= " AND tk.userid = '$iduser'";
    }
    if ($id != "") {
        $sql .= " AND t.id = '$id'";
    }

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $taskid = $row['id'];

            $data = [
                'id' => $taskid,
                'namatask' => $row['namatask'],
                'tanggaldibuat' => $row['tanggaldibuat'],
                'statustask' => $row['statustask'],
                'detailtask' => $row['detailtask'],
                'dibuatolehid' => $row['createduserid'],
                'dibuatoleh' => $row['creatednameuser'],
                'namasopir' => $row['namasopir'],
                'sopirid' => $row['sopirid']
            ];
            
            array_push($arrResult, $data);

            if ($id == "" || $id == 0) {
                
            } else if ($id > 0) {
                ## DETAIl PEKERJAAN
                $sql = "SELECT id, lokasi, latitude, longitude, status 
                            FROM task_detail 
                            WHERE taskid = '$id'";
                $sql .= " ORDER BY id ASC;";

                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $data = [
                            'id' => $row['id'],
                            'idtask' => $id,
                            'lokasi' => $row['lokasi'],
                            'latitude' => $row['latitude'],
                            'longitude' => $row['longitude'],
                            'status' => $row['status']
                        ];
                        array_push($arrTodoList, $data);
                    }
                }
                
                ## Ambil data absensi
                $sql = "SELECT id, id_user, taskid, longitude, latitude, lokasi, filename, tanggal, tipe
                            FROM absensi 
                            WHERE taskid = '$id'";
                $sql .= " ORDER BY tipe ASC;";

                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $data = [
                            'id' => $row['id'],
                            'iduser' => $row['id_user'],
                            'idtask' => $id,
                            'lokasi' => $row['lokasi'],
                            'latitude' => $row['latitude'],
                            'longitude' => $row['longitude'],
                            'tanggal' => $row['tanggal'],
                            'tipe' => $row['tipe'],
                            'fileupload' => $_SERVER['SERVER_NAME'] . "\\" . "uploads" . "\\" . $row['filename']
                        ];
                        array_push($arrAbsensi, $data);

                    }
                }
                
                ## Ambil data pengerjaan
//                $sql = "SELECT id, id_user, taskid, longitude, latitude, lokasi, filename, tanggal, tipe
//                            FROM absensi 
//                            WHERE taskid = '$id'";
//                $sql .= " ORDER BY tipe ASC;";
//
//                $result = $con->query($sql);
//
//                if ($result->num_rows > 0) {
//                    while ($row = $result->fetch_assoc()) {
//                        $data = [
//                            'id' => $row['id'],
//                            'iduser' => $row['id_user'],
//                            'idtask' => $id,
//                            'lokasi' => $row['lokasi'],
//                            'latitude' => $row['latitude'],
//                            'longitude' => $row['longitude'],
//                            'tanggal' => $row['tanggal'],
//                            'tipe' => $row['tipe'],
//                            'fileupload' => $_SERVER['SERVER_NAME'] . "\\" . "uploads" . "\\" . $row['filename']
//                        ];
//                        array_push($arrAbsensi, $data);
//
//                    }
//                }
            }
        }

        $data = ['status' => "succeeded",
            'message' => 'Detail Task berhasil didapatkan.',
            'Data' => $arrResult,
            'Detail' => $arrTodoList,
            'HasilPengerjaan' => $arrPengerjaan,
            'Absensi' => $arrAbsensi,
        ];
    } else {
        $data = ['status' => "failed", 'message' => 'Detail Task gagal didapatkan.'];
    }



    echo json_encode($data);
    ## Close connection
    mysqli_close($con);
} catch (Exception $ex) {
    echo 'Error: ' . $ex->getMessage();
}
?>