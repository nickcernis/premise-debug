<?php
/**
 * Display the main settings page.
 *
 * @package   HeartThis\Admin\Views
 * @copyright Copyright (c) 2016, Rainmaker Digital LLC
 * @license   MIT
 * @since     0.1.0
 */
?>
<?php do_action( 'premise_debug_before_admin_form' ); ?>

<div class="wrap">
	<h2><?php esc_html_e( 'Premise Connection Test', 'premise-debug' ); ?></h2>
	<form action="<?php echo admin_url( 'admin.php?page=premise-debug' ); ?>" method="post">
		<input type="hidden" name="action" value="premise_connect_test"/>
		<?php wp_nonce_field( "premise-debug-options" ); ?>
		<?php do_settings_sections( 'premise-debug' ); ?>
		<?php submit_button( __( 'Check connection', 'premise-debug' ) ); ?>
	</form>

</div>

<?php do_action( 'premise_debug_after_admin_form' ); ?>
