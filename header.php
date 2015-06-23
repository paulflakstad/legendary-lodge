<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<html <?php /*language_attributes();*/ ?>lang="<?php echo the_lang() ?>">
<head>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=0.5,user-scalable=yes" />
<?php the_meta_descr() ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php the_hreflang_links() ?>
<!-- 
    Background image courtesy of William Smith (willsmith.org). Used with permission. More like this at mayang.com/textures/Wood/images/
-->
<link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
<link rel="icon" type="image/png" href="/favicon-192x192.png" sizes="192x192">
<link rel="icon" type="image/png" href="/favicon-160x160.png" sizes="160x160">
<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-TileImage" content="/mstile-144x144.png">
<?php
// This script must stay hard-coded here - wp_enqueue_script() does not allow conditionals
?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php 
wp_head(); // Look for wp_enqueue_style() / wp_enqueue_script() in functions.php to find CSS and JS inclusions ;)
?>
</head>
<body>
<?php if (!is_user_logged_in()) { ?>
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-58339841-1', 'auto');
  ga('send', 'pageview');
</script>
<?php } else { ?>
<!-- GA tracking is normally here, but is disabled for this page because you're currently logged in -->
<?php } ?>
<div id="wrap"><div id="wrapwrap">
<header id="header" class="clearfix">
    <div class="mw">
        <a id="homelink" href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <!--<img src="<?php echo get_template_directory_uri(); ?>/img/logo-legendary-lodge.png" id="logo" alt="">-->
            <img src="<?php echo get_template_directory_uri(); ?>/img/logo-legendary-lodge.svg" id="logo" alt="">
        </a>
        <?php 
		// Use H1 on the front page, div for other pages
		//$sitename_wrapper = is_front_page() ? "h1" : "div";
                // Nah, strike that ... just use the div all the way
                $sitename_wrapper = is_front_page() ? "div" : "div";
		echo '<' . $sitename_wrapper . ' id="sitename">';
		?><?php echo bloginfo('name') ?>
         <span id="tagline">&ndash;&nbsp;<?php echo bloginfo('description') ?></span>
        <?php echo '</' . $sitename_wrapper . '>'; ?>
        
        <div id="navcontrol"><!-- show/hide navigation -->
            <a class="nav-controller" id="nav-on" href="#nav"><span></span></a>
            <a class="nav-controller" id="nav-off" href="#nonav"><span><?php echo the_lang() == 'no' ? 'Skjul meny' : 'Hide menu' ?></span></a>
        </div>
    </div>
</header>
    
<?php /*get_search_form();*/ ?>
    
<?php 
    // Site navigation - see http://codex.wordpress.org/Function_Reference/wp_nav_menu
    wp_nav_menu(
        array( 
                'theme_location'	=> 'primary', // ???
                'container'		=> 'nav', // The wrapper type ( div | nav )
                'container_id'    	=> 'nav', // The wrapper ID
                'menu'			=> 'slug', // ( id | slug | name )
                'menu_class'		=> 'mw', // The root ul's class
                'menu_id'		=> 'global-nav',
                'wrap_id'		=> 'wrappernav',
                'fallback_cb'		=> false
            ) 
        ); 
?>
<!--<nav id="jumplinks">-->
    <div class="mw">
        <nav id="nav-lang" class="mw"><?php the_translations() ?></nav>
        <?php 
        //the_breadcrumb();
        //my_breadcrumb('Primary Menu'); // moved to page.php
        ?>
    </div>
<!--</nav>-->

<article>
<div class="mw">