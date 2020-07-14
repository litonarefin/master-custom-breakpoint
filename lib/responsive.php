<?php
namespace MasterCustomBreakPoint\Lib;
use \Elementor\Core\Responsive\Responsive;
use \Elementor\Core\Responsive\Files\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class JLTMA_Master_Custom_Breakpoint_Responsive extends Responsive{
	
	protected static $default_breakpoints = [
		'xs' => 0,
		'sm' => 480,
		'md' => 768,
		'lg' => 1025,
		'xl' => 1440,
		'xxl' => 1600,
	];

	protected static $editable_breakpoints_keys = [
		'md',
		'lg',
	];

	public static function jltma_cbps() {
	    $default_breakpoints = self::$default_breakpoints;
	    $custom_breakpoints = json_decode(file_get_contents( JLTMA_MCB_PLUGIN_PATH . '/custom_breakpoints.json'), true);
		return array_merge($default_breakpoints, $custom_breakpoints);
	}
	
	public static function get_breakpoints() {
		
		self::$default_breakpoints = self::jltma_cbps();
		return array_reduce(
			array_keys( self::$default_breakpoints ), function( $new_array, $breakpoint_key ) {
				if ( ! in_array( $breakpoint_key, self::$editable_breakpoints_keys ) ) {
					$new_array[ $breakpoint_key ] = self::$default_breakpoints[ $breakpoint_key ];
				} else {
					$saved_option = get_option( self::BREAKPOINT_OPTION_PREFIX . $breakpoint_key );

					$new_array[ $breakpoint_key ] = $saved_option ? (int) $saved_option : self::$default_breakpoints[ $breakpoint_key ];
				}

				return $new_array;
			}, []
		);
	}

	public static function has_custom_breakpoints() {
		return self::get_breakpoints();
	}

}
