<?php 
//index.php 

 include("database_connection.php");
 session_start();

 if(isset($_SESSION['user_id']))
 {
     header('Location: index.php');
 }

  $message ='';
 
  if(isset($_POST['register']))
  {
       $username = trim($_POST['username']);
       $password = trim($_POST['password']);  

       $check_query  = "SELECT * FROM  `login` WHERE username=:username ";
       $statement = $connect->prepare($check_query);

       $check_data = array(
           ':username' => $username
       );

       if($statement->execute($check_data))
       {
            if($statement->rowCount() > 0 )
            {
                $message .= '<p><label>Username already taken
                </label></p>';
            }
            else{
                
                if(empty($username)){
                    $message .='<p><label>Username is required
                    </label></p>';
                }
                if(empty($password))
                {
                    $message .='<p><label>Password is required
                    </label></p>';
                }
                else{
                  
                    if($password != $_POST['confirm_password'])
                    {
                        $message .='<p><label>Password not match</label></p>';
                    }

                }

                if($message == '')
                {
                    $data = array(
                        ':username' => $username,
                        ":password" => md5($password)
                    );

                    $query ="INSERT INTO `login` (username,`password`) VALUES (:username,:password)";
                    $statement = $connect->prepare($query);

                    if($statement->execute($data))
                    {
                        $message ="<label>Registration Completed</label>";
                    }
                }
            }
       }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />

    <script src="https://code.jquery.com/jquery-1.12.4.js">
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js">
    </script>


</head>
<body>
       <div class="container">
           <br/>
           <h3 align="center">Chat Application using PHP Ajax Jquery</h3><br/>
           <br />
          <div class="panel panel-default">
              <?php if($message != ''){   ?>
                 <div class="alert alert-danger">
                     <?php echo $message; ?>
                 </div>
              <?php } ?>  
                 <div class="panel-heading">Chat Application Register</div>
                 <form action="" method="POST">
                    <div class="panel-body">
                        <div class="form-group">
                        <label>Enter Username</label>
                        <input type="text" name="username" class="form-control" />
                        </div>
                        <div class="form-group">
                        <label>Enter Password</label>
                            <input type="password" name="password" class="form-control" />
                        </div>
                        <div class="form-group">
                        <label>Re-enter Password</label>
                            <input type="password" name="confirm_password" class="form-control" />
                        </div>
                        <div class="form-group">
                        <input type="submit" name="register" class="btn btn-info" value="Register">
                        </div>
                 </form>
                
                     <div align="center">
                        <a href="login.php">Login</a>
                     </div>
                 </div>
           </div>
       </div>
</body>
</html>
