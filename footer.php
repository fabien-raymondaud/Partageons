<?php
	if(!is_home() && !is_front_page() && !is_page_template('template_a_propos.php') && !is_page_template('template_credits.php')){
?>
<footer>
	<!-- Barre d'infos s'affichant au rollover du bouton "i"-->
	<?php
	if(!is_page_template('template_playlist.php')){
	?>
	<section class="infos fixed">
		<span class="bebas uppercase couleur_5">En écoute</span><h4 class="bebas uppercase couleur_6 more_more_big ma0"><?php the_field('infos_son');?></h4>
    </section>
    <?php
	}
	?>

    <!-- Gestion des encarts apparaissant au rollover de la nav-->
	<?php
		$compteur_nav=0;
		$my_query = new WP_Query( array( 'post_type' => 'page', 'post__in' => array(167,169,175,291,181,183,154,193,197,199,205,213,217), 'order' => 'ASC', 'orderby' => 'menu_order', 'posts_per_page'=>-1));
		while( $my_query->have_posts() ) : $my_query->the_post();
			$compteur_nav++;
	?>
			<div class="navigation-hover row fixed small-hidden" id="navigation_<?php echo $compteur_nav;?>">
				<div>
					<?php
						if(get_field('image_navigation')!=""){
					?>
							<img src="<?php the_field('image_navigation');?>" alt="the_title()"/>
					<?php
						}
					?>
				</div>
				<h3><span class="couleur_5 uppercase bebas less_normal"><?php the_title();?></span></h3>
				<h4><span class="couleur_6 uppercase bebas more_more_big"><?php the_field('nom_page');?></span></h4>
			</div>		
	<?php
	    endwhile;
	    wp_reset_postdata();
	?>

	<!-- Gestion du son de la page qui se joue en autoplay, sauf sur la page playlist-->
	<?php
	if(!is_page_template('template_playlist.php')){
		if(get_field('fichier_son')!=""){
			$mon_son = get_field('fichier_son');
	?>
			<audio autoplay id="mon-son"><source id="ma-source" src="<?php echo $mon_son;?>" type="audio/mpeg"></audio>

			<script>
			    function StartOrStop() {
			        var audie = document.getElementById("mon-son");
			        if (audie.paused == false) {
			            audie.pause();
			        } else {
			            audie.play();
			        }
			    }
			</script>
	<?php
		}
	}
	else{
	?>
		<script>
		    function StartOrStop() {
		        var audie = document.getElementById("son-playlist");
		        if (audie.paused == false) {
		            audie.pause();
		            $('.un-morceau').each(function(){
		            	if($(this).css('display')=="block"){
		            		$(this).find('.pause').addClass('actif');
		            	}
		            });
		        } else {
		            audie.play();
		            $('.un-morceau').each(function(){
		            	if($(this).css('display')=="block"){
		            		$(this).find('.pause').removeClass('actif');
		            	}
		            });
		        }
		    }
		</script>
	<?php
	}
	?>


	<!-- Barre fixe en pied de page-->
	<nav class="footer row">
		<a href="#" class="potard pl2"><span <?php if(get_field('fichier_son')!="" || is_page_template('template_playlist.php')){ echo 'onclick="StartOrStop()"';}?>></span></a>
		<?php
			if(!is_page_template('template_playlist.php')){
		?>
				<a href="#" class="lien-infos oleo big couleur_6 no-decoration"><span class="txtcenter"><img src="<?php bloginfo( 'template_url' ); ?>/img/icn-infos.png" alt="infos"/></span></a>
		<?php
			}
			else{
		?>
				<a href="#" class="lien-infos oleo big couleur_6 no-decoration inactif"><span class="txtcenter"><img src="<?php bloginfo( 'template_url' ); ?>/img/icn-infos.png" alt="infos"/></span></a>
		<?php
			}
		?>
		<a href="#" class="wave"><span></span></a>
		<ul class="unstyled small-hidden">
			<li class="gros"><a href="<?php echo get_permalink(167);?>" class="<?php if($post->ID==167){echo "actif";}?>" id="menu_1"></a></li>
			<li class="gros"><a href="<?php echo get_permalink(169);?>" class="<?php if($post->ID==169 || $post->ID==171 || $post->ID==173){echo "actif";}?>" id="menu_2"></a></li>
			<li class="gros"><a href="<?php echo get_permalink(175);?>" class="<?php if($post->ID==132 || $post->ID==175 || $post->ID==179){echo "actif";}?>" id="menu_3"></a></li>
			<li class="gros"><a href="<?php echo get_permalink(293);?>" class="<?php if($post->ID==293){echo "actif";}?>" id="menu_4"></a></li>
			<li class="gros"><a href="<?php echo get_permalink(183);?>" id="menu_5"></a></li>
			<li><a href="<?php echo get_permalink(183);?>" class="<?php if($post->ID==183 || $post->ID==185 || $post->ID==187){echo "actif";}?>" id="menu_6"></a></li>
			<li><a href="<?php echo get_permalink(154);?>" class="<?php if($post->ID==152 || $post->ID==154 || $post->ID==245){echo "actif";}?>" id="menu_7"></a></li>
			<li><a href="<?php echo get_permalink(193);?>" class="<?php if($post->ID==193){echo "actif";}?>" id="menu_8"></a></li>
			<li><a href="<?php echo get_permalink(197);?>" class="<?php if($post->ID==197){echo "actif";}?>" id="menu_9"></a></li>
			<li><a href="<?php echo get_permalink(199);?>" class="<?php if($post->ID==199 || $post->ID==201 || $post->ID==203){echo "actif";}?>" id="menu_10"></a></li>
			<li class="gros"><a href="<?php echo get_permalink(205);?>" class="<?php if($post->ID==205 || $post->ID==207 || $post->ID==209){echo "actif";}?>" id="menu_11"></a></li>
			<li class="gros"><a href="<?php echo get_permalink(213);?>" class="<?php if($post->ID==213){echo "actif";}?>" id="menu_12"></a></li>
			<li class="gros"><a href="<?php echo get_permalink(217);?>" class="<?php if($post->ID==217){echo "actif";}?>" id="menu_13"></a></li>
		</ul>
		<!--<div class="plug small-hidden">
			<span></span>
		</div>-->
		<?php 
			if(get_field('sequence_suivante')!=""){
		?>
				<a href="<?php the_field('sequence_suivante');?>" class="uppercase couleur_5 big bebas no-decoration suivante txtcenter">Séquence suivante</a>
		<?php
			}
		?>
	</nav>
</footer>
<?php
	}
?>

<?php wp_footer(); ?>
</body>
</html>
