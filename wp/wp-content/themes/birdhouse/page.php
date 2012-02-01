<?php get_header() ?>

        <div class="content">

            <div class="content-main">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content() ?>
            <?php endwhile; ?>

            <?php next_posts_link('&laquo; Older Entries') ?>
            <?php previous_posts_link('Newer Entries &raquo;') ?>
            <?php else: endif; ?>

            </div>
            
            <?php get_sidebar(); ?>
 
            <div class="cf"></div>

        </div>

<?php get_footer() ?>
