<?php
/*
Template Name: Map
*/
?>
<?php get_header();?>
<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
    <section class="map">
    	<h1 class="logo-principal"><img src="<?php bloginfo( 'template_url' ); ?>/img/logo.png" alt="30 ans dans la vie de Marie"/></h1>
    	<div id="gmap_marqueur" style="">

		</div>
    </section>

    <!-- Volet filtre -->
    <a class="right-menu volet-map" href="#right-menu"></a>

    <section class="volet filtres">
    	<h1 class="dosis txtcenter very_very_big uppercase">Filtrer<br/>les témoignages</h1>
    	<ul class="unstyled filtre-tous">
    		<li class="txtcenter"><a href="#" class="dosis no-decoration bold reinit selected">Tous</a></li>
    	</ul>
    	<ul class="liste-filtres unstyled">
    		
    		<?php 
    		$args = array('type' => 'souvenir',	'orderby' => 'id', 'order' => 'ASC', 'hide_empty' => 1, 'taxonomy' => 'categorie_souvenir'); 
    		$categories = get_categories( $args );
	            
	        if($categories){
	            foreach ($categories as $categorie){
	    	?>
					<li class="txtcenter"><a href="#" class="dosis no-decoration bold <?php echo $categorie->slug;?>" data-filtre="<?php echo $categorie->slug;?>"><?php echo $categorie->name;?></a></li>    
	    	<?php
	            }
	        }
	    	?>
    	</ul>
    </section>


    <!-- Volet marqueur -->
    <a class="right-menu volet-marqueur" href="#"></a>

    <section class="volet marqueur sidr right">
    	<div class="sidr-inner">
    	
    	</div>
    </section>
<?php endwhile; ?>
<?php endif; ?>
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/dist/js/sidr/jquery.sidr.min.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/dist/js/infobubble.js"></script>
<script type="text/javascript" src="<?php bloginfo( 'template_url' ); ?>/dist/js/markerclustererplus.js"></script>

<script type="text/javascript">
	//<![CDATA[
	function initializeMarqueur() {
		var styles = [
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#444444"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f2f2f2"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#ddd5cb"
            },
            {
                "visibility": "on"
            }
        ]
    }
]
		var latlng = new google.maps.LatLng(45.27475, 1.766524);

		var winwidth = document.body.clientWidth;


		if(winwidth > 480){
			var monZoom = 5;
		}
		else{
			var monZoom = 8;
		}
		

		var myOptions = {
			zoom: monZoom,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			streetViewControl: false,
			mapTypeControl: false
		}

		var map = new google.maps.Map(document.getElementById("gmap_marqueur"),myOptions);
		var infoWindow = new google.maps.InfoWindow();

		map.setOptions({styles: styles});
		setMarkers(map, marqueurs);

		//var options = {styles:array('opt_textColor'=>'white')};
		var styles = [[{
	        url: '<?php bloginfo( 'template_url' ); ?>/img/cluster.png',
	        height: 56,
	        width: 56,
	        anchor: [28, 0],
	        textColor: 'white',
	        textSize:17,
	        fontFamily:'"Dosis", Helvetica, sans-serif'
	    },
	    {
	        url: '<?php bloginfo( 'template_url' ); ?>/img/cluster.png',
	        height: 56,
	        width: 56,
	        anchor: [28, 0],
	        textColor: 'white',
	        textSize:17,
	        fontFamily:'"Dosis", Helvetica, sans-serif'
	    },
	    {
	        url: '<?php bloginfo( 'template_url' ); ?>/img/cluster.png',
	        height: 56,
	        width: 56,
	        opt_anchor: [28, 0],
	        textColor: 'white',
	        textSize:17,
	        fontFamily:'"Dosis", Helvetica, sans-serif'
	    }]];


		markerCluster = new MarkerClusterer(map, mesMarqueursGmap, {styles: styles[0]});
		markerCluster.setIgnoreHidden(true);
		markerCluster.repaint();

		/*google.maps.event.addListener(map, 'idle', function(){
			if(!mapLoaded){
				$('#google_map').trigger('mapLoaded');
				mapLoaded = true;
				
				$(".gmnoprint").each(function(){
					$(this).append('<p>'+$(this).attr('title')+'</p>');
				});
			}
		});*/


	}

	google.maps.event.addDomListener(window, 'load', initializeMarqueur);
	
	var marqueurs = new Array;

	var mesMarqueursGmap = [];

	var markerCluster = "";

	var image = "";

	var image_grande = "";

	//Initialiser la variable qui va enregistrer la dernière infobulle ouverte
	var prev_infobulle;
	<?php 
		$zIndex = 0;

		$my_query = new WP_Query( array( 'post_type' => 'souvenir', 'order' => 'ASC', 'posts_per_page'=>-1));
		while( $my_query->have_posts() ) : $my_query->the_post();
			$coordonees = get_field('localisation');

			$auteur = get_the_author_meta('ID');

			$lat = (float) $coordonees['lat'];
			$lng = (float) $coordonees['lng'];
			$titre = html_entity_decode(get_the_title(), ENT_NOQUOTES, 'UTF-8');
			$titre_infobulle = html_entity_decode(get_the_title(), ENT_NOQUOTES, 'UTF-8');
			$sous_titre_infobulle = html_entity_decode(get_the_author_meta('display_name',$auteur), ENT_NOQUOTES, 'UTF-8');
			$texte_infobulle = html_entity_decode(get_field('texte_infobulle'), ENT_NOQUOTES, 'UTF-8');

			$ouverture = html_entity_decode(get_field('ouverture_souvenir'), ENT_NOQUOTES, 'UTF-8');

			$lesCategories = "";

			$categories = get_the_terms($post->ID, 'categorie_souvenir');
			foreach ($categories as $categorie){
				$lesCategories .= $categorie->slug.",";
			}
			
			$lesCategories = substr($lesCategories, 0, -1);
			$categories = html_entity_decode($lesCategories, ENT_NOQUOTES, 'UTF-8');

			$identifiant = get_the_ID();
			

			$zIndex++;
	?>
			var intermediaire = new Array('<?php echo $titre;?>', <?php echo $lat;?>, <?php echo $lng;?>, <?php echo $zIndex;?>, '<?php echo $ouverture;?>', '<?php echo $categories;?>', '<?php echo $titre_infobulle;?>', '<?php echo $sous_titre_infobulle;?>', '<?php echo $texte_infobulle;?>', <?php echo $identifiant;?>, <?php echo $auteur;?>);
			marqueurs.push(intermediaire);
	<?php
	    endwhile;
	?>

	/**
	 * Data for the markers consisting of a name, a LatLng and a zIndex for
	 * the order in which these markers should display on top of each
	 * other.
	 */
	 
	function setMarkers(map, locations) {
		// Add markers to the map
		
		// Marker sizes are expressed as a Size of X,Y
		// where the origin of the image (0,0) is located
		// in the top left of the image.
		
		// Origins, anchor positions and coordinates of the marker
		// increase in the X direction to the right and in
		// the Y direction down.
		image = new google.maps.MarkerImage('<?php bloginfo( 'template_url' ); ?>/img/map_pointeur.png',
		// This marker is 48 pixels wide by 42 pixels tall.
		new google.maps.Size(52, 59),
		// The origin for this image is 0,0.
		new google.maps.Point(0,0),
		// The anchor for this image is the base of the flagpole at 0,32.
		new google.maps.Point(26, 59));

		image_grande = new google.maps.MarkerImage('<?php bloginfo( 'template_url' ); ?>/img/map_pointeur_actif.png',
		// This marker is 71 pixels wide by 60 pixels tall.
		new google.maps.Size(52, 59),
		// The origin for this image is 0,0.
		new google.maps.Point(0,0),
		// The anchor for this image is the base of the flagpole at 0,32.
		new google.maps.Point(26, 59));
		// Shapes define the clickable region of the icon.
		// The type defines an HTML &lt;area&gt; element 'poly' which
		// traces out a polygon as a series of X,Y points. The final
		// coordinate closes the poly by connecting to the first
		// coordinate.
		/*var shape = {
			coord: [1, 1, 1, 31, 97, 31, 97 , 1],
			type: 'poly'
		};*/
		for (var i = 0; i < locations.length; i++) {
			var marqueur = locations[i];
			var myLatLng = new google.maps.LatLng(marqueur[1], marqueur[2]);
			var myLatLngInfobulle = new google.maps.LatLng(marqueur[1], marqueur[2]);
			var marker = new google.maps.Marker({
				position: myLatLng,
				map: map,
				icon: image,
				title: marqueur[0],
				zIndex: marqueur[3],
				ouverture: marqueur[4],
				categories: marqueur[5],
				titre_infobulle: marqueur[6],
				sous_titre_infobulle: marqueur[7],
				texte_infobulle: marqueur[8],
				identifiant: marqueur[9],
				auteur: marqueur[10],
				ouvert: false,
			});

			mesMarqueursGmap.push(marker);


			
			//Créer un évènement au clic sur le marker
			google.maps.event.addListener(marker, 'click', function(event) {
				if(this.ouverture=="infobulle"){
					//Initialiser la variable dans laquelle va être construit l'objet InfoBubble
					var infobulle;

					var contenu = '<div class="scrollFix">';
					if(this.titre_infobulle!=""){
						contenu = contenu+'<h1 class="dosis couleur_13 txtcenter ma0 infobulle normal">'+this.titre_infobulle+'</h1>';
					}
					if(this.sous_titre_infobulle!=""){
						contenu = contenu+'<h2 class="dosis couleur_13 txtcenter ma0 infobulle normal">'+this.sous_titre_infobulle+'</h2>';
					}
					if(this.texte_infobulle!=""){
						contenu = contenu+'<p class="dosis txtcenter infobulle ma0">'+this.texte_infobulle+'</p>';
					}

					contenu = contenu+'</div>';

					infobulle = new InfoBubble({
						map: map,
						content: contenu,  // Contenu de l'infobulle
						position: this.position,  // Coordonnées latitude longitude du marker
						shadowStyle: 0,  // Style de l'ombre de l'infobulle (0, 1 ou 2)
						padding: 0,  // Marge interne de l'infobulle (en px)
						backgroundColor: 'rgb(255,255,255)',  // Couleur de fond de l'infobulle
						borderRadius: 0, // Angle d'arrondis de la bordure
						arrowSize: 22, // Taille du pointeur sous l'infobulle
						borderWidth: 0,  // Épaisseur de la bordure (en px)
						borderColor: '#FFFFFF', // Couleur de la bordure
						disableAutoPan: false, // Désactiver l'adaptation automatique de l'infobulle
						hideCloseButton: false, // Cacher le bouton 'Fermer'
						arrowPosition: 50,  // Position du pointeur de l'infobulle (en %)
						arrowStyle: 0,  // Type de pointeur (0, 1 ou 2)
						disableAnimation: false,  // Déactiver l'animation à l'ouverture de l'infobulle
						minWidth :   300, // Largeur minimum de l'infobulle  (en px)
						maxWidth :   305  // Largeur maximum de l'infobulle  (en px)
					});
					 
					//Si on a déjà une infobulle ouverte, on la ferme
					if(prev_infobulle){
						prev_infobulle.close();
					}
					 
					//La précédent infobulle devient l'infobulle que l'on va ouvrir
					prev_infobulle = infobulle;
					 
					//Enfin, on ouvre l'infobulle
					infobulle.open(map, this);

					//On ferme le volet si un volet est ouvert
			    	$('.right-menu.volet-marqueur').css('display','none');
			    	$('.right-menu.volet-marqueur').animate({right:'20px'},200);
			    	$('.right-menu.volet-marqueur').removeClass('ouvert');
			    	$('.volet.marqueur').animate({right:'-520px'},200, function(){
			    		$('.right-menu.volet-map').css('display','block');
			    	});

			    	google.maps.event.addListener(infobulle,'closeclick',function(){
					   	for (var i=0; i<mesMarqueursGmap.length; i++) {
							mesMarqueursGmap[i].setIcon(image);
							mesMarqueursGmap[i].ouvert=false;
						}
					});

				}
				else{
					//Si on a déjà une infobulle ouverte, on la ferme
					if(prev_infobulle){
						prev_infobulle.close();
					}


					var winwidth = document.body.clientWidth;

					
					$('.right-menu.volet-map').css('display','none');
					$('.volet.marqueur').css('display','block');
					$('.volet.marqueur').animate({right:'0px'},200);
					$('.right-menu.volet-marqueur').css('display','block');
					$('.right-menu.volet-marqueur').addClass('ouvert');

					if(winwidth>=540){
						$('.right-menu.volet-marqueur').animate({right:'502px'},200);
					}
					else{
						$('.right-menu.volet-marqueur').animate({right:'20px'},200);
						$('.menu-hamburger').css('display','none');
					}

					doAjaxRequest(this.identifiant, this.auteur);
				}

				for (var i=0; i<mesMarqueursGmap.length; i++) {
					mesMarqueursGmap[i].setIcon(image);
				}

				this.setIcon(image_grande);
				this.ouvert = true;
			});

			google.maps.event.addListener(marker, "mouseover", function() {
				this.setIcon(image_grande);
			});

			google.maps.event.addListener(marker, "mouseout", function() {
				if(this.ouvert==false){
					this.setIcon(image);
				}
			});																									
		}
	}

	function doAjaxRequest(identifiant, auteur){
		$.ajax({
			url: 'http://fabien-raymondaud.fr/Marie/wp-admin/admin-ajax.php',
			data:{
				'action':'do_ajax',
				'fn':'get_souvenir',
				'identifiant':identifiant,
				'auteur':auteur
			},
			dataType: 'JSON',
			success:function(data){
				//console.log(data);
				var contenu_volet = '';
				
				contenu_volet += '<h1 class="dosis txtcenter uppercase">'+data.titre_volet+'</h1>';

				if(data.sous_titre_souvenir!=false){
					contenu_volet += '<h2 class="dosis txtcenter normal">'+data.sous_titre_souvenir+'</h2>';
				}

				if(data.video_souvenir!=false){
					contenu_volet += '<div class="video-container"><iframe width="560" height="315" src="https://www.youtube.com/embed/'+data.video_souvenir+'" frameborder="0" allowfullscreen></iframe></div>';
				}

				contenu_volet += '<div class="texte more_normal dosis">'+data.texte_volet+'</div>';

				if(data.lien_souvenir!=false){
					contenu_volet += '<a href="'+data.lien_souvenir+'" class="uppercase dosis couleur_5 lien_marqueur no-decoration more_more_big bold txtcenter">lien</a>';
				}

				$(".volet.marqueur .sidr-inner").html(contenu_volet);

				$(".image-lightbox").fancybox();
			},
			error: function(errorThrown){
				alert('error');
				console.log(errorThrown);
			}
		});
	}


	function showCategory(category) {
		for (var i=0; i<mesMarqueursGmap.length; i++) {
			var tableau_categories = mesMarqueursGmap[i].categories.split(',');
			if (tableau_categories.indexOf(category)!=-1) {
				mesMarqueursGmap[i].setVisible(true);
			}
		}
		//Si on a déjà une infobulle ouverte, on la ferme
		if(prev_infobulle){
			prev_infobulle.close();
		}
	}

	function hideCategory(category) {
		for (var i=0; i<mesMarqueursGmap.length; i++) {
			var tableau_categories = mesMarqueursGmap[i].categories.split(',');
			if (tableau_categories.indexOf(category)!=-1) {
				mesMarqueursGmap[i].setVisible(false);
			}
		}
		//Si on a déjà une infobulle ouverte, on la ferme
		if(prev_infobulle){
			prev_infobulle.close();
		}
	}

	function hideAll() {
		for (var i=0; i<mesMarqueursGmap.length; i++) {
			mesMarqueursGmap[i].setVisible(false);
		}
		//Si on a déjà une infobulle ouverte, on la ferme
		if(prev_infobulle){
			prev_infobulle.close();
		}
	}

	function showAll() {
		for (var i=0; i<mesMarqueursGmap.length; i++) {
			mesMarqueursGmap[i].setVisible(true);
		}
		//Si on a déjà une infobulle ouverte, on la ferme
		if(prev_infobulle){
			prev_infobulle.close();
		}
	}

	$(document).ready(function(){
		var winwidth = document.body.clientWidth;

		$('.right-menu.volet-map').sidr({
	      name: 'sidr-filtres',
	      source: '.volet.filtres',
	      side: 'right',
	      renaming: false,
	      displace: false
	    });
		

		var clickEvent = "touchstart";
		if(!("ontouchstart" in window)){
		    // if no touch we use mouseenter and mouseleave events
		    clickEvent = "click";
		}

	    $('.right-menu.volet-map').on(clickEvent,function(e){
	    	e.preventDefault();
	    	$(this).toggleClass('ouvert');
	    	if($(this).hasClass('ouvert')){
	    		if(winwidth>=440){
	    			$(this).animate({right:'500px'},200);
	    		}
	    		else{
	    			$('.menu-hamburger').css('display','none');
	    		}
	    	}
	    	else{
	    		if(winwidth>=440){
	    			$(this).animate({right:'20px'},200);
	    		}
	    		else{
	    			$('.menu-hamburger').css('display','inline-block');
	    		}
	    	}
	    });
	    
	    $('.right-menu.volet-marqueur').on(clickEvent,function(e){
	    	e.preventDefault();
	    	$(this).css('display','none');
	    	$(this).animate({right:'20px'},200);
	    	$('.right-menu.volet-marqueur').removeClass('ouvert');
	    	$('.volet.marqueur').animate({right:'-520px'},200, function(){
	    		$('.right-menu.volet-map').css('display','block');
	    	});

	    	$('.menu-hamburger').css('display','inline-block');

	    	for (var i=0; i<mesMarqueursGmap.length; i++) {
				mesMarqueursGmap[i].setIcon(image);
				mesMarqueursGmap[i].ouvert=false;
			}
	    });

	    $('.liste-filtres a').click(function(e){
	    	e.preventDefault();
	    	$(this).toggleClass('selected');

	    	//Cas où le filtre est sélectionné
	    	if($(this).hasClass('selected')){
	    		//Si c'est le seul filtre sélectionné on masque tous les  marqueurs
	    		if($('.liste-filtres a.selected').length==1){
		    		hideAll();
		    		markerCluster.setIgnoreHidden(true);
					markerCluster.repaint();
		    	}
		    	//On affiche ensuite seulement ceux de la catégorie
		    	var leFiltre = $(this).data("filtre");
	    		showCategory(leFiltre);
	    		markerCluster.setIgnoreHidden(true);
				markerCluster.repaint();
				$('.reinit').removeClass('selected');
	    	}
	    	//cas où le filtre est désélectionné
	    	else{
	    		//Si plus aucun filtre n'est sélectionné on affiche tout
	    		if($('.liste-filtres a.selected').length==0){
		    		showAll();
		    		markerCluster.setIgnoreHidden(true);
					markerCluster.repaint();
					$('.reinit').addClass('selected');
		    	}
		    	//Sinon on efface tout et on ne ré-affiche que ceux dont la catégorie est encore sélectionnée
		    	else{
		    		hideAll();
		    		$('.liste-filtres a.selected').each(function(){
		    			var leFiltre = $(this).data("filtre");
	    				showCategory(leFiltre);
	    				markerCluster.setIgnoreHidden(true);
						markerCluster.repaint();
						$('.reinit').removeClass('selected');
		    		});
		    	}
	    	}
	    });

	    $('.reinit').click(function(e){
	    	e.preventDefault();
	    	$('.liste-filtres a').removeClass('selected');
	    	$(this).addClass('selected');
	    	showAll();
	    	markerCluster.setIgnoreHidden(true);
			markerCluster.repaint();
	    });

	});
	
	//initialize();
	//]]>
</script>
</body>
</html>

