<?php get_header() ?>

        <div class="content">

            <div class="content-main">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php the_content() ?>
            <?php endwhile; else: endif; ?>
            </div>
            
            <?php get_sidebar(); ?>            

            <div class="cf"></div>

        </div>

<?php get_footer() ?>
