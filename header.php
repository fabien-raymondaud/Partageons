<!doctype html>
<!--[if lte IE 6]> <html class="no-js ie6 ie67 ie678" lang="fr"> <![endif]-->
<!--[if IE 7]> <html class="no-js ie7 ie67 ie678" lang="fr"> <![endif]-->
<!--[if IE 8]> <html class="no-js ie8 ie678" lang="fr"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
<head>
    <title>
    	<?php bloginfo('name') ?>
    	<?php if ( is_404() ) : ?> &raquo; <?php _e('Not Found') ?>
    	<?php elseif ( is_home() ) : ?>
    	<?php else : ?><?php wp_title() ?><?php endif ?>
	</title>
 
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
	<meta name="viewport" content="width=device-width, maximum-scale=1.0">
	<meta property="og:image" content="http://www.memoireselectriques.fr/memoires-electriques.png"/>

	<!-- leave this for stats -->
	<link rel="stylesheet" href="<?php bloginfo( 'template_url' ); ?>/dist/css/style.min.css" type="text/css" media="screen" />
	<link href="<?php bloginfo( 'template_url' ); ?>/dist/css/jquery.fancybox.css" rel="stylesheet" />

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php wp_head(); ?>
	<script src="<?php bloginfo( 'template_url' ); ?>/dist/js/jquery-1.7.1.min.js"></script>
	<script src="<?php bloginfo( 'template_url' ); ?>/dist/js/jquery.fancybox.js"></script>
    <script src="<?php bloginfo( 'template_url' ); ?>/dist/js/built.js"></script>


    <!--[if IE]>
	  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>-->
	<script src="http://maps.googleapis.com/maps/api/js?v=3&amp;sensor=false"></script>
	
	<link href='https://fonts.googleapis.com/css?family=Dosis:500,600,700' rel='stylesheet' type='text/css'>
</head>

<body <?php body_class(); ?>>
