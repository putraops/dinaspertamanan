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
    //if (isset($_REQUEST["idsalesmanager"])) {
    //    $idsalesmanager = $con->real_escape_string($_REQUEST["idsalesmanager"]);
    //}
    if (isset($_REQUEST["status"])) {
        $status = $con->real_escape_string($_REQUEST["status"]);
    }

    ## Array Declare
    $arrResult = array();
    $arrPekerja = array();
    $arrPengerjaan = array();
    $totalPekerja = 0;

    $sql  = "Select t.id as id, 
                    t.taskname as namatask,
                    t.createduser as createduser,
                    t.tanggaldibuat as tanggaldibuat, 
                    t.statustask as statustask,  
                    u.nama as creatednameuser, 
                    u.id as createduserid 
            FROM task t";
    $sql .= " INNER JOIN user u ON t.createduser = u.id";
    $sql .= " WHERE t.id > 0 AND t.statustask != 'Closed'";
    //echo $sql;exit;
    if ($status != "") {
        $sql .= " AND t.statustask = '$status'";
    }
    if ($iduser != "") {
        $sql .= " AND td.userid = '$iduser'";
    }

    if ($id != "") {
        $sql .= " AND t.id = '$id'";
    }

    //echo $sql;exit;

    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $taskid = $row['id'];

            $data = [
                'id' => $taskid,
                'namatask' => $row['namatask'],
                'tanggaldibuat' => $row['tanggaldibuat'],
                'statustask' => $row['statustask'],
                'dibuatolehid' => $row['createduserid'],
                'dibuatoleh' => $row['creatednameuser'],
                //'totalpekerja' => $resulttotal->num_rows
            ];
            
            
            //$sqltotalpekerja = "SELECT * FROM task_detail WHERE taskid = '$taskid' ";

            //if ($iduser != "") {
            //   $sqltotalpekerja .= " AND userid = '$iduser'";
            //}

            //$resulttotal = $con->query($sqltotalpekerja);


            array_push($arrResult, $data);

            if ($id == "" || $id == 0) {
                
            } else if ($id > 0) {
                ## DETAIl PEKERJAAN
                $sql = "SELECT id, lokasi, latitude, longitude, statusdikerjakan 
                            FROM task_detail 
                            WHERE taskid = '$id'";
                $sql .= " ORDER BY id ASC;";

                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $data = [
                            'id' => $row['id'],
                            'idtask' => $id,
                            'lokasi' => $row['statusdikerjakan'],
                            'latitude' => $row['latitude'],
                            'longitude' => $row['longitude'],
                            'status' => $row['statusdikerjakan']
                        ];
                        array_push($arrPengerjaan, $data);
                        
                        ##
                        ## ambil list pekerjaan dalam detail task
                        ##
                        
//                        $listpengerjaan_query = "SELECT id, taskdetailid, ext, tipe, created_at FROM pengerjaan WHERE taskdetailid =".$row['id'];
//                       // $listpengerjaan_query = "UPDATE table SET commodity_quantity=".$qty."WHERE user=".$rows['user'];
//
//                        $result_pengerjaan = $subinner_connection->query($listpengerjaan_query);
//
//                        if ($result_pengerjaan->num_rows > 0) {
//                            while ($row_pengerjaan = $result_pengerjaan->fetch_assoc()) {
//                                $data = [
//                                    'id' => $row_pengerjaan['id'],
//                                    'taskdetailid' => $row_pengerjaan['taskdetailid'],
//                                    'fileupload' => $_SERVER['SERVER_NAME'] . "\\" . "uploads" . "\\" . $row_pengerjaan['id'] . $row_pengerjaan['ext'],
//                                    'tipe' => $row_pengerjaan['tipe'],
//                                    'waktuabsen' => $row_pengerjaan['created_at']
//                                ];
//                                array_push($arrPengerjaan, $data);
//                            }
//                        }
                        ## END of [ambil list pekerjaan dalam detail task]

                    }
                }
            }
        }

        $data = ['status' => "succeeded",
            'message' => 'Detail Task berhasil didapatkan.',
            'Data' => $arrResult,
            'Detail' => $arrPengerjaan
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