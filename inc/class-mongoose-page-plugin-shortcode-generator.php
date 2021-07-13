<?php
/**
 * Shortcode generator class
 *
 * @package facebook-page-feed-graph-api
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Shortcode generator class
 */
class Mongoose_Page_Plugin_Shortcode_Generator {

	/**
	 * Available languages
	 *
	 * @var array
	 */
	private $langs;

	/**
	 * Instatiate the class
	 */
	public function __construct() {
		$this->langs = Mongoose_Page_Plugin::get_instance()->locales;
	}

	/**
	 * Create the markup for the shortcode generator
	 */
	public function generate() {
		$return        = null;
		$return       .= Mongoose_Page_Plugin::get_instance()->donate_notice();
		$return       .= '<noscript>' . __( 'The shortcode generator requires JavaScript enabled', 'facebook-page-feed-graph-api' ) . '</noscript>';
		$return       .= '<form>';
		$return       .= '<p><label>' . __( 'Facebook Page URL:', 'facebook-page-feed-graph-api' ) . ' <input type="url" id="fbpp-href" /></label></p>';
		$return       .= '<p><label>' . __( 'Width (pixels):', 'facebook-page-feed-graph-api' ) . ' <input type="number" max="500" min="180" id="fbpp-width" /></label></p>';
		$return       .= '<p><label>' . __( 'Height (pixels):', 'facebook-page-feed-graph-api' ) . ' <input type="number" min="70" id="fbpp-height" /></label></p>';
		$return       .= '<p><label>' . __( 'Show Cover Photo:', 'facebook-page-feed-graph-api' ) . ' <input type="checkbox" value="true" id="fbpp-cover" /></label></p>';
		$return       .= '<p><label>' . __( 'Show Facepile:', 'facebook-page-feed-graph-api' ) . ' <input type="checkbox" value="true" id="fbpp-facepile" /></label></p>';
		$return       .= '<p><label>' . __( 'Page Tabs:', 'facebook-page-feed-graph-api' );
		$settings      = Mongoose_Page_Plugin::get_instance()->get_settings();
		$cjw_fbpp_tabs = $settings['tabs'];
		if ( ! empty( $cjw_fbpp_tabs ) ) {
			foreach ( $cjw_fbpp_tabs as $tab ) {
				$return .= '<br/><label>';
				$return .= '<input type="checkbox" class="fbpp-tabs" name="' . $tab . '" /> ';
				$return .= ucfirst( $tab );
				$return .= '</label>';
			}
		}
		$return .= '<p><label>' . __( 'Hide Call To Action:', 'facebook-page-feed-graph-api' ) . ' <input type="checkbox" value="true" id="fbpp-cta" /></label></p>';
		$return .= '<p><label>' . __( 'Small Header:', 'facebook-page-feed-graph-api' ) . ' <input type="checkbox" value="true" id="fbpp-small" /></label></p>';
		$return .= '<p><label>' . __( 'Adaptive Width:', 'facebook-page-feed-graph-api' ) . ' <input type="checkbox" value="true" id="fbpp-adapt" checked /></label></p>';
		$return .= '<p><label>' . __( 'Display link while loading:', 'facebook-page-feed-graph-api' ) . ' <input type="checkbox" value="true" id="fbpp-link" checked /></label></p>';
		$return .= '<p id="linktext-label"><label>' . __( 'Link text:', 'facebook-page-feed-graph-api' ) . ' <input type="text" id="fbpp-linktext" /></label></p>';
		$return .= '<p><label>' . __( 'Embed method:', 'facebook-page-feed-graph-api' ) . '<select id="fbpp-method"><option value="sdk">' . __( 'SDK', 'facebook-page-feed-graph-api' ) . '</option><option value="iframe">' . __( 'iframe', 'facebook-page-feed-graph-api' ) . '</option></select><label></p>';
		$return .= '<p><label>' . __( 'Language:', 'facebook-page-feed-graph-api' ) . ' <select id="fbpp-lang"><option value="">' . __( 'Site Language', 'facebook-page-feed-graph-api' ) . '</option>';
		if ( isset( $this->langs ) && ! empty( $this->langs ) ) {
			foreach ( $this->langs as $code => $label ) {
				$return .= '<option value="' . esc_attr( $code ) . '">' . esc_html( $label ) . '</option>';
			}
		}
		$return .= '</select></label></p>';
		$return .= '<input type="text" readonly="readonly" id="facebook-page-plugin-shortcode-generator-output" onfocus="this.select()" />';
		$return .= '</form>';

		echo $return;
	}

}
