(function($){
    $(document).ready(function(){
        $('#facebook-page-plugin-shortcode-generator form').submit(function(e){
            e.preventDefault();
        });
        var $facebookURLs = ['https://www.facebook.com/', 'https://facebook.com/', 'www.facebook.com/', 'facebook.com/'];
        $('#facebook-page-plugin-shortcode-generator input').change(function(){
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
                var $posts = $('#fbpp-posts').prop("checked");
                $shortcode += 'posts="' + $posts + '" ';
				var $lang = $('#fbpp-lang').val();
				if($lang.length > 0){
                    $shortcode += 'lang="' + $lang + '" ';
                }
                $shortcode += ' ]';
                $('#facebook-page-plugin-shortcode-generator-output').val($shortcode);
            }
        });
    });
}(jQuery));