<?php
/**
 * The template for displaying Category pages.
 *
 * Used to display archive-type pages for posts in a category.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
<?php get_header(); ?>
    <section class="summary">
    <?php if ( have_posts() ) : ?>
    <h1 class="archive-title">
    <?php 
        //the_category_title_tree()
        echo single_cat_title( '', true );
    ?>
    </h1>

        <?php 
        if ( category_description() ) : // Show an optional category description
            echo category_description();                     
        endif; 
        ?>
    </section>
    <section class="promos clearfix">
        <ul>
            <?php
            /* Start the Loop */
            while ( have_posts() ) : the_post();

                /* Include the post format-specific template for the content. If you want to
                 * this in a child theme then include a file called called content-___.php
                 * (where ___ is the post format) and that will be used instead.
                 */
                //get_template_part( 'content', get_post_format() );
                //echo the_title();
                //
                // Display the "short title" (ACF) if it exists
                $short_title = get_the_title();
                if (get_field('short_title')) {
                    $short_title = get_field('short_title');
                }
                ?>
                <li class="card clearfix">
                    <a href="<?php the_permalink() ?>">
                        <div class="card-image"><?php the_post_thumbnail( 'full' ) ?></div>
                        <div class="card-info">
                            <h3><?php echo $short_title ?></h3>
                            <?php the_excerpt() ?>
                            <span class="card-more"></span>
                        </div>
                    </a>
                </li>
            <?php

            endwhile;

            //twentytwelve_content_nav( 'nav-below' );
            ?>
        </ul>
    </section>

	<?php else : ?>
        <?php 
            //get_template_part( 'content', 'none' ); 
        ?>
    <?php endif; ?>

<?php 
//get_sidebar();
get_footer(); 
?>