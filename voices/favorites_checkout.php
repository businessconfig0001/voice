<?php
function sendRequest(){
    $nome = $_POST['nome'];
    $apelido = $_POST['apelido'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $projeto = $_POST['projeto'];
		
    $to = getOption('voz_admin_email'); 
    $subject = __( "Novo pedido", "voices" );
    $headers = 'From: '. $to . "\r\n".'Reply-To: ' . $to . "\r\n";
 
    $message = __( "Dados do pedido pedido", "voices" ).":
        ".__( "Nome", "voices" ).": $nome
        ".__( "Apelido", "voices" ).": $apelido
        ".__( "E-mail", "voices" ).": $email
        ".__( "Telefone", "voices" ).": $telefone
        ".__( "Projeto", "voices" ).": $projeto
        
        ".__( "Favoritos", "voices" ).": ".getFavoriteListToEmail();
    $sent = wp_mail($to, $subject, strip_tags($message), $headers);
    //client mail
    wp_mail($email, __( "Seu pedido foi recebido", "voices"), strip_tags($message.client_thank_you()), $headers);
    
    $msg = __("Obrigado pelo seu contacto. O seu pedido foi enviado. Iremos responder brevemente.", "voices" );
	echo json_encode(array('status'=>200, 'data'=>$msg));
    exit;
}
function client_thank_you(){
    return "\n\n".__("Obrigado pelo seu contacto. Iremos responder brevemente.", "voices" );;
}
function getFavoriteListToEmail(){
    $result = "";
    
    $favorites = getFavoriteVoicesCookie();
    $list = explode("|", $favorites);
    foreach ($list as $value) {
        if(!empty($value)){
           $result .= getVoiceToEmail($value)." | ";
        }
    }
    return $result;
}
function getVoiceToEmail($id){
    return get_post_meta($id, 'nome', true);
}
function showFavoritesCheckout(){
    $html = "<div class='formulariocotacao'>". showContactForm() ."</div>";
    $html .= "<h3>".__( "Meus Favoritos", "voices" )."</h3>";
    $html .= showFavoriteList();
    return $html;
}
function showContactForm(){
    $html = "<form>
      <div class='row'><div class='col-6-first'><input type='text' id='nome' name='nome' placeholder='".__( "Nome", "voices" )."' required /></div>
      <div class='col-6-last'><input type='text' id='apelido' name='apelido' placeholder='".__( "Apelido", "voices" )."'></div></div>
      <div class='row'><div class='col-6-first'><input type='text' id='email' name='email' placeholder='".__( "E-mail", "voices" )."' required /></div>
      <div class='col-6-last'><input type='text' id='telefone' name='telefone' placeholder='".__( "Telefone", "voices" )."'></div></div>";
    
    $html .= "<div class='row'><div class='col'><textarea type='area' id='projeto' name='projeto' placeholder='".__( "Descrição do Projeto", "voices" )."'></textarea></div></div>";
    $html .= "<div class='botaoenviar'><a type='submit' class='et_pb_button et_pb_button_0 et_pb_bg_layout_light' onclick='sendRequest()'>".__( "Enviar Mensagem", "voices" )."</a></div>";
    $html .= "</form>";
    return $html;
}
?>