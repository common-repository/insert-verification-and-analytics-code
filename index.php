<?php
/**
* Plugin Name: Insert verification and analytics code
* Plugin URI: https://www.wordpress.com/
* Description: This is a simple plugin for adding the google analytics and veriication code on your WordPress Blogs and sites.
* Version: 2.0.1
* Author: Sanjeev Kumar
* Author URI: http://wordpress.com/
**/
add_action('admin_menu', 'inhfsetupmenu');
function inhfsetupmenu() {

    //create new top-level menu
    add_menu_page('Insert verification and analytics code Page','Analytics Code','administrator', __FILE__,'inhfinit');

    //call register settings function
    add_action( 'admin_init','register_inhfinit');

}


function register_inhfinit() {
      //register our settings
    register_setting( 'register_inhffield', 'inhfcode');
    register_setting( 'register_inhffield', 'inhfverification');
}

function inhfinit() {  
        //creating form for data fields ?>
        <div class="wrap">
        <h1>Thanks for installing our plugin </h1>
        <h2 style='color:#4290b0'>Please insert your code below and press save button.</h2>
            <form method="post" action="options.php">
                <?php settings_fields( 'register_inhffield' ); ?>
                <?php do_settings_sections( 'register_inhffield' ); ?>
                <p class ="data-field"><b>Insert google analytics code here.</b></p>
                <input type="textarea" style='width:20em;' placeholder ="Insert GAtag Here" name="inhfcode" value="<?php echo esc_attr( get_option('inhfcode') ); ?>" />
               <p class ="data-field"><b>Note:</b>&nbsp;Please insert only the UA key. Don't include "UA-".</p>

                <p class ="data-field"><b>Insert google verification code here.</b></p>
                <input type="textarea" style='width:20em;' placeholder ="Insert varification key here" name="inhfverification" value="<?php echo esc_attr( get_option('inhfverification') ); ?>" />
                <p class ="data-field"><b>Note:</b>&nbsp;Please insert only the key not the html.</p>

                <?php submit_button(); ?>

        
            </form>
        </div>
<?php 
}
//fetching datad from form and adding block into head tag.
function inhftags() {
    $inhf_geotag =   get_option( 'inhfcode' );
    $inhf_siteverify = get_option( 'inhfverification' );
            if (!empty($inhf_siteverify))
            {
                echo '<meta name="google-site-verification" content="'.$inhf_siteverify.'">';
            }
            if (!empty($inhf_geotag))
            {   
                echo "\n<!-- Global site tag (gtag.js) - Google Analytics -->
                <script async src='https://www.googletagmanager.com/gtag/js?id=UA-".$inhf_geotag."'></script>
                <script>
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag('js', new Date());
                gtag('config', 'UA-".$inhf_geotag."');
                </script>\n";
            }
}
add_action('wp_head','inhftags',5);
?>