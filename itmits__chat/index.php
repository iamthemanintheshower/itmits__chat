<?php
/*
Plugin Name: itmits__chat
Plugin URI: http://www.imthemanintheshower.com/itmits__chat
Description: wp admin panel demo
Version: 0.1
Author: imthemanintheshower
Author URI: http://www.imthemanintheshower.com
License: MIT - https://opensource.org/licenses/mit-license.php
*/
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

global $plugin_folder_path;
global $chat_plugin_dir_url;
global $getAdminMenuPageBean;
global $getAdminSubmenuPageBean;

$plugin_folder_path = plugin_dir_path( __FILE__ );

$chat_plugin_dir_url = plugin_dir_url( __FILE__ );

include($plugin_folder_path . 'frontend-haskjd/_class-ikasdwno/Chat.php');

include($plugin_folder_path . 'frontend-haskjd/_class-ikasdwno/ChatBean.php');

include($plugin_folder_path . 'frontend-haskjd/_include-uashd/-functions.php');

include($plugin_folder_path . 'admin-uihsdw/_include-asdwe/-config-siodhow.php');

include($plugin_folder_path . 'admin-uihsdw/_class-ofishen/AdminMenuPageBean.php');

include($plugin_folder_path . 'admin-uihsdw/_class-ofishen/AdminSubmenuPageBean.php');

include($plugin_folder_path . 'admin-uihsdw/_class-ofishen/AdminPage.php');


$admin_menu_page_bean = new AdminMenuPageBean();
$admin_submenu_page_bean = new AdminSubmenuPageBean();

$admin_page = new AdminPage();

$getAdminMenuPageBean = $admin_page->getAdminMenuPageBean($admin_menu_page_config, $admin_menu_page_fields, $admin_menu_page_bean);
$getAdminSubmenuPageBean = $admin_page->getAdminSubmenuPageBean($admin_submenu_page_config, $admin_submenu_page_fields, $admin_submenu_page_bean);

//# admin panel
include($plugin_folder_path . '_include-sihdw/-functions.php'); //# A "-functions.php" file for the frontend/backend common functions (if you have common functions)
include($plugin_folder_path . 'admin-uihsdw/_include-asdwe/-functions-wp_admin_panel_demo.php'); //# Admin panel (if you need an "admin panel" for the plugin)

//# admin panel
add_action('admin_menu', 'admin_itmits__wp_admin_panel_demo__menu');
add_action('admin_print_scripts', 'admin_itmits__wp_admin_panel_demo_inline_js');
add_action('admin_print_scripts', 'admin_itmits__wp_admin_panel_demo_frontend_inline_js');
add_action('admin_enqueue_scripts', 'add_chat');
add_action('admin_enqueue_scripts', 'admin_itmits__wp_admin_panel_demo_enqueue');

//# frontend features
add_action('init', 'init_functions');

function admin_itmits__chat_script_and_styles(){
    global $chat_plugin_dir_url;
    wp_enqueue_style( 'chat-css', $chat_plugin_dir_url . '/frontend-haskjd/public_html/css/frontend.css' );
    wp_enqueue_script('chat-script', $chat_plugin_dir_url . '/frontend-haskjd/public_html/js/frontend-script.js', array(), null, true); //
}

function init_functions(){
    add_action('wp_enqueue_scripts', 'admin_itmits__chat_script_and_styles');
    add_action('wp_footer', 'add_chat');
}


add_action('wp_print_scripts', 'admin_itmits__wp_admin_panel_demo_frontend_inline_js');
