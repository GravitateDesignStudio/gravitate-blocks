<?php
/*
Plugin Name: Gravitate Content Blocks
Description: Create Content Blocks.
Version: 1.0.0
Plugin URI: http://www.gravitatedesign.com
Author: Gravitate
*/

register_activation_hook( __FILE__, array( 'GRAVITATE_CONTENT_BLOCKS', 'activate' ));
register_deactivation_hook( __FILE__, array( 'GRAVITATE_CONTENT_BLOCKS', 'deactivate' ));

add_action('admin_menu', array( 'GRAVITATE_CONTENT_BLOCKS', 'admin_menu' ));
add_action('admin_init', array( 'GRAVITATE_CONTENT_BLOCKS', 'admin_init' ));
add_action('init', array( 'GRAVITATE_CONTENT_BLOCKS', 'init' ));



class GRAVITATE_CONTENT_BLOCKS {

	private static $version = '1.0.0';
	private static $page = 'options-general.php?page=gravitate_blocks';
	private static $settings = array();
	private static $option_key = 'gravitate_blocks_settings';

	public static function init()
	{
		// Nothing for now
		// self::get_settings();
		// grav_dump(self::$settings);
	}

	public static function activate()
	{
		// Nothing for now
	}

	public static function deactivate()
	{
		// Nothing for now
	}

	public static function admin_init()
	{
		// Nothing for now
	}

	public static function admin_menu()
	{
		add_submenu_page( 'options-general.php', 'Gravitate Blocks', 'Gravitate Blocks', 'manage_options', 'gravitate_blocks', array( __CLASS__, 'admin' ));
	}

	public static function get_handler_template()
	{
		if($handler && file_exists(get_template_directory().'/grav-blocks/handler.php'))
		{
			return get_template_directory().'/grav-blocks/handler.php';
		}
		else if(file_exists(plugin_dir_path( __FILE__ ).'grav-blocks/handler.php'))
		{
			return plugin_dir_path( __FILE__ ).'grav-blocks/handler.php';
		}
	}

	public static function get_handler_path($handler='')
	{
		$template = self::get_handler_template();

		if(get_field($handler))
		{
			while(the_flexible_field($handler))
			{
				$block_class_prefix = 'block';
				$block_name = strtolower(str_replace('_', '-', get_row_layout()));
				$block_background = get_sub_field('block_background');
				$block_background_image = get_sub_field('block_background_image');
				$block_background_style = (get_sub_field('block_background') == 'image' && $block_background_image ? ' style="background-image: url(\''.$block_background_image['large'].'\');" ' : '');
				?>

				<section class="<?php echo $block_class_prefix;?>-container <?php echo $block_class_prefix;?>-<?php echo $block_name;?> <?php echo $block_background;?>" <?php echo $block_background_style;?>>

					<?php
						$layout = strtolower(str_replace('_', '-', get_row_layout()));
						GRAVITATE_CONTENT_BLOCKS::get_block($layout);
					?>

				</section>

				<?php
			}
		}
	}

	public static function get_block($block='')
	{
		$path = self::get_block_path($block);
		if($handler && file_exists($path.'/html.php'))
		{
			include($path.'/html.php');
		}
		else
		{
			// Error
		}
	}

	public static function get_block_path($block='')
	{
		if($block && is_dir(get_template_directory().'/grav-blocks/'.$block.'/'))
		{
			return get_template_directory().'/grav-blocks/'.$block;
		}
		else
		{
			if(is_dir(plugin_dir_path( __FILE__ ).'grav-blocks/'.$block.'/'))
			{
				return plugin_dir_path( __FILE__ ).'grav-blocks/'.$block;
			}
		}
	}

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

	private static function get_settings_fields()
	{
		$posts_to_exclude = array('attachment', 'revision', 'nav_menu_item', 'acf-field-group', 'acf-field');
		// TODO add filter here for $posts_to_exclude

		$posts = get_post_types();
		$templates = get_page_templates();

		$post_types = array();
		foreach($posts as $post_type){
			if(!in_array($post_type, $posts_to_exclude)){
				$post_types[$post_type] = self::unsanitize_title($post_type);
			}
		}

		$template_options = array('default' => 'Default');
		foreach($templates as $key => $template){
			$template_options[$template] = self::unsanitize_title($key);
		}

		$fields = array();
		$fields['post_types'] = array('type' => 'checkbox', 'label' => 'Post Types', 'options' => $post_types, 'description' => 'Choose what post types you want to have the Gravitate Blocks.');
		$fields['templates'] = array('type' => 'checkbox', 'label' => 'Templates', 'options' => $template_options, 'description' => 'Choose what templates you want to have the Gravitate Blocks.');

		self::get_settings();

		// Update Values in Form
		if(!empty(self::$settings))
		{
			foreach (self::$settings as $key => $value)
			{
				if(isset($fields[$key]))
				{
					$fields[$key]['value'] = $value;
				}
			}
		}

		return $fields;
	}

	private static function get_advanced_settings_fields()
	{
		$advanced_options = array(
			'foundation' => 'Use Foundation 5 CSS.',
			'content' => 'Add content blocks to the end of your content.'
		);

		$fields = array();
		$fields['advanced_options'] = array('type' => 'checkbox', 'label' => 'Advanced Options', 'options' => $advanced_options, 'description' => 'Change Advanced Settings.');

		self::get_settings();

		// Update Values in Form
		if(!empty(self::$settings))
		{
			foreach (self::$settings as $key => $value)
			{
				if(isset($fields[$key]))
				{
					$fields[$key]['value'] = $value;
				}
			}
		}

		return $fields;
	}

	private static function get_settings($force=false)
	{
		if(empty(self::$settings) || $force)
		{
			self::$settings = get_option(self::$option_key);
		}
	}

	private static function save_settings()
	{
		if(!empty($_POST['save_settings']) && !empty($_POST['settings']))
		{
			$_POST['settings']['updated_at'] = time();

			$settings = $_POST['settings'];

			if(!empty(self::$settings))
			{
				$settings = array_merge(self::$settings, $settings);
			}

			if(update_option( self::$option_key, $settings ))
			{
				self::get_settings(true);
				return 'Settings Saved Successfully';
			}
		}

		return false;
	}

	public static function admin()
	{
		// Get Settings
		self::get_settings(true);

		// Save Settings if POST
		self::save_settings();

		?>

		<div class="wrap">
		<h2>Gravitate Blocks</h2>
		<h4 style="margin: 6px 0;">Version <?php echo self::$version;?></h4>
		<?php if(!empty($error)){?><div class="error"><p><?php echo $error; ?></p></div><?php } ?>
		</div>

		<br>
		<div class="gravitate-redirects-page-links">
			<a href="<?php echo self::$page;?>&section=General">General</a>
			<a href="<?php echo self::$page;?>&section=advanced">Advanced</a>
		</div>

		<br>
		<br>

		<?php

		$section = (!empty($_GET['section']) ? $_GET['section'] : 'settings');

		switch($section)
		{
			default:
			case 'settings':
				self::settings();
			break;

			case 'advanced':
				self::settings('advanced');

			case 'add':
				self::add();
			break;

			case 'top':
				self::top();
			break;
		}
	}

	private static function add()
	{
		?>


		<?php
	}

	private static function settings($type = 'general')
	{
		// Get Form Fields
		switch ($type){
			default;
			case 'general':
				$fields = self::get_settings_fields();
				break;

			case 'advanced':
				$fields = self::get_advanced_settings_fields();
				break;
		}


		?>
			<form method="post">
				<input type="hidden" name="save_settings" value="1">
				<table class="form-table">
				<?php
				foreach($fields as $meta_key => $field)
				{
					?>
					<tr>
						<th><label for="<?php echo $meta_key;?>"><?php echo $field['label'];?></label></th>
						<td>
						<?php
						if(isset($field['description']))
						{ ?><span class="description"><?php echo $field['description'];?></span><br><?php }

						if($field['type'] == 'text')
						{
							?><input type="text" name="settings[<?php echo $meta_key;?>]" id="<?php echo $meta_key;?>"<?php echo (isset($field['maxlength']) ? ' maxlength="'.$field['maxlength'].'"' : '');?> value="<?php echo esc_attr( (isset($field['value']) ? $field['value'] : '') );?>" class="regular-text" /><br /><?php
						}
						else if($field['type'] == 'textarea')
						{
							?><textarea rows="6" cols="38" name="settings[<?php echo $meta_key;?>]" id="<?php echo $meta_key;?>"><?php echo esc_attr( (isset($field['value']) ? $field['value'] : '') );?></textarea><br /><?php
						}
						else if($field['type'] == 'select')
						{
							?>
							<select name="settings[<?php echo $meta_key;?>]" id="<?php echo $meta_key;?>">
							<?php
							foreach($field['options'] as $option_value => $option_label){
								$real_value = ($option_value !== $option_label && !is_numeric($option_value) ? $option_value : $option_label);
								?>
								<option<?php echo ($real_value !== $option_label ? ' value="'.$real_value.'"' : '');?> <?php selected( ($real_value !== $option_label ? $real_value : $option_label), esc_attr( (isset($field['value']) ? $field['value'] : '') ));?>><?php echo $option_label;?></option>
								<?php
							} ?>
							</select>
							<?php
						}
						else if($field['type'] == 'checkbox')
						{
							foreach($field['options'] as $option_value => $option_label){
								$real_value = ($option_value !== $option_label && !is_numeric($option_value) ? $option_value : $option_label);
								if($fields[$meta_key]['value']){
									$checked = (in_array($real_value, $fields[$meta_key]['value'])) ? 'checked' : '';
								} else { $checked = ''; }
								?>
								<input type="checkbox" name="settings[<?php echo $meta_key;?>][]" value="<?php echo $option_value; ?>" <?php echo $checked; ?>><?php echo $option_label; ?><br>
								<?php
							}
						}
						 ?>
						</td>
					</tr>
					<?php
				}
				?>
				</table>
				<p><input type="submit" value="Save Settings" class="button button-primary" id="submit" name="submit"></p>
			</form>
		<?php

	}

	public static function unsanitize_title($title)
	{
		return ucwords(str_replace(array('_', '-'), ' ', $title));
	}
}