<?php
function showItem(){
    $html = "<div id='voice_".get_the_ID()."' class='voice'>";
        $html .= showMoreInfo(get_the_ID());
        $html .= "<div class='name'>".get_post_meta(get_the_ID(), 'nome', true)."</div>
                  <div class='gender ".get_post_meta(get_the_ID(), 'genero', true)."'>".get_post_meta(get_the_ID(), 'genero', true)."</div>";
        $html .= showMedias(get_the_ID());
        $html .= showAddRemoveIcons(get_the_ID());
        $html .= showAge(get_post_meta(get_the_ID(), 'data_de_nascimento', true));
        $html .= "<div id='mais_info_".get_the_ID()."' class='mais_info_".get_the_ID()." mais_info' style='display: none;'><div class='bio'>".get_post_meta(get_the_ID(), 'biografia', true)."</div>";
           
        //$html .= "<a id='share_$id' class='share' onclick='share(\"".get_permalink(get_the_ID())."\")'>Share</a>";
        $html .= "<a id='download_$id' class='download' onclick='multi_download(\"".get_download_src(get_the_ID())."\")'><img class='download-icon' width=50 src='".plugin_dir_url( __DIR__ )."/voices/public/img/download.svg' alt='Download'></a>";
        $html .= "</div>";
    $html .= "</div>";
    return $html;
}
function get_download_src($id){
    $srcs = getSrcIfNotEmpty('comercial');
    $srcs .= getSrcIfNotEmpty('informativo');
    $srcs .= getSrcIfNotEmpty('personagem');
    $srcs .= getSrcIfNotEmpty('ivr');
    return $srcs;
}
function getSrcIfNotEmpty($type){
    $result = '';
    $id = get_post_meta(get_the_ID(), $type, true);
    if(!empty($id)){
        $result = wp_get_attachment_url($id).",";
    }
    return $result;
}

function showMedias($id){
    $html = "<div class='medias medias_".get_the_ID()."'>";
    $html .= showMediaIfNotEmpty(__( "Comercial", "voices" ), 'comercial', 'audio', 'audio/mpeg');
    $html .= showMediaIfNotEmpty(__( "Institucional", "voices" ), 'personagem', 'audio', 'audio/mpeg');
    $html .= showMediaIfNotEmpty(__( "Informativo", "voices" ), 'informativo', 'audio', 'audio/mpeg');
    $html .= showMediaIfNotEmpty(__( "IVR", "voices" ), 'ivr', 'audio', 'audio/mpeg');
    $html .= showMediaIfNotEmpty(__( "Vídeo", "voices" ), 'video', 'video', 'video/mp4');
    $html .= "</div>";
    return $html;
}
function showMediaIfNotEmpty($name, $type, $media, $mediaType){
    $html = '';
    $id = get_post_meta(get_the_ID(), $type, true);
    if(!empty($id)){
        $html .= "<div class='$media media_$id' onclick='play(".get_the_ID().",".$id.")'><span class='type'>$name</span>";
        $html .= "<div class='container_media'><$media controls style='display: none;' playsinline><source src='".wp_get_attachment_url($id)."' type='$mediaType'></$media><i class='fas fa-times' style='display: none;'></i></div></div>";
    } else {
        $html .= "<div class='$media media_$id empty_media' ><span class='type'>$name</span></div>";
    }
    return $html;
}
function showAddRemoveIcons($id){
    return "<a id='addremove_$id' class='addremove' onclick='addRemoveFavorite(".$id.")'>".__( "Add / Remove", "voices" )."</a>";
}
function showMoreInfo($id){
    return "<div id='more_$id' class='more' onclick='more_info(".$id.")'><i class='fas fa-chevron-down'></i></div>";
}
function showAge($data){
    $html = "<div class='age'>".__( "Idade", "voices" ).": ";
    $date = DateTime::createFromFormat('Ymd', $data);
    $now = date("Y");
    $html .= intval(date("Y")) - intval($date->format("Y"));
    $html .= "</div>";
    return $html;
}
function showLanguages($languages){
    $linguages = __( "Linguagens", "voices" ).": ";
    foreach ($languages as $value) {
        $linguages .= $value.", ";    
    }
    return substr($linguages, 0, -2);
}
?>