<?php
/**
 * Plugin Name: Coming soon and Maintenance mode WpDevArt
 * Plugin URI: http://wpdevart.com/wordpress-coming-soon-plugin
 * Description: Coming soon and Maintenance mode plugin is awesome tool to show your users that you are working on your website to make it better. Our coming soon plugin is the best way to create better coming soon page.  
 * Version: 2.0.4
 * Author: maintenance mode GG, wpdevart, big ben keeper
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
 
 
class coming_soon_main{
	// required variables
	
	private $coming_soon_plugin_url;
	
	private $coming_soon_plugin_path;
	
	private $coming_soon_version;
	
	public $coming_soon_options;
	
	
	function __construct(){
		
		$this->coming_soon_plugin_url  = trailingslashit( plugins_url('', __FILE__ ) );
		$this->coming_soon_plugin_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->coming_soon_version     = 1.0;
		$this->call_base_filters();
		$this->install_databese();
		$this->create_admin_menu();	
		$this->coming_soon_front_end();
		
	}
	
	public function create_admin_menu(){
		
		require_once($this->coming_soon_plugin_path.'includes/admin_menu.php');
		
		$coming_soon_admin_menu = new coming_soon_admin_menu(array('menu_name' => 'Coming Soon','databese_parametrs'=>$this->coming_soon_options));
		
		add_action('admin_menu', array($coming_soon_admin_menu,'create_menu'));
		
	}
	
	public function install_databese(){
		
		require_once($this->coming_soon_plugin_path.'includes/install_database.php');
		
		$coming_install_database = new install_database();
		
		$this->coming_soon_options = $coming_install_database->installed_options;
		
	}
	
	public function coming_soon_front_end(){
		
		require_once($this->coming_soon_plugin_path.'includes/front_end.php');

		$coming_soon_front_end = new coming_soon_front_end(array('menu_name' => 'Coming Soon Page','databese_parametrs'=>$this->coming_soon_options));

		add_action( 'template_redirect', array($coming_soon_front_end,'create_fornt_end') );
	}
	
	public function registr_requeried_scripts(){
		wp_register_script('coming-soon-script',$this->coming_soon_plugin_url.'includes/javascript/front_end_js.js');
		wp_register_script('angularejs',$this->coming_soon_plugin_url.'includes/javascript/angular.min.js');
		wp_register_script('coming-soon-script-admin',$this->coming_soon_plugin_url.'includes/javascript/admin_coming_soon.js');
		wp_register_style('jquery-ui-style',$this->coming_soon_plugin_url.'includes/style/jquery-ui-style.css');
		wp_register_style('coming-soon-admin-style',$this->coming_soon_plugin_url.'includes/style/admin-style.css');
		wp_register_style('coming-soon-style',$this->coming_soon_plugin_url.'includes/style/style.css');
		
	}
	
	public function call_base_filters(){
		add_action( 'init',  array($this,'registr_requeried_scripts') );
	}
  	
	private function include_file(){
	
	}
}
$cooming_soon = new coming_soon_main();

?>