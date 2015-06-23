<?php
/**
 * The front page template.
 */
?>
<?php get_header(); ?>

    <?php
    while (have_posts()): the_post();
    ?>
    <section class="summary">
        <figure class="panorama">
            <img src="http://localhost/wptest/wp-content/themes/legendary-lodge/img/senjafjell-espen-minde.jpg" alt="">
        </figure>
        <h1><strong>Adventure</strong> in the heart of <strong>Senja</strong></h1>
        <?php if (the_lang() == 'no') { ?>
        <p>Med Legendary Lodge som base kan du nyte hav, fjell, strender, fiskevær og innland &ndash; alt innenfor en par 
            timers kjøretur. Rett utenfor døren ligger et av verdens beste fiskefelt og havørnområder.</p>
        <?php } else { ?>
        <p>Using Legendary Lodge as your base, enjoy the ocean, mountains, beaches, fishing villages and the inland &ndash; 
            all within a couple of hours' drive. Right outside the door is one of the world's best fishing areas and 
            white-tailed eagle habitats.</p>
        <?php } ?>
    </section>
    <section class="promos clearfix">
        <?php
        
        //$hero_image = get_the_post_thumbnail('full');;
        if (has_post_thumbnail()) {
        }
        ?>
        <?php
        ?>
    </section>
    <?php endwhile; // end of the loop. ?>
            
    <?php 
    // Include "sections"? (This is an ACF Repeater field.)
    include('_section.php');
    // Include "products" (ACF repeater field)
    include('_products.php');
    ?>
<!-- CALLING: get_sidebar() -->
<?php /*get_sidebar();*/ ?>
<!-- DONE: get_sidebar() -->

<!-- CALLING: get_footer() -->
<?php get_footer(); ?>
<!-- DONE: get_footer() -->