<?php 

$connect = new PDO("mysql:host=localhost;dbname=chat_application;charset=utf8mb4",'root','');


function fetch_user_last_activity($user_id,$connect)
{
    $query = "SELECT * FROM login_details WHERE user_id='$user_id' ORDER BY  last_activity DESC LIMIT 1; ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach($result as $row)
    {
        return $row['last_activity'];
    }
}


function fetch_user_chat_history($from_user_id,$to_user_id,$connect){

    $query = "Select * FROM chat_message WHERE  (from_user_id='".$from_user_id."' AND to_user_id='".$to_user_id."') OR (from_user_id='".$to_user_id."' AND to_user_id='".$from_user_id."')  ORDER BY timestamp DESC;";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    $output = "<ul class='list-unstyled'>";
    foreach($result as $row)
    {
        $user_name = ''; 
        $dyname_background ='';
        $chat_message = '';

        // if the user is login user then 
        if($row['from_user_id'] == $from_user_id)
        {   
            /// if the status of chat message 2 then
            if($row['status'] == '2')
            {
                $chat_message = "<em>This message has been removed</em>";
                $user_name = '<b class="text-success">You</b>';
            }

            // else show the message 
            else{
                 $chat_message = $row['chat_message'];
                 $user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="'.$row['chat_message_id'].'" >x</button>
                 &nbsp;<b class="text-success">You</b>';
            }
           
            $dyname_background = 'background-color:#ffe6e6';
        }

        //if the user is not a login user then
        else{  

            if($row['status'] == '2')
            {
                $chat_message = '<em>This message has been removed</em>';
              
            }
            else{
                $chat_message = $row['chat_message'];
            }
            $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'],$connect).'</b>';
            $dyname_background = 'background-color:#ffffe6';
        }

        $output .= '<li style="border-bottom:1px solid dotted #ccc;padding:8px 8px 0 8px;'.$dyname_background.'"> <p>'.$user_name.' - '.$chat_message.'
          <div align="right">
              - <small><em>'.$row['timestamp'].'</em></small>
          </div></p></li>';
    }
    $output .='</ul>';
    return $output;
}

function get_user_name($user_id,$connect)
{
    $query = "SELECT username FROM `login` WHERE `user_id`='$user_id' ";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    foreach($result as $row)
    {
        return $row['username'];
    }
}

function count_unseen_message($from_user_id,$to_user_id,$connect)
{
    $query = "SELECT * FROM chat_message
     WHERE  from_user_id='$from_user_id' AND  to_user_id='$to_user_id' AND `status`= 1";

     $statement = $connect->prepare($query);
     $statement->execute();
     $count =$statement->rowCount();
     $output ='';
     if($count > 0)
     {
         $output = '<span class="label label-success">
          '.$count.'</span>';
     }
     return $output;

}



function fetch_is_type_status($user_id,$connect)
{
    $query = "SELECT * FROM login_details 
          WHERE  `user_id` = '".$user_id."' ORDER BY   last_activity DESC LIMIT 1 ";

     $statement = $connect->prepare($query);
     $statement->execute();
     $result = $statement->fetchAll();   
     $output ='';
     foreach($result as $row){

         if($row['is_type']  == 'yes'){
              $output = '- <small><em><span class="text-success">Typing...</span></em>
              </small>';
         }
     }
     return $output;
}

function fetch_group_chat_history($connect){
      
       $query = "SELECT * FROM  chat_message WHERE to_user_id='0' ORDER BY  `timestamp` DESC";

       $statement = $connect->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       $output = '<ul class="list-unstyled">';

       foreach($result as $row)
       {
           $user_name = '';
           $dyname_background = '';
           $chat_message = '';
           if($row['from_user_id'] == $_SESSION['user_id'])
           {
                if($row['status'] == '2')
                {
                    $chat_message = "<em>This message has been removed</em>";
                    $user_name = '<b class="text-success">You</b>';
                }
                else{
                    
                    $chat_message = $row['chat_message'];
                    $user_name = '<button type="button" class="btn btn-danger btn-xs remove_chat" id="'.$row['chat_message_id'].'" >x</button>
                    &nbsp;<b class="text-success">You</b>';
                }
                $dyname_background = 'background-color:#ffe6e6;';

           }
           else{

               if($row['status'] == '2')
               {
                  $chat_message = "<em>This message has been removed</em>";
                
               }
               else{
                    $chat_message = $row['chat_message'];
               }
               $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'],$connect).'</b>';
               $dyname_background = 'background-color:#ffffe6;';
           }
           $output .="<li style='border-bottom:1px dotted #ccc;padding:8px 8px 0 8px;".$dyname_background."'>
             <p>".$user_name." - ".$chat_message."
             <div align='right'>
                 - <small>
                      <em>".$row['timestamp']."</em>
                   </small>
              </div>
             </p>
           </li>";
       }
       $output .='</ul>';
       return $output;
}



?>