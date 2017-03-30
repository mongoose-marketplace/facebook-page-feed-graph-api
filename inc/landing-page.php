<?php defined( 'ABSPATH' ) or die();
$currentuser = wp_get_current_user();
$internet = $this->facebook_page_plugin_is_connected(); ?>
<div class="wrap">

	<h1>Facebook Page Plugin</h1>

	<div class="welcome-panel">
		<div class="welcome-panel-content">
			<img src="<?php echo CJW_FBPP_PLUGIN_URL; ?>/images/banner-772x250.jpg" class="welcome-panel-image">
			<p class="about-description"><?php _e( 'Thank you for downloading the Facebook Page Plugin by cameronjonesweb! You\'ve joined more than 10,000 other WordPress websites using this plugin to display a Facebook Page on their site. To help introduce you to the plugin, I\'ve created this page full of useful information. Please enjoy using my Facebook Page Plugin and let me know how it works for you!', 'facebook-page-feed-graph-api' ); ?></p>
		</div>
	</div>
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">
			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables">
					<div class="postbox">
						<div class="main inside">
							<h2><abbr title="Frequently Asked Questions"><?php _e( 'FAQs', 'facebook-page-feed-graph-api' ); ?></abbr></h2>
							<?php $file = CJW_FBPP_PLUGIN_DIR . '/faq.json';
							$json = file_get_contents( $file );
							$faq_obj = json_decode( $json );
							if( !empty( $faq_obj->faqs ) ) {
								echo '<ul>';
								foreach( $faq_obj->faqs as $faq ) {
									echo '<li>';
										echo '<strong>';
											_e( $faq->question, 'facebook-page-feed-graph-api' );
										echo '</strong>';
										echo '<p>';
											_e( $faq->answer, 'facebook-page-feed-graph-api' );
										echo '</p>';
									echo '</li>';
								}
								echo '</ul>';
							} else {
								_e( 'There was a problem retrieving the FAQs.', 'facebook-page-feed-graph-api' );
							} ?>
						</div>
					</div>
				</div>
				<div class="meta-box-sortables">
					<div class="postbox">
						<div class="main inside">
							<h2>Changelog</h2>
							<h3>New in version <?php echo CJW_FBPP_PLUGIN_VER; ?></h3>
							<?php if( !empty( $faq_obj->changelog ) ) {
								foreach( $faq_obj->changelog as $version ) {
									if( $version->version == CJW_FBPP_PLUGIN_VER ) {
										echo '<ul>';
											foreach( $version->changes as $change ) {
												echo '<li>';
													_e( $change, 'facebook-page-feed-graph-api' );
												echo '</li>';
											}
										echo '</ul>';
										echo '<a href="https://wordpress.org/plugins/facebook-page-feed-graph-api/changelog/" target="_blank">View full changelog</a>';
									}
								}
							} ?>
						</div>
					</div>
				</div>
			</div>
			<div id="postbox-container-2" class="postbox-container">
				<div class="meta-box-sortables">
					<div class="postbox">
						<div class="main inside">
							<h3><i class="dashicons dashicons-heart"></i> <?php _e( 'Donate', 'facebook-page-feed-graph-api' ); ?></h3>
							<p><?php _e( 'Development relies on donations from kind-hearted supporters of the Facebook Page Plugin. If you\'re enjoying the plugin,', 'facebook-page-feed-graph-api' ); ?> <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=WLV5HPHSPM2BG&lc=AU&item_name=cameronjonesweb%20-%20Facebook%20Page%20Plugin&¤cy_code=AUD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted" target="_blank"><?php _e( 'please donate today', 'facebook-page-feed-graph-api' ); ?></a>.</p>
						</div>
					</div>
					<div class="postbox">
						<div class="main inside">
							<h3><i class="dashicons dashicons-email-alt"></i> <?php _e( 'Plugin Newsletter', 'facebook-page-feed-graph-api' ); ?></h3>
							<p><?php _e( 'Subscribe today to receive the latest updates for the Facebook Page Plugin', 'facebook-page-feed-graph-api' ); ?></p>
							<!-- Begin MailChimp Signup Form -->
							<div id="mc_embed_signup">
							<form action="//cameronjonesweb.us10.list-manage.com/subscribe/post?u=507cd0221f4894316c903e99b&amp;id=8d3d7b8378" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
							    <div id="mc_embed_signup_scroll">
									<input type="email" value="<?php echo $currentuser->user_email; ?>" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
								    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
								    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_507cd0221f4894316c903e99b_8d3d7b8378" tabindex="-1" value=""></div>
								    <input type="submit" value="<?php _e( 'Subscribe', 'facebook-page-feed-graph-api' ); ?>" name="subscribe" id="mc-embedded-subscribe" class="button">
								    <div class="clear"></div>
							    </div>
							</form>
							</div>
							<!--End mc_embed_signup-->
						</div>
					</div>
					<div class="postbox">
						<div class="main inside">
							<h3><i class="dashicons dashicons-star-filled"></i> <?php _e( 'Leave A Review', 'facebook-page-feed-graph-api' ); ?></h3>
							<p><?php _e( 'Is this the best plugin for adding a Facebook Page to your WordPress website?', 'facebook-page-feed-graph-api' ); ?> <a href="https://wordpress.org/support/view/plugin-reviews/facebook-page-feed-graph-api#new-post" target="_blank"><?php _e( 'Let me know', 'facebook-page-feed-graph-api' ); ?></a>!</p>
							<p><?php echo __( 'If there\'s a problem, please open a support ticket on', 'facebook-page-feed-graph-api' ) . ' <a href="https://github.com/cameronjonesweb/facebook-page-feed-graph-api/issues" target="_blank">' . __( 'GitHub', 'facebook-page-feed-graph-api' ) . '</a>' . __( ', on', 'facebook-page-feed-graph-api' ) . ' <a href="https://wordpress.org/support/plugin/facebook-page-feed-graph-api" target="_blank">' . __( 'WordPress.org', 'facebook-page-feed-graph-api' ) . '</a>' . __( ' or ', 'facebook-page-feed-graph-api' ) . '<a href="mailto:plugins@cameronjonesweb.com.au" target="_blank">' . __( 'email me', 'facebook-page-feed-graph-api' ) . '</a>.'; ?></p>
						</div>
					</div>
					<div class="postbox">
						<div class="main inside">
							<h3><i class="dashicons dashicons-chart-line"></i> <?php _e( 'Take The Survey', 'facebook-page-feed-graph-api' ); ?></h3>
							<p><?php _e( 'Want to have your say about the Facebook Page Plugin?', 'facebook-page-feed-graph-api' ); ?></p>
							<p><a href="<?php echo CJW_FBPP_PLUGIN_SURVEY_LINK; ?>" class="button" target="_blank"><?php _e( 'Take The Survey!', 'facebook-page-feed-graph-api' ); ?></a></p>
						</div>
					</div>
					<div class="postbox">
						<div class="main inside">
							<h3><i class="dashicons dashicons-admin-plugins"></i> <?php _e( 'More Free Plugins by cameronjonesweb', 'facebook-page-feed-graph-api' ); ?></h3>
							<p><?php _e( 'Help support the developer by using more of my plugins!', 'facebook-page-feed-graph-api' ); ?></p>
							<?php add_thickbox(); ?>
							<div id="plugins-target">
								<span class="spinner is-active"></span>
							</div>
						</div>
					</div>
					<div class="postbox">
						<div class="main inside">
							<h3><i class="dashicons dashicons-testimonial"></i> <?php _e( 'Latest News From The Developer', 'facebook-page-feed-graph-api' ); ?></h3>
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