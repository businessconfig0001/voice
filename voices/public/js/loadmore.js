function showLoader(){
    jQuery(".loader").removeClass("hidden");
}
function hiddeLoader(){
    jQuery(".loader").addClass("hidden");
}
jQuery(function($){
	var canBeLoaded = true, // this param allows to initiate the AJAX call only if necessary
	    bottomOffset = 1000; // the distance (in px) from the page bottom when you want to load more posts
 
    var lastScrollTop = 0;
	$(window).scroll(function(){
		var data = {
			'action': 'loadmore',
			'query': loadmore_params.posts,
			'page' : loadmore_params.current_page,
			'language' : $('#language_filter').val(),
			'gender': $('#genero_filter').val(),
			'category': $('#categories_filter').val(),
			'name': jQuery('#name_search').val(),
			'age': getIdades()
		};
		var st = $(this).scrollTop();
		var scrollDown = false;
        if (st > lastScrollTop){
            scrollDown = true;
        } 
        lastScrollTop = st;

		if((scrollDown===true) && $(document).scrollTop() > ( $(document).height() - bottomOffset ) && canBeLoaded == true ){
		    showLoader();
			$.ajax({
				url : loadmore_params.ajaxurl,
				data:data,
				type:'POST',
				beforeSend: function( xhr ){
					// you can also add your own preloader here
					// you see, the AJAX call is in process, we shouldn't run it again until complete
					canBeLoaded = false; 
				},
				success:function(data){
					if( data ) {
						$('#voice_main .voice').last().after(data); // where to insert posts
						updateCount();
						loadmore_params.current_page++;
					}
					canBeLoaded = true; // the ajax is completed, now we can run it again
					hiddeLoader();
				},
				error: function(xhr, error){
				    canBeLoaded = true; // the ajax is completed, now we can run it again
                    console.debug(xhr);
                    console.debug(error);
                    hiddeLoader();
                }
			});
		}
	});
});