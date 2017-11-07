<?php
    try {
        require_once('connection.php');
        
        $username   = $con->real_escape_string($_REQUEST["username"]);
        $password   = $con->real_escape_string($_REQUEST["password"]);
        
        $hashpassword = md5($password);

        $arrResult = array(); 
        
        $sql = "Select u.id as id, u.username as username, u.nama as namauser, u.telepon as telepon, j.id as kodejabatan, j.nama as namajabatan, u.is_active as status
                from user u
                INNER JOIN jabatan j ON j.id = u.id_jabatan 
                where lower(username) = lower('$username') AND password = '$hashpassword';";
        
        $result = $con->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['status'] == 1) {
                    $data = [
                            'id' => $row['id'], 
                            'username' => $row['username'],
                            'namauser' => $row['namauser'],
                            'telepon' => $row['telepon'],
                            'kodejabatan' => $row['kodejabatan'],
                            'namajabatan' => $row['namajabatan'],
                            'status' => $row['status'],
                            ];
                    array_push($arrResult, $data);

                    $data = ['status' => "succeeded", 'message' => 'Login berhasil', 'Data' => $arrResult];
                } else {
                    $data = ['status' => "notactive", 'message' => 'User belum aktif'];
                }
            }
        } else {
            $data = ['status' => "failed", 'message' => 'username atau password salah'];
        }
        


        echo json_encode($data);
        ## Close connection
        mysqli_close($con);
        
    } catch (Exception $ex) {
        echo 'Error: ' . $ex->getMessage();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
?>