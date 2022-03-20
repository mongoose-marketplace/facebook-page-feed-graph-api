<?php
/**
 * Main plugin class
 *
 * @package facebook-page-feed-graph-api
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Main plugin class
 */
class Mongoose_Page_Plugin {

	/**
	 * The plugin directory path
	 *
	 * @var string
	 */
	private $dirpath;

	/**
	 * The plugin directory URI
	 *
	 * @var string
	 */
	public $dirurl;

	/**
	 * The plugin basename
	 *
	 * @var string
	 */
	private $basefile;

	/**
	 * The plugin basename directory
	 *
	 * @var string
	 */
	private $basename;

	/**
	 * The plugin version
	 *
	 * @var string
	 */
	public $version = '1.8.2';

	/**
	 * The plugin slug
	 *
	 * @var string
	 */
	public $slug = 'facebook-page-feed-graph-api';

	/**
	 * User meta key to hide donate notice
	 *
	 * @var string
	 */
	public $remove_donate_notice_key = 'facebook_page_plugin_donate_notice_ignore';

	/**
	 * All available languages
	 *
	 * @var array
	 */
	public $locales = array(
		'so_SO' => 'Af-Soomaali',
		'af_ZA' => 'Afrikaans',
		'az_AZ' => 'Azərbaycan dili',
		'id_ID' => 'Bahasa Indonesia',
		'ms_MY' => 'Bahasa Melayu',
		'jv_ID' => 'Basa Jawa',
		'cx_PH' => 'Bisaya',
		'bs_BA' => 'Bosanski',
		'br_FR' => 'Brezhoneg',
		'ca_ES' => 'Català',
		'co_FR' => 'Corsu',
		'cy_GB' => 'Cymraeg',
		'da_DK' => 'Dansk',
		'de_DE' => 'Deutsch',
		'et_EE' => 'Eesti',
		'en_GB' => 'English (UK)',
		'en_US' => 'English (US)',
		'en_UD' => 'English (uʍop əpısdՈ)',
		'es_LA' => 'Español',
		'es_ES' => 'Español (España)',
		'eo_EO' => 'Esperanto',
		'eu_ES' => 'Euskara',
		'tl_PH' => 'Filipino',
		'fr_CA' => 'Français (Canada)',
		'fr_FR' => 'Français (France)',
		'fy_NL' => 'Frysk',
		'ff_NG' => 'Fula',
		'fo_FO' => 'Føroyskt',
		'ga_IE' => 'Gaeilge',
		'gl_ES' => 'Galego',
		'gn_PY' => 'Guarani',
		'ha_NG' => 'Hausa',
		'hr_HR' => 'Hrvatski',
		'rw_RW' => 'Ikinyarwanda',
		'it_IT' => 'Italiano',
		'sw_KE' => 'Kiswahili',
		'ht_HT' => 'Kreyòl Ayisyen',
		'ku_TR' => 'Kurdî (Kurmancî)',
		'lv_LV' => 'Latviešu',
		'lt_LT' => 'Lietuvių',
		'hu_HU' => 'Magyar',
		'mg_MG' => 'Malagasy',
		'mt_MT' => 'Malti',
		'nl_NL' => 'Nederlands',
		'nl_BE' => 'Nederlands (België)',
		'nb_NO' => 'Norsk (bokmål)',
		'nn_NO' => 'Norsk (nynorsk)',
		'uz_UZ' => 'O\'zbek',
		'pl_PL' => 'Polski',
		'pt_BR' => 'Português (Brasil)',
		'pt_PT' => 'Português (Portugal)',
		'ro_RO' => 'Română',
		'sc_IT' => 'Sardu',
		'sn_ZW' => 'Shona',
		'sq_AL' => 'Shqip',
		'sk_SK' => 'Slovenčina',
		'sl_SI' => 'Slovenščina',
		'fi_FI' => 'Suomi',
		'sv_SE' => 'Svenska',
		'vi_VN' => 'Tiếng Việt',
		'tr_TR' => 'Türkçe',
		'zz_TR' => 'Zaza',
		'is_IS' => 'Íslenska',
		'cs_CZ' => 'Čeština',
		'sz_PL' => 'ślōnskŏ gŏdka',
		'el_GR' => 'Ελληνικά',
		'be_BY' => 'Беларуская',
		'bg_BG' => 'Български',
		'mk_MK' => 'Македонски',
		'mn_MN' => 'Монгол',
		'ru_RU' => 'Русский',
		'sr_RS' => 'Српски',
		'tt_RU' => 'Татарча',
		'tg_TJ' => 'Тоҷикӣ',
		'uk_UA' => 'Українська',
		'ky_KG' => 'кыргызча',
		'kk_KZ' => 'Қазақша',
		'hy_AM' => 'Հայերեն',
		'he_IL' => 'עברית',
		'ur_PK' => 'اردو',
		'ar_AR' => 'العربية',
		'fa_IR' => 'فارسی',
		'ps_AF' => 'پښتو',
		'cb_IQ' => 'کوردیی ناوەندی',
		'sy_SY' => 'ܣܘܪܝܝܐ',
		'ne_NP' => 'नेपाली',
		'mr_IN' => 'मराठी',
		'hi_IN' => 'हिन्दी',
		'as_IN' => 'অসমীয়া',
		'bn_IN' => 'বাংলা',
		'pa_IN' => 'ਪੰਜਾਬੀ',
		'gu_IN' => 'ગુજરાતી',
		'or_IN' => 'ଓଡ଼ିଆ',
		'ta_IN' => 'தமிழ்',
		'te_IN' => 'తెలుగు',
		'kn_IN' => 'ಕನ್ನಡ',
		'ml_IN' => 'മലയാളം',
		'si_LK' => 'සිංහල',
		'th_TH' => 'ภาษาไทย',
		'lo_LA' => 'ພາສາລາວ',
		'my_MM' => 'မြန်မာဘာသာ',
		'ka_GE' => 'ქართული',
		'am_ET' => 'አማርኛ',
		'km_KH' => 'ភាសាខ្មែរ',
		'tz_MA' => 'ⵜⴰⵎⴰⵣⵉⵖⵜ',
		'zh_TW' => '中文(台灣)',
		'zh_CN' => '中文(简体)',
		'zh_HK' => '中文(香港)',
		'ja_JP' => '日本語',
		'ja_KS' => '日本語(関西)',
		'ko_KR' => '한국어',
	);

	/**
	 * Link to donate
	 *
	 * @var string
	 */
	public $donate_link = 'https://www.patreon.com/cameronjonesweb';

	/**
	 * Link to fill out a feedback survey
	 *
	 * @var string
	 */
	public $survey_link = 'https://cameronjonesweb.typeform.com/to/BllbYm';

	/**
	 * Creates a singleton instance of the plugin class.
	 */
	public static function get_instance() {
		static $inst = null;
		if ( null === $inst ) {
			$inst = new self();
		}
		return $inst;
	}

	/**
	 * Instantiate the class
	 */
	public function __construct() {
		$this->constants();
		$this->files();
		$this->hooks();
		$this->shortcodes();
	}

	/**
	 * Setup dynamic properties.
	 */
	public function constants() {
		$this->dirurl            = plugin_dir_url( dirname( __FILE__ ) );
		$this->dirpath           = plugin_dir_path( dirname( __FILE__ ) );
		$this->basefile          = plugin_basename( $this->dirpath . '/' . $this->slug . '.php' );
		$this->basename          = basename( $this->dirpath );
		$this->settings_page_url = admin_url( 'options-general.php?page=' . $this->slug );
	}

	/**
	 * Include additional files
	 */
	public function files() {
		// Widget class.
		require_once trailingslashit( $this->dirpath ) . 'inc/widgets/class-mongoose-page-plugin-facebook-page-widget.php';
		// Shortcode generator.
		require_once trailingslashit( $this->dirpath ) . 'inc/class-mongoose-page-plugin-shortcode-generator.php';
	}

	/**
	 * Register any actions or filters the plugin needs
	 */
	public function hooks() {
		// Actions.
		add_action( 'wp_dashboard_setup', array( $this, 'facebook_page_plugin_dashboard_widget' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_resources' ) );
		add_action( 'admin_init', array( $this, 'remove_donate_notice_nojs' ) );
		add_action( 'admin_menu', array( $this, 'landing_page_menu' ) );
		add_action( 'wp_ajax_facebook_page_plugin_latest_blog_posts_callback', array( $this, 'facebook_page_plugin_latest_blog_posts_callback' ) );
		add_action( 'wp_ajax_facebook_page_plugin_remove_donate_notice', array( $this, 'remove_donate_notice' ) );
		add_action( 'init', array( $this, 'register_assets' ) );
		add_action( 'widgets_init', array( $this, 'load_widget' ) );
		// Filters.
		add_filter( 'widget_text', 'do_shortcode' );
		add_filter( 'plugin_action_links_' . $this->basename, array( $this, 'plugin_action_links' ) );
	}

	/**
	 * Register the plugins shortcode(s)
	 */
	public function shortcodes() {
		add_shortcode( 'facebook-page-plugin', array( $this, 'facebook_page_plugin' ) );
	}

	/**
	 * Runs on activation
	 *
	 * @param string $plugin The filename of the plugin including the path.
	 */
	public function activate( $plugin ) {
		if ( $plugin === $this->basefile ) {
			wp_safe_redirect( admin_url( 'options-general.php?page=mongoose-page-plugin' ) );
			die();
		}
	}

	/**
	 * Filter functions.
	 */
	private function dashboard_widget_capability() {
		$return = apply_filters( 'facebook_page_plugin_dashboard_widget_capability', 'edit_posts' );
		return $return;
	}

	/**
	 * Get the Facebook App ID
	 *
	 * @return string
	 */
	private function app_id() {
		$return = apply_filters( 'facebook_page_plugin_app_id', '846690882110183' );
		return $return;
	}


	/**
	 * Generate the markup for the donate notice
	 *
	 * @param bool $echo Return or echo the markup.
	 * @return bool|void
	 */
	public function donate_notice( $echo = false ) {
		$return = null;

		if ( current_user_can( 'administrator' ) ) {
			$user_id = get_current_user_id();

			if ( ! get_user_meta( $user_id, $this->remove_donate_notice_key ) || get_user_meta( $user_id, $this->remove_donate_notice_key ) === false ) {
				$return .= '<div class="facebook-page-plugin-donate"><p>';
				$return .= __( 'Thank you for using the Mongoose Page Plugin. Please consider donating to support ongoing development. ', 'facebook-page-feed-graph-api' );
				$return .= '</p><p>';
				$return .= '<a href="' . $this->donate_link . '" target="_blank" class="button button-secondary">' . __( 'Donate now', 'facebook-page-feed-graph-api' ) . '</a>';
				$return .= '<a href="?' . $this->remove_donate_notice_key . '=0" class="notice-dismiss facebook-page-plugin-donate-notice-dismiss" title="' . __( 'Dismiss this notice', 'facebook-page-feed-graph-api' ) . '"><span class="screen-reader-text">' . __( 'Dismiss this notice', 'facebook-page-feed-graph-api' ) . '.</span></a>';
				$return .= '</p></div>';
			}
		}

		if ( $echo ) {
			echo $return;
		} else {
			return $return;
		}
	}

	/**
	 * Set a user meta key to prevent the donate nag showing
	 */
	public function remove_donate_notice() {
		$user_id = get_current_user_id();
		update_user_meta( $user_id, $this->remove_donate_notice_key, 'true', true );

		if ( wp_doing_ajax() ) {
			wp_die();
		}
	}

	/**
	 * No JS callback for removing the donate notice
	 */
	public function remove_donate_notice_nojs() {
		if ( isset( $_GET[ $this->remove_donate_notice_key ] ) && 0 === absint( $_GET[ $this->remove_donate_notice_key ] ) ) {
			$this->remove_donate_notice();
		}
	}


	/**
	 * Add a link to support on plugins listing
	 *
	 * @param array $links Array of links.
	 * @return array
	 */
	public function plugin_action_links( $links ) {
		$links[] = sprintf(
			'<a href="https://wordpress.org/support/plugin/facebook-page-feed-graph-api" target="_blank">%1$s</a>',
			__( 'Support', 'facebook-page-feed-graph-api' )
		);
		return $links;
	}

	/**
	 * Register CSS and JS assets
	 */
	public function register_assets() {
		// Styles.
		wp_register_style( 'facebook-page-plugin-admin-styles', trailingslashit( $this->dirurl ) . 'css/admin-global.css', array(), $this->version );
		wp_register_style( 'facebook-page-plugin-landing-page-css', trailingslashit( $this->dirurl ) . 'css/admin-landing-page.css', array(), $this->version );
		wp_register_style( 'facebook-page-plugin-google-fonts', 'https://fonts.googleapis.com/css?family=Rammetto+One|Paytone+One|Space+Mono:400|Muli:400,400i,700', array(), $this->version );
		// Scripts.
		wp_register_script( 'facebook-page-plugin-admin-scripts', trailingslashit( $this->dirurl ) . 'js/admin-global.js', array( 'jquery' ), $this->version, true );
		wp_register_script( 'facebook-page-plugin-landing-page-js', trailingslashit( $this->dirurl ) . 'js/admin-landing-page.js', array( 'jquery' ), $this->version, true );
		wp_register_script( 'facebook-page-plugin-responsive-script', trailingslashit( $this->dirurl ) . 'js/responsive.min.js', array( 'jquery' ), $this->version, true );
		wp_register_script( 'facebook-page-plugin-sk-hosted', 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v9.0', array(), '9.0', true );
		wp_register_script( 'facebook-page-plugin-sdk-local', trailingslashit( $this->dirurl ) . 'js/sdk.js', array(), '9.0', true );
	}

	/**
	 * Enqueue CSS and JS for admin
	 */
	public function admin_resources() {
		wp_enqueue_script( 'facebook-page-plugin-admin-scripts' );
		wp_enqueue_style( 'facebook-page-plugin-admin-styles' );

	}

	/**
	 * Register the dashboard widget
	 */
	public function facebook_page_plugin_dashboard_widget() {
		if ( current_user_can( $this->dashboard_widget_capability() ) ) {
			wp_add_dashboard_widget( 'facebook-page-plugin-shortcode-generator', __( 'Mongoose Page Plugin Shortcode Generator', 'facebook-page-feed-graph-api' ), array( $this, 'dashboard_widget_callback' ) );
		}
	}

	/**
	 * Load the dashboard widget
	 */
	public function dashboard_widget_callback() {
		echo '<a name="cameronjonesweb_facebook_page_plugin_shortcode_generator"></a>';
		$generator = new Mongoose_Page_Plugin_Shortcode_Generator();
		$generator->generate();
	}

	/**
	 * Register the settings page
	 *
	 * Doesn't have any settings, more a landing page for FAQs
	 */
	public function landing_page_menu() {
		add_options_page(
			__( 'Mongoose Page Plugin by Mongoose Marketplace', 'facebook-page-feed-graph-api' ),
			'Mongoose Page Plugin',
			'install_plugins',
			'mongoose-page-plugin',
			array( $this, 'facebook_page_plugin_landing_page' )
		);
	}

	/**
	 * Settings page callback
	 *
	 * Registers the required assets and includes the template
	 */
	public function facebook_page_plugin_landing_page() {
		wp_enqueue_style( 'facebook-page-plugin-landing-page-css' );
		wp_enqueue_style( 'facebook-page-plugin-google-fonts' );
		wp_enqueue_script( 'facebook-page-plugin-landing-page-js' );
		require_once trailingslashit( $this->dirpath ) . 'inc/templates/landing-page.php';
	}

	/**
	 * Get the latests posts from developer and plugin store sites
	 */
	public function facebook_page_plugin_latest_blog_posts_callback() {
		$links = sprintf(
			'<p><a href="https://cameronjonesweb.com.au/blog/" target="_blank">%1$s</a> | <a href="https://mongoosemarketplace.com/news/" target="_blank">%2$s</a></p>',
			__( 'Developer\'s blog', 'facebook-page-feed-graph-api' ),
			__( 'Latest plugin news', 'facebook-page-feed-graph-api' )
		);
		wp_widget_rss_output( 'http://www.rssmix.com/u/13155011/rss.xml', array( 'show_date' => 1 ) );
		wp_die( $links );
	}

	/**
	 * Create a random string to serve as the ID of the wrapper
	 */
	public function facebook_page_plugin_generate_wrapper_id() {
		return wp_generate_password( 15, false );
	}

	/**
	 * Parse shortcode
	 *
	 * @param array $filter Supplied shortcode attributes.
	 * @return string
	 */
	public function facebook_page_plugin( $filter ) {
		wp_enqueue_script( 'facebook-page-plugin-responsive-script' );
		$return = '';
		$a      = shortcode_atts(
			array(
				'href'            => null,
				'width'           => 340,
				'height'          => 130,
				'cover'           => null,
				'facepile'        => null,
				'posts'           => null,
				'tabs'            => array(),
				'language'        => get_bloginfo( 'language' ),
				'cta'             => null,
				'small'           => null,
				'adapt'           => null,
				'link'            => true,
				'linktext'        => null,
				'method'          => 'sdk',
				'_implementation' => 'shortcode',
			),
			$filter
		);
		if ( isset( $a['href'] ) && ! empty( $a['href'] ) ) {
			$a['language'] = str_replace( '-', '_', $a['language'] );

			$return .= sprintf(
				'<div class="cameronjonesweb_facebook_page_plugin" data-version="%1$s" data-implementation="%2$s" id="%3$s" data-method="%4$s">',
				esc_attr( $this->version ),
				esc_attr( $a['_implementation'] ),
				esc_attr( $this->facebook_page_plugin_generate_wrapper_id() ),
				esc_attr( $a['method'] )
			);

			if ( 'sdk' === $a['method'] ) {

				$return .= '<div id="fb-root"></div><script async defer crossorigin="anonymous" src="https://connect.facebook.net/' . $a['language'] . '/sdk.js#xfbml=1&version=v11.0"></script>';

				$return .= sprintf(
					'<div class="fb-page" data-href="https://facebook.com/%1$s" ',
					esc_attr( $a['href'] )
				);
				if ( isset( $a['width'] ) && ! empty( $a['width'] ) ) {
					$return .= sprintf(
						' data-width="%1$s" data-max-width="%1$s"',
						esc_attr( $a['width'] )
					);
				}
				if ( isset( $a['height'] ) && ! empty( $a['height'] ) ) {
					$return .= sprintf(
						' data-height="%1$s"',
						esc_attr( $a['height'] )
					);
				}
				if ( isset( $a['cover'] ) && ! empty( $a['cover'] ) ) {
					if ( 'false' == $a['cover'] ) {
						$return .= ' data-hide-cover="true"';
					} elseif ( 'true' == $a['cover'] ) {
						$return .= ' data-hide-cover="false"';
					}
				}
				if ( isset( $a['facepile'] ) && ! empty( $a['facepile'] ) ) {
					$return .= ' data-show-facepile="' . esc_attr( $a['facepile'] ) . '"';
				}
				if ( isset( $a['tabs'] ) && ! empty( $a['tabs'] ) ) {
					$return .= sprintf(
						' data-tabs="%1$s"',
						esc_attr( $a['tabs'] )
					);
				} elseif ( isset( $a['posts'] ) && ! empty( $a['posts'] ) ) {
					if ( 'true' == $a['posts'] ) {
						$return .= ' data-tabs="timeline"';
					} else {
						$return .= ' data-tabs="false"';
					}
				}
				if ( isset( $a['cta'] ) && ! empty( $a['cta'] ) ) {
					$return .= sprintf(
						' data-hide-cta="%1$s"',
						esc_attr( $a['cta'] )
					);
				}
				if ( isset( $a['small'] ) && ! empty( $a['small'] ) ) {
					$return .= sprintf(
						' data-small-header="%1$s"',
						esc_attr( $a['small'] )
					);
				}
				if ( isset( $a['adapt'] ) && ! empty( $a['adapt'] ) ) {
					$return .= ' data-adapt-container-width="true"';
				} else {
					$return .= ' data-adapt-container-width="false"';
				}
				$return .= '><div class="fb-xfbml-parse-ignore">';
				if ( 'true' == $a['link'] ) {
					$return .= sprintf(
						'<blockquote cite="https://www.facebook.com/%1$s"><a href="https://www.facebook.com/%1$s">',
						esc_attr( $a['href'] )
					);
					if ( empty( $a['linktext'] ) ) {
						$return .= 'https://www.facebook.com/' . esc_attr( $a['href'] );
					} else {
						$return .= esc_html( $a['linktext'] );
					}
					$return .= '</a></blockquote>';
				}
				$return .= '</div>'; // .fb-xfbml-parse-ignore.
				$return .= '</div>'; // .fb-page.
			} elseif ( 'iframe' === $a['method'] ) {
				$url     = add_query_arg(
					array(
						'href'                  => $a['href'],
						'width'                 => $a['width'],
						'height'                => $a['height'],
						'hide_cover'            => ! is_null( $a['cover'] ) ? strval( ! filter_var( $a['cover'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE ) ) : null,
						'show_facepile'         => $a['facepile'],
						'tabs'                  => ! empty( $a['posts'] ) ? 'timeline' : $a['tabs'],
						'hide_cta'              => $a['cta'],
						'small_header'          => $a['small'],
						'adapt_container_width' => $a['adapt'],
						'locale'                => $a['language'],
					),
					'https://www.facebook.com/plugins/page.php'
				);
				$return .= sprintf(
					'<iframe src="%1$s" width="%2$s" height="%3$s" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>',
					esc_url( $url ),
					esc_attr( $a['width'] ),
					esc_attr( $a['height'] )
				);
			}
			$return .= '</div>'; // .cameronjonesweb_facebook_page_plugin.
		}
		return $return;
	}

	/**
	 * Register the widget
	 */
	public function load_widget() {
		register_widget( 'Mongoose_Page_Plugin_Facebook_Page_Widget' );
	}

	/**
	 * Get settings for the embed
	 *
	 * @return array
	 */
	public function get_settings() {
		$return         = array();
		$return['tabs'] = array( 'timeline', 'events', 'messages' );
		return $return;
	}

}

