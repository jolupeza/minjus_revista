<?php
/***************************************/
/* Define Constants */
/***************************************/
define('THEMEROOT', get_stylesheet_directory_uri());
define('IMAGES', THEMEROOT . '/images');
define('THEMEDOMAIN', 'revista-framework');

/***************************************/
/* Load JS Files */
/***************************************/
function load_custom_scripts() {
  wp_enqueue_script('vendor_script', THEMEROOT . '/js/vendor.min.js', array('jquery'), false, true);
  wp_enqueue_script('custom_script', THEMEROOT . '/js/app.min.js', array('jquery'), false, true);
  wp_enqueue_script('main_script', THEMEROOT . '/js/main.js', array('jquery'), false, true);
  wp_localize_script('custom_script', 'RevistaAjax', array('url' => admin_url('admin-ajax.php'), 'nonce' => wp_create_nonce('revistaajax-nonce')));
}
add_action('wp_enqueue_scripts', 'load_custom_scripts');

/***************************************/
/* Add Theme Support */
/***************************************/
if (function_exists('add_theme_support')) {
  // add_theme_support('post-formats', array('link', 'quote', 'gallery', 'video'));

  add_theme_support('post-thumbnails', array('post', 'page', 'team', 'publications'));
  //set_post_thumbnail_size(210, 210, true);
  // add_image_size('post-thumb', 320, 240, true);
  // add_image_size('page-gallery', 375, 234, true);
  // add_image_size('events-large', 362, 593, true);

  //add_theme_support('automatic-feed-links');
}

/***************************************/
/* Add Menus */
/***************************************/
function register_my_menus() {
  register_nav_menus(
    [
      'main-menu' => __( 'Main Menu', THEMEDOMAIN ),
      'footer-left-menu' => __( 'Enlaces Footer Izquierda', THEMEDOMAIN ),
      'footer-links-menu' => __( 'Enlaces Footer Derecha', THEMEDOMAIN ),
    ]
  );
}
add_action('init', 'register_my_menus');

/***************************************/
/* Add Logo Theme */
/***************************************/
function my_theme_setup() {
  add_theme_support('custom-logo', [
    'height' => 76,
    'width' => 346,
    'flex-height' => true
  ]);
}
add_action('after_setup_theme', 'my_theme_setup');

/***************************************/
/* Custom Breadbcrumbs */
/***************************************/
function custom_breadcrumbs() {
  // Settings
  $separator          = '/';
  // $breadcrums_id      = 'breadcrumbs';
  $breadcrums_class   = 'Breadcrumb';
  $home_title         = 'Inicio';

  // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
  $custom_taxonomy    = 'product_cat';

  // Get the query & post information
  global $post, $wp_query;

  // Do not display on the homepage
  if ( !is_front_page() ) {
      // Build the breadcrums
      // echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';
      echo '<ul class="' . $breadcrums_class . '">';

      // Home page
      echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
      echo '<li class="separator separator-home"> ' . $separator . ' </li>';

      if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
        echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title('', false) . '</strong></li>';
        // echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
      } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
        // If post is a custom post type
        $post_type = get_post_type();

        // If it is a custom post type display name and link
        if($post_type != 'post') {
          $post_type_object = get_post_type_object($post_type);
          $post_type_archive = get_post_type_archive_link($post_type);

          echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
          echo '<li class="separator"> ' . $separator . ' </li>';
        }

        $custom_tax_name = get_queried_object()->name;
        echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
      } else if ( is_single() ) {
        // If post is a custom post type
        $post_type = get_post_type();

        // If it is a custom post type display name and link
        if($post_type != 'post') {
          $post_type_object = get_post_type_object($post_type);
          $post_type_archive = get_post_type_archive_link($post_type);

          echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
          echo '<li class="separator"> ' . $separator . ' </li>';
        }

        // Get post category info
        $category = get_the_category();

        if(!empty($category)) {
          // Get last category post is in
          $last_category = end(array_values($category));

          // Get parent any categories and create array
          $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
          $cat_parents = explode(',',$get_cat_parents);

          // Loop through parent categories and store in variable $cat_display
          $cat_display = '';
          foreach($cat_parents as $parents) {
            $cat_display .= '<li class="item-cat">'.$parents.'</li>';
            $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
          }
        }

        // If it's a custom post type within a custom taxonomy
        $taxonomy_exists = taxonomy_exists($custom_taxonomy);
        if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {
          $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
          $cat_id         = $taxonomy_terms[0]->term_id;
          $cat_nicename   = $taxonomy_terms[0]->slug;
          $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
          $cat_name       = $taxonomy_terms[0]->name;
        }

        // Check if the post is in a category
        if(!empty($last_category)) {
          echo $cat_display;
          echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
        // Else if post is in a custom taxonomy
        } else if(!empty($cat_id)) {
          echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
          echo '<li class="separator"> ' . $separator . ' </li>';
          echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
        } else {
          echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
        }
      } else if ( is_category() ) {
        // Category page
        echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
      } else if ( is_page() ) {
        // Standard page
        if( $post->post_parent ) {
          // If child page, get parents
          $anc = get_post_ancestors( $post->ID );

          // Get parents in the right order
          $anc = array_reverse($anc);

          // Parent page loop
          if ( !isset( $parents ) ) $parents = null;
          foreach ( $anc as $ancestor ) {
            $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
            $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
          }

          // Display parent pages
          echo $parents;

          // Current page
          echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';

        } else {
          // Just display current page if not parents
          echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
        }
      } else if ( is_tag() ) {
        // Tag page

        // Get tag information
        $term_id        = get_query_var('tag_id');
        $taxonomy       = 'post_tag';
        $args           = 'include=' . $term_id;
        $terms          = get_terms( $taxonomy, $args );
        $get_term_id    = $terms[0]->term_id;
        $get_term_slug  = $terms[0]->slug;
        $get_term_name  = $terms[0]->name;

        // Display the tag name
        echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
      } elseif ( is_day() ) {
        // Day archive

        // Year link
        echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
        echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

        // Month link
        echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
        echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

        // Day display
        echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
      } else if ( is_month() ) {
        // Month Archive

        // Year link
        echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
        echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

        // Month display
        echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
      } else if ( is_year() ) {
        // Display year archive
        echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
      } else if ( is_author() ) {
        // Auhor archive

        // Get the author information
        global $author;
        $userdata = get_userdata( $author );

        // Display author name
        echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
      } else if ( get_query_var('paged') ) {
        // Paginated archives
        echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
      } else if ( is_search() ) {
        // Search results page
        echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Buscador: ' . get_search_query() . '">Buscador: ' . get_search_query() . '</strong></li>';
        // echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
      } elseif ( is_404() ) {
        // 404 page
        echo '<li>' . 'Error 404' . '</li>';
      }

      echo '</ul>';
  }
}

/*****************************************************************/
/* Add Support excerpt to page */
/*****************************************************************/
function revista_add_excerpt_support_for_pages() {
  add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'revista_add_excerpt_support_for_pages' );

/***********************************************************/
/* Get team via ajax */
/***********************************************************/
add_action('wp_ajax_get_team', 'get_team_callback');
add_action('wp_ajax_nopriv_get_team', 'get_team_callback');

function get_team_callback()
{
  $nonce = $_POST['nonce'];
  $result = array(
    'result' => false,
    'error' => '',
    'data' => []
  );

  if (!wp_verify_nonce($nonce, 'revistaajax-nonce')) {
      die('¡Acceso denegado!');
  }

  $page = (int)$_POST['page'];

  if ($page > 0) {
    $args = [
      'post_type' => 'team',
      'posts_per_page' => 9,
      'orderby' => 'menu_order',
      'order' => 'ASC',
      'offset' => ( $page - 1 ) * 9
    ];
    $the_query = new WP_Query($args);

    if ($the_query->have_posts()) {
      ob_start();

      if (file_exists(TEMPLATEPATH . '/includes/team-ajax.php')) {
        include TEMPLATEPATH . '/includes/team-ajax.php';
      }

      $content = ob_get_contents();

      ob_get_clean();

      $result['data']['content'] = $content;

      $result['result'] = true;
    } else {
      $result['error'] = 'Datos no encontrado';
    }
    wp_reset_postdata();
  } else {
    $result['error'] = 'Por favor vuelva a intentarlo';
  }

  echo json_encode($result);
  die();
}

/***********************************************************/
/* Include posts from authors in the search */
/***********************************************************/
add_filter( 'posts_search', 'db_filter_authors_search' );

function db_filter_authors_search( $posts_search ) {
  // Don't modify the query at all if we're not on the search template
  // or if the LIKE is empty
  if ( !is_search() || empty( $posts_search ) ) {
    return $posts_search;
  }

  global $wpdb;

  // Get all of the users of the blog and see if the search query matches either
  // the display name or the user login
  add_filter( 'pre_user_query', 'db_filter_user_query' );
  $search = sanitize_text_field( get_query_var( 's' ) );
  $args = array(
    'count_total' => false,
    'search' => sprintf( '*%s*', $search ),
    'search_fields' => array(
      'display_name',
      'user_login',
    ),
    'fields' => 'ID',
  );
  $matching_users = get_users( $args );
  remove_filter( 'pre_user_query', 'db_filter_user_query' );

  // Don't modify the query if there aren't any matching users
  if ( empty( $matching_users ) ) {
    return $posts_search;
  }

  // Take a slightly different approach than core where we want all of the posts from these authors
  $posts_search = str_replace( ')))', ")) OR ( {$wpdb->posts}.post_author IN (" . implode( ',', array_map( 'absint', $matching_users ) ) . ")))", $posts_search );
  return $posts_search;
}

/**
 * Modify get_users() to search display_name instead of user_nicename
 */
function db_filter_user_query( &$user_query ) {
  if ( is_object( $user_query ) )
    $user_query->query_where = str_replace( "user_nicename LIKE", "display_name LIKE", $user_query->query_where );
  return $user_query;
}


/****************************************************/
/* Load Theme Options Page and Custom Widgets */
/****************************************************/
require_once(TEMPLATEPATH . '/functions/revista-theme-customizer.php');

/*
 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
 * @author Joost van Veen
 * @version 1.0
 */
if (!function_exists('dump')) {
  function dump($var, $label = 'Dump', $echo = true) {
    // Store dump in variable
    ob_start();
    var_dump($var);
    $output = ob_get_clean();

    // Add formatting
    $output = preg_replace("/\]\=\>\n(\s+)/m", '] => ', $output);
    $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">'.$label.' => '.$output.'</pre>';

    // Output
    if ($echo == true) {
      echo $output;
    } else {
      return $output;
    }
  }
}

if (!function_exists('dump_exit')) {
  function dump_exit($var, $label = 'Dump', $echo = true) {
    dump($var, $label, $echo);
    exit;
  }
}
