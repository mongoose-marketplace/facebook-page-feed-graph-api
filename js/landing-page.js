(function($){
	$(document).ready(function(){
		$.ajax({
			type: "GET",
			url: ajaxurl,
			data: {
				action: 'facebook_page_plugin_other_plugins_callback',
			},
			success: function( result ){
				$('#plugins-target').html(result);
			},
			error: function( result ) {
				$('#plugins-target').html("There was an error retrieving the plugins");	
			}
		});
		$.ajax({
			type: "GET",
			url: ajaxurl,
			data: {
				action: 'facebook_page_plugin_latest_blog_posts_callback',
			},
			success: function( result ){
				$('#blog-posts-target').html(result);
			},
			error: function( result ) {
				$('#blog-posts-target').html("There was an error retrieving the RSS feed");	
			}
		});
	});
})(jQuery);