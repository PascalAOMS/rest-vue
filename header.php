<!DOCTYPE html>
<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="viewport" 		content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" 	content="<?php bloginfo('description'); ?>">

		<meta property="og:title" 	content="<?php bloginfo('name'); ?>">
		<meta property="og:type" 	content="website">
		<meta property="og:image"	content="<?php get_template_directory_uri(); ?>/img/social-preview.png">
		<meta property="og:url" 	content="<?php bloginfo('url'); ?>" >

		<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
		<!-- <title>{{ post.title.rendered || '404' }}</title> -->

		<link rel="icon" type="image/png" href="<?php get_template_directory_uri(); ?>/favicon.png"> 		<!-- 32x32 -->
		<link rel="apple-touch-icon" href="<?php get_template_directory_uri(); ?>/apple-touch-icon.png"> 	<!-- 180x180 -->

		<?php wp_head(); ?>

</head>
<body id="<?php echo get_query_var('name'); ?>">



<div class="header-sticky">
<header class="header">
	<div class="container">

		<div class="logo">
			<h1>REST API Test</h1>
		</div>

		<?php

			wp_nav_menu( array(
				'container'       => 'nav',
				'container_class' => 'nav',
				'items_wrap'      => '<ul>%3$s</ul>',
			) );
		 ?>

	</div>
</header>
</div>
