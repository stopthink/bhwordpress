<?php
/*
 * Template Name: Blog
 */
?>

<?php get_header() ?>

        <div class="content">

            <div class="content-main">
<?php wp_get_archives('type=postbypost'); ?>
            </div>
            
            <?php get_sidebar('blog'); ?>            

            <div class="cf"></div>

        </div>

<?php get_footer() ?>
