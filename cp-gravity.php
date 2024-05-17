<?php
/*
Plugin Name: CP Gravity
Plugin URI: https://decodecms.com
Description: Plugin que lee de una BD tablas de codigo postal y autocompleta campos de Gravity Forms.
Version: 1.0
Author: Jhon Marreros Guzmán
Author URI: https://decodecms.com
Text Domain: cp-gravity
Domain Path: languages
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

namespace dcms\cpgravity;

use dcms\cpgravity\includes\Submenu;
use dcms\cpgravity\includes\Enqueue;
use dcms\cpgravity\includes\Gravity;
use dcms\cpgravity\includes\Process;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin class to handle settings constants and loading files
**/
final class Loader{

	// Define all the constants we need
	public function define_constants():void{
		define ('DCMS_CPGRAVITY_VERSION', '1.0');
		define ('DCMS_CPGRAVITY_PATH', plugin_dir_path( __FILE__ ));
		define ('DCMS_CPGRAVITY_URL', plugin_dir_url( __FILE__ ));
		define ('DCMS_CPGRAVITY_BASE_NAME', plugin_basename( __FILE__ ));
		define ('DCMS_CPGRAVITY_SUBMENU', 'tools.php');
	}

	// Load all the files we need
	public function load_includes():void{
		include_once ( DCMS_CPGRAVITY_PATH . '/helpers/helper.php');
		include_once ( DCMS_CPGRAVITY_PATH . '/includes/submenu.php');
		include_once ( DCMS_CPGRAVITY_PATH . '/includes/enqueue.php');
		include_once ( DCMS_CPGRAVITY_PATH . '/includes/gravity.php');
		include_once ( DCMS_CPGRAVITY_PATH . '/includes/database.php');
		include_once ( DCMS_CPGRAVITY_PATH . '/includes/process.php');
	}

	// Load tex domain
	public function load_domain():void{
		add_action('plugins_loaded', function(){
			$path_languages = dirname(DCMS_CPGRAVITY_BASE_NAME).'/languages/';
			load_plugin_textdomain('cpgravity', false, $path_languages );
		});
	}

	// Add link to plugin list
	public function add_link_plugin():void{
		add_action( 'plugin_action_links_' . plugin_basename( __FILE__ ), function( $links ){
			return array_merge( array(
				'<a href="' . esc_url( admin_url( DCMS_CPGRAVITY_SUBMENU . '?page=cpgravity' ) ) . '">' . __( 'Settings', 'cpgravity' ) . '</a>'
			), $links );
		} );
	}

	// Initialize all
	public function init():void{
		$this->define_constants();
		$this->load_includes();
		$this->load_domain();
		$this->add_link_plugin();
		new SubMenu();
		new Enqueue();
		new Gravity();
		new Process();
	}

}

$dcms_process = new Loader();
$dcms_process->init();


