<?php

// Exit if accessed directly
! defined( 'YITH_WCBM' )  && exit();

return array(
	'premium' => array(
		'landing' => array(
			'type' => 'custom_tab',
			'action' => 'yith_wcbm_premium_tab',
			'hide_sidebar' => true,
		)
	)
);