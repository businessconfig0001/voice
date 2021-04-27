jQuery(document).ready(function($){
    $('#language_filter').change(function() {
        search();
    });
    $('#genero_filter').change(function() {
        search();
    });
    $('#categories_filter').change(function() {
        search();
    });
    $('#10-15').change(function() {
        search();
    });
    $('#16-25').change(function() {
        search();
    });
    $('#26-40').change(function() {
        search();
    });
    $('#41-65').change(function() {
        search();
    });
    $('#_66').change(function() {
        search();
    });
    $('#name_search').keyup(function() {
        search();
    });
    $(".medias audio").each(function(n) {
            $(this).attr("id", "audio" + n);
      });
    checkFavorites();
});
function checkFavorites(){
    var cookie = getCookie("favorite_voice");
    var cookies = cookie.split("|");
    for (i = 0; i < cookies.length; i++) {
        var id = cookies[i];
        changeCssClass(id);
    }
    setFavoriteCount(cookie);
}
function multi_download(links){
    var links_array = links.split(",");

    for (i = 0; i < links_array.length; i++) {
        if (links_array[i]) {
            download(links_array[i]);
        }
    }
}
function download(uri) {
    var link = document.createElement("a");
    // If you don't know the name or want to use
    // the webserver default set name = ''
    link.setAttribute('download', '');
    link.href = uri;
    document.body.appendChild(link);
    link.click();
    link.remove();
}

function share(link){
    copyStringToClipboard(link);
    alert("Link copiado para sua área de transferência!");
}
function copyStringToClipboard (str) {
   // Create new element
   var el = document.createElement('textarea');
   // Set value (string to be copied)
   el.value = str;
   // Set non-editable to avoid focus and move outside of view
   el.setAttribute('readonly', '');
   el.style = {position: 'absolute', left: '-9999px'};
   document.body.appendChild(el);
   // Select text inside element
   el.select();
   // Copy text to clipboard
   document.execCommand('copy');
   // Remove temporary element
   document.body.removeChild(el);
}
function sendRequest(){
    var data = {
		'action': 'sendRequest',
		'nome': jQuery('#nome').val(),
		'apelido': jQuery('#apelido').val(),
		'email': jQuery('#email').val(),
		'telefone': jQuery('#telefone').val(),
		'projeto': jQuery('#projeto').val()
	};
    jQuery.post('/wp-admin/admin-ajax.php', data, function(response) {
        response = JSON.parse(response);
        alert(response.data);
    });
}
function cleanFilters(){
    jQuery("#categories_filter").find('option').removeAttr("selected");
    jQuery("#language_filter").find('option').removeAttr("selected");
    jQuery("#genero_filter").find('option').removeAttr("selected");
    jQuery("#name_search").val("");
    
    jQuery('#10-15').removeAttr('checked');
    jQuery('#16-25').removeAttr('checked');
    jQuery('#26-40').removeAttr('checked');
    jQuery('#41-65').removeAttr('checked');
    jQuery('#_66').removeAttr('checked');
    
    search();
}
function getData(){
    var data = {
		'action': 'voiceSearch',
		'language': jQuery('#language_filter').val(),
		'gender': jQuery('#genero_filter').val(),
		'category': jQuery('#categories_filter').val(),
		'name': jQuery('#name_search').val(),
		'age': getIdades()
	};
	return data;
}
function getIdades(){
    var result = "";
    result += check(jQuery('#10-15'));
    result += check(jQuery('#16-25'));
    result += check(jQuery('#26-40'));
    result += check(jQuery('#41-65'));
    result += check(jQuery('#_66'));
    
    return result;
}
function check(field){
    var result = "";
    if (field.prop("checked")){
        result += field.val()+";";
    }
    return result;
}
function search(){
    jQuery.post('/wp-admin/admin-ajax.php', getData(), function(response) {
        jQuery('#voice_main').empty();
        jQuery('#voice_main').html(response);
        loadmore_params.current_page = 1;
        updateCount();
        checkFavorites();
    });
}
function updateCount(){
    var numItems = jQuery('.voice').length
    jQuery('#result_count').empty();
    jQuery('#result_count').html(numItems);
}
function addRemoveFavorite(id){
    var idsSeparator = "|";
    var cookie = getCookie("favorite_voice");
    if(cookie!=null && cookie.indexOf(id) > -1) {//if contains
        //remove
        cookie = cookie.replace(idsSeparator+id, "");
        removeItem(id);
    } else {
        //add
        cookie = cookie+idsSeparator+id;
        //Add item on html
        jQuery('.voices_on_quote').last().after(getItem(id));
    }
    setCookie("favorite_voice",cookie);
    setFavoriteCount(cookie);
    changeCssClass(id);
}
function removeItem(id){
    jQuery('#voice_on_quote_'+id).remove();
}
function getItem(id){
    var html = jQuery('#voice_'+id).clone();
    html.find('.addremove').remove();
    html.find('.age').remove();
    //html.find('.gender').remove();
    html.find('.linguagens').remove();
    html.find('.medias').remove();
    html.find('.bio').remove();
    html.find('.share').remove();
    html.append("<a id='addremove_"+id+"' onclick='addRemoveFavorite("+id+")'>Remover</a>");
    
    html.addClass("voice_on_quote");
    html.attr('id', 'voice_on_quote_'+id);
    return html;
}
function setFavoriteCount(cookie){
    var favorites = cookie.split("|");
    jQuery('#quote_count').html(favorites.length-1);
}
function removeAllFavorites(){
    var cookie = getCookie("favorite_voice");
    var cookies = cookie.split("|");
    for (i = 0; i < cookies.length; i++) {
        addRemoveFavorite(cookies[i]);
    }
    
    setCookie("favorite_voice","");
    jQuery('#quote_count').html("");
}
function changeCssClass(id){
    var element = jQuery("#addremove_"+id);
    var classe = "added";
    if(element.hasClass(classe)){
        element.removeClass(classe);
    } else {
        element.addClass(classe);
    }
}
function setCookie(name,value) {
    document.cookie = name + "=" + value + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}


function more_info(id){
    //var element = jQuery("#more_"+id);
    var maisinfo = jQuery(".mais_info_"+id);
    var classe = "mostrarinfo";
    var icon = jQuery("#more_"+id);
    maisinfo.toggleClass(classe);
    //icon.html("<i class='fas fa-chevron-up'></i>");
    icon.find('i').toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
}
var oldMainId =0;
var oldId =0;
function play(mainId, id) {
    var audio = document.querySelector(".medias_"+mainId+" .media_"+id+ " audio");
    var video = document.querySelector(".medias_"+mainId+" .media_"+id+ " video");
    
    var type = jQuery(".medias_"+mainId+" .media_"+id+ " .type");
    
    if (audio && audio.paused) {
        pauseLast();
        
        audio.play();
        type.addClass('pause');
    }else if (video && video.paused) {
        pauseLast();
        
        video.play();
        type.addClass('pause');
        //video.toggle();
    }else if (video && video) {
        video.pause();
        type.removeClass('pause');
        //video.toggle();
    }else {
        audio.pause();
        type.removeClass('pause');
    }
    
    oldMainId = mainId;
    oldId = id;
}
function pauseLast(){
    var audio = document.querySelector(".medias_"+oldMainId+" .media_"+oldId+ " audio");
    var video = document.querySelector(".medias_"+oldMainId+" .media_"+oldId+ " video");
    var type = jQuery(".medias_"+oldMainId+" .media_"+oldId+ " .type");
    if (audio){
        audio.pause();
        type.removeClass('pause');
    }
    if (video) {
        video.pause();
        type.removeClass('pause');
        //video.toggle();
    }
}
function old_play(id) {
        //var audio = jQuery(".medias_"+id+ "#audio0");
        //var audio = document.getElementById("audio0");
        
        //var video = document.querySelector(".medias_"+id+ "> video");
        //video.play();
        
        var audio = document.querySelector(".medias_"+id+ " .audio audio");
        var video = document.querySelector(".medias_"+id+ " .video video");
        
        var seaudio = document.querySelector(".medias_"+id+ " .audio");
        var sevideo = document.querySelector(".medias_"+id+ " .video");
        
        var mostrarvideo = jQuery(".medias_"+id+ " .video video");
    
        
        var type = jQuery(".medias_"+id+ " .type");
        
        if (seaudio && audio.paused) {
            audio.play();
            type.addClass('pause');
        }
        else if (sevideo && video.paused) {
            video.play();
            type.addClass('pause');
            mostrarvideo.toggle();
        }
        
        else if (sevideo && video) {
            video.pause();
            type.removeClass('pause');
            mostrarvideo.toggle();
        }
        
        else {
            audio.pause();
            type.removeClass('pause');
        }
        
      }
      
      
function mostraridades() {
    var mostraridades = jQuery(".dropdownidade");
    mostraridades.toggle();
}