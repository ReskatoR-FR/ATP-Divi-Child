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
						<h3 class="hndle"><span class="dashicons dashicons-admin-settings"></span><?php esc_html_e( 'Result', 'rr-atp-divi-child' ); ?></h3>
						<div class="inside">
                            <?php if( empty( $this->rr_msg['error'] ) ) { ?>
                            <p>Page de réussite => Profiter de l'affichage de cette page pour du marketing…<br/><br/></p>
                            <h4><span class="dashicons dashicons-awards"></span><?php _e('Congratulations!', 'rr-atp-divi-child'); ?></h4>
                            <p><?php _e( 'Your child theme has been created.', 'rr-atp-divi-child' ); ?></p>
                            <p><?php _e( 'Click the button below to access the Themes Gallery to activate your child theme.', 'rr-atp-divi-child' ); ?></p>
                            <form action="themes.php?page=<?php echo esc_attr( $this->plugin_name ); ?>"&action="<?php echo $this->form_action; ?>" method="post">
                                <?php wp_nonce_field( $this->plugin_name, $this->form_nonce ); ?>
                                <input type="hidden" name="child" value="<?php echo $this->form_atp_name; ?>" />
                                <input type="hidden" name="action" value="activate" />
                                <p class="rr-exerg"><input name="submit" type="submit" name="Submit" class="rr-button" value="<?php esc_attr_e( 'Yes! Take me to the themes gallery.', 'rr-atp-divi-child' ); ?>" /></p>
                            </form>
                            <?php } else { ?>
                            <p class="atp_warning"><?php printf( __( 'An error occurred while creating “%s” child theme.', 'rr-atp-divi-child' ), $this->form_atp_name ); ?></p>
                            <h4><?php _e( 'Possible causes are:', 'rr-atp-divi-child'); ?></h4>
                            <ul>
                                <li><?php printf( __( 'The child theme’s folder already exists.%1$sSolution:%2$s Give your child theme a different name.', 'rr-atp-divi-child' ), '<br/><span class="solution">', '</span>'); ?></li>
                                <li><?php printf( __( 'An authorization problem of writing on the web server disk.%1$sSolution:%2$s contact your host’s support.', 'rr-atp-divi-child' ), '<br/><span class="solution">', '</span>'); ?></li>
                            </ul>
                            <p><?php _e( 'If you want to try with another child theme name, click button below.', 'rr-atp-divi-child') ?></p>
                            <form action="themes.php?page=<?php echo esc_attr( $this->plugin_name ); ?>"&action="<?php echo $this->form_action; ?>" method="post">
                                <?php wp_nonce_field( $this->plugin_name, $this->form_nonce ); ?>
                                <input type="hidden" name="action" value="" />
                                <p class="rr-exerg"><input name="submit" type="submit" name="Submit" class="rr-button" value="<?php esc_attr_e( 'Yes! I will try giving another name to my child theme.', 'rr-atp-divi-child' ); ?>" /></p>
                            </form>

                            <?php } ?>
                        </div>
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
            <!-- /Sidebar -->
        </div>
    </div>
    <div class="clear"></div>
</div>