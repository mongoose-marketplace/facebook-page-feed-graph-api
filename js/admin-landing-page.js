jQuery( document ).ready( function() {
	jQuery.ajax({
		type: "GET",
		url: ajaxurl,
		data: {
			action: 'facebook_page_plugin_latest_blog_posts_callback',
		},
		success: function( result ){
			jQuery( '#blog-posts-target' ).html( result );
		},
		error: function( result ) {
			jQuery( '#blog-posts-target' ).html( "There was an error retrieving the RSS feed" );	
		}
	});
});
