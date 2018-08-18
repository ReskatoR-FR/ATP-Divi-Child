<?php defined( 'ABSPATH' ) || exit;
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    ATP Divi Child
 * @subpackage ATP Divi Child/includes
 * @author     ReskatoR <plugins@reskator.fr>
 */
class ATP_DC_activate  {
	public static function activate() {
		update_option( 'rr-atp-divi-child_welcome-key', 'yes', '', true );
	}
}
