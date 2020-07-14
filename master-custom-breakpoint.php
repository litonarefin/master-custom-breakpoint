<?php
/**
 * Plugin Name: Master Breakpoint Extender for Elementor
 * Description: Custom Breakpoint Creator by Master Addons
 * Plugin URI:  https://master-addons.com/
 * Version:     1.0.1
 * Author:      Jewel Theme
 * Author URI:  https://master-addons.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: master-custom-breakpoint
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) || exit;

define( 'JLTMA_MCB_VERSION', '1.0.0' );
define( 'JLTMA_MCB_TD', 'master-custom-breakpoint' );
define( 'JLTMA_MCB_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'JLTMA_MCB_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
define( 'JLTMA_MCB_PLUGIN_DIR', plugin_basename( __FILE__ ) );

require plugin_dir_path( __FILE__ ) . 'class-master-custom-breakpoint.php';