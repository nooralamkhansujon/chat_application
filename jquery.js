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