<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class SWPA_Plugin_Template_Settings {

	/**
	 * The single instance of SWPA_Plugin_Template_Settings.
	 * @var 	object
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The main plugin object.
	 * @var 	object
	 * @access  public
	 * @since 	1.0.0
	 */
	public $parent = null;

	/**
	 * Prefix for plugin settings.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public $base = '';

	/**
	 * Available settings for plugin.
	 * @var     array
	 * @access  public
	 * @since   1.0.0
	 */
	public $settings = array();

	public function __construct ( $parent ) {
		$this->parent = $parent;

		$this->base = 'wpsp_';

		// Initialise settings
		add_action( 'init', array( $this, 'init_settings' ), 11 );

		// Register plugin settings
		add_action( 'admin_init' , array( $this, 'register_settings' ) );

		// Add settings page to menu
		add_action( 'admin_menu' , array( $this, 'add_menu_item' ) );

		// Add settings link to plugins page
		add_filter( 'plugin_action_links_' . plugin_basename( $this->parent->file ) , array( $this, 'add_settings_link' ) );
	}

	/**
	 * Initialise settings
	 * @return void
	 */
	public function init_settings () {
		$this->settings = $this->settings_fields();
	}

	/**
	 * Add settings page to admin menu
	 * @return void
	 */
	public function add_menu_item () {
		$page = add_options_page( __( 'Secure WP Admin', 'swpa' ) , __( 'Secure WP Admin', 'swpa' ) , 'manage_options' , 'swpa_settings' ,  array( $this, 'settings_page' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'settings_assets' ) );
	}

	/**
	 * Load settings JS & CSS
	 * @return void
	 */
	public function settings_assets () {

		// We're including the farbtastic script & styles here because they're needed for the colour picker
		// If you're not including a colour picker field then you can leave these calls out as well as the farbtastic dependency for the wpt-admin-js script below
		wp_enqueue_style( 'farbtastic' );
    	wp_enqueue_script( 'farbtastic' );

    	// We're including the WP media scripts here because they're needed for the image upload field
    	// If you're not including an image upload then you can leave this function call out
    	wp_enqueue_media();

    	wp_register_script( $this->parent->_token . '-settings-js', $this->parent->assets_url . 'js/settings' . $this->parent->script_suffix . '.js', array( 'farbtastic', 'jquery' ), '1.0.0' );
    	wp_enqueue_script( $this->parent->_token . '-settings-js' );
	}

	/**
	 * Add settings link to plugin list table
	 * @param  array $links Existing links
	 * @return array 		Modified links
	 */
	public function add_settings_link ( $links ) {
		$settings_link = '<a href="options-general.php?page=' . $this->parent->_token . '_settings">' . __( 'Settings', 'swpa' ) . '</a>';
  		array_push( $links, $settings_link );
  		return $links;
	}

	/**
	 * Build settings fields
	 * @return array Fields to be displayed on settings page
	 */
	private function settings_fields () {

		$settings['Settings'] = array(
			'title'					=> __( 'Settings', 'swpa' ),
			'description'			=> __( '', 'swpa' ),
			'fields'				=> array(
                // to add logo
                array(
                    'id' 			=> 'logo_image',
                    'label'			=> __( 'Your Logo  (optional)' , 'swpa' ),
                    'description'	=> __( 'Upload an image for your logo', 'swpa' ),
                    'type'			=> 'image',
                    'default'		=> '',
                    'placeholder'	=> ''
                ),
                array(
                    'id' 			=> 'enable',
                    'label'			=> __( 'Enable Secure WP Admin Lock', 'swpa' ),
                    'description'	=> __( 'Check this to enable Secure WP Admin\'s PIN lock on your whole site', 'swpa' ),
                    'type'			=> 'checkbox',
                    'default'		=> ''
                ),
                array(
                    'id' 			=> 'logo_width',
                    'label'			=> __( 'Logo Width (optional)' , 'swpa' ),
                    'description'	=> __( 'Here you can set logo widht in px.', 'swpa' ),
                    'type'			=> 'number',
                    'default'		=> '100',
                    'placeholder'	=> __( '42', 'swpa' )
                ),
                array(
                    'id' 			=> 'logo_height',
                    'label'			=> __( 'Logo Height (optional)' , 'swpa' ),
                    'description'	=> __( 'Here you can set logo height in px.<br><b>Note: keep both height and width same for neat look.<b>', 'swpa' ),
                    'type'			=> 'number',
                    'default'		=> '100',
                    'placeholder'	=> __( '42', 'swpa' )
                ),
				array(
					'id' 			=> 'pin',
					'label'			=> __( 'Password' , 'swpa' ),
					'description'	=> __( 'Enter PIN to lock your Login Page', 'swpa' ),
					'type'			=> 'text',
					'default'		=> '',
					'placeholder'	=> __( 'PIN', 'swpa' )
				),
                array(
                    'id' 			=> 'submit_label',
                    'label'			=> __( 'Label for submit button (optional)' , 'swpa' ),
                    'description'	=> __( 'From here you can set label for submit button.', 'swpa' ),
                    'type'			=> 'text',
                    'default'		=> 'Submit',
                    'placeholder'	=> __( 'Submit', 'swpa' )
                ),
                array(
                    'id' 			=> 'pin_placeholder',
                    'label'			=> __( 'Place holder text (optional)' , 'swpa' ),
                    'description'	=> __( 'From here you can set Placeholder text.', 'swpa' ),
                    'type'			=> 'text',
                    'default'		=> 'ENTER YOUR PIN',
                    'placeholder'	=> __( 'Placeholder text', 'swpa' )
                ),
                array(
                    'id' 			=> 'try_again_error',
                    'label'			=> __( 'Error Text (optional)' , 'swpa' ),
                    'description'	=> __( 'Text to be displayed if wrong PIN entered', 'swpa' ),
                    'type'			=> 'text',
                    'default'		=> 'Please Try Again',
                    'placeholder'	=> __( 'Error text', 'swpa' )
                ),
			)
		);

		$settings = apply_filters( $this->parent->_token . '_settings_fields', $settings );

		return $settings;
	}

	/**
	 * Register plugin settings
	 * @return void
	 */
	public function register_settings () {
		if ( is_array( $this->settings ) ) {

			// Check posted/selected tab
			$current_section = '';
			if ( isset( $_POST['tab'] ) && $_POST['tab'] ) {
				$current_section = $_POST['tab'];
			} else {
				if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
					$current_section = $_GET['tab'];
				}
			}

			foreach ( $this->settings as $section => $data ) {

				if ( $current_section && $current_section != $section ) continue;

				// Add section to page
				add_settings_section( $section, $data['title'], array( $this, 'settings_section' ), $this->parent->_token . '_settings' );

				foreach ( $data['fields'] as $field ) {

					// Validation callback for field
					$validation = '';
					if ( isset( $field['callback'] ) ) {
						$validation = $field['callback'];
					}

					// Register field
					$option_name = $this->base . $field['id'];
					register_setting( $this->parent->_token . '_settings', $option_name, $validation );

					// Add field to page
					add_settings_field( $field['id'], $field['label'], array( $this->parent->admin, 'display_field' ), $this->parent->_token . '_settings', $section, array( 'field' => $field, 'prefix' => $this->base ) );
				}

				if ( ! $current_section ) break;
			}
		}
	}

	public function settings_section ( $section ) {
		$html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
		echo $html;
	}

	/**
	 * Load settings page content
	 * @return void
	 */
	public function settings_page () {

		// Build page HTML
		$html = '<div class="wrap" id="' . $this->parent->_token . '_settings">' . "\n";
			$html .= '<h2>' . __( 'Secure WP Admin' , 'swpa' ) . '</h2>' . "\n";

			$tab = '';
			if ( isset( $_GET['tab'] ) && $_GET['tab'] ) {
				$tab .= $_GET['tab'];
			}

			// Show page tabs
			if ( is_array( $this->settings ) && 1 < count( $this->settings ) ) {

				$html .= '<h2 class="nav-tab-wrapper">' . "\n";

				$c = 0;
				foreach ( $this->settings as $section => $data ) {

					// Set tab class
					$class = 'nav-tab';
					if ( ! isset( $_GET['tab'] ) ) {
						if ( 0 == $c ) {
							$class .= ' nav-tab-active';
						}
					} else {
						if ( isset( $_GET['tab'] ) && $section == $_GET['tab'] ) {
							$class .= ' nav-tab-active';
						}
					}

					// Set tab link
					$tab_link = add_query_arg( array( 'tab' => $section ) );
					if ( isset( $_GET['settings-updated'] ) ) {
						$tab_link = remove_query_arg( 'settings-updated', $tab_link );
					}

					// Output tab
					$html .= '<a href="' . $tab_link . '" class="' . esc_attr( $class ) . '">' . esc_html( $data['title'] ) . '</a>' . "\n";

					++$c;
				}

				$html .= '</h2>' . "\n";
			}

			$html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";

				// Get settings fields
				ob_start();
				settings_fields( $this->parent->_token . '_settings' );
				do_settings_sections( $this->parent->_token . '_settings' );
				$html .= ob_get_clean();

				$html .= '<p class="submit">' . "\n";
					$html .= '<input type="hidden" name="tab" value="' . esc_attr( $tab ) . '" />' . "\n";
					$html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr( __( 'Save Settings' , 'swpa' ) ) . '" />' . "\n";
				$html .= '</p>' . "\n";
			$html .= '</form>' . "\n";
		$html .= '</div>' . "\n";

		echo $html;
	}

	/**
	 * Main SWPA_Plugin_Template_Settings Instance
	 *
	 * Ensures only one instance of SWPA_Plugin_Template_Settings is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see SWPA_Plugin_Template()
	 * @return Main SWPA_Plugin_Template_Settings instance
	 */
	public static function instance ( $parent ) {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $parent );
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Cloning is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __clone () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );
	} // End __clone()

	/**
	 * Unserializing instances of this class is forbidden.
	 *
	 * @since 1.0.0
	 */
	public function __wakeup () {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?' ), $this->parent->_version );
	} // End __wakeup()

}


function swpa_get_option( $key = '' ) {


    if ( $key == '' )
        return '';

    $swpa_defaults = array(
        // TODO define array for default values...
    );

    return get_option('wpsp_'.$key);

}