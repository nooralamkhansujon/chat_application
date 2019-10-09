<?php 
//index.php 

 include("database_connection.php");
 session_start();

 if(!isset($_SESSION['user_id']))
 {
     header('location: login.php');
 }


echo date('Y-m-d H:i:s');

 
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

    <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css" />
     

    <script src="https://code.jquery.com/jquery-1.12.4.js">
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>

    <style>
       .chat_message_area{
             position: relative;
             width   : 100%;
             height  : auto;
             background-color:#fff;
             border  :1px solid #ccc;
             border-radius:3px;
       }
       #group_chat_message{
           width:100%;
           height:auto;
           min-height:80px;
           overflow:auto;
           padding:6px 24px 6px 12px;
       }
       .image_upload{
           position:absolute;
           top:3px;
           right:3px;
       }
       .image_upload > form > input{
           display:none;
       }
       .image_upload img{
           width:24px;
           cursor:pointer;
       }
    </style>

</head>
<body>
       <div class="container">
           <br/>
           <h3 align="center">Chat Application using PHP Ajax Jquery</h3><br/>
           <br />
           <div class="row">
             <div class="col-md-8 col-sm-6">
                <h4 align="center">Online user</h4>
             </div>
             <div class="col-md-2 col-sm-3">
               <input type="hidden" id="is_active_group_chat_window" value="no" />
               <button type="button" name="group_chat" id="group_chat" class="btn btn-warning btn-xs">Group Chat</button>
             </div>

             <div class="col-md-2 col-sm-3">
               <p align="right">Hi - <?php echo $_SESSION['username']; ?> - 
                <a href="logout.php">Logout</a>
                </p>
             </div>
           
           </div>
           <div class="table-responsive">
               <div id="user_details"></div>
               <div id="user_modal_details"></div>
           </div>
       </div>
</body>
</html>


<div id="group_chat_dialog" title="Group Chat Window">
          
       <div id="group_chat_history" style="height:400px;border:1px solid #ccc;overflow-y:scroll;margin-bottom:24px;padding:16px;">
       
       </div>  
       <div class="form-group">
          <!-- <textarea name="group_chat_message" id="group_chat_message" class="form-control">
          </textarea> -->
        <div class="chat_message_area">
             <div id="group_chat_message" contenteditable class="form-control">
             </div>
             <div class="image_upload">
                 <form action="upload.php" method="POST" id="uploadImage" enctype="multipart/form-data">
                    <label for="uploadFile"> 
                       <img src="default.png"  /> 
                    </label>
                    <input type="file" name="uploadFile" id="uploadFile" accept=".jpg,.png" />
                 </form>
             </div>
        </div>

       </div> 
       <div class="form-group">
         <button type="button" class="btn btn-success" name="send_group_chat" id="send_group_chat">
         Send
         </button>
       </div> 
</div>

<script src="jquery.js"></script>