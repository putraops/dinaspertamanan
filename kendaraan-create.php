<?php
    try {
        require_once('connection.php');

        $userid = $con->real_escape_string($_REQUEST["penanggungjawabuserid"]);
        $nama = $con->real_escape_string($_REQUEST["nama"]);
        $no_polisi = $con->real_escape_string($_REQUEST["no_polisi"]);

        // Set autocommit to off
        mysqli_autocommit($con, FALSE);

        $sql = "INSERT INTO kendaraan (penanggungjawabuserid, nama, no_polisi, created_at, updated_at)
                VALUES ('$userid', '$nama', '$no_polisi', now(), now())";
        
        if(mysqli_query($con, $sql)) {
            // Commit transaction
            
            mysqli_commit($con);
            $data = ['status' => "succeeded", 'message' => 'Kendaraan baru berhasil dibuat.'];
        } else {
            // Rollback transaction
            mysqli_rollback($con);
            $data = ['status' => "failed", 'message' => 'Kendaraan baru gagal dibuat.'];
        }
        

        echo json_encode($data);
        // Close connection
        mysqli_close($con);
        
    } catch (Exception $ex) {
        echo 'Error: ' . $ex->getMessage();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
?>