<?php 
//upload.php 

if(!empty($_FILES))
{
     if(is_uploaded_file($_FILES['uploadFile']['tmp_name']))
     {
        $source      = $_FILES['uploadFile']['tmp_name'];
        $target_path = 'upload/'.$_FILES['uploadFile']['name'];

        if(move_uploaded_file($source,$target_path))
        {
            echo '<p>
                 <img src="'.$target_path.'" class="img-thumbnail" width="200" height="160" /></p> <br />';
        }
     }
}

?>