<?php defined( 'ABSPATH' ) || exit;
/**
 * Dismissible Notices template
 */
?>
<div class="notice notice-success is-dismissible <?php echo $this->plugin_name; ?>-notice-welcome">
	<p><?php printf( __( 'Thank you for installing <strong>%1$s</strong>! <a href="%2$s">Click here</a> to configure your child theme.', 'rr-atp-divi-child' ), $this->plugin_display_name, $this->plugin_page ); ?></p>
</div>
<script type="text/javascript">
    jQuery(document).ready( function($) {
        $(document).on( 'click', '.<?php echo $this->plugin_name; ?>-notice-welcome button.notice-dismiss', function( event ) {
            event.preventDefault();
            $.post( ajaxurl, {
                action: '<?php echo $this->plugin_name . '_dismiss-dashboard-notice'; ?>',
                nonce: '<?php echo wp_create_nonce( $this->plugin_name . '-nonce' ); ?>'
            });
            $('.<?php echo $this->plugin_name; ?>-notice-welcome').remove();
        });
    });
</script>
