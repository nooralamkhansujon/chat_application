<?php 

include("database_connection.php");
session_start();
if(isset($_POST['to_user_id']))
{
   $to_user_id   = $_POST['to_user_id'];
   $from_user_id = $_SESSION['user_id'];

   $query   = "UPDATE chat_message 
   SET  `status`='0'
   WHERE  from_user_id = '".$to_user_id."' 
   AND    to_user_id   = '".$from_user_id."' "; 
   $statement = $connect->prepare($query);
   $statement->execute();

}
   
?>