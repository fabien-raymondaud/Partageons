<?php get_header();?>

<video autoplay loop poster="<?php the_field('image_poster') ?>" class="bgvid">
	<source src="<?php bloginfo( 'template_url' ); ?>/img/clip_court.mp4" type="video/mp4">
</video>

<script src="<?php bloginfo( 'template_url' ); ?>/dist/js/imagesLoaded.min.js"></script>
<script>
	$(document).ready(function(){
		$('.gif-anime').addClass('gm-style');
		imagesLoaded( document.querySelector('.gif-anime'), function( instance ) {
	  		var winheight = document.body.clientHeight;
			var winwidth = document.body.clientWidth;

			if(winwidth>688 && winheight<659){
				console.log("pas ok");
				$('.gif-anime img').height(winheight);
				var hauteurConteneur = $('.gif-anime img').height();
				var largeurConteneur = hauteurConteneur*1.044; // ratio taille image de base

				$('.gif-anime').height(hauteurConteneur);
				$('.gif-anime').width(largeurConteneur);

				var marginLeft = $('.gif-anime').width()/2;
				var marginTop = $('.gif-anime').height()/2;

				$('.gif-anime').css('margin-left','-'+marginLeft+'px');
				$('.gif-anime').css('margin-top','-'+marginTop+'px');
			}
		});

		$(window).resize( function() {
			var winheight = document.body.clientHeight;
			var winwidth = document.body.clientWidth;

			var hauteurImage = $('.gif-anime img').height();

			if(winwidth>688 && winheight<659){
				$('.gif-anime img').height(winheight);
				var hauteurConteneur = $('.gif-anime img').height();
				var largeurConteneur = $('.gif-anime img').width();

				$('.gif-anime').height(hauteurConteneur);
				$('.gif-anime').width(largeurConteneur);

				var marginLeft = $('.gif-anime').width()/2;
				var marginTop = $('.gif-anime').height()/2;

				$('.gif-anime').css('margin-left','-'+marginLeft+'px');
				$('.gif-anime').css('margin-top','-'+marginTop+'px');
			}
		});
	});
</script>

</body>
</html>
