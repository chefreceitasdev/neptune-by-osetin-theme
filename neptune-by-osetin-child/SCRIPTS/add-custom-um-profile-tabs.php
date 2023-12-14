<?php 

/**
 * This example shows how to add a new tab into the Profile page of the Ultimate Member. 
 * See the article https://docs.ultimatemember.com/article/69-how-do-i-add-my-extra-tabs-to-user-profiles
 *
 * This example adds the tab 'reviewstab' that contains the field 'description'. You can add your own tabs and fields.
 * Important! Each profile tab has an unique key. Replace 'reviewstab' to your unique key.
 *
 * You can add this code to the end of the file functions.php in the active theme (child theme) directory.
 * 
 * Ultimate Member documentation: https://docs.ultimatemember.com/
 * Ultimate Member support (for customers): https://ultimatemember.com/support/ticket/
 */
 
/**
 * Add a new Profile tab
 *
 * @param array $tabs
 * @return array
 */
function um_reviewstab_add_tab( $tabs ) {

	$tabs[ 'reviewstab' ] = array(
		'name'   => 'Reviews',
		'icon'   => 'um-faicon-pencil',
		'custom' => true
	);

	UM()->options()->options[ 'profile_tab_' . 'reviewstab' ] = true;

	return $tabs;
}
add_filter( 'um_profile_tabs', 'um_reviewstab_add_tab', 1000 );

/**
 * Render tab content
 *
 * @param array $args
 */
function um_profile_content_reviewstab_default( $args ) {
	/* START. You can paste your content here, it's just an example. */
	
	$action = 'reviewstab';
	
	/* List user fields you want to see in this form. */
	$fields_metakey = array(
		'description'
	);

	$nonce = filter_input( INPUT_POST, '_wpnonce' );
	if( $nonce && wp_verify_nonce( $nonce, $action ) && um_is_myprofile() ) {
		foreach( $fields_metakey as $metakey ) {
			update_user_meta( um_profile_id(), $metakey, filter_input( INPUT_POST, $metakey ) );
		}
		UM()->user()->remove_cache( um_profile_id() );
	}

	$fields = UM()->builtin()->get_specific_fields( implode( ',', $fields_metakey ) );
	?>

	<div class="um">
		<div class="um-form">
			<form method="post">

				<?php
				if( um_is_myprofile() ) {
					foreach( $fields as $key => $data ) {
						echo UM()->fields()->edit_field( $key, $data );
					}
				} else {
					foreach( $fields as $key => $data ) {
						echo UM()->fields()->view_field( $key, $data );
					}
				}
				?>

				<?php if( um_is_myprofile() ) : ?>
					<div class="um-col-alt">
						<div class="um-left">
							<?php wp_nonce_field( $action ); ?>
							<input type="submit" value="<?php esc_attr_e( 'Update', 'ultimate-member' ); ?>" class="um-button" />
						</div>
					</div>
				<?php endif; ?>

			</form>
		</div>
	</div>

	<?php
	/* END. You can paste your content here, it's just an example. */
}
add_action( 'um_profile_content_reviewstab_default', 'um_profile_content_reviewstab_default' );