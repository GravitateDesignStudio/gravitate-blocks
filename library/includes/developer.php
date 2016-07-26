<div class="grav-blocks-developers">
    <h2>Placing the blocks in your theme</h2>
    <h4>There are 2 ways to include Gravitate Blocks in your theme:</h4>
        <ul>
            <li>By default the blocks will be filtered into "the_content()".  However, you can disable that in the <a href="admin.php?page=gravitate-blocks&section=advanced">Advanced Tab</a>.</li>
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

    <h2>Hooks - Actions and Filters</h2>
    <ul class="grav-hooks">
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
    <li><h3>grav_is_viewable</h3>
        This filters the viewable areas for all blocks.
        <blockquote>
        <label>Example 1: Adding blocks to a taxonomy term page.</label>
        <textarea class="grav-code-block">
add_filter('grav_is_viewable', 'your_function');
function your_function($is_viewable){
if(is_tax('product_categories')){
return true;
}
return $is_viewable;
}
        </textarea>
        <br><em>* Keep in mind you will still need to update the markup to accept the new settings</em>
        </blockquote>
    </li>
    <li><h3>grav_get_css</h3>
        This filters the css classes for each block.
        <blockquote>
        <label>Example 1: Adding a class only on the row of a certain block.</label>
        <textarea class="grav-code-block">
add_filter('grav_get_css', 'your_function', 10, 2);
function your_function($css, $block_name){
if($block_name == 'content' && in_array('row', $css)){
$css[] = 'align-center';
}
return $css;
}
        </textarea>
        </blockquote>
    </li>
    <li><h3>grav_block_content_columns</h3>
        This filters the number of columns for the block "Content".
        <blockquote>
        <label>Example 1: Changing one column block to only take up 10 columns of the grid and two column block to only take up a total of 10 columns.</label>
        <textarea class="grav-code-block">
add_filter('grav_block_content_columns', 'your_function');
function your_function($cols_span){
switch ($cols_span){
case 12:
    $cols_span = 10;
    break;
case 6:
    $cols_span = 5;
    break;
}
return $cols_span;
}
        </textarea>
        </blockquote>
    </li>
    <li><h3>grav_block_background_colors</h3>
        This filters the background options for all blocks.
        <blockquote>
        <label>Example 1: Adding another option to the background options.</label>
        <textarea class="grav-code-block">
add_filter('grav_block_background_colors', 'your_function');
function your_function($block_background_colors){
	$block_background_colors['bg-landscape'] = 'Landscape';
	return $block_background_colors;
}
        </textarea>
        </blockquote>
    </li>
    <li><h3>grav_hide_on_screen</h3>
        This filter gives the ability to hide other parts of the WordPress dashboard on Gravitate Block enabled areas.
        <blockquote>
        <label>Example 1: Remove the content and excerpt fields.</label>
        <textarea class="grav-code-block">
add_filter('grav_hide_on_screen', 'your_function');
function grav_hide_fields($hidden){
	$hidden = array(
                0 => 'the_content',
                1 => 'excerpt'
	);
	return $hidden;
}
        </textarea>
        </blockquote>
    </li>
    <li><h3>grav_column_widths</h3>
        This filters the allowable column widths for the "Media Content" block.
        <blockquote>
        <label>Example 1: Change the width options. The key in the array is the number of columns for the media to use.</label>
        <textarea class="grav-code-block">
add_filter('grav_column_widths', 'your_function');
function your_function($column_width_options){
	$column_width_options = array(
		2 => 'Small',
		4 => 'Medium',
		6 => 'Large',
		7 => 'X-Large'
	);
	return $column_width_options;
}
        </textarea>
        </blockquote>
    </li>
    <li><h3>grav_block_mediacontent_columns</h3>
        This filters the total columns to use for the "Media Content" block.
        <blockquote>
        <label>Example 1: Change the total number of columns to be used to 10 instead of 12 based on if the media column width is less than 6 columns.</label>
        <textarea class="grav-code-block">
add_filter('grav_block_mediacontent_columns', 'your_function');
function your_function($col_total, $col_width, $placement){
	if($col_width < 6){
		return 10;
	}
	return $col_total;
}
        </textarea>
        </blockquote>
    </li>
    <li><h3>grav_block_background_colors</h3>
        This filters options for the block background colors.
        <blockquote>
        <label>Example 1: Remove the option for a background of none.</label>
        <textarea class="grav-code-block">
add_filter('grav_block_background_colors', 'your_function');
function your_function($block_background_colors){
    unset($block_background_colors['block-bg-none']);
    return $block_background_colors;
}
        </textarea>
        </blockquote>
    </li>
    <li><h3>grav_block_background_style</h3>
        This filters options for the block background style.
        <blockquote>
        <label>Example 1: Adding a color picker option for background colors.</label>
        <textarea class="grav-code-block">
add_filter('grav_block_background_style', 'your_function');
function your_function($block_background_style){
    $bg_option = get_sub_field('block_background');
    if($bg_option == 'picker' &amp;&amp; $color = get_sub_field('block_color_picker')){
        $block_background_style = $block_background_style.'background-color:'.$color.';';
    }
    return $block_background_style;
}
        </textarea>
        </blockquote>
    </li>
    <li><h3>grav_blocks_responsive_image_settings</h3>
        This filters the settings for the responsive images.
        <blockquote>
        <label>Example 1: Adding a custom size and enabling downscale.</label>
        <textarea class="grav-code-block">
add_filter( 'grav_blocks_responsive_image_settings', 'custom_responsive_image_settings' );
function custom_responsive_image_settings($settings)
{
    $settings['downscale'] = true;
    $settings['sizes'][] = array('name' => 'custom_size', 'size' => 1900);
    return $settings;
}
        </textarea>
        </blockquote>
    </li>
    <li><h3>grav_block_link_fields</h3>
        This filters the fields for "GRAV_BLOCKS::get_link_fields" used to build button and links within the blocks.
        <blockquote>
        <label>Example 1: Adding a custom button type.</label>
        <textarea class="grav-code-block">
add_filter('grav_block_link_fields', 'your_function');
function your_function($fields){
    $fields[0]['choices']['chat'] = 'Chat';
    return $fields;
}
        </textarea>
        </blockquote>
    </li>
    </ul>
</div>
