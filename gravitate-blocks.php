<?php
/*
Plugin Name: Gravitate Blocks
Description: Create Content Blocks.
Version: 1.1.0
Plugin URI: http://www.gravitatedesign.com
Author: Gravitate
*/

register_activation_hook( __FILE__, array( 'GRAV_BLOCKS', 'activate' ));
register_deactivation_hook( __FILE__, array( 'GRAV_BLOCKS', 'deactivate' ));

add_action( 'admin_menu', array( 'GRAV_BLOCKS', 'admin_menu' ));
add_action( 'admin_init', array( 'GRAV_BLOCKS', 'admin_init' ));
add_action( 'init', array( 'GRAV_BLOCKS', 'init' ));
add_action( 'admin_enqueue_scripts', array('GRAV_BLOCKS', 'enqueue_admin_files' ));
add_action( 'wp_enqueue_scripts', array('GRAV_BLOCKS', 'enqueue_files' ));
add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), array('GRAV_BLOCKS', 'plugin_settings_link' ));

/**
 *
 * @author Gravitate
 *
 */
class GRAV_BLOCKS {


	private static $version = '1.1.0';
	private static $page = 'options-general.php?page=gravitate_blocks';
	private static $settings = array();
	private static $option_key = 'gravitate_blocks_settings';
	private static $posts_to_exclude = array('attachment', 'revision', 'nav_menu_item', 'acf-field-group', 'acf-field');


	public static function dump($var){
		echo '<pre>';
		var_dump($var);
		echo '</pre>';
	}

	/**
	 * Outputs the Grav CSS to the Front End Head
	 *
	 * @return type
	 */
	public static function add_head_css()
	{
		self::get_settings(true);

		$custom_class = GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('css_options', 'add_custom_color_class');


		?>

		<style>
			/* Gravitate Blocks CSS */
		<?php /* Sublime Color Issue Fix </style> */ ?><?php

		if(!empty(self::$settings['background_colors']))
		{
			foreach (self::$settings['background_colors'] as $color_key => $color_params)
			{
				$use_css_variable = (!empty($color_params['class']) && $custom_class);

			?>	<?php echo ($use_css_variable ? '.'.str_replace('.', '', $color_params['class']).', ' : ''); echo '.block-bg-'.$color_params['_repeater_id'];?> { background-color: <?php echo $color_params['value'];?>}
		<?php
			}
		}
	?></style>

		<?php

	}

	/**
	 * This is the initial setup that connects the Settings and loads the Fields from ACF
	 *
	 * @return void
	 */
	private static function setup()
	{
		include_once plugin_dir_path( __FILE__ ).'gravitate-blocks-css.php';

		include plugin_dir_path( __FILE__ ).'gravitate-plugin-settings.php';
		new GRAV_BLOCKS_PLUGIN_SETTINGS(self::$option_key);

		self::get_settings(true);

		/**
		 *  Set Background Colors
		 */
		$block_background_colors = array();
		$block_background_colors['block-bg-none'] = 'None';
		if(!empty(self::$settings['background_colors']))
		{
			foreach (self::$settings['background_colors'] as $color_key => $color_params)
			{
				$block_background_colors['block-bg-'.$color_params['_repeater_id']] = $color_params['name'];
			}
		}
		$block_background_colors['block-bg-image'] = 'Image';


		/**
		 *  Include Blocks in Flexible Content
		 */
		$layouts = array();
		foreach(self::get_blocks() as $block => $block_params)
		{
			if(!empty($block_params['path']))
			{
				$block_backgrounds = array (
					'key' => 'field_'.$block.'_x01',
					'label' => 'Background',
					'name' => 'block_background',
					'type' => 'select',
					'column_width' => '',
					'choices' => $block_background_colors,
					'default_value' => '',
					'allow_null' => 0,
					'multiple' => 0,
				);

				$block_background_image = array (
					'key' => 'field_'.$block.'_x02',
					'label' => 'Background Image',
					'name' => 'block_background_image',
					'type' => 'image',
					'conditional_logic' => array (
						'status' => 1,
						'rules' => array (
							array (
								'field' => 'field_'.$block.'_x01',
								'operator' => '==',
								'value' => 'block-bg-image',
							),
						),
						'allorany' => 'all',
					),
					'column_width' => '',
					'save_format' => 'object',
					'preview_size' => 'medium',
					'library' => 'all',
				);

				if(file_exists($block_params['path'].'/block_fields.php'))
				{
					$layouts[$block] = include($block_params['path'].'/block_fields.php');
				}
			}
		}


		/*
		* Block Function to build Admin and Set Fields for ACF
		*/
		if(function_exists("acf_add_local_field_group") && !empty($layouts))
		{
			// Filter the Fields from developers
			$layouts = apply_filters( 'grav_block_fields', $layouts );

			acf_add_local_field_group(array (
				'key' => 'group_grav_blocks',
				'title' => 'Grav Blocks',
				'fields' => array (
					array (
						'key' => 'field_x1',
						'label' => 'Grav Blocks',
						'name' => 'grav_blocks',
						'type' => 'flexible_content',
						'layouts' => $layouts,
						'button_label' => 'Add Content',
						'min' => '',
						'max' => '',
					),
				),
				'location' => self::get_locations(),
				'menu_order' => 100,
				'position' => 'normal',
				'style' => 'no_box',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));
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
		self::add_hooks();
	}

	/**
	 * Runs on WP init
	 *
	 * @return void
	 */
	public static function add_hooks()
	{
		if(GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'filter_content') && !is_admin())
		{
			self::add_hook('filter', 'the_content', 'filter_content', 23);
		}

		if(GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('css_options', 'enqueue_css') && !is_admin())
		{
			self::add_hook('action', 'wp_head', 'add_head_css');
		}

		if(GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('search_options', 'include_in_search') && !is_admin() && is_main_query())
		{
			self::add_hook('filter', 'posts_search', 'add_search_filtering');
			self::add_hook('filter', 'get_the_excerpt', 'add_search_excerpt_filtering');
		}

		if(!function_exists('acf_add_local_field_group') && (!isset($_GET['page']) || $_GET['page'] != 'gravitate_blocks'))
		{
			self::add_hook('action', 'admin_notices', 'acf_notice');
		}
	}

	/**
	 * Runs on WP init
	 *
	 * @return void
	 */
	public static function add_hook($type='', $hook='', $hook_function='', $param='')
	{
		if($type === 'action')
		{
			add_action( $hook , array(__CLASS__, $hook_function));
		}
		else
		{
			add_filter( $hook , array(__CLASS__, $hook_function), $param);
		}
	}

	/**
	 * Grabs the settings from the Settings class
	 *
	 * @param boolean $force
	 *
	 * @return void
	 */
	public static function get_settings($force=false)
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
		$active_settings = get_option(self::$option_key);
		if(!$active_settings)
		{
			$current_settings = array(
				'post_types' => array_keys(self::get_usable_post_types()),
				'templates' => '',
				'advanced_options' => array('filter_content', 'enqueue_cycle'),
				'css_options' => array('enqueue_css'),
				'background_colors' => array(
											array('name' => 'White', 'value' => '#ffffff'),
											array('name' => 'Light Gray', 'value' => '#eeeeee'),
											array('name' => 'Dark Gray', 'value' => '#555555')
										),
			);
			$blocks_groups = self::get_available_block_groups();
			foreach($blocks_groups as $group_name => $group_info){
				$current_settings['blocks_enabled_'.$group_name] = array_keys($group_info);
			}
			update_option(self::$option_key, $current_settings);
		}
	}

	public static function acf_notice($dismissible=true)
	{
	    ?>
	    <div class="notice error grav-blocks-acf-notice<?php echo ($dismissible ? ' is-dismissible' : '');?>">
	        <p><?php _e( 'Gravitate Blocks - ACF Pro is required to run Gravitate Blocks<br>To download the plugin go here. <a target="_blank" href="http://www.advancedcustomfields.com/pro/">http://www.advancedcustomfields.com/pro/</a><br>To remove this message permanently either Install ACF Pro or Deactivate the Gravitate Blocks Plugin', 'my-text-domain' ); ?></p>
	    </div>
	    <?php
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

	public static function plugin_settings_link($links)
	{
		$settings_link = '<a href="options-general.php?page=gravitate_blocks">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	public static function add_search_excerpt_filtering( $output )
	{
		if(empty($output) && !has_excerpt() && !get_the_content() && get_search_query())
		{
			global $wpdb;

			if($results = $wpdb->get_var("SELECT meta_value FROM ".$wpdb->postmeta." WHERE meta_value LIKE '%".get_search_query()."%' AND post_id = ".get_the_ID()." ORDER BY CHAR_LENGTH(meta_value) DESC LIMIT 1"))
			{
			    if(!empty($results))
		    	{
		    		$output = $results;
		    	}
			}
		}
		return $output;
	}

	public static function add_search_filtering($search)
	{
		if(!is_admin() && is_search() && is_main_query())
		{
			global $wpdb;
			$post_ids = array();

			if($results = $wpdb->get_results("SELECT * FROM ".$wpdb->postmeta.", ".$wpdb->posts." WHERE meta_value LIKE '%".get_search_query()."%' AND post_id = ID AND post_status = 'publish' GROUP BY post_id"))
			{
			    foreach ($results as $result)
			    {
			        $post_ids[] = $result->post_id;
			    }
			}

			if(!empty($post_ids))
			{
				$replace = ' OR ('.$wpdb->posts.'.ID IN ('.esc_sql(implode(',',$post_ids)).')) OR ';
				$search = str_replace(' OR ', $replace, $search);
			}
		}

		return $search;
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

					if(!empty(self::$settings['background_colors']))
					{
						foreach (self::$settings['background_colors'] as $color_key => $color_params)
						{
							$use_css_variable = (!empty($color_params['class']) && GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('css_options', 'add_custom_color_class'));

							if($block_background === 'block-bg-'.$color_params['_repeater_id'] && $use_css_variable)
							{
								$block_background.= ' '.$color_params['class'];
							}
						}
					}

					$block_background_image = get_sub_field('block_background_image');

					$block_background_style = (get_sub_field('block_background') == 'block-bg-image' && $block_background_image ? ' style="background-image: url(\''.$block_background_image['sizes']['large'].'\');" ' : '');

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

		if($available_blocks = self::get_available_blocks())
		{

			$enabled_blocks = array();

			foreach (self::$settings as $setting_key => $setting_value)
			{
				if(strpos($setting_key, 'blocks_enabled_') !== false && is_array($setting_value))
				{
					$enabled_blocks = array_merge($enabled_blocks, $setting_value);
				}
			}

			$blocks = array_intersect_key($available_blocks, array_flip($enabled_blocks));

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

		/* These are just placed to ignore any php warnings when including the fields */
		$block_backgrounds = '';
		$block_background_image = '';

		if($plugin_blocks)
		{
			foreach($plugin_blocks as $dir)
			{
				$block = basename($dir);

			    if(file_exists($dir.'/block_fields.php'))
			    {
			    	$fields = include($dir.'/block_fields.php');
					$blocks[$block] = array('label' => $block, 'path' => $dir, 'group' => (!empty($fields['grav_blocks_settings']['group']) ? $fields['grav_blocks_settings']['group'] : 'default'));
				}
			}
		}

		if($theme_blocks)
		{
			foreach($theme_blocks as $dir)
			{
				$block = basename($dir);

			    if(file_exists($dir.'/block_fields.php'))
			    {
			    	$fields = include($dir.'/block_fields.php');
					$blocks[$block] = array('label' => $block . ' <span class="extra-info">( Custom )</span>', 'path' => $dir, 'group' => (!empty($fields['grav_blocks_settings']['group']) ? $fields['grav_blocks_settings']['group'] : 'theme'));
				}
			}
		}



		// Apply Filters to allow others to filter the blocks used.
		$filterd_blocks = apply_filters( 'grav_blocks', $blocks );

		// foreach ($filterd_blocks as $filtered_key => $filtered_value)
		// {
		// 	if(isset($blocks[$filtered_key]) && serialize($filtered_value) !== serialize($blocks[$filtered_key]))
		// 	{
		// 		$filterd_blocks[$filtered_key]['label'].= ' <span class="extra-info">( Custom )</span>';
		// 	}

		// 	if(empty(var))
		// 	{

		// 	}
		// }

		return $filterd_blocks;
	}

	/**
	 * Returns all the available block groups
	 *
	 *
	 * @return array
	 */
	public static function get_available_block_groups()
	{
		$block_groups = array();
		foreach (self::get_available_blocks() as $block => $block_params)
		{
			$block_groups[str_replace(' ', '_', strtolower($block_params['group']))][$block] = $block_params['label'];
		}
		return $block_groups;
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
					'filter_content' => 'Gravitate Blocks will be added to the end of your content. <span class="extra-info">( Using "the_content" filter )</span>',
					'enqueue_cycle' => 'Cycle2 jQuery slider plugin will be used. <span class="extra-info">( Required for Imageside and Testimonials blocks</span> )',
				);
				$css_options = array(
					'add_custom_color_class' => 'Allow customization of CSS class names for the background color options.',
					'disable_colorpicker' => 'Disable color picker ( Use this to force your own css class names ).',
					'enqueue_css' => 'Background color CSS will be added to the website\'s header. <span class="extra-info">( Needed for custom background colors, images, etc. )</span>',
					//'use_foundation' => 'Use Foundation 5 CSS.',
				);

				$search_options = array(
					'include_in_search' => 'Includes Block Fields (all postmeta fields) in the search criteria.',
					//'use_foundation' => 'Use Foundation 5 CSS.',
				);

				$fields = array();
				$fields['advanced_options'] = array('type' => 'checkbox', 'label' => 'Advanced Options', 'options' => $advanced_options, 'description' => '');
				$fields['css_options'] = array('type' => 'checkbox', 'label' => 'CSS Settings', 'options' => $css_options, 'description' => '');
				$fields['search_options'] = array('type' => 'checkbox', 'label' => 'Search Settings', 'options' => $search_options, 'description' => '');

			break;

			default:
			case 'general':
				$post_types = self::get_usable_post_types();
				$template_options = self::get_template_options();
				$block_groups = self::get_available_block_groups();

				$background_colors_repeater = array();
				$background_colors_repeater['name'] = array('type' => 'text', 'label' => 'Name', 'description' => 'Name of color');

				if(GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('css_options', 'add_custom_color_class'))
				{
					$background_colors_repeater['class'] = array('type' => 'text', 'label' => 'CSS Class Name', 'description' => '( Optional )');
				}

				if(!GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('css_options', 'disable_colorpicker'))
				{
					$background_colors_repeater['value'] = array('type' => 'colorpicker', 'label' => 'Value', 'description' => 'Use Hex values (ex. #ff0000)');
				}



				$fields = array();

				foreach ($block_groups as $group => $blocks)
				{
					$description = ($group == 'default') ? 'Determine what default blocks will be available.' : '';
					$fields['blocks_enabled_'.$group] = array('type' => 'checkbox', 'label' => ucwords(str_replace('_', ' ', $group)).' Blocks', 'options' => $blocks, 'description' => $description);
				}

				$fields['background_colors'] = array('type' => 'repeater', 'label' => 'Background Color Options', 'fields' => $background_colors_repeater, 'description' => 'Choose what Background Colors you want to have the Gravitate Blocks.');
				$fields['post_types'] = array('type' => 'checkbox', 'label' => 'Post Types', 'options' => $post_types, 'description' => 'Determine the post types that Gravitate Blocks will appear on.');
				$fields['templates'] = array('type' => 'checkbox', 'label' => 'Page Templates', 'options' => $template_options, 'description' => 'Determine the page templates that Gravitate Blocks will appear on.');

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


			<?php if(!function_exists('acf_add_local_field_group'))
			{
				self::acf_notice(false);
			}
			?>

			<?php if(!empty($error)){?><div class="error"><p><?php echo $error; ?></p></div><?php } ?>
			<?php if(!empty($success)){?><div class="updated"><p><?php echo $success; ?></p></div><?php } ?>
			</main>


		<br>
		<div class="gravitate-redirects-page-links">
			<a href="<?php echo self::$page;?>&section=general" class="<?php echo self::get_current_tab($_GET['section'], 'general'); ?>">General</a>
			<a href="<?php echo self::$page;?>&section=advanced" class="<?php echo self::get_current_tab($_GET['section'], 'advanced'); ?>">Advanced</a>
			<a href="<?php echo self::$page;?>&section=developers" class="<?php echo self::get_current_tab($_GET['section'], 'developers'); ?>">Developers</a>
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

			case 'developers':
				self::developers();
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

	private static function developers()
	{
		?>
		<div class="grav-blocks-developers">
			<h2>Placing the blocks in your theme</h2>
			<h4>There are 2 ways to include Gravitate Blocks in your theme:</h4>
				<ul>
					<li>By default the blocks will be filtered into "the_content()".  However, you can disable that in the <a href="options-general.php?page=gravitate_blocks&section=advanced">Advanced Tab</a>.</li>
					<li>
						You can use the function to manually include them in your theme.
						<br><span class="grav-code-block"> &lt;?php GRAV_BLOCKS::display(); ?&gt;</span>
					</li>
				</ul>

			<h2>Modifying Blocks</h2>
			<h4>There are a few options to modify an existing block.</h4>
				<ul>
					<li>You can copy the block from:
						<br><span class="grav-code-block">wp-content/plugins/gravitate-blocks/grav-blocks</span>
						<br>and paste it in:
						<br><span class="grav-code-block">wp-content/themes/your-theme-folder/grav-blocks</span>
						<br><em>* This is not ideal as updates will not be applied to those blocks</em>
					</li>
					<li>You can Modify the Block by using the Hooks and Filters below (Recommended)</li>
				</ul>

			<h2>Adding your own blocks</h2>
			<h4>There are a few options for adding your own blocks.</h4>
				<ul>
					<li>You can create your own WP plugin to include your own blocks—this feature uses the "grav_blocks" filter below.</li>
					<li>You can create a block folder in:
						<br><span class="grav-code-block">wp-content/themes/your-theme-folder/grav-blocks</span>
					</li>
					<li>You can use the "grav_blocks" filter below in your functions.php file.</li>
				</ul>

			<h2>Hooks and Filters</h2>
			<ul>
			<li>
				<h3>grav_blocks</h3>
				This filters through the available blocks.
				<blockquote>
				<label>Example 1: Adding Your Own</label>
				<textarea class="grav-code-block">
add_filter( 'grav_blocks', 'your_function' );
function your_function($blocks)
{
	$blocks['my_block'] = array('label' => 'My Block', 'path' => 'path/to/your/block/folder/my_block', 'group' => 'Custom');
	return $blocks;
}
				</textarea>
				</blockquote>
				<blockquote>
				<label>Example 2: Removing A Block</label>
				<textarea class="grav-code-block">
add_filter( 'grav_blocks', 'your_function' );
function your_function($blocks)
{
	unset($blocks['html']);
	return $blocks;
}
				</textarea>
				</blockquote>
			</li>
			<li><h3>grav_block_locations</h3>
				This filters through the locations to allow Gravitate Blocks.
				<blockquote>
				<label>Example 1: Adding a Location to Events where the ID is not 14</label>
				<textarea class="grav-code-block">
add_filter( 'grav_block_locations', 'your_function' );
function your_function($locations)
{
	$locations[] = array(
						array(
							'param' => 'post_type',
                    		'operator' => '==',
                    		'value' => 'events'
                    	),
                    	array(
							'param' => 'post',
                    		'operator' => '!=',
                    		'value' => '14'
                    	)
					);

	return $locations;
}
				</textarea>
				</blockquote>
				<blockquote>
				<label>Example 2: Adding a Location to the Category Taxonomy</label>
				<textarea class="grav-code-block">
add_filter( 'grav_block_locations', 'your_function' );
function your_function($locations)
{
	$locations[] = array(
						array(
							'param' => 'taxonomy',
                    		'operator' => '==',
                    		'value' => 'category'
                    	)
					);

	return $locations;
}
				</textarea>
				</blockquote>
			</li>
			<li><h3>grav_block_fields</h3>
				This filters through the fields for each block.
				<blockquote>
				<label>Example 1: Removing the Attribution option for the Quote Block </label>
				<textarea class="grav-code-block">
add_filter( 'grav_block_fields', 'your_function' );
function your_function($fields)
{
	if(!empty($fields['quote']['sub_fields']))
	{
		foreach ($fields['quote']['sub_fields'] as $key => $field)
		{
			if($field['name'] === 'attribution')
			{
				unset($fields['quote']['sub_fields'][$key]);
			}
		}
	}

	return $fields;
}
				</textarea>
				</blockquote>
				<blockquote>
				<label>Example 2: Adding an Image to the Quote Block </label>
				<textarea class="grav-code-block">
add_filter( 'grav_block_fields', 'your_function' );
function your_function($fields)
{
	if(!empty($fields['quote']['sub_fields']))
	{
		$fields['quote']['sub_fields'][] = array(
			'key' => 'field_quote_image',
			'label' => 'Image',
			'name' => 'quote_image',
			'instructions' => 'Image should be 120x120px',
			'type' => 'image',
			'column_width' => '',
			'save_format' => 'object',		// url | object | id
			'library' => 'all',				// all | uploadedTo
			'preview_size' => 'medium',
		);
	}

	return $fields;
}
				</textarea>
				<br><em>* Keep in mind you will still need to update the markup to accept the new settings</em>
				</blockquote>
			</li>
			</ul>
		</div>
		<?php

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
    	wp_enqueue_style( 'grav_blocks_admin_css', plugin_dir_url( __FILE__ ) . 'library/css/master.css', true, '1.0.0' );
	    wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}

	/**
	 * Enqueue Front End Scripts
	 *
	 * @param $hook
	 *
	 * @return runs enqueue for front end where required
	 */
	public static function enqueue_files($hook){
		if (GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'enqueue_cycle') && self::is_viewable())
		{
			wp_enqueue_script( 'cycle2_js', plugin_dir_url( __FILE__ ) . 'library/js/cycle2.min.js', array('jquery'), '2.1.6', true );
		}

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
	public static function filter_content($content)
	{

		ob_start();

		self::display();

		$blocks = ob_get_contents();
		ob_end_clean();

		return $content . $blocks;

	}

	/**
	 * Gets usable post types
	 *
	 * @param
	 *
	 * @return
	 */
	public static function get_usable_post_types()
	{

		// TODO add filter here for $posts_to_exclude

		$posts = get_post_types();
		$post_types = array();

		foreach($posts as $post_type)
		{
			if(!in_array($post_type, self::$posts_to_exclude))
			{
				$post_types[$post_type] = self::unsanitize_title($post_type);
			}
		}

		return $post_types;

	}

	/**
	 * Gets template options
	 *
	 * @param
	 *
	 * @return
	 */
	public static function get_template_options()
	{

		// TODO add filter here for $templates_to_exclude

		$templates = get_page_templates();
		$template_options = array();

		if(!in_array('default', array_map('strtolower', $templates)) && !in_array('page.php', array_map('strtolower', $templates)) && file_exists(get_template_directory().'/page.php'))
		{
			$templates = array_merge(array('Default' => 'default'), $templates);
		}

		foreach($templates as $key => $template)
		{
			$template_options[$template] = self::unsanitize_title($key);
		}

		return $template_options;

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