<?php
/**
 * Plugin Name:       Fix Divi A11Y Man T
 * Plugin URI:        https://elevagedigital.com/fix-divi-a11y/?utm_source=wordpress&utm_medium=referral&utm_campaign=fixdivi
 * Description:       Fix Accessibility Issues in Divi Theme and Page Builder
 * Requires at least: 6.3
 * Requires PHP:      8.1
 * Version:           1.2
 * Author:            Elevage Digital
 * Author URI:        https://elevagedigital.com/?utm_source=wordpress&utm_medium=referral&utm_campaign=fixdivi
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       fix-divi-a11y-man-t
 * Domain Path:       /languages
 *
 * @package           Fix_Divi_A11Y_Man_T
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'FDA11Y_VERSION' ) ) {
	define( 'FDA11Y_VERSION', '1.1.01' );
}

// Used for referring to the plugin file or basename.
if ( ! defined( 'FDA11Y_FILE' ) ) {
	define( 'FDA11Y_FILE', plugin_basename( __FILE__ ) );
}

// Used for referring to the plugin base path.
if ( ! defined( 'FDA11Y_PATH' ) ) {
	define( 'FDA11Y_PATH', plugin_dir_path( __FILE__ ) );
}

// Theme Fixes
require 'public/general.php';

// Pagebuilder Fixes
require 'public/pagebuilder.php';

// Menu Fixes
require 'public/menu.php';
