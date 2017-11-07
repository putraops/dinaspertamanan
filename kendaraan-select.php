<?php
    try {
        require_once('connection.php');
        
        $arrResult = array(); 
        
        $sql = "SELECT k.id as id,  k.nama as namakendaraan, k.no_polisi as nopolisi,
                       u.id as penanggungjawabid, u.nama as namapenanggungjawab 
                FROM kendaraan k
                INNER JOIN user u ON u.id = k.penanggungjawabuserid
                WHERE k.isdelete = 0;";

        $result = $con->query($sql);
        
       
        if (!$result) {
        $data = ['status' => -1, 'message' => 'Data yang anda cari tidak ada'];
        } else {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data = [
                            'id' => $row['id'], 
                            'namakendaraan' => $row['namakendaraan'],
                            'no_polisi' => $row['nopolisi'],
                            'penanggungjawabid' => $row['penanggungjawabid'],
                            'namapenanggungjawab' => $row['namapenanggungjawab']
                            ];
                    array_push($arrResult, $data);
                }
                $data = ['status' => 1, 'message' => 'succeeded','Data' => $arrResult];
            } else {
                $data = ['status' => -1, 'message' => 'Data yang anda cari tidak ada'];
            }
        }
        echo json_encode($data);
        ## Close connection
        mysqli_close($con);
        
    } catch (Exception $ex) {
        echo 'Error: ' . $ex->getMessage();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
?>