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

function admin_itmits__wp_admin_panel_demo_frontend_inline_js(){
    global $chat_plugin_dir_url;
    $token = md5(uniqid(rand(), TRUE));
    echo "<script type='text/javascript'>".PHP_EOL;
        echo 'var chatpluginUrl = "' . $chat_plugin_dir_url . '";'.PHP_EOL;
        echo 'var token = "'.$token.'";';
    echo "</script>";
}


function add_chat() {?>
    <div class="chat_box">
        <div class="chat_box_container">
            <i id="chat_icon" class="fa fa-comment-o" aria-hidden="true"></i>
            <div id="chat_box_chat">

            </div>
            <div class="chat_box_text">
                <textarea id="chat_input"></textarea>
            </div>
        </div>    
    </div>
<?php
}