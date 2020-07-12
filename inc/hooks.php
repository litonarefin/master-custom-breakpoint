<?php 
namespace MasterCustomBreakPoint\Inc;
use MasterCustomBreakPoint\JLTMA_Master_Custom_Breakpoint;
use Elementor\Core\Responsive\Responsive;


defined( 'ABSPATH' ) || exit;

class JLTMA_Master_Custom_Breakpoint_Hooks{

	public function __construct() {
		
		// $this->jltma_mcb_includes();

        add_action( 'admin_menu', [$this, 'jltma_mcb_menu'], 55);
        add_action( 'admin_post_download_elementor_settings', [$this, 'download_elementor_settings']);
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

    public function jltma_mcb_includes(){
    	// include JLTMA_MCB_PLUGIN_PATH . '/inc/hooks.php';
    }

    public function jltma_mcb_content(){ ?>
		

        <?php
        if(isset($_POST['updated']) && $_POST["updated"] === 'true' ){
            $this->handle_form();
        }

        $breakpoints = Responsive::get_breakpoints();
        // print_r($breakpoints);

        $breakpoints_tbody = "";

        $counter = 0;
        foreach($breakpoints as $bp => $bp_value) {
            

            $skip = ["xs", "sm", "md", "lg", "xl", "xxl"];
            if(in_array($bp, $skip))
                continue;

                    $breakpoints_tbody .= "<ul>
                        <li data-label='{$bp_value["name"]}'>
                            <input type='text' name='breakpoint_name[]' value='{$bp_value["name"]}'>
                        </li>
                        <li data-label='Select'>
                           <select name='breakpoint_select1[]'>
                                <option value='width'"; if($bp_value['select1'] == 'width') { $breakpoints_tbody .= 'selected'; } $breakpoints_tbody .= ">Width</option>
                                <option value='min-width'"; if($bp_value['select1'] == 'min-width') { $breakpoints_tbody .= 'selected'; } $breakpoints_tbody .= ">Min Width</option>
                                <option value='max-width'"; if($bp_value['select1'] == 'max-width') { $breakpoints_tbody .= 'selected'; } $breakpoints_tbody .= ">Max Width</option>
                                <option value='height'"; if($bp_value['select1'] == 'height') { $breakpoints_tbody .= 'selected'; } $breakpoints_tbody .= ">Height</option>
                                <option value='min-height'"; if($bp_value['select1'] == 'min-height') { $breakpoints_tbody .= 'selected'; } $breakpoints_tbody .= ">Min Height</option>
                                <option value='max-height'"; if($bp_value['select1'] == 'max-height') { $breakpoints_tbody .= 'selected'; } $breakpoints_tbody .= ">Max Height</option>
                            </select>                        
                        </li>
                        <li data-label='{$bp_value["input1"]}'>
                            <input type='number' name='breakpoint_input1[]' value='{$bp_value["input1"]}'>
                        </li>
                        <li data-label='Select'>
                            <select name='breakpoint_select2[]'>
                                <option value='width'"; if($bp_value['select2'] == 'width') { $breakpoints_tbody .= 'selected'; } $breakpoints_tbody .= ">Width</option>
                                <option value='min-width'"; if($bp_value['select2'] == 'min-width') { $breakpoints_tbody .= 'selected'; } $breakpoints_tbody .= ">Min Width</option>
                                <option value='max-width'"; if($bp_value['select2'] == 'max-width') { $breakpoints_tbody .= 'selected'; } $breakpoints_tbody .= ">Max Width</option>
                                <option value='height'"; if($bp_value['select2'] == 'height') { $breakpoints_tbody .= 'selected'; } $breakpoints_tbody .= ">Height</option>
                                <option value='min-height'"; if($bp_value['select2'] == 'min-height') { $breakpoints_tbody .= 'selected'; } $breakpoints_tbody .= ">Min Height</option>
                                <option value='max-height'"; if($bp_value['select2'] == 'max-height') { $breakpoints_tbody .= 'selected'; } $breakpoints_tbody .= ">Max Height</option>
                            </select>                        
                        </li>
                        <li data-label='{$bp_value["input2"]}'>
                            <input type='number' name='breakpoint_input2[]' value='{$bp_value["input2"]}'>
                        </li>
                        <li data-label='Orientation'>
                           <select name='orientation[]'>
                                <option value='none'"; if($bp_value['orientation'] == 'none') { $breakpoints_tbody .= 'selected'; } $breakpoints_tbody .= ">None</option>
                                <option value='portrait'"; if($bp_value['orientation'] == 'portrait') { $breakpoints_tbody .= 'selected'; } $breakpoints_tbody .= ">Portrait</option>
                                <option value='landscape'"; if($bp_value['orientation'] == 'landscape') { $breakpoints_tbody .= 'selected'; } $breakpoints_tbody .= ">Landscape</option>
                            </select>
                        </li>
                        <li data-label='description'>
                            <div class='button button-primary jltma-cbp-remove' onclick='del_master_cbp_table_row(this);'>x</div>
                        </li>
                    </ul>";

            $counter++;
        }

        ?>

        <div class="jltma-wrap">
            <h2>
                <?php echo esc_html_e( JLTMA_Master_Custom_Breakpoint::$plugin_name, JLTMA_MCB_TD ); ?>
            </h2>

            <form method="POST" class="jlmta-cbp-input-form">
                <input type="hidden" name="updated" value="true" />
                <?php wp_nonce_field( 'breakpoints_update', 'breakpoints_form' ); ?>

                <div id="master_cbp_table">
                    <ul>
                        <li><?php echo esc_html__('Name', JLTMA_MCB_TD);?></li>
                        <li><?php echo esc_html__('Select', JLTMA_MCB_TD);?></li>
                        <li><?php echo esc_html__('Value', JLTMA_MCB_TD);?></li>
                        <li><?php echo esc_html__('Select', JLTMA_MCB_TD);?></li>
                        <li><?php echo esc_html__('Value', JLTMA_MCB_TD);?></li>
                        <li><?php echo esc_html__('Orientation', JLTMA_MCB_TD);?></li>
                        <li><?php echo esc_html__('Actions', JLTMA_MCB_TD);?></li>
                    </ul>

                    <?php echo $breakpoints_tbody; ?>

                </div>

                <div class="submit">
                    <div class="button button-primary jltma-cbp-add" onclick="jltma_cbp_add();">
                        <?php echo esc_html__('Add Breakpoint', JLTMA_MCB_TD);?>
                    </div>
                    <input type="submit" name="submit" id="submit" class="button button-primary jltma-cbp-save" value="<?php echo esc_html__('Save Breakpoints', JLTMA_MCB_TD);?>">
                </div>
            </form>
        </div>
        <div class="jltma-wrap">
            <h2 class="jltma-cbp-ex-imp-head">
                <?php echo esc_html__('Export Elementor Settings', JLTMA_MCB_TD);?>        
            </h2>
            <div style="margin: 20px 0px">
                <div class="button button-primary jltma-cbp-add" onclick="window.open('admin-post.php?action=download_elementor_settings');">
                    <?php echo esc_html__('Export Settings', JLTMA_MCB_TD);?>
                </div>
            </div>
            <br>

            <h2 class="jltma-cbp-ex-imp-head" style="padding-top:0;">
                <?php echo esc_html__('Import Elementor Settings', JLTMA_MCB_TD);?>        
            </h2>
            <div>
                <form id="elementor_settings_import_form" enctype="multipart/form-data" method="post" name="elementor_settings">
                    <label for="jltma-cbp-import-file" style="font-size: 16px;">
                        <?php echo esc_html__('Select Settings File:', JLTMA_MCB_TD);?>        
                    </label>
                    <input name="elementor_settings" type="file" />
                    <input type="hidden" name="action" value="import_elementor_settings">

                    <button type="submit" class="button button-primary jltma-cbp-save">
                        <?php echo esc_html__('Import Settings', JLTMA_MCB_TD);?>        
                    </button>
                </form>
            </div>
            <div id="elementor_import_success" class='updated' style="display: none; float: right;">
                <p><?php echo esc_html__('Settings Imported', JLTMA_MCB_TD);?></p>
            </div>
        </div>

        <script>

            function del_master_cbp_table_row(element) {
                jQuery(element).parents('ul').remove();
            }

            function jltma_cbp_add() {

                var jltma_cbp_new_ul = "<ul>\n" +
                    "\t<li>\n" +
                    "\t\t<input type='text' name='breakpoint_name[]' value='name'>\n" +
                    "\t</li>\n" +
                    "\t<li>\n" +
                    "\t\t   <select name='breakpoint_select1[]'>\n" +
                    "\t\t\t<option value='width'>Width</option>\n" +
                    "\t\t\t<option value='min-width' selected>Min Width</option>\n" +
                    "\t\t\t<option value='max-width'>Max Width</option>\n" +
                    "\t\t\t<option value='height'>Height</option>\n" +
                    "\t\t\t<option value='min-height'>Min Height</option>\n" +
                    "\t\t\t<option value='max-height'>Max Height</option>\n" +
                    "\t\t</select>\n" +
                    "\t</li>\n" +
                    "\t<li>\n" +
                    "\t\t<input type='number' name='breakpoint_input1[]' value='1024'>\n" +
                    "\t</li>\n" +
                    "\t<li>\n" +
                    "\t\t<select name='breakpoint_select2[]'>\n" +
                    "\t\t\t<option value='width'>Width</option>\n" +
                    "\t\t\t<option value='min-width'>Min Width</option>\n" +
                    "\t\t\t<option value='max-width' selected>Max Width</option>\n" +
                    "\t\t\t<option value='height'>Height</option>\n" +
                    "\t\t\t<option value='min-height'>Min Height</option>\n" +
                    "\t\t\t<option value='max-height'>Max Height</option>\n" +
                    "\t\t</select>\n" +
                    "\t</li>\n" +
                    "\t<li>\n" +
                    "\t\t<input type='number' name='breakpoint_input2[]' value='1440'>\n" +
                    "\t</li>\n" +
                    "\t<li>\n" +
                    "\t   <select name='orientation[]'>\n" +
                    "\t\t\t<option value='none' selected>None</option>\n" +
                    "\t\t\t<option value='portrait'>Portrait</option>\n" +
                    "\t\t\t<option value='landscape'>Landscape</option>\n" +
                    "\t\t</select>\n" +
                    "\t</li>\n" +
                    "\t<li><div class='button button-primary jltma-cbp-remove' onclick='del_master_cbp_table_row(this);'>x</div></li>\n" +
                    "</ul>";
                jQuery('#master_cbp_table').append(jltma_cbp_new_ul);

            }

            jQuery("#elementor_settings_import_form").submit(function(evt){

                evt.preventDefault();
                var formData = new FormData(jQuery(this)[0]);

                jQuery.ajax({
                    url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    async: true,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    success: function (response) {
                        if(response == 'ok')  {
                            jQuery('#elementor_import_success').slideDown();
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        }
                    }
                });
                return false;
            });

        </script>

        <?php
    }


    public function handle_form() {
        //Breakpoints SAVE



        if( ! isset( $_POST['breakpoints_form'] ) || ! wp_verify_nonce( $_POST['breakpoints_form'], 'breakpoints_update' ) ){ ?>
            <div class="error">
                <p>Sorry, your nonce was not correct. Please try again.</p>
            </div> 
        <?php
            exit;
        } else {

            $data_updated = false;

            //CUSTOM BREAKPOINTS FILE SAVE
            $custom_breakpoints = [];
            foreach($_REQUEST["breakpoint_select1"] as $key => $select1_value) {
                $custom_breakpoints["breakpoint{$key}"] = [
                    'name'          => $_REQUEST["breakpoint_name"][$key],
                    'select1'       => $select1_value,
                    'input1'        => $_REQUEST["breakpoint_input1"][$key],
                    'select2'       => $_REQUEST["breakpoint_select2"][$key],
                    'input2'        => $_REQUEST["breakpoint_input2"][$key],
                    'orientation'   => $_REQUEST["orientation"][$key]
                ];
            }

            if(!empty($custom_breakpoints))
                $data_updated = file_put_contents( JLTMA_MCB_PLUGIN_PATH . '/custom_breakpoints.json', json_encode($custom_breakpoints));

            //CUSTOM BREAKPOINTS SAVE END

            if($data_updated) {

                echo "
                    <div class='updated'>
                        <p>Custom Breakpoints updated</p>
                    </div>
                    <script>
                        jQuery(document).ready(function() {
                           window.location.reload(); 
                        });
                    </script>
                ";

            } else {
                echo "
                    <div class='error'>
                        <p>Custom Breakpoints cannot be updated</p>
                    </div>
                ";
            }
        }

    }




    public function download_elementor_settings() {

        $export_options = [];
        $options = wp_load_alloptions();
        foreach($options as $option_name => $option_value) {
            if(preg_match('/elementor/', $option_name)) {
                $export_options[$option_name] = $option_value;
            }
        }
        $export_options["cbp"] = file_get_contents( JLTMA_MCB_PLUGIN_PATH . '/custom_breakpoints.json');

        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=elementor_settings_backup.txt");

        echo json_encode($export_options);

    }


}

new JLTMA_Master_Custom_Breakpoint_Hooks();