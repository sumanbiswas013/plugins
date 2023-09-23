<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/sumanbiswas013/
 * @since      1.0.0
 *
 * @package    Custom_Login_Sso
 * @subpackage Custom_Login_Sso/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Custom_Login_Sso
 * @subpackage Custom_Login_Sso/admin
 * @author     Suman Biswas <sumanbiswas013@gmail.com>
 */
class Custom_Login_Sso_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Custom_Login_Sso_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Custom_Login_Sso_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/custom-login-sso-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Custom_Login_Sso_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Custom_Login_Sso_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/custom-login-sso-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the custom API endpoint
	 *
	 * @since    1.0.0
	 */
	public function create_custom_login_endpoint(){
		register_rest_route('custom-login/v1', '/login', array(
			'methods' => 'POST',
			'callback' => array($this,'custom_user_login_callback')
		));
	}

	/**
	* Login API endpoint
	* @param : request object
	* first check the username and password is empty or not
	* then check the username exits or not. If not exits then create a new one and login the user
	* if username exits then check the username and password. If valid then login otherwise return error message
	* @return array
	*
	* @since    1.0.0
	*/
	public function custom_user_login_callback($request){
		$data = $request->get_json_params();
		$username = isset($data['username']) ? sanitize_text_field($data['username']) : '';
		$password = isset($data['password']) ? sanitize_text_field($data['password']) : '';
		
		$response = array();
		if(empty($username)){
			$response = array(
				'message'=>'Please enter an username',
				'data'	=> array()
			);
		}else if(empty($password)){
			$response = array(
				'message'=>'Please enter login password',
				'data'	=> array()
			);
		}else if ( username_exists( $username ) ) {
			$user = wp_authenticate($username, $password);

			if (is_wp_error($user)) {
				error_log(date('Y-m-d H:i:s')." Login faild ::".$username." \n",3,plugin_dir_path(__DIR__).'log/login.log');
				$response = array(
					'message'=>'Invalid login password',
					'data'	=> array()
				);
			} else {
				wp_set_current_user($user->ID);
				wp_set_auth_cookie($user->ID);
				
				error_log(date('Y-m-d H:i:s')." User login success. User ID ::".$user->ID." \n",3,plugin_dir_path(__DIR__).'log/login.log');

				$response = array(
					'message'=>'Login success',
					'data'	=> $user
				);
			}
		}else{
			$user_id = wp_create_user( $username, $password );
			if (is_wp_error($user_id)) {
				error_log(date('Y-m-d H:i:s')." Could not create user ::".$username." \n",3,plugin_dir_path(__DIR__).'log/login.log');

				$response = array(
					'message'=>'Could not create user',
					'data'	=> array()
				);
			} else {
				wp_set_current_user($user_id);
				wp_set_auth_cookie($user_id);
				
				error_log(date('Y-m-d H:i:s')." New user created ::".$user_id." \n",3,plugin_dir_path(__DIR__).'log/login.log');

				$user = get_user_by('ID',$user_id);
				$response = array(
					'message'=>'New user created',
					'data'	=> $user
				);
			}
		}
		$response_data = new WP_REST_Response( $response );
		return $response_data;
	}

	/**
	 * Create admin menu for login log
	 */
	public function create_user_login_log_menu(){
		add_menu_page('Login Log', 'Login Log', 'manage_options', 'login-log', array($this, 'user_login_log_callback') );
	}

	/**
	 * Menu callback function
	 * Load log data
	 */
	public function user_login_log_callback(){
		include ( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/display_log.php' );
	}
}
