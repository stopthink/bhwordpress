<?php
get_header();
if (have_posts()) : while (have_posts()) : the_post();
?>

        <div class="content">

            <div class="content-main">

                <?php the_content(); ?>
                <!--<h3 class="fl">Building a strong soverign food system in Tampa Bay</h3>

                <div class="welcome_photo"><img src="<?php bloginfo('template_url') ?>/images/box_photo_large.jpg" class="polaroid" /></div>
                <div class="cf"></div>

                <h3 class="how_it_works">How it Works</h3>
                <div class="step cf">
                    <div class="step-num"><span>1</span></div>
                    <p>Order online each week by selecting from the choices to the right.</p>
                </div>
                <div class="step cf">
                    <div class="step-num"><span>2</span></div>
                    <p>Checkout to pay for your order by Tuesday night.</p>
                </div>
                <div class="step cf">
                    <div class="step-num"><span>3</span></div>
                    <p>Pickup your order the following Thursday at <a href="#">Mermaid Tavern</a>.</p>
                </div>
-->


            </div>
            
            <?php get_sidebar(); ?>            

            <div class="cf"></div>

        </div>


<?php
endwhile;
else:
?>

<!-- no post -->

<?php
endif;
get_footer();
?>
