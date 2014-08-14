<?php

/**
 * Register Post Types and Taxonomies
 */

if ( !class_exists( 'FM_Demo_Data_Structures' ) ) :

class FM_Demo_Data_Structures {

	private static $instance;

	private $post_types = array();

	private $taxonomies = array();

	private function __construct() {
		/* Don't do anything, needs to be initialized via instance() method */
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new FM_Demo_Data_Structures;
			self::$instance->setup();
		}
		return self::$instance;
	}

	public function setup() {
		add_action( 'init', array( $this, 'register' ) );
	}

	public function add_post_type( $type, $args ) {
		$this->post_types[ $type ] = $args;
	}

	public function add_taxonomy( $taxonomy, $args ) {
		$this->taxonomies[ $taxonomy ] = $args;
	}

	public function register() {
		foreach ( $this->post_types as $type => $args ) {
			$singular = ( ! empty( $args['singular'] ) ) ? $args['singular'] : $this->titleize( $type );
			$plural = ( ! empty( $args['plural'] ) ) ? $args['plural'] : $singular . 's';

			register_post_type( $type, array_merge( $args, array(
				'public' => true,
				'supports' => array( 'title' ),
				'menu_icon' => 'dashicons-images-alt2',
				'labels' => array(
					'name'               => $plural,
					'singular_name'      => $singular,
					'add_new'            => 'Add New',
					'add_new_item'       => 'Add New ' . $singular,
					'edit_item'          => 'Edit ' . $singular,
					'new_item'           => 'New ' . $singular,
					'all_items'          => 'All ' . $plural,
					'view_item'          => 'View ' . $singular,
					'search_items'       => 'Search ' . $plural,
					'not_found'          => 'No ' . $plural . ' found',
					'not_found_in_trash' => 'No ' . $plural . ' found in Trash',
					'parent_item_colon'  => '',
					'menu_name'          => $plural
				)
			) ) );
		}

		foreach ( $this->taxonomies as $taxonomy => $args ) {
			$singular = ( ! empty( $args['singular'] ) ) ? $args['singular'] : $this->titleize( $taxonomy );
			$plural = ( ! empty( $args['plural'] ) ) ? $args['plural'] : $singular . 's';

			register_taxonomy( $taxonomy, $args['post_type'], array_merge( $args, array(
				'labels' => array(
					'name'                       => $plural,
					'singular_name'              => $singular,
					'search_items'               => 'Search ' . $plural,
					'popular_items'              => 'Popular ' . $plural,
					'all_items'                  => 'All ' . $plural,
					'parent_item'                => 'Parent ' . $singular,
					'parent_item_colon'          => "Parent {$singular}:",
					'edit_item'                  => 'Edit ' . $singular,
					'update_item'                => 'Update ' . $singular,
					'add_new_item'               => 'Add New ' . $singular,
					'new_item_name'              => "New {$singular} Name",
					'separate_items_with_commas' => "Separate {$plural} with commas",
					'add_or_remove_items'        => "Add or remove {$plural}",
					'choose_from_most_used'      => "Choose from the most used {$plural}",
					'not_found'                  => "No {$plural} found.",
					'menu_name'                  => $plural,
					
				)
			) ) );
		}
	}

	public static function titleize( $field ) {
		$search = array( '-', '_' );
		$replace = array( ' ', ' ' );
		return ucwords( str_replace( $search, $replace, $field ) );
	}
}

function FM_Demo_Data_Structures() {
	return FM_Demo_Data_Structures::instance();
}

endif;


add_filter( 'manage_edit-neat-slider_columns', 'my_edit_movie_columns' ) ;

function my_edit_movie_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Sliders' ),
		'shortcode' => __( 'Shortcode' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action( 'manage_neat-slider_posts_custom_column', 'my_manage_neatslider_columns', 10, 2 );

function my_manage_neatslider_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'duration' column. */
		case 'shortcode' :

			/* Get the post meta. */

			global $post;
    		$id = $post->ID;  

			$duration = get_post_meta( $post_id, 'duration', true );

			/* If no duration is found, output a default message. */
			echo '[neat-slider id=&quot;'.  $id .'&quot;]';

			break;
  
		default :
			break;
	}
}


// Add Shortcode
function neat_slider( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'id' => '',
		), $atts )
	);

 	$args = array(
		'post_type'=> 'neat-slider',
		'p'    => $id, 
	);

	global $post;
    	$sliderid = $post->ID; 

	query_posts( $args );
	 
    if ( have_posts() ) :
	while ( have_posts() ) : the_post();
 
 	  $neat_slides = get_post_meta($post->ID,'neat_slides');
	  $slider_settings = get_post_meta($post->ID,'slider_settings'); 

		$slider_width = $slider_settings[0]['Layout_group']['slider_width'];
		$slider_height = $slider_settings[0]['Layout_group']['slider_height'];
		$fullWidth = $slider_settings[0]['Layout_group']['fullWidth'];

		$slides_transition = $slider_settings[0]['slides_transition_group']['slides_transition'];
		$slide_tspeed = $slider_settings[0]['slides_transition_group']['slide_tspeed'];
		$slide_endani = $slider_settings[0]['slides_transition_group']['slide_endani'];
		$slide_timeout = $slider_settings[0]['slides_transition_group']['slide_timeout'];
		$slide_speedIn = $slider_settings[0]['slides_transition_group']['slide_speedIn'];
		$slide_speedOut = $slider_settings[0]['slides_transition_group']['slide_speedOut'];

		$slider_controls = $slider_settings[0]['slider_appearance_group']['slider_controls'];
		$slider_pager = $slider_settings[0]['slider_appearance_group']['slider_pager'];
		$slider_pauseonhover = $slider_settings[0]['slider_appearance_group']['slider_pauseonhover'];
		$slider_autochange = $slider_settings[0]['slider_appearance_group']['slider_autochange'];

	  $list = '<div class="slider-wrapper">'; 
	  $list .= '<div class="neat-slider-'.$sliderid.' fr-slider" style="max-width:'. $slider_width .'px;">';
	  $list .= '<div class="fs_loader"></div>'; 

	foreach ($neat_slides[0] as $key => $value) {  
 	  $slide_image = wp_get_attachment_url($value['slide'],'full');
	  $list .= '<div class="slide">';

	  $list .= '<img data-fixed class="slide-bg" src=" '. $slide_image .' " alt=" '. get_the_title($value['slide'],'full') .' "> '; 

		foreach ($value['repeatable_group'] as $subkey => $subvalue) { 
 
			$content_image = $subvalue['content_group']['content-image'];
			$content_text  = $subvalue['content_group']['content-text'];
			$content_html  = $subvalue['content_group']['content-html'];

			$top_position  = $subvalue['position_group']['top-position'];
			$left_position = $subvalue['position_group']['left-position'];

			$data_in = $subvalue['transition_group']['data-in'];
			$data_out = $subvalue['transition_group']['data-out'];
			$delay = $subvalue['transition_group']['delay'];
			$easingin = $subvalue['transition_group']['easingin'];
			$easingout = $subvalue['transition_group']['easingout'];
			$data_step = $subvalue['transition_group']['data-step'];

			$data_special = $subvalue['transition_group']['data-special']; 

			$custom_styles = $subvalue['style_group']['custom-styles']; 
 
			$list .= '<div data-position="'. $top_position .','. $left_position .'" data-in="'. $data_in .'"  data-out="'. $data_out .'"  data-delay="'. $delay .'" data-ease-in="'. $easingin .'" data-ease-out="'. $easingout .'" ';

			if ($data_step) {
			$list .=' data-step="'. $data_step  .'"'; 
			 }

			 if ($data_special) { 
			 	$list .='data-special="cycle" ';
			 }
			 $list .=' class="caption" style="'. $custom_styles .'"  >'; 
			 
				if ($content_html) {
					$list .= ' '. $content_html .'';
				} elseif ($content_text) {
					$list .= ' '. $content_text .'';
				} else {
					$list .= ' '. wp_get_attachment_image($content_image,'full') .'';
				}
				
			$list .= '</div>';
			}   

	  $list .= '</div>';

	} 

	  $list .= '</div>';
	  $list .= '</div>';
	  $list .= '<script type="text/javascript">
	  				 $(window).load(function(){
	  				 	$(".neat-slider-'. $sliderid .'").fractionSlider({
	  				 		"fullWidth": '. $fullWidth .',
	  				 		"slideTransition": "'.$slides_transition .'",
	  				 		"slideTransitionSpeed" :'. $slide_tspeed .', 
	  				 		"slideEndAnimation" : '. $slide_endani .',
	  				 		"controls": '. $slider_controls .',
	  				 		"pager": '. $slider_pager .',
	  				 		"speedIn" : '. $slide_speedIn .',
	  				 		"speedOut" : '. $slide_speedOut .',
	  				 		"timeout" : '.  $slide_timeout .',
	  				 		"pauseOnHover" :  '. $slider_pauseonhover .', 
	  				 		"autoChange": '. $slider_autochange .',
	  				 		"responsive":  true,
	  				 		"increase": true,
	  				 		"dimensions": "'. $slider_width.','. $slider_height .'",
	  				}); });</script> ';

			if ( $fullWidth == 'true' ) { 

				$list .= ' <script type="text/javascript">
	  			$(window).load(function(){ 
	  				var viewportWidth = $(window).width();
	  				var colWidth = $(".container").width(); 
	  				var viewportHeight = $(window).height();
	  				var divideval = 2 ; 
	  				var marginslidebg = (viewportWidth - colWidth) / divideval  ; 

	  				if (viewportWidth > 1200) {
	  					$(".slide-bg").css({"width": viewportWidth,"max-width": viewportWidth,"margin-left":"-"+marginslidebg+"px", });
	  					$(".slider-wrapper").css({"width": viewportWidth,"max-width": viewportWidth,"margin-left":"-"+marginslidebg+"px",});
	  				} else
	  				{
	  					$(".slide-bg").css({"width": viewportWidth,"max-width": viewportWidth,"margin-left":"0px",});
	  					$(".slider-wrapper").css({"width": viewportWidth,"max-width": viewportWidth,"margin-left":"-"+marginslidebg+"px",});  
	  				}
	  			$(window).resize(function() {
	  				var viewportWidth = $(window).width();
	  				var colWidth = $(".container").width(); 
	  				var viewportHeight = $(window).height();
	  				var divideval = 2 ; 
	  				var marginslidebg = (viewportWidth - colWidth) / divideval  ; 
	  				if (viewportWidth > 1200) {
	  					$(".slide-bg").css({"width": viewportWidth,"max-width": viewportWidth,"margin-left":"-"+marginslidebg+"px", });
	  					$(".slider-wrapper").css({"width": viewportWidth,"max-width": viewportWidth,"margin-left":"-"+marginslidebg+"px",});
	  				} else
	  				{
	  					$(".slide-bg").css({"width": viewportWidth,"max-width": viewportWidth,"margin-left":"0px",});
	  					$(".slider-wrapper").css({"width": viewportWidth,"max-width": viewportWidth,"margin-left":"-"+marginslidebg+"px",});  
	  				}
	  			});

 				  });</script>';
 			}  

	endwhile;
	else :
	   $list .= 'Sorry, no posts were found';
	endif;
	 return force_balance_tags( $list );

}
add_shortcode( 'neat-slider', 'neat_slider' );


add_filter('the_content', 'remove_empty_tags_recursive', 20, 1);
function remove_empty_tags_recursive ($str, $repto = NULL) {
         $str = force_balance_tags($str);
         //** Return if string not given or empty.
         if (!is_string ($str)
         || trim ($str) == '')
        return $str;

        //** Recursive empty HTML tags.
       return preg_replace (

              //** Pattern written by Junaid Atari.
              '/<([^<\/>]*)>([\s]*?|(?R))<\/\1>/imsU',

             //** Replace with nothing if string empty.
             !is_string ($repto) ? '' : $repto,

            //** Source string
           $str
);}




