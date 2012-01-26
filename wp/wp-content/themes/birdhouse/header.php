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
        
        <?php wp_enqueue_script('jquery') ?>

        <!--<script type="text/javascript" src="<?php bloginfo('template_url') ?>/js/name.js" />-->
        
        <?php wp_head() ?>
    </head>
    
    <body>


    <div class="header-wrap">
        <div class="header-content">
        <h1><a href="<?php bloginfo('url') ?>">Birdhouse Buying Club</a></h1>

            <ul class="nav">
                <?php wp_nav_menu(); ?>
                <?php //wp_list_pages(array('title_li' => '', 'exclude' => '29')); ?>
            </ul>
        </div>
    </div>
