<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://test
 * @since      1.0.0
 *
 * @package    Test
 * @subpackage Test/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Test
 * @subpackage Test/admin
 * @author     test <test@test.com>
 */
class Test_Admin {

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
		 * defined in Test_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Test_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/test-admin.css', array(), $this->version, 'all' );

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
		 * defined in Test_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Test_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/test-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function my_admin_menu() {

		add_menu_page(
				__( 'Sample page', 'my-textdomain' ),
				__( 'Sample menu', 'my-textdomain' ),
				'manage_options',
				'sample-page',
				array($this, 'my_admin_page_contents'),
				'dashicons-schedule',
				3
		);

	}

	public function my_admin_page_contents() {
			?>
			<h1> <?php esc_html_e( 'Settings', 'my-plugin-textdomain' ); ?> </h1>
			<form method="POST" action="options.php">
			<?php
			settings_fields( 'sample-page' );
			do_settings_sections( 'sample-page' );
			submit_button();
			?>
			</form>
			<?php
	}

	

	public function my_settings_init() {

			add_settings_section(
					'sample_page_setting_section',
					'',
					'',
					'sample-page'
			);

			add_settings_field(
				'my_setting_field',
				__( 'Blacklist Emails', 'my-textdomain' ),
				array($this, 'my_setting_markup'),
				'sample-page',
				'sample_page_setting_section'
			);

			register_setting( 'sample-page', 'my_setting_field' );
	}


	public function my_setting_markup() {
			?> 
			<textarea name="my_setting_field" id="my_setting_field" cols="30" rows="10"><?php echo get_option( 'my_setting_field' ); ?></textarea>
			
			<?php
	}

	public function test($sanitized_user_login, $user_email, $errors) { 
		$option = get_option('my_setting_field');
		$option = array_map('trim', explode(',', $option));
		
		if(in_array($user_email, $option)){
			error_log(print_r($option,true));
			$errors->add( 'email_exists', __( '<strong>Error:</strong> This email address is being blacklisted.' ) ); 
		}
		
	}
}
