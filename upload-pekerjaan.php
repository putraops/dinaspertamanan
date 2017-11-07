<?php
    try {
        require_once('connection.php');
        $data = [];
        
        $taskiddetail = $con->real_escape_string($_REQUEST["taskiddetail"]);
        $userid = $con->real_escape_string($_REQUEST["userid"]);
        $tipe = $con->real_escape_string($_REQUEST["tipe"]); 
        
        $target_dir = "uploads/";
        
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $ext = "." . pathinfo($_FILES["filename"]["name"], PATHINFO_EXTENSION);;
        
        // Set autocommit to off
        mysqli_autocommit($con, FALSE);

        
        ## INSERT PEKERJAAN
        $sql = " INSERT INTO pengerjaan (taskiddetail, ext, tipe, created_at, updated_at)
                VALUES ('$taskiddetail', '$ext', '$tipe', now(), now())";
        
        
        if(mysqli_query($con, $sql)) {
            $last_id = $con->insert_id;
            $target_file_name = $target_dir . $last_id . $ext ;
            if (isset($_FILES["filename"])) 
            {
                //if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file_name)) 
                if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file_name)) 
                {
                    // Commit transaction
                    mysqli_commit($con);
                    $data = ['status' => "Succeeded", 'message' => 'Pengeluaran berhasil ditambahkan.'];
                } else {
                    mysqli_rollback($con);
                    $data = ['status' => "failed", 'message' => 'Gagal upload foto.'];
                }
            }
        } else {
            // Rollback transaction
            mysqli_rollback($con);
            $data = ['status' => "failed", 'message' => 'Pengeluaran gagal ditambahkan.'];
        }
        
        echo json_encode($data);
        // Close connection
        mysqli_close($con);
        
    } catch (Exception $ex) {
        echo 'Error: ' . $ex->getMessage();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
?>