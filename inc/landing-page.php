<?php
defined( 'ABSPATH' ) or die();
$currentuser = wp_get_current_user();
if ( ! function_exists( 'plugins_api' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
}
$plugin_data = plugins_api(
	'plugin_information',
	[
		'slug'   => 'facebook-page-feed-graph-api',
		'fields' => [ 'sections' ],
	]
);
?>
<div class="wrap mongoose-facebook-page-plugin">
	<h1 class="notices-placeholder"></h1>
	<div class="mongoose-facebook-page-plugin__banner">
		<img src="<?php echo esc_url( trailingslashit( CJW_FBPP_PLUGIN_URL ) ); ?>images/banner-1544x500.png" />
	</div>
	<div class="mongoose-facebook-page-plugin__box">
		<?php
		printf(
			'<h1 class="page-title">%1$s</h1>',
			esc_html( get_admin_page_title() )
		);
		?>
		<p class="about-description"><?php esc_html_e( 'Thank you for downloading the Mongoose Page Plugin by Mongoose Marketplace! You\'ve joined more than 30,000 other WordPress websites using this plugin to display a Facebook Page on their site. To help introduce you to the plugin, I\'ve created this page full of useful information. Please enjoy using my Mongoose Page Plugin and let me know how it works for you!', 'facebook-page-feed-graph-api' ); ?></p>
	</div>
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder columns-2">
			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables">
					<div class="postbox mongoose-facebook-page-plugin__box">
						<div class="main inside">
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
					</div>
				</div>
				<div class="meta-box-sortables">
					<div class="postbox mongoose-facebook-page-plugin__box">
						<div class="main inside">
							<h2><?php esc_html_e( 'Changelog', 'facebook-page-feed-graph-api' ); ?></h2>
							<h3>
								<?php
								printf(
									/* translators: 1. version number */
									esc_html__( 'New in version %1$s', 'facebook-page-feed-graph-api' ),
									esc_html( CJW_FBPP_PLUGIN_VER )
								);
								?>
							</h3>
							<?php
							if ( ! empty( $plugin_data ) && ! is_wp_error( $plugin_data ) && isset( $plugin_data->sections['changelog'] ) ) {
								$changelog = explode( '</ul>', $plugin_data->sections['changelog'] );
								if ( ! empty( $changelog ) ) {
									$changes = explode( '</h4>', $changelog[0] );
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
					</div>
				</div>
			</div>
			<div id="postbox-container-2" class="postbox-container">
				<div class="meta-box-sortables">
					<div class="postbox mongoose-facebook-page-plugin__box">
						<div class="main inside">
							<h3><i class="dashicons dashicons-heart"></i> <?php _e( 'Donate', 'facebook-page-feed-graph-api' ); ?></h3>
							<p><?php printf(
								__( 'Development relies on donations from kind-hearted supporters of the Mongoose Page Plugin. If you\'re enjoying the plugin, <a href="%1$s" target="_blank" rel="noopener noreferrer">please donate today</a>.', 'facebook-page-feed-graph-api' ),
								CJW_FBPP_PLUGIN_DONATE_LINK
							); ?></p>
						</div>
					</div>
					<div class="postbox mongoose-facebook-page-plugin__box">
						<div class="main inside">
							<h3><i class="dashicons dashicons-email-alt"></i> <?php _e( 'Plugin Newsletter', 'facebook-page-feed-graph-api' ); ?></h3>
							<p><?php _e( 'Subscribe today to receive the latest updates for the Mongoose Page Plugin', 'facebook-page-feed-graph-api' ); ?></p>
							<!-- Begin MailChimp Signup Form -->
							<div id="mc_embed_signup">
							<form action="//cameronjonesweb.us10.list-manage.com/subscribe/post?u=507cd0221f4894316c903e99b&amp;id=8d3d7b8378" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
								<div id="mc_embed_signup_scroll">
									<input type="email" value="<?php echo esc_attr( $currentuser->user_email ); ?>" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
									<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
									<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_507cd0221f4894316c903e99b_8d3d7b8378" tabindex="-1" value=""></div>
									<input type="submit" value="<?php esc_attr_e( 'Subscribe', 'facebook-page-feed-graph-api' ); ?>" name="subscribe" id="mc-embedded-subscribe" class="button">
									<div class="clear"></div>
								</div>
							</form>
							</div>
							<!--End mc_embed_signup-->
						</div>
					</div>
					<div class="postbox mongoose-facebook-page-plugin__box">
						<div class="main inside">
							<h3><i class="dashicons dashicons-star-filled"></i> <?php esc_html_e( 'Leave A Review', 'facebook-page-feed-graph-api' ); ?></h3>
							<p>
                <?php printf(
                  '%1$s <a href="https://wordpress.org/support/view/plugin-reviews/facebook-page-feed-graph-api#new-post" target="_blank" rel="noopener noreferrer">%2$s</a>!</p>',
                  esc_html__( 'Is this the best plugin for adding a Facebook Page to your WordPress website?', 'facebook-page-feed-graph-api' ),
                  esc_html__( 'Let me know', 'facebook-page-feed-graph-api' )
                ); ?>
              </p>
							<p>
                <?php printf(
								__( 'If there\'s a problem, please open a support ticket on <a href="%1$s" target="_blank" rel="noopener noreferrer">Github</a>, on <a href="%2$s" target="_blank" rel="noopener noreferrer">WordPress.org</a>, or <a href="%3$s" target="_blank" rel="noopener noreferrer">email me</a>.', 'facebook-page-feed-graph-api' ),
                  'https://github.com/cameronjonesweb/facebook-page-feed-graph-api/issues',
                  'https://wordpress.org/support/plugin/facebook-page-feed-graph-api',
                  'mailto:support@mongoosemarketplace.com'
                ); ?>
              </p>
						</div>
					</div>
					<div class="postbox mongoose-facebook-page-plugin__box">
						<div class="main inside">
							<h3><i class="dashicons dashicons-chart-line"></i> <?php esc_html_e( 'Take The Survey', 'facebook-page-feed-graph-api' ); ?></h3>
							<p><?php esc_html_e( 'Want to have your say about the Mongoose Page Plugin?', 'facebook-page-feed-graph-api' ); ?></p>
							<p><a href="<?php echo CJW_FBPP_PLUGIN_SURVEY_LINK; ?>" class="button" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Take The Survey!', 'facebook-page-feed-graph-api' ); ?></a></p>
						</div>
					</div>
					<div class="postbox mongoose-facebook-page-plugin__box">
						<div class="main inside">
							<h3><i class="dashicons dashicons-testimonial"></i> <?php esc_html_e( 'Latest News From The Developer', 'facebook-page-feed-graph-api' ); ?></h3>
							<div id="blog-posts-target">
								<span class="spinner is-active"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
