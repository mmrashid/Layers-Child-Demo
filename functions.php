<?php

/**
 * Layers Child Theme Custom Functions
 * Replace layers_child in examples with your own child theme name!
**/
require_once get_stylesheet_directory() . '/includes/presets.php';

/**
 * Localize
 * Since 1.0
 */
 if( ! function_exists( 'layers_child_localize' ) ) {
	 
	add_action('after_setup_theme', 'layers_child_localize');

	function layers_child_localize(){
		load_child_theme_textdomain( 'layers-child' , get_stylesheet_directory().'/languages');
	}
 }

/* Set Font and Theme Defaults
* * http://docs.layerswp.com/?p=2290
* Since 1.0
*/
add_filter( 'layers_customizer_control_defaults', 'layers_child_customizer_defaults' );

function layers_child_customizer_defaults( $defaults ){

 $defaults = array(
       'body-fonts' => 'Lato',
       'form-fonts' => 'Lato',
       'header-menu-layout' => 'header-logo-left',
       'header-background-color' => 'transparent',
       'header-width' => 'layout-boxed',
       'header-sticky' => '1',
	   'header-overlay' => '1',
       'heading-fonts' => 'Mandali',
       'footer-sidebar-count' => '0',
 );

 return $defaults;
}

 /* Enqueue Child Theme Scripts & Styles 
 ** http://codex.wordpress.org/Function_Reference/wp_enqueue_style
 * Since 1.0
 */
 
add_action( 'wp_enqueue_scripts', 'layers_child_styles' );	

if( ! function_exists( 'layers_child_styles' ) ) {	

	function layers_child_styles() {	
					
		wp_enqueue_style(
			'layers-parent-style',
			get_template_directory_uri() . '/style.css',
			array()
		); // Parent Stylsheet for Version info

		
	}
	
}
if( ! function_exists( 'layers_child_scripts' ) ) {
		
	function layers_child_scripts() {
		
		wp_enqueue_script(
			'layers-child' . '-custom',
			get_stylesheet_directory() . '/assets/js/theme.js',
			array(
				'jquery', // make sure this only loads if jQuery has loaded
			)
		); // Custom Child Theme jQuery  
		
	}
	
}
// Output this in the footer before anything else
// http://codex.wordpress.org/Plugin_API/Action_Reference/wp_footer
add_action('wp_enqueue_scripts', 'layers_child_scripts'); 
 
/**
 * Set the post editor content width based on the theme's design and stylesheet.
 * Since 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 720; /* pixels */
}

/**
 * Adjust the post editor content width when the full width page template is being used
 * Filter existing function to replace with our code
 */
if( ! function_exists( 'layers_child_set_content_width' ) ) {	

	 add_filter( 'layers_set_content_width', 'layers_child_set_content_width', 2, 2 );
	
	 function layers_child_set_content_width() {
		global $content_width;
	
		if ( is_page_template( 'full-width.php' ) ) {
			$content_width = 1120;
		} elseif( is_singular() ) {
			$content_width = 720;
		}
	 }
 
}

 /* Add Excerpt Support for Pages 
 ** http://codex.wordpress.org/Function_Reference/add_post_type_support
 * Since 1.0 
 */
 if( ! function_exists( 'layers_child_add_excerpts_to_pages' ) ) {	
 
 	add_action( 'init', 'layers_child_add_excerpts_to_pages' );
 
	function layers_child_add_excerpts_to_pages() {
		add_post_type_support( 'page', 'excerpt' );
	}
	
 }


 /**
 * Add the title banner to all builder pages other than home
 ** http://codex.oboxsites.com/reference/before_layers_builder_widgets/
 * Since 1.0
 */
 add_action('layers_after_builder_widgets', 'layers_child_builder_title');
 if(! function_exists( 'layers_child_builder_title' )) {	
		
	function layers_child_builder_title() {
	  if(!is_front_page()) {
		get_template_part( 'partials/header' , 'page-title' );
	  }
	}
	
 }
  /**
 * Customize list post meta to show author and date above the excerpt
 ** http://docs.layerswp.com/reference/layers_before_…t_post_content/
 * Since 1.0
 */
 
add_action('layers_before_list_post_content', 'my_list_author');

if(! function_exists('my_list_author') ) {
    function my_list_author() { 
     layers_post_meta( get_the_ID(), array( 'author', 'date' ) , 'h5', 'meta-info' );
    }
}