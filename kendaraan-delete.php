<?php
    try {
        require_once('connection.php');

        $id = "";
        
        if (isset($_REQUEST["id"])) {
            $id = $con->real_escape_string($_REQUEST["id"]);
        }  
        
        // Set autocommit to off
        mysqli_autocommit($con, FALSE);

        $sql  = "UPDATE kendaraan ";
	$sql .= "SET updated_at = now(), isDelete = 1 ";
        $sql .= "WHERE ID = '$id'";
        
        if(mysqli_query($con, $sql)) {
            ## Commit transaction
            mysqli_commit($con);
            $data = ['status' => "succeeded", 'message' => 'Berhasil hapus data kendaraan.'];
        } else {
            ## Rollback transaction
            mysqli_rollback($con);
            $data = ['status' => "failed", 'message' => 'Gagal hapus data kendaraan.'];
        }
        

        echo json_encode($data);
        // Close connection
        mysqli_close($con);
        
    } catch (Exception $ex) {
        echo 'Error: ' . $ex->getMessage();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
?>