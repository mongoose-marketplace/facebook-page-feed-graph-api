jQuery(window).resize(function() {
   if(this.resizeTO) clearTimeout(this.resizeTO);
   this.resizeTO = setTimeout(function() {
      jQuery(this).trigger('resizeEnd');
   }, 500);
});
jQuery(window).bind('resizeEnd', function() {
   var container = jQuery('#fb-page');
   var url = container.data('href');
   if( jQuery(container).data('adapt-container-width') == true ) {
      container.fadeOut("slow", function() {
         container.load(url, { width: container.width() },
         function() {
            FB.XFBML.parse(document.getElementById('fb-page'),
            function() {
               container.fadeIn("slow");
            });
         })
      });
   }
});