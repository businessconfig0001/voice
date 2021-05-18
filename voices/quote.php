<?php
function showGetAQuote(){
    $html = "<div id='main_quote'>";
    $html .= showFavoriteCountBox();
    $html .= showRemoveAllFavorite();
    $html .= showFavoriteList();
    $html .= showSendAsk();
    $html .= "</div>";
    return $html;
}
function showFavoriteList(){
    $html = "<div id='voices_on_quote' class='voices_on_quote'>";
        $favorites = getFavoriteVoicesCookie();
        //$html .= var_export($favorites);
        $list = explode("|", $favorites);
        foreach ($list as $value) {
            if(!empty($value)){
               $html .= showItemOnQuote($value);
            }
        }
    $html .= "</div>";
    return $html;
}
function showItemOnQuote($id){
    $html = "<div id='voice_on_quote_".$id."' class='voice_on_quote'>
            <div class='name'>".get_post_meta($id, 'nome', true)."</div>";
    $html .= "<a id='addremove_".$id."' onclick='addRemoveFavorite(".$id.")'>Remover</a>";
    //$html .= "<div class='linguagens'>".showLanguages(get_post_meta($id, 'linguagens', true))."</div>";
    $html .= "</div>";
    return $html;
}
function showRemoveAllFavorite(){
    return "<a id='removeAll' onclick='removeAllFavorites()'><i class='fas fa-user-slash'></i></a>";
}
function showSendAsk(){
    return "<div class='botaopedido'><a href='".getOption('voz_checkout_page')."'>".__( "Pedir Cotação", "voices" )."</a></div>";
}
function showFavoriteCountBox(){
    $html = "<div id='quote_count_box'>";
        //$html .= "<span id='quote_count'>";
        //$html .= showFavoriteCount();
        //$html .= "</span>";
            
        $html .= __( "Favoritos", "voices" );
    $html .= "</div>";
    return $html;
}
function showFavoriteCount(){
    $favorites = getFavoriteVoicesCookie();
    $list = explode("|", $favorites);
    return count($list)-1;
}
function getFavoriteVoicesCookie(){
    return htmlentities($_COOKIE['favorite_voice'], 3, 'UTF-8');
}
?>