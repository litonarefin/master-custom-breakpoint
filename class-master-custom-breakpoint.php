<?php
namespace MasterCustomBreakPoint;

defined( 'ABSPATH' ) || exit;

if( !class_exists('JLTMA_Master_Custom_Breakpoint') ){

	class JLTMA_Master_Custom_Breakpoint{

		public $dir;

		public $url;

		private static $plugin_path;

	    private static $plugin_url;

	    private static $_instance = null;

		const MINIMUM_PHP_VERSION = '5.6';

	    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

		public static $plugin_name = 'Responsive Breakpoint Extender';

	    public function __construct(){
			
			$this->jltma_mcb_include_files();

			add_action( 'init', [ $this, 'jltma_mcb_i18n' ] );

			add_action( 'plugins_loaded', [ $this, 'init' ] );

			register_activation_hook(__FILE__, array($this, 'jltma_mcb_add_options'));
    	}

    	public function jltma_mcb_i18n(){
    		load_plugin_textdomain( 'master-custom-breakpoint' );
    	}

		public function init(){
			// echo 'liton';
	        include_once JLTMA_MCB_PLUGIN_PATH .'/lib/base.php';
	        include_once JLTMA_MCB_PLUGIN_PATH .'/lib/frontend.php';
	        include_once JLTMA_MCB_PLUGIN_PATH .'/lib/responsive.php';
	        include_once JLTMA_MCB_PLUGIN_PATH .'/lib/controls-stack.php';
	        include_once JLTMA_MCB_PLUGIN_PATH .'/lib/stylesheet.php';
	        include_once JLTMA_MCB_PLUGIN_PATH .'/lib/editor.php';
		}


	    // Read Contents from json file and insert Options Table
	    public function jltma_mcb_add_options(){
	        $custom_breakpoints = json_decode(file_get_contents( JLTMA_MCB_PLUGIN_PATH . '/custom_breakpoints.json'), true);
	        update_option('jltma_mcb', $custom_breakpoints );
	    }

		public function jltma_mcb_include_files(){
			include JLTMA_MCB_PLUGIN_PATH . '/inc/breakpoint-assets.php';
			include JLTMA_MCB_PLUGIN_PATH . '/inc/hooks.php';
		}

	    public static function get_instance() {
	        if ( is_null( self::$_instance ) ) {
	            self::$_instance = new self();
	        }
	        return self::$_instance;
	    }
	}
}

JLTMA_Master_Custom_Breakpoint::get_instance();