<?php 

get_header();  

if ( have_posts() ) :
	while ( have_posts() ) : the_post();
?>
<div class="container">
<div class="slider-wrapper">
  <div class="fr-slider">
  <div class="fs_loader"></div> 
	<?php 
		$neat_slides = get_post_meta($post->ID,'neat_slides');


		foreach ($neat_slides[0] as $key => $value) { ?>

		<div class="slide">

			<img data-fixed class="slide-bg" src="<?php print_r(wp_get_attachment_url($value['slide'],'full')); ?>" alt="<?php print_r(get_the_title($value['slide'],'full'));   ?>">

		<?php 
		 

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
 
		?>  
			<div data-position="<?php print_r($top_position); ?>,<?php print_r($left_position); ?>" data-in="<?php print_r($data_in); ?>"  data-out="<?php print_r($data_out); ?>"  data-delay="<?php print_r($delay); ?>" data-ease-in="<?php print_r($easingin); ?>" data-ease-out="<?php print_r($easingout); ?>" <?php  if ($data_step) { ?> data-step="<?php print_r($data_step); ?>" <?php } if ($data_special) { echo 'data-special="cycle"'; } ?>  class="caption" style="<?php print_r($custom_styles); ?>">

			<?php 	

				if ($content_html) {
					print_r($content_html);
				} elseif ($content_text) {
					print_r($content_text);
				} else {
					print_r(wp_get_attachment_image($content_image,'full'));
				} 
			?>

			</div>
		<?php  }  ?>

	</div>

		<?php  } 
	?>


  </div>
</div> 
</div>
	<?php
	endwhile;
else :
	echo wpautop( 'Sorry, no posts were found' );
endif;

?>


<?php get_footer(); ?>