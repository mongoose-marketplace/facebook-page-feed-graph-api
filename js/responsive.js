var $width = jQuery(window).width();
jQuery(window).resize(function() {
   if(this.resizeTO) clearTimeout(this.resizeTO);
   if($width != jQuery(window).width()){
      this.resizeTO = setTimeout(function() {
         jQuery(this).trigger('resizeEnd');
      }, 500);
   }
});

jQuery(window).bind('resizeEnd', function() {
   $width = jQuery(window).width();
   rerenderFB();
});

function rerenderFB(){
   jQuery('.cameronjonesweb_facebook_page_plugin').each(function(){
      var container = jQuery(this).children('.fb-page');
      var wrapper = jQuery(this);
      var url = container.data('href');
      var width = wrapper.width();
      var max_width = container.data('max-width');
      var containerId = jQuery(this).attr('id');
      if( jQuery(container).data('adapt-container-width') == true ) {
         container.fadeOut("slow", function() {
            if( width <= max_width ) {
               container.attr("data-width", width);
            } else {
               container.attr("data-width", max_width);
            }
            container.load(url, function() {
               FB.XFBML.parse(document.getElementById(containerId),
               function() {
                  container.fadeIn("slow");
               });
            })
         });
      }
   });
}