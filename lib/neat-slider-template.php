<?php 

get_header();  

if ( have_posts() ) :
	while ( have_posts() ) : the_post();
?>
<?php global $post;
    	$sliderid = $post->ID;  ?>
<div class="container"> 
<div class="slider-wrapper">

	<?php 
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
   		
   		 if ( $fullWidth == 'true' ) { 
 	 $sliderstyle = "fullWidthslider";
 } else {
 	$sliderstyle = "boxedWidthslider";
 }
   		?>

  		<div class="neat-slider-<?php echo $sliderid ?> fr-slider" style="max-width:<?php echo $slider_width ?>px;">
  		<div class="fs_loader"></div> 

		<?php foreach ($neat_slides[0] as $key => $value) { ?>

		<div class="slide">

			<img  data-fixed class="<?php echo $sliderstyle ?> slide-bg" src="<?php print_r(wp_get_attachment_url($value['slide'],'full')); ?>" alt="<?php print_r(get_the_title($value['slide'],'full'));   ?>">

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
<script type="text/javascript">
$(window).load(function(){

  $('.neat-slider-<?php echo $sliderid ?>').fractionSlider({
    'fullWidth':     <?php echo $fullWidth; ?>,
    'slideTransition': '<?php echo $slides_transition; ?>',
    'slideTransitionSpeed' : <?php echo $slide_tspeed; ?>, 
    'slideEndAnimation' : <?php echo $slide_endani; ?>,
    'controls':  <?php echo $slider_controls; ?>,
    'pager': <?php echo $slider_pager; ?>,
    'speedIn' : <?php echo $slide_speedIn; ?>,
    'speedOut' : <?php echo $slide_speedOut; ?>,
    'timeout' : <?php echo $slide_timeout; ?>,
    'pauseOnHover' : <?php echo $slider_pauseonhover; ?>, 
    'autoChange' : <?php echo $slider_autochange; ?>,
    'responsive':  true,
    'increase': true,
    'dimensions': '<?php echo $slider_width; ?>,<?php echo $slider_height; ?>',
  });
 

<?php
if ( $fullWidth == 'true' ) { ?>


  var viewportWidth = $(window).width();
  var colWidth = $(".container").width(); 
  var viewportHeight = $(window).height();
  var divideval = 2 ; 
  var marginslidebg = (viewportWidth - colWidth) / divideval  ;

  if (viewportWidth > 1200) {

  $(".fullWidthslider").css({"width": viewportWidth,"max-width": viewportWidth,"margin-left":"-"+marginslidebg+"px", }); 
   
  $(".slider-wrapper").css({"width": viewportWidth,"max-width": viewportWidth,"margin-left":"-"+marginslidebg+"px",});  
  } else
  {
  $(".fullWidthslider").css({"width": viewportWidth,"max-width": viewportWidth,"margin-left":"0px",}); 
   
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

<?php }
?> 

});
</script> 
	<?php 
	endwhile;
else :
	echo wpautop( 'Sorry, no posts were found' );
endif;

?>


<?php get_footer(); ?>