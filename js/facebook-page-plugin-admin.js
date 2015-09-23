(function($){
    $(document).ready(function(){
        $('#facebook-page-plugin-shortcode-generator form').submit(function(e){
            e.preventDefault();
        });
        var $facebookURLs = ['https://www.facebook.com/', 'https://facebook.com/', 'www.facebook.com/', 'facebook.com/'];
        $('#facebook-page-plugin-shortcode-generator input, #facebook-page-plugin-shortcode-generator select').change(function(){
            if( $('#fbpp-link').prop("checked") == false ) {
                $('#linktext-label').hide();
            } else {
                $('#linktext-label').show();
            }
            var $shortcode = '';
            $shortcode += '[facebook-page-plugin ';
            var $href = $('#fbpp-href').val();
            for(i = 0; i < $facebookURLs.length; i++) {
                $href = $href.replace($facebookURLs[i],'');
            }
            if($href.length > 0){
                $shortcode += 'href="' + $href + '" ';
                var $width = $('#fbpp-width').val();
                if($width.length > 0){
                    $shortcode += 'width="' + $width + '" ';
                }
                var $height = $('#fbpp-height').val();
                if($height.length > 0){
                    $shortcode += 'height="' + $height + '" ';
                }
                var $cover = $('#fbpp-cover').prop("checked");
                $shortcode += 'cover="' + $cover + '" ';
                var $facepile = $('#fbpp-facepile').prop("checked");
                $shortcode += 'facepile="' + $facepile + '" ';
                var $tabs = $('#fbpp-tabs').val();
                $shortcode += 'tabs="' + $tabs + '" ';
				var $cta = $('#fbpp-cta').prop("checked");
                $shortcode += 'cta="' + $cta + '" ';
				var $small = $('#fbpp-small').prop("checked");
                $shortcode += 'small="' + $small + '" ';
				var $adapt = $('#fbpp-adapt').prop("checked");
                $shortcode += 'adapt="' + $adapt + '" ';
				var $link = $('#fbpp-link').prop("checked");
                $shortcode += 'link="' + $link + '" ';
                if( $link == true ) {
    				var $linktext = $('#fbpp-linktext').val();
                    $shortcode += 'linktext="' + $linktext + '" ';
                }
				var $lang = $('#fbpp-lang').val();
				if($lang.length > 0){
                    $shortcode += 'lang="' + $lang + '" ';
                }
                $shortcode += ']';
                $('#facebook-page-plugin-shortcode-generator-output').val($shortcode);
            }
        });
    });
}(jQuery));