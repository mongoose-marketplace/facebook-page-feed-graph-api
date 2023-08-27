<?php
/**
 * Facebook page embed widget class
 *
 * @package facebook-page-feed-graph-api
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Facebook page embed widget class
 */
class Mongoose_Page_Plugin_Facebook_Page_Widget extends WP_Widget {

	/**
	 * List of all formats a URL might take
	 *
	 * @var array
	 */
	private $facebook_urls = array( 'https://www.facebook.com/', 'https://facebook.com/', 'www.facebook.com/', 'facebook.com/', 'http://facebook.com/', 'http://www.facebook.com/' );

	/**
	 * Embed settings
	 *
	 * @var array
	 */
	private $settings;

	/**
	 * Instantiate the widget
	 */
	public function __construct() {
		$this->settings = Mongoose_Page_Plugin::get_instance()->get_settings();
		parent::__construct( 'facebook_page_plugin_widget', __( 'Mongoose Page Plugin: Facebook Page Embed', 'facebook-page-feed-graph-api' ), array( 'description' => __( 'Generates a Facebook Page feed in your widget area', 'facebook-page-feed-graph-api' ) ) );
	}

	/**
	 * Render widget on the front end
	 *
	 * @param array $args Widget args.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {
		if ( isset( $instance['title'] ) && ! empty( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
		} else {
			$title = null;
		}
		if ( isset( $instance['href'] ) && ! empty( $instance['href'] ) ) {
			$href = $instance['href'];
			foreach ( $this->facebook_urls as $url ) {
				$href = str_replace( $url, '', $href );
			}
		} else {
			$href = null;
		}
		if ( isset( $instance['width'] ) && ! empty( $instance['width'] ) ) {
			$width = $instance['width'];
		} else {
			$width = null;
		}
		if ( isset( $instance['height'] ) && ! empty( $instance['height'] ) ) {
			$height = $instance['height'];
		} else {
			$height = null;
		}
		if ( isset( $instance['cover'] ) && ! empty( $instance['cover'] ) ) {
			$cover = 'true';
		} else {
			$cover = 'false';
		}
		if ( isset( $instance['facepile'] ) && ! empty( $instance['facepile'] ) ) {
			$facepile = 'true';
		} else {
			$facepile = 'false';
		}
		if ( isset( $instance['tabs'] ) && ! empty( $instance['tabs'] ) ) {
			$tabs = $instance['tabs'];
		} else {
			$tabs = '';
		}
		if ( isset( $instance['cta'] ) && ! empty( $instance['cta'] ) ) {
			$cta = 'true';
		} else {
			$cta = 'false';
		}
		if ( isset( $instance['small'] ) && ! empty( $instance['small'] ) ) {
			$small = 'true';
		} else {
			$small = 'false';
		}
		if ( isset( $instance['adapt'] ) && ! empty( $instance['adapt'] ) ) {
			$adapt = 'true';
		} else {
			$adapt = 'false';
		}
		if ( isset( $instance['link'] ) && ! empty( $instance['link'] ) ) {
			$link = 'true';
		} else {
			$link = 'false';
		}
		if ( isset( $instance['linktext'] ) && ! empty( $instance['linktext'] ) ) {
			$linktext = $instance['linktext'];
		} else {
			$linktext = null;
		}
		if ( isset( $instance['language'] ) && ! empty( $instance['language'] ) ) {
			$language = $instance['language'];
		} else {
			$language = null;
		}
		if ( isset( $instance['method'] ) && ! empty( $instance['method'] ) ) {
			$method = $instance['method'];
		} else {
			$method = null;
		}
		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
		if ( ! empty( $title ) ) {
			// Apparently people like to put HTML in their widget titles, not a good idea but okay ¯\_(ツ)_/¯.
			echo $args['before_title'] . $title . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput
		}
		if ( ! empty( $href ) ) {
			$shortcode = '[facebook-page-plugin href="' . $href . '"';
			if ( isset( $width ) && ! empty( $width ) ) {
				$shortcode .= ' width="' . esc_attr( $width ) . '"';
			}
			if ( isset( $height ) && ! empty( $height ) ) {
				$shortcode .= ' height="' . esc_attr( $height ) . '"';
			}
			if ( isset( $cover ) && ! empty( $cover ) ) {
				$shortcode .= ' cover="' . esc_attr( $cover ) . '"';
			}
			if ( isset( $facepile ) && ! empty( $facepile ) ) {
				$shortcode .= ' facepile="' . esc_attr( $facepile ) . '"';
			}
			if ( isset( $tabs ) && ! empty( $tabs ) ) {
				if ( is_array( $tabs ) ) {
					$shortcode .= ' tabs="';
					for ( $i = 0, $c = count( $tabs ); $i < $c; $i++ ) {
						$shortcode .= esc_attr( $tabs[ $i ] );
						$shortcode .= ( $i < $c - 1 ? ',' : '' );
					}
					$shortcode .= '"';
				} else {
					$shortcode .= ' tabs="' . esc_attr( $tabs ) . '"';
				}
			}
			if ( isset( $language ) && ! empty( $language ) ) {
				$shortcode .= ' language="' . esc_attr( $language ) . '"';
			}
			if ( isset( $cta ) && ! empty( $cta ) ) {
				$shortcode .= ' cta="' . esc_attr( $cta ) . '"';
			}
			if ( isset( $small ) && ! empty( $small ) ) {
				$shortcode .= ' small="' . esc_attr( $small ) . '"';
			}
			if ( isset( $adapt ) && ! empty( $adapt ) ) {
				$shortcode .= ' adapt="' . esc_attr( $adapt ) . '"';
			}
			if ( isset( $link ) && ! empty( $link ) ) {
				$shortcode .= ' link="' . esc_attr( $link ) . '"';
			}
			if ( isset( $linktext ) && ! empty( $linktext ) ) {
				$shortcode .= ' linktext="' . esc_attr( $linktext ) . '"';
			}
			if ( isset( $method ) && ! empty( $method ) ) {
				$shortcode .= ' method="' . esc_attr( $method ) . '"';
			}
			$shortcode .= ' _implementation="widget"';
			$shortcode .= ']';
			echo do_shortcode( $shortcode );
		}
		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput
	}

	/**
	 * Register the widget edit form
	 *
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'New title', 'facebook-page-feed-graph-api' );
		}
		if ( isset( $instance['href'] ) ) {
			$href = $instance['href'];
		} else {
			$href = '';
		}
		if ( isset( $instance['width'] ) ) {
			$width = $instance['width'];
		} else {
			$width = '';
		}
		if ( isset( $instance['height'] ) ) {
			$height = $instance['height'];
		} else {
			$height = '';
		}
		if ( isset( $instance['cover'] ) ) {
			$cover = $instance['cover'];
		} else {
			$cover = 'false';
		}
		if ( isset( $instance['facepile'] ) ) {
			$facepile = $instance['facepile'];
		} else {
			$facepile = 'false';
		}
		if ( isset( $instance['tabs'] ) ) {
			$tabs = $instance['tabs'];
		} else {
			$tabs = '';
		}
		if ( isset( $instance['cta'] ) ) {
			$cta = $instance['cta'];
		} else {
			$cta = 'false';
		}
		if ( isset( $instance['small'] ) ) {
			$small = $instance['small'];
		} else {
			$small = 'false';
		}
		if ( isset( $instance['adapt'] ) ) {
			$adapt = $instance['adapt'];
		} else {
			$adapt = 'true';
		}
		if ( isset( $instance['link'] ) ) {
			$link = $instance['link'];
		} else {
			$link = 'true';
		}
		if ( isset( $instance['linktext'] ) ) {
			$linktext = $instance['linktext'];
		} else {
			$linktext = '';
		}
		if ( isset( $instance['language'] ) ) {
			$language = $instance['language'];
		} else {
			$language = '';
		}
		if ( isset( $instance['method'] ) ) {
			$method = $instance['method'];
		} else {
			$method = '';
		}

		$langs = Mongoose_Page_Plugin::get_instance()->locales;

		Mongoose_Page_Plugin::get_instance()->donate_notice( true );

		printf(
			'<p><label for="%1$s">%2$s</label><input class="widefat" id="%1$s" name="%3$s" type="text" value="%4$s" /></p>',
			esc_attr( $this->get_field_id( 'title' ) ),
			esc_html__( 'Title:', 'facebook-page-feed-graph-api' ),
			esc_attr( $this->get_field_name( 'title' ) ),
			esc_attr( $title )
		);

		printf(
			'<p><label for="%1$s">%2$s</label><input class="widefat" id="%1$s" name="%3$s" type="text" value="%4$s" /></p>',
			esc_attr( $this->get_field_id( 'href' ) ),
			esc_html__( 'Page URL:', 'facebook-page-feed-graph-api' ),
			esc_attr( $this->get_field_name( 'href' ) ),
			esc_attr( $href )
		);

		printf(
			'<p><label for="%1$s">%2$s</label><input class="widefat" id="%1$s" name="%3$s" type="number" min="180" max="500" value="%4$s" /></p>',
			esc_attr( $this->get_field_id( 'width' ) ),
			esc_html__( 'Width:', 'facebook-page-feed-graph-api' ),
			esc_attr( $this->get_field_name( 'width' ) ),
			esc_attr( $width )
		);

		printf(
			'<p><label for="%1$s">%2$s</label><input class="widefat" id="%1$s" name="%3$s" type="number" min="70" value="%4$s" /></p>',
			esc_attr( $this->get_field_id( 'height' ) ),
			esc_html__( 'Height:', 'facebook-page-feed-graph-api' ),
			esc_attr( $this->get_field_name( 'height' ) ),
			esc_attr( $height )
		);

		printf(
			'<p><label for="%1$s">%2$s</label> <input class="widefat" id="%1$s" name="%3$s" type="checkbox" value="true" %4$s /></p>',
			esc_attr( $this->get_field_id( 'cover' ) ),
			esc_html__( 'Cover Photo:', 'facebook-page-feed-graph-api' ),
			esc_attr( $this->get_field_name( 'cover' ) ),
			checked( esc_attr( $cover ), 'true', false )
		);

		printf(
			'<p><label for="%1$s">%2$s</label> <input class="widefat" id="%1$s" name="%3$s" type="checkbox" value="true" %4$s /></p>',
			esc_attr( $this->get_field_id( 'facepile' ) ),
			esc_html__( 'Show Facepile:', 'facebook-page-feed-graph-api' ),
			esc_attr( $this->get_field_name( 'facepile' ) ),
			checked( esc_attr( $facepile ), 'true', false )
		);

		echo '<p>';
		esc_html_e( 'Page Tabs:', 'facebook-page-feed-graph-api' );
		$cjw_fbpp_tabs = $this->settings['tabs'];
		if ( ! empty( $cjw_fbpp_tabs ) ) {
			// First we should convert the string to an array as that's how it will be stored moving forward.
			if ( ! is_array( $tabs ) ) {
				$oldtabs = esc_attr( $tabs );
				$newtabs = explode( ',', $tabs );
				$tabs    = $newtabs;
			}
			foreach ( $cjw_fbpp_tabs as $tab ) {
				printf(
					'<br/><label><input type="checkbox" name="%1$s[]" value="%2$s" %3$s /> %4$s</label>',
					esc_attr( $this->get_field_name( 'tabs' ) ),
					esc_attr( $tab ),
					in_array( $tab, $tabs, true ) ? 'checked' : '',
					esc_html( ucfirst( $tab ) )
				);
			}
		}
		echo '</p>';

		printf(
			'<p><label for="%1$s">%2$s</label> <input class="widefat" id="%1$s" name="%3$s" type="checkbox" value="true" %4$s /></p>',
			esc_attr( $this->get_field_id( 'cta' ) ),
			esc_html__( 'Hide Call To Action:', 'facebook-page-feed-graph-api' ),
			esc_attr( $this->get_field_name( 'cta' ) ),
			checked( esc_attr( $cta ), 'true', false )
		);

		printf(
			'<p><label for="%1$s">%2$s</label> <input class="widefat" id="%1$s" name="%3$s" type="checkbox" value="true" %4$s /></p>',
			esc_attr( $this->get_field_id( 'small' ) ),
			esc_html__( 'Small Header:', 'facebook-page-feed-graph-api' ),
			esc_attr( $this->get_field_name( 'small' ) ),
			checked( esc_attr( $small ), 'true', false )
		);

		printf(
			'<p><label for="%1$s">%2$s</label> <input class="widefat" id="%1$s" name="%3$s" type="checkbox" value="true" %4$s /></p>',
			esc_attr( $this->get_field_id( 'adapt' ) ),
			esc_html__( 'Adaptive Width:', 'facebook-page-feed-graph-api' ),
			esc_attr( $this->get_field_name( 'adapt' ) ),
			checked( esc_attr( $adapt ), 'true', false )
		);

		printf(
			'<p><label for="%1$s">%2$s</label> <input class="widefat" id="%1$s" name="%3$s" type="checkbox" value="true" %4$s /></p>',
			esc_attr( $this->get_field_id( 'link' ) ),
			esc_html__( 'Display link while loading:', 'facebook-page-feed-graph-api' ),
			esc_attr( $this->get_field_name( 'link' ) ),
			checked( esc_attr( $link ), 'true', false )
		);

		printf(
			'<p><label for="%1$s">%2$s</label><input class="widefat" id="%1$s" name="%3$s" type="text" value="%4$s" /></p>',
			esc_attr( $this->get_field_id( 'linktext' ) ),
			esc_html__( 'Link text:', 'facebook-page-feed-graph-api' ),
			esc_attr( $this->get_field_name( 'linktext' ) ),
			esc_attr( $linktext )
		);

		printf(
			'<p><label for="%1$s">%2$s</label><select class="widefat" id="%1$s" name="%3$s"><option value="sdk" %6$s>%4$s</option><option value="iframe" %7$s>%5$s</option></select></p>',
			esc_attr( $this->get_field_id( 'method' ) ),
			esc_html__( 'Embed method:', 'facebook-page-feed-graph-api' ),
			esc_attr( $this->get_field_name( 'method' ) ),
			esc_html__( 'SDK', 'facebook-page-feed-graph-api' ),
			esc_html__( 'iframe', 'facebook-page-feed-graph-api' ),
			selected( $method, 'sdk', false ),
			selected( $method, 'iframe', false )
		);

		printf(
			'<p><label for="%1$s">%2$s</label><select class="widefat" id="%1$s" name="%3$s">%4$s</select></p>',
			esc_attr( $this->get_field_id( 'language' ) ),
			esc_html__( 'Language:', 'facebook-page-feed-graph-api' ),
			esc_attr( $this->get_field_name( 'language' ) ),
			call_user_func( // phpcs:ignore WordPress.Security.EscapeOutput
				function() use ( $langs, $language ) {
					$return = '<option value="">' . esc_html__( 'Site Language (default)', 'facebook-page-feed-graph-api' ) . '</option>';
					foreach ( $langs as $code => $label ) {
						$return .= sprintf(
							'<option value="%1$s" %2$s>%3$s</option>',
							esc_attr( $code ),
							selected( esc_attr( $language ), $code, false ),
							esc_html( $label )
						);
					}
					return $return;
				}
			)
		);
	}

	/**
	 * Updating widget replacing old instances with new
	 *
	 * @param array $new_instance Updated widget instance.
	 * @param array $old_instance Previous widget instance.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		if ( ! empty( $new_instance['href'] ) ) {
			$href             = wp_strip_all_tags( $new_instance['href'] );
			$href             = wp_http_validate_url( $href ) ? $href : 'https://facebook.com/' . $href;
			$instance['href'] = esc_url( $href );
		} else {
			$instance['href'] = '';
		}
		$instance['width']    = ( ! empty( $new_instance['width'] ) ) ? wp_strip_all_tags( $new_instance['width'] ) : '';
		$instance['height']   = ( ! empty( $new_instance['height'] ) ) ? wp_strip_all_tags( $new_instance['height'] ) : '';
		$instance['cover']    = ( ! empty( $new_instance['cover'] ) ) ? wp_strip_all_tags( $new_instance['cover'] ) : '';
		$instance['facepile'] = ( ! empty( $new_instance['facepile'] ) ) ? wp_strip_all_tags( $new_instance['facepile'] ) : '';
		if ( ! empty( $new_instance['tabs'] ) ) {
			$instance['tabs'] = $new_instance['tabs'];
			if ( is_array( $new_instance['tabs'] ) ) {
				for ( $i = 0, $c = count( $new_instance['tabs'] ); $i < $c; $i++ ) {
					$instance['tabs'][] = wp_strip_all_tags( $new_instance['tabs'][ $i ] );
				}
			}
		} else {
			$instance['tabs'] = '';
		}
		$instance['cta']      = ( ! empty( $new_instance['cta'] ) ) ? wp_strip_all_tags( $new_instance['cta'] ) : '';
		$instance['small']    = ( ! empty( $new_instance['small'] ) ) ? wp_strip_all_tags( $new_instance['small'] ) : '';
		$instance['adapt']    = ( ! empty( $new_instance['adapt'] ) ) ? wp_strip_all_tags( $new_instance['adapt'] ) : '';
		$instance['link']     = ( ! empty( $new_instance['link'] ) ) ? wp_strip_all_tags( $new_instance['link'] ) : '';
		$instance['linktext'] = ( ! empty( $new_instance['linktext'] ) ) ? wp_strip_all_tags( $new_instance['linktext'] ) : '';
		$instance['language'] = ( ! empty( $new_instance['language'] ) ) ? wp_strip_all_tags( $new_instance['language'] ) : '';
		$instance['method']   = ( ! empty( $new_instance['method'] ) ) ? wp_strip_all_tags( $new_instance['method'] ) : '';
		return $instance;
	}

}
