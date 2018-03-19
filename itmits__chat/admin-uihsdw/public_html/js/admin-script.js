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

var chat_session = '';

jQuery(document).ready(function () {
    jQuery('body').on('click', '.chatwith', function () {
        console.log('chatwith');
        jQuery('#chat_box_chat').html('');
        jQuery('#chat_input').val('');
        console.log(jQuery(this).data('chatsession'));
        chat_session = jQuery(this).data('chatsession');
        getChatByAdmin('chat-get-by-chatsession');
    });
});

function getChatByAdmin(key){
    token = chat_session;
    var values = {
        key: key ,
        token: "assistance-4e9f3fb0dfc46418a3c1b236b7bd4d94", chat_session:chat_session, timestamp:timestamp
    };

    jQuery.post( chatpluginUrl + "frontend-haskjd/public_html/index.php", values)
    .done(function( data ) {
        if(data === 'no-chat'){
            console.log('oknochat');
            return false;
        }

        var chat_lines = data;
        console.log('chat_lines');
        console.log(chat_lines);
        
        jQuery.each(chat_lines, function( index, chat_line ) {
            console.log('chat_line');
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
    .fail(function(data) {
        console.log( "error" );
        console.log(data.responseText);
    });
}
