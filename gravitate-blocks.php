<?php
/*
Plugin Name: Gravitate Blocks
Description: Create Content Blocks.
Version: 1.7.6
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


	private static $version = '1.7.6';
	private static $page = 'admin.php?page=gravitate-blocks';
	private static $settings = array();
	private static $option_key = 'gravitate_blocks_settings';
	private static $posts_to_exclude = array('attachment', 'revision', 'nav_menu_item', 'acf-field-group', 'acf-field');
	public static $current_block_name = '';
	public static $block_index = 0;
	private static $registered_sections = array(array());


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
		global $block;

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
				if(!empty($color_params['_repeater_id']))
				{
					$block_background_colors['block-bg-'.$color_params['_repeater_id']] = $color_params['name'];
				}
			}
		}
		$block_background_colors['block-bg-image'] = 'Image';
		$block_background_colors = apply_filters( 'grav_block_background_colors', $block_background_colors );

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
			// Filter the Link Options
			self::filter_layout_links($layouts, '', 'grav_link_fields');

			// Filter the Fields from developers
			$layouts = apply_filters( 'grav_block_fields', $layouts );

			$placement = (GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'after_title')) ? 'acf_after_title' : 'normal';

			$sections = array (
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
				'position' => $placement,
				'style' => 'no_box',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => self::hide_on_screen(),
				'active' => 1,
				'description' => '',
			);
			$sections = apply_filters('grav_default_section', $sections);
			acf_add_local_field_group($sections);
		}

	}

	public static function get_additional_fields(){
		global $block;
		$additional_fields = array();
		$unique_id_field = array (
			'key' => 'field_'.$block.'_unique_id',
			'label' => 'Unique ID',
			'name' => 'unique_id',
			'type' => 'text',
			'column_width' => '',
			'default_value' => '',
			'instructions' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'formatting' => 'none', 		// none | html
			'maxlength' => '',
		);
		if(class_exists('GRAV_BLOCKS_PLUGIN_SETTINGS') && GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'add_unique_id')){
			$additional_fields[] = $unique_id_field;
		}
		return $additional_fields;
	}

	public static function hide_on_screen(){
		$hidden = array();
		if(GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'hide_content')){
			$hidden[0] = 'the_content';
		}
		$hidden = apply_filters( 'grav_hide_on_screen', $hidden );
		return $hidden;
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
		}

		if(!is_admin())
		{
			if((!empty($_GET['s']) && GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('search_options', 'include_in_search')) || GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'filter_excerpt'))
			{
				self::add_hook('filter', 'get_the_excerpt', 'add_excerpt_filtering');
			}
		}

		if(GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'enqueue_scripts') ||
		   GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'add_responsive_img'))
		{
			self::add_hook('action', 'wp_footer', 'add_footer_js', 100);
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
				'advanced_options' => array('filter_content', 'enqueue_scripts'),
				'css_options' => array('enqueue_css', 'use_foundation', 'use_default'),
				'search_options' => array('include_in_search'),
				'background_colors' => array(
											array('name' => 'White', 'value' => '#ffffff'),
											array('name' => 'Light Gray', 'value' => '#eeeeee'),
											array('name' => 'Dark Gray', 'value' => '#555555')
										),
				'foundation' => array('f5'),
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
	        <p><?php _e( 'Gravitate Blocks - ACF Pro is required to run Gravitate Blocks<br>To download the plugin go here. <a target="_blank" href="http://www.advancedcustomfields.com/pro/">http://www.advancedcustomfields.com/pro/</a><br>To remove this message permanently either Install ACF Pro or Deactivate the Gravitate Blocks Plugin', 'GRAV_BLOCKS' ); ?></p>
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
		$icon = file_get_contents(plugin_dir_path( __FILE__ ) . 'grav-blocks/content/content_2.svg');
		add_menu_page( 'Gravitate Blocks', 'Blocks', 'manage_options', 'gravitate-blocks', array( __CLASS__, 'admin' ), 'dashicons-gravitate', 9999);
	}

	public static function plugin_settings_link($links)
	{
		$settings_link = '<a href="options-general.php?page=gravitate_blocks">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}

	public static function add_excerpt_filtering( $output )
	{
		if(empty($output) && !has_excerpt() && !get_the_content())
		{
			global $wpdb;

			// If is Search, then first check to see if we can find results that matches the search
			if(is_main_query() && get_search_query() && is_search() && GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('search_options', 'include_in_search'))
			{
				$results = $wpdb->get_var("SELECT meta_value FROM ".$wpdb->postmeta." WHERE meta_value LIKE '%".get_search_query()."%' AND meta_key NOT LIKE '\_%' AND post_id = ".get_the_ID()." ORDER BY CHAR_LENGTH(meta_value) DESC LIMIT 1");
			}

			// If no matches are found or if not Search then check for any fields to show data
			if(empty($results))
			{
				if(GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('search_options', 'include_in_search') || !is_search() || !is_main_query())
				{
					$results = $wpdb->get_var("SELECT meta_value FROM ".$wpdb->postmeta." WHERE meta_key NOT LIKE '\_%' AND post_id = ".get_the_ID()." ORDER BY CHAR_LENGTH(meta_value) DESC LIMIT 1");
				}
			}

			// If Results then lets format it
		    if(!empty($results))
	    	{
	    		$output = wp_trim_excerpt(strip_shortcodes(strip_tags($results)));
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
	 * @param string $args - Currently the two options for the array are 'section' and 'object'
	 *
	 * @return type
	 */
	public static function display($args = array())
	{
		// Check $args array if it exists and what is set.
		$section = (!empty($args) && isset($args['section'])) ? $args['section'] : 'grav_blocks';
		$object = (!empty($args) && isset($args['object'])) ? $args['object'] : false;
		$query_target = ($object) ? $object : ( ( ( $query = get_queried_object() ) && !empty($query->term_id ) ) ? $query : '');

		if(self::is_viewable())
		{

			$handler_file = self::get_path('handler.php');
			self::$block_index = 0;
			if($handler_file && get_field($section, $query_target))
			{

				while(the_flexible_field($section, $query_target))
				{
					self::$block_index++;
					$block_class_prefix = 'block';
					$unique_id = (GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'add_unique_id') && $uid = get_sub_field('unique_id')) ? 'id='.sanitize_title($uid).'' : '';
					self::$current_block_name = strtolower(str_replace('_', '-', get_row_layout()));

					$block_background = ($block_bg = get_sub_field('block_background')) ? $block_bg : 'block-bg-none';

					if(!empty(self::$settings['background_colors']))
					{
						foreach (self::$settings['background_colors'] as $color_key => $color_params)
						{
							$use_css_variable = (!empty($color_params['class']) && GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('css_options', 'add_custom_color_class'));

							if(!empty($color_params['_repeater_id']) && $block_background === 'block-bg-'.$color_params['_repeater_id'] && $use_css_variable)
							{
								if(!GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('css_options', 'enqueue_css'))
								{
									$block_background = '';
								}
								$block_background.= ' '.$color_params['class'];
							}
						}
					}

					$block_background_image = get_sub_field('block_background_image');

					$block_background_image_url = $block_background_image['url'];

					$block_section_attributes = '';

					$block_background_style = ($block_background === 'block-bg-image' && $block_background_image ? ' background-image: url(\''.$block_background_image_url.'\'); ' : '');

					if(GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'add_responsive_img'))
					{
						if($block_background === 'block-bg-image')
						{
							$block_section_attributes = GRAV_BLOCKS::image_sources($block_background_image);
							$block_background_style = '';
						}
					}

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
	 * Returns the specified setting for the block or array of all settings
	 *
	 * @param string $block - This is the name of the block folder to retrieve
	 * @param string $setting - This is the setting to retrieve
	 *
	 * @return array if no setting specified, string if setting is specified
	 */
	public static function get_block_settings($block='', $setting='')
	{
		if($path = self::get_path($block))
		{
			if(file_exists($path.'/block_fields.php'))
			{
				$fields = include($path.'/block_fields.php');
				$settings = ($setting === '') ? $fields['grav_blocks_settings'] : $fields['grav_blocks_settings'][$setting];

				return $settings;
			}
		}
		return false;
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
			    	$label = (!empty($fields['label'])) ? $fields['label'] : $block;
					$blocks[$block] = array('label' => $label, 'path' => $dir, 'group' => (!empty($fields['grav_blocks_settings']['group']) ? $fields['grav_blocks_settings']['group'] : 'default'));
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
			    	$label = (!empty($fields['label'])) ? $fields['label'] : $block;
					$blocks[$block] = array('label' => $label, 'path' => $dir, 'group' => (!empty($fields['grav_blocks_settings']['group']) ? $fields['grav_blocks_settings']['group'] : 'theme'));
				}
			}
		}



		// Apply Filters to allow others to filter the blocks used.
		$filterd_blocks = apply_filters( 'grav_blocks', $blocks );

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
			else if(file_exists(get_template_directory().'/grav-blocks/'.str_replace('-', '_', $path)))
			{
				return get_template_directory().'/grav-blocks/'.str_replace('-', '_', $path);
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
					'filter_excerpt' => 'Filter the_excerpt() with Block Fields (all postmeta fields) when the_excerpt() or the_content() is empty.',
					'enqueue_scripts' => 'Add necessary jQuery plugins. <span class="extra-info">( adds Cycle2 and Colorbox scripts for sliders and lightbox )</span>',
					'after_title' => 'Place Gravitate Blocks directly after the title in the WordPress admin. <span class="extra-info">( changes position using acf_after_title )</span>',
					'hide_content' => 'Remove the WordPress content box from Gravitate Blocks enabled pages. <span class="extra-info">( if content has already been entered it may still show on the front end of the website. )</span>',
					'add_unique_id' => 'Add a field for a unique id for each block. <span class="extra-info">( This allows you to use the #unique-id in a url to anchor to a specific spot on a page. )</span>',
					'add_responsive_img' => 'Add "Responsive-Images" JS. This will also include data attributes for all image sizes.',
				);
				$css_options = array(
					'add_custom_color_class' => 'Allow customization of CSS class names for the background color options.',
					'disable_colorpicker' => 'Disable color picker ( Use this to force your own css class names ).',
					'enqueue_css' => 'Background color CSS will be added to the website\'s header. <span class="extra-info">( Needed for custom background colors, images, etc. )</span>',
					'use_default' => 'Use the default Gravitate Blocks CSS. <span class="extra-info">( Affects padding and some basic styling. )</span>',
					'use_foundation' => 'Use the <a target="_blank" href="http://foundation.zurb.com/sites/docs/">Foundation</a> CSS grid. <span class="extra-info">( This will add the foundation CSS file to your site. )</span>',
				);
				$foundation_options = array(
					'f5' => '<a href="http://foundation.zurb.com/sites/docs/v/5.5.3/" target="_blank">5.5.3</a>',
					'f6' => '<a href="http://foundation.zurb.com/sites/docs/grid.html" target="_blank">6.2.0</a>',
					'f6flex' => '<a href="http://foundation.zurb.com/sites/docs/flex-grid.html" target="_blank">6.2.0</a> <span class="extra-info">( flex grid )</span>',
				);

				$search_options = array(
					'include_in_search' => 'Includes Block Fields (all postmeta fields) in the search criteria.',
				);

				$fields = array();
				$fields['advanced_options'] = array('type' => 'checkbox', 'label' => 'Advanced Options', 'options' => $advanced_options, 'description' => '');
				$fields['css_options'] = array('type' => 'checkbox', 'label' => 'CSS Settings', 'options' => $css_options, 'description' => '');
				$fields['foundation'] = array('type' => 'radio', 'label' => 'Foundation Version', 'options' => $foundation_options, 'description' => 'If you are using the foundation grid, this will determine which version of the grid to use.');
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
					foreach($blocks as $block_slug => $block_label)
					{
						if($block_settings = self::get_block_settings($block_slug))
						{
							$block_settings['label'] = $block_label;
							$blocks[$block_slug] = $block_settings;
						}
					}
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
	 * Gets current version of foundation
	 *
	 *
	 * @return
	 */
	public static function get_foundation_version()
	{
		$foundation_version = GRAV_BLOCKS_PLUGIN_SETTINGS::get_setting_value('foundation', 0);
		return $foundation_version;
	}

	/**
	 * Gets current version of foundation
	 *
	 *
	 * @return
	 */
	public static function get_foundation_file_name()
	{
		$foundation_version = self::get_foundation_version();
		switch ($foundation_version){
			case 'f5':
				$foundation_file_name = 'foundation5';
				break;

			case 'f6':
				$foundation_file_name = 'foundation6';
				break;

			default:
			case 'f6flex':
				$foundation_file_name = 'foundation6flex';
				break;

		}
		return $foundation_file_name;
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
		<?php add_thickbox(); ?>
		<div class="wrap grav-blocks">
			<header>
				<h1><img itemprop="logo" src="//uploads.gravitatedesign.com/2016/03/27080812/grav_logo.png" alt="Gravitate"> Blocks</h1>
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
		include_once('library/includes/developer.php');
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

		wp_enqueue_style( 'grav_blocks_admin_css', plugin_dir_url( __FILE__ ) . 'library/css/master.css', true, '1.0.0' );
		wp_enqueue_style( 'grav_blocks_icons_css', 'https://i.icomoon.io/public/790bec4572/GravitateBlocks/style.css', true, '1.1.0' );
		if ( 'toplevel_page_gravitate-blocks' != $hook ) {
	        return;
	    }
    	wp_enqueue_script( 'grav_blocks_scripts_js', plugin_dir_url( __FILE__ ) . 'library/js/blocks.min.js', array('jquery'), self::$version, true );
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
		if (GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'enqueue_scripts') && self::is_viewable())
		{
			wp_enqueue_script( 'grav_blocks_scripts_js', plugin_dir_url( __FILE__ ) . 'library/js/blocks.min.js', array('jquery'), self::$version, true );
		}
		if (GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'add_responsive_img'))
		{
			wp_enqueue_script( 'grav_blocks_scripts_js', plugin_dir_url( __FILE__ ) . 'library/js/responsive-images.min.js', array('jquery'), self::$version, true );
		}
		if (GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('css_options', 'use_foundation') && self::is_viewable())
		{
			$foundation_file = self::get_foundation_file_name();
			wp_enqueue_style( 'foundation_css', plugin_dir_url( __FILE__ ) . 'library/css/'.$foundation_file.'.css' , array(), '6.0.0');
		}
		if (GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('css_options', 'use_default') && self::is_viewable())
		{
			wp_enqueue_style( 'default_css', plugin_dir_url( __FILE__ ) . 'library/css/default.css' , array(), self::$version);
		}

	}

	/**
	 * Add any necessary JS to footer
	 *
	 * @param
	 *
	 * @return
	 */
	public static function add_footer_js(){
		?>
			<script>
				jQuery(function($){
					$(document).ready(function(){



					<?php if(GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'enqueue_scripts')){ ?>

						$('.block-link-video').colorbox({iframe:true, height:'80%', width:'80%'});
						$('.block-link-gallery').colorbox({rel:'block-link-gallery', iframe:true, height:'80%', width:'80%', transition:'fade'});
						$('.grav-inline').colorbox({inline: true, height:'80%', width:'80%', transition:'fade'});

					<?php } ?>



					<?php if(GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'add_responsive_img')){

						$image_sizes = array();
						foreach (self::get_image_sizes() as $name => $image)
						{
							// Only include sizes that are not cropped.
							if(empty($image['crop']) && $image['width'])
							{
								$image_sizes[$name] = $image['width'];
							}
						}

						// Sort Sizes from smallest to largest by width
						asort($image_sizes);

						// Create json format for jquery
						$image_sizes_array = array();
						foreach ($image_sizes as $name => $width)
						{
							$image_sizes_array[] = array('name' => $name, 'size' => $width);
						}

						$image_sizes_array[] = array('name' => 'full', 'size' => 99999);

						$responsive_image_settings = array(
							'watch' => 'tag',
							'throttle' => 100,
							'downscale' => false,
							'downsize' => false,
							'onload' => true,
							'lazyload' => true,
							'lazyload_threshold' => 400,
							'sizes' => $image_sizes_array
						);

						$filtered_responsive_image_settings = apply_filters( 'grav_blocks_responsive_image_settings', $responsive_image_settings );

						?>

						$(this).responsiveImages(<?php echo json_encode($filtered_responsive_image_settings);?>);

					<?php } ?>



					});
				});
			</script>
		<?php
	}



	/**
	 * Check if blocks are viewable on the front end
	 *
	 * @param none
	 *
	 * @return boolean
	 */
	public static function is_viewable(){
		$is_viewable = false;
		$post_id = ( ($query = get_queried_object()) && !empty($query->ID) ) ? $query->ID : false;
		if( $post_id )
		{

			$locations = self::get_locations('viewable');

			if(!empty($locations['post_types']))
			{
				if(is_singular() && in_array(get_post_type(), $locations['post_types'])){
					$is_viewable = true;
				}
			}
			if(!empty($locations['templates']))
			{
				$is_default = (get_page_template_slug($post_id) == '' && in_array('default', $locations['templates']));
				if($is_default || in_array(get_page_template_slug($post_id), $locations['templates'])){
					$is_viewable = true;
				}
			}
		}
		$is_viewable = apply_filters( 'grav_is_viewable', $is_viewable );
		return $is_viewable;
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


		$posts = get_post_types();
		$post_types = array();

		foreach($posts as $post_type)
		{
			if(!in_array($post_type, self::$posts_to_exclude))
			{
				$post_types[$post_type] = self::unsanitize_title($post_type);
			}
		}

		// TODO add filter here for $post_types

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


	/**
	 * Converts a URL to a verified Vimeo ID
	 *
	 * @param  $url  (string) Url of a defined Vimeo Video.
	 *
	 * @return (int)
	 * @author GG
	 *
	 **/
	public static function get_vimeo_id($url)
	{
		preg_match('/([0-9]+)/', $url, $matches);
		if(!empty($matches[1]) && is_numeric($matches[1]))
		{
			return $matches[1];
		}
		else if(!$pos && strpos($url, 'http') === false)
		{
			return $url;
		}
		return 0;
	}
	/**
	 * onverts a URL to a verified YouTube ID
	 *
	 * @param  $url  (string) Url of a defined Youtube Video.
	 *
	 * @return (int)
	 * @author GG
	 *
	 **/
	public static function get_youtube_id($url)
	{
		if(!$pos = strpos($url, 'youtu.be/'))
		{
			$pos = strpos($url, '/watch?v=');
		}
		if($pos)
		{
			$split = explode("?", substr($url, ($pos+9)));
			$split = explode("&", $split[0]);
			return $split[0];
		}
		else if($pos = strpos($url, '/embed/'))
		{
			$split = explode("?", substr($url, ($pos+7)));
			return $split[0];
		}
		else if($pos = strpos($url, '/v/'))
		{
			$split = explode("?", substr($url, ($pos+3)));
			return $split[0];
		}
		else if(!$pos && strpos($url, 'http') === false)
		{
			return $url;
		}
		return 0;
	}
	/**
	 * Converts a URL to a verified YouTube video ID function
	 *
	 * @param  $url  (string) Url of a defined Youtube Video.
	 *
	 * REQUIRES: function grav_get_youtube_id()
	 *
	 * @return (str)
	 * @author GG
	 *
	 **/
	public static function get_video_url($url)
	{
		$autoplay = 1;
		if(strpos($url, 'autoplay=0') || strpos($url, 'autoplay=false'))
		{
			$autoplay = 0;
		}
		if(strpos($url, 'vimeo'))
		{
			$id = self::get_vimeo_id($url);
			if(is_numeric($id))
			{
				return 'https://player.vimeo.com/video/'.$id.'?autoplay='.$autoplay;
			}
			return $url;
		}
		$id = self::get_youtube_id($url);
		if($id)
		{
			$link = 'https://www.youtube.com/embed/'.$id.'?rel=0&amp;iframe=true&amp;wmode=transparent&amp;autoplay='.$autoplay;
			return $link;
		}
		return '';
	}

	public static function column_width_options()
	{
		$column_width_options = array(
			2 => 'Small',
			5 => 'Medium',
			6 => 'Half',
			8 => 'Large',
		);

		// allow filtering of column sizes for the media with content block
		$filtered_column_width_options = apply_filters( 'grav_column_widths', $column_width_options );

		return $filtered_column_width_options;
	}


	/**
	 * Converts a single array of link options into multiple fields
	 *
	 * @param  $label, $includes, $show_text
	 *
	 * @return array
	 * @author GG & BF
	 *
	 **/
	public static function get_link_fields($label = 'link', $includes = array(), $show_text = true, $post_types = array(0 => 'all'))
	{
		global $block;

		$allowed_options = array(
			'none' => 'None',
			'page' => 'Page Link',
			'url' => 'URL',
			'file' => 'File Download',
			'video' => 'Play Video',
		);
		$allowed_fields = (!empty($includes)) ? array() : $allowed_options;

		if(!empty($includes)){
			foreach($includes as $include_key => $include){
				// Allow the Dev to change the Label
				if(!is_numeric($include_key) && isset($allowed_options[$include_key]))
				{
					$allowed_fields[$include_key] = $include;
				}
				else  // Use Default Label
				{
					$allowed_fields[$include] = $allowed_options[$include];
				}
			}
		}

		$label_title = ucwords($label);
		$label_sanitized = sanitize_title($label);
		$fields = array();

		$fields[] = array (
			'key' => 'field_'.$block.'_'.$label_sanitized.'_type',
			'label' => $label_title.' Type',
			'name' => $label_sanitized.'_type',
			'type' => 'radio',
			'layout' => 'horizontal',
			'column_width' => '',
			'choices' => $allowed_fields,
			'default_value' => '',
			'allow_null' => 0,
			'multiple' => 0,
		);
		if($show_text){
			$fields[] = array (
				'key' => 'field_'.$block.'_'.$label_sanitized.'_text',
				'label' => $label_title.' Text',
				'name' => $label_sanitized.'_text',
				'type' => 'text',
				'required' => 1,
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_'.$block.'_'.$label_sanitized.'_type',
							'operator' => '!=',
							'value' => 'none',
						),
					),
					'allorany' => 'all',
				),
				'column_width' => '',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			);
		}

		if(isset($allowed_fields['url']))
		{
			$fields[] = array (
				'key' => 'field_'.$block.'_'.$label_sanitized.'_url',
				'label' => $allowed_fields['url'],
				'name' => $label_sanitized.'_url',
				'type' => 'text',
				'required' => 1,
				'conditional_logic' => array (
					array (
						array (
							'field' => 'field_'.$block.'_'.$label_sanitized.'_type',
							'operator' => '==',
							'value' => 'url',
						),
					),
				),
				'column_width' => '',
				'default_value' => '',
				'placeholder' => 'http://',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			);
		}

		if(isset($allowed_fields['page']))
		{
			$fields[] = array (
				'key' => 'field_'.$block.'_'.$label_sanitized.'_page',
				'label' => $allowed_fields['page'],
				'name' => $label_sanitized.'_page',
				'type' => 'page_link',
				'required' => 1,
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_'.$block.'_'.$label_sanitized.'_type',
							'operator' => '==',
							'value' => 'page',
						),
					),
					'allorany' => 'all',
				),
				'column_width' => '',
				'post_type' => $post_types,
				'allow_null' => 0,
				'multiple' => 0,
			);
		}

		if(isset($allowed_fields['file']))
		{
			$fields[] = array (
				'key' => 'field_'.$block.'_'.$label_sanitized.'_file',
				'label' => $allowed_fields['file'],
				'name' => $label_sanitized.'_file',
				'type' => 'file',
				'required' => 1,
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_'.$block.'_'.$label_sanitized.'_type',
							'operator' => '==',
							'value' => 'file',
						),
					),
					'allorany' => 'all',
				),
				'column_width' => '',
				'save_format' => 'url',
				'library' => 'all',
			);
		}

		if(isset($allowed_fields['video']))
		{
			$fields[] = array (
				'key' => 'field_'.$block.'_'.$label_sanitized.'_video',
				'label' => $allowed_fields['video'],
				'name' => $label_sanitized.'_video',
				'type' => 'text',
				'required' => 1,
				'instructions' => 'This works for Vimeo or Youtube. Just paste in the url to the video you want to show.',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_'.$block.'_'.$label_sanitized.'_type',
							'operator' => '==',
							'value' => 'video',
						),
					),
					'allorany' => 'all',
				),
				'column_width' => '',
				'default_value' => '',
				'placeholder' => 'http://',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			);
		}

		$filtered_fields = apply_filters('grav_block_link_fields', $fields);
		return array('grav_link_fields' => $filtered_fields);
	}

	public static function get_link_url($field)
	{
		// TODO make this a public filterable array
		$allowed_options = array(
			'none' => 'None',
			'page' => 'Page Link',
			'url' => 'URL',
			'file' => 'File Download',
			'video' => 'Play Video',
		);
		if($type = get_sub_field($field.'_type'))
		{
			if($type != 'none')
			{
				$url = get_sub_field($field.'_'.$type);
				if(!array_key_exists($type, $allowed_options))
				{
					$url = get_sub_field($field.'_url');
				}
				if($type == 'video')
				{
					$url = self::get_video_url($url);
				}
				return esc_url($url);
			}
		}
		return '';
	}

	public static function get_link_html($field, $class='')
	{
		$url = ($type_url = self::get_link_url($field)) ? $type_url : '#';
		if($text = get_sub_field($field.'_text'))
		{
			?>
				<a class="block-link-<?php echo esc_attr(get_sub_field($field.'_type'));?><?php echo ($class ? ' '.$class : '');?>" href="<?php echo esc_url($url);?>"><?php echo esc_html($text);?></a>
			<?php
		}
	}

	public static function filter_layout_links(&$item, $key='', $lookup='')
	{
	    if(!empty($item) && is_array($item))
	    {
	        foreach ($item as $k => $v)
	        {
	            if(is_array($v) && isset($v[$lookup]))
	            {
	                array_splice($item, array_search($k, array_keys($item)), 1, $v[$lookup]);
	            }
	        }
	        array_walk($item, array(__CLASS__, __METHOD__), $lookup);
	    }
	}




	/**
	* Get size information for all currently-registered image sizes.
	*
	* @global $_wp_additional_image_sizes
	* @uses   get_intermediate_image_sizes()
	* @return array $sizes Data for all currently-registered image sizes.
	*/
	public static function get_image_sizes()
	{
		global $_wp_additional_image_sizes;

		$sizes = array();

		foreach ( get_intermediate_image_sizes() as $_size )
		{
			if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
				$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
				$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
				$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
			}
			elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) )
			{
				$sizes[ $_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
				);
			}
		}

		return $sizes;
	}



	public static function image_sources($image='featured', $return_as_array=false)
	{
		$sources = array();

		if(is_numeric($image) && get_post_type($image) !== 'attachment')
		{
			$image = get_post_thumbnail_id($image);
		}

		if($image === 'featured')
		{
			$image = get_post_thumbnail_id();
		}

		if(is_numeric($image) || !empty($image['sizes']))
		{
			$image_sizes = self::get_image_sizes();

			if(is_numeric($image))
			{
				foreach ($image_sizes as $size => $image_size)
				{
					// Only include sizes that are not cropped.
					if(empty($image_size['crop']) && $image_size['width'])
					{
						if($url = wp_get_attachment_image_src( $image, $size ))
						{
							$sources['data-rimg-'.$size] = '"'.$url[0].'"';
						}
					}
				}
			}
			else
			{
				foreach ($image['sizes'] as $size => $url)
				{
					if(!preg_match('/\-width|\-height/i', $size) && isset($image_sizes[$size]['crop']) && empty($image_sizes[$size]['crop']))
					{
						$sources['data-rimg-'.$size] = '"'.$url.'"';
					}
				}
			}
		}

		if($return_as_array)
		{
			return $sources;
		}

		return trim(urldecode(http_build_query($sources, '', ' ')));
	}



	public static function image($image='featured', $additional_attributes=array(), $tag_type='img')
	{
		if(empty($image)){
			return '';
		}
		if($image === 'featured')
		{
			if(is_numeric($image) && get_post_type($image) !== 'attachment')
			{
				$attachment = get_post(get_post_thumbnail_id($image));
			}
			else
			{
				$attachment = get_post(get_post_thumbnail_id());
			}

			if($attachment)
			{
				$image = array(
					'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
					'caption' => $attachment->post_excerpt,
					'description' => $attachment->post_content,
					'href' => get_permalink( $attachment->ID ),
					'src' => $attachment->guid,
					'url' => $attachment->guid,
					'title' => $attachment->post_title
				);

				if(GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'add_responsive_img'))
				{
					$image['sizes'] = array();

					foreach (self::get_image_sizes() as $size => $image_size)
					{
						// Only include sizes that are not cropped.
						if(empty($image_size['crop']) && $image_size['width'])
						{
							if($url = wp_get_attachment_image_src( $attachment->ID, $size ))
							{
								$image['sizes'][$size] = $url[0];
							}
						}
					}

				}
			}
			else
			{
				return '';
			}
		}

		if($tag_type === 'img' && !isset($additional_attributes['alt']) && !empty($image['alt']))
		{
			$additional_attributes['alt'] = esc_attr($image['alt']);
		}

		if(!isset($additional_attributes['title']) && !empty($image['title']))
		{
			$additional_attributes['title'] = esc_attr($image['title']);
		}

		$image_sources = array();

		if(GRAV_BLOCKS_PLUGIN_SETTINGS::is_setting_checked('advanced_options', 'add_responsive_img'))
		{
			$additional_attributes['src'] = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';

			$image_sources = self::image_sources($image, true);
		}
		else if($tag_type === 'img' && !isset($additional_attributes['src']))
		{
			if(!empty($image['sizes']['large']))
			{
				$additional_attributes['src'] = $image['sizes']['large'];
			}
			else if(!empty($image['url']))
			{
				$additional_attributes['src'] = $image['sizes']['url'];
			}
		}

		$additional_attributes = array_filter($additional_attributes);

		foreach ($additional_attributes as $attribute_key => $attribute_value)
		{
			$additional_attributes[$attribute_key] = '"'.esc_attr($attribute_value).'"';
		}

		$attributes_array = array_filter(array_merge($image_sources, $additional_attributes));

		// If not ALt then add an empty one for validation
		if($tag_type === 'img' && empty($additional_attributes['alt']))
		{
			$attributes_array['alt'] = '""';
		}

		$attributes_str = trim(urldecode(http_build_query($attributes_array, '', ' ')));


		if($attributes_str)
		{
			if($tag_type === 'div')
			{
				return '<div '.$attributes_str.'></div>';
			}
			else
			{
				return '<img '.$attributes_str.' />';
			}
		}

		return '';
	}

}
