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

function admin_itmits__wp_admin_panel_demo__menu() {
    global $getAdminMenuPageBean;
    global $getAdminSubmenuPageBean;

    //# admin panel
    add_menu_page(
        $getAdminMenuPageBean->get_plugin_page_title(), $getAdminMenuPageBean->get_plugin_menu_title(),
        $getAdminMenuPageBean->get_plugin_page_capability(), $getAdminMenuPageBean->get_plugin_top_menu_slug(),
        $getAdminMenuPageBean->get_plugin_page_function(), $getAdminMenuPageBean->get_plugin_menu_icon(),
        $getAdminMenuPageBean->get_plugin_menu_position()
    );

    add_submenu_page(
        $getAdminMenuPageBean->get_plugin_top_menu_slug(),
        $getAdminSubmenuPageBean->get_plugin_page_title(), $getAdminSubmenuPageBean->get_plugin_menu_title(),
        $getAdminSubmenuPageBean->get_plugin_page_capability(), $getAdminSubmenuPageBean->get_plugin_menu_slug(),
        $getAdminSubmenuPageBean->get_plugin_page_function()
    );

    add_action( 'admin_init', 'admin_itmits__register_wp_admin_panel_demo' );
}

//# MENU
function admin_itmits__wp_admin_panel_demo__menu_page() {
    global $getAdminMenuPageBean;
    global $wpdb; ?>
    <div class="wrap">
        <h1>Chat sessions</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'wp_admin_panel_demo_group' ); ?>
            <?php do_settings_sections( 'wp_admin_panel_demo_group' ); ?>
            <table class="form-table">
                <?php
                $_get_admin_menu_page_fields = $getAdminMenuPageBean->get_admin_menu_page_fields();
                foreach ($_get_admin_menu_page_fields as $k=>$v){
                    $label_slug = $v['label_slug'];
                    $fields = $v['fields'];
                    ?>
                    <tr valign="top">
                        <th scope="row"><span><?php echo $k;?></span></th>
                        <td><?php echo $label_slug;?></td>
                    </tr>
                    <?php
                    foreach ($fields as $field_label => $args){?>
                        <tr valign="top">
                            <td scope="row">- <?php echo $field_label;?></td>
                            <td><?php echo _get_field($args);?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
    
            <?php submit_button(); ?>

            <table class="form-table chat-sessions-table">
                <thead>
                    <th>SESSION</th>
                    <th>STARTED AT</th>
                    <th>CHAT WITH</th>
                </thead>
                <tbody>
                    <?php
                    $chat = new Chat();
                    $chat_sessions = $chat->getChatSessions($wpdb, is_user_logged_in());
                    $lastchatsession = '';

                    if(isset($chat_sessions)){
                        foreach ($chat_sessions as $cs_bean){
                            if($cs_bean->getChatSession() !== $lastchatsession){
                                $chats[] = $cs_bean;
                                $lastchatsession = $cs_bean->getChatSession();
                            }
                        }
                        foreach ($chats as $cs_bean){
                            echo '<tr>';
                                echo '<td><span class="chatwith" data-chatsession="'.$cs_bean->getChatSession().'">'.$cs_bean->getChatSession().'</span></td>';
                                echo '<td><span class="chatwith" data-chatsession="'.$cs_bean->getChatSession().'">'.$cs_bean->getMoment().'</span></td>';
                                echo '<td><span class="chatwith" data-chatsession="'.$cs_bean->getChatSession().'">'.$cs_bean->getId_senderuser().'</span></td>';
                            echo '</tr>';        
                        }
                    }
                    ?>
                </tbody>
            </table>
        </form>
    </div>
<?php 
}

function admin_itmits__register_wp_admin_panel_demo() {
    global $getAdminMenuPageBean;
    $_get_admin_menu_page_fields = $getAdminMenuPageBean->get_admin_menu_page_fields();
    foreach ($_get_admin_menu_page_fields as $k=>$v){
        $label_slug = $v['label_slug'];
        $fields = $v['fields'];
        register_setting( 'wp_admin_panel_demo_group', $args['field_slug'] );
        foreach ($fields as $field_label => $args){
            register_setting( 'wp_admin_panel_demo_group', $args['field_slug'] );
        }
    }
}

//# SUB MENU
function admin_itmits__wp_admin_panel_demo__submenu_page() {
    global $getAdminMenuPageBean; ?>
    <div class="wrap">
        <h1>Chat config (TODO)</h1>
    </div>
<?php 
}


function _get_field($args){
    switch ($args['field_type']) {
        case 'text':
            return '<input type="text" id="'.$args['field_slug'].'" name="'.$args['field_slug'].'" class="retrieved_input" value="'.esc_attr( get_option($args['field_slug']) ).'"/>';
        case 'textarea':
            return '<textarea id="'.$args['field_slug'].'" name="'.$args['field_slug'].'" class="retrieved_text_area">'.esc_attr( get_option($args['field_slug']) ).'</textarea>';
        case 'checkbox':
            if(esc_attr( get_option($args['field_slug'])) === 'on'){
                return '<input id="'.$args['field_slug'].'" checked="checked" name="'.$args['field_slug'].'" class="retrieved_checkbox" type="checkbox"/>';
            }else{
                return '<input id="'.$args['field_slug'].'" name="'.$args['field_slug'].'" class="retrieved_checkbox" type="checkbox"/>';
            }
        default:
            return '';
    }
}

function admin_itmits__wp_admin_panel_demo_inline_js(){
    global $chat_plugin_dir_url;
    echo "<script type='text/javascript'>\n";
        echo 'var pluginUrl = "' . $chat_plugin_dir_url . '";';
    echo "\n</script>";
}

function admin_itmits__wp_admin_panel_demo_enqueue() { //https://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
    global $chat_plugin_dir_url;
    wp_enqueue_style( 'admin', $chat_plugin_dir_url . '/admin-uihsdw/public_html/css/admin.css' );
    wp_enqueue_style( 'chat-css', $chat_plugin_dir_url . '/frontend-haskjd/public_html/css/frontend.css' );
    wp_enqueue_script( 'frontend-script-admin', $chat_plugin_dir_url . '/frontend-haskjd/public_html/js/frontend-script.js', array(), null, true); //
    wp_enqueue_script( 'admin-script', $chat_plugin_dir_url . '/admin-uihsdw/public_html/js/admin-script.js' );
}