<?php
namespace MasterCustomBreakPoint;

defined( 'ABSPATH' ) || exit;

if( !class_exists('Master_Custom_Breakpoint') ){

	class Master_Custom_Breakpoint{

		public $dir;

		public $url;

		private static $plugin_path;

	    private static $plugin_url;

	    private static $_instance = null;

		const MINIMUM_PHP_VERSION = '5.6';

	    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

		public static $plugin_name = 'Master Custom Breakpoint';

	    public function __construct(){
			
			$this->jltma_mcb_include_files();
    	}

		public function jltma_mcb_include_files(){
			include JLTMA_MCB_PLUGIN_PATH . '/inc/breakpoint-assets.php';
			include JLTMA_MCB_PLUGIN_PATH . '/inc/hooks.php';

	        // include JLTMA_MCB_PLUGIN_PATH . '/inc/cpt.php';
	        // include JLTMA_MCB_PLUGIN_PATH . '/inc/api/rest-api.php';
	        // include JLTMA_MCB_PLUGIN_PATH . '/inc/api/cpt-api.php';
	        // include JLTMA_MCB_PLUGIN_PATH . '/inc/cpt-hooks.php';
	        // include JLTMA_MCB_PLUGIN_PATH . '/inc/jltma-activator.php';
	        
	        // include JLTMA_MCB_PLUGIN_PATH . '/inc/api/handler-api.php';
	        // include JLTMA_MCB_PLUGIN_PATH . '/inc/api/select2-api.php';
	        // include JLTMA_MCB_PLUGIN_PATH . '/inc/comments/class-comments-builder.php';
		}

	    public static function get_instance() {
	        if ( is_null( self::$_instance ) ) {
	            self::$_instance = new self();
	        }
	        return self::$_instance;
	    }
	}
}

