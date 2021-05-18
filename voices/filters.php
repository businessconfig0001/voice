<?php
function showFilters(){
    $html = "<div class='voices_filters'>";
    $html .= printSelectToSelectionMetadata("language_filter", __( "Idioma", "voices" ), "linguagens");
    $html .= showGender();
    $html .= showAges();
    $html .= showAllCategories();
    $html .= showClean();
    $html .= "</div>";
    $html .= showFilterByName();
    
    return $html;
}
function showFilterByName(){
    return "<div class='voices_filter_name'><input id='name_search' placeholder='".__( "Procurar", "voices" )."...'></div>";
}
function showClean(){
    return '<a id="clean-filters" onclick="cleanFilters()" href="#"><i class="far fa-times-circle"></i></a>';
}
function showGender(){
    $html = "<div class='gender_filter'>";
    $html .= printSelectToRadioMetadata("genero_filter", __( "Gênero", "voices" ), "genero");
    $html .= "</div>";
    return $html;
}
function showAges(){
    $html = "<div class='age_filter' onclick='mostraridades();'>";
    $html .= "<span class='filter-title'>".__( "Idade", "voices" )."</span><div class='dropdownidade' style='display: none;'>";    
    $html .= showCheck("10-15", "10-15", "10-15");
    $html .= showCheck("16-25", "16-25", "16-25");
    $html .= showCheck("26-40", "26-40", "26-40");
    $html .= showCheck("41-65", "41-65", "41-65");
    $html .= showCheck("_66", "_66", "66+");
    $html .= "</div></div>";
    return $html;
}
function showCheck($name, $value, $text){
    return "<input type='checkbox' name='$name' id='$name' value='$value'> $text<br>";
}
?>