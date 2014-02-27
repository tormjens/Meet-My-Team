<?php
/**
 * Meet My Team
 *
 * @package   Meet My Team
 * @author    Aaron Lee <aaron.lee@buooy.com>
 * @license   GPL-2.0+
 * @link      http://buooy.com
 * @copyright 2014 Buooy
 */
class Meet_My_Team_Admin {

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;
	
	/* All Necessary Variables */
	protected $post_type 	= 'team_members';
	protected $text_domain 	= 'meet-my-team';
	protected $post_name 	= 'Team Members';
	protected $menu_name 	= 'Meet My Team';
	protected $parent_item 	= 'Parent Team Member';
	protected $items_name 	= 'Members';
	protected $item_name 	= 'Member';

	/**
	 * Initialize the plugin by loading admin scripts & styles and adding a
	 * settings page and menu.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		/*
		 * Call $plugin_slug from public plugin class.
		 *
		 * @TODO:
		 *
		 * - Rename "Meet_My_Team" to the name of your initial plugin class
		 *
		 */
		$plugin = Meet_My_Team::get_instance();
		$this->plugin_slug = $plugin->get_plugin_slug();

		// Load admin style sheet and JavaScript.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );

		// Build Custom Post Type
		add_action( 'init', array( $this, 'build_custom_post_type'), 0 );
		add_action( 'admin_menu', array( $this, 'add_plugin_admin_menu' ) );
		add_action( 'add_meta_boxes', array($this, 'build_meta_box') );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_slug . '.php' );
		add_filter( 'plugin_action_links_' . $plugin_basename, array( $this, 'add_action_links' ) );
		
		

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		/*
		 * @TODO :
		 *
		 * - Uncomment following lines if the admin class should only be available for super admins
		 */
		/* if( ! is_super_admin() ) {
			return;
		} */

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @TODO:
	 *
	 * - Rename "Meet_My_Team" to the name your plugin
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_styles() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_style( $this->plugin_slug .'-admin-styles', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), Meet_My_Team::VERSION );
		}

	}

	/**
	 * Register and enqueue admin-specific JavaScript.
	 *
	 * @TODO:
	 *
	 * - Rename "Meet_My_Team" to the name your plugin
	 *
	 * @since     1.0.0
	 *
	 * @return    null    Return early if no settings page is registered.
	 */
	public function enqueue_admin_scripts() {

		if ( ! isset( $this->plugin_screen_hook_suffix ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( $this->plugin_screen_hook_suffix == $screen->id ) {
			wp_enqueue_script( $this->plugin_slug . '-admin-script', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), Meet_My_Team::VERSION );
		}

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		/*
		 * Add a settings page for this plugin to the Settings menu.
		 *
		 * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
		 *
		 *        Administration Menus: http://codex.wordpress.org/Administration_Menus
		 *
		 * @TODO:
		 *
		 * - Change 'Page Title' to the title of your plugin admin page
		 * - Change 'Menu Text' to the text for menu item for the plugin settings page
		 * - Change 'manage_options' to the capability you see fit
		 *   For reference: http://codex.wordpress.org/Roles_and_Capabilities
		 */
		$this->plugin_screen_hook_suffix = add_submenu_page(
			'edit.php?post_type=team_members',
			__( 'Meet My Team Settings', $this->plugin_slug ),
			__( 'Settings', $this->plugin_slug ),
			'manage_options',
			$this->plugin_slug,
			array( $this, 'display_plugin_admin_page' )
		);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {
		include_once( 'views/admin.php' );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_slug ) . '">' . __( 'Settings', $this->plugin_slug ) . '</a>'
			),
			$links
		);

	}

	/**
	 * 	-	Builds the Meet My team Custom Post Type
	 *	
	 *	POST TYPE: team_members
	 *
	 * @since    1.0.0
	 */
	public function build_custom_post_type() {
		
		// Builds the team_member post type
		$labels = array(
			'name'                => _x( $this->post_name, 'Post Type General Name', $this->text_domain ),
			'singular_name'       => _x( $this->post_name, 'Post Type Singular Name', $this->text_domain ),
			'menu_name'           => __( $this->menu_name, $this->text_domain ),
			'parent_item_colon'   => __( $this->parent_item, $this->text_domain ),
			'all_items'           => __( 'All '.$this->items_name, $this->text_domain ),
			'view_item'           => __( 'View '.$this->item_name, $this->text_domain ),
			'add_new_item'        => __( 'Add New '.$this->item_name, $this->text_domain ),
			'add_new'             => __( 'Add New', $this->text_domain ),
			'edit_item'           => __( 'Edit '.$this->item_name, $this->text_domain ),
			'update_item'         => __( 'Update '.$this->item_name, $this->text_domain ),
			'search_items'        => __( 'Search '.$this->item_name, $this->text_domain ),
			'not_found'           => __( 'Not found', $this->text_domain ),
			'not_found_in_trash'  => __( 'Not found in Trash', $this->text_domain ),
		);
		$args = array(
			'label'               => __( $this->post_name, $this->text_domain ),
			'description'         => __( 'Team members is a custom post type for Meet My Team', $this->text_domain ),
			'labels'              => $this->labels,
			'supports'            => array( 'title' ),
			'taxonomies'          => array( 'category' ),
			'hierarchical'        => true,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 70,
			'menu_icon'           => '',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
		);
		register_post_type( $this->post_type, $args );

	}
	
	/**
	 * 	-	Creates the meta boxes for the team members
	 *	
	 *	POST TYPE: team_members
	 *
	 * @since    1.0.0
	 */
	public function build_meta_box(){
		add_meta_box( 	$post_type.'_fields', // ID 
						'Additional Details', // Title 
						array($this, ''),	//Call back 
						$post_type,	//post type 
						'normal',
						'core', 
						'' );
	}
	

}
