<?php
/*
Plugin Name: Gravitate Content Blocks
Description: Create Content Blocks.
Version: 1.0.0
Plugin URI: http://www.gravitatedesign.com
Author: Gravitate
*/

register_activation_hook( __FILE__, array( 'GRAV_BLOCKS', 'activate' ));
register_deactivation_hook( __FILE__, array( 'GRAV_BLOCKS', 'deactivate' ));

add_action('admin_menu', array( 'GRAV_BLOCKS', 'admin_menu' ));
add_action('admin_init', array( 'GRAV_BLOCKS', 'admin_init' ));
add_action('init', array( 'GRAV_BLOCKS', 'init' ));
add_action( 'admin_enqueue_scripts', array('GRAV_BLOCKS', 'enqueue_admin_files' ));


/**
 *
 * @author Gravitate
 *
 */
class GRAV_BLOCKS {


	private static $version = '1.0.0';
	private static $page = 'options-general.php?page=gravitate_blocks';
	private static $settings = array();
	private static $option_key = 'gravitate_blocks_settings';


	public static function dump($var){
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
	}

	/**
	 * This is the initial setup that connects the Settings and loads the Fields from ACF
	 *
	 * @return void
	 */
	private static function setup()
	{
		include_once plugin_dir_path( __FILE__ ).'gravitate-content-blocks-css.php';

		include plugin_dir_path( __FILE__ ).'gravitate-plugin-settings.php';
		new GRAV_BLOCKS_PLUGIN_SETTINGS(self::$option_key);

		if($config_path = self::get_path('config.php'))
		{
			include $config_path;
		}
		else
		{
			// Error
		}
	}

	public static function css()
	{
		return new GRAV_BLOCKS_CSS();
	}

	/**
	 * Runs on WP init
	 *
	 * @return void
	 */
	public static function init()
	{
		self::setup();
		self::add_filters();
	}

	/**
	 * Runs on WP init
	 *
	 * @return void
	 */
	public static function add_filters()
	{
		if(GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'filter_content') && !is_admin())
		{
			self::add_filter('the_content', 'filter_content');
		}
	}

	/**
	 * Runs on WP init
	 *
	 * @return void
	 */
	public static function add_filter($filter, $filter_function)
	{
		add_filter( $filter , array('GRAV_BLOCKS', $filter_function), 23);
	}

	/**
	 * Grabs the settings from the Settings class
	 *
	 * @param boolean $force
	 *
	 * @return void
	 */
	private static function get_settings($force=false)
	{
		self::$settings = GRAV_BLOCKS_PLUGIN_SETTINGS::get_settings($force);
	}

	/**
	 * Runs on WP Plugin Activation
	 *
	 * @return void
	 */
	public static function activate()
	{
		// Nothing for now
	}

	/**
	 * Runs on WP Plugin Deactivation
	 *
	 * @return void
	 */
	public static function deactivate()
	{
		// Nothing for now
	}

	/**
	 * Runs on WP Admin Initiate
	 *
	 * @return void
	 */
	public static function admin_init()
	{
		// Nothing for now
	}

	/**
	 * Create the Admin Menu in that Admin Panel
	 *
	 * @return void
	 */
	public static function admin_menu()
	{
		add_submenu_page( 'options-general.php', 'Gravitate Blocks', 'Gravitate Blocks', 'manage_options', 'gravitate_blocks', array( __CLASS__, 'admin' ));
	}

	/**
	 * Outputs the Grav Blocks
	 *
	 * @param string $section - This is the Section of blocks to pull from.
	 *                          For now there is just one.
	 *
	 * @return type
	 */
	public static function display($section='grav_blocks')
	{
		if(self::is_viewable())
		{
			$handler_file = self::get_path('handler.php');

			if($handler_file && get_field($section))
			{
				while(the_flexible_field($section))
				{
					$block_class_prefix = 'block';
					$block_name = strtolower(str_replace('_', '-', get_row_layout()));
					$block_background = get_sub_field('block_background');
					$block_background_image = get_sub_field('block_background_image');
					$block_background_style = (get_sub_field('block_background') == 'image' && $block_background_image ? ' style="background-image: url(\''.$block_background_image['large'].'\');" ' : '');

					include $handler_file;
				}
			}
		}
	}

	/**
	 * Returns the Array of locations that the blocks are attached to.
	 *
	 * Has Filter:
	 * Allows to be filtered with apply_filters( 'grav_block_locations', $locations_formatted )
	 *
	 * @return array
	 */
	public static function get_locations($format = 'acf')
	{
		self::get_settings(true);
		$locations = array();
		$locations_formatted = array();


		if($format == 'viewable')
		{
			$locations['post_types'] = self::$settings['post_types'];
			$locations['templates'] = self::$settings['templates'];
			return $locations;
		}


		if(!empty(self::$settings['post_types']))
		{
			foreach (self::$settings['post_types'] as $location)
			{
				$locations[] = array('key' => 'post_type', 'value' => $location);
			}
		}

		if(!empty(self::$settings['templates']))
		{
			foreach (self::$settings['templates'] as $location)
			{
				$locations[] = array('key' => 'page_template', 'value' => $location);
			}
		}

		$group = 0;


		foreach ($locations as $location)
		{
			$locations_formatted[] = array (
					array (
						'param' => $location['key'],
						'operator' => '==',
						'value' => $location['value'],
						'order_no' => 0,
						'group_no' => $group++,
					),
				);
		}

		$locations_formatted = apply_filters( 'grav_block_locations', $locations_formatted );

		return $locations_formatted;
	}

	/**
	 * Outputs the Markup for the Block
	 *
	 * @param string $block - This is the name of the block folder to retrieve and output
	 *
	 * @return void
	 */
	public static function get_block($block='')
	{
		if($path = self::get_path($block))
		{
			if(file_exists($path.'/block.php'))
			{
				include($path.'/block.php');
			}
			else
			{
				// Error
			}
		}
		else
		{
			// Error
		}
	}

	/**
	 * Returns the Enabled Blocks
	 *
	 * @return array
	 */
	public static function get_blocks()
	{
		self::get_settings(true);
		$blocks = array();

		if(empty(self::$settings['blocks_enabled']))
		{
			return array();
		}

		if($available_blocks = self::get_available_blocks())
		{
			$blocks = array_intersect_key($available_blocks, array_flip(self::$settings['blocks_enabled']));
		}

		return $blocks;
	}

	/**
	 * Returns all the available blocks
	 *
	 * Has Filter:
	 * Allows to be filtered with apply_filters( 'grav_blocks', $blocks );
	 *
	 * @return array
	 */
	public static function get_available_blocks()
	{
		$blocks = array();
		$plugin_blocks = array();
		$theme_blocks = array();

		// Get blocks from the Plugin
		if($directory = self::get_path())
		{
			$plugin_blocks = array_filter(glob($directory.'*'), 'is_dir');
		}

		// Get blocks from the Theme
		if($directory = get_template_directory().'/grav-blocks/')
		{
			if(is_dir($directory))
			{
				$theme_blocks = array_filter(glob($directory.'*'), 'is_dir');
			}
		}

		// Overwrite Plugin Blocks with Theme Blocks
		$dirs = array_merge($plugin_blocks, $theme_blocks);

		if($dirs)
		{
			foreach($dirs as $dir)
			{
				$block = basename($dir);

			    if(file_exists($dir.'/block.php'))
			    {
					$blocks[$block] = $dir;
				}
			}
		}

		// Apply Filters to allow others to filter the blocks used.
		$blocks = apply_filters( 'grav_blocks', $blocks );

		return $blocks;
	}

	/**
	 * Gets the correct path of a file or directory for a Block asset.
	 * Allows to be overwritten by the theme if the theme has a block asset in /grav-blocks/
	 *
	 * @param string $path
	 *
	 * @return string|false
	 */
	public static function get_path($path='')
	{
		if(!$path)
		{
			if(is_dir(plugin_dir_path( __FILE__ ).'grav-blocks/'))
			{
				return plugin_dir_path( __FILE__ ).'grav-blocks/';
			}
			else
			{
				// Error
			}
		}
		else
		{
			if(is_dir(get_template_directory().'/grav-blocks/'.$path.'/'))
			{
				return get_template_directory().'/grav-blocks/'.$path;
			}
			else if(file_exists(get_template_directory().'/grav-blocks/'.$path))
			{
				return get_template_directory().'/grav-blocks/'.$path;
			}
			else if(is_dir(plugin_dir_path( __FILE__ ).'grav-blocks/'.$path.'/'))
			{
				return plugin_dir_path( __FILE__ ).'grav-blocks/'.$path;
			}
			else if(file_exists(plugin_dir_path( __FILE__ ).'grav-blocks/'.$path))
			{
				return plugin_dir_path( __FILE__ ).'grav-blocks/'.$path;
			}

			return false;
		}
	}

	/**
	 * Returns the Real IP from the user
	 *
	 * @return string
	 */
	public static function get_real_ip()
    {
        foreach (array('HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'REMOTE_ADDR') as $server_ip)
        {
            if(!empty($_SERVER[$server_ip]) && is_string($_SERVER[$server_ip]))
            {
                if($ip = trim(reset(explode(',', $_SERVER[$server_ip]))))
	            {
	            	return $ip;
	            }
            }
        }

        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * Returns the Settings Fields for specifc location.
     *
     * @param string $location
     *
     * @return array
     */
	private static function get_settings_fields($location = 'general')
	{
		switch ($location)
		{

			case 'advanced':
				$advanced_options = array(
					//'use_foundation' => 'Use Foundation 5 CSS.',
					'filter_content' => 'Add content blocks to the end of your content.',
				);

				$fields = array();
				$fields['advanced_options'] = array('type' => 'checkbox', 'label' => 'Advanced Options', 'options' => $advanced_options, 'description' => 'Change Advanced Settings.');

			break;

			default:
			case 'general':
				$posts_to_exclude = array('attachment', 'revision', 'nav_menu_item', 'acf-field-group', 'acf-field');
				// TODO add filter here for $posts_to_exclude

				$posts = get_post_types();
				$templates = get_page_templates();
				$post_types = array();
				$template_options = array();

				foreach($posts as $post_type)
				{
					if(!in_array($post_type, $posts_to_exclude))
					{
						$post_types[$post_type] = self::unsanitize_title($post_type);
					}
				}

				if(!in_array('default', array_map('strtolower', $templates)) && !in_array('page.php', array_map('strtolower', $templates)) && file_exists(get_template_directory().'/page.php'))
				{
					$templates = array_merge(array('Default' => 'default'), $templates);
				}

				foreach($templates as $key => $template)
				{
					$template_options[$template] = self::unsanitize_title($key);
				}

				$background_colors_repeater = array(
					'name' => array('type' => 'text', 'label' => 'Name', 'description' => ''),
					'things' => array('type' => 'select', 'label' => 'Things', 'description' => 'asdfasf', 'options' => array('asdf','ggg')),
					'value' => array('type' => 'checkbox', 'label' => 'Value', 'description' => 'Use Hex values (ex. #ff0000)', 'options' => array('blue' => 'Blue', 'red' => 'Red'))
				);


				$fields = array();
				$fields['blocks_enabled'] = array('type' => 'checkbox', 'label' => 'Blocks Enabled', 'options' => implode(',', array_keys(self::get_available_blocks())), 'description' => 'Choose what post types you want to have the Gravitate Blocks.');
				$fields['background_colors'] = array('type' => 'repeater', 'label' => 'Background Color Options', 'fields' => $background_colors_repeater, 'description' => 'Choose what post types you want to have the Gravitate Blocks.');
				$fields['post_types'] = array('type' => 'checkbox', 'label' => 'Post Types', 'options' => $post_types, 'description' => 'Choose what post types you want to have the Gravitate Blocks.');
				$fields['templates'] = array('type' => 'checkbox', 'label' => 'Page Templates', 'options' => $template_options, 'description' => 'Choose what templates you want to have the Gravitate Blocks.');

			break;

		}

		return $fields;
	}

	/**
	 * Runs the Admin Page and outputs the HTML
	 *
	 * @return void
	 */
	public static function admin()
	{
		// Get Settings
		self::get_settings(true);

		// Save Settings if POST
		$response = GRAV_BLOCKS_PLUGIN_SETTINGS::save_settings();
		if($response['error'])
		{
			$error = 'Error saving Settings. Please try again.';
		}
		else if($response['success'])
		{
			$success = 'Settings saved successfully.';
		}

		?>

		<div class="wrap grav-blocks">
			<header>
				<h1><img itemprop="logo" src="http://www.gravitatedesign.com/wp-content/themes/gravtheme/library/images/grav_logo.png" alt="Gravitate"> Blocks</h1>
			</header>
			<main>
			<h4 class="blocks-version">Version <?php echo self::$version;?></h4>

			<?php if(!empty($error)){?><div class="error"><p><?php echo $error; ?></p></div><?php } ?>
			<?php if(!empty($success)){?><div class="updated"><p><?php echo $success; ?></p></div><?php } ?>
			</main>


		<br>
		<div class="gravitate-redirects-page-links">
			<a href="<?php echo self::$page;?>&section=general" class="<?php echo self::get_current_tab($_GET['section'], 'general'); ?>">General</a>
			<a href="<?php echo self::$page;?>&section=advanced" class="<?php echo self::get_current_tab($_GET['section'], 'advanced'); ?>">Advanced</a>
		</div>

		<br>
		<br>

		<?php

		$section = (!empty($_GET['section']) ? $_GET['section'] : 'settings');

		switch($section)
		{
			case 'advanced':
				self::form('advanced');

			break;

			default:
			case 'settings':
				self::form();
			break;
		}
		?>
		</div>
		<?php
	}

	/**
	 * Outputs the Form with the correct fields
	 *
	 * @param string $location
	 *
	 * @return type
	 */
	private static function form($location = 'general')
	{
		// Get Form Fields
		switch ($location)
		{
			default;
			case 'general':
				$fields = self::get_settings_fields();
				break;

			case 'advanced':
				$fields = self::get_settings_fields('advanced');
				break;
		}

		GRAV_BLOCKS_PLUGIN_SETTINGS::get_form($fields);
	}

	/**
	 * Filters a string to be in a title format
	 *
	 * @param string $title
	 *
	 * @return string
	 */
	public static function unsanitize_title($title)
	{
		return ucwords(str_replace(array('_', '-'), ' ', $title));
	}

	/**
	 * Enqueue Admin Scripts
	 *
	 * @param $hook
	 *
	 * @return runs enqueue for admin
	 */
	public static function enqueue_admin_files($hook){

		 if ( 'settings_page_gravitate_blocks' != $hook ) {
	        return;
	    }
    	wp_register_style( 'grav_blocks_admin_css', plugin_dir_url( __FILE__ ) . 'library/css/master.css', true, '1.0.0' );
    	wp_enqueue_style( 'grav_blocks_admin_css' );
	}


	/**
	 * Check if blocks are viewable on the front end
	 *
	 * @param none
	 *
	 * @return boolean
	 */
	public static function is_viewable(){

		if($id = get_the_ID())
		{
			$locations = self::get_locations('viewable');

			if(!empty($locations['post_types']))
			{
				if(in_array(get_post_type(), $locations['post_types'])){
					return true;
				}
			}
			if(!empty($locations['templates']))
			{
				$is_default = (get_page_template_slug($id) == '' && in_array('default', $locations['templates']));
				if($is_default || in_array(get_page_template_slug($id), $locations['templates'])){
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Filters the content and adds content blocks to the end of the content
	 *
	 * @param string $content
	 *
	 * @return
	 */
	public static function filter_content($content){

		ob_start();

		self::display();

		$blocks = ob_get_contents();
		ob_end_clean();

		return $content . $blocks;

	}

	/**
	 * Gets current tab and sets active state
	 *
	 * @param string $current
	 * @param string $section
	 *
	 * @return
	 */
	public static function get_current_tab($current = '' , $section = ''){

		if($current == $section || ($current == '' && $section == 'general'))
		{
			return 'active';
		}

	}


}