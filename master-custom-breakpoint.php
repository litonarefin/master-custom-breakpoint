<?php
/**
 * Plugin Name: AAA Master Custom Breakpoint
 * Description: Custom Breakpoint Creator by Master Addons
 * Plugin URI:  https://master-addons.com/
 * Version:     1.0.1
 * Author:      Jewel Theme
 * Author URI:  https://master-addons.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: jltma_mcb
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) || exit;

define( 'JLTMA_MCB_VERSION', '1.0.0' );
define( 'JLTMA_MCB_TD', 'jltma_mcb' );
define( 'JLTMA_MCB_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'JLTMA_MCB_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
define( 'JLTMA_MCB_PLUGIN_DIR', plugin_basename( __FILE__ ) );

require plugin_dir_path( __FILE__ ) . 'class-master-custom-breakpoint.php';

add_action( 'plugins_loaded', 'jltma_mcb_init' );

function jltma_mcb_init(){
	\MasterCustomBreakPoint\Master_Custom_Breakpoint::get_instance();
}
