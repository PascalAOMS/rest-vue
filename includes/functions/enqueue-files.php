<?php

$PRODUCTION_ENV = FALSE;

function add_scripts() {

	if ( !$PRODUCTION_ENV ) {

/////// CSS
		wp_enqueue_style( 'style', (get_template_directory_uri() . '/css/main.css'), false, '1.0');
		wp_enqueue_style( 'style-demo', (get_template_directory_uri() . '/css/style.css'), false, '1.0');

/////// JS
	//	wp_enqueue_script( 'plugins', get_template_directory_uri() . '/js/plugins.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'vue', get_template_directory_uri() . '/js/vue.js', array(), '1.0', true );
		wp_enqueue_script( 'vue-resource', get_template_directory_uri() . '/js/vue-resource.js', array(), '1.0', true );
		wp_enqueue_script( 'vue-router', get_template_directory_uri() . '/js/vue-router.js', array(), '1.0', true );
		wp_enqueue_script( 'app', get_template_directory_uri() . '/js/app.js', array(), '1.0', true );
	//	wp_enqueue_script( 'script', get_template_directory_uri() . '/js/main.js', array(), '1.0', true );

	} else {

		wp_enqueue_style( 'style-min', (get_template_directory_uri() . '/css/main.min.css'), false, '1.0');
		wp_enqueue_script( 'script-min', get_template_directory_uri() . '/js/main.min.js', array(), '1.0.0', true );
	}


// JQUERY
	if( !is_admin() ) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js', false, '2.2.2');
		wp_enqueue_script('jquery');
	}

}
add_action( 'wp_enqueue_scripts', 'add_scripts' );
