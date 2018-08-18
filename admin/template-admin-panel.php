<?php defined( 'ABSPATH' ) || exit; ?>
<div class="wrap">
	<h1><img src="<?php echo ATP_DC_IMAGE_URL; ?>atp_logo_208x50.png">Divi Child v<?php echo $this->plugin_version; ?><span class="desc"><?php _e('This plugin generates a Divi child theme with a single clic!', 'rr-atp-divi-child' ); ?></span></h1>
	<?php if ( ! empty( $this->rr_msg[ 'updated' ] ) ) { ?><div class="updated fade"><p><?php echo $this->_get_msg( 'updated' ) . '</p></div>'; } ?>
	<?php if ( ! empty( $this->rr_msg[ 'notice' ] ) ) { ?><div class="notice fade"><p><?php echo $this->_get_msg( 'notice' ) . '</p></div>'; } ?>
	<?php if ( ! empty( $this->rr_msg[ 'error' ] ) ) { ?><div class="error fade"><p><?php echo $this->_get_msg( 'error' ) . '</p></div>'; } ?>
    <div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<!-- Content -->
			<div id="post-body-content">
				<div id="normal-sortables" class="meta-box-sortables ui-sortable">
					<div class="postbox">
						<h3 class="hndle"><span class="dashicons dashicons-admin-settings"></span><?php esc_html_e( 'Settings', 'rr-atp-divi-child' ); ?></h3>
						<?php if ($this->is_divi_installed && $this->is_divi_activated ) : ?>
						<div class="inside">
							<form action="themes.php?page=<?php esc_attr_e( $this->plugin_name ); ?>"&action="<?php echo $this->form_action; ?> " method="post">
                                <p>
                                    <label for="form_atp_name"><?php esc_html_e( 'What name do you want for this child theme?', 'rr-atp-divi-child' ); ?></><span class="required">*</span></label>
                                    <input type="text" name="form_atp_name" id="form_atp_name" class="widefat" tabindex="1" placeholder="<?php echo esc_attr( $this->form_atp_name ); ?>" pattern="[a-zA-Z0-9\- ]{1,25}" title="<?php esc_attr_e('This field contains invalid or too much characters (25 max [a-zA-A0-9 space+hyphens]).', 'rr-atp-divi-child'); ?>" value="<?php echo esc_attr( $this->form_atp_name ); ?>" autofocus required />
                                </p>
                                <p>
                                    <label for="form_atp_author"><?php esc_html_e( 'The author’s name of this child theme will be:', 'rr-atp-divi-child' ); ?></label>
                                    <input type="text" name="form_atp_author" id="form_atp_author" class="widefat" tabindex="2" placeholder="<?php echo esc_attr( $this->form_atp_author ); ?>" pattern="[\p{L}' ]{1,50}" title="<?php esc_attr_e('This field contains invalid or too much characters (50 max).', 'rr-atp-divi-child'); ?>" value="<?php echo esc_attr( $this->form_atp_author ); ?>" />
                                </p>
                                <p>
                                    <label for="form_atp_author_url"><?php esc_html_e( 'If you wish, you can change the author’s website address of the child theme', 'rr-atp-divi-child' ); ?></label>
                                    <input type="url" name="form_atp_author_url" id="form_atp_author_url" class="widefat" tabindex="3" placeholder="<?php echo esc_attr( $this->form_atp_author_url ); ?>" pattern="https?://.+" title="<?php _e('Must start by http:// or https://', 'rr-atp-divi-child'); ?>" value="<?php echo esc_attr( $this->form_atp_author_url ); ?>" />
                                </p>
                                <p>
                                    <label for="form_atp_version"><?php esc_html_e( 'Which version number do you want to assign to this child theme?', 'rr-atp-divi-child' ); ?></label>
                                    <input type="text" name="form_atp_version" id="form_atp_version" class="widefat" tabindex="4" placeholder="1.0" pattern="[0-9\.]{1,7}" title="<?php esc_attr_e('This field contains invalid or too much characters (7 max. [0-9 + dot(s)]).', 'rr-atp-divi-child'); ?>" value="<?php echo esc_attr( $this->form_atp_version ); ?>" />
                                </p>
                                <?php if ( $this->gd_loaded ) { ?>
                                <p class="label customize"><?php esc_html_e( 'Which color do you want to give to the image that will represent this child theme?', 'rr-atp-divi-child' ); ?></p>
                                <p class="atp-row">
                                    <span class="atp-block"><img src="<?php echo ATP_DC_IMAGE_URL . 'screenshot-apricot.jpg'; ?> " width="180" title="Apricot">
                                        <span class="atp-radio">
                                            <label for="color_r1">Apricot</label>
                                            <input type="radio" name="form_atp_color" value="apricot" <?php echo ($this->form_atp_color == "apricot") ? "checked": ""; ?> tabindex="5" id="color_r1">
                                        </span>
                                    </span>
                                    <span class="atp-block"><img src="<?php echo ATP_DC_IMAGE_URL . 'screenshot-brown.jpg'; ?> " width="180" title="Brown">
                                        <span class="atp-radio">
                                            <label for="color_r2">Brown</label>
                                            <input type="radio" name="form_atp_color" value="brown" <?php echo ($this->form_atp_color == "brown") ? "checked": ""; ?> tabindex="6" id="color_r2">
                                        </span>
                                    </span>
                                    <span class="atp-block"><img src="<?php echo ATP_DC_IMAGE_URL . 'screenshot-girly.jpg'; ?> " width="180" title="Girly">
                                        <span class="atp-radio">
                                            <label for="color_r3">Girly</label>
                                            <input type="radio" name="form_atp_color" value="girly" <?php echo ($this->form_atp_color == "girly") ? "checked": ""; ?> tabindex="7" id="color_r3">
                                        </span>
                                    </span>
                                    <span class="atp-block"><img src="<?php echo ATP_DC_IMAGE_URL . 'screenshot-lagoon.jpg'; ?> " width="180" title="Lagoon">
                                        <span class="atp-radio">
                                            <label for="color_r4">Lagoon</label>
                                            <input type="radio" name="form_atp_color" value="lagoon" <?php echo ($this->form_atp_color == "lagoon") ? "checked": ""; ?> tabindex="8" id="color_r4">
                                        </span>
                                    </span>
                                    <span class="atp-block"><img src="<?php echo ATP_DC_IMAGE_URL . 'screenshot-navy.jpg'; ?> " width="180" title="Navy">
                                        <span class="atp-radio">
                                            <label for="color_r5">Navy</label>
                                            <input type="radio" name="form_atp_color" value="navy" <?php echo ($this->form_atp_color == "navy") ? "checked": ""; ?> tabindex="9" id="color_r5">
                                        </span>
                                    </span>
                                </p>
                                <p>
                                <span class="atp-row">
                                    <span class="atp-block"><img src="<?php echo ATP_DC_IMAGE_URL . 'screenshot-serious.jpg'; ?> " width="180" title="Serious">
                                        <span class="atp-radio">
                                            <label for="color_r6">Serious</label>
                                            <input type="radio" name="form_atp_color" value="serious" <?php echo ($this->form_atp_color == "serious") ? "checked": ""; ?> tabindex="10" id="color_r6">
                                        </span>
                                    </span>
                                    <span class="atp-block"><img src="<?php echo ATP_DC_IMAGE_URL . 'screenshot-sienne.jpg'; ?> " width="180" title="Sienne">
                                        <span class="atp-radio">
                                            <label for="color_r7">Sienne</label>
                                            <input type="radio" name="form_atp_color" value="sienne" <?php echo ($this->form_atp_color == "sienne") ? "checked": ""; ?> tabindex="11" id="color_r7">
                                        </span>
                                    </span>
                                    <span class="atp-block"><img src="<?php echo ATP_DC_IMAGE_URL . 'screenshot-sky.jpg'; ?> " width="180" title="Sky">
                                        <span class="atp-radio">
                                            <label for="color_r8">Sky</label>
                                            <input type="radio" name="form_atp_color" value="sky" <?php echo ($this->form_atp_color == "sky") ? "checked": ""; ?> tabindex="12" id="color_r8">
                                        </span>
                                    </span>
                                    <span class="atp-block"><img src="<?php echo ATP_DC_IMAGE_URL . 'screenshot-sunny.jpg'; ?> " width="180" title="Sunny">
                                        <span class="atp-radio">
                                            <label for="color_r9">Sunny</label>
                                            <input type="radio" name="form_atp_color" value="sunny" <?php echo ($this->form_atp_color == "sunny") ? "checked": ""; ?> tabindex="13" id="color_r9">
                                        </span>
                                    </span>
                                    <span class="atp-block"><img src="<?php echo ATP_DC_IMAGE_URL . 'screenshot-turtledove.jpg'; ?> " width="180" title="Turtledove">
                                        <span class="atp-radio">
                                            <label for="color_r10">Turtledove</label>
                                            <input type="radio" name="form_atp_color" value="turtledove" <?php echo ($this->form_atp_color == "turtledove") ? "checked": ""; ?> tabindex="14" id="color_r10">
                                        </span>
                                    </span>
                                </span>
                                <?php } // end if gd_loaded ?>
                                </p>
								<?php wp_nonce_field( $this->plugin_name, $this->form_nonce ); ?>
                                <input type="hidden" name="action" value="create" />
                                <hr/>
                                <p class="rr-exerg">
									<input name="submit" type="submit" name="Submit" class="rr-button" value="<?php esc_attr_e( 'Create Divi Child Theme', 'rr-atp-divi-child' ); ?>" />
                                </p>
							</form>
						</div>
						<?php else : ?>
                        <div class="inside">
                            <p class="atp_warning">Divi n'est pas le thème actuellement activé.</p>
                            <p>Activez-le s'il est installé ou si vous ne l'avez pas encore installé, vous pouvez vous le procurer auprès d'<a href="https://www.adopte-ton-plugin.fr/theme-divi-elegant-themes/" title="Bénéficier de l’offre 'Divi Autonomie'" target="_blank">Adopte Ton Plugin</a> pour un prix avantageux :</p>
                            <h4>Thème Divi de Elegant Themes</h4>
                            <ul>
                                <li class="da-yes">Mises à jour automatiques pendant 1 an ;</li>
                                <li class="da-yes">Le thème Extra pour les bloggeurs ;</li>
                                <li class="da-yes">L'outil Bloom pour les newsletters ;</li>
                                <li class="da-yes">L'outil Monarch pour les réseaux sociaux ;</li>
                                <li class="da-yes">Le constructeur Divi pour bénéficier des fonctionnalités Divi sur ton propre thème.</li>
                            </ul>
                            <h4>Support</h4>
                            <ul>
                                <li class="da-yes">Accès au groupe d’entraide privé Facebook ;</li>
                                <li class="da-yes">Documentation en français</li>
                                <li class="da-plus-alt">Dépannage (en option)</li>
                            </ul>
                            <?php if ($this->is_divi_installed ) : ?>
                                <form action="themes.php?page=<?php echo esc_attr( $this->plugin_name ); ?>"&action="<?php echo $this->form_action; ?> " method="post">
	                                <?php wp_nonce_field( $this->plugin_name, $this->form_nonce ); ?>
                                    <input type="hidden" name="action" value="switch" />
                                    <p class="rr-exerg"><input name="submit" type="submit" name="Submit" class="rr-button" value="<?php esc_attr_e( 'Yes! I want to enable Divi to create my child theme.', 'rr-atp-divi-child' ); ?>" /></p>
                                </form>
                            <?php else : ?>
                                <p class="rr-exerg"><a class="rr-button" href="https://www.adopte-ton-plugin.fr/theme-divi-elegant-themes/" title="Bénéficier de l’offre 'Divi Autonomie'" target="_blank">Oui, je veux bénéficier de l’offre 'Divi Autonomie' de Adopte Ton Plugin !</a></p>
                            <?php endif; ?>
                        </div>
						<?php endif; ?>
                    </div>
					<!-- /postbox -->
				</div>
				<!-- /normal-sortables -->
			</div>
            <!-- /post-body-content -->
			<!-- Sidebar -->
			<div id="postbox-container-1" class="postbox-container">
				<?php require_once( ATP_DC_ABSPATH . '/admin/template-admin-sidebar.php' ); ?>
			</div>
			<!-- /postbox-container -->
		</div>
	</div>
    <div class="clear"></div>
</div>