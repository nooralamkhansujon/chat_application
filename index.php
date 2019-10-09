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

<script>
  $(document).ready(function(){
       fetch_user();
       setInterval(() => {
          update_last_activity();
          fetch_user();
          update_chat_history_data();
          fetch_group_chat_history();
       },5000);

      function fetch_user(){
            
            $.ajax({
                url    : "fetch_user.php",
                success:function(data){
                    $("#user_details").html(data);
                }
            })
      }
      function update_last_activity(){

          $.ajax({
              url    :"update_last_activity.php",
              success:function(data){}
          });
      }

      function make_chat_dialog_box(to_user_id,to_user_name)
      {
          let modal_content = `<div id="user_dialog_${to_user_id}" class="user_dialog" title="You have chat with ${to_user_name}">`;

          modal_content +=`<div style="height:400px;border:1px solid #ccc; overflow-y:scroll;margin-bottom:24px;padding:16px;" class="chat_history" data-touserid="${to_user_id}" id="chat_history_${to_user_id}">`;
          
          modal_content += fetch_user_chat_history(to_user_id);
          modal_content +=`</div>`;
          modal_content +=`<div class="form-group">`;
          modal_content +=`<textarea name="chat_message_${to_user_id}" id="chat_message_${to_user_id}" class="form-control chat_message"></textarea>`;
          modal_content +=`</div><div class="form-group" align="right">`;
          modal_content +=`<button type="button" name="send_chat" id="${to_user_id}" class="btn btn-info send_chat">Send</button></div></div>`;
          $('#user_modal_details').html(modal_content);

      }
      $(document).on('click','.start_chat',function(){
           
            let to_user_id = $(this).data('touserid');
            let to_user_name = $(this).data('tousername');
            
            //makedialog box 
            make_chat_dialog_box(to_user_id,to_user_name);

            //this is will update chat_status
            upate_chat_notification(to_user_id);

            $("#user_dialog_"+to_user_id).dialog({
                autoOpen:false,
                width:400
            });
            $("#user_dialog_"+to_user_id).dialog('open');
            $(`#chat_message_${to_user_id}`).emojioneArea({
                pickerPosition: "top",
                tonesStyle    : "bullet"
            });
      });
      
      $(document).on('click','.send_chat',function(){
            
             let to_user_id   = $(this).attr('id');
             let chat_message = $('#chat_message_'+to_user_id)
             .val();
           
             $.ajax({
                 url    : 
                 "insert_chat.php",
                 method : "POST",
                 data   : {to_user_id:to_user_id,chat_message:chat_message},
                 success:function(data){
                    //  $("#chat_message_"+to_user_id).val(''); 
                     let element =$("#chat_message_"+to_user_id).emojioneArea();
                     element[0].emojioneArea.setText('');
                     $(`#chat_history_${to_user_id}`).html(data);
                 }
             });
      });

      function fetch_user_chat_history(to_user_id)
      {
          $.ajax({
              url    : "fetch_user_chat_history.php",
              method : "POST",
              data   : {to_user_id:to_user_id},
              success:function(data){
                $(`#chat_history_${to_user_id}`).html(data);
              }

          });
      }

      function update_chat_history_data(){

            $('.chat_history').each(function(){
                  let to_user_id = $(this).data('touserid');
                  fetch_user_chat_history(to_user_id);

            });
      }

      function upate_chat_notification(to_user_id)
      {
          $.ajax({
              url    : "update_chat_status.php",
              method : "POST",
              data   : {to_user_id:to_user_id},
              success: function(data){}
          });

      }

     $(document).on('click','.ui-button-icon',function(){
         $(".user_dialog").dialog('destroy').remove();
     });

     $(document).on('focus','.chat_message',function(){
            let is_type = 'yes';

            $.ajax({
                url    : "update_is_type_status.php",
                method : "POST",
                data   :{is_type:is_type},
                success:function(data){

                }
            });
     });

     $(document).on('blur','.chat_message',function(){
            let is_type = 'no';
            $.ajax({
                url    : "update_is_type_status.php",
                method : "POST",
                data   : {is_type:is_type},
                success:function(data){

                }
            });
    });

      $("#group_chat_dialog").dialog({
          autoOpen:false,
          width:400
      });   
      $("#group_chat").click(function(){
            $("#group_chat_dialog").dialog('open');
            $("#is_active_group_chat_window").val('yes');
            fetch_group_chat_history();
      });

      $('#send_group_chat').click(function(){
           
          let chat_message = $("#group_chat_message").html();
          let action       = 'insert_data';
          if(chat_message  !='')
          {
              $.ajax({
                  url    : "group_chat.php",
                  method : "POST",
                  data   : {chat_message:chat_message,action :action},
                  success:function(data){
                    $("#group_chat_message").html('');
                    $("#group_chat_history").html(data);
                  }
              })
          }
      });

      function fetch_group_chat_history()
      {
          let group_chat_dialog_active = $("#is_active_group_chat_window").val();
          let action = 'fetch_data';

          if(group_chat_dialog_active == 'yes')
          {
              $.ajax({
                  url    : "group_chat.php",
                  method : "POST",
                  data   : {action:action},
                  success:function(data){
                    $("#group_chat_history").html(data);  
                  }
              });
          }
      }

      $("#uploadFile").on('change',function(){
            
           $("#uploadImage").ajaxSubmit({
                target    : "#group_chat_message",
                resetForm : true
           });
      });

      $(document).on('click','.remove_chat',function(){
            let chat_message_id = $(this).attr('id');
            if(confirm('Are You sure you want to remove this chat?'))
            {
                $.ajax({
                    url      : "remove_chat.php",
                    method   : "POST",
                    data     : {chat_message_id:chat_message_id},
                    success  : function(data){
                        update_chat_history_data();
                    }
                })
            }
      });

  });
</script>