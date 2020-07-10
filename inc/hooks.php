<?php 
namespace MasterCustomBreakPoint\Inc;
use MasterCustomBreakPoint\Master_Custom_Breakpoint;

defined( 'ABSPATH' ) || exit;

class Master_CB_Hooks{

	public function __construct() {
		// add_action( 'admin_menu', [$this, 'jltma_mcb_menu'], 55);
		add_action( 'cmb2_admin_init', [$this, 'yourprefix_register_options_submenu_for_page_post_type'] );
		$this->jltma_mcb_includes();
	}

	public function jltma_mcb_includes(){
		

		if ( file_exists( JLTMA_MCB_PLUGIN_PATH . 'CMB2/init.php' ) ) {
			include JLTMA_MCB_PLUGIN_PATH . 'CMB2/init.php';
		} elseif ( file_exists( JLTMA_MCB_PLUGIN_PATH . 'CMB2/init.php' ) ) {
			include JLTMA_MCB_PLUGIN_PATH . 'CMB2/init.php';
		}

	}

    // public function jltma_mcb_menu(){
    //     add_submenu_page(
    //         'master-addons-settings',
    //         esc_html__('Custom Breakpoints', JLTMA_MCB_TD),
    //         esc_html__('Breakpoints', JLTMA_MCB_TD),
    //         'manage_options',
    //         'master-custom-breakpoints',
    //         array( $this, 'jltma_mcb_content')
    //     );
    // }



    function yourprefix_register_options_submenu_for_page_post_type() {

			/**
			 * Registers options page menu item and form.
			 */

			$cmb = new_cmb2_box( array(
				'id'           		=> 'master-custom-breakpoints',
				'title'        		=> esc_html__( 'Custom Breakpoints for Elementor', JLTMA_MCB_TD ),
				'object_types' 		=> array( 'options-page' ),
				'option_key'      	=> 'master-custom-breakpoints', 
				'menu_title'      	=> esc_html__( 'Breakpoints', JLTMA_MCB_TD ),
				'parent_slug'     	=> 'master-addons-settings',
				'capability'      	=> 'manage_options',
				'message_cb'      	=> 'yourprefix_options_page_message_callback',
			) );

			// $cmb->add_field( array(
			// 	'name'    => esc_html__( 'Background Color for Pages', JLTMA_MCB_TD ),
			// 	'desc'    => esc_html__( 'field description (optional)', JLTMA_MCB_TD ),
			// 	'id'      => 'bg_color',
			// 	'type'    => 'colorpicker',
			// 	'default' => '#ffffff',
			// ) );




			/**
			 * Repeatable Field Groups
			 */
			// $cmb_group = new_cmb2_box( array(
			// 	'id'           => 'yourprefix_group_metabox',
			// 	'title'        => esc_html__( 'Repeating Field Group', 'cmb2' ),
			// 	'object_types' => array( 'page' ),
			// ) );

			// $group_field_id is the field id string, so in this case: 'yourprefix_group_demo'
			$group_field_id = $cmb->add_field( array(
				'id'          => 'yourprefix_group_demo',
				'type'        => 'group',
				'description' => esc_html__( 'Generates reusable form entries', 'cmb2' ),
				'options'     => array(
					'group_title'    => esc_html__( 'Entry {#}', 'cmb2' ), // {#} gets replaced by row number
					'add_button'     => esc_html__( 'Add Another Entry', 'cmb2' ),
					'remove_button'  => esc_html__( 'Remove Entry', 'cmb2' ),
					'sortable'       => true,
					// 'closed'      => true, // true to have the groups closed by default
					// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
				),
			) );

			/**
			 * Group fields works the same, except ids only need
			 * to be unique to the group. Prefix is not needed.
			 *
			 * The parent field's id needs to be passed as the first argument.
			 */
			$cmb->add_group_field( $group_field_id, array(
				'name'       => esc_html__( 'Entry Title', 'cmb2' ),
				'id'         => 'title',
				'type'       => 'text',
				// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
			) );

			$cmb->add_group_field( $group_field_id, array(
				'name'        => esc_html__( 'Description', 'cmb2' ),
				'description' => esc_html__( 'Write a short description for this entry', 'cmb2' ),
				'id'          => 'description',
				'type'        => 'textarea_small',
			) );

			$cmb->add_group_field( $group_field_id, array(
				'name' => esc_html__( 'Entry Image', 'cmb2' ),
				'id'   => 'image',
				'type' => 'file',
			) );

			$cmb->add_group_field( $group_field_id, array(
				'name' => esc_html__( 'Image Caption', 'cmb2' ),
				'id'   => 'image_caption',
				'type' => 'text',
			) );


	}




	function yourprefix_options_page_message_callback( $cmb, $args ) {
		if ( ! empty( $args['should_notify'] ) ) {

			if ( $args['is_updated'] ) {

				// Modify the updated message.
				$args['message'] = sprintf( esc_html__( '%s &mdash; Updated!', JLTMA_MCB_TD ), $cmb->prop( 'title' ) );
			}

			add_settings_error( $args['setting'], $args['code'], $args['message'], $args['type'] );
		}
	}


	function myprefix_get_option( $key = '', $default = false ) {
		if ( function_exists( 'cmb2_get_option' ) ) {
			// Use cmb2_get_option as it passes through some key filters.
			return cmb2_get_option( 'myprefix_options', $key, $default );
		}

		// Fallback to get_option if CMB2 is not loaded yet.
		$opts = get_option( 'myprefix_options', $default );

		$val = $default;

		if ( 'all' == $key ) {
			$val = $opts;
		} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
			$val = $opts[ $key ];
		}

		return $val;
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