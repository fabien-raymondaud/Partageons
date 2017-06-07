<?php
add_action( 'after_setup_theme', 'memoires_setup' );

if ( ! function_exists( 'memoires_setup' ) ){

	function memoires_setup() {
		add_theme_support('nav-menus');
		add_theme_support( 'post-thumbnails' );
			
		if ( function_exists('register_sidebar') )
			register_sidebar();
			
		if ( function_exists('my_register_post_types') )
			add_action( 'init', 'my_register_post_types' );
			
		if ( function_exists('my_register_taxonomies') )
			add_action( 'init', 'my_register_taxonomies' );

    	register_nav_menus( array( 'principal' => "Menu Principal" ) );
    	register_nav_menus( array( 'responsive' => "Menu mobile" ) );
    	register_nav_menus( array( 'responsive_suite' => "Menu mobile partie 2" ) );

    	add_image_size('mosaique', 240, 0);
    	add_image_size('jaquette', 155, 0);
	}
}

if( ! function_exists (my_register_post_types)) {
	function my_register_post_types() {
		register_post_type(
			'souvenir',
			array(
				'label' => __('Anecdotes'),
				'singular_label' => __('Anecdote'),
				'public' => true,
				'show_ui' => true,
				'show_in_nav_menus'=> false,
				'capability_type' => 'post',
				'rewrite' => array("slug" => "souvenir"),
				'hierarchical' => false,
				'query_var' => false,
				'supports' => array('title','editor','thumbnail'),
				//'taxonomies' => 
			)
		);	
	}
}

if( ! function_exists (my_register_taxonomies)) {
	function my_register_taxonomies() {
		$labels = array(
			'name' => _x( 'Catégories anecdote', 'taxonomy general name' ),
			'singular_name' => _x( 'Catégorie anecdote', 'taxonomy singular name' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			//'show_ui' => false,
			'menu_name' => __( 'Catégories anecdotes' ),
		); 
	
		register_taxonomy('categorie_souvenir','souvenir',array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'show_in_nav_menus' => true,
			'rewrite' => array( 'slug' => 'categorie_souvenir' ),
		));
	}
}

add_action('init', 'remove_editor_init');
function remove_editor_init() {
    // if post not set, just return 
    // fix when post not set, throws PHP's undefined index warning
    if (isset($_GET['post'])) {
        $post_id = $_GET['post'];
    } else if (isset($_POST['post_ID'])) {
        $post_id = $_POST['post_ID'];
    } else {
        return;
    }
    /*$template_file = get_post_meta($post_id, '_wp_page_template', TRUE);
    if ($template_file == 'template_image_full.php' || $template_file == 'template_map.php') {*/
        remove_post_type_support('page', 'editor');
    //}
}



add_action('wp_ajax_nopriv_do_ajax', 'notre_fonction_ajax');
add_action('wp_ajax_do_ajax', 'notre_fonction_ajax');
function notre_fonction_ajax(){
     // ce switch lancera les fonctions selon la valeur qu'aura notre variable 'fn'
 
     switch($_REQUEST['fn']){
          case 'get_souvenir':
          		$output = new stdClass();
          		$output->titre_volet = get_the_title($_REQUEST['identifiant']);
          		$output->sous_titre_souvenir = get_the_author_meta('display_name', $_REQUEST['auteur']);
          		$output->texte_volet = get_field('texte_volet', $_REQUEST['identifiant']);
          		$output->video_souvenir = get_field('video_souvenir', $_REQUEST['identifiant']);
          		$output->lien_souvenir = get_field('lien_souvenir', $_REQUEST['identifiant']);
          break;
          default:
            	$output = 'No function specified, check your jQuery.ajax() call';
          break;
 
     }
 
	// Maintenant nous allons transformer notre résultat en JSON et l'afficher

	$output=json_encode($output);
	if(is_array($output)){
		print_r($output);
	}
	else{
		echo $output;
	}
	die;
}

?>