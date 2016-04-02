jQuery( function() {
    // Short-circuit selective refresh events if not in customizer preview or pre-4.5.
    if ( 'undefined' === typeof wp || ! wp.customize || ! wp.customize.selectiveRefresh ) {
        return;
    }
 
    // Re-load Facebook Page Plugin when a partial is rendered.
    wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function( placement ) {
        if ( placement.container ) {
            if( placement.container.find('.cameronjonesweb_facebook_page_plugin') ) {
                var wrapper = placement.container.find('.cameronjonesweb_facebook_page_plugin');
                var containerId = wrapper.attr('id');
                var container = wrapper.children('.fb-page');
                var url = container.data('href');
                container.load( url, function() {
                    FB.XFBML.parse(document.getElementById( containerId ),
                        function() {
                            container.fadeIn( "slow" );
                        }
                    );
                });
            }
        }
    } );
 
    // Refresh a moved partial containing a Facebook Page Plugin, since it has to be re-built.
    wp.customize.selectiveRefresh.bind( 'partial-content-moved', function( placement ) {
        if ( placement.container && placement.container.find( '.cameronjonesweb_facebook_page_plugin' ).length ) {
            placement.partial.refresh();
        }
    } );
} );