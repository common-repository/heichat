<?php
/*
* Plugin Name: HeiChat
* Description: A sales chatbot based on the AI model of ChatGPT (GPT-3.5&GPT4) and Claude(Claude 3 Opus). 24/7 Converting general inquiries into sales. For "Where is my order" can be helpful in checking and responding accurately. Can take over the job of real human customer service. Support to answer discount, store policies, shipping policies. Use knowledge base and correction to train a customer service robot exclusively for your store.
* Plugin URI: https://heichat.net/
* Version: 1.0
* Author: GenCybers
* Developer: GenCybers
* License: GPL2
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
* Domain Path: /languages/
* Text Domain: heichat
*/


if (!defined('ABSPATH')) {
    exit;
}

define('HEICHAT_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('HEICHAT_PLUGIN_URI', plugin_dir_url(__FILE__));
define('HEICHAT_URI','https://admin.heichat.net/');
// Register Plugin Activation Hook
register_activation_hook(__FILE__, 'heichat_activate_plugin');
register_uninstall_hook(__FILE__,'heichat_uninstall_plugin');

function heichat_activate_plugin() {

}
function heichat_uninstall_plugin(){
    delete_option('heichat_login');
    delete_option('heichat_js_url');
    delete_option('heichat_integrate');
}

add_action('admin_menu', 'heichat_add_admin_menu');
function heichat_add_admin_menu() {
    add_menu_page(
        __('HeiChat', 'heichat'),
        __('HeiChat', 'heichat'),
        'manage_options',
        'heichat',
        'heichat_display_page',
        'dashicons-smiley',
        6
    );
}

function heichat_display_page() {
    include HEICHAT_PLUGIN_DIR . 'templates/admin/menu-page.php';
}

function heichat_enqueue_admin_styles($hook) {
    // Check if we're on the desired admin page
    if ($hook != 'toplevel_page_heichat') {
        return;
    }
    // Register the stylesheet
    wp_register_style(
        'heichat-admin-style', // Handle
        HEICHAT_PLUGIN_URI.'static/css/heichat.css', // Path to the CSS file
        array(), // Dependencies
        '1.0', // Version
        'all' // Media
    );

    // Enqueue the stylesheet
    wp_enqueue_style('heichat-admin-style');
}

add_action('admin_enqueue_scripts', 'heichat_enqueue_admin_styles');



//Update local configuration remotely
function heichat_api(){
    $action = isset($_REQUEST['do']) ? sanitize_text_field($_REQUEST['do']) : '';
    switch ($action){
        case 'login':

            $user_id = isset($_REQUEST['user_id']) ? sanitize_text_field($_REQUEST['user_id']) : false;
            if(empty($user_id)){
                die( wp_json_encode(['code'=>100,'msg'=>'The param user_id is necessary']));
            }else{
                $option=get_option('heichat_login');
                if(!empty($option)){
                    die( wp_json_encode(['code'=>201,'msg'=>'already set user_id','data'=>$option]));
                }else{
                    update_option('heichat_login',$user_id);
                    die( wp_json_encode(['code'=>200,'msg'=>'ok']));
                }
            }
            break;
        case 'install':

            $user_id = isset($_REQUEST['user_id']) ? sanitize_text_field($_REQUEST['user_id']) : 0;
            $js_url = isset($_REQUEST['js_url']) ? esc_url_raw($_REQUEST['js_url']) : '';

            if(empty($user_id)){
                die( wp_json_encode(['code'=>100,'msg'=>'The param user_id is necessary']));
            }
            $login_user_id=get_option('heichat_login');
            if($user_id!=$login_user_id){
                die( wp_json_encode(['code'=>100,'msg'=>'error  user_id']));
            }
            if(empty($js_url)){
                die( wp_json_encode(['code'=>100,'msg'=>'The param js_url is necessary']));
            }else{
                $option=get_option('heichat_js_url');
                if(!empty($option)){
                    die( wp_json_encode(['code'=>201,'msg'=>'already set js_url','data'=>$option]));
                }else{
                    update_option('heichat_js_url',$js_url);
                    die( wp_json_encode(['code'=>200,'msg'=>'ok']));
                }
            }
            break;
        case 'integrate':

            $integrate = isset($_REQUEST['integrate']) ? sanitize_text_field($_REQUEST['integrate']) : '';
            $option=get_option('heichat_integrate');
            if(!empty($option)){
                die( wp_json_encode(['code'=>201,'msg'=>'already set integrate','data'=>$option]));
            }else{
                update_option('heichat_integrate',$integrate);
                die( wp_json_encode(['code'=>200,'msg'=>'ok']));
            }
            break;
        default:
            die( wp_json_encode(['code'=>100,'msg'=>'error do']));
            break;
    }
}
add_action('wp_ajax_heichat_api','heichat_api');
add_action('wp_ajax_nopriv_heichat_api','heichat_api');

add_action('wp_enqueue_scripts', 'heichat_js_to_head');
function heichat_js_to_head() {
    $login=get_option('heichat_login');
    $js_url=get_option('heichat_js_url');
//    $integrate=get_option('heichat_integrate');
    if(!empty($login)&&!empty($js_url)){
        wp_enqueue_script('heichat-js', $js_url, array(), 1, true);
    }
}