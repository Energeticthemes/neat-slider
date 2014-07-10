<?php

/**
 *
 */

if ( !class_exists( 'Neat_slider_fields' ) ) :

class Neat_slider_fields {

	private static $instance;

	private function __construct() {
		/* Don't do anything, needs to be initialized via instance() method */
	}

	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Neat_slider_fields;
			self::$instance->setup();
		}
		return self::$instance;
	}

	public function setup() {
		FM_Demo_Data_Structures()->add_post_type( 'neat-slider', array( 'singular' => 'Neat Slider' ) );
		add_action( 'fm_post_neat-slider', array( $this, 'init' ) );
	}

	public function init() {
		 
 
		$fm = new Fieldmanager_Group( array(
			'name'           => 'neat_slides',
			'limit'          => 0,
			'starting_count' => 1,
        	'extra_elements' => 0,
			'add_more_label' => 'Add another Slide',
			'sortable'       => true,
			'collapsed' 	 => True,
			'label'          => 'New Slide',
			'label_macro' => array( 'Slide: %s', 'title' ),

			'children'       => array(
				'title' => new Fieldmanager_Textfield( 'Slide Title' ),
				'slide' => new Fieldmanager_Media( 'Slide Image' ),

				'repeatable_group' => new Fieldmanager_Group( array(
					'limit'          => 0,
					'starting_count' => 1,
        			'extra_elements' => 0, 
					'add_more_label' => 'Add another Slide', 
					'label'          => 'New layer',
					'label_macro' => array( 'layer: %s', 'title' ),
					'tabbed'   => true, 

					'children'       => array(
						'title' => new Fieldmanager_Textfield( 'layer Title' ),
						'content_group' => new Fieldmanager_Group( array(
							'tabbed'   => true,
							'label'          => 'Content',
							'children'       => array(
								'content-image'        => new Fieldmanager_Media( 'Image' ),
								'content-text' => new Fieldmanager_RichTextArea( 'Text' ),
								'content-html'     => new Fieldmanager_TextArea( 'HTML / Video / Audio' ), 
								 
							)
						) ),
						
						'position_group' => new Fieldmanager_Group( array( 
							'label'          => 'Content Position',
							'children'       => array(
								'top-position'         => new Fieldmanager_Textfield( 'Content from top in pixels' ),
								'left-position'         => new Fieldmanager_Textfield( 'Content from left in pixels' ),
								 
								 
							)
						) ),

						'transition_group' => new Fieldmanager_Group( array( 
							'label'          => 'Transition',
							'children'       => array(
								'data-in'    => new Fieldmanager_Select( 'Data in', 
									array( 'options' => array(
										'fade', 'none' ,'left', 'topLeft', 'bottomLeft', 'right', 'topRight', 'bottomRight', 'top', 'bottom'
										 ) ) ),
								'data-out'   => new Fieldmanager_Select( 'Data Out', 
									array( 'options' => array(
										'fade', 'none' ,'left', 'topLeft', 'bottomLeft', 'right', 'topRight', 'bottomRight', 'top', 'bottom'
										 ) ) ),
								'delay'         => new Fieldmanager_Textfield( 'Delay - time in ms before the in transition starts (in the current step / see steps)' ), 
								'easingin'       => new Fieldmanager_Select( 'Easing in', 
									array( 'options' => array( 
										'linear','swing','easeInQuad','easeOutQuad','easeInOutQuad','easeInCubic','easeOutCubic','easeInOutCubic','easeInQuart','easeOutQuart','easeInOutQuart','easeInQuint','easeOutQuint','easeInOutQuint','easeInExpo','easeOutExpo','easeInOutExpo','easeInSine','easeOutSine','easeInOutSine','easeInCirc','easeOutCirc','easeInOutCirc','easeInElastic','easeOutElastic','easeInOutElastic','easeInBack','easeOutBack','easeInOutBack','easeInBounce','easeOutBounce','easeInOutBounce',
										 ) ) ),
								'easingout'       => new Fieldmanager_Select( 'Easing out', 
									array( 'options' => array( 
										'linear','swing','easeInQuad','easeOutQuad','easeInOutQuad','easeInCubic','easeOutCubic','easeInOutCubic','easeInQuart','easeOutQuart','easeInOutQuart','easeInQuint','easeOutQuint','easeInOutQuint','easeInExpo','easeOutExpo','easeInOutExpo','easeInSine','easeOutSine','easeInOutSine','easeInCirc','easeOutCirc','easeInOutCirc','easeInElastic','easeOutElastic','easeInOutElastic','easeInBack','easeOutBack','easeInOutBack','easeInBounce','easeOutBounce','easeInOutBounce',
										 ) ) ),


								'data-step'         => new Fieldmanager_Textfield( 'Data step - You can group your different filed content in different steps.' ),
								'data-special'     => new Fieldmanager_Checkbox( 'Data special cycle' ), 
							)
						) ),

						'style_group' => new Fieldmanager_Group( array( 
							'label'          => 'Style',
							'children'       => array(
								'custom-styles'     => new Fieldmanager_TextArea( 'Custom style - Write your custom css here for this Field content' ), 
							)
						) ),
 

						
					)
				) ),
			
			)
		) );
		$fm->add_meta_box( 'Slides', 'neat-slider' );

 
  

 
	}
}

Neat_slider_fields::instance();

endif;