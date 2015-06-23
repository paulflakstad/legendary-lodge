<?php
function the_meta_descr() {
    global $post;
    
    if (is_category()) {
        $meta_descr = category_description();
    } else {
        $meta_descr = $post->post_content;
    }
    
    if (isset($meta_descr)) {
        echo '<meta name="description" content="' . htmlspecialchars(strip_tags($meta_descr)) . '" />' . PHP_EOL;
    }
}
/**
 * Gets the caption for the featured image / post thumbnail.
 * 
 * @see https://wordpress.org/support/topic/featured-image-display-image-caption
 * @global type $post
 */
function the_post_thumbnail_caption() {
    global $post;

    $thumbnail_id    = get_post_thumbnail_id($post->ID);
    $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

    if ($thumbnail_image && isset($thumbnail_image[0])) {
        echo '<figcaption>' . $thumbnail_image[0]->post_excerpt . '</figcaption>';
    }
}

/**
 * Card-link shortcode function
 * [cardlink category="15" /]
 */
function cardlink($atts, $content = null) {
    $cat_id = $atts['category'];
    
    if (is_numeric($cat_id)) {
        $params = array(
            'posts_per_page' => 100,
            'orderby' => 'menu_order',
            'category' => (int)$cat_id
        );
        
        $card_pages = get_posts($params);
        if ($card_pages) {
            $html .= '<ul class="cards clearfix">';
            foreach ($card_pages as $p) {
                $title = get_the_title($p);
                $short_title = get_field('short_title', $p);
                if ($short_title)
                    $title = $short_title;
                $html .= '<li class="card clearfix">';
                $html .= '<a href="' . get_the_permalink($p) . '">';
                $html .= '<div class="card-image">' . get_the_post_thumbnail($p->ID, 'medium') . '</div>';
                $html .= '<div class="card-info">';
                $html .= '<h3>' . $title . '</h3>';
                $html .= '<p>' . $p->post_excerpt . '</p>';
                $html .= '<span class="card-more"></span>';
                $html .= '</div>';
                $html .= '</a>';
                $html .= '</li>';
            }
            $html .= '</ul>';
        }
    }
    return $html;
}
add_shortcode('cardlink', 'cardlink');

/**
 * Instagram feed shortcode.
 * [instafeed /]
 */
function instafeed() {
    // NOTE: The instagram widget plugin has been 
    // slightly modified (added <section>, icon font etc.)
    ob_start();
    dynamic_sidebar('First Front Page Widget Area');
    $output_string = ob_get_contents();
    ob_end_clean();

    return $output_string;
}
add_shortcode('instafeed', 'instafeed');

/**
 * Youtube video shortcode.
 * [youtube-video id="Scxs7L0vhZ4" caption="Et lite stykke Norge." /]
 * @param type $atts
 * @return string
 */
function youtube_video($atts) {
    $video_id = $atts['id'];
    $caption = $atts['caption'];
    $html = '';
    if ($video_id) {
        $html = '<figure>'
                    . '<span class="video yt">'
                        //. '<iframe width="100%" height="auto" src="//www.youtube.com/embed/' . $video_id . '?theme=dark&amp;wmode=transparent&amp;html5=1" frameborder="0" allowfullscreen></iframe>'
                    . '<iframe width="560" height="349" src="//www.youtube.com/embed/' . $video_id . '?theme=dark&amp;wmode=transparent&amp;html5=1" allowfullscreen></iframe>'
                    . '</span>';
        if ($caption) {
                $html .= '<figcaption>'
                    	. '<p>' . $caption . '</p>'
                    . '</figcaption>';
        }
            $html .= '</figure>';
    }
    return $html;
}
add_shortcode('youtube-video', 'youtube_video');

/**
 * Product box shortcode
 * [prodbox price="8000,–" icon="mo-tu-we-th" price-info="Per person"]Mandag–torsdag[/prodbox]
 */
function prodbox($atts, $content = null) {
    return '<div class="packet">'
            . '<h3>' . $content . '</h3>'
            . '<span class="' . $atts['icon'] . '"></span>'
            . '<p class="price">' . $atts['price'] . '</p>'
            . '<p class="price-info">' . $atts['price-info'] . '</p>'
            //. '<a class="product-cta-booking" href="' . (the_lang() == 'no' ? '/booking/' : '/en/booking-request/') . '"></a>'
        . '</div>';
}
add_shortcode('prodbox', 'prodbox');
/**
 * Prints the category hierarchy (as category titles)
 */
function the_category_title_tree() {
    global $post;
    // Based on: http://codex.wordpress.org/Template_Tags/wp_list_categories#Display_Categories_Assigned_to_a_Post
    $taxonomy = 'category';
    // get the category IDs (or: the term IDs assigned to post)
    $post_cat_ids = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );

    // define separator to use between categories
    $separator = ' &ndash; ';

    $cat_string = '';

    if ( !empty( $post_cat_ids ) && !is_wp_error( $post_cat_ids ) ) {

        foreach ($post_cat_ids as $cat_id) {
                $cat_string .= $separator . get_the_category_by_ID( $cat_id, false );
        }
        //var_dump($cat_string);
        // display post categories (hierarchically
        echo  substr($cat_string, strlen($separator));
    }
    // More like this:
    //single_cat_title( '', true )  
    //get_category_parents( get_the_category(), true, ' &raquo; ' );
    //the_category(' &ndash; ')
}

/**
 * Gets current language slug (two-letter string). Defaults to Norwegian.
 */
function the_lang() {
    $current_lang = 'no';
    if (function_exists('pll_current_language')) {
        $current_lang = pll_current_language('slug');
    }
    return $current_lang;
}
/**
 * Language navigation
 */
function the_translations() {
    $no_alt_langs = array(
        "no" => '<em lang="en">English version still in press!</em>',
        "en" => '<em lang="en">Norsk versjon er til trykk!</em>'
    );
    if (function_exists('pll_the_languages')) {
        $lang_opts = array(
            'dropdown' => 0 // displays a list if set to 0, a dropdown list if set to 1 (default: 0)
                    ,'show_names' => 1 // displays language names if set to 1 (default: 1)
                    ,'display_names_as' => 'name' // either 'name' or 'slug' (default: 'name')
                    ,'show_flags' => 1 // displays flags if set to 1 (default: 0)
                    ,'hide_if_empty' => 1 // hides languages with no posts (or pages) if set to 1 (default: 1)
                    ,'force_home' => 0 // forces link to homepage if set to 1 (default: 0)
                    ,'echo' => 0 // echoes if set to 1, returns a string if set to 0 (default: 1)
                    ,'hide_if_no_translation' => 1 // hides the language if no translation exists if set to 1 (default: 0)
                    ,'hide_current'=> 1 // hides the current language if set to 1 (default: 0)
                    ,'post_id' =>  null // if set, displays links to translations of the post (or page) defined by post_id (default: null)
                    ,'raw' => 0 // use this to create your own custom language switcher (default:0)
        );
        echo '<ul id="langswitch">'; 
        $alt_langs = pll_the_languages($lang_opts);
        if ($alt_langs) {
            echo $alt_langs;
        } else {
            echo '<li>' . $no_alt_langs[the_lang()] . '</li>';
        }
        echo '</ul>' . PHP_EOL;
    }
}

/**
 * Header link elements for alternative languages (including "self")
 */
function the_hreflang_links() {
    if (function_exists('pll_the_languages')
            && function_exists('pll_current_language')) {
        $lang_opts = array(
            'dropdown' => 0 // displays a list if set to 0, a dropdown list if set to 1 (default: 0)
                    ,'show_names' => 0 // displays language names if set to 1 (default: 1)
                    ,'display_names_as' => 'name' // either 'name' or 'slug' (default: 'name')
                    ,'show_flags' => 0 // displays flags if set to 1 (default: 0)
                    ,'hide_if_empty' => 1 // hides languages with no posts (or pages) if set to 1 (default: 1)
                    ,'force_home' => 0 // forces link to homepage if set to 1 (default: 0)
                    ,'echo' => 0 // echoes if set to 1, returns a string if set to 0 (default: 1)
                    ,'hide_if_no_translation' => 1 // hides the language if no translation exists if set to 1 (default: 0)
                    ,'hide_current'=> 1 // hides the current language if set to 1 (default: 0)
                    ,'post_id' =>  null // if set, displays links to translations of the post (or page) defined by post_id (default: null)
                    ,'raw' => 1 // use this to create your own custom language switcher (default:0)
        );
        $current_language = pll_current_language(); // 'name' | 'locale' | 'slug
        $alt_langs = pll_the_languages($lang_opts);
        /*echo '<!--' . PHP_EOL;
        var_dump($alt_langs);
        echo PHP_EOL;
        var_dump($current_language);
        echo PHP_EOL . '-->' . PHP_EOL;*/
        
        echo '<link rel="alternate" hreflang="' . $current_language . '" href="' . get_permalink() . '" />' . PHP_EOL;
        echo '<link rel="alternate" hreflang="' . $alt_langs[0]['slug'] . '" href="' . $alt_langs[0]['url'] . '" />' . PHP_EOL;
    }
}

/**
 * Breadcrumb navigation
 */
function the_breadcrumb() {
    $home_title = array(
        'en' => 'Home'
        ,'no' => 'Forsiden'
        ,'yo' => 'KEK'
    );
    $current_lang = the_lang();
    
    if (!is_front_page()) {
        ob_start();

        wp_nav_menu( array( 
                        'container' => 'none', 
                        'theme_location' => 'primary',
                        'walker'=> new WW_BreadCrumbWalker, 
                        'link_before' => '<li class="%2$s breadcrumb-item">',
                        'link_after' => '</li>',
                        'items_wrap' => '%3$s'
                        //'items_wrap' => '<div>%3$s</div>'
                        //'items_wrap' => '<li class="%2$s breadcrumb-item">%3$s</li>'
                        //'items_wrap' => '<li id="breadcrumb-%1$s" class="%2$s">%3$s</li>'
                    )
                );

        $output_string = ob_get_contents();
        ob_end_clean();
    
    echo '<nav id="nav-breadcrumbs"><ul id="breadcrumb-items">'; 
    echo '<li><a href="' . get_option('home') . '"><i class="icon-home"></i> ' . $home_title[$current_lang] . '</a></li>';
    if (strlen($output_string) > 0)
        echo "";
    echo $output_string;
    echo "</ul></nav>";
    }
    /*global $post;
    $home_title = array(
        'en' => 'Home'
        ,'no' => 'Forsiden'
        ,'yo' => 'KEK'
    );
    $current_lang = the_lang();
    echo '<ul id="breadcrumb-items">';
    if (!is_home()) {
        echo '<li><a href="' . get_option('home') . '"><i class="icon-home"></i> ' . $home_title[$current_lang] . '</a></li>';
		
        if (is_category() || is_single()) {
            echo '<li>';
            the_category(' </li><li class="separator"> / </li><li> ');
            if (is_single()) {
                echo '</li><li class="separator"> / </li><li>';
                the_title();
                echo '</li>';
            }
        } elseif (is_page()) {
            if( $post->post_parent ) {
                $parents = get_post_ancestors( $post->ID );
                $title = get_the_title();
                foreach ( $parents as $parent ) {
                    $output = '<li><a href="' . get_permalink($parent) . '">' . get_the_title($parent).'</a></li>';
                }
                echo $output;
                echo '<li><strong>' . $title . '</strong></li>';
            } else {
                echo '<li><strong> ' . get_the_title() . '</strong></li>';
            }
        }
    }
    elseif (is_tag()) { single_tag_title(); }
    elseif (is_day()) { echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>'; }
    elseif (is_month()) { echo"<li>Archive for "; the_time('F, Y'); echo'</li>'; }
    elseif (is_year()) { echo"<li>Archive for "; the_time('Y'); echo'</li>'; }
    elseif (is_author()) { echo"<li>Author Archive"; echo'</li>'; }
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { echo "<li>Blog Archives"; echo'</li>'; }
    elseif (is_search()) { echo"<li>Search Results"; echo'</li>'; }
    echo '</ul>';
    //*/
}

/**
 * Image sizes
 */


/**
 * Customize image html produced
 */
 
add_filter( 'post_thumbnail_html', 'remove_image_dimensions', 10 ); 
add_filter( 'image_send_to_editor', 'remove_image_dimensions', 10 ); 
function remove_image_dimensions( $html ) { 
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	return $html;
}




add_filter('img_caption_shortcode', 'customize_image_html',10,3);
/**
 * Filter to replace the [caption] shortcode text with HTML5 compliant code
 *
 * @return text HTML content describing embedded figure
 **/
function customize_image_html($val, $attr, $content = null)
{
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> '',
		'width'	=> '',
		'caption' => ''
	), $attr));
	
	if ( 1 > (int) $width || empty($caption) )
		return $val;

	$capid = '';
	if ( $id ) {
		$id = esc_attr($id);
		$capid = 'id="figcaption_'. $id . '" ';
		$id = 'id="' . $id . '" ';// . ' aria-labelledby="figcaption_' . $id . '" ';
	}

	return '<span ' . $id . 'class="wp-caption media ' . esc_attr($align) 
	//. '" style="width: ' . (10 + (int) $width) . 'px">' . do_shortcode( $content ) . '<span ' . $capid 
	. '">' . remove_image_dimensions(do_shortcode( $content )) . '<span ' . $capid 
	. 'class="wp-caption-text caption">' . $caption . '</span></span>';
	//. '\n<!--' . var_dump($attr) . '\n-->'
	//. '\n<!--' . var_dump($attr) . '\n-->';
}
/**
 * Add sensible image size for articles.
 */
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'page-illustration', 420, 9999 ); //300 pixels wide (and unlimited height)
}

/**
 * Remove unwanted feed links in the <head>.
 */
function remove_comments_rss( $for_comments ) {
    return;
}
add_filter('post_comments_feed_link','remove_comments_rss');

/**
 * Enable the "Excerpt" field for pages
 */
add_post_type_support('page', 'excerpt');

/**
 * Remove regular editor on pages (we want content only in custom ACF fields + excerpt).
 */
/*function remove_editor() {
  remove_post_type_support('page', 'editor');
}
add_action('admin_init', 'remove_editor');*/



/* ============== BREADCRUMBS WALKER CLASS ======================*/
class WW_BreadCrumbWalker extends Walker{
    /**
     * @see Walker::$tree_type
     * @var string
     */
    var $tree_type = array( 'post_type', 'taxonomy', 'custom' );

    /**
     * @see Walker::$db_fields
     * @var array
     */
    var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

    /**
     * delimiter for crumbs
     * @var string
     */
    var $delimiter = '';// ' / ';

    /**
     * @see Walker::start_el()
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item Menu item data object.
     * @param int $depth Depth of menu item.
     * @param int $current_page Menu item ID.
     * @param object $args
     */
    //function start_el( &$output, $object, $depth = 0, $args = array(), $current_object_id = 0 )  {
    function start_el(&$output, $item, $depth, $args) {

        //Check if menu item is an ancestor of the current page
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $current_identifiers = array( 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor' ); 
        $ancestor_of_current = array_intersect( $current_identifiers, $classes );     


        if( $ancestor_of_current ){
            $title = apply_filters( 'the_title', $item->title, $item->ID );

            // Preceed with delimter for all but the first item.
            if( 0 != $depth ) {
                $output .= $this->delimiter;
            }
            //if ($item->object_id === get_the_ID()) {
                //Link tag attributes
                $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
                $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
                $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
                $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

                //Add to the HTML output
                $output .= '<li><a data-depth="' . $depth . '"'. $attributes .'>'.$title.'</a></li>';
            //} else {
            //    $output .= $title;
            //}
        }
    }
}





/**
 * Twenty Twelve functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 625;

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Twenty Twelve supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links,
 * 	custom background, and post formats.
 * @uses register_nav_menu() To add support for navigation menus.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Twelve 1.0
 */
function legendary_lodge_setup() {
	/*
	 * Makes Twenty Twelve available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Twelve, use a find and replace
	 * to change 'twentytwelve' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'legendary-lodge', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Adds RSS feed links to <head> for posts and comments.
	//add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'legendary-lodge' ) );

	/*
	 * This theme supports custom background color and image, and here
	 * we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop

	// REMOVE UNWANTED STUFF
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rsd_link');
}
add_action( 'after_setup_theme', 'legendary_lodge_setup' );

/**
 * Adds support for a custom header image.
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Enqueues scripts and styles for front-end.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		//wp_enqueue_script( 'comment-reply' );

	/*
	 * Adds JavaScript for handling the navigation menu hide-and-show behavior.
	 */
	//wp_enqueue_script( 'twentytwelve-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true );

	/*
	 * Loads our special font CSS file.
	 *
	 * The use of Open Sans by default is localized. For languages that use
	 * characters not supported by the font, the font can be disabled.
	 *
	 * To disable in a child theme, use wp_dequeue_style()
	 * function mytheme_dequeue_fonts() {
	 *     wp_dequeue_style( 'twentytwelve-fonts' );
	 * }
	 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
	 */

	/* translators: If there are characters in your language that are not supported
	   by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'twentytwelve' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language, translate
		   this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'twentytwelve' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400italic,700italic,400,700',
			'subset' => $subsets,
		);
		//wp_enqueue_style( 'twentytwelve-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}

	/*
	 * Loads the main stylesheet.
	 */
	//wp_enqueue_style( 'twentytwelve-style', get_stylesheet_uri() );
	wp_enqueue_style( 'legendary-lodge-style', get_stylesheet_uri(), array(), get_mod_time(get_stylesheet_uri()) );
	
	/*
	 * Loads the navigation-specific stylesheet.
	 */
	wp_enqueue_style( 'legendary-lodge-nav', get_template_directory_uri() . '/css/nav.css', array( 'legendary-lodge-style' ), get_mod_time('/css/nav.css') );
	wp_enqueue_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Oswald:400,300,700|Roboto:400,400italic,700,700italic|Open+Sans+Condensed:300,300italic,700|Lora:400,700,400italic,700italic', array( 'legendary-lodge-style' ));

	/*
	 * Loads the IE-specific stylesheet.
	 */
	wp_enqueue_style( 'ie-fixes', get_template_directory_uri() . '/css/ie.css', array( 'legendary-lodge-style' ), get_mod_time('/css/ie.css') );	
	$wp_styles->add_data( 'ie-fixes', 'conditional', 'lt IE 9' );
	
	/*
	 * Loads common scripts, e.g. Modernizr, jQuery, etc.
	 */
	 wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.89196.js', array(), get_mod_time('/js/modernizr.custom.89196.js'));
	 wp_enqueue_script( '_jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js', array()); // WordPress has tabs on the 'jquery' ID, so we'll need to use something else here ('_jquery').
	 wp_enqueue_script( 'legendary-lodge-js', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), get_mod_time('/js/main.js') );
	
	/*
	 * Loads the HTML5 shiv for old versions of IE. (Conditional possible only for CSS, so this is hard-coded in header.php instead ...)
	 */
	//wp_enqueue_script( 'html5-shiv', get_template_directory_uri() . '/js/html5.js', array(), '20141023' );
	//$wp_scripts->add_data( 'html5-shiv', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'twentytwelve_scripts_styles' );

/**
 * Gets a number indicating when the given file was last modified.
 *
 * @param string $file_path The path of the file, relative to the theme directory, e.g. '/js/myscript.js'.
 * @return string A number indicating when the given file was last modified.
 */
function get_mod_time( $file_path ) {
	$tdu = get_template_directory_uri();
	$fp = $file_path;
	
	// If path started with template directory URI, remove it first
	if (strpos($fp, $tdu) === 0)
		$fp = str_replace($tdu, "", $fp);
		
	return ''. filemtime(get_template_directory() . $fp);
}

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Twenty Twelve 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function twentytwelve_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'twentytwelve_wp_title', 10, 2 );

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) )
		$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentytwelve_page_menu_args' );

/**
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'twentytwelve' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'First Front Page Widget Area', 'twentytwelve' ),
		'id' => 'sidebar-2',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Second Front Page Widget Area', 'twentytwelve' ),
		'id' => 'sidebar-3',
		'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'twentytwelve' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentytwelve_widgets_init' );

if ( ! function_exists( 'twentytwelve_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
			<div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentytwelve' ) ); ?></div>
			<div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;

if ( ! function_exists( 'twentytwelve_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentytwelve_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'twentytwelve' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite class="fn">%1$s %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'twentytwelve' ) . '</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'twentytwelve' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentytwelve' ); ?></p>
			<?php endif; ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'twentytwelve' ), '<p class="edit-link">', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'twentytwelve' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

if ( ! function_exists( 'twentytwelve_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own twentytwelve_entry_meta() to override in a child theme.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'twentytwelve' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'twentytwelve' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'twentytwelve' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'twentytwelve' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

/**
 * Extends the default WordPress body class to denote:
 * 1. Using a full-width layout, when no active widgets in the sidebar
 *    or full-width template.
 * 2. Front Page template: thumbnail in use and number of sidebars for
 *    widget areas.
 * 3. White or empty background color to change the layout and spacing.
 * 4. Custom fonts enabled.
 * 5. Single or multiple authors.
 *
 * @since Twenty Twelve 1.0
 *
 * @param array Existing class values.
 * @return array Filtered class values.
 */
function twentytwelve_body_class( $classes ) {
	$background_color = get_background_color();

	if ( ! is_active_sidebar( 'sidebar-1' ) || is_page_template( 'page-templates/full-width.php' ) )
		$classes[] = 'full-width';

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() )
			$classes[] = 'has-post-thumbnail';
		if ( is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
			$classes[] = 'two-sidebars';
	}

	if ( empty( $background_color ) )
		$classes[] = 'custom-background-empty';
	elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
		$classes[] = 'custom-background-white';

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'twentytwelve-fonts', 'queue' ) )
		$classes[] = 'custom-font-enabled';

	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'twentytwelve_body_class' );

/**
 * Adjusts content_width value for full-width and single image attachment
 * templates, and when there are no active widgets in the sidebar.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_content_width() {
	if ( is_page_template( 'page-templates/full-width.php' ) || is_attachment() || ! is_active_sidebar( 'sidebar-1' ) ) {
		global $content_width;
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'twentytwelve_content_width' );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since Twenty Twelve 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 * @return void
 */
function twentytwelve_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action( 'customize_register', 'twentytwelve_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Twenty Twelve 1.0
 */
function twentytwelve_customize_preview_js() {
	wp_enqueue_script( 'twentytwelve-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20120827', true );
}
add_action( 'customize_preview_init', 'twentytwelve_customize_preview_js' );
