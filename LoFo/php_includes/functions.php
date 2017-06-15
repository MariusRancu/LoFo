<?php
include_once("db_con.php");

function filter_tags($tag){
    if(strlen($tag) > 1 && ($tag !="sau" || $tag != "cum" || $tag != "pai" || $tag !="sunt" || $tag !="in" || $tag !="pe"))
        return true;
    else
        return false;    
}

function sanitize_tag($tag){
    return strtolower(preg_replace("/[^A-Za-z0-9 ]/", '', $tag));
}

function upload_file($file_basename, $file_ext, $allowed_file_types, $filesize){
    if (in_array($file_ext, $allowed_file_types) && ($filesize < 200000000))
	        {	
                // Rename file
                $newfilename = md5($file_basename) . $file_ext;
                if (file_exists("upload/" . $newfilename))
                {
                    // file already exists error
                    echo "You have already uploaded this file.";
                }
                else
                {		
                    move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $newfilename);
                    echo "File uploaded successfully.";
                    //$null = NULL;
                    $picture_location = "upload/" . $newfilename;
                    $sql3 = mysqli_prepare($db_con, "INSERT INTO objects (`username`, `category`, `obj_name`, `producer`, `model`, `color`, `location`, `data`, `picture_location`) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    mysqli_stmt_bind_param($sql3, 'sssssssss', $username, $category, $name, $producer, $model, $color, $location, $date, $picture_location);
                    
                    mysqli_stmt_execute($sql3);

                    //$objId = $sql3->insert_id;

                    mysqli_stmt_close($sql3);

                    /*$sql1 = mysqli_prepare($db_con, "UPDATE objects SET `picture`=? WHERE id=?");
                    mysqli_stmt_bind_param($sql1, 'bi', $null, $objId);
                    $sql1->send_long_data(0, file_get_contents("upload/" . $newfilename));

                    mysqli_stmt_execute($sql1);
                    mysqli_stmt_close($sql1);*/


                }
            }
            elseif ($filesize > 2000000)
            {	
                // file size error
                echo "The file you are trying to upload is too large.";
            }
            else
            {
                // file type error
                echo "Only these file types are allowed for upload: " . implode(', ',$allowed_file_types);
                unlink($_FILES["file"]["tmp_name"]);
            } 
}
?>