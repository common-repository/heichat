<?php
    if (!defined('ABSPATH')) {
        exit;
    }
    $login=get_option('heichat_login');
    $js_url=get_option('heichat_js_url');
    $integrate=get_option('heichat_integrate');
    $ajax_url=admin_url('admin-ajax.php');
    if(!empty($login)&&!empty($js_url)&&!empty($integrate)){
        $success=true;
    }else{
        $success=false;
    }
    // HeiChat service URLs for integration
    $login_url=HEICHAT_URI.'integration/woocommerce/register?home_url='.home_url().'&ajax_url='.$ajax_url;
    $install_url=HEICHAT_URI.'integration/woocommerce/install?home_url='.home_url().'&ajax_url='.$ajax_url;
    $integrate_url = HEICHAT_URI . 'integration';
    $manual_url = HEICHAT_URI . 'setup/install';
    $panel_url=HEICHAT_URI.'dashboard';
?>

<div class="heichat-content">
    <div><img src="<?php echo esc_url(HEICHAT_PLUGIN_URI).'static/image/heichat-logo.svg'?>" alt=""></div>
    <div class="heichat-step-wrapper">
        <div class="center-logo-wrapper">
            <img class="heichat-center-logo" src="<?php echo esc_url(HEICHAT_PLUGIN_URI).'static/image/logo-heichat.svg'?>" alt="">
            <?php if($success){?>
                <img class="logo-tip" src="<?php echo esc_url(HEICHAT_PLUGIN_URI).'static/image/ok.svg'?>" alt="">
            <?php }else{?>
                <img class="logo-tip" src="<?php echo esc_url(HEICHAT_PLUGIN_URI).'static/image/reminder.svg'?>" alt="">
            <?php }?>
        </div>
        <?php if($success){?>
        <?php }else{?>
            <div class="heichat-step heichat-title">Please follow step to configured HeiChat for your website.</div>
        <?php }?>
        <div class="heichat-step"><?php if(!empty($login)){echo '<img class="step-ok" src="'.esc_url(HEICHAT_PLUGIN_URI).'static/image/ok.svg">';}else{echo '<input type="radio" disabled>';}?><span>1.Log in HeiChat to setup chatbot</span><?php if(empty($login)){?><a class="heichat-button" href="<?php echo esc_url($login_url);?>" target="_blank">Log in/Sign up</a><?php }?></div>
        <div class="heichat-step"><?php if(!empty($js_url)){echo '<img class="step-ok" src="'.esc_url(HEICHAT_PLUGIN_URI).'static/image/ok.svg">';}else{echo '<input type="radio" disabled>';}?><span>2.Install into WooCommerce theme</span><?php if(empty($js_url)){?><a class="heichat-button" href="<?php echo esc_url($install_url);?>" target="_blank">Install</a><?php }?></div>
        <div class="heichat-step"><?php if(!empty($integrate)){echo '<img class="step-ok" src="'.esc_url(HEICHAT_PLUGIN_URI).'static/image/ok.svg">';}else{echo '<input type="radio" disabled>';}?><span>3.Allow chatbot to reply”Where is my order” and better learning products in store.</span><?php if(empty($integrate)){?><a class="heichat-button" href="<?php echo esc_url($integrate_url);?>" target="_blank">Integrate WooCommerce</a><?php }?></div>
        <div class="heichat-step-tip mt30" >Chatbot Not showing? Try &nbsp<a target="_blank" href="<?php echo esc_url($install_url);?>">integrate again</a>&nbsp or &nbsp<a target="_blank" href="<?php echo esc_url($manual_url);?>">manual setup</a></div>
        <div class="heichat-step"><a target="_blank" href="<?php echo esc_url($panel_url);?>" class="panel-button">Open HeiChat panel</a></div>
        <div class="heichat-step-tip mt5" >Any questions? Email &nbsp<a href="mailto:heicarbook@gmail.com">heicarbook@gmail.com</a>&nbsp for help</div>
    </div>
</div>
