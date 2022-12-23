jQuery(document).ready(function(){

	jQuery( '.facebook-page-plugin-shortcode-generator form' ).submit(function(e){
		e.preventDefault();
	});

	var $facebookURLs = ['https://www.facebook.com/', 'https://facebook.com/', 'www.facebook.com/', 'facebook.com/'];
	jQuery('.facebook-page-plugin-shortcode-generator input, .facebook-page-plugin-shortcode-generator select').change(function(){
		console.log('hello');
		if( jQuery('#fbpp-link').prop("checked") == false ) {
			jQuery('#linktext-label').hide();
		} else {
			jQuery('#linktext-label').show();
		}
		var $shortcode = '';
		$shortcode += '[facebook-page-plugin ';
		var $href = jQuery('#fbpp-href').val();
		for(i = 0; i < $facebookURLs.length; i++) {
			$href = $href.replace($facebookURLs[i],'');
		}
		if($href.length > 0){
			$shortcode += 'href="' + $href + '" ';
			var $width = jQuery('#fbpp-width').val();
			if($width.length > 0){
				$shortcode += 'width="' + $width + '" ';
			}
			var $height = jQuery('#fbpp-height').val();
			if($height.length > 0){
				$shortcode += 'height="' + $height + '" ';
			}
			var $cover = jQuery('#fbpp-cover').prop("checked");
			$shortcode += 'cover="' + $cover + '" ';
			var $facepile = jQuery('#fbpp-facepile').prop("checked");
			$shortcode += 'facepile="' + $facepile + '" ';
			var $tabs = [];
			jQuery('.fbpp-tabs').each(function(){
				if( jQuery(this).prop('checked') == true ) {
					$tabs.push( jQuery(this).attr('name' ) );
				}
			});
			if($tabs.length > 0){
				var $tabstring = '';
				for( $i = 0; $i < $tabs.length; $i++ ) {
					$tabstring += $tabs[$i];
					if( $i != $tabs.length - 1 ) {
						$tabstring += ','
					}
				}
				$shortcode += 'tabs="' + $tabstring + '" ';
			}
			var $cta = jQuery('#fbpp-cta').prop("checked");
			$shortcode += 'cta="' + $cta + '" ';
			var $small = jQuery('#fbpp-small').prop("checked");
			$shortcode += 'small="' + $small + '" ';
			var $adapt = jQuery('#fbpp-adapt').prop("checked");
			$shortcode += 'adapt="' + $adapt + '" ';
			var $link = jQuery('#fbpp-link').prop("checked");
			$shortcode += 'link="' + $link + '" ';
			if( $link == true ) {
				var $linktext = jQuery('#fbpp-linktext').val();
				$shortcode += 'linktext="' + $linktext + '" ';
			}
			var $lang = jQuery('#fbpp-lang').val();
			var $method = jQuery('#fbpp-method').val();
			if($method.length > 0){
                $shortcode += 'method="' + $method + '" ';
            }
			if($lang.length > 0){
				$shortcode += 'language="' + $lang + '" ';
			}
			$shortcode += ']';
			jQuery('.facebook-page-plugin-shortcode-generator-output').val($shortcode);

		}

	});

	jQuery( document ).on( 'click', '.facebook-page-plugin-donate-notice-dismiss', function(e){
		e.preventDefault();
		var $notice = jQuery(this).parents('.facebook-page-plugin-donate');
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: {
				action: 'facebook_page_plugin_remove_donate_notice',
			},
			success: function() {
				$notice.fadeOut();
			},
			error: function( data ) {
				console.log( data );
			}
		});
	});

	jQuery( document ).on( 'click', '.settings_page_mongoose-page-plugin .nav-tab', function( e ) {
		e.preventDefault();
		$this = jQuery( this );
		$page = jQuery( '.settings_page_mongoose-page-plugin' );
		$page.find( '.tab-content' ).removeClass( 'active' );
		$page.find( '.nav-tab' ).removeClass( 'nav-tab-active' );
		$this.addClass( 'nav-tab-active' );
		$page.find( $this.attr( 'href' ) ).addClass( 'active' );
	});

});
