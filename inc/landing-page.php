<?php defined( 'ABSPATH' ) or die();
$currentuser = wp_get_current_user();
$internet = $this->facebook_page_plugin_is_connected(); ?>
<div class="wrap">

	<?php printf(
		'<h1>%1$s</h1>',
		__( 'Facebook Page Plugin', 'facebook-page-feed-graph-api' )
	); ?>

	<div class="welcome-panel">
		<div class="welcome-panel-content">
			<img src="<?php echo CJW_FBPP_PLUGIN_URL; ?>/images/banner-772x250.jpg" class="welcome-panel-image">
			<p class="about-description"><?php _e( 'Thank you for downloading the Facebook Page Plugin by cameronjonesweb! You\'ve joined more than 30,000 other WordPress websites using this plugin to display a Facebook Page on their site. To help introduce you to the plugin, I\'ve created this page full of useful information. Please enjoy using my Facebook Page Plugin and let me know how it works for you!', 'facebook-page-feed-graph-api' ); ?></p>
		</div>
	</div>
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder columns-2">
			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables">
					<div class="postbox">
						<div class="main inside">
							<h2><abbr title="<?php _e( 'Frequently Asked Questions', 'facebook-page-feed-graph-api' ); ?>"><?php _e( 'FAQs', 'facebook-page-feed-graph-api' ); ?></abbr></h2>
							<?php $file = CJW_FBPP_PLUGIN_DIR . '/faq.json';
							$json = file_get_contents( $file );
							$faq_obj = json_decode( $json );
							if( !empty( $faq_obj->faqs ) ) {
								echo '<ul>';
								foreach( $faq_obj->faqs as $faq ) {
									printf(
										'<li><strong>%1$s</strong><p>%2$s</p></li>',
										$faq->question,
										$faq->answer
									);
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
							<h2><?php _e( 'Changelog', 'facebook-page-feed-graph-api' ); ?></h2>
							<h3><?php printf(
								__( 'New in version %1$s', 'facebook-page-feed-graph-api' ),
								CJW_FBPP_PLUGIN_VER
							); ?></h3>
							
							<?php if( !empty( $faq_obj->changelog ) ) {
								foreach( $faq_obj->changelog as $version ) {
									if( $version->version == CJW_FBPP_PLUGIN_VER ) {
										echo '<ul>';
											foreach( $version->changes as $change ) {
												printf(
													'<li>%1$s</li>',
													$change
												);
											}
										echo '</ul>';
										printf(
											'<a href="https://wordpress.org/plugins/facebook-page-feed-graph-api/#developers" target="_blank" rel="noopener noreferrer">%1$s</a>',
											__( 'View full changelog', 'facebook-page-feed-graph-api' )
										);
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
							<p><?php printf(
								__( 'Development relies on donations from kind-hearted supporters of the Facebook Page Plugin. If you\'re enjoying the plugin, <a href="%1$s" target="_blank" rel="noopener noreferrer">please donate today</a>.', 'facebook-page-feed-graph-api' ),
								CJW_FBPP_PLUGIN_DONATE_LINK
							); ?></p>
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
							<p><?php printf(
								'%1$s <a href="https://wordpress.org/support/view/plugin-reviews/facebook-page-feed-graph-api#new-post" target="_blank" rel="noopener noreferrer">%2$s</a>!</p>',
								__( 'Is this the best plugin for adding a Facebook Page to your WordPress website?', 'facebook-page-feed-graph-api' ),
								__( 'Let me know', 'facebook-page-feed-graph-api' )
							); ?></p>
							<p><?php printf(
								__( 'If there\'s a problem, please open a support ticket on <a href="%1$s" target="_blank" rel="noopener noreferrer">Github</a>, on <a href="%2$s" target="_blank" rel="noopener noreferrer">WordPress.org</a>, or <a href="%3$s" target="_blank" rel="noopener noreferrer">email me</a>.', 'facebook-page-feed-graph-api' ),
								'https://github.com/cameronjonesweb/facebook-page-feed-graph-api/issues',
								'https://wordpress.org/support/plugin/facebook-page-feed-graph-api',
								'mailto:plugins@cameronjonesweb.com.au'
								
							); ?></p>
						</div>
					</div>
					<div class="postbox">
						<div class="main inside">
							<h3><i class="dashicons dashicons-chart-line"></i> <?php _e( 'Take The Survey', 'facebook-page-feed-graph-api' ); ?></h3>
							<p><?php _e( 'Want to have your say about the Facebook Page Plugin?', 'facebook-page-feed-graph-api' ); ?></p>
							<p><a href="<?php echo CJW_FBPP_PLUGIN_SURVEY_LINK; ?>" class="button" target="_blank" rel="noopener noreferrer"><?php _e( 'Take The Survey!', 'facebook-page-feed-graph-api' ); ?></a></p>
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