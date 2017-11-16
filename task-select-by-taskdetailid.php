<?php

try {
    require_once('connection.php');

    $id = "";

    if (isset($_REQUEST["id"])) {
        $id = $con->real_escape_string($_REQUEST["id"]);
    }
    ## Array Declare
    $arrPengerjaan = array();
    $arrAbsensi = array();
    $totalPekerja = 0;
    
    if ($id > 0) {
        ## Ambil data pengerjaan
        $sql = "SELECT  p.id as pengerjaan_id,
                        p.taskdetailid as pengerjaan_taskdetailid,
                        p.filename as pengerjaan_filename,
                        p.latitude as pengerjaan_latitude, 
                        p.longitude as pengerjaan_longitude, 
                        p.lokasi as pengerjaanlokasi,
                        p.created_at as pengerjaan_created_at,
                        p.updated_at as pengerjaan_updated_at,
                        u.id as sopir_id,
                        u.nama as sopir_nama,
                        k.nama as kendaraan_nama
                FROM pengerjaan p
                INNER JOIN task_detail td ON p.taskdetailid = td.id
                INNER JOIN user u ON u.id = p.userid 
                INNER JOIN taskkendaraan tk ON tk.userid = u.id
                INNER JOIN kendaraan k ON k.id = tk.kendaraanid
                WHERE td.id = '$id'";
        //$sql .= " ORDER BY tipe ASC;";

        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data = [
                    'pengerjaan_id' => $row['pengerjaan_id'],
                    'pengerjaan_taskdetailid' => $row['pengerjaan_taskdetailid'],
                    'pengerjaan_filename' => $_SERVER['SERVER_NAME'] . "\\" . "uploads" . "\\" . $row['pengerjaan_filename'],
                    'pengerjaan_latitude' => $row['pengerjaan_latitude'],
                    'pengerjaan_longitude' => $row['pengerjaan_longitude'],
                    'pengerjaanlokasi' => $row['pengerjaanlokasi'],
                    'pengerjaan_created_at' => $row['pengerjaan_created_at'],
                    'pengerjaan_updated_at' => $row['pengerjaan_updated_at'],
                    'sopir_id' => $row['sopir_id'],
                    'sopir_nama' => $row['sopir_nama'],
                    'kendaraan_nama' => $row['kendaraan_nama'],
                ];
                array_push($arrPengerjaan, $data);
            }
            
            $data = ['status' => "succeeded",
                'message' => 'Detail Task berhasil didapatkan.',
                'HasilPengerjaan' => $arrPengerjaan,
            ];
        } else {
            $data = ['status' => "failed", 'message' => 'Detail Task gagal didapatkan.'];
        }
    }

    echo json_encode($data);
    ## Close connection
    mysqli_close($con);
} catch (Exception $ex) {
    echo 'Error: ' . $ex->getMessage();
}
?>