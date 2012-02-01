<?php get_header() ?>

        <div class="content">

            <div class="content-main">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <h3><?php the_title() ?></h3>
                <p>by: <b><?php the_author() ?></b> on <?php the_date() ?></p>
                <?php the_content() ?>
            <?php endwhile; ?>

            <?php next_posts_link('&laquo; Older Entries') ?>
            <?php previous_posts_link('Newer Entries &raquo;') ?>
            <?php else: endif; ?>

            </div>
            
            <?php get_sidebar('blog'); ?>
 
            <div class="cf"></div>

        </div>

<?php get_footer() ?>
