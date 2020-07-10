<?php
namespace MasterCustomBreakPoint\Inc;
use MasterCustomBreakPoint\Master_Custom_Breakpoint;

// namespace Elementor;
// use Elementor\Master_Custom_Breakpoint;


defined( 'ABSPATH' ) || exit;

class JLTMA_Master_Custom_Breakpoint_Assets{

    private static $_instance = null;
    
    public function __construct(){

        add_action('admin_print_scripts', [$this, 'jltma_mcb_admin_js']);

        // enqueue scripts
        add_action( 'admin_enqueue_scripts', [$this, 'jltma_mcb_admin_enqueue_scripts'] );

		add_action( 'elementor/editor/before_enqueue_scripts', [$this, 'jltma_mcb_elmentor_scripts']);

    }


    // Declare Variable for Rest API
    public function jltma_mcb_admin_js(){
        echo "<script type='text/javascript'>\n";
        echo $this->jltma_common_js();
        echo "\n</script>";
    }


    public function jltma_common_js(){
        ob_start(); ?>
            var masteraddons = { resturl: '<?php echo get_rest_url() . 'masteraddons/v2/'; ?>', }
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }


    public function jltma_mcb_elmentor_scripts(){
    	wp_enqueue_style( 'master-cbp-css', JLTMA_MCB_PLUGIN_URL . 'assets/css/master-cbp.css');
    	wp_enqueue_script( 'master-cbp-script', JLTMA_MCB_PLUGIN_URL . 'assets/js/master-cbp.js', array( 'jquery'), true, JLTMA_MCB_VERSION );

        // Localize Scripts
        $jltma_mcb_localize_data = array(
            'plugin_url'    => JLTMA_MCB_PLUGIN_URL,
            'ajaxurl'       => admin_url( 'admin-ajax.php' ),                
            'resturl'       => get_rest_url() . 'masteraddons/v2/'
        );      
        wp_localize_script( 'master-cbp-script', 'masteraddons', $jltma_mcb_localize_data );

    }

    public function jltma_mcb_admin_enqueue_scripts(){
        
        $screen = get_current_screen();

        if($screen->id == 'master-addons_page_master-custom-breakpoints'){

            // CSS
            wp_enqueue_style( 'master-cbp-admin', JLTMA_MCB_PLUGIN_URL . 'assets/css/master-cbp-admin.css');

            // JS
            wp_enqueue_script( 'master-cbp-admin', JLTMA_MCB_PLUGIN_URL . 'assets/js/master-cbp-admin.js', array( 'jquery'), true, JLTMA_MCB_VERSION );
        }
    }


    public static function get_instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

}

JLTMA_Master_Custom_Breakpoint_Assets::get_instance();