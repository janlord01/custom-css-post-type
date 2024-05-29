<?php
/**
 * Plugin Name: Prtrix Custom CSS Post Type
 * Description: CSS custom editor for custom post types
 * Version: 1.0
 * Author: Janlord Luga, Garry Rodriguez
 * Author URI: https://janlordluga.com/, https://janlordluga.com/
 * License: GPL v2 or later
 * 
 */

//  Add settings page
function custom_css_settings_page(){
    add_options_page(
        'Custom CSS Settings',
        'Custom CSS Settings',
        'manage_options',
        'custom_css_settings',
        'custom_css_settings_page_html',
    );

}

add_action('admin_menu', 'custom_css_settings_page');

// Settings page UI
function custom_css_settings_page_html(){
    $selected_post_types = custom_css_get_selected_post_types();
    $post_types = get_post_types(array('public' => true), 'objects');
    ?>
<div class="wrap">
    <h2>Custom CSS Settings</h2>
    <form method="post" action="options.php">
        <?php settings_fields('custom_css_settings_group'); ?>
        <?php do_settings_sections('custom_css_settings'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Select Post Types</th>
                <td>
                    <?php  foreach($post_types as $post_type): ?>
                    <label><input type="checkbox" name="custom_css_selected_post_types[]"
                            value="<?php echo esc_attr($post_type->name) ?>"
                            <?php checked(in_array($post_type->name, $selected_post_types)); ?>>
                        <?php echo esc_html($post_type->labels->singular_name); ?> </label><br>
                    <?php endforeach ?>
                </td>
            </tr>
        </table>
        <input type="submit" class="button-primary" value="Save Changes" />
    </form>

</div>
<?php
}
// Register settings
function custom_css_register_settings(){
    register_setting('custom_css_settings_group', 'custom_css_selected_post_types');
    // add_settings_section('custom_css_settings_section', 'Select post_types', 'custom_css_settings_section_callback', 'custom_css_settings');
    // add_settings_field('custom_css_post_types_field', 'post_types', 'custom_css_post_types_field_callback', 'custom_css_settings','custom_css_settings_section');
}
add_action('admin_init', 'custom_css_register_settings');

// Settings section callback
// function custom_css_settings_section_callback(){
//     echo "<p>Select the post_types where you want to enable custom CSS</p>";
// }

// post_types field Callback
// function custom_css_post_types_field_callback(){
//     $post_types = get_post_types(array('public' => true), 'objects');
//     $selected_post_types = custom_css_get_selected_post_types();
//     foreach ($post_types as $taxonomy) {
//         echo '<label><input type="checkbox"  name="custom_css_selected_post_types[]" value="' . $taxonomy->name . '" ' . (in_array($taxonomy->name, $selected_post_types) ? 'checked' : '') . '>' . $taxonomy->label . '</label><br>';
//     }
// }

// Get selected post types from settings
function custom_css_get_selected_post_types(){
    $selected_post_types = get_option('custom_css_selected_post_types', array('post','page')); //Default page and post
    return $selected_post_types;
}

// Add meta box for css input based on selected taxonomy types
function custom_css_add_meta_box(){
    $selected_post_types = custom_css_get_selected_post_types();
    foreach ($selected_post_types as $post_type) {
        add_meta_box(
            'custom_css_meta_box_' . $post_type,
            'Custom CSS',
            'custom_css_meta_box_html',
            $post_type,
            'side',
            'default',
        );
    }
}
add_action('add_meta_boxes', 'custom_css_add_meta_box');

// Meta Box HTML
function custom_css_meta_box_html($post)
{
    $value = get_post_meta($post->ID, '_custom_css', true);
    ?>
<textarea id="custom_css_editor" name="custom_css"
    style="width: 100%;height: 200px;"><?php echo esc_textarea($value); ?></textarea>
<?php
}

// Save the custom CSS
function custom_css_save_postdata($post_id){
    if(array_key_exists('custom_css',$_POST)){
        update_post_meta(
            $post_id,
            '_custom_css',
            wp_kses_post($_POST['custom_css'])
        );
    }
}
add_action('save_post', 'custom_css_save_postdata');

// Output the custom CSS
function custom_css_output(){
    if(is_singular()){
        global $post;
        $selected_post_types = custom_css_get_selected_post_types();
        if(in_array($post->post_type,$selected_post_types)){
            $custom_css = get_post_meta($post->ID, '_custom_css', true);
            if (!empty($custom_css)) {
                echo '<style type="text/css">' . esc_html($custom_css) . '</style>';
            }
        }
    }
}
add_action('wp_head', 'custom_css_output');