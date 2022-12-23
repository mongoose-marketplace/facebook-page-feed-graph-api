<?php
/**
 * Admin landing page template
 *
 * @package facebook-page-feed-graph-api
 */

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

$currentuser = wp_get_current_user();
$generator   = new Mongoose_Page_Plugin_Shortcode_Generator();

if ( ! function_exists( 'plugins_api' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
}

$plugin_data = plugins_api(
	'plugin_information',
	array(
		'slug'   => 'facebook-page-feed-graph-api',
		'fields' => array( 'sections' ),
	)
);
?>
<div class="wrap">
	<?php
	printf(
		'<h1 class="page-title"><img src="%2$s" width="32" class="page-title__icon" />%1$s</h1>',
		esc_html( get_admin_page_title() ),
		esc_url( trailingslashit( Mongoose_Page_Plugin::get_instance()->dirurl ) . 'images/mongoose-page-plugin-icon.png' )
	);
	?>
	<nav class="nav-tab-wrapper">
		<a href="#tab-welcome" class="nav-tab nav-tab-active"><?php esc_html_e( 'Welcome', 'facebook-page-feed-graph-api' ); ?></a>
		<a href="#tab-changelog" class="nav-tab"><?php esc_html_e( 'Changelog', 'facebook-page-feed-graph-api' ); ?></a>
		<a href="#tab-faqs" class="nav-tab"><?php esc_html_e( 'FAQs', 'facebook-page-feed-graph-api' ); ?></a>
		<a href="#tab-shortcode-generator" class="nav-tab"><?php esc_html_e( 'Shortcode Generator', 'facebook-page-feed-graph-api' ); ?></a>
		<a href="#tab-support" class="nav-tab"><?php esc_html_e( 'Support', 'facebook-page-feed-graph-api' ); ?></a>
	</nav>

	<div class="tab-content active" id="tab-welcome">
		<h2><?php esc_html_e( 'Welcome', 'facebook-page-feed-graph-api' ); ?></h2>
		<p><?php esc_html_e( 'Thank you for downloading the Mongoose Page Plugin by Mongoose Marketplace! You\'ve joined more than 30,000 other WordPress websites using this plugin to display a Facebook Page on their site.' ); ?></p>
		<p><?php esc_html_e( 'To help introduce you to the plugin, I\'ve created this page full of useful information. Please enjoy using my Mongoose Page Plugin and let me know how it works for you!', 'facebook-page-feed-graph-api' ); ?></p>
		<h3><?php esc_html_e( 'Support This Plugin', 'facebook-page-feed-graph-api' ); ?></h3>
		<p>
			<?php
			/* translators: 1. closing anchor tag 2. opening anchor tag (WP.org review) 3. opening anchor tag (Patreon) */
			printf(
				__( 'If the Mongoose Page Plugin provides you value, please consider %2$sleaving a review%1$s or %3$ssupporting us on Patreon%1$s.' ), // phpcs:ignore
				'</a>',
				'<a href="https://wordpress.org/support/view/plugin-reviews/facebook-page-feed-graph-api#new-post" target="_blank" rel="noopener noreferrer">',
				'<a href="https://www.patreon.com/cameronjonesweb" target="_blank" rel="noopener noreferrer">'
			);
			?>
		</p>
	</div>
	<div class="tab-content" id="tab-changelog">
		<h2><?php esc_html_e( 'Changelog', 'facebook-page-feed-graph-api' ); ?></h2>
		<?php
		if ( ! empty( $plugin_data ) && ! is_wp_error( $plugin_data ) && isset( $plugin_data->sections['changelog'] ) ) {
			$changelog = explode( '</ul>', $plugin_data->sections['changelog'] );
			if ( ! empty( $changelog ) ) {
				$changes = explode( '</h3>', $changelog[0] );
				echo wp_kses_post( $changes[1] );
				echo '</ul>';
			}
		}
		printf(
			'<p><a href="https://wordpress.org/plugins/facebook-page-feed-graph-api/#developers" target="_blank" rel="noopener noreferrer">%1$s</a></p>',
			esc_html__( 'View full changelog', 'facebook-page-feed-graph-api' )
		);
		?>
	</div>
	<div class="tab-content" id="tab-faqs">
		<h2><?php esc_html_e( 'FAQs', 'facebook-page-feed-graph-api' ); ?></h2>
		<?php
		if ( ! empty( $plugin_data ) && ! is_wp_error( $plugin_data ) && isset( $plugin_data->sections['faq'] ) ) {
			$faqs = $plugin_data->sections['faq'];
			echo wp_kses_post( $faqs );
		} else {
			esc_html_e( 'There was a problem retrieving the FAQs.', 'facebook-page-feed-graph-api' );
		}
		?>
	</div>
	<div class="tab-content" id="tab-shortcode-generator">
		<h2><?php esc_html_e( 'Shortcode Generator', 'facebook-page-feed-graph-api' ); ?></h2>
		<?php $generator->generate(); ?>
	</div>
	<div class="tab-content" id="tab-support">
		<h2><?php esc_html_e( 'Support', 'facebook-page-feed-graph-api' ); ?></h2>
		<p>
			<?php
			printf(
				/* translators: 1. closing anchor tag 2. opening anchor tag (GitHub) 3. opening anchor tag (WP.org) 4. opening anchor tag (website) */
				__( 'If you run into any issues with the plugin, please open a support ticket on %2$sGithub%1$s, on %3$sWordPress.org%1$s or on %4$sour website%1$s.', 'facebook-page-feed-graph-api' ), // phpcs:ignore
				'</a>',
				'<a href="https://github.com/cameronjonesweb/facebook-page-feed-graph-api/issues" target="_blank" rel="noopener noreferrer">',
				'<a href="https://wordpress.org/support/plugin/facebook-page-feed-graph-api" target="_blank" rel="noopener noreferrer">',
				'<a href="https://mongoosemarketplace.com/support/" target="_blank" rel="noopener noreferrer">'
			);
			?>
		</p>
	</div>
</div>
