<?php
    try {
        require_once('connection.php');
        
        $id     = "";
        $oldpassword  = "";
        $newpassword = "";
        
        if (isset($_REQUEST["id"])) {
            $id = $con->real_escape_string($_REQUEST["id"]);
        } 
        if (isset($_REQUEST["oldpassword"])) {
            $oldpassword = $con->real_escape_string($_REQUEST["oldpassword"]);
        }   
        if (isset($_REQUEST["newpassword"])) {
            $newpassword = $con->real_escape_string($_REQUEST["newpassword"]);
        }   
        
        $oldpasswordMd5 = md5($oldpassword);
        $newPasswordMd5 = md5($newpassword);  
        
        $sql = "Select password 
                From user 
                where id = '$id' AND password = '$oldpasswordMd5';";
        $result = $con->query($sql); 
        
        if ($result->num_rows > 0) {
            ## update to database
            ## Kode login dari profile-navigation.php
            
            $sql = "UPDATE user 
                    SET password = '$newPasswordMd5', 
                    updated_at = now() 
                    where id = '$id'";
            
            if(mysqli_query($con, $sql)) {
                ## Commit transaction
                mysqli_commit($con);
                $data = ['status' => "succeeded", 'message' => 'Berhasil ubah password user.'];
            } else {
                ## Rollback transaction
                mysqli_rollback($con);
                $data = ['status' => "failed", 'message' => 'Gagal ubah password user.'];
            }
            
            echo json_encode($data);
            
        } else {
            $data = ['status' => "failed", 'message' => 'Password yang dimasukkan salah.'];
            echo json_encode($data);
        }
      
        ## Close connection
        mysqli_close($con);
    } catch (Exception $ex) {
        echo 'Error: ' . $ex->getMessage();
    }
?>