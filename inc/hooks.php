<?php 
namespace MasterCustomBreakPoint\Inc;
use MasterCustomBreakPoint\JLTMA_Master_Custom_Breakpoint;
use MasterCustomBreakPoint\Lib\JLTMA_Master_Custom_Breakpoint_Responsive;


defined( 'ABSPATH' ) || exit;

class JLTMA_Master_Custom_Breakpoint_Hooks{

    public function __construct() {

        add_action( 'init', [$this,'jltma_mcb_add_options']);
        add_action( 'admin_menu', [$this, 'jltma_mcb_menu'], 55);

        // Import Settings
        add_action( 'wp_ajax_jltma_cbp_import_elementor_settings', [$this, 'jltma_cbp_import_elementor_settings']);
        add_action( 'wp_ajax_nopriv_jltma_cbp_import_elementor_settings', [$this, 'jltma_cbp_import_elementor_settings']);

        //Export Setttings
        add_action( 'admin_post_jltma_mcb_export_settings', [$this, 'jltma_mcb_export_settings']);

        // Reset Form
        add_action( 'wp_ajax_jltma_mcb_reset_settings', [$this, 'jltma_mcb_reset_settings']);
        add_action( 'wp_ajax_nopriv_jltma_mcb_reset_settings', [$this, 'jltma_mcb_reset_settings']);

        // Save Breakpoint Settings
        add_action( 'wp_ajax_jltma_mcb_save_settings', [$this, 'jltma_mcb_save_settings']);
        add_action( 'wp_ajax_nopriv_jltma_mcb_save_settings', [ $this,'jltma_mcb_save_settings']);
    }

    public function jltma_mcb_menu(){
        add_submenu_page(
            'master-addons-settings',
            esc_html__('Master Custom Breakpoints', JLTMA_MCB_TD),
            esc_html__('Breakpoints', JLTMA_MCB_TD),
            'manage_options',
            'master-custom-breakpoints',
            array( $this, 'jltma_mcb_content')
        );
    }


    // Read Contents from json file and insert Options Table
    public function jltma_mcb_add_options(){

        $custom_breakpoints = json_decode(file_get_contents( JLTMA_MCB_PLUGIN_PATH . '/custom_breakpoints.json'), true);

        update_option('jltma_mcb', $custom_breakpoints );
    }



    public function jltma_mcb_content(){ 

        $breakpoints = JLTMA_Master_Custom_Breakpoint_Responsive::get_breakpoints();


        $breakpoints_tbody = "";

        $counter = 0;
        foreach($breakpoints as $bp => $bp_value) {
            

            $skip = ["xs", "sm", "md", "lg", "xl", "xxl"];
            if(in_array($bp, $skip))
                continue;

                    $breakpoints_tbody .= "<ul>
                        <li data-label='{$bp_value["name"]}'>
                            <input class='jlma-mcb-name' type='text' name='breakpoint_name[]' value='{$bp_value["name"]}'>
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
                            <div class='button button-primary jltma-cbp-remove' onclick='jltma_mbp_del_table_row(this);'>x</div>
                        </li>
                    </ul>";

            $counter++;
        } ?>

        <div class="jltma-wrap">
            <h2>
                <?php echo esc_html_e( JLTMA_Master_Custom_Breakpoint::$plugin_name, JLTMA_MCB_TD ); ?>
            </h2>

            <?php 
                if(isset($_POST['updated']) && $_POST["updated"] === 'true' ){
                    $this->handle_form();
                }
            ?>
            <form method="POST" class="jlmta-cbp-input-form" id="jlmta-cbp-form">

                <div class="jltma-spinner"></div>
                
                <?php wp_nonce_field( 'breakpoints_update', 'breakpoints_form' ); ?>

                <div id="master_cbp_table" class="master_cbp_table">
                    <ul>
                        <li><?php echo esc_html__('Device Name', JLTMA_MCB_TD);?></li>
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

            <div class="jltma-mcb-settings master_cbp_table">
                <ul>
                    <li>
                        <strong>
                            <?php echo esc_html__('Reset Settings', JLTMA_MCB_TD);?>
                        </strong>
                    </li>
                    <li>
                        <strong>
                            <?php echo esc_html__('Export Settings', JLTMA_MCB_TD);?>        
                        </strong>
                    </li>
                    <li>
                        <strong>
                            <?php echo esc_html__('Import Settings', JLTMA_MCB_TD);?>
                        </strong>
                    </li>
                </ul>


                <ul>
                    <li data-label='Reset Settings'>
                        <div style="margin: 20px 0px;">
                            <form id="elementor_settings_reset_form" method="post">
                                <?php wp_nonce_field( 'breakpoints_reset', 'reset_form' ); ?>
                                <!-- <div class="button button-primary jltma-cbp-reset" onclick="window.open('admin-post.php?action=jltma_mcb_reset_settings');"> -->
                                <button type="submit" class="button button-primary jltma-cbp-reset">
                                    <?php echo esc_html__('Reset Settings', JLTMA_MCB_TD);?>
                                </button>
                            </form>

                            <div id="reset_success" class='updated' style="display: none;">
                                <p><?php echo esc_html__('Reset Settings', JLTMA_MCB_TD);?></p>
                            </div>                            
                        </div>
                        <br>
                    </li>

                    <li data-label='Export Settings'>
                        <div style="margin: 20px 0px;">
                            <div class="button button-primary jltma-cbp-add" onclick="window.open('admin-post.php?action=jltma_mcb_export_settings');">
                                <?php echo esc_html__('Export Settings', JLTMA_MCB_TD);?>
                            </div>
                        </div>
                        <br>
                    </li>

                    <li>
                        <form id="elementor_settings_import_form" enctype="multipart/form-data" method="post">
                            
                            <?php wp_nonce_field('jltma-mcb-import'); ?>

                            <input name="jltma_mcb" type="file" />
                            <input type="hidden" name="action" value="jltma_cbp_import_elementor_settings">
                            <br>
                            <button type="submit" class="button button-primary jltma-cbp-save">
                                <?php echo esc_html__('Import Settings', JLTMA_MCB_TD);?>        
                            </button>
                        </form>

                        <div id="elementor_import_success" class='updated' style="display: none;">
                            <p><?php echo esc_html__('Settings Imported', JLTMA_MCB_TD);?></p>
                        </div>

                    </li>
                </ul>


            </div> <!-- master_cbp_table -->

        </div>

        <script>

            function jltma_mbp_del_table_row(element) {
                jQuery(element).parents('ul').remove();
                // jQuery(element).parents('ul').animate({'backgroundColor':'#fb6c6c'},300).slideUp(300);
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
                    "\t<li><div class='button button-primary jltma-cbp-remove' onclick='jltma_mbp_del_table_row(this);'>x</div></li>\n" +
                    "</ul>";
                jQuery('.master_cbp_table').append(jltma_cbp_new_ul);

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
                            }, 3000);
                        }
                    }
                });
                return false;
            });

        </script>

        <?php
    }


    public function jltma_mcb_save_settings(){
        
        // header( "Content-Type: application/json" );

        // check security field
        if( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'breakpoints_update' ) ) {
            wp_send_json_error(  esc_html__( 'Security Error.', JLTMA_MCB_TD ) );
        }

        $form_fields = $_POST['form_fields'];
        $output = array_slice($form_fields, 2); 
        $split_form_data = array_chunk($output, 6);

        $custom_breakpoints = [];
        foreach ( $split_form_data as $key => $value) {
            $custom_breakpoints["breakpoint{$key}"] = [
                'name'          => $value[0]['value'],
                'select1'       => $value[1]['value'],
                'input1'        => $value[2]['value'],
                'select2'       => $value[3]['value'],
                'input2'        => $value[4]['value'],
                'orientation'   => $value[5]['value']
            ];   
        }

        update_option( 'jltma_mcb', $custom_breakpoints );

        file_put_contents( JLTMA_MCB_PLUGIN_PATH . '/custom_breakpoints.json', json_encode($custom_breakpoints));

        die();

    }

    public function handle_form() {
        
        // Save Breakpoints 
        if( ! isset( $_POST['breakpoints_form'] ) || ! wp_verify_nonce( $_POST['breakpoints_form'], 'breakpoints_update' ) ){ ?>
            <div class="error">
                <p>
                    <?php echo esc_html__('Sorry, your nonce was not correct. Please try again.', JLTMA_MCB_TD);?>      
                </p>
            </div> 
        <?php
            exit;
        } else {

            $data_updated = false;

            //CUSTOM BREAKPOINTS FILE SAVE
            $custom_breakpoints = [];

            if (is_array($_REQUEST["breakpoint_select1"]) || is_object($_REQUEST["breakpoint_select1"])){

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
                            <p>Saved Breakpoints</p>
                        </div>
                        <script>
                            jQuery(document).ready(function() {
                               setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            });
                        </script>
                    ";

                } else {
                    echo "<div class='error'>
                            <p>Custom Breakpoints cannot be updated</p>
                        </div>";
                }
            }
        }

    }

    // Reset Settings
    public function jltma_mcb_reset_settings(){
        
        if( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'breakpoints_reset' ) ) {
            wp_send_json_error(  esc_html__( 'Security Error.', JLTMA_MCB_TD ) );
        }

        $original_file = file_get_contents( JLTMA_MCB_PLUGIN_PATH . '/lib/custom_breakpoints-original.json');
        
        $custom_breakpoints = json_decode($original_file, true);
        
        update_option( 'jltma_mcb', $custom_breakpoints );

        file_put_contents( JLTMA_MCB_PLUGIN_PATH .'/custom_breakpoints.json', json_encode($custom_breakpoints));

        echo json_encode('ok');

        die();

        
    }

    // Export & Download Settins Files
    public function jltma_mcb_export_settings() {

        $export_options = [];
        $options = wp_load_alloptions();
        foreach($options as $option_name => $option_value) {
            if(preg_match('/jltma_mcb/', $option_name)) {
                $export_options[$option_name] = $option_value;
            }
        }
        $export_options["jltma_mcb"] = file_get_contents( JLTMA_MCB_PLUGIN_PATH . '/custom_breakpoints.json');

        header("Content-type: text/plain");
        header("Content-Disposition: attachment; filename=master_custom_breakpoints_backup.json");

        echo json_encode($export_options);

    }

    // Import Files
    public function jltma_cbp_import_elementor_settings(){

        if (isset($_FILES['jltma_mcb']) && check_admin_referer('jltma-mcb-import')) {

            if ($_FILES['jltma_mcb']['error'] > 0) {
                wp_die("Error happens");
            }
            else {
                $file_name = $_FILES['jltma_mcb']['name']; // Get the name of file
                $file_ext = strtolower(end(explode(".", $file_name))); // Get extension of file
                $file_size = $_FILES['jltma_mcb']['size']; // Get size of file
                if (($file_ext == "json") && ($file_size < 500000)) {
                    $encode_options = file_get_contents($_FILES['jltma_mcb']['tmp_name']);
                    $options = json_decode($encode_options, true);
                    update_option( 'jltma_mcb', $options );
                    
                    file_put_contents( JLTMA_MCB_PLUGIN_PATH .'/custom_breakpoints.json', json_encode($options));

                    echo json_encode('ok');
                }
                else {
                    echo json_encode('notimported');
                }
            }
        }

        die();
    }


}

new JLTMA_Master_Custom_Breakpoint_Hooks();