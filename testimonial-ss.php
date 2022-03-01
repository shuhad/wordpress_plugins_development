<?php
/**
 * Plugin Name:       Testimonial
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sheikh Shuhad
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */


 // Register Custom Post Type Testimonial
function create_testimonial_cpt() {

	$labels = array(
		'name' => _x( 'Testimonials', 'Post Type General Name', 'textdomain' ),
		'singular_name' => _x( 'Testimonial', 'Post Type Singular Name', 'textdomain' ),
		'menu_name' => _x( 'Testimonials', 'Admin Menu text', 'textdomain' ),
		'name_admin_bar' => _x( 'Testimonial', 'Add New on Toolbar', 'textdomain' ),
		'archives' => __( 'Testimonial Archives', 'textdomain' ),
		'attributes' => __( 'Testimonial Attributes', 'textdomain' ),
		'parent_item_colon' => __( 'Parent Testimonial:', 'textdomain' ),
		'all_items' => __( 'All Testimonials', 'textdomain' ),
		'add_new_item' => __( 'Add New Testimonial', 'textdomain' ),
		'add_new' => __( 'Add New', 'textdomain' ),
		'new_item' => __( 'New Testimonial', 'textdomain' ),
		'edit_item' => __( 'Edit Testimonial', 'textdomain' ),
		'update_item' => __( 'Update Testimonial', 'textdomain' ),
		'view_item' => __( 'View Testimonial', 'textdomain' ),
		'view_items' => __( 'View Testimonials', 'textdomain' ),
		'search_items' => __( 'Search Testimonial', 'textdomain' ),
		'not_found' => __( 'Not found', 'textdomain' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
		'featured_image' => __( 'Featured Image', 'textdomain' ),
		'set_featured_image' => __( 'Set featured image', 'textdomain' ),
		'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
		'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
		'insert_into_item' => __( 'Insert into Testimonial', 'textdomain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Testimonial', 'textdomain' ),
		'items_list' => __( 'Testimonials list', 'textdomain' ),
		'items_list_navigation' => __( 'Testimonials list navigation', 'textdomain' ),
		'filter_items_list' => __( 'Filter Testimonials list', 'textdomain' ),
	);
	$args = array(
		'label' => __( 'Testimonial', 'textdomain' ),
		'description' => __( '', 'textdomain' ),
		'labels' => $labels,
		'menu_icon' => 'dashicons-admin-comments',
		'supports' => array('title', 'editor', 'thumbnail'),
		'taxonomies' => array(),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 20,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'has_archive' => false,
		'hierarchical' => false,
		'exclude_from_search' => false,
		'show_in_rest' => false,
		'publicly_queryable' => true,
		'capability_type' => 'post',
	);
	register_post_type( 'testimonial', $args );

}
add_action( 'init', 'create_testimonial_cpt', 0 );


/**
 * Proper way to enqueue scripts and styles
 */
function wpdocs_theme_name_scripts() {
    wp_enqueue_style( 'bootstrap', plugin_dir_url( __FILE__ ).'bootstrap.min.css' );
}
add_action( 'wp_enqueue_scripts', 'wpdocs_theme_name_scripts' );


// Create Shortcode get_testimonials
// Shortcode: [get_testimonials post_count="3"]
function create_gettestimonials_shortcode($atts) {

	$atts = shortcode_atts(
		array(
			'post_count' => '3',
		),
		$atts,
		'get_testimonials'
	);

	$post_count = $atts['post_count'];

    // Custom WP query query
$args_query = array(
	'post_type' => array('testimonial'),
	'post_status' => array('published'),
	'posts_per_page' => $post_count,
	'order' => 'DESC',
);

$query = new WP_Query( $args_query );
$op;
$op .='<div class="row" >';
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
        $op .='<div class="col-md-6" >';
        $op .='<div class="card" >';
        
        $op .='<img src="'.get_the_post_thumbnail_url().'" class="card-img-top" alt="...">';
        $op .='<div class="card-body">';
        $op .='<h5 class="card-title">'.get_the_title().'</h5>';
        $op .='<p class="card-text">'.get_the_content().'</p>';
        $op .='</div>
</div>
</div>';



	}
    $op .='</div>';

} else {

}

wp_reset_postdata();


    return $op;

}
add_shortcode( 'get_testimonials', 'create_gettestimonials_shortcode' );

?>