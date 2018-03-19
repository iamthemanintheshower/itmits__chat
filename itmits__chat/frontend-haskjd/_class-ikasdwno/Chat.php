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

class Chat {
    public function setChat($wpdb, $chat_session, $message, $is_user_logged_in){
        if($is_user_logged_in){
            $id_senderuser = 1;
            $id_receiveruser = 2;
        }else{
            $id_senderuser = 2;
            $id_receiveruser = 1;
        }

        $wpdb->insert('_chat-Edfg8', array(
            'chatsession' => $chat_session,
            'id_senderuser' => $id_senderuser,
            'id_receiveruser' => $id_receiveruser,
            'message' => $message
        ));
        return $wpdb->insert_id;
    }
    
    public function getChat($wpdb, $chat_session, $is_user_logged_in){
        $response = array();

        if($is_user_logged_in){
            $id_senderuser = 2;
            $id_receiveruser = 1;
        }else{
            $id_senderuser = 1;
            $id_receiveruser = 2;
        }

        $get_results = 
            $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT * FROM `_chat-Edfg8` WHERE chatsession = %s AND id_senderuser = %d AND received = 0", 
                    $chat_session,
                    $id_senderuser
                )
            );
        if ($get_results){
            foreach($get_results as $row){
                $chatbean = new ChatBean();
                $chatbean->setChatsession($row->chatsession);
                $chatbean->setId_receiveruser($row->id_receiveruser);
                $chatbean->setId_senderuser($row->id_senderuser);
                $chatbean->setMessage($row->message);
                $chatbean->setMoment($row->moment);

                $response[] = $chatbean;
                $this->_markAsRead($wpdb, $row->id_chat);
            }
        }
        return $response;
    }

    private function _markAsRead($wpdb, $id_chat){
        //# Reference: https://developer.wordpress.org/reference/classes/wpdb/update/
        $_markAsRead = $wpdb->update(
                '_chat-Edfg8', array(
                'received' => 1
            ), array(
                'id_chat' => $id_chat
            )
        );
        return $_markAsRead;
    }

    public function getChatSessions($wpdb, $is_user_logged_in){
        $response = array();

        if($is_user_logged_in){
            $get_results = 
                $wpdb->get_results("SELECT * FROM `_chat-Edfg8` ORDER by id_chat DESC");

            if ($get_results){
                foreach($get_results as $row){
                    $chatbean = new ChatBean();
                    $chatbean->setChatsession($row->chatsession);
                    $chatbean->setId_receiveruser($row->id_receiveruser);
                    $chatbean->setId_senderuser($row->id_senderuser);
                    $chatbean->setMoment($row->moment);

                    $response[] = $chatbean;
                }
            }
        }
        return $response;
    }
    
}