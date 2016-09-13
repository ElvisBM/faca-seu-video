<?php 
	

	/*
		Pagina de Configuracao
	*/
function fsv_configuracoes() {

		add_action( 'admin_init', 'fsv_register_options' );

		// criamos a pagina de opções com esta função
		add_options_page( 'Configurações', 'Faça Seu Video', 'manage_options', 'faca-seu-video', 'fsv_page_config' );

}

	/* Registrar Opcoes de Configuracoes*/
function fsv_register_options(){
		 register_setting( 'fsv_my_options', 'fsv_my_options' );
 		 add_settings_section( 'ewp_opcoes_principais', 'Opções Gerais', 'ewp_opcoes_seccao', 'minhas-opcoes' );
  		 add_settings_field( 'ewp_opcao_1', 'Coloque o seu texto', 'ewp_opcao_1_input', 'minhas-opcoes', 'ewp_opcoes_principais' );
}

function fsv_options_seccao() {
	  echo '<p>Cabeçalho da página</p>';
}

function ewp_opcao_1_input() {
	  // Vamos primeiro buscar a opção registada em cima...
	  $opcao = get_option( 'fsv_my_options' );
	  $opcao_1 = $opcao['opcao_1'];

	  // ... e agora vamos imprimir o campo de input com a opção
	  echo '<input type="text" name="fsv_my_options[opcao_1]" value="'.$opcao_1.'" />';

}
	

	/*
	  	Carregar CSS e JS
	*/
function css_js(){
	 	wp_enqueue_style( 'facaseuvideo-css', plugins_url('css/facaseuvideo.css',__FILE__) ) ;
	 	wp_enqueue_style( 'style', plugins_url('css/style.css',__FILE__) ) ;
	 	wp_enqueue_style( 'style_select', plugins_url('css/chosen.css',__FILE__) ) ;
	 	//wp_enqueue_script( 'select_faca', plugins_url('js/chosen.jquery.js',__FILE__) , true, true, true);
		wp_enqueue_script( 'funcitons_faca', plugins_url('js/functions.js',__FILE__) , true, true, true);
} 	


	 

//VIEW 
function fsv_layout(){


	//Validar Login e Senha...
	if ($_POST['log'] || $_POST['pwd']){
		$user = wp_authenticate($_POST['log'],$_POST['pwd']);
		if ($user->ID>0) {
			wp_set_auth_cookie($user->ID);
			wp_redirect( get_bloginfo('url').'/?page_id=235' );
		} 
	}
	


	//VERIFICA USUARIO LOGADO
	if ( is_user_logged_in() ) {

		$template = logado();
		
	}else{

		$template = naologado();
		
	}
	
	// Retornando o Template do Plugin
	return $template;


}//fsv_layout()





?>