<?php $currentuser = wp_get_current_user(); ?>
<div class="wrap">
	<h1>Hello World</h1>
	<div class="welcome-panel">
		<div class="welcome-panel-content">
			<p><?php _e( 'Thank you for downloading the Facebook Page Plugin by cameronjonesweb!' ); ?></p>
		</div>
	</div>
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets" class="metabox-holder">
			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables">
					<div class="postbox">
						<div class="main inside">
							<h2><abbr title="Frequently Asked Questions">FAQs</abbr></h2>
							<ul>
								<li>
									<strong>Where is the settings page?</strong>
									<p>There isn't one.</p>
								</li>
								<li>
									<strong>Something's broken, where do I get help?</strong>
									<p>You can go to <a href="https://wordpress.org/support/plugin/facebook-page-feed-graph-api" target="_blank">https://wordpress.org/support/plugin/facebook-page-feed-graph-api</a> and create a support ticket on WordPress.org, or you can email the developer at <a href="mailto:plugins@cameronjonesweb.com.au">plugins@cameronjonesweb.com.au</a>.</p>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div id="postbox-container-2" class="postbox-container">
				<div class="meta-box-sortables">
					<div class="postbox">
						<div class="main inside">
							<h3><i class="dashicons dashicons-heart"></i> Donate</h3>
							<p>Development relies on donations from kind-hearted supporters of the Facebook Page Plugin. If you're enjoying the plugin, <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=WLV5HPHSPM2BG&lc=AU&item_name=cameronjonesweb%20-%20Facebook%20Page%20Plugin&¤cy_code=AUD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted" target="_blank">please donate today</a>.</p>
						</div>
					</div>
					<div class="postbox">
						<div class="main inside">
							<h3><i class="dashicons dashicons-email-alt"></i> Plugin Newsletter</h3>
							<p>Subscribe today to receive the latest updates for the Facebook Page Plugin</p>
							<!-- Begin MailChimp Signup Form -->
							<div id="mc_embed_signup">
							<form action="//cameronjonesweb.us10.list-manage.com/subscribe/post?u=507cd0221f4894316c903e99b&amp;id=8d3d7b8378" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
							    <div id="mc_embed_signup_scroll">
									<input type="email" value="<?php echo $currentuser->user_email; ?>" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
								    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
								    <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_507cd0221f4894316c903e99b_8d3d7b8378" tabindex="-1" value=""></div>
								    <input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button">
								    <div class="clear"></div>
							    </div>
							</form>
							</div>
							<!--End mc_embed_signup-->
						</div>
					</div>
					<div class="postbox">
						<div class="main inside">
							<h3><i class="dashicons dashicons-star-filled"></i> Leave A Review</h3>
							<p>Is this the best plugin for adding a Facebook Page to your WordPress website? <a href="https://wordpress.org/support/view/plugin-reviews/facebook-page-feed-graph-api#postform" target="_blank">Let me know</a>!</p>
							<p>If there's a problem, you can <a href="https://wordpress.org/support/plugin/facebook-page-feed-graph-api" target="_blank">let me know here</a> instead.</p>
						</div>
					</div>
					<div class="postbox">
						<div class="main inside">
							<h3><i class="dashicons dashicons-chart-line"></i> Take The Survey</h3>
							<p>Want to have your say about the Facebook Page Plugin?</p>
						</div>
					</div>
					<div class="postbox">
						<div class="main inside">
							<h3><i class="dashicons dashicons-admin-plugins"></i> More Plugins by cameronjonesweb</h3>
							<p>Help support the developer by using more of his plugins!</p>
							<?php add_thickbox(); ?>
							<div>
								<?php if ( ! function_exists( 'plugins_api' ) ){
									require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
								}
								$plugins = plugins_api( 'query_plugins', array( 
									'author' => 'cameronjonesweb', 'fields' => array(
										'active_installs' => true,
										'description' => false,
										'icons' => true,
									) 
								) );
								for( $i = 0; $i < count( $plugins->plugins ); $i++ ) {
									if( $plugins->plugins[$i]->slug != 'facebook-page-feed-graph-api' ) { ?>
										<div class="plugin-card">
											<div class="plugin-card-top">
												<?php if( !empty( $plugins->plugins[$i]->icons['1x'] ) ) { ?>
													<img src="<?php echo $plugins->plugins[$i]->icons['1x']; ?>" alt="<?php echo $plugins->plugins[$i]->name; ?> Icon" />
												<?php } ?>
												<h4><strong><?php echo $plugins->plugins[$i]->name; ?></strong></h4>
												<p><?php echo $plugins->plugins[$i]->short_description; ?></p>
												<p><a href="<?php echo self_admin_url(); ?>plugin-install.php?tab=plugin-information&amp;plugin=<?php echo $plugins->plugins[$i]->slug; ?>TB_iframe=true&amp;width=600&amp;height=550" class="thickbox open-plugin-details-modal button" aria-label="More information about <?php echo $plugins->plugins[$i]->name; ?>" data-title="<?php echo $plugins->plugins[$i]->name; ?>">Details &amp; Install</a></p>
											</div>
										</div>
									<?php } ?>
								<?php } ?>
								<div class="clear"></div>
							</div>
						</div>
					</div>
					<div class="postbox">
						<div class="main inside">
							<?php $feed = 'https://cameronjonesweb.com.au/feed/';
							$xml = simplexml_load_file( $feed );
							print_r( $xml ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>