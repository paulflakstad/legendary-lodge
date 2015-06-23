<?php
/**
 * The template for displaying search results pages.
 */

get_header(); ?>

	<article>
		<h1><?php printf( __( 'Søkeresultater for: %s', 'twentytwelve' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
		<?php if (have_posts()) : ?>
			<?php /*twentytwelve_content_nav( 'nav-above' );*/ ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
            	<a href=""><?php the_title(); ?></a>
            	<?php the_excerpt(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php twentytwelve_content_nav( 'nav-below' ); ?>

		<?php else : ?>
				<h4 class="entry-title"><?php _e( 'Ingen treff!', 'twentytwelve' ); ?></h4>
                <p><?php _e( 'Beklager, men ingen av våre sider passet til det du søkte på. Prøv gjerne et nytt søk med andre ord.', 'twentytwelve' ); ?></p>
                <?php get_search_form(); ?>

		<?php endif; ?>

		</article>

<?php get_sidebar(); ?>
<?php get_footer(); ?>