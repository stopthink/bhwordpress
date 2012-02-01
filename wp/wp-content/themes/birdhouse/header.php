<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
    <head>
        <title>
        <?php
        if (function_exists('is_tag') && is_tag()) {
            single_tag_title('Tag Archive for &quot;'); echo '&quot; - ';
        } elseif (is_archive()) {
            wp_title(''); echo ' Archive - ';
        } elseif (!(is_404()) && (is_single()) || (is_page())) {
            wp_title(''); echo ' - ';
        } elseif (is_search()) {
            echo 'Search for &quot;'.wp_specialchars($s).'&quot; - ';
        } elseif (is_404()) {
            echo 'Not Found - ';
        }
        if (is_home()) {
            bloginfo('name'); echo ' - '; bloginfo('description');
        } else {
            bloginfo('name');
        }
        if ($paged > 1) {
            echo ' - page ' . $paged;
        } ?>
        </title>
        <script type="text/javascript" src="http://use.typekit.com/dxo0wcu.js"></script>
        <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
        <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.9.0/build/reset/reset-min.css">
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url') ?>" media="screen" />
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>;charset=<?php bloginfo('charset'); ?>" />
        <meta charset="<?php bloginfo('charset'); ?>">
        <?php wp_register_script('jquery.color', get_template_directory_uri() . '/js/jquery.color.js', array('jquery')) ?>
        <?php wp_enqueue_script('jquery.color') ?> 

        <?php wp_head() ?>
    </head>
    
    <body>

<?php /* if (!current_user_can('manage_options')) { ?>
<div class="coming_soon">
<p style="text-align: center;"><img src="<?php bloginfo('url') ?>/chicken.png"><br />
<p style="text-align: center;">Good things coming (very) soon =]</p>
</div>
<?php } */ ?>

</div>
    <div class="header-wrap">
        <div class="header-content">
            <div class="widget wpchkt_w" id="wpchkt_w-2">
                <div id="wpchkt_widget">
                    <span class="tiny_cart">Your cart is empty</span>
                </div>
            </div>
            
            <h1><a href="<?php bloginfo('url') ?>">Birdhouse Buying Club</a></h1>

            <ul class="nav">
                <?php wp_nav_menu(); ?>
                <?php //wp_list_pages(array('title_li' => '', 'exclude' => '29')); ?>
            </ul>
        </div>
    </div>
