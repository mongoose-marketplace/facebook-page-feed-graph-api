(function($){
	$(document).ready(function(){
		$.ajax({
			type: "GET",
			url: ajaxurl,
			dataType: "html",
			data: {
				action: 'facebook_page_plugin_other_plugins_callback',
			},
			success: function( result ){
				$('#plugins-inside').append(result);
			},
			error: function( result ) {
				$('#plugins-inside').append("There was an error retrieving the plugins");	
			}
		});
		$.ajax({
			type: "GET",
			url: ajaxurl,
			data: {
				action: 'facebook_page_plugin_latest_blog_posts_callback',
			},
			success: function( result ){
				$('#blog-posts-inside').append(result);
			},
			error: function( result ) {
				$('#blog-posts-inside').append("There was an error retrieving the RSS feed");	
			}
		});
	});
})(jQuery);