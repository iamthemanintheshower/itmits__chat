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

var timestamp = Math.floor((new Date).getTime()/1000);
var msg_count = 0;

jQuery(document).ready(function () {
    'use strict';

    window.setInterval(function(){
        getChat('chat-get', msg_count);
    }, 10000);
    
    jQuery('#chat_input').focus();
    
    jQuery(document).on("keypress", "#chat_input", function(e) {
         if (e.which == 13) {
             if(jQuery('#chat_input').val() !== ''){
                jQuery('#chat_box_chat').html( jQuery('#chat_box_chat').html() + '<div class="sentence your_sentence">' + jQuery('#chat_input').val() + '</div>');
                sendChat('chat-set', jQuery('#chat_input').val());
                jQuery('#chat_input').val('');
                jQuery('#chat_icon').hide('fade');
                jQuery("#chat_box_chat").animate({ scrollTop: 1000 }, 'normal');
            }
             return false;
         }
    });
});


function sendChat(key, message){
    var values = {
        key: key ,
        token: token, message: message, id_receiveruser:1
    };

    jQuery.post( chatpluginUrl + "frontend-haskjd/public_html/index.php", values)
    .done(function( data ) {
        console.log(data);
    })
    .fail(function( data ) {
        console.log( "FAIL: " );
        console.log( data );
    });
    return false;
}

function getChat(key, msg_count_p){
    var values = {
        key: key ,
        token: token, timestamp:timestamp
    };

    jQuery.post( chatpluginUrl + "frontend-haskjd/public_html/index.php", values)
    .done(function( data ) {
        console.log(data);
        if(msg_count_p === 0){
            jQuery('#chat_box_chat').html( '<div class="sentence other_sentence">Here I am, I\'m connected, ask me about what you are looking for!</div>'); 
            jQuery('#chat_icon').hide('fade');
            msg_count = msg_count + 1; 
        }
        if(data === 'no-chat'){ return false; }
        
        var chat_lines = data;
        jQuery.each(chat_lines, function( index, chat_line ) {
            if(chat_line !== '' && data !== 'no-chat'){
                if(chat_line.id_senderuser === 2){
                    jQuery('#chat_box_chat').html( jQuery('#chat_box_chat').html() + 
                    '<div class="sentence your_sentence">' + chat_line.message + '</div>');
                }else{
                    jQuery('#chat_box_chat').html( jQuery('#chat_box_chat').html() + 
                    '<div class="sentence other_sentence">' + chat_line.message + '</div>');
                }
                jQuery('#chat_icon').hide('fade');
                jQuery("#chat_box_chat").animate({ scrollTop: 1000 }, 'normal');
            }
            
        });
    })
    .fail(function( data ) {
        console.log( "FAIL: " );
        console.log( data );
    });
    return false;
}