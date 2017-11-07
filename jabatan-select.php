<?php
    try {
        require_once('connection.php');
        
        $arrResult = array(); 
        
        $sql = "select id, nama from jabatan where nama != 'super_admin' OR nama != 'admin'";

        $result = $con->query($sql);

        if (!$result) {
        $data = ['status' => -1, 'message' => 'Data yang anda cari tidak ada'];
        } else {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data = ['id' => $row['id'], 'nama' => $row['nama']];
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