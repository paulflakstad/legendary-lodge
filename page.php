<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 */
?>
<?php get_header(); ?>
	<!--<div id="contentwrap">
	<article>-->

			<?php
			while (have_posts()): the_post();
				?>
                <section class="summary">
                <?php
                //$hero_image = get_the_post_thumbnail('full');;
                if (has_post_thumbnail()) {
                ?>
                    <figure class="panorama">
                    <?php the_post_thumbnail('full') ?>
                        <!--<figcaption>                    	
                            <h1><?php the_title() ?></h1>
                        </figcaption>-->
                        <?php the_post_thumbnail_caption() ?>
                    </figure>
                    <?php		}
					?>
                    <h1><?php the_title() ?></h1>
                    <?php the_breadcrumb() ?>
                    <?php
					
                    //the_excerpt();
                    the_content();
                    //get_template_part( 'content', 'page' );
                    //comments_template( '', true ); 
				?>
                </section>
                <?php endwhile; // end of the loop. ?>
            
            <?php 
			// Include "sections"? (This is an ACF Repeater field.)
			include('_section.php');
			// Include "products" (ACF repeater field)
			include('_products.php');
			?>

	<!--</article>
	</div>-->
<!-- CALLING: get_sidebar() -->
<?php /*get_sidebar();*/ ?>
<!-- DONE: get_sidebar() -->

<!-- CALLING: get_footer() -->
<?php get_footer(); ?>
<!-- DONE: get_footer() -->