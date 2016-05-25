<tr valign="top">
	<th scope="row" class="titledesc">
		<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
	</th>
	<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?> <?php echo sanitize_title( $value['type'] ) ?>">
		<div class="account-banner">
			<div class="account-avatar">
				<div class="account-thumb">
					<?php if( ! empty( $avatar ) ): ?>
					<img src="<?php echo $avatar ?>" alt="<?php echo $username; ?>" width="96" heigth="96" />
					<?php
						else:
							echo get_avatar( 0, 96 );
						endif;
					?>
				</div>
				<div class="account-name tips" data-tip="<?php echo ! empty( $username ) ? __( 'MailChimp user', 'yith-wcmc' ) : __( 'No user can be found with this API key', 'yith-wcmc' )?>">
					<?php echo ! empty( $username ) ? $username : __( '&lt; Not Found &gt;' ); ?>
				</div>
			</div>
			<div class="account-details">
				<p class="account-info">
					<span class="label"><b><?php _e( 'Status:', 'yith-wcmc' )?></b></span>

					<?php if( ! empty( $user_id ) ): ?>
						<mark class="completed tips" data-tip="<?php _e( 'Correctly synchronized', 'yith-wcmc' )?>"><?php _e( 'OK', 'yith-wcmc' )?></mark>
					<?php else: ?>
						<mark class="cancelled tips" data-tip="<?php _e( 'Wrong API key', 'yith-wcmc' )?>"><?php _e( 'KO', 'yith-wcmc' )?></mark>
					<?php endif; ?>
				</p>

				<p class="account-info">
					<span class="label"><b><?php _e( 'Name:', 'yith-wcmc' )?></b></span>

					<?php echo ! empty( $name ) ? $name : __( '&lt; Not Found &gt;', 'yith-wcmc' ) ?>
				</p>

				<p class="account-info">
					<span class="label"><b><?php _e( 'Email:', 'yith-wcmc' )?></b></span>

					<?php echo ! empty( $email ) ? $email : __( '&lt; Not Found &gt;', 'yith-wcmc' ) ?>
				</p>
			</div>
		</div>
	</td>
</tr>