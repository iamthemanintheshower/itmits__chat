<?php
/*
MIT License

Copyright 2018 https://github.com/iamthemanintheshower - imthemanintheshower@gmail.com

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

require realpath(__DIR__ . '/../../../../../wp-load.php');

$is_user_logged_in = is_user_logged_in();

if(isset($_POST) && is_array($_POST) 
    && isset($_POST['token'])){

    $post = $_POST;
    $post_key = $post['key'];
    $post_token = $post['token'];

    $date = new DateTime();
    $chat = new Chat();
    switch ($post_key) {
        case 'chat-get':
            $chatbeans = $chat->getChat($wpdb, getChatSession($post_token, $is_user_logged_in), $is_user_logged_in);
            if(is_array($chatbeans)){
                foreach ($chatbeans as $cb){
                    $json_response[] = array(
                        'chatsession' => $cb->getChatsession(),
                        'id_senderuser' => $cb->getId_senderuser(),
                        'id_receiveruser' => $cb->getId_receiveruser(),
                        'message' => $cb->getMessage(),
                        'moment' => $cb->getMoment()
                    );
                }
            } else {
                $json_response = 'no-chat';
            }
            echo response($json_response);
            break;

        case 'chat-set':
            if($post['message'] !== ''){
                $message = $post['message'];
                $chat_session = getChatSession($post_token, $is_user_logged_in);
                $chat->setChat($wpdb, $chat_session, $message, $is_user_logged_in);
            }
            response('chat');
            break;

        case 'chat-get-by-chatsession':
            $chat_session = $post['chat_session'];
            $chatbeans = $chat->getChat($wpdb, getChatSession($chat_session, $is_user_logged_in), $is_user_logged_in);
            if(is_array($chatbeans)){
                foreach ($chatbeans as $cb){
                    $json_response[] = array(
                        'chatsession' => $cb->getChatsession(),
                        'id_senderuser' => $cb->getId_senderuser(),
                        'id_receiveruser' => $cb->getId_receiveruser(),
                        'message' => $cb->getMessage(),
                        'moment' => $cb->getMoment()
                    );
                }
            } else {
                $json_response = 'no-chat';
            }
            echo response($json_response);
            break;

        default:
            break;
    }

}

function getChatSession($post_token, $is_user_logged_in){
    if($is_user_logged_in){
        if($post_token === 'assistance-4e9f3fb0dfc46418a3c1b236b7bd4d94'){
            return $post_token;
        }else{
            return false;
        }
    }else{
        return $post_token;
    }
}

//# FUNCTIONS
function response($response){
    header("Content-Type: application/json");
    if($response !== ''){
        echo json_encode($response);
    }
    die();
}