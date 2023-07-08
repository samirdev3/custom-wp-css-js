<?php
/**
 *
 * Plugin Name:       Custom WP CSS & JS
 * Plugin URI:        https://github.com/samirdev3/custom-wp-css-js
 * Description:       A lightweight plugin to add custom CSS, JS/Javascript to any theme. This plugin also gives you an ability to insert JS in header or footer. For settings please look under Appearance page.
 * Version:           1.2.1
 * Author:            Samir Manjiyani
 * Author URI:        https://github.com/samirdev3/custom-wp-css-js
 * Text Domain:       custom-wp-css-js
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * 
 * 
 * This Program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or any later version.
 * This Program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with This Program. If not, see {URI to Plugin License}.
 * 
 * 
 * @package           CustomWPCSSAndJS
 * @author            Samir Manjiyani
 * @version           1.2.1
 */

// Prevent direct file access.
if ( ! defined( 'ABSPATH' ) ) exit;

// CWCJS - Custom WP CSS & JS Settings
define( 'CWCJS_FILE', __FILE__ );
define( 'CWCJS_DIR', __DIR__ );
define( 'CWCJS_OPTION', 'cwcjs_settings' );
define( 'CWCJS_DOMAIN', 'custom-wp-css-js' );

// Insert plugin files
if ( is_admin() ) {
    require_once CWCJS_DIR . '/admin/custom-wp-css-js-admin.php';
} else {
    require_once CWCJS_DIR . '/public/custom-wp-css-js-public.php';
}