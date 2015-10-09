<?php
/*
* Gravitate Plugin Settings File
* Version: 1.0.0
*
*/

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

						foreach ($value as $rep_i => $rep_values)
						{
							$fields[$key]['fields'][$rep_i] = $rep_original_fields;

							foreach ($rep_original_fields as $rep_key => $rep_value)
							{
								$fields[$key]['fields'][$rep_i][$rep_key]['value'] = $rep_values[$rep_key];
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
	 * Saved the Settings to the Database when the form was seubmitted
	 *
	 * @return array
	 */
	public static function save_settings()
	{
		if(!empty($_POST['save_grav_settings']) && !empty($_POST['settings']))
		{
			$_POST['settings']['updated_at'] = time();

			$settings = $_POST['settings'];

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
			<form method="post">
				<input type="hidden" name="save_grav_settings" value="1">
				<table class="form-table">
				<?php
				foreach($fields as $meta_key => $field)
				{
					?>
					<tr>
						<th><label for="<?php echo $meta_key;?>"><?php echo $field['label'];?></label></th>
						<td>
						<?php
						if($field['type'] != 'repeater')
						{
							self::settings_field($meta_key, $field);
						}
						else // If Repeater
						{
							if(!empty($field['fields']))
							{
								?>
								<table class="form-table repeater-table">
									<?php
									$repeater_num = 0;
									foreach ($field['fields'] as $rep_i => $rep_fields)
									{
										if(is_numeric($rep_i))
										{
											?>
											<tr class="repeater-item" style="border: 1px solid #999;">
												<?php

												foreach ($rep_fields as $rep_key => $rep_field)
												{
													?>
													<td>
														<?php self::settings_field($rep_key, $rep_field, $meta_key, $repeater_num); ?>
													</td>
													<?php

												}
												$rep_i++;
												?>
												<td>
													<button class="repeater-remove" type="input">X</button>
												</td>
											</tr>
											<?php

											$repeater_num++;
										}
									}
									?>
									<tfoot>
										<tr>
											<td colspan="10"><button class="repeater-add" style="float:right;" type="input">Add</button></td>
										</tr>
									</tfoot>
								</table>
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

			<script>

			jQuery(function($)
			{

				$('.repeater-add').on('click', function(e)
				{
					e.preventDefault();
					var clone = $('.repeater-table .repeater-item:first-child').clone();
					clone.html(clone.html().replace(new RegExp(/\[0\]/, 'g'), '['+$(this).closest('.repeater-table').find('.repeater-item').length+']'));
					clone.find('input[type="text"], textarea').val('');
					clone.find('input[type="checkbox"]').removeAttr('checked');
					clone.find('select option').removeAttr('selected');
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
		$settings_attribute = 'settings['.$meta_key.']';

		if($repeater_key && $field['label'])
		{
			$settings_attribute = 'settings['.$repeater_key.']['.$rep_i.']['.$meta_key.']';

			?><label for="<?php echo $meta_key;?>"><strong><?php echo $field['label'];?></strong></label><br><?php
		}

		if(!empty($field['description']))
		{
			?><span class="description"><?php echo $field['description'];?></span><br><?php
		}

		if($field['type'] == 'text')
		{
			?><input type="text" name="<?php echo $settings_attribute;?>" id="<?php echo $meta_key;?>"<?php echo (isset($field['maxlength']) ? ' maxlength="'.$field['maxlength'].'"' : '');?> value="<?php echo esc_attr( (isset($field['value']) ? $field['value'] : '') );?>" class="regular-text" /><br /><?php
		}
		else if($field['type'] == 'textarea')
		{
			?><textarea rows="6" cols="38" name="<?php echo $settings_attribute;?>" id="<?php echo $meta_key;?>"><?php echo esc_attr( (isset($field['value']) ? $field['value'] : '') );?></textarea><br /><?php
		}
		else if($field['type'] == 'select')
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
			foreach($field['options'] as $option_value => $option_label)
			{
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
			if(is_string($field['options']))
			{
				$field['options'] = explode(',', $field['options']);
				$field['options'] = array_combine($field['options'], $field['options']);
			}

			?>
			<input type="hidden" name="<?php echo $settings_attribute;?>" value="">
			<?php

			foreach($field['options'] as $option_value => $option_label)
			{
				$real_value = ($option_value !== $option_label && !is_numeric($option_value) ? $option_value : $option_label);

				if(is_array($field['value']))
				{
					$checked = (in_array($real_value, $field['value'])) ? 'checked' : '';
				}
				else
				{
					$checked = '';
				}
				?>
				<label><input type="checkbox" name="<?php echo $settings_attribute;?>[]" value="<?php echo $option_value; ?>" <?php echo $checked; ?>><?php echo $option_label; ?></label><br>
				<?php
			}
		}
	}
}