<?php
/*
* Gravitate Plugin Settings File
* Version: 1.0.0
*
*/


if(function_exists('add_action'))
{
	add_action( 'admin_enqueue_scripts', array('GRAV_BLOCKS_PLUGIN_SETTINGS', 'add_sortable') );
}

class GRAV_BLOCKS_PLUGIN_SETTINGS
{
	private static $option_key = '';
	private static $settings = array();

	/**
	 * Constructor for the class.
	 *
	 * @param string $option_key - key of the wp_options to store the settings
	 *
	 * @return void
	 */
	public function __construct($option_key)
	{
		self::$option_key = $option_key;
	}

	public static function add_sortable()
	{
		wp_enqueue_script( 'jquery-ui-sortable' );
	}

	/**
	 * Formats the fields to include values
	 *
	 * @param string $fields - fields to be filtered
	 *
	 * @return array
	 */
	public static function format_fields($fields)
	{
		self::get_settings();

		// Update Values in Form
		if(!empty(self::$settings))
		{
			foreach (self::$settings as $key => $value)
			{
				if(isset($fields[$key]))
				{
					if($fields[$key]['type'] == 'repeater' && is_array($value))
					{
						$rep_original_fields = $fields[$key]['fields'];

						$rep_original_fields['_repeater_id'] = array('type' => 'repeater_id');

						foreach ($value as $rep_i => $rep_values)
						{
							$fields[$key]['fields'][$rep_i] = $rep_original_fields;

							foreach ($rep_original_fields as $rep_key => $rep_value)
							{
								if(isset($rep_values[$rep_key]))
								{
									$fields[$key]['fields'][$rep_i][$rep_key]['value'] = $rep_values[$rep_key];
								}
							}
						}
					}
					else
					{
						$fields[$key]['value'] = $value;
					}
				}
			}
		}

		return $fields;
	}

	/**
	 * Returns the Settings from the Database
	 *
	 * @param string $force - Forces a database call incase it was stored.
	 *
	 * @return array
	 */
	public static function get_settings($force=false)
	{
		if(empty(self::$settings) || $force)
		{
			self::$settings = get_option(self::$option_key);
		}
		return self::$settings;
	}

	/**
	 * Returns true if a specific setting is set
	 *
	 * @param string $setting_type - The type of setting you want to check such as 'advanced_options'
	 * @param string $setting - The specific setting you want to check
	 *
	 * @return boolean
	 */
	public static function is_setting_checked($setting_type = '', $setting = ''){
		self::get_settings(true);
		if(isset(self::$settings[$setting_type]) && is_array(self::$settings[$setting_type]) && in_array($setting, self::$settings[$setting_type]))
		{
			return true;
		}
		return false;
	}

	/**
	 * Returns setting if value is set
	 *
	 * @param string $setting_type - The type of setting you want to check such as 'advanced_options'
	 * @param string $setting_position - The key position for the array you want to check
	 *
	 * @return boolean
	 */
	public static function get_setting_value($setting_type = '', $setting_key = ''){
		self::get_settings(true);
		$setting = (!empty(self::$settings[$setting_type])) ? self::$settings[$setting_type] : false;
		if($setting_key !== ''){
			$setting = (!empty(self::$settings[$setting_type][$setting_key])) ? self::$settings[$setting_type][$setting_key] : false;
		}
		return $setting;
	}

	/**
	 * Saved the Settings to the Database when the form was submitted
	 *
	 * @return array
	 */
	public static function save_settings()
	{
		if(!empty($_POST['save_grav_settings']) && !empty($_POST['settings']) && check_admin_referer(self::$option_key))
		{
			$_POST['settings']['updated_at'] = time();

			$settings = $_POST['settings'];

			foreach ($settings as $setting => $value)
			{
				if(isset($value[0]) && is_array($value[0])) // If is Repeater
				{
					unset($settings[$setting][0]);
					//sort($settings[$setting]);
				}
			}

			if(!empty(self::$settings))
			{
				$settings = array_merge(self::$settings, $settings);
			}

			$settings['grav_settings_last_updated'] = time();

			if(update_option( self::$option_key, $settings))
			{
				self::get_settings(true);
				return array('error' => null, 'success' => true);
			}
			else
			{
				array('error' => true, 'success' => null);
			}
		}

		return array('error' => null, 'success' => null);
	}

	/**
	 * Outputs the Form to the HTML
	 *
	 * @param string $fields - fields to render
	 *
	 * @return void
	 */
	public static function get_form($fields)
	{

		$fields = self::format_fields($fields);

		?>

			<style>
				/******* Set Default Styling ******/
				.grav-plugin-settings-form .repeater-item {
					border: 1px solid #bbb;
				}
				.grav-plugin-settings-form .repeater-item td {
					background-color: rgba(255,255,255,0.6);
					border-bottom: 1px solid #bbb;
				}
				.repeater-placeholder {
					display: none;
				}
				.grav-plugin-settings-field-colorpicker .wp-picker-container {
					min-width: 250px;
				}
				.wp-picker-holder {
					position: absolute;
					z-index: 1;
				}
				.repeater-item.ui-sortable-helper {
					left: 0 !important;
				}
				.repeater-table .ui-sortable {
					position: relative !important;
					border: 2px solid #ddd;
				}
				.ui-sortable-placeholder {
					height: 97px;
				}
				.repeater-table td.handle {
					position: relative;
					cursor: pointer;
				}
				.repeater-table td.handle:before, .repeater-table td.handle:after {
					content:'';
					width: 10px;
					height: 2px;
					background-color: #bbb;
					top: 48%;
					left: 12px;
					display: block;
					border-radius: 3px;
					position: absolute;
				}
				.repeater-table td.handle:after {
					top: 52%;
				}
			</style>

			<form method="post" class="grav-plugin-settings-form">
				<input type="hidden" name="save_grav_settings" value="1">
				<?php wp_nonce_field(self::$option_key); ?>
				<table class="form-table">
				<?php
				foreach($fields as $meta_key => $field)
				{
					?>
					<tr class="grav-plugin-settings-<?php echo $meta_key;?> grav-plugin-settings-type-<?php echo $field['type'];?>">
						<th><label for="<?php echo $meta_key;?>"><?php echo $field['label'];?></label></th>
						<td>
						<?php
						if($field['type'] != 'repeater')
						{
							self::settings_field($meta_key, $field);
						}
						else // If Repeater
						{
							?>
								<table class="form-table repeater-table">
								<?php
								if(!empty($field['fields']))
								{
									$repeater_num = 0;
									$added_placeholder = 0;

									foreach ($field['fields'] as $rep_i => $rep_fields)
									{
										/* Create Placeholer */
										if(!is_numeric($rep_i))
										{
											if($added_placeholder)
											{
												continue;
											}

											$rep_fields = $field['fields'];
											foreach ($rep_fields as $placeholder_key => $placeholder_vlue)
											{
												if(is_numeric($placeholder_key))
												{
													unset($rep_fields[$placeholder_key]);
												}
											}
											$added_placeholder = 1;
										}

										?>
										<tr class="repeater-item<?php echo (!is_numeric($rep_i) ? ' repeater-placeholder' : '');?>" style="z-index:<?php echo (is_numeric($rep_i) ? $rep_i : 0);?>;">
											<td class="handle"><input type="hidden" name="settings[<?php echo $meta_key;?>][<?php echo $repeater_num;?>][_repeater_id]" value="<?php echo (isset($rep_fields['_repeater_id']['value']) ? $rep_fields['_repeater_id']['value'] : (!is_numeric($rep_i) ? '_repeater_id' : '').(is_numeric($rep_i) ? $rep_i : 0));?>"></td>
											<?php

											foreach ($rep_fields as $rep_key => $rep_field)
											{
												if($rep_field['type'] != 'repeater_id')
												{
													?>
													<td class="grav-plugin-settings-field grav-plugin-settings-field-<?php echo $rep_field['type'];?>">
														<?php self::settings_field($rep_key, $rep_field, $meta_key, $repeater_num); ?>
													</td>
													<?php
												}
											}
											$rep_i++;
											?>
											<td>
												<button class="repeater-remove button" type="input">X</button>
											</td>
										</tr>
										<?php

										$repeater_num++;
									}

								}
								?>
								<tfoot>
									<tr>
										<td colspan="10"><button class="repeater-add button" style="float:right;" type="input">Add</button></td>
									</tr>
								</tfoot>
							</table>
							<?php
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

			<script>

			jQuery(function($)
			{

				var c = {};

				// Return a helper with preserved width of cells
				var fixHelper = function(e, ui) {
					ui.children().each(function() {
						$(this).width($(this).width());
						$('.ui-sortable-placeholder').css('height', $('.ui-sortable-helper').height());
						console.log('helping: '+ $('.ui-sortable-helper').height());
					});
					return ui;
				};

				$(".repeater-table tbody").sortable({
					helper: fixHelper,
					containment: "document",
					cursor: "move",
					handle: ".handle",
					opacity: 0.8
				});

				$('.repeater-add').on('click', function(e)
				{
					e.preventDefault();
					var clone = $(this).closest('.repeater-table').find('.repeater-placeholder').clone();
					var total = $(this).closest('.repeater-table').find('.repeater-item').length;
					clone.removeClass('repeater-placeholder');
					clone.html(clone.html().split('[0]').join('['+total+']'));
					clone.html(clone.html().split('_repeater_id0').join((Math.floor(Math.random() * (99999 - 10000 + 1)) + 10000)));
					clone.css('z-index', total);
					clone.find('input[type="text"], textarea').val('');
					clone.find('input[type="checkbox"]').removeAttr('checked');
					clone.find('select option').removeAttr('selected');
					clone.find('.grav-blocks-colorpicker').wpColorPicker();

					clone.appendTo('.repeater-table');

					addRemoveListeners();
					return false;
				});

				function addRemoveListeners()
				{
					$('.repeater-remove').off('click');
					$('.repeater-remove').on('click', function(e)
					{
						e.preventDefault();
						if($(this).closest('.repeater-table').find('.repeater-item').length > 1)
						{
							$(this).closest('.repeater-item').remove();
						}
						else
						{
							alert('You need to keep at least one Item');
						}
						return false;
					});
				}

				addRemoveListeners();
				$('.repeater-item:not(.repeater-placeholder) .grav-blocks-colorpicker').wpColorPicker();

			});

			</script>
		<?php

	}

	/**
	 * Outputs a field to the form
	 *
	 * @param string $meta_key - Key of the field
	 * @param array $field - Field Array
	 * @param string $repeater_key - If Repeater field then pass the Key of the Parent Repeater field
	 * @param int $rep_i - If Repeater field then pass the number of the field within the repeater.
	 *
	 * @return type
	 */
	public static function settings_field($meta_key, $field, $repeater_key='', $rep_i=0)
	{
		$deprecated = array();

		?><span class="settings-field-wrapper"><?php
		$settings_attribute = 'settings['.$meta_key.']';

		if($repeater_key && !empty($field['label']))
		{

			$settings_attribute = 'settings['.$repeater_key.']['.$rep_i.']['.$meta_key.']';

			?><label for="<?php echo $meta_key;?>"><strong><?php echo $field['label'];?></strong></label><br><?php
		}

		if(!empty($field['type']) && $field['type'] == 'text')
		{
			?><input type="text" name="<?php echo $settings_attribute;?>" id="<?php echo $meta_key;?>"<?php echo (isset($field['maxlength']) ? ' maxlength="'.$field['maxlength'].'"' : '');?> value="<?php echo esc_attr( (isset($field['value']) ? $field['value'] : '') );?>" class="regular-text" /><br /><?php
		}
		else if(!empty($field['type']) && $field['type'] == 'textarea')
		{
			?><textarea rows="6" cols="38" name="<?php echo $settings_attribute;?>" id="<?php echo $meta_key;?>"><?php echo esc_attr( (isset($field['value']) ? $field['value'] : '') );?></textarea><br /><?php
		}
		else if(!empty($field['type']) && $field['type'] == 'select')
		{
			?>
			<select name="<?php echo $settings_attribute;?>" id="<?php echo $meta_key;?>">
				<?php
				if(!empty($field['allow_null']))
				{
					?>
					<option value="">- Select -</option>
					<?php
				}
				foreach($field['options'] as $option_value => $options)
				{
					$options_label = (is_array($options)) ? $options['label'] : $options;
					$real_value = ($option_value !== $options_label && !is_numeric($option_value) ? $option_value : $options_label);
					?>
					<option<?php echo ($real_value !== $options_label ? ' value="'.$real_value.'"' : '');?> <?php selected( ($real_value !== $options_label ? $real_value : $options_label), esc_attr( (isset($field['value']) ? $field['value'] : '') ));?>><?php echo $options_label;?></option>
					<?php
				} ?>
			</select>
			<?php
		}
		else if(!empty($field['type']) && $field['type'] == 'checkbox')
		{


			if(is_string($field['options']))
			{
				$field['options'] = explode(',', $field['options']);
				$field['options'] = array_combine($field['options'], $field['options']);
			}

			?>
			<input type="hidden" name="<?php echo $settings_attribute;?>" value="">
			<?php

			foreach($field['options'] as $option_value => $options)
			{
				if(isset($options['deprecated']) ){
					$deprecated[$option_value] = $options;
					continue;
				}
				$options_label = (is_array($options)) ? $options['label'] : $options;
				$block_icon = (is_array($options) && $options['icon']) ? $options['icon'] : '';
				$block_description = (is_array($options) && $options['description']) ? $options['description'] : '';
				$real_value = ($option_value !== $options_label && !is_numeric($option_value) ? $option_value : $options_label);

				if(isset($field['value']) && is_array($field['value']))
				{
					$checked = (in_array($real_value, $field['value'])) ? 'checked' : '';
				}
				else
				{
					$checked = '';
				}
				?>
				<span class="grav-option-wrapper">
					<label>
						<input type="checkbox" name="<?php echo $settings_attribute;?>[]" value="<?php echo $option_value; ?>" <?php echo $checked; ?>>
						<span <?php if($block_icon){ echo 'class="'.esc_attr($block_icon).'"'; } ?>><?php echo ucfirst($options_label); ?></span>
					</label>
					<?php if($block_description){ ?>
						<a class="grav-inline thickbox" href="#TB_inline?width=600&height=550&inlineId=<?php echo $option_value; ?>" title="<?php echo ucfirst($options_label); ?>">?</a>
						<div style="display:none;"><div id="<?php echo $option_value; ?>">
							<div class="grav-modal-content">
								<?php echo $block_description; ?>
							</div>
						</div></div>
					<?php } ?>
				</span>
				<?php
			}
			if(!empty($deprecated)){
				?> <h4 style="width:100%;margin-bottom:0">Deprecated Blocks</h4><span class="description" style="margin-bottom:30px;">These blocks are marked for deprecation and will no longer be updated or supported. Please use the replacing blocks.</span><?php
				foreach($deprecated as $option_value => $options)
				{
					$options_label = (is_array($options)) ? $options['label'] : $options;
					$block_icon = (is_array($options) && $options['icon']) ? $options['icon'] : '';
					$block_description = (is_array($options) && $options['description']) ? $options['description'] : '';
					$real_value = ($option_value !== $options_label && !is_numeric($option_value) ? $option_value : $options_label);

					if(isset($field['value']) && is_array($field['value']))
					{
						$checked = (in_array($real_value, $field['value'])) ? 'checked' : '';
					}
					else
					{
						$checked = '';
					}
					?>
					<span class="grav-option-wrapper">
						<label>
							<input type="checkbox" name="<?php echo $settings_attribute;?>[]" value="<?php echo $option_value; ?>" <?php echo $checked; ?>>
							<span <?php if($block_icon){ echo 'class="'.esc_attr($block_icon).'"'; } ?>><?php echo ucfirst($options_label); ?></span>
						</label>
						<?php if($block_description){ ?>
							<a class="grav-inline thickbox" href="#TB_inline?width=600&height=550&inlineId=<?php echo $option_value; ?>" title="<?php echo ucfirst($options_label); ?>">?</a>
							<div style="display:none;"><div id="<?php echo $option_value; ?>">
								<div class="grav-modal-content">
									<?php echo $block_description; ?>
								</div>
							</div></div>
						<?php } ?>
					</span>
					<?php
				}
			}
		}
		else if(!empty($field['type']) && $field['type'] == 'radio')
		{
			if(is_string($field['options']))
			{
				$field['options'] = explode(',', $field['options']);
				$field['options'] = array_combine($field['options'], $field['options']);
			}

			?>
			<input type="hidden" name="<?php echo $settings_attribute;?>" value="">
			<?php

			foreach($field['options'] as $option_value => $options)
			{

				$options_label = (is_array($options)) ? $options['label'] : $options;
				$block_icon = (is_array($options) && $options['icon']) ? $options['icon'] : '';
				$block_description = (is_array($options) && $options['description']) ? $options['description'] : '';
				$real_value = ($option_value !== $options_label && !is_numeric($option_value) ? $option_value : $options_label);

				if(isset($field['value']) && is_array($field['value']))
				{
					$checked = (in_array($real_value, $field['value'])) ? 'checked' : '';
				}
				else
				{
					$checked = '';
				}
				?>
				<span class="grav-option-wrapper">
					<label>
						<input type="radio" name="<?php echo $settings_attribute;?>[]" value="<?php echo $option_value; ?>" <?php echo $checked; ?>>
						<span <?php if($block_icon){ echo 'class="'.esc_attr($block_icon).'"'; } ?>><?php echo ucfirst($options_label); ?></span>
					</label>
					<?php if($block_description){ ?>
						<a class="grav-inline thickbox" href="#TB_inline?width=600&height=550&inlineId=<?php echo $option_value; ?>" title="<?php echo ucfirst($options_label); ?>">?</a>
						<div style="display:none;"><div id="<?php echo $option_value; ?>">
							<div class="grav-modal-content">
								<?php echo $block_description; ?>
							</div>
						</div></div>
					<?php } ?>
				</span>
				<?php
			}
		}
		else if(!empty($field['type']) && $field['type'] == 'colorpicker')
		{
			?><input type="text" class="grav-blocks-colorpicker" name="<?php echo $settings_attribute;?>" id="<?php echo $meta_key;?>"<?php echo (isset($field['maxlength']) ? ' maxlength="'.$field['maxlength'].'"' : '');?> value="<?php echo esc_attr( (isset($field['value']) ? $field['value'] : '') );?>" class="regular-text" /><br /><?php
		}
		?>
		</span>
		<?php

		if(!empty($field['description']))
		{
			?><span class="description"><?php echo $field['description'];?></span><br><?php
		}
	}
}
