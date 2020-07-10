<?php 
namespace MasterCustomBreakPoint\Inc;
use MasterCustomBreakPoint\Master_Custom_Breakpoint;

defined( 'ABSPATH' ) || exit;

class Master_CB_Hooks{

	public function __construct() {
		add_action( 'admin_menu', [$this, 'jltma_mcb_menu'], 55);
		$this->jltma_mcb_includes();
	}

    public function jltma_mcb_menu(){
        add_submenu_page(
            'master-addons-settings',
            esc_html__('Custom Breakpoints', JLTMA_MCB_TD),
            esc_html__('Breakpoints', JLTMA_MCB_TD),
            'manage_options',
            'master-custom-breakpoints',
            array( $this, 'jltma_mcb_content')
        );
    }

    public function jltma_mcb_content(){ ?>
		<div class="wrap">
		   	<h2>
		   		<?php _e( 'Welcome to '. Master_Custom_Breakpoint::$plugin_name, JLTMA_MCB_TD ); ?>		
		   	</h2>

		   	<div class="changelog content-wrap">
		      	<div class="feature-section images-stagger-right">
					

				</div>
			</div>
		</div> <!-- .wrap -->

    <?php }


}

new Master_CB_Hooks();