<?php
function showAllCategories(){
    $categories = get_categories( array(
        'orderby' => 'id',
        'order'   => 'ASC'
    ));
    return printSelect("categories_filter", __( "Categoria", "voices" ), $categories);
}
function printSelectToSelectionMetadata($selectId, $defaultText, $metaKey){
    $values = formatSelectionMetadata(generateDefaultQuery($metaKey));
    $selected = '';
    
    $htmlCode = '<select name="'.$selectId.'" id="'.$selectId.'">';
    $htmlCode .= '<option value="'.__( "Todos", "voices" ).'">'.$defaultText.'</option>';
    if($values!=NULL){
        foreach ($values as $option) { 
            if(!empty($option)){
                $htmlCode .= "<option value='$option'>$option</option>";
            }
        }  
    }
    $htmlCode .= '</select>';
    return $htmlCode;
}
function printSelectToRadioMetadata($selectId, $defaultText, $metaKey){
    $values = generateDefaultQuery($metaKey);
    $selected = '';
    
    $htmlCode = '<select name="'.$selectId.'" id="'.$selectId.'">';
    $htmlCode .= '<option value="'.__( "Todos", "voices" ).'">'.$defaultText.'</option>';
    if($values!=NULL){
        foreach ($values as $option) { 
            if(!empty($option->value)){
                $htmlCode .= "<option value='$option->value'>$option->value</option>";
            }
        }  
    }
    $htmlCode .= '</select>';
    return $htmlCode;
}
function printSelect($selectId, $defaultText, $values){
    $htmlCode = '<select name="'.$selectId.'" id="'.$selectId.'">';
    $htmlCode .= '<option value="'.__( "Todos", "voices" ).'">'.$defaultText.'</option>';
    if($values!=NULL){
        foreach ($values as $option) { 
            //var_dump($option);
            if(!empty($option) && $option->cat_ID!=1){
                $htmlCode .= "<option value='$option->cat_ID'>$option->name</option>";
            }
        }  
    }
    $htmlCode .= '</select>';
    return $htmlCode;
}
function generateDefaultQuery($metaKey) {
    global $wpdb;
    $query = "SELECT DISTINCT($wpdb->postmeta.meta_value) as value FROM $wpdb->postmeta where $wpdb->postmeta.meta_key = '$metaKey' ORDER BY $wpdb->postmeta.meta_value";
    return $wpdb->get_results($query);
}
function formatSelectionMetadata($values){
    $result = array();
    if($values!=NULL){
        foreach ($values as $option) { 
            $chars = preg_split('/"(.*?)"/', $option->value, -1, PREG_SPLIT_DELIM_CAPTURE);
            for ($i = 1; $i < count($chars); $i+=2) {
                $result[] = $chars[$i];
            }
        }
        $result = array_unique($result);
        sort($result);
    }
    return $result;
}
?>