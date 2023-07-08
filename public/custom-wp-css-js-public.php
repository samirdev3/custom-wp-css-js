<?php
/**
 * Front-facing functionality.
 */

// Prevent direct file access.
if ( ! defined( 'CWCJS_FILE' ) ) {
	die();
}

/**
 * Get plugin options output
 */
$cwjs_options = get_option( CWCJS_OPTION );

/**
 * Print inline style element.
 */
if ( !function_exists( 'cwcjs_print_inline_css' ) ) {
    add_action( 'wp_head', 'cwcjs_print_inline_css', 101 );
    function cwcjs_print_inline_css() {
        echo '<style id="cwcjs-css">';
            cwcjs_the_css();
        echo '</style>';
    }

    /**
     * Sanitize CSS.
     */
    function cwcjs_the_css() {
        $cwjs_options = get_option( CWCJS_OPTION );
        $raw_content = isset( $cwjs_options['cwcjs-css'] ) ? $cwjs_options['cwcjs-css'] : '';
        $content     = wp_kses( $raw_content, array( '\'', '\"' ) );
        $content     = str_replace( '&gt;', '>', $content );
        echo strip_tags( $content );
    }
}

/**
 * Print inline script element.
 */
if ( !function_exists( 'cwcjs_print_inline_script' ) ) {
    $cwjs_options = get_option( CWCJS_OPTION );

    if ( $cwjs_options['cwcjs-script-position'] === 'footer' ) {
        add_action( 'wp_footer', 'cwcjs_print_inline_script', 101 );
    } else {
        add_action( 'wp_head', 'cwcjs_print_inline_script', 10 );
    }

    function cwcjs_print_inline_script() {
        echo '<script id="cwcjs-script">';
            cwcjs_the_script();
        echo '</script>';
    }

    /**
     * Sanitize Script.
     */
    function cwcjs_the_script() {
        $cwjs_options = get_option( CWCJS_OPTION );
        $raw_content = isset( $cwjs_options['cwcjs-script'] ) ? $cwjs_options['cwcjs-script'] : '';
        $content     = wp_kses( $raw_content, array( '\'', '\"' ) );
        $content     = str_replace( '&gt;', '>', $content );
        echo strip_tags( $content );
    }
}
