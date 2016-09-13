<?php
/*
Plugin Name: Faça Seu video
Plugin URI: http://webtreex.com.br
Description: Plugin para SET List  de videos do Youtube e Sound Cloud
Version: 1.0
Author: Elvis B. Martins
Author URI: http://webtreex.com.br
License: GPLv2
*/

/*
 *      Copyright 2014 Elvis B. Martins - Web TreeX <elvisbmartins@gmail.com>
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 3 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */


/*
	Funcitons e Options  PHP
*/
	include( plugin_dir_path( __FILE__ ) . 'fsv_naologado.php' );
	include( plugin_dir_path( __FILE__ ) . 'fsv_logado.php' );
	include( plugin_dir_path( __FILE__ ) . 'functions.php' );
	include( plugin_dir_path( __FILE__ ) . 'options.php' );



/*
	Carremanto CSS e JS Function
*/
	add_action( 'wp_enqueue_scripts', 'css_js' );


/*
	Adicionando pagina de configuração
*/
	add_action( 'admin_menu', 'fsv_configuracoes' );


/* 
	Corpo do Plugin 
*/

add_filter('the_content', 'custom_post_content', 10 , 3 );

function custom_post_content( $content){

	 $post = "Faça seu Video";

	 if(strpos($content,$post) != false)
     {
     	return $content = fsv_layout();
     }
		else
     {
     	return $content;
     }

	
}



?>