<?php

/*add_action('admin_menu', 'add_gcf_interface');

function add_gcf_interface() {
    add_options_page('Global Custom Fields', 'Global Custom Fields', '8', 'functions', 'editglobalcustomfields');
}

function editglobalcustomfields() {
?>

<div class="wrap">
    <h2>Global Custom Fields</h2>
    <form method="post" action="options.php">
        <?php wp_nonce_field('update-options') ?>
        <p><strong>Amazon ID:</strong><br />
        <input type="text" name="amazonid" size="45" value="<?php echo get_option('amazonid'); ?>" /></p>
        <p><input type="submit" name="Submit" value="Update Options" /></p>
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="amazonid" />
    </form>
</div>
 */

?>



<?php
    
if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => 'Sidebar Widgets',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="widget_title">',
        'after_title' => '</div>'
    ));
    register_sidebar(array(
        'name' => 'Footer',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget_title">',
        'after_title' => '</h4>'
    ));
    register_sidebar(array(
        'name' => 'Blog Sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget_title">',
        'after_title' => '</h4>'
    ));
}

# parse shortcodes in widgets
add_filter('widget_text', 'do_shortcode');
?>
