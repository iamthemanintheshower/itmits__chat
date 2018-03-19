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

class ChatBean {
    private $id_chat = 0;
    private $chatsession = '';
    private $id_senderuser = 0;
    private $id_receiveruser = 0;
    private $received = 0;
    private $message = '';
    private $moment = '';
    
    public function getId_chat(){
        return $this->id_chat;
    }

    public function setId_chat($id_chat){
        $this->id_chat = $id_chat;
    }

    public function getChatsession(){
        return $this->chatsession;
    }

    public function setChatsession($chatsession){
        $this->chatsession = $chatsession;
    }

    public function getId_senderuser(){
        return $this->id_senderuser;
    }

    public function setId_senderuser($id_senderuser){
        $this->id_senderuser = $id_senderuser;
    }

    public function getId_receiveruser(){
        return $this->id_receiveruser;
    }

    public function setId_receiveruser($id_receiveruser){
        $this->id_receiveruser = $id_receiveruser;
    }

    public function getReceived(){
        return $this->received;
    }

    public function setReceived($received){
        $this->received = $received;
    }

    public function getMessage(){
        return $this->message;
    }

    public function setMessage($message){
        $this->message = $message;
    }

    public function getMoment(){
        return $this->moment;
    }

    public function setMoment($moment){
        $this->moment = $moment;
    }    
}
