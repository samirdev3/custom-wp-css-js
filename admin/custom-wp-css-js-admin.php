<?php
// Prevent direct file access.
if ( ! defined( 'CWCJS_FILE' ) ) {
	die();
}

/**
 * Delete Options on Uninstall.
 * 
 */
if ( !function_exists( 'cwcjs_uninstall' ) ) {
    register_uninstall_hook( CWCJS_FILE, 'cwcjs_uninstall' );
    function cwcjs_uninstall() {
        delete_option( CWCJS_OPTION );
    }
}

/**
 * Register "Custom WP CSS & JS" submenu under "Appearance" admin menu. 
 * 
 */
if ( !function_exists( 'cwcjs_register_submenu_page' ) ) {
    add_action( 'admin_menu', 'cwcjs_register_submenu_page' );
    function cwcjs_register_submenu_page() {
        add_theme_page( 'Custom WP CSS & JS', 'Custom CSS & JS', 'edit_theme_options', basename( CWCJS_FILE ), 'cwcjs_render_submenu_page' );
    }
}

/**
 * Register settings (form field).
 *
 */
if ( !function_exists( 'cwcjs_register_settings' ) ) {
    add_action( 'admin_init', 'cwcjs_register_settings' );
    function cwcjs_register_settings() {
        register_setting( 'cwcjs_settings_group', CWCJS_OPTION );
    }
}

/**
 * Render submenu page
 * 
 */
if ( !function_exists( 'cwcjs_render_submenu_page' ) ) {
    function cwcjs_render_submenu_page() {
        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        
        require_once CWCJS_DIR . '/admin/custom-wp-css-js-form.php';
    }
}

/**
 * Register and enqueue a CSS in the admin.
 * 
 */
if ( !function_exists( 'cwcjs_enqueue_styles' ) ) {
    add_action( 'admin_enqueue_scripts', 'cwcjs_enqueue_styles' );
    function cwcjs_enqueue_styles( $hook ) {
        if ( 'appearance_page_custom-wp-css-js' !== $hook ) {
            return;
        }
        
        wp_register_style( 'cwcjs-admin-style', plugins_url( '/css/styles.min.css', __FILE__ ));
        wp_enqueue_style( 'cwcjs-admin-style' );

        // codemirror
        wp_register_style( 'cwcjs-admin-codemirror-style', plugins_url( '/codemirror/codemirror.min.css', __FILE__ ));
        wp_enqueue_style( 'cwcjs-admin-codemirror-style' );
        wp_register_script( 'cwcjs-admin-codemirror-script', plugins_url( '/codemirror/codemirror.js', __FILE__ ));
        wp_enqueue_script( 'cwcjs-admin-codemirror-script' );
        wp_register_script( 'cwcjs-admin-codemirror-script-css', plugins_url( '/codemirror/css.js', __FILE__ ));
        wp_enqueue_script( 'cwcjs-admin-codemirror-script-css' );
        wp_register_script( 'cwcjs-admin-codemirror-script-javascript', plugins_url( '/codemirror/javascript.js', __FILE__ ));
        wp_enqueue_script( 'cwcjs-admin-codemirror-script-javascript' );
        wp_register_script( 'cwcjs-admin-codemirror-script-htmlmixed', plugins_url( '/codemirror/htmlmixed.js', __FILE__ ));
        wp_enqueue_script( 'cwcjs-admin-codemirror-script-htmlmixed' );
        wp_register_script( 'cwcjs-admin-codemirror-script-line', plugins_url( '/codemirror/active-line.js', __FILE__ ));
        wp_enqueue_script( 'cwcjs-admin-codemirror-script-line' );
        wp_register_script( 'cwcjs-admin-codemirror-script-matchbrackets', plugins_url( '/codemirror/matchbrackets.js', __FILE__ ));
        wp_enqueue_script( 'cwcjs-admin-codemirror-script-matchbrackets' );
    }
}