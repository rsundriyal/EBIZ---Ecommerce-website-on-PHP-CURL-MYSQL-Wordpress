<?php
/*-----------------------------------------------------------------------------------*/
/*	Default Options
/*-----------------------------------------------------------------------------------*/

//menus
function magee_shortcode_menus($name){
    $menus[''] = 'Default';
    if( $name !== ''){
	
	$menu = wp_get_nav_menus();
	    
		foreach ( $menu as $val){
		if(isset($val->name)){
			$menus[$val->name] = $val->name;
			}
		}	
		if(isset( $menus)){	
		return $menus;	
		}
    }

}


global $magee_shortcodes,$magee_sliders,$magee_widget;
$magee_sliders = Magee_Core::sliders_meta(); 

$choices = array( 'yes' => 'Yes', 'no' => 'No' );
$reverse_choices = array( 'no' => 'No', 'yes' => 'Yes' );
$choices_with_default = array( '' => 'Default', 'yes' => 'Yes', 'no' => 'No' );
$reverse_choices_with_default = array( '' => 'Default', 'no' => 'No', 'yes' => 'Yes' );
$leftright = array( 'left' => 'Left', 'right' => 'Right' );
$textalign = array( 'left' => __( 'Left', 'magee-shortcodes' ), 'center' => __( 'Center', 'magee-shortcodes' ), 'right' => __( 'Right', 'magee-shortcodes' ) );
$opacity = array('0' => '0', '0.1' => '0.1', '0.2' => '0.2', '0.3' => '0.3', '0.4' => '0.4', '0.5' => '0.5', '0.6' => '0.6', '0.7' => '0.7', '0.8' => '0.8', '0.9' => '0.9', '1' => '1');
$dec_numbers = array( '0.1' => '0.1', '0.2' => '0.2', '0.3' => '0.3', '0.4' => '0.4', '0.5' => '0.5', '0.6' => '0.6', '0.7' => '0.7', '0.8' => '0.8', '0.9' => '0.9', '1' => '1', '2' => '2', '2.5' => '2.5', '3' => '3' );
$animation_type = array('' => 'None',"bounce" => "bounce", "flash" => "flash", "pulse" => "pulse", "rubberBand" => "rubberBand", "shake" => "shake", "swing" => "swing", "tada" => "tada", "wobble" => "wobble", "bounceIn" => "bounceIn", "bounceInDown" => "bounceInDown", "bounceInLeft" => "bounceInLeft", "bounceInRight" => "bounceInRight", "bounceInUp" => "bounceInUp", "bounceOut" => "bounceOut", "bounceOutDown" => "bounceOutDown", "bounceOutLeft" => "bounceOutLeft", "bounceOutRight" => "bounceOutRight", "bounceOutUp" => "bounceOutUp", "fadeIn" => "fadeIn", "fadeInDown" => "fadeInDown", "fadeInDownBig" => "fadeInDownBig", "fadeInLeft" => "fadeInLeft", "fadeInLeftBig" => "fadeInLeftBig", "fadeInRight" => "fadeInRight", "fadeInRightBig" => "fadeInRightBig", "fadeInUp" => "fadeInUp", "fadeInUpBig" => "fadeInUpBig", "fadeOut" => "fadeOut", "fadeOutDown" => "fadeOutDown", "fadeOutDownBig" => "fadeOutDownBig", "fadeOutLeft" => "fadeOutLeft", "fadeOutLeftBig" => "fadeOutLeftBig", "fadeOutRight" => "fadeOutRight", "fadeOutRightBig" => "fadeOutRightBig", "fadeOutUp" => "fadeOutUp", "fadeOutUpBig" => "fadeOutUpBig", "flip" => "flip", "flipInX" => "flipInX", "flipInY" => "flipInY", "flipOutX" => "flipOutX", "flipOutY" => "flipOutY", "lightSpeedIn" => "lightSpeedIn", "lightSpeedOut" => "lightSpeedOut", "rotateIn" => "rotateIn", "rotateInDownLeft" => "rotateInDownLeft", "rotateInDownRight" => "rotateInDownRight", "rotateInUpLeft" => "rotateInUpLeft", "rotateInUpRight" => "rotateInUpRight", "rotateOut" => "rotateOut", "rotateOutDownLeft" => "rotateOutDownLeft", "rotateOutDownRight" => "rotateOutDownRight", "rotateOutUpLeft" => "rotateOutUpLeft", "rotateOutUpRight" => "rotateOutUpRight", "hinge" => "hinge", "rollIn" => "rollIn", "rollOut" => "rollOut", "zoomIn" => "zoomIn", "zoomInDown" => "zoomInDown", "zoomInLeft" => "zoomInLeft", "zoomInRight" => "zoomInRight", "zoomInUp" => "zoomInUp", "zoomOut" => "zoomOut", "zoomOutDown" => "zoomOutDown", "zoomOutLeft" => "zoomOutLeft", "zoomOutRight" => "zoomOutRight", "zoomOutUp" => "zoomOutUp", "slideInDown" => "slideInDown", "slideInLeft" => "slideInLeft", "slideInRight" => "slideInRight", "slideInUp" => "slideInUp", "slideOutDown" => "slideOutDown", "slideOutLeft" => "slideOutLeft", "slideOutRight" => "slideOutRight", "slideOutUp" => "slideOutUp");
$columns  = array(""=>"default","1"=>"1/12","2"=>"2/12","3"=>"3/12","4"=>"4/12","5"=>"5/12","6"=>"6/12","7"=>"7/12","8"=>"8/12","9"=>"9/12","10"=>"10/12","11"=>"11/12","12"=>"12/12");
// Fontawesome icons list

$icons = array('fa-glass'=>'\f000', 'fa-music'=>'\f001', 'fa-search'=>'\f002', 'fa-envelope-o'=>'\f003', 'fa-heart'=>'\f004', 'fa-star'=>'\f005', 'fa-star-o'=>'\f006', 'fa-user'=>'\f007', 'fa-film'=>'\f008', 'fa-th-large'=>'\f009', 'fa-th'=>'\f00a', 'fa-th-list'=>'\f00b', 'fa-check'=>'\f00c', 'fa-times'=>'\f00d', 'fa-search-plus'=>'\f00e', 'fa-search-minus'=>'\f010', 'fa-power-off'=>'\f011', 'fa-signal'=>'\f012', 'fa-cog'=>'\f013', 'fa-trash-o'=>'\f014', 'fa-home'=>'\f015', 'fa-file-o'=>'\f016', 'fa-clock-o'=>'\f017', 'fa-road'=>'\f018', 'fa-download'=>'\f019', 'fa-arrow-circle-o-down'=>'\f01a', 'fa-arrow-circle-o-up'=>'\f01b', 'fa-inbox'=>'\f01c', 'fa-play-circle-o'=>'\f01d', 'fa-repeat'=>'\f01e', 'fa-refresh'=>'\f021', 'fa-list-alt'=>'\f022', 'fa-lock'=>'\f023', 'fa-flag'=>'\f024', 'fa-headphones'=>'\f025', 'fa-volume-off'=>'\f026', 'fa-volume-down'=>'\f027', 'fa-volume-up'=>'\f028', 'fa-qrcode'=>'\f029', 'fa-barcode'=>'\f02a', 'fa-tag'=>'\f02b', 'fa-tags'=>'\f02c', 'fa-book'=>'\f02d', 'fa-bookmark'=>'\f02e', 'fa-print'=>'\f02f', 'fa-camera'=>'\f030', 'fa-font'=>'\f031', 'fa-bold'=>'\f032', 'fa-italic'=>'\f033', 'fa-text-height'=>'\f034', 'fa-text-width'=>'\f035', 'fa-align-left'=>'\f036', 'fa-align-center'=>'\f037', 'fa-align-right'=>'\f038', 'fa-align-justify'=>'\f039', 'fa-list'=>'\f03a', 'fa-outdent'=>'\f03b', 'fa-indent'=>'\f03c', 'fa-video-camera'=>'\f03d', 'fa-picture-o'=>'\f03e', 'fa-pencil'=>'\f040', 'fa-map-marker'=>'\f041', 'fa-adjust'=>'\f042', 'fa-tint'=>'\f043', 'fa-pencil-square-o'=>'\f044', 'fa-share-square-o'=>'\f045', 'fa-check-square-o'=>'\f046', 'fa-arrows'=>'\f047', 'fa-step-backward'=>'\f048', 'fa-fast-backward'=>'\f049', 'fa-backward'=>'\f04a', 'fa-play'=>'\f04b', 'fa-pause'=>'\f04c', 'fa-stop'=>'\f04d', 'fa-forward'=>'\f04e', 'fa-fast-forward'=>'\f050', 'fa-step-forward'=>'\f051', 'fa-eject'=>'\f052', 'fa-chevron-left'=>'\f053', 'fa-chevron-right'=>'\f054', 'fa-plus-circle'=>'\f055', 'fa-minus-circle'=>'\f056', 'fa-times-circle'=>'\f057', 'fa-check-circle'=>'\f058', 'fa-question-circle'=>'\f059', 'fa-info-circle'=>'\f05a', 'fa-crosshairs'=>'\f05b', 'fa-times-circle-o'=>'\f05c', 'fa-check-circle-o'=>'\f05d', 'fa-ban'=>'\f05e', 'fa-arrow-left'=>'\f060', 'fa-arrow-right'=>'\f061', 'fa-arrow-up'=>'\f062', 'fa-arrow-down'=>'\f063', 'fa-share'=>'\f064', 'fa-expand'=>'\f065', 'fa-compress'=>'\f066', 'fa-plus'=>'\f067', 'fa-minus'=>'\f068', 'fa-asterisk'=>'\f069', 'fa-exclamation-circle'=>'\f06a', 'fa-gift'=>'\f06b', 'fa-leaf'=>'\f06c', 'fa-fire'=>'\f06d', 'fa-eye'=>'\f06e', 'fa-eye-slash'=>'\f070', 'fa-exclamation-triangle'=>'\f071', 'fa-plane'=>'\f072', 'fa-calendar'=>'\f073', 'fa-random'=>'\f074', 'fa-comment'=>'\f075', 'fa-magnet'=>'\f076', 'fa-chevron-up'=>'\f077', 'fa-chevron-down'=>'\f078', 'fa-retweet'=>'\f079', 'fa-shopping-cart'=>'\f07a', 'fa-folder'=>'\f07b', 'fa-folder-open'=>'\f07c', 'fa-arrows-v'=>'\f07d', 'fa-arrows-h'=>'\f07e', 'fa-bar-chart'=>'\f080', 'fa-twitter-square'=>'\f081', 'fa-facebook-square'=>'\f082', 'fa-camera-retro'=>'\f083', 'fa-key'=>'\f084', 'fa-cogs'=>'\f085', 'fa-comments'=>'\f086', 'fa-thumbs-o-up'=>'\f087', 'fa-thumbs-o-down'=>'\f088', 'fa-star-half'=>'\f089', 'fa-heart-o'=>'\f08a', 'fa-sign-out'=>'\f08b', 'fa-linkedin-square'=>'\f08c', 'fa-thumb-tack'=>'\f08d', 'fa-external-link'=>'\f08e', 'fa-sign-in'=>'\f090', 'fa-trophy'=>'\f091', 'fa-github-square'=>'\f092', 'fa-upload'=>'\f093', 'fa-lemon-o'=>'\f094', 'fa-phone'=>'\f095', 'fa-square-o'=>'\f096', 'fa-bookmark-o'=>'\f097', 'fa-phone-square'=>'\f098', 'fa-twitter'=>'\f099', 'fa-facebook'=>'\f09a', 'fa-github'=>'\f09b', 'fa-unlock'=>'\f09c', 'fa-credit-card'=>'\f09d', 'fa-rss'=>'\f09e', 'fa-hdd-o'=>'\f0a0', 'fa-bullhorn'=>'\f0a1', 'fa-bell'=>'\f0f3', 'fa-certificate'=>'\f0a3', 'fa-hand-o-right'=>'\f0a4', 'fa-hand-o-left'=>'\f0a5', 'fa-hand-o-up'=>'\f0a6', 'fa-hand-o-down'=>'\f0a7', 'fa-arrow-circle-left'=>'\f0a8', 'fa-arrow-circle-right'=>'\f0a9', 'fa-arrow-circle-up'=>'\f0aa', 'fa-arrow-circle-down'=>'\f0ab', 'fa-globe'=>'\f0ac', 'fa-wrench'=>'\f0ad', 'fa-tasks'=>'\f0ae', 'fa-filter'=>'\f0b0', 'fa-briefcase'=>'\f0b1', 'fa-arrows-alt'=>'\f0b2', 'fa-users'=>'\f0c0', 'fa-link'=>'\f0c1', 'fa-cloud'=>'\f0c2', 'fa-flask'=>'\f0c3', 'fa-scissors'=>'\f0c4', 'fa-files-o'=>'\f0c5', 'fa-paperclip'=>'\f0c6', 'fa-floppy-o'=>'\f0c7', 'fa-square'=>'\f0c8', 'fa-bars'=>'\f0c9', 'fa-list-ul'=>'\f0ca', 'fa-list-ol'=>'\f0cb', 'fa-strikethrough'=>'\f0cc', 'fa-underline'=>'\f0cd', 'fa-table'=>'\f0ce', 'fa-magic'=>'\f0d0', 'fa-truck'=>'\f0d1', 'fa-pinterest'=>'\f0d2', 'fa-pinterest-square'=>'\f0d3', 'fa-google-plus-square'=>'\f0d4', 'fa-google-plus'=>'\f0d5', 'fa-money'=>'\f0d6', 'fa-caret-down'=>'\f0d7', 'fa-caret-up'=>'\f0d8', 'fa-caret-left'=>'\f0d9', 'fa-caret-right'=>'\f0da', 'fa-columns'=>'\f0db', 'fa-sort'=>'\f0dc', 'fa-sort-desc'=>'\f0dd', 'fa-sort-asc'=>'\f0de', 'fa-envelope'=>'\f0e0', 'fa-linkedin'=>'\f0e1', 'fa-undo'=>'\f0e2', 'fa-gavel'=>'\f0e3', 'fa-tachometer'=>'\f0e4', 'fa-comment-o'=>'\f0e5', 'fa-comments-o'=>'\f0e6', 'fa-bolt'=>'\f0e7', 'fa-sitemap'=>'\f0e8', 'fa-umbrella'=>'\f0e9', 'fa-clipboard'=>'\f0ea', 'fa-lightbulb-o'=>'\f0eb', 'fa-exchange'=>'\f0ec', 'fa-cloud-download'=>'\f0ed', 'fa-cloud-upload'=>'\f0ee', 'fa-user-md'=>'\f0f0', 'fa-stethoscope'=>'\f0f1', 'fa-suitcase'=>'\f0f2', 'fa-bell-o'=>'\f0a2', 'fa-coffee'=>'\f0f4', 'fa-cutlery'=>'\f0f5', 'fa-file-text-o'=>'\f0f6', 'fa-building-o'=>'\f0f7', 'fa-hospital-o'=>'\f0f8', 'fa-ambulance'=>'\f0f9', 'fa-medkit'=>'\f0fa', 'fa-fighter-jet'=>'\f0fb', 'fa-beer'=>'\f0fc', 'fa-h-square'=>'\f0fd', 'fa-plus-square'=>'\f0fe', 'fa-angle-double-left'=>'\f100', 'fa-angle-double-right'=>'\f101', 'fa-angle-double-up'=>'\f102', 'fa-angle-double-down'=>'\f103', 'fa-angle-left'=>'\f104', 'fa-angle-right'=>'\f105', 'fa-angle-up'=>'\f106', 'fa-angle-down'=>'\f107', 'fa-desktop'=>'\f108', 'fa-laptop'=>'\f109', 'fa-tablet'=>'\f10a', 'fa-mobile'=>'\f10b', 'fa-circle-o'=>'\f10c', 'fa-quote-left'=>'\f10d', 'fa-quote-right'=>'\f10e', 'fa-spinner'=>'\f110', 'fa-circle'=>'\f111', 'fa-reply'=>'\f112', 'fa-github-alt'=>'\f113', 'fa-folder-o'=>'\f114', 'fa-folder-open-o'=>'\f115', 'fa-smile-o'=>'\f118', 'fa-frown-o'=>'\f119', 'fa-meh-o'=>'\f11a', 'fa-gamepad'=>'\f11b', 'fa-keyboard-o'=>'\f11c', 'fa-flag-o'=>'\f11d', 'fa-flag-checkered'=>'\f11e', 'fa-terminal'=>'\f120', 'fa-code'=>'\f121', 'fa-reply-all'=>'\f122', 'fa-star-half-o'=>'\f123', 'fa-location-arrow'=>'\f124', 'fa-crop'=>'\f125', 'fa-code-fork'=>'\f126', 'fa-chain-broken'=>'\f127', 'fa-question'=>'\f128', 'fa-info'=>'\f129', 'fa-exclamation'=>'\f12a', 'fa-superscript'=>'\f12b', 'fa-subscript'=>'\f12c', 'fa-eraser'=>'\f12d', 'fa-puzzle-piece'=>'\f12e', 'fa-microphone'=>'\f130', 'fa-microphone-slash'=>'\f131', 'fa-shield'=>'\f132', 'fa-calendar-o'=>'\f133', 'fa-fire-extinguisher'=>'\f134', 'fa-rocket'=>'\f135', 'fa-maxcdn'=>'\f136', 'fa-chevron-circle-left'=>'\f137', 'fa-chevron-circle-right'=>'\f138', 'fa-chevron-circle-up'=>'\f139', 'fa-chevron-circle-down'=>'\f13a', 'fa-html5'=>'\f13b', 'fa-css3'=>'\f13c', 'fa-anchor'=>'\f13d', 'fa-unlock-alt'=>'\f13e', 'fa-bullseye'=>'\f140', 'fa-ellipsis-h'=>'\f141', 'fa-ellipsis-v'=>'\f142', 'fa-rss-square'=>'\f143', 'fa-play-circle'=>'\f144', 'fa-ticket'=>'\f145', 'fa-minus-square'=>'\f146', 'fa-minus-square-o'=>'\f147', 'fa-level-up'=>'\f148', 'fa-level-down'=>'\f149', 'fa-check-square'=>'\f14a', 'fa-pencil-square'=>'\f14b', 'fa-external-link-square'=>'\f14c', 'fa-share-square'=>'\f14d', 'fa-compass'=>'\f14e', 'fa-caret-square-o-down'=>'\f150', 'fa-caret-square-o-up'=>'\f151', 'fa-caret-square-o-right'=>'\f152', 'fa-eur'=>'\f153', 'fa-gbp'=>'\f154', 'fa-usd'=>'\f155', 'fa-inr'=>'\f156', 'fa-jpy'=>'\f157', 'fa-rub'=>'\f158', 'fa-krw'=>'\f159', 'fa-btc'=>'\f15a', 'fa-file'=>'\f15b', 'fa-file-text'=>'\f15c', 'fa-sort-alpha-asc'=>'\f15d', 'fa-sort-alpha-desc'=>'\f15e', 'fa-sort-amount-asc'=>'\f160', 'fa-sort-amount-desc'=>'\f161', 'fa-sort-numeric-asc'=>'\f162', 'fa-sort-numeric-desc'=>'\f163', 'fa-thumbs-up'=>'\f164', 'fa-thumbs-down'=>'\f165', 'fa-youtube-square'=>'\f166', 'fa-youtube'=>'\f167', 'fa-xing'=>'\f168', 'fa-xing-square'=>'\f169', 'fa-youtube-play'=>'\f16a', 'fa-dropbox'=>'\f16b', 'fa-stack-overflow'=>'\f16c', 'fa-instagram'=>'\f16d', 'fa-flickr'=>'\f16e', 'fa-adn'=>'\f170', 'fa-bitbucket'=>'\f171', 'fa-bitbucket-square'=>'\f172', 'fa-tumblr'=>'\f173', 'fa-tumblr-square'=>'\f174', 'fa-long-arrow-down'=>'\f175', 'fa-long-arrow-up'=>'\f176', 'fa-long-arrow-left'=>'\f177', 'fa-long-arrow-right'=>'\f178', 'fa-apple'=>'\f179', 'fa-windows'=>'\f17a', 'fa-android'=>'\f17b', 'fa-linux'=>'\f17c', 'fa-dribbble'=>'\f17d', 'fa-skype'=>'\f17e', 'fa-foursquare'=>'\f180', 'fa-trello'=>'\f181', 'fa-female'=>'\f182', 'fa-male'=>'\f183', 'fa-gratipay'=>'\f184', 'fa-sun-o'=>'\f185', 'fa-moon-o'=>'\f186', 'fa-archive'=>'\f187', 'fa-bug'=>'\f188', 'fa-vk'=>'\f189', 'fa-weibo'=>'\f18a', 'fa-renren'=>'\f18b', 'fa-pagelines'=>'\f18c', 'fa-stack-exchange'=>'\f18d', 'fa-arrow-circle-o-right'=>'\f18e', 'fa-arrow-circle-o-left'=>'\f190', 'fa-caret-square-o-left'=>'\f191', 'fa-dot-circle-o'=>'\f192', 'fa-wheelchair'=>'\f193', 'fa-vimeo-square'=>'\f194', 'fa-try'=>'\f195', 'fa-plus-square-o'=>'\f196', 'fa-space-shuttle'=>'\f197', 'fa-slack'=>'\f198', 'fa-envelope-square'=>'\f199', 'fa-wordpress'=>'\f19a', 'fa-openid'=>'\f19b', 'fa-university'=>'\f19c', 'fa-graduation-cap'=>'\f19d', 'fa-yahoo'=>'\f19e', 'fa-google'=>'\f1a0', 'fa-reddit'=>'\f1a1', 'fa-reddit-square'=>'\f1a2', 'fa-stumbleupon-circle'=>'\f1a3', 'fa-stumbleupon'=>'\f1a4', 'fa-delicious'=>'\f1a5', 'fa-digg'=>'\f1a6', 'fa-pied-piper'=>'\f1a7', 'fa-pied-piper-alt'=>'\f1a8', 'fa-drupal'=>'\f1a9', 'fa-joomla'=>'\f1aa', 'fa-language'=>'\f1ab', 'fa-fax'=>'\f1ac', 'fa-building'=>'\f1ad', 'fa-child'=>'\f1ae', 'fa-paw'=>'\f1b0', 'fa-spoon'=>'\f1b1', 'fa-cube'=>'\f1b2', 'fa-cubes'=>'\f1b3', 'fa-behance'=>'\f1b4', 'fa-behance-square'=>'\f1b5', 'fa-steam'=>'\f1b6', 'fa-steam-square'=>'\f1b7', 'fa-recycle'=>'\f1b8', 'fa-car'=>'\f1b9', 'fa-taxi'=>'\f1ba', 'fa-tree'=>'\f1bb', 'fa-spotify'=>'\f1bc', 'fa-deviantart'=>'\f1bd', 'fa-soundcloud'=>'\f1be', 'fa-database'=>'\f1c0', 'fa-file-pdf-o'=>'\f1c1', 'fa-file-word-o'=>'\f1c2', 'fa-file-excel-o'=>'\f1c3', 'fa-file-powerpoint-o'=>'\f1c4', 'fa-file-image-o'=>'\f1c5', 'fa-file-archive-o'=>'\f1c6', 'fa-file-audio-o'=>'\f1c7', 'fa-file-video-o'=>'\f1c8', 'fa-file-code-o'=>'\f1c9', 'fa-vine'=>'\f1ca', 'fa-codepen'=>'\f1cb', 'fa-jsfiddle'=>'\f1cc', 'fa-life-ring'=>'\f1cd', 'fa-circle-o-notch'=>'\f1ce', 'fa-rebel'=>'\f1d0', 'fa-empire'=>'\f1d1', 'fa-git-square'=>'\f1d2', 'fa-git'=>'\f1d3', 'fa-hacker-news'=>'\f1d4', 'fa-tencent-weibo'=>'\f1d5', 'fa-qq'=>'\f1d6', 'fa-weixin'=>'\f1d7', 'fa-paper-plane'=>'\f1d8', 'fa-paper-plane-o'=>'\f1d9', 'fa-history'=>'\f1da', 'fa-circle-thin'=>'\f1db', 'fa-header'=>'\f1dc', 'fa-paragraph'=>'\f1dd', 'fa-sliders'=>'\f1de', 'fa-share-alt'=>'\f1e0', 'fa-share-alt-square'=>'\f1e1', 'fa-bomb'=>'\f1e2', 'fa-futbol-o'=>'\f1e3', 'fa-tty'=>'\f1e4', 'fa-binoculars'=>'\f1e5', 'fa-plug'=>'\f1e6', 'fa-slideshare'=>'\f1e7', 'fa-twitch'=>'\f1e8', 'fa-yelp'=>'\f1e9', 'fa-newspaper-o'=>'\f1ea', 'fa-wifi'=>'\f1eb', 'fa-calculator'=>'\f1ec', 'fa-paypal'=>'\f1ed', 'fa-google-wallet'=>'\f1ee', 'fa-cc-visa'=>'\f1f0', 'fa-cc-mastercard'=>'\f1f1', 'fa-cc-discover'=>'\f1f2', 'fa-cc-amex'=>'\f1f3', 'fa-cc-paypal'=>'\f1f4', 'fa-cc-stripe'=>'\f1f5', 'fa-bell-slash'=>'\f1f6', 'fa-bell-slash-o'=>'\f1f7', 'fa-trash'=>'\f1f8', 'fa-copyright'=>'\f1f9', 'fa-at'=>'\f1fa', 'fa-eyedropper'=>'\f1fb', 'fa-paint-brush'=>'\f1fc', 'fa-birthday-cake'=>'\f1fd', 'fa-area-chart'=>'\f1fe', 'fa-pie-chart'=>'\f200', 'fa-line-chart'=>'\f201', 'fa-lastfm'=>'\f202', 'fa-lastfm-square'=>'\f203', 'fa-toggle-off'=>'\f204', 'fa-toggle-on'=>'\f205', 'fa-bicycle'=>'\f206', 'fa-bus'=>'\f207', 'fa-ioxhost'=>'\f208', 'fa-angellist'=>'\f209', 'fa-cc'=>'\f20a', 'fa-ils'=>'\f20b', 'fa-meanpath'=>'\f20c', 'fa-buysellads'=>'\f20d', 'fa-connectdevelop'=>'\f20e', 'fa-dashcube'=>'\f210', 'fa-forumbee'=>'\f211', 'fa-leanpub'=>'\f212', 'fa-sellsy'=>'\f213', 'fa-shirtsinbulk'=>'\f214', 'fa-simplybuilt'=>'\f215', 'fa-skyatlas'=>'\f216', 'fa-cart-plus'=>'\f217', 'fa-cart-arrow-down'=>'\f218', 'fa-diamond'=>'\f219', 'fa-ship'=>'\f21a', 'fa-user-secret'=>'\f21b', 'fa-motorcycle'=>'\f21c', 'fa-street-view'=>'\f21d', 'fa-heartbeat'=>'\f21e', 'fa-venus'=>'\f221', 'fa-mars'=>'\f222', 'fa-mercury'=>'\f223', 'fa-transgender'=>'\f224', 'fa-transgender-alt'=>'\f225', 'fa-venus-double'=>'\f226', 'fa-mars-double'=>'\f227', 'fa-venus-mars'=>'\f228', 'fa-mars-stroke'=>'\f229', 'fa-mars-stroke-v'=>'\f22a', 'fa-mars-stroke-h'=>'\f22b', 'fa-neuter'=>'\f22c', 'fa-genderless'=>'\f22d', 'fa-facebook-official'=>'\f230', 'fa-pinterest-p'=>'\f231', 'fa-whatsapp'=>'\f232', 'fa-server'=>'\f233', 'fa-user-plus'=>'\f234', 'fa-user-times'=>'\f235', 'fa-bed'=>'\f236', 'fa-viacoin'=>'\f237', 'fa-train'=>'\f238', 'fa-subway'=>'\f239', 'fa-medium'=>'\f23a', 'fa-y-combinator'=>'\f23b', 'fa-optin-monster'=>'\f23c', 'fa-opencart'=>'\f23d', 'fa-expeditedssl'=>'\f23e', 'fa-battery-full'=>'\f240', 'fa-battery-three-quarters'=>'\f241', 'fa-battery-half'=>'\f242', 'fa-battery-quarter'=>'\f243', 'fa-battery-empty'=>'\f244', 'fa-mouse-pointer'=>'\f245', 'fa-i-cursor'=>'\f246', 'fa-object-group'=>'\f247', 'fa-object-ungroup'=>'\f248', 'fa-sticky-note'=>'\f249', 'fa-sticky-note-o'=>'\f24a', 'fa-cc-jcb'=>'\f24b', 'fa-cc-diners-club'=>'\f24c', 'fa-clone'=>'\f24d', 'fa-balance-scale'=>'\f24e', 'fa-hourglass-o'=>'\f250', 'fa-hourglass-start'=>'\f251', 'fa-hourglass-half'=>'\f252', 'fa-hourglass-end'=>'\f253', 'fa-hourglass'=>'\f254', 'fa-hand-rock-o'=>'\f255', 'fa-hand-paper-o'=>'\f256', 'fa-hand-scissors-o'=>'\f257', 'fa-hand-lizard-o'=>'\f258', 'fa-hand-spock-o'=>'\f259', 'fa-hand-pointer-o'=>'\f25a', 'fa-hand-peace-o'=>'\f25b', 'fa-trademark'=>'\f25c', 'fa-registered'=>'\f25d', 'fa-creative-commons'=>'\f25e', 'fa-gg'=>'\f260', 'fa-gg-circle'=>'\f261', 'fa-tripadvisor'=>'\f262', 'fa-odnoklassniki'=>'\f263', 'fa-odnoklassniki-square'=>'\f264', 'fa-get-pocket'=>'\f265', 'fa-wikipedia-w'=>'\f266', 'fa-safari'=>'\f267', 'fa-chrome'=>'\f268', 'fa-firefox'=>'\f269', 'fa-opera'=>'\f26a', 'fa-internet-explorer'=>'\f26b', 'fa-television'=>'\f26c', 'fa-contao'=>'\f26d', 'fa-500px'=>'\f26e', 'fa-amazon'=>'\f270', 'fa-calendar-plus-o'=>'\f271', 'fa-calendar-minus-o'=>'\f272', 'fa-calendar-times-o'=>'\f273', 'fa-calendar-check-o'=>'\f274', 'fa-industry'=>'\f275', 'fa-map-pin'=>'\f276', 'fa-map-signs'=>'\f277', 'fa-map-o'=>'\f278', 'fa-map'=>'\f279', 'fa-commenting'=>'\f27a', 'fa-commenting-o'=>'\f27b', 'fa-houzz'=>'\f27c', 'fa-vimeo'=>'\f27d', 'fa-black-tie'=>'\f27e', 'fa-fonticons'=>'\f280');



$checklist_icons = array ( 'icon-check' => '\f00c', 'icon-star' => '\f006', 'icon-angle-right' => '\f105', 'icon-asterisk' => '\f069', 'icon-remove' => '\f00d', 'icon-plus' => '\f067' );

/*-----------------------------------------------------------------------------------*/
/*	Shortcode Selection Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['shortcode-generator'] = array(
	'no_preview' => true,
	'params' => array(),
	'shortcode' => '',
	'popup_title' => ''
);


/*-----------------------------------------------------------------------------------*/
/*	Accordion Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['accordion'] = array(
	'no_preview' => true,
	'icon' => 'fa-list-ul',
	'params' => array(
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
		),	
		'style' => array(
			'type' => 'select',
			'std' => 'simple',
			'label' => __( 'Style', 'magee-shortcodes' ),
			'desc' => '',
			'options' => array(
				'simple' => __( 'Simple Style', 'magee-shortcodes' ),
				'boxed' => __( 'Boxed Style', 'magee-shortcodes' ),
			)
		),
		'type' => array(
			'type' => 'select',
			'label' => __( 'Type', 'magee-shortcodes' ),
			'desc' => '',
			'std' => '1',
			'options' => array(
				'1' => __( 'Type 1', 'magee-shortcodes' ),
				'2' => __( 'Type 2', 'magee-shortcodes' ),
			)
		),
		'content' => array(
			'std' => "\r\n[ms_accordion_item title='Accordion Item 1' icon='fa-flag' status='open']Accordion Item Content 1[/ms_accordion_item]\r\n[ms_accordion_item title='Accordion Item 2' icon='fa-star' status='close']Accordion Item Content 2[/ms_accordion_item]\r\n[ms_accordion_item title='Accordion Item 3' icon='fa-music' status='close']Accordion Item Content 3[/ms_accordion_item]\r\n",
			'type' => 'textarea',
			'label' => __( 'Accordion Items', 'magee-shortcodes' ),
			'desc' => __( 'Insert accordion items shortcode.', 'magee-shortcodes' ),
		),	
		
		),
	'shortcode' => '[ms_accordion style="{{style}}" type="{{type}}"  class="{{class}}" id="{{id}}"]{{content}}[/ms_accordion]',
	'popup_title' => __( 'Accordion Shortcode', 'magee-shortcodes' ),
    'name' => __('accordions-shortcode/','magee-shortocdes'),

);


/*-----------------------------------------------------------------------------------*/
/*	Alert Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['alert'] = array(
	'no_preview' => true,
	'icon' => 'fa-exclamation-circle',
	'params' => array(
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Icon', 'magee-shortcodes' ),
			'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
			'options' => $icons
			),
		
		'content' => array(
			'std' => __('Warning! Better check yourself, you\'re not looking too good.', 'magee-shortcodes'),
			'type' => 'textarea',
			'label' => __( 'Alert Content', 'magee-shortcodes' ),
			'desc' => __( 'Insert the content for the alert.', 'magee-shortcodes' ),
		),
		
		'background_color' => array(
			'std' => '#f5f5f5',
			'type' => 'colorpicker',
			'label' => __( 'Background Color', 'magee-shortcodes' ),
			'desc' => __( 'Set background color for alert box.', 'magee-shortcodes' ),
		),
		'text_color' => array(
			'std' => '',
			'type' => 'colorpicker',
			'label' => __( 'Text Color', 'magee-shortcodes' ),
			'desc' =>__( 'Set content color & border color for alert box.', 'magee-shortcodes' ),
		),
	
		
		'border_width' => array(
			'std' => '0',
			'type' => 'number',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Border Width', 'magee-shortcodes' ),
			'desc' => __('In pixels (px), eg: 1px.', 'magee-shortcodes')
		),
		
		'border_radius' => array(
			'std' => '0',
			'type' => 'number',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Border Radius', 'magee-shortcodes' ),
			'desc' => __('In pixels (px), eg: 1px.', 'magee-shortcodes')
		),
		
		'box_shadow' => array(
			'std' => '',
			'type' => 'choose',
			'label' => __( 'Box Shadow', 'magee-shortcodes' ),
			'desc' => __( 'Display a box shadow for alert.', 'magee-shortcodes' ),
			'options' => $reverse_choices 
		),	
		'dismissable' => array(
			'std' => '',
			'type' => 'choose',
			'label' => __( 'Dismissable', 'magee-shortcodes' ),
			'desc' => __( 'The alert box is dismissable.', 'magee-shortcodes' ),
			'options' =>  $reverse_choices 
		),	
		
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),		
	),
	'shortcode' => '[ms_alert icon="{{icon}}" background_color="{{background_color}}"  text_color="{{text_color}}"  border_width="{{border_width}}"  border_radius="{{border_radius}}" box_shadow="{{box_shadow}}" dismissable="{{dismissable}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_alert]',
	'popup_title' => __( 'Alert Shortcode', 'magee-shortcodes' ),
	'name' => __('alert-shortcode/','magee-shortocdes'),
);

/*-----------------------------------------------------------------------------------*/
/*	Audio Config
/*-----------------------------------------------------------------------------------*/
$magee_shortcodes['audio'] = array(
	'no_preview' => true,
	'icon' => 'fa-play-circle-o',
	'params' => array(
	    'mp3' => array(
			'std' => '',
			'type' => 'link',
			'label' => __( 'Mp3 URL', 'magee-shortcodes'),
			'desc' => __( 'Add the URL of audio in MP3 format.', 'magee-shortcodes')
		),
		'ogg' => array(
			'std' => '',
			'type' => 'link',
			'label' => __( 'Ogg URL', 'magee-shortcodes'),
			'desc' => __( 'Add the URL of audio in OGG format.', 'magee-shortcodes')
		),
		'wav' => array(
			'std' => '',
			'type' => 'link',
			'label' => __( 'Wav URL', 'magee-shortcodes'),
			'desc' => __( 'Add the URL of audio in WAV format.', 'magee-shortcodes')
		),
		'mute' => array(
		    'type' => 'choose',
		    'label' => __( 'Mute Audio','magee-shortcodes'),
		    'desc' => __('Choose to mute the audio.','magee-shortcodes'), 
		    'options' =>  $reverse_choices,
		),
		'autoplay' => array(
		    'type' => 'choose',
		    'label' => __( 'Autoplay Audio','magee-shortcodes'),
		    'desc' => __('Choose to autoplay the audio.','magee-shortcodes'), 
		    'options' =>  $choices,
		),
		'loop' => array(
		    'type' => 'choose',
		    'label' => __( 'Loop Audio','magee-shortcodes'),
		    'desc' => __('Choose to loop the audio.','magee-shortcodes'), 
		    'options' =>  $choices,
		),
		'controls' => array(
		    'type' => 'choose',
		    'label' => __( 'Controls Audio','magee-shortcodes'),
		    'desc' => __('Choose to display controls of the audio.','magee-shortcodes'), 
		    'options' =>  $choices,
		),
	    'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes'),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes'),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),
	),   
    'shortcode' => '[ms_audio mp3="{{mp3}}" ogg="{{ogg}}" wav="{{wav}}" mute="{{mute}}" autoplay="{{autoplay}}" loop="{{loop}}" controls="{{controls}}" class="{{class}}" id="{{id}}"][/ms_audio]' ,
	'popup_title' => __( 'Audio Shortcode','magee-shortcodes'),
	'name' => __('audio-shortcode/','magee-shortocdes'),
);

/*******************************************************
 *	Button Config
 ********************************************************/

$magee_shortcodes['button'] = array(
	'no_preview' => true,
	'icon' => 'fa-hand-o-up',
	'params' => array(
		'style' => array(
			'type' => 'select',
			'label' => __( 'Button Style', 'magee-shortcodes' ),
			'desc' => __( 'Select the button\'s default style.', 'magee-shortcodes' ),
			'options' => array(
				'normal' => __('Normal', 'magee-shortcodes'),
				'dark' => __('Dark', 'magee-shortcodes'),
				'light' => __('Light', 'magee-shortcodes'),
				'2d' => __('2d', 'magee-shortcodes'),
				'3d' => __('3d', 'magee-shortcodes'),
				'line' => __('Line', 'magee-shortcodes'),
				'line_dark' => __('Line Dark', 'magee-shortcodes'),
				'line_light' => __('Line Light', 'magee-shortcodes'),
				
			)
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Button URL', 'magee-shortcodes' ),
			'desc' => __( 'Add the button\'s url eg: http://example.com.', 'magee-shortcodes' )
		),
		'size' => array(
			'type' => 'select',
			'std' =>'medium',
			'label' => __( 'Button Size', 'magee-shortcodes' ),
			'desc' => __( 'Select the button\'s size.', 'magee-shortcodes' ),
			'options' => array(
				'small' => __('Small', 'magee-shortcodes'),
				'medium' => __('Medium', 'magee-shortcodes'),
				'large' => __('Large', 'magee-shortcodes'),
				'xlarge' => __('XLarge', 'magee-shortcodes'),
			)
		),
		
		'border_width' => array(
			'std' => '0',
			'type' => 'number',
			'max' => '50',
			'min' => '0',
			'label' => __('Border Width', 'magee-shortcodes'),
			'desc' => __('In pixels (px), default: 2px.', 'magee-shortcodes'),
		),
	
		'shape' => array(
			'type' => 'select',
			'label' => __( 'Button Shape', 'magee-shortcodes' ),
			'desc' => __( 'Select the button\'s shape. Choose default for theme option selection.', 'magee-shortcodes' ),
			'options' => array(
				'' => __('Default', 'magee-shortcodes'),
				'square' => __('Square', 'magee-shortcodes'),
				'rounded' => __('Rounded', 'magee-shortcodes'),
				'full-rounded' => __('Full Rounded', 'magee-shortcodes'),
			)
		),
		'shadow' => array(
			'type' => 'choose',
			'label' => __( 'Text Shadow', 'magee-shortcodes' ),
			'desc' => __( 'Display shadow for button text.', 'magee-shortcodes' ),
			'options' => $reverse_choices
		),
		'gradient' => array(
			'type' => 'choose',
			'label' => __( 'Gradient', 'magee-shortcodes' ),
			'desc' => __( 'Display gradient for button.', 'magee-shortcodes' ),
			'options' => $reverse_choices
		),
		'block' => array(
			'type' => 'choose',
			'label' => __( 'Block Button', 'magee-shortcodes' ),
			'desc' => __( 'Display in full width.', 'magee-shortcodes' ),
			'options' => $reverse_choices
		),
		
		'target' => array(
			'type' => 'choose',
			'label' => __( 'Button Target', 'magee-shortcodes' ),
			'desc' => __( '_self = open in same window <br />_blank = open in new window.', 'magee-shortcodes' ),
			'options' => array(
				'_self' => '_self',
				'_blank' => '_blank'
			)
		),
	
		'content' => array(
			'std' => __('Button Text', 'magee-shortcodes'),
			'type' => 'text',
			'label' => __( 'Button\'s Text', 'magee-shortcodes' ),
			'desc' => __( 'Add the text that will display in the button.', 'magee-shortcodes' ),
		),
		
		'color' => array(
			'type' => 'colorpicker',
			'desc' => __( 'Set background color for button.', 'magee-shortcodes' ),
			'label' => __( 'Button Color', 'magee-shortcodes' ),
			'std' => ''
		),
		
		'textcolor' => array(
			'type' => 'colorpicker',
			'std' => '#ffffff',
			'label' => __( 'Text Color', 'magee-shortcodes' ),
			'desc' => __( 'Set content color & border color for button.', 'magee-shortcodes' )
		),
		
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Button Icon', 'magee-shortcodes' ),
			'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
			'options' => $icons
		),
		
		'iconanimationtype' => array(
			'type' => 'select',
			'label' => __( 'Icon Animation Type', 'magee-shortcodes' ),
			'desc' => __( 'Select the type of animation to use on the button icon.', 'magee-shortcodes' ),
			'options' => $animation_type
		),
		
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),			
	),
	'shortcode' => '[ms_button style="{{style}}" link="{{link}}" size="{{size}}" shape="{{shape}}" shadow="{{shadow}}" block="{{block}}" target="{{target}}" gradient="{{gradient}}" color="{{color}}"  text_color="{{textcolor}}" icon="{{icon}}" icon_animation_type="{{iconanimationtype}}" border_width="{{border_width}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_button]',
	'popup_title' => __( 'Button Shortcode', 'magee-shortcodes'),
	'name' => __('buttons-shortcode/','magee-shortocdes'),
);


/*******************************************************
 *	Columns Config
 ********************************************************/

$magee_shortcodes['column'] = array(
	'no_preview' => true,
	'icon' => 'fa-columns',
	'params' => array(
	
	),
	'shortcode' => '[ms_row]{{child_shortcode}}[/ms_row]',	
	'popup_title' => __( 'Column Shortcode', 'magee-shortcodes'),	
	'name' => __('columns-shortcode/','magee-shortocdes'),
	'child_shortcode' => array(
	'params' => array(				  
		'style' => array(
			'type' => 'select',
			'label' => __( 'Column Style', 'magee-shortcodes'),
			'desc' => __( 'Select the size of column.', 'magee-shortcodes'),
			'options' => array(
				'1/1' => __('1/1', 'magee-shortcodes'),
				'1/2' => __('1/2', 'magee-shortcodes'),
				'1/3' => __('1/3', 'magee-shortcodes'),
				'1/4' => __('1/4', 'magee-shortcodes'),
				'1/5' => __('1/5', 'magee-shortcodes'),
				'1/6' => __('1/6', 'magee-shortcodes'),
				'2/3' => __('2/3', 'magee-shortcodes'),
				'2/5' => __('2/5', 'magee-shortcodes'),
				'3/4' => __('3/4', 'magee-shortcodes'),
				'3/5' => __('3/5', 'magee-shortcodes'),
				'4/5' => __('4/5', 'magee-shortcodes'),
				'5/6' => __('5/6', 'magee-shortcodes'),
			)
		),
	
		'content' => array(
			'std' => __('Column Content', 'magee-shortcodes'),
			'type' => 'textarea',
			'label' => __( ' Column Content', 'magee-shortcodes'),
			'desc' => __( 'Insert the column\'s content', 'magee-shortcodes'),
		),		
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes'),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes'),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),
	),	
	'shortcode' => '[ms_column style="{{style}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_column]',
	)
	
);

/*-----------------------------------------------------------------------------------*/
/*	Countdowns Config
/*-----------------------------------------------------------------------------------*/


$magee_shortcodes['countdowns'] = array(
	'no_preview' => true,
	'icon' => 'fa-calendar',
	'params' => array(
		
     
	'endtime' => array(
			'std' => date('d-m-Y H:i',strtotime(' 1 month')),
			'type' => 'datepicker',
			'label' => __( 'Set end time for countdown.', 'magee-shortcodes' ),
			'desc' => '',

		),
	    'fontcolor' => array(
		    'std' => '',
			'type' => 'colorpicker',
			'label' => __( 'Font Color','magee-shortcodes' ),
			'desc' => __( 'Set font color for countdown.', 'magee-shortcodes')
		
		), 	
		'backgroundcolor' => array(
		     'std' => '',
			 'type' => 'colorpicker',
			 'label' => __( 'Background Color','magee-shortcodes'),
			 'desc' => __( 'Set background color for countdown.','magee-shortcodes')
		
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
		)
		
		
	),
	'shortcode' => '[ms_countdowns endtime="{{endtime}}" fontcolor="{{fontcolor}}" backgroundcolor="{{backgroundcolor}}" class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Countdowns Shortcode', 'magee-shortcodes' ),
	'name' => __('countdowns-shortcode/','magee-shortocdes'),
);


/*-----------------------------------------------------------------------------------*/
/*	Counter Box Config
/*-----------------------------------------------------------------------------------*/


$magee_shortcodes['counter'] = array(
	'no_preview' => true,
	'icon' => 'fa-calculator',
	'params' => array(
		

	'top_icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Top Icon', 'magee-shortcodes' ),
			'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
			'options' => $icons
		),
	'top_icon_color' => array(
	        'std' => '',
	        'type' => 'colorpicker',
			'label' => __( 'Top Icon Color', 'magee-shortcodes'),  
			'desc' => __( 'Set color for top icon.','magee-shortcodes') 
	
	    ),
	'left_icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Left Icon', 'magee-shortcodes' ),
			'desc' =>  __( 'Insert text before the number.', 'magee-shortcodes' ),
			'options' => $icons
		),
		
		'left_text' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Left Text', 'magee-shortcodes' ),
			'desc' => __( 'Left text of counter num', 'magee-shortcodes' ),
		),
		
		'counter_num' => array(
			'std' => '100',
			'type' => 'number',
			'max' => '200',
			'min' => '0',
			'label' => __( 'Counter Num', 'magee-shortcodes' ),
			'desc' => __( 'The animated counter number.', 'magee-shortcodes' ),
		),
		'right_text' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Right Text', 'magee-shortcodes' ),
			'desc' =>  __( 'Insert text after the number.', 'magee-shortcodes' ),
		),
		
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Title', 'magee-shortcodes' ),
			'desc' => __( 'Insert Title for counter.', 'magee-shortcodes' ),
		),
		
		'border' => array(
			'type' => 'choose',
			'label' => __( 'Display Border', 'magee-shortcodes' ),
			'desc' =>  __( 'Choose to display border for counter.', 'magee-shortcodes' ),
			'options' => array( 
							   '0' => __('No', 'magee-shortcodes' ),  
							   '1' => __('Yes', 'magee-shortcodes' ),  
							   )
							   
		),
	
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
		)
		
		
	),
	'shortcode' => '[ms_counter top_icon="{{top_icon}}" top_icon_color="{{top_icon_color}}" left_icon="{{left_icon}}" counter_num="{{counter_num}}"  left_text="{{left_text}}" right_text="{{right_text}}" title="{{title}}" border="{{border}}" class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Counter Shortcode', 'magee-shortcodes' ),
	'name' => __('counter-box-shortcode/','magee-shortocdes'),
);

/*******************************************************
 *	Custom Box Config
 ********************************************************/
$magee_shortcodes['custom_box'] = array(
	'no_preview' => true,
	'icon' => 'fa-list-alt',
	'params' => array(
		'content' => array(
			'std' => __('Custom Box Content', 'magee-shortcodes'),
			'type' => 'textarea',
			'label' => __( 'Content', 'magee-shortcodes' ),
			'desc' => __( 'Insert content for custom box.', 'magee-shortcodes' ),
		),
		'backgroundimage' => array(
				'type' => 'uploader',
				'label' => __( 'Background Image', 'magee-shortcodes' ),
				'desc' => __( 'Upload an image to display in background of custom box.', 'magee-shortcodes' ),
			), 
		'padding' => array(
			'std' => '30',
			'type' => 'number',
			'min' => '0',
			'max' => '100',
			'label' => __( 'Padding', 'magee-shortcodes' ),
			'desc' => __( 'Content Padding. eg:30px', 'magee-shortcodes')
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),			
	),
	'shortcode' => '[ms_custom_box  backgroundimage="{{backgroundimage}}" padding="{{padding}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_custom_box]',
	'popup_title' => __( ' Custom Box Shortcode', 'magee-shortcodes'),
	'name' => __('custom-box-shortcode/','magee-shortocdes'),
);

/*-----------------------------------------------------------------------------------*/
/*	Dailymotion Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['dailymotion'] = array(
    'no_preview' => true,
	'icon' => 'fa-video-camera',
    'params' => array(
	
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Dailymotion URL', 'magee-shortcodes' ),
			'desc' => __( 'Add the URL the video will link to, ex: http://example.com.', 'magee-shortcodes' ),
		),
		'width' => array(
		    'std' => '100%',
			'type' => 'text',
			'label' => __('Width','magee-shortcodes'),
			'desc' => __('In pixels (px), eg:1px.','magee-shortcodes'),
		),
	    'height' => array(
		    'std' => '100%',
			'type' => 'text',
			'label' => __('Height','magee-shortcodes'),
			'desc' => __('In pixels (px), eg:1px.','magee-shortcodes'), 
		),
		'mute' => array( 
		    'std' => '',  
		    'type' => 'choose',
			'label' => __('Mute Video' ,'magee-shortcodes'),
			'desc' => __('Choose to mute the video.','magee-shortcodes'), 
			'options' => $reverse_choices	 
		),
	    'autoplay' =>array(
		    'std' => '',
		    'type' => 'choose',
			'label' => __('Autoplay Video','magee-shortcodes'),
			'desc' => __('Choose to autoplay the video.','magee-shortcodes'), 
			'options' => array(
			    'yes' => __('Yes','magee-shortcodes'), 
			    'no' => __('No','magee-shortcodes'),
			)
		),
		'loop' =>array(
		    'std' => '',
		    'type' => 'choose',
			'label' => __('Loop Video','magee-shortcodes'),
			'desc' => __('Choose to loop the video.','magee-shortcodes'), 
			'options' => array(
			    'yes' => __('Yes','magee-shortcodes'), 
			    'no' => __('No','magee-shortcodes')
			)
		),
		'controls' =>array(
		    'std' => '',
		    'type' => 'choose',
			'label' => __('Show Controls','magee-shortcodes'),
			'desc' => __('Choose to display controls for the video player.','magee-shortcodes'), 
			'options' => array(
			    'yes' => __('Yes','magee-shortcodes'), 
			    'no' => __('No','magee-shortcodes')
			)
		),
	    'class' =>array(
		    'std' => '',
			'type' => 'text',
			'label' => __('CSS Class','magee-shortcodes'),
			'desc' => __('Add a class to the wrapping HTML element.','magee-shortcodes') 
		),   
	    'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),
	),
	'shortcode' => '[ms_dailymotion link="{{link}}"  width="{{width}}" height="{{height}}" mute="{{mute}}" autoplay="{{autoplay}}" loop="{{loop}}" controls="{{controls}}" class="{{class}}" id="{{id}}"][/ms_dailymotion]',   
    'popup_title' => __( 'Dailymotion Shortcode', 'magee-shortcodes' ),
	'name' => __('dailymotion-shortcode/','magee-shortocdes'),
);       


/*******************************************************
 *	Divider Config
 ********************************************************/

$magee_shortcodes['divider'] = array(
	'no_preview' => true,
	'icon' => 'fa-ellipsis-h',
	'params' => array(
		'style' => array(
			'type' => 'select',
			'label' => __( 'Divider Style', 'magee-shortcodes' ),
			'desc' => __( 'Select the Divider\'s Style.', 'magee-shortcodes' ),
			'options' => array(
				'normal' => __('Normal', 'magee-shortcodes'),
				'shadow' => __('Shadow', 'magee-shortcodes'),
				'dashed' => __('Dashed', 'magee-shortcodes'),
				'dotted' => __('Dotted', 'magee-shortcodes'),
				'double_line' => __('Double Line', 'magee-shortcodes'),
				'double_dashed' => __('Double Dashed', 'magee-shortcodes'),
				'double_dotted' => __('Double Dotted', 'magee-shortcodes'),
				'image' => __('Image', 'magee-shortcodes'),
				'icon' => __('Icon', 'magee-shortcodes'),
				'back_to_top' => __('Back to Top', 'magee-shortcodes'),
			)
		),
		'width' => array(
			'std' => '100%',
			'type' => 'text',
			'label' => __( 'Width', 'magee-shortcodes' ),
			'desc' => __( 'In pixels. Default: 100%', 'magee-shortcodes' ),
		),
		'align' => array(
			'type' => 'select',
			'label' => __( 'Align', 'magee-shortcodes' ),
			'desc' => __( 'When the width is not 100%.', 'magee-shortcodes' ),
			'options' => array(
				'left' => __('Left', 'magee-shortcodes'),
				'center' => __('Center', 'magee-shortcodes'),
			)
		),
		'margin_top' => array(
			'std' => '30',
			'type' => 'number',
			'min' => '0',
			'max' => '100',
			'label' => __( 'Margin Top', 'magee-shortcodes' ),
			'desc' => __( 'Spacing above the separator. In pixels.', 'magee-shortcodes' ),
		),
		'margin_bottom' => array(
			'std' => '30',
			'type' => 'number',
			'max' => '100',
			'min' => '0',
			'label' => __( 'Margin Bottom', 'magee-shortcodes' ),
			'desc' => __( 'Spacing under the separator. In pixels.', 'magee-shortcodes' ),
		),
		
		'border_size' => array(
				'std' => '5',
				'type' => 'number',
				'max' => '50',
				'min' => '0',
				'label' => __( 'Border Size', 'magee-shortcodes' ),
				'desc' => __( 'In pixels (px), eg: 1px. ', 'magee-shortcodes' ),
		 ),
		'border_color' => array(
		        'std' => '#f2f2f2',
				'type' => 'colorpicker',
				'label' => __( 'Border Color', 'magee-shortcodes' ),
				'desc' => __( 'Set the border color.', 'magee-shortcodes' )
			),
		
		'icon' => array(
				'type' => 'iconpicker',
				'label' => __( 'Icon', 'magee-shortcodes' ),
				'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
				'options' => $icons
			),	
	
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),			
	),
	'shortcode' => '[ms_divider style="{{style}}" align="{{align}}"  width="{{width}}"  margin_top="{{margin_top}}" margin_bottom="{{margin_bottom}}" border_size="{{border_size}}" border_color="{{border_color}}" icon="{{icon}}" class="{{class}}" id="{{id}}"][/ms_divider]',
	'popup_title' => __( 'Divider Shortcode', 'magee-shortcodes'),
	'name' => __('divider-shortcode/','magee-shortocdes'),
);

/*-----------------------------------------------------------------------------------*/
/*	Document Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['document'] = array(
    'no_preview' => true,
	'icon' => 'fa-file-text-o',
	'params' => array(
	    'url' => array(
		     'std' => '', 
		     'type' => 'link',
			 'label' => __( 'Doc URL','magee-shortcodes'), 
		     'desc' => __( 'Upload document to display. Supported formats: doc, xls, pdf etc.','magee-shortcodes')
		),
		'width' => array(
			'std' => '300',
			'type' => 'number',
			'max' => '1000',
			'min' => '0',
			'label' => __( 'Width', 'magee-shortcodes'),
			'desc' => __( 'Set width for doc.', 'magee-shortcodes')
		),
		'height' => array(
			'std' => '300',
			'type' => 'number',
			'max' => '1000',
			'min' => '0',
			'label' => __( 'Height', 'magee-shortcodes'),
			'desc' => __( 'Set height for doc.', 'magee-shortcodes')
		),
		'responsive' => array(
			'type' => 'choose',
			'label' => __( 'Responsive','magee-shortcodes'),
		    'desc' => __( 'Choose to responsive or not', 'magee-shortcodes'),
			'options' => $choices
		),
		'viewer' => array(
		    'type' => 'select',
			'label' => __('Viewer','magee-shortcodes'),
		    'desc' => __( 'Choose viewer for document.','magee-shortocodes'),
			'options' => array(
			    'google' => __( 'Google','magee-shortcodes'),
			    'microsoft' => __( 'Microsoft','magee-shortcodes'),
			)  
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes'),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes'),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),
	),
	'shortcode' => '[ms_document url="{{url}}" width="{{width}}" height="{{height}}" responsive="{{responsive}}" viewer="{{viewer}}" class="{{class}}" id="{{id}}"][/ms_document]',
    'popup_title' => __( 'Document Shortcode','magee-shortcodes'),
	'name' => __('document-shortcode/','magee-shortocdes'),
);	

/*-----------------------------------------------------------------------------------*/
/*	Dropcap Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['dropcap'] = array(
	'no_preview' => true,
	'icon' => 'fa-square',
	'params' => array(
		'content' => array(
			'std' => 'A',
			'type' => 'textarea',
			'label' => __( 'Dropcap Letter', 'magee-shortcodes' ),
			'desc' => __( 'Add the letter to be used as dropcap', 'magee-shortcodes' ),
		),
		'color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Color', 'magee-shortcodes' ),
			'desc' => __( 'Controls the color of the dropcap letter. Leave blank for theme option selection.', 'magee ')
		),		
		'boxed' => array(
			'type' => 'choose',
			'label' => __( 'Boxed Dropcap', 'magee-shortcodes' ),
			'desc' => __( 'Choose to get a boxed dropcap.', 'magee-shortcodes' ),
			'options' => $reverse_choices
		),
		'boxedradius' => array(
			'std' => '8',
			'type' => 'number',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Box Radius', 'magee-shortcodes' ),
			'desc' => __('Choose the radius of the boxed dropcap. In pixels (px), eg: 1px', 'magee-shortcodes')
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),
	),
	'shortcode' => '[ms_dropcap color="{{color}}" boxed="{{boxed}}" boxed_radius="{{boxedradius}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_dropcap]',
	'popup_title' => __( 'Dropcap Shortcode', 'magee-shortcodes' ),
	'name' => __('dropcap-shortcode/','magee-shortocdes'),
);

/*-----------------------------------------------------------------------------------*/
/*	Dummy_image Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['dummy_image'] = array(
    'no_preview' => true,
	'icon' => 'fa-picture-o',
	'params' => array(
	    'style' =>array(
		    'type' => 'select',
			'label' => __( 'Style','magee-shortcodes'),
		    'desc' => __( 'Select style for dummy image','magee-shortcodes'),
			'options' => array(
			    'any'       => __( 'Any', 'magee-shortcodes' ),
				'transport' => __( 'Transport', 'magee-shortcodes' ),
				'technics'  => __( 'Technics', 'magee-shortcodes' ),
				'people'    => __( 'People', 'magee-shortcodes' ),
				'sports'    => __( 'Sports', 'magee-shortcodes' ),
				'cats'      => __( 'Cats', 'magee-shortcodes' ),
				'city'      => __( 'City', 'magee-shortcodes' ),
				'food'      => __( 'Food', 'magee-shortcodes' ),
				'nightlife' => __( 'Night life', 'magee-shortcodes' ),
				'fashion'   => __( 'Fashion', 'magee-shortcodes' ),
				'animals'   => __( 'Animals', 'magee-shortcodes' ),
				'business'  => __( 'Business', 'magee-shortcodes' ),
				'nature'    => __( 'Nature', 'magee-shortcodes' ),
				'abstract'  => __( 'Abstract', 'magee-shortcodes' ),
			)
		), 
		'width' => array(
			'std' => '500',
			'type' => 'number',
			'max' => '1000',
			'min' => '0' ,
			'label' => __( 'Width', 'magee-shortcodes'),
			'desc' => __( 'Set width for image.', 'magee-shortcodes')
		),
		'height' => array(
			'std' => '300',
			'type' => 'number',
			'max' => '1000',
			'min' => '0',
			'label' => __( 'Height', 'magee-shortcodes'),
			'desc' => __( 'Set height for image.', 'magee-shortcodes')
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes'),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes'),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),
	
	),
	'shortcode' => '[ms_dummy_image style="{{style}}" width="{{width}}" height="{{height}}" class="{{class}}" id="{{id}}"][/ms_dummy_image]' ,
    'popup_title' => __( 'Dummy Image Shortcode','magee-shortcodes'),
	'name' => __('dummy-image-shortcode/','magee-shortocdes'),
);
	

/*-----------------------------------------------------------------------------------*/
/*	Dummy_text Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['dummy_text'] = array(
    'no_preview' => true,
	'icon' => 'fa-text-height',
	'params' => array(
	    'style' =>array(
		    'type' => 'select',
			'label' => __( 'Style','magee-shortcodes'),
		    'desc' => __( 'Select text type.','magee-shortcodes'),
			'options' => array(
			    'paras' => __( 'Paragraphs', 'magee-shortcodes' ),
				'words' => __( 'Words', 'magee-shortcodes' ),
				'bytes' => __( 'Bytes', 'magee-shortcodes' ),
			)
		), 
		'amount' => array(
		    'std' => '3',
			'type' => 'number',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Amount','magee-shortcodes'),
			'desc' => __( 'Choose how many paragraphs or words to show','magee-shortcodes')
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes'),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes'),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),
	),
	'shortcode' => '[ms_dummy_text style="{{style}}" amount="{{amount}}" class="{{class}}" id="{{id}}"][/ms_dummy_text]' ,
    'popup_title' => __( 'Dummy Text Shortcode','magee-shortcodes'),
	'name' => __('dummy-text-shortcode/','magee-shortocdes'),
);
	

/*-----------------------------------------------------------------------------------*/
/*	Expand Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['expand'] = array(
    'no_preview' => true,
	'icon' => 'fa-sort-amount-asc',
	'params' => array(
	    'more_icon' => array(
			'type' => 'iconpicker',
			'label' => __('More Icon' ,'magee-shortcodes'),
			'desc' => __('Set icon for expand title. Click an icon to select, click again to deselect.','magee-shortcodes'),
			'options' => $icons
		),
	    'more_text' => array(
		    'std' => '',
			'type' => 'text',
			'label' => __( 'More Text', 'magee-shortcodes'),
			'desc' => __( 'Set text for expand title.', 'magee-shortcodes'),
		),
		'less_icon' => array(
			'type' => 'iconpicker',
			'label' => __('Less Icon' ,'magee-shortcodes'),
			'desc' => __('Set icon for fold title. Click an icon to select, click again to deselect.','magee-shortcodes'),
			'options' => $icons
		),
	    'less_text' => array(
		    'std' => '',
			'type' => 'text',
			'label' => __( 'Less Text', 'magee-shortcodes'),
			'desc' => __( 'Set text for fold title. ', 'magee-shortcodes'),
		), 
	    'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Content', 'magee-shortcodes'),
			'desc' => __( 'This text block can be expanded.', 'magee-shortcodes')
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes'),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes'),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),
	),
    'shortcode' => '[ms_expand class="{{class}}" id="{{id}}" more_icon="{{more_icon}}" more_text="{{more_text}}" less_icon="{{less_icon}}" less_text="{{less_text}}"]{{content}}[/ms_expand]',
	'popup_title' => __( 'Expand Shortcode', 'magee-shortcodes'),
	'name' => __('expand-shortcode/','magee-shortocdes'),
);

/*-----------------------------------------------------------------------------------*/
/*	Feature Boxes Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['featurebox'] = array(
	'no_preview' => true,
	'icon' => 'fa-list-alt',
	'params' => array(
		'style' => array(
			'type' => 'select',
			'label' => __( 'Feature Box Style', 'magee-shortcodes' ),
			'desc' => __( 'Select the Feature Box\'s Style.', 'magee-shortcodes' ),
			'options' => array(
				'1' => __('Icon on Top of Title', 'magee-shortcodes'),
				'2' => __('Icon Beside Title and Content', 'magee-shortcodes'),
				'3' => __('Icon Beside Title', 'magee-shortcodes'),
				'4' => __('Boxed', 'magee-shortcodes'),
			)
		),
		
		'title' => array(
				'std' => 'Feature Box',
				'type' => 'text',
				'label' => __( 'Title', 'magee-shortcodes' ),
				'desc' => __( 'Insert title for feature box.', 'magee-shortcodes' ),
		 ),
		
		'title_font_size' => array(
				'std' => '18',
				'type' => 'number',
				'max' => '50',
				'min' => '0',
				'label' => __( 'Title Font Size', 'magee-shortcodes' ),
				'desc' => __( 'Set font size for title of feature box.', 'magee-shortcodes' ),
		 ),
		'title_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Title Color', 'magee-shortcodes' ),
			'desc' => __( 'Set color for title of feature box.', 'magee-shortcodes' ),
			),
		'icon_animation_type' => array(
			'type' => 'select',
			'label' => __( 'Icon Hover Animation', 'magee-shortcodes' ),
			'desc' => __( 'Select the Icon\'s Animation.', 'magee-shortcodes' ),
			'options' => $animation_type
		),
		'icon' => array(
			'type' => 'icon',
			'label' => __( 'Icon', 'magee-shortcodes' ),
			'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
			'options' => $icons
			),
		 'icon_size' => array(
				'std' => '46',
				'type' => 'number',
				'max' => '100',
				'min' => '0',
				'label' => __( 'Icon Size', 'magee-shortcodes' ),
				'desc' =>  __( 'Set size for icon of feature box.', 'magee-shortcodes' ),
		 ),
		'icon_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Icon Color', 'magee-shortcodes' ),
			'desc' => __( 'Set color for icon of feature box.', 'magee-shortcodes' ),
			),
		'icon_border_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Icon Border Color', 'magee-shortcodes' ),
			'desc' => __( 'Set border color for icon of feature box.', 'magee-shortcodes' ),
			),
		'icon_border_width' => array(
				'std' => '0',
				'type' => 'number',
				'max' => '50',
				'min' => '0',
				'label' => __( 'Icon Border Width', 'magee-shortcodes' ),
				'desc' =>  __( 'Set border width for icon of feature box.', 'magee-shortcodes' ),
		 ),
		
		'flip_icon' => array(
			'std' => '',
			'type' => 'select',
			'label' => __( 'Flip Icon', 'magee-shortcodes' ),
			'desc' => __( 'Choose to flip the icon of feature box.', 'magee-shortcodes' ),
			'options' => array(
				'none' => __('None', 'magee-shortcodes'),
				'horizontal' => __('Horizontal', 'magee-shortcodes'),
				'vertical' => __('Vertical', 'magee-shortcodes'),
		     )
			),
			
		'spinning_icon' => array(
			'std' => '',
			'type' => 'choose',
			'label' => __( 'Spinning Icon', 'magee-shortcodes' ),
			'desc' => __( 'Choose to spin the icon of feature box.', 'magee-shortcodes' ),
			'options' => $reverse_choices 
		),	
		
		 'icon_background_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Icon Circle Background Color', 'magee-shortcodes' ),
			'desc' => __( 'Set background for icon circle of feature box.', 'magee-shortcodes' ),
		),
		 
		'alignment' => array(
			'std' => '',
			'type' => 'choose',
			'label' => __( 'Icon Alignment', 'magee-shortcodes' ),
			'desc' => __( 'Set alignment for style2/style3 of feature box.', 'magee-shortcodes' ),
			'options' => array(
				'left' => __('Left', 'magee-shortcodes'),
				'right' => __('Right', 'magee-shortcodes'),
		
			)
		),	
		'icon_circle' => array(
			'std' => '',
			'type' => 'choose',
			'label' => __( 'Icon Circle', 'magee-shortcodes' ),
			'desc' => __( 'Choose to display icon of feature box in circle.', 'magee-shortcodes' ),
			'options' => $reverse_choices 
		),	
		
		'icon_image' => array(
				'std' => '',
				'type' => 'uploader',
				'label' => __( 'Icon Image', 'magee-shortcodes' ),
				'desc' => __( 'To upload your own icon image, remember to deselect icon above.', 'magee-shortcodes' ),
		 ),
		'icon_image_width' => array(
				'std' => '0',
				'type' => 'number',
				'max' => '1000',
				'min' => '0',
				'label' => __( 'Icon Image Width', 'magee-shortcodes' ),
				'desc' => __( 'If using custom icon image, set icon image width. In percentage of pixels (px), eg: 1px.', 'magee-shortcodes' ),
		 ),
		'icon_image_height' => array(
				'std' => '',
				'type' => 'number',
				'max' => '1000',
				'min' => '0',
				'label' => __( 'Icon Image Height', 'magee-shortcodes' ),
				'desc' => __( 'If using custom icon image, set icon image height. In percentage of pixels (px), eg: 1px.', 'magee-shortcodes' ),
		 ),
		
		
		'link_url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Link URL', 'magee-shortcodes' ),
			'desc' => __( 'Set link for feature box, eg: http://example.com.', 'magee-shortcodes' ),
		),	
		'link_target' => array(
			'std' => '',
			'type' => 'choose',
			'label' => __( 'Link Target', 'magee-shortcodes' ),
			'desc' => __( '_self = open in same window _blank = open in new window.', 'magee-shortcodes' ),
			'options' => array(
				'_blank' => __('_blank', 'magee-shortcodes'),
				'_self' => __('_self', 'magee-shortcodes'),
		
			)
		),	
		'link_text' => array(
				'std' => 'Read More',
				'type' => 'text',
				'label' => __( 'Link Text', 'magee-shortcodes' ),
				'desc' => __( 'Insert link text for feature box. It would not display if you leave it as blank.', 'magee-shortcodes' ),
		 ),
		'link_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Link Color', 'magee-shortcodes' ),
			'desc' => __( 'Set color for link of feature box.', 'magee-shortcodes' ),
		),
		'content_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Content Color', 'magee-shortcodes' ),
			'desc' => __( 'Set color for content of feature box.', 'magee-shortcodes' ),
		),
		'content_box_background_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Set box background color for Boxed Style.', 'magee-shortcodes' ),
			'desc' => __( 'For Boxed Style', 'magee-shortcodes' ),
		),

		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),	
		'content' => array(
			'std' => __('Your Content Goes Here', 'magee-shortcodes'),
			'type' => 'textarea',
			'label' => __( 'Feature Box Content', 'magee-shortcodes' ),
			'desc' => '',
		),
	),
	'shortcode' => '[ms_featurebox style="{{style}}" title_font_size="{{title_font_size}}" title_color="{{title_color}}" icon_circle="{{icon_circle}}" icon_size="{{icon_size}}" title="{{title}}" icon="{{icon}}" alignment="{{alignment}}" icon_animation_type="{{icon_animation_type}}" icon_color="{{icon_color}}" icon_background_color="{{icon_background_color}}" icon_border_color="{{icon_border_color}}" icon_border_width="{{icon_border_width}}"  flip_icon="{{flip_icon}}" spinning_icon="{{spinning_icon}}" icon_image="{{icon_image}}" icon_image_width="{{icon_image_width}}" icon_image_height="{{icon_image_height}}" link_url="{{link_url}}" link_target="{{link_target}}" link_text="{{link_text}}" link_color="{{link_color}}" content_color="{{content_color}}" content_box_background_color="{{content_box_background_color}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_featurebox]',
	'popup_title' => __( 'Feature Box Shortcode', 'magee-shortcodes'),
	'name' => __('feature-box-shortcode/','magee-shortcodes'),
);


/*******************************************************
 *	Flip Box Config
 ********************************************************/

$magee_shortcodes['flip_box'] = array(
	'no_preview' => true,
	'icon' => 'fa-list-alt',
	'params' => array(
		'direction' => array(
			'type' => 'select',
			'label' => __( 'Direction', 'magee-shortcodes' ),
			'desc' => __( 'Select flip directioon.', 'magee-shortcodes' ),
			'options' => array(
				'horizontal' => __('Horizontal', 'magee-shortcodes'),
				'vertical' => __('Vertical', 'magee-shortcodes'),
			)			
		),
		'front_paddings' => array(
				'std' => '15',
				'type' => 'number',
				'max' => '100',
				'min' => '0',
				'label' => __( 'Front Container Paddings', 'magee-shortcodes' ),
				'desc' => __( 'Set paddings for front container of flip box.', 'magee-shortcodes' ),
			),
		'front_background' => array(
			'type' => 'colorpicker',
			'std'=>'',
			'label' => __( 'Front Background Color', 'magee-shortcodes' ),
			'desc' => __( 'Set background color for front container of flip box.', 'magee-shortcodes')
		),
		/*'front_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Front Font Color', 'magee-shortcodes' ),
			'desc' => __( 'Custom setting only. Set the background color for custom alert boxes.', 'magee-shortcodes')
		),*/
		'front_content' => array(
			'std' => __('Front Content', 'magee-shortcodes'),
			'type' => 'textarea',
			'label' => __( 'Front content.', 'magee-shortcodes' ),
			'desc' => __( 'Insert content for front container of flip box.', 'magee-shortcodes' ),
		),
		'back_paddings' => array(
				'std' => '15',
				'type' => 'number',
				'max' => '100',
				'min' => '0',
				'label' => __( 'Back Container Paddings', 'magee-shortcodes' ),
				'desc' => __( 'Set paddings for back container of flip box.', 'magee-shortcodes' ),
			),
		'back_background' => array(
			'std'=>'',
			'type' => 'colorpicker',
			'label' => __( 'Front Background Color', 'magee-shortcodes' ),
			'desc' => __( 'Set background color for back container of flip box.', 'magee-shortcodes')
		),
		/*'back_color' => array(
			'std' =>'#ffffff',
			'type' => 'colorpicker',
			'label' => __( 'Back Font Color', 'magee-shortcodes' ),
			'desc' => __( 'Custom setting only. Set the background color for custom alert boxes.', 'magee-shortcodes')
		),*/
		'back_content' => array(
			'std' => __('Back Content', 'magee-shortcodes'),
			'type' => 'textarea',
			'label' => __( 'Back Content.', 'magee-shortcodes' ),
			'desc' => __('Insert content for back container of flip box.', 'magee-shortcodes'),
		),
		
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),			
	),
	'shortcode' => '[ms_flip_box direction="{{direction}}" front_paddings="{{front_paddings}}"  front_background="{{front_background}}" back_paddings="{{back_paddings}}" back_background="{{back_background}}" class="{{class}}" id="{{id}}"]{{front_content}}|||{{back_content}}[/ms_flip_box]',
	'popup_title' => __( 'Flip Box Shortcode', 'magee-shortcodes'),
	'name' => __('flip-box-shortcode/','magee-shortocdes'),
);

/*-----------------------------------------------------------------------------------*/
/*	Heading Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['heading'] = array(
    'icon' => 'fa-header',
	'no_preview' => true,
	'params' => array(
					  
		'title' => array(
			'std' => 'Title Text',
			'type' => 'text',
			'label' => __( 'Title', 'magee-shortcodes'),
            'desc' => __( 'Insert heading text', 'magee-shortcodes')
		),
					  
		'style' => array(
			'type' => 'select',
			'label' => __( 'Style', 'magee-shortcodes'),
			'std' => 'border',
            'desc' => __( 'Choose a heading style. Leave blank as default.', 'magee-shortcodes'),
			'options' => array(
			    'none' => 'None',
				'border' => 'Border',
				'boxed' => 'Boxed',
				'boxed-reverse' => 'Boxed-reverse',
				'doubleline' => 'Doubleline',
			)
		),
		
		'color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Font Color', 'magee-shortcodes'),
            'desc' => __( 'Set color for heading text.', 'magee-shortcodes'),
			),	
		'border_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Border Color', 'magee-shortcodes'),
            'desc' => __( 'Set border color for heading.', 'magee-shortcodes'),
			),
		
		'text_align' => array(
			'type' => 'select',
			'label' => __( 'Text Align', 'magee-shortcodes'),
            'desc' => __( 'Set text align for this heading.', 'magee-shortcodes'),
			'options' => $textalign
		),
		'font_weight' => array(
			'type' => 'select',
			'std' => '400',
			'label' => __( 'Font Weight', 'magee-shortcodes'),
            'desc' => __( 'Set font weight for heading text.', 'magee-shortcodes'),
			'options' => array(
							   '100' => '100',
							   '200' => '200',
							   '300' => '300',
							   '400' => '400',
							   '500' => '500',
							   '600' => '600',
							   '700' => '700',
							   '800' => '800',
							   '900' => '900',
							   )
		),
		
		'font_size' => array(
			'std' => '36',
			'type' => 'number',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Font Size', 'magee-shortcodes'),
            'desc' => __( 'Set font size for heading text. In pixels (px), eg: 1px.', 'magee-shortcodes'),
		),
		'margin_top' => array(
			'std' => '0',
			'type' => 'number',
			'max' => '100',
			'min' => '0',
			'label' => __( 'Margin Top', 'magee-shortcodes'),
            'desc' => __( 'In pixels (px), eg: 1px.', 'magee-shortcodes'),
		),
		'margin_bottom' => array(
			'std' => '0',
			'type' => 'number',
			'max' => '100',
			'min' => '0',
			'label' => __( 'Margin Bottom', 'magee-shortcodes'),
            'desc' => __( 'In pixels (px), eg: 1px.', 'magee-shortcodes'),
		),
		'border_width' => array(
			'std' => '5',
			'type' => 'number',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Border Width', 'magee-shortcodes'),
            'desc' => __( 'In pixels (px), eg: 1px.', 'magee-shortcodes'),
		),
        'responsive_text' => array(
		    'std' => '',
			'type' => 'choose',
			'label' => __( 'Responsive Text','magee-shortcodes'),
            'desc' => __( 'Choose to display responsive text.', 'magee-shortcodes'),
			'options' => $reverse_choices		
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes'),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes'),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),	
		
		
		),
	'shortcode' => '[ms_heading style="{{style}}" color="{{color}}" border_color="{{border_color}}" text_align="{{text_align}}" font_weight="{{font_weight}}" font_size="{{font_size}}" margin_top="{{margin_top}}" margin_bottom="{{margin_bottom}}" border_width="{{border_width}}" responsive_text="{{responsive_text}}"  class="{{class}}" id="{{id}}"]{{title}}[/ms_heading]',
	'popup_title' => __( 'Heading Shortcode', 'magee-shortcodes'),
    'name' => __('heading-shortcode/','magee-shortocdes'),  
);

/*-----------------------------------------------------------------------------------*/
/*	Highlight Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['highlight'] = array(
	'no_preview' => true,
	'icon' => 'fa-magic',
	'params' => array(

		'background_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Background Color', 'magee-shortcodes' ),
			'desc' => __( 'Set background color for highlight item.', 'magee-shortcodes')
		),
		'border_radius' => array(
			'type' => 'number',
			'std' =>'5',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Border Radius', 'magee-shortcodes' ),
			'desc' => __( 'In pixels (px), eg: 1px.', 'magee-shortcodes' ),
		),
		
		'content' => array(
			'std' => __('Your Content Goes Here', 'magee-shortcodes'),
			'type' => 'textarea',
			'label' => __( 'Content to Higlight', 'magee-shortcodes' ),
			'desc' => __( 'Insert content to highlight.', 'magee-shortcodes' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),			

	),
	'shortcode' => '[ms_highlight background_color="{{background_color}}" border_radius="{{border_radius}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_highlight]',
	'popup_title' => __( 'Highlight Shortcode', 'magee-shortcodes' ),
	'name' => __('highlight-shortcode/','magee-shortocdes'),
);


/*-----------------------------------------------------------------------------------*/
/*	Icon Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['icon'] = array(
	'icon' => 'fa-flag',
	'no_preview' => true,
	'params' => array(

	'icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Icon', 'magee-shortcodes'),
			'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes'),
			'options' => $icons
			),
	'size' => array(
			'type' => 'number',
			'std' => '14',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Icon Size', 'magee-shortcodes'),
			'desc' => __( 'Set text size for item.', 'magee-shortcodes'),
			),
	'color' => array(
			'type' => 'colorpicker',
			'std' => '#fdd200',
			'label' => __( 'Icon Color', 'magee-shortcodes'),
			'desc' =>  __( 'Set color for icon.', 'magee-shortcodes'),
		),
    'icon_box' => array(
	        'std' => '',  
	        'type' => 'choose',
	        'label' => __( 'Icon Box', 'magee-shortcodes'),
            'desc' => __( 'Choose to display boxed icon.', 'magee-shortcodes'),
			'options' => $reverse_choices
	    ),		
	'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes'),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
	'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes'),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),			

	),
	'shortcode' => '[ms_icon icon="{{icon}}" size="{{size}}" color="{{color}}" icon_box="{{icon_box}}" class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Icon Shortcode', 'magee-shortcodes'),
	'name' => __('icon-shortcode/','magee-shortocdes'),
);

/*-----------------------------------------------------------------------------------*/
/*	Image Compare Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['image_compare'] = array(
    'icon' => 'fa-file-image-o',
	'no_preview' => true,
	'params' => array(
	    'image_left' => array(
		    'std' => '',
			'type' => 'uploader',
			'label' => __( 'Image Left', 'magee-shortcodes' ),
			'desc' => __( 'Insert the image displayed in the left.', 'magee-shortcodes')
		),
		'image_right' => array(
		    'std' => '',
			'type' => 'uploader',
			'label' => __( 'Image Right', 'magee-shortcodes' ),
			'desc' => __( 'Insert the image displayed in the right.', 'magee-shortcodes')
		),
	    'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
				'std' => '',
				'type' => 'text',
				'label' => __( 'CSS ID', 'magee-shortcodes' ),
				'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),    
	),
    'shortcode' => '[ms_image_compare image_left="{{image_left}}" image_right="{{image_right}}" class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Image Compare Shortcode', 'magee-shortcodes' ),
	'name' => __('image-compare-shortcode/','magee-shortocdes'),
);

/*-----------------------------------------------------------------------------------*/
/*	Image Frame Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['image_frame'] = array(
     'icon' => 'fa-file-image-o',
	'no_preview' => true,
	'params' => array(

	'src' => array(
			'type' => 'uploader',
			'label' => __( 'Image', 'magee-shortcodes' ),
			'desc' => __( 'Upload an image to display.', 'magee-shortcodes' ),
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Image Link URL', 'magee-shortcodes' ),
			'desc' => __( 'Add the URL the picture will link to, ex: http://example.com.', 'magee-shortcodes' ),
		),
	'link_target' => array(
			'std' => '',
			'type' => 'choose',
			'label' => __( 'Link Target', 'magee-shortcodes' ),
			'desc' => __( '_self = open in same window _blank = open in new window.', 'magee-shortcodes' ),
			'options' => array(
				'_blank' => __('_blank', 'magee-shortcodes'),
				'_self' => __('_self', 'magee-shortcodes'),
		
			),
			),
	'border_radius' => array(
			'std' => '0',
			'type' => 'number',
			'max' => '50',
			'min' => '0' ,
			'label' => __( 'Border Radius', 'magee-shortcodes' ),
			'desc' => __( 'Choose the border radius of the image frame. In pixels (px), ex: 1px, or "round".  Leave blank for theme option selection.', 'magee-shortcodes' ), 	         
	    ),	
	'light_box' => array(
	        'std' => '',
			'type' => 'choose' ,
			'label' => __( 'Light Box','magee-shortcodes'),
            'desc' => __( 'Choose to display light box once click.', 'magee-shortcodes'),
			'options' => $reverse_choices	
	    ),	
	'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
	'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),			

	),
	'shortcode' => '[ms_image_frame src="{{src}}" border_radius="{{border_radius}}" link="{{link}}" link_target="{{link_target}}" light_box="{{light_box}}" class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Image Frame Shortcode', 'magee-shortcodes' ),
	'name' => __('image-frame-shortcode/','magee-shortocdes'),
);


/*-----------------------------------------------------------------------------------*/
/*	Label Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['label'] = array(
    'no_preview' => true,
	'icon' => 'fa-bookmark',    
    'params' => array(
	    
		'content' => array(
		    'std' => '',
			'type' => 'text',
			'label' => __( 'Text', 'magee-shortcodes' ),
		    'desc' => __( 'Insert text to be displayed in label.','magee-shortcodes')
		),  
	    'background_color' => array(
		    'std' => '',
			'type' => 'colorpicker',
		    'label' => __( 'Background Color' , 'magee-shortcodes'),
			'desc' => __( 'Set background color for label.','magee-shortcodes')
		),
	),
	'shortcode' => '[ms_label background_color="{{background_color}}" ]{{content}}[/ms_label]',
    'popup_title' => __( 'Label Shortcode', 'magee-shortcodes' ),
	'name' => __('label-shortcode/','magee-shortocdes'), 
);

/*******************************************************
 *	List Config
 ********************************************************/
 $magee_shortcodes['list'] = array(
	'no_preview' => true,
	'icon' => 'fa-list',
	'params' => array(
		'icon' => array(
			'type' => 'iconpicker',
			'label' => __( 'Icon', 'magee-shortcodes' ),
			'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
			'options' => $icons
			),
		'icon_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Icon Color', 'magee-shortcodes' ),
			'desc' => __( 'Set color fo list icon.', 'magee-shortcodes')
			),
		'icon_boxed' => array(
			'type' => 'choose',
			'label' => __( 'Icon Boxed', 'magee-shortcodes' ),
			'desc' => __( 'Choose to set icon boxed.', 'magee-shortcodes'),
			'options' =>array(
				'no' => __('No','magee-shortcodes'),
				'yes' => __('Yes','magee-shortcodes'),)
			),
		 'background_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Icon Circle Background Color', 'magee-shortcodes' ),
			'desc' => __( 'Set background color for list icon.', 'magee-shortcodes')
		),
		'boxed_shape' => array(
			'type' => 'select',
			'label' => __( 'Boxed Shape', 'magee-shortcodes' ),
			'desc' => __( 'Choose boxed shape for list icon.', 'magee-shortcodes'),
			'options' =>array(
				'square' => __('Square','magee-shortcodes'),
				'circle' => __('Circle','magee-shortcodes'),)
			),
		'item_border' => array(
			'type' => 'choose',
			'label' => __( 'Item Border', 'magee-shortcodes' ),
			'desc' => __( 'Choose to display item border for list.', 'magee-shortcodes'),
			'options' =>array(
				'no' => __('No','magee-shortcodes'),
				'yes' => __('Yes','magee-shortcodes'),)
			),
		'item_size' => array(
			'type' => 'number',
			'std'  => '12',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Item Size', 'magee-shortcodes' ),
			'desc' => __( 'Set text font size for item.', 'magee-shortcodes'),
			),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),	
		'content' => array(
				'std' => "\r\n[ms_list_item]List item 1[/ms_list_item]\r\n[ms_list_item]List item 2[/ms_list_item]\r\n[ms_list_item]List item 3[/ms_list_item]\r\n",
				'type' => 'textarea',
				'label' => __( 'List items', 'magee-shortcodes' ),
				'desc' => ''
				),	
	),
	'shortcode' => '[ms_list icon="{{icon}}" icon_color="{{icon_color}}" icon_boxed="{{icon_boxed}}" background_color="{{background_color}}" boxed_shape="{{boxed_shape}}" item_border="{{item_border}}" item_size="{{item_size}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_list]',
	'popup_title' => __( 'List Shortcode', 'magee-shortcodes' ),
	'name' => __('list-shortcode/','magee-shortcodes'),
);

/*******************************************************
 *	Modal Config
 ********************************************************/

$magee_shortcodes['modal'] = array(
	'no_preview' => true,
	'icon' => 'fa-comment-o',
	'params' => array(
		'modal_anchor_text' => array(
			'std' => 'Modal Anchor Text',
			'type' => 'textarea',
			'label' => __( 'Modal Anchor Text', 'magee-shortcodes' ),
			'desc' => __( 'Insert anchor text for the modal.', 'magee-shortcodes' ),
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Modal Heading', 'magee-shortcodes' ),
			'desc' => __( 'Insert heading text for the modal.', 'magee-shortcodes' ),
		),		
		'size' => array(
			'type' => 'select',
			'label' => __( 'Size Of Modal', 'magee-shortcodes' ),
			'desc' => __( 'Select the modal window size.', 'magee-shortcodes' ),
			'options' => array(
				'small' => __('Small', 'magee-shortcodes'),
				'middle' => __('Middle', 'magee-shortcodes'),
				'large' => __('Large', 'magee-shortcodes')
			)
		),

		'showfooter' => array(
			'type' => 'choose',
			'label' => __( 'Show Footer', 'magee-shortcodes' ),
			'desc' => __( 'Choose to show the modal footer with close button.', 'magee-shortcodes' ),
			'options' => array(
				'yes' => __('Yes', 'magee-shortcodes'),
				'no' => __('No', 'magee-shortcodes'),	
			)
		),
		'content' => array(
			'std' => __('Your Content Goes Here', 'magee-shortcodes'),
			'type' => 'textarea',
			'label' => __( 'Contents of Modal', 'magee-shortcodes' ),
			'desc' => __( 'Add your content to be displayed in modal.', 'magee-shortcodes' ),
		),		
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
		),			
	),
	'shortcode' => '[ms_modal title="{{title}}" size="{{size}}" showfooter="{{showfooter}}" class="{{class}}" id="{{id}}"][ms_modal_anchor_text]{{modal_anchor_text}}[/ms_modal_anchor_text][ms_modal_content]{{content}}[/ms_modal_content][/ms_modal]',
	'popup_title' => __( 'Modal Shortcode', 'magee-shortcodes' ),
	'name' => __('modal-shortcode/','magee-shortocdes'),
);

/*-----------------------------------------------------------------------------------*/
/*	Menu Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['menu'] = array(
	'no_preview' => true,
	'icon' => 'fa-bars',
	'params' => array(
	    'menu' => array(
		    'std' => '',
			'type' => 'select',
			'label' => __( 'Select a menu','magee-shortcodes'),
		    'options' =>  magee_shortcode_menus('name') 
		),
	    'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes'),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes'),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),
	),
    'shortcode' => '[ms_menu menu="{{menu}}" class="{{class}}" id="{{id}}"][/ms_menu]' ,
	'popup_title' => __( 'Menu Shortcode', 'magee-shortcodes'),
);	

/*-----------------------------------------------------------------------------------*/
/*	panel Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['panel'] = array(
	'no_preview' => true,
	'icon' => 'fa-list-alt',
	'params' => array(
		
		'title' => array(
			'std' =>  'Panel title',
			'type' => 'text',
			'label' => __( 'Title', 'magee-shortcodes' ),
			'desc' => __( 'Insert title for panel.', 'magee-shortcodes' ),
		),
		'content' => array(
			'std' => __('Panel content.', 'magee-shortcodes'),
			'type' => 'textarea',
			'label' => __( 'Panel Content', 'magee-shortcodes' ),
			'desc' => __( 'Insert content for panel.', 'magee-shortcodes' ),
		),
		
		
		'title_color' => array(
			'std' => '#000',
			'type' => 'colorpicker',
			'label' => __( 'Title Color', 'magee-shortcodes' ),
			'desc' => __( 'Set color for panel title.', 'magee-shortcodes' ),
		),
		'border_color' => array(
			'std' => '#ddd',
			'type' => 'colorpicker',
			'label' => __( 'Border Color', 'magee-shortcodes' ),
			'desc' =>  __( 'Set color for panel border.', 'magee-shortcodes' ),
		),
		
		'title_background_color' => array(
			'std' => '#f5f5f5',
			'type' => 'colorpicker',
			'label' => __( 'Title Background Color', 'magee-shortcodes' ),
			'desc' => __( 'Set background color for panel title.', 'magee-shortcodes' ),
		),		
		'border_radius' => array(
			'std' => '0',
			'type' => 'number',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Border Radius', 'magee-shortcodes' ),
			'desc' => __('In pixels (px), eg: 1px.', 'magee-shortcodes')
		),				
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),		
	),
	'shortcode' => '[ms_panel title="{{title}}" title_color="{{title_color}}" border_color="{{border_color}}"  title_background_color="{{title_background_color}}" border_radius="{{border_radius}}"  class="{{class}}" id="{{id}}"]{{content}}[/ms_panel]',
	'popup_title' => __( 'Panel Shortcode', 'magee-shortcodes' ),
	'name' => __('panel-shortcode/','magee-shortcodes'),
);

/*-----------------------------------------------------------------------------------*/
/*	Person Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['person'] = array(
	'no_preview' => true,
	'icon' => 'fa-user',
	'params' => array(
	    'style' => array(
		    'std' => '',
		    'type' => 'select',
			'label' => __( 'Style', 'magee-shortcodes'),
			'desc' => __( 'Choose to display info below or beside the image.','magee-shortcodes'),
			'options' => array(
			    'below' => __('Below', 'magee-shortcodes')  ,
				'beside' => __('Beside', 'magee-shortcodes'),
			),
		),
		'name' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Name', 'magee-shortcodes' ),
			'desc' => __( 'Insert the name of the person.', 'magee-shortcodes' ),
		),
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Title', 'magee-shortcodes' ),
			'desc' => __( 'Insert the title of the person', 'magee-shortcodes' ),
		),
		'link_target' => array(
			'std' => '',
			'type' => 'choose',
			'label' => __( 'Link Target', 'magee-shortcodes' ),
			'desc' => __( '_self = open in same window _blank = open in new window.', 'magee-shortcodes' ),
			'options' => array(
				'_blank' => __('_blank', 'magee-shortcodes'),
				'_self' => __('_self', 'magee-shortcodes'),
		
			),
			),
		'overlay_color' => array(
		    'std' => '',
			'type' => 'colorpicker',
			'label' => __('Image Overlay Color','magee-shortcodes'),
			'desc' => __('Select a hover color to show over the image as an overlay.','magee-shortcodes')
		),	
		'overlay_opacity' => array(
		    'std' => '0.5',
			'type' => 'select',
			'label' => __('Image Overlay Opacity', 'magee-shortcodes'),
			'desc' => __('Opacity ranges between 0 (transparent) and 1 (opaque). ex: .5','magee-shortcodes'),
			'options' => $opacity
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Profile Description', 'magee-shortcodes' ),
			'desc' => __( 'Insert profile description.', 'magee-shortcodes' )
		),
		'picture' => array(
			'type' => 'uploader',
			'label' => __( 'Picture', 'magee-shortcodes' ),
			'desc' => __( 'Upload an image to display.', 'magee-shortcodes' ),
		),
		'piclink' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Picture Link URL', 'magee-shortcodes' ),
			'desc' => __( 'Add the URL the picture will link to, ex: http://example.com.', 'magee-shortcodes' ),
		),
		'picborder' => array(
			'std' => '0',
			'type' => 'number',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Picture Border Size', 'magee-shortcodes' ),
			'desc' => __( 'In pixels (px), ex: 1px. Leave blank for theme option selection.', 'magee-shortcodes' ),
		),
		'picbordercolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Picture Border Color', 'magee-shortcodes' ),
			'desc' => __( 'Controls the picture\'s border color. Leave blank for theme option selection.', 'magee-shortcodes' ),
		),
		'picborderradius' => array(
			'std' => '0',
			'type' => 'number',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Picture Border Radius', 'magee-shortcodes' ),
			'desc' => __( 'Choose the border radius of the person image. In pixels (px), ex: 1px, or "round".  Leave blank for theme option selection.', 'magee-shortcodes' ),
		),				
		'iconboxedradius' => array(
			'std' => '4',
			'type' => 'number',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Social Icon Box Radius', 'magee-shortcodes' ),
			'desc' => __( 'Choose the border radius of the boxed icons. In pixels (px), ex: 1px, or "round". Leave blank for theme option selection.', 'magee-shortcodes' ),
		),		
		'iconcolor' => array(
			'std' => '',
			'type' => 'colorpicker',
			'label' => __( 'Social Icon Custom Colors', 'magee-shortcodes' ),
			'desc' => __( 'Controls the Icon\'s border color. Leave blank for theme option selection.', 'magee-shortcodes' ),
		),
		'icon1' => array(
				'type' => 'iconpicker',
				'label' => __( 'Icon1', 'magee-shortcodes' ),
				'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
				'options' => $icons
			),
		'link1' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Link1 ', 'magee-shortcodes' ),
			'desc' => __( 'The Icon1 Link ', 'magee-shortcodes' ),
		),
		'icon2' => array(
				'type' => 'iconpicker',
				'label' => __( 'Icon2', 'magee-shortcodes' ),
				'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
				'options' => $icons
			),
		'link2' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Link2 ', 'magee-shortcodes' ),
			'desc' => __( 'The Icon2 Link ', 'magee-shortcodes' ),
		),
		'icon3' => array(
				'type' => 'iconpicker',
				'label' => __( 'Icon3', 'magee-shortcodes' ),
				'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
				'options' => $icons
			),
		'link3' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Link3 ', 'magee-shortcodes' ),
			'desc' => __( 'The Icon3 Link ', 'magee-shortcodes' ),
		),
		'icon4' => array(
				'type' => 'iconpicker',
				'label' => __( 'Icon4', 'magee-shortcodes' ),
				'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
				'options' => $icons
			),
		'link4' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Link4', 'magee-shortcodes' ),
			'desc' => __( 'The Icon4 Link ', 'magee-shortcodes' ),
		),
		'icon5' => array(
				'type' => 'iconpicker',
				'label' => __( 'Icon5', 'magee-shortcodes' ),
				'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
				'options' => $icons
			),
		'link5' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Link5', 'magee-shortcodes' ),
			'desc' => __( 'The Icon5 Link ', 'magee-shortcodes' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
		),
	),
	'shortcode' => '[ms_person name="{{name}}" style="{{style}}" title="{{title}}" link_target="{{link_target}}" overlay_color="{{overlay_color}}" overlay_opacity="{{overlay_opacity}}" picture="{{picture}}" piclink="{{piclink}}" picborder="{{picborder}}" picbordercolor="{{picbordercolor}}" picborderradius="{{picborderradius}}" iconboxedradius="{{iconboxedradius}}" iconcolor="{{iconcolor}}" icon1="{{icon1}}" icon2="{{icon2}}" icon3="{{icon3}}" icon4="{{icon4}}" icon5="{{icon5}}" link1="{{link1}}" link2="{{link2}}" link3="{{link3}}" link4="{{link4}}" link5="{{link5}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_person]',
	'popup_title' => __( 'Person Shortcode', 'magee-shortcodes' ),
	'name' => __('person-shortcode/','magee-shortcodes'),
);

/*-----------------------------------------------------------------------------------*/
/*	Piechart Config
/*-----------------------------------------------------------------------------------*/


$magee_shortcodes['piechart'] = array(
	'no_preview' => true,
	'icon' => 'fa-circle-o-notch',
	'params' => array(

	'percent' => array(
			'std' => '80',
			'type' => 'number',
			'max' => '100',
			'min' => '0',
			'label' => __( 'Percent', 'magee-shortcodes' ),
			'desc' => __( 'From 1 to 100.', 'magee-shortcodes' ),

		),
	
	'content' => array(
			'std' => '80%',
			'type' => 'textarea',
			'label' => __( 'Title', 'magee-shortcodes' ),
			'desc' => __( 'Insert title for piechart. It need to be short.', 'magee-shortcodes' ),

		),
	'size' => array(
			'std' => '200',
			'type' => 'number',
			'max' => '500',
			'min' => '0',
			'label' => __( 'Size', 'magee-shortcodes' ),
			'desc' => __( 'Set size for piechart.', 'magee-shortcodes' ),

		),
	'font_size' => array(
			'std' => '40',
			'type' => 'number',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Font Size', 'magee-shortcodes' ),
			'desc' => __( 'Set font size for piechart title.', 'magee-shortcodes' ),

		),
	'filledcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Filled Color', 'magee-shortcodes' ),
			'desc' =>  __( 'Set color for filled area in piechart.', 'magee-shortcodes' ),
			'std' => '#fdd200'
		),
	'unfilledcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Unfilled Color', 'magee-shortcodes' ),
			'desc' => __( 'Set color for unfilled area in piechart.', 'magee-shortcodes' ),
			'std' => '#f5f5f5'
		),
	
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
		),
	
	),
	'shortcode' => '[ms_piechart percent="{{percent}}"  filledcolor="{{filledcolor}}" size="{{size}}" font_size="{{font_size}}" unfilledcolor="{{unfilledcolor}}" class="{{class}}" ]{{content}}[/ms_piechart]',
	'popup_title' => __( 'Piechart Shortcode', 'magee-shortcodes' ),
	'name' => __('piechart-shortcode/','magee-shortcodes'),
);

/*-----------------------------------------------------------------------------------*/
/*	Popover Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['popover'] = array(
	'no_preview' => true,
	'icon' => 'fa-comment-o',
	'params' => array(
		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Popover Heading', 'magee-shortcodes' ),
			'desc' => __( 'Insert heading text of the popover.', 'magee-shortcodes' ),
		),
		'triggering_text' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Triggering Text', 'magee-shortcodes' ),
			'desc' => __( 'Content that will trigger the popover.', 'magee-shortcodes' ),
		),
		
	
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Contents Inside Popover', 'magee-shortcodes' ),
			'desc' => __( 'Text to be displayed inside the popover.', 'magee-shortcodes' ),
		),

		'trigger' => array(
			'type' => 'select',
			'label' => __( 'Popover Trigger Method', 'magee-shortcodes' ),
			'desc' => __( 'Choose mouse action to trigger popover.', 'magee-shortcodes' ),
			'options' => array(
				'click' => __('Click', 'magee-shortcodes'),
				'hover' => __('Hover', 'magee-shortcodes'),
			)
		),
		'placement' => array(
			'type' => 'select',
			'label' => __( 'Popover Position', 'magee-shortcodes' ),
			'desc' => __( 'Choose the display position of the popover.', 'magee-shortcodes' ),
			'options' => array(
				'top' => __('Top', 'magee-shortcodes'),
				'bottom' => __('Bottom', 'magee-shortcodes'),
				'left' => __('Left', 'magee-shortcodes'),
				'Right' => __('Right', 'magee-shortcodes'),
			)
		),
	
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
		),			
	),
	'shortcode' => '[ms_popover title="{{title}}" triggering_text="{{triggering_text}}" trigger="{{trigger}}" placement="{{placement}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_popover]', // as there is no wrapper shortcode
	'popup_title' => __( 'Popover Shortcode', 'magee-shortcodes' ),
	'name' => __('popover-shortcode/','magee-shortocdes'),
);

/*-----------------------------------------------------------------------------------*/
/*	Progress Config
/*-----------------------------------------------------------------------------------*/


$magee_shortcodes['progress'] = array(
	'no_preview' => true,
	'icon' => 'fa-tasks',
	'params' => array(
		
'striped' => array(
			'type' => 'select',
			'label' => __( 'Striped', 'magee-shortcodes' ),
			'desc' => __( 'Choose to get the filled area striped.', 'magee-shortcodes' ),
			'options' => array( 
							   'none' => __( 'None Striped', 'magee-shortcodes' ),
							   'striped' => __( 'Striped', 'magee-shortcodes' ),
							   'striped animated' => __( 'Striped Animated', 'magee-shortcodes' ),
							   )
							  
		),
'rounded' => array(
			'type' => 'select',
			'label' => __( 'Rounded', 'magee-shortcodes' ),
			'desc' => __( 'Choose to set the progress bar as rounded.', 'magee-shortcodes' ),
			'options' => array( 
							   'on' => __( 'On', 'magee-shortcodes' ),
							   'off' => __( 'Off', 'magee-shortcodes' ),
							   )
							  
		),
	'number' => array(
			'type' => 'choose',
			'label' => __( 'Display  Number', 'magee-shortcodes' ),
			'desc' => __( 'Choose to diplay number for progress bar.', 'magee-shortcodes' ),
			'options' =>$choices 
							  
		),
	
	'percent' => array(
			'std' => '50',
			'type' => 'number',
			'max' => '100',
			'min' => '0',
			'label' => __( 'Percent', 'magee-shortcodes' ),
			'desc' => __( 'Set percentage for progress bar. 0~100.', 'magee-shortcodes' )
		),
	
	'text' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Text', 'magee-shortcodes' ),
			'desc' => __( 'Insert text for progress bar.', 'magee-shortcodes' ),
		),
	
	'height' => array(
			'std' => '30',
			'type' => 'number',
			'max' => '200',
			'min' => '0',
			'label' => __( 'Height', 'magee-shortcodes' ),
			'desc' =>__( 'Set height for progress bar.', 'magee-shortcodes' ),
		),
	
	

	'color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Color', 'magee-shortcodes' ),
			'desc' => __( 'Set background color for filled area in progress bar.', 'magee-shortcodes' ),
			'std' => ''
		),
	'textalign' => array(
			'type' => 'select',
			'label' => __( 'Text Align', 'magee-shortcodes' ),
			'desc' =>  __( 'Set align for progress bar.', 'magee-shortcodes' ),
			'options' => array( 
							   'left' => __( 'Left', 'magee-shortcodes' ), 
							   'right' =>  __( 'Right', 'magee-shortcodes' ),
							   )
							   
		),
	'textposition' => array(
			'type' => 'select',
			'label' => __( 'Text Position', 'magee-shortcodes' ),
			'desc' => __( 'Choose text position for progress bar.', 'magee-shortcodes' ),
			'options' => array( 
							   '1' => __('Text on Progress bars', 'magee-shortcodes' ),  
							   '2' => __('Text above progress bars', 'magee-shortcodes' ),  
							   )
							   
		),
				
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
		)
		
		
	),
	'shortcode' => '[ms_progress striped="{{striped}}" rounded="{{rounded}}" number="{{number}}"  percent="{{percent}}" text="{{text}}"  height="{{height}}" color="{{color}}" textalign="{{textalign}}" textposition="{{textposition}}" class="{{class}}" id="{{id}}"]',
	'popup_title' => __( 'Progress Shortcode', 'magee-shortcodes' ),
	'name' => __('progress-bar-shortcode/','magee-shortcodes'),
);

/*-----------------------------------------------------------------------------------*/
/* Promo_box Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['promo_box'] = array(
	'no_preview' => true,
	'icon' => 'fa-tag',
	'params' => array(

		'style' => array(
			'type' => 'select',
			'label' => __( 'Style', 'magee-shortcodes' ),
			'desc' => __( 'Select style for promo box.', 'magee-shortcodes' ),
			'options' => array(
				'normal' => __('Normal', 'magee-shortcodes'),
				'boxed' => __('Boxed', 'magee-shortcodes'),
			)
		),		
		'border_color' => array(
			'type' => 'colorpicker',
			'std' => '#fdd200',
			'label' => __( 'Border Color', 'magee-shortcodes' ),
			'desc' =>  __( 'Set color for highlight border of promo box.', 'magee-shortcodes' ),
		),
		'border_width' => array(
			'std' => '1',
			'type' => 'number',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Border Width', 'magee-shortcodes' ),
			'desc' => __( 'Set width for highlight border of promo box.', 'magee-shortcodes' ),
		),
	
		'border_position' => array(
			'type' => 'select',
			'label' => __( 'Border Position', 'magee-shortcodes' ),
			'desc' => __( 'Choose position for highlight border of promo box.', 'magee-shortcodes' ),
			'options' => array(
				'left' => __('Left', 'magee-shortcodes'),
				'right' => __('Right', 'magee-shortcodes'),
				'top' => __('Top', 'magee-shortcodes'),
				'bottom' => __('Bottom', 'magee-shortcodes'),
				
			)
		),
		'background_color' => array(
			'type' => 'colorpicker',
			'std' =>'#f5f5f5',
			'label' => __( 'Icon Circle Background Color', 'magee-shortcodes' ),
			'desc' => __( 'Set background color for promo box.', 'magee-shortcodes' ),
		),
		'button_color' => array(
			'type' => 'colorpicker',
			'std' =>'',
			'label' => __( 'Button Color', 'magee-shortcodes' ),
		),
		
		'button_text' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Button Text', 'magee-shortcodes' ),
			'desc' => __( 'Inser text for button of promo box.', 'magee-shortcodes' ),
		),	
		'button_text_color' => array(
			'std' => '#ffffff',
			'type' => 'colorpicker',
			'label' => __( 'Button Text Color', 'magee-shortcodes' ),
		),	
		'button_link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Button Link URL', 'magee-shortcodes' ),
			'desc' => __( 'Inser link for button of promo box, eg: http://example.com.', 'magee-shortcodes' ),
		),	
		'button_icon' => array(
				'type' => 'iconpicker',
				'label' => __( 'Button Icon', 'magee-shortcodes' ),
				'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
				'options' => $icons
			),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Content', 'magee-shortcodes' ),
			'desc' => __( 'Insert content for promo box.', 'magee-shortcodes' ),
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
		),
	),
	'shortcode' => '[ms_promo_box style="{{style}}" border_color="{{border_color}}" border_width="{{border_width}}" border_position="{{border_position}}" background_color="{{background_color}}" button_color="{{button_color}}" button_link="{{button_link}}" button_icon="{{button_icon}}" button_text="{{button_text}}" button_text_color="{{button_text_color}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_promo_box]',
	'popup_title' => __( 'Promo Box Shortcode', 'magee-shortcodes' ),
	'name' => __('promo-box-shortcode/','magee-shortcodes'),
);

/*-----------------------------------------------------------------------------------*/
/*	Pullquote Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['pullquote'] = array(
	'no_preview' => true,
	'icon' => 'fa-quote-left',
	'params' => array(
	    'align' => array(
			'type' => 'select',
			'label' => __('Align', 'magee-shortcodes'),
			'desc' => __('Set alignment for pullquote.','magee-shortcodes'),
			'options' => array(
			    'left' => __('Left', 'magee-shortcodes') ,
				'right' => __('Right', 'magee-shortcodes'),
			)
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Content', 'magee-shortcodes'),
			'desc' => __( 'Insert content for pullquote.', 'magee-shortcodes')
		),
	    'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes'),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes'),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		), 
		
	),
    'shortcode' => '[ms_pullquote align="{{align}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_pullquote]',
	'popup_title' =>__('Pullquote Shortcode','magee-shortcodes'),
	'name' => __('pullquote-shortcode/','magee-shortocdes'),
);	

/*-----------------------------------------------------------------------------------*/
/*	QR Code Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['QRCode'] = array(
    'no_preview' => true,
	'icon' => 'fa-qrcode',    
    'params' => array(
	
	    'content' =>array(
		    'std' => '',
			'type' => 'text',
			'label' => __( 'Content', 'magee-shortcodes' ),
		    'desc' => __( 'The text to store within the QR code. Any text or URL is available.', 'magee-shortcodes' ),
		),
		'alt' => array(
			'std' => 'scan QR code',
			'type' => 'text',
			'label' => __( 'Alternative text', 'magee-shortcodes' ),
			'desc' => __( 'Set image alt for QR code.', 'magee-shortcodes' ),
		),
		'size' => array(
		    'std' => '100',
			'type' => 'number',
			'max' => '200',
			'min' => '0',
			'label' => __('Size in pixel','magee-shortcodes'),
			'desc' => __('Image width and height.','magee-shortcodes'),
		),
		'click' => array(
		    'std' => 'no',
			'type' => 'choose',
			'label' => __('QRCode clickable?','magee-shortcodes'),
			'desc' => __('Choose to make this QR code clickable.','magee-shortcodes'), 
			'options' => array(
				'no' => __( 'No', 'magee-shortcodes' ),
				'yes' => __( 'Yes', 'magee-shortcodes' ),
			)
		),
		'fgcolor' => array( 
		    'std' => '#000000',  
		    'type' => 'colorpicker',
			'label' => __('Foreground Color' ,'magee-shortcodes'),
			'desc' => __('Set foreground Color for QR code.' ,'magee-shortcodes'),
		),
	    'bgcolor' =>array(
		    'std' => '#FFFFFF',
		    'type' => 'colorpicker',
			'label' => __('Background Color','magee-shortcodes'),
			'desc' => __('Set background Color for QR code.' ,'magee-shortcodes'),
		),
	),
	'shortcode' => '[ms_qrcode alt="{{alt}}" size="{{size}}" click="{{click}}" fgcolor="{{fgcolor}}" bgcolor="{{bgcolor}}"]{{content}}[/ms_qrcode]',
    'popup_title' => __( 'QR Code Shortcode', 'magee-shortcodes' ),
	'name' => __('qr-code-shortcode/','magee-shortocdes'),
); 

/*-----------------------------------------------------------------------------------*/
/*	Quote Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['quote'] = array(
	'no_preview' => true,
	'icon' => 'fa-quote-right',    
	'params' => array(
	    'cite' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Cite', 'magee-shortcodes'),
			'desc' => __( 'Author name for quote.', 'magee-shortcodes')
		),
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Cite Link', 'magee-shortcodes'),
			'desc' => __( 'Insert Url for the quote author. Leave empty to disable hyperlink.', 'magee-shortcodes')
		),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Content', 'magee-shortcodes'),
			'desc' => __( 'Insert content for the quote.', 'magee-shortcodes')
		),
	    'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes'),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes'),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		), 
	),
    'shortcode' =>  '[ms_quote cite="{{cite}}" url="{{url}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_quote]',
	'popup_title' =>__('Quote Shortcode','magee-shortcodes'),
	'name' => __('quote-shortcode/','magee-shortocdes'),
);	

/*-----------------------------------------------------------------------------------*/
/*	RSS Feed Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['rss_feed'] = array(
	'no_preview' => true,
	'icon' => 'fa-rss' ,
	'params' => array(
	      
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Feed URL', 'magee-shortcodes'),
			'desc' => __( 'Url of RSS Feed.', 'magee-shortcodes')
		),  
		'number' => array(
			'std' => '3',
			'type' => 'number',
			'max' => '20',
			'min' => '0',
			'label' => __( 'Number to Display', 'magee-shortcodes'),
			'desc' => __( 'Number of items to show.', 'magee-shortcodes')
		),  
	    'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes'),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes'),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),   
	),
	'shortcode' => '[ms_rss_feed url="{{url}}" number="{{number}}" class="{{class}}" id="{{id}}"][/ms_rss_feed]',
	'popup_title' =>__('RSS Feed Shortcode','magee-shortcodes'),
	'name' => __('rss-feed-shortcode/','magee-shortocdes'),
);	


/*-----------------------------------------------------------------------------------*/
/*	Scheduled_content Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['scheduled_content'] = array(
    'no_preview' => true,
	'icon' => 'fa-clock-o',
	'params' => array(
	    'time' => array(
			'std' => '6-12,13-16',
			'type' => 'text',
			'label' => __( 'Time', 'magee-shortcodes'),
			'desc' => __( 'Select an random time in one day to show content.</br>Example: 6-12,13-16  show content from  6:00 to 12:00 and from 13:00 to 16:00', 'magee-shortcodes')
		),
		'day_week' => array(
			'std' => '1-5,7',
			'type' => 'text',
			'label' => __( 'Days of Week', 'magee-shortcodes'),
			'desc' => __( 'Select days from one week to show content.</br>1 => Monday </br>2 => Tuesday  </br> 3 => Wednesday</br> 4 => Thursday  </br> 5 => Friday  </br> 6 => Saturday </br>  7 => Sunday </br>Examples:1-5,7 =>show content at Sunday and from Monday to Friday', 'magee-shortcodes')
		),
		'day_month' =>array(
		    'std' => '10-15,20-25',
			'type' => 'text',
			'label' => __( 'Days of Month', 'magee-shortcodes'), 
			'desc' => __('Select days from one month to show content.</br>Examples:</br>1 => show content only at first day of  month </br> 10-25 => show content from 10th to 25th </br> 10-15,20-25 => show content from 10th to 15th and from 20th to 25th','magee-shortcodes')
		),
		'months' => array(
		    'std' => '1,5,8-9',
			'type' => 'text',
			'label' => __('Months','magee-shortcodes'),
			'desc' => __('Select months from a year to show content.</br>Examples:</br>1 => show content in January </br> 3-6 => show content from March to June </br> 1,5,8-9 => show content in January,May and from August to September','magee-shortcodes') 
		),
		'years' => array(
		    'std' => '2016,2017,2345-2666',
			'type' => 'text',
			'label' => __('Years','magee-shortcodes'),  
		    'desc' => __( 'Select years to show content.</br>Examples:</br> 2016 => show content in 2016 </br>2014-2016 => show content from 2014 to 2016 </br> 2016,2017,2345-2666 => show content in 2016,2017 and from 2345 to 2666','magee-shortcodes')
		),
	    'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes'),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
	    'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes'),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		), 
		'content' => array(
		    'std' => '',
			'type' => 'textarea',
			'label' => __( 'Content', 'magee-shortcodes'),
			'desc' => __( 'Insert scheduled content.', 'magee-shortcodes') 
		)   
	),
	'shortcode' => '[ms_scheduled_content time="{{time}}" day_week="{{day_week}}" day_month="{{day_month}}" months="{{months}}" years="{{years}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_scheduled_content]',
	'popup_title' => __( 'Scheduled Shortcode','magee-shortcodes'),
	'name' => __('scheduled-shortcode/','magee-shortocdes'),
);	

/*-----------------------------------------------------------------------------------*/
/*	Section Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['section'] = array(
	'no_preview' => true,
	'icon' => 'fa-list-alt',
	'params' => array(

		'background_color' => array(
			'std' => '',
			'type' => 'colorpicker',
			'label' => __( 'Background Color', 'magee-shortcodes' ),
			'desc' => __( 'Set background for section. Leave blank for transparent.', 'magee-shortcodes' ),
		),
		
		'background_image' => array(
			'std' => '',
			'type' => 'uploader',
			'label' => __( 'Background Image', 'magee-shortcodes' ),
			'desc' => __( 'Upload an image to display in the background.', 'magee-shortcodes' ),
		),
		'background_repeat' => array(
			'type' => 'select',
			'label' => __( 'Background Repeat', 'magee-shortcodes' ),
			'desc' =>__( 'Choose repeat style for the background image.', 'magee-shortcodes' ),
			'std' => '',
			'options' => array(
							  'repeat' => __( 'Repeat', 'magee-shortcodes' ),
							  'repeat-x' => __( 'Repeat-x', 'magee-shortcodes' ),
							  'repeat-y' => __( 'Repeat-y', 'magee-shortcodes' ),
							  'no-repeat' => __( 'No-repeat', 'magee-shortcodes' ),
							  'inherit' => __( 'Inherit', 'magee-shortcodes' )
							   )
		),
		
		'background_position' => array(
			'type' => 'select',
			'label' => __( 'Background Position', 'magee-shortcodes' ),
			'desc' => __( 'Choose the postion of the background image.', 'magee-shortcodes' ),
			'std' => '',
			'options' => array(
							  'top left' => __( 'Top Left', 'magee-shortcodes' ),
							  'top center' => __( 'Top Center', 'magee-shortcodes' ),
							  'top right' => __( 'Top Right', 'magee-shortcodes' ),
							  'center left' => __( 'Center Left', 'magee-shortcodes' ),
							  'center center' => __( 'Center Center', 'magee-shortcodes' ),
							  'center right' => __( 'Center Right', 'magee-shortcodes' ),
							  'bottom left' => __( 'Bottom Left', 'magee-shortcodes' ),
							  'bottom center' => __( 'Bottom Center', 'magee-shortcodes' ),
							  'bottom right' => __( 'Bottom Right', 'magee-shortcodes' )
							   )
		),
		'background_parallax' => array(
			'type' => 'choose',
			'label' => __( 'Background Parallax', 'magee-shortcodes' ),
			'desc' => __( 'Choose how the background image scrolls and responds.', 'magee-shortcodes' ),
			'std' => 'no',
			'options' => $reverse_choices
		),
		'border_size' => array(
			'std' => '0',
			'type' => 'number',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Border Size', 'magee-shortcodes' ),
			'desc' =>__( 'In pixels (px), eg: 1px.', 'magee-shortcodes' ),
		),
		
		'border_color' => array(
			'std' => '',
			'type' => 'colorpicker',
			'label' => __( 'Border Color', 'magee-shortcodes' ),
			'desc' => __( 'Set border color for section.', 'magee-shortcodes' ),
		),
		'border_style' => array(
			'type' => 'select',
			'label' => __( 'Background Position', 'magee-shortcodes' ),
			'desc' => __( 'Select border style for section', 'magee-shortcodes' ),
			'std' => '',
			'options' => array(
							  'none' => __( 'None', 'magee-shortcodes' ),
							  'hidden' => __( 'Hidden', 'magee-shortcodes' ),
							  'dotted' => __( 'Dotted', 'magee-shortcodes' ),
							  'dashed' => __( 'Dashed', 'magee-shortcodes' ),
							  'solid' => __( 'Solid', 'magee-shortcodes' ),
							  'double' => __( 'Double', 'magee-shortcodes' ),
							  'groove' => __( 'Groove', 'magee-shortcodes' ),
							  'ridge' => __( 'Ridge', 'magee-shortcodes' ),
							  'inset' => __( 'Inset', 'magee-shortcodes' ),
							  'outset' => __( 'Outset', 'magee-shortcodes' ),
							  'initial' => __( 'Initial', 'magee-shortcodes' ),
							  'inherit' => __( 'Inherit', 'magee-shortcodes' ),
							 
							   )
		),
		
		'padding_top' => array(
			'std' => '10',
			'type' => 'number',
			'max' => '100',
			'min' => '0',
			'label' => __( 'Padding Top', 'magee-shortcodes' ),
			'desc' =>  __( 'In pixels (px), eg: 1px.', 'magee-shortcodes' ),
		),
		'padding_bottom' => array(
			'std' => '10',
			'type' => 'number',
			'max' => '100',
			'min' => '0',
			'label' => __( 'Padding Bottom', 'magee-shortcodes' ),
			'desc' => __( 'In pixels (px), eg: 1px.', 'magee-shortcodes' ),
		),
		'padding_left' => array(
			'std' => '10',
			'type' => 'number',
			'max' => '100',
			'min' => '0',
			'label' => __( 'Padding Left', 'magee-shortcodes' ),
			'desc' => __( 'In pixels (px), eg: 1px.', 'magee-shortcodes' ),
		),
		'padding_right' => array(
			'std' => '10',
			'type' => 'number',
			'max' => '100',
			'min' => '0',
			'label' => __( 'Padding Right', 'magee-shortcodes' ),
			'desc' => __( 'In pixels (px), eg: 1px.', 'magee-shortcodes' ),
		),
		'contents_in_container' => array(
			'type' => 'choose',
			'label' => __( 'Contents in Container ?', 'magee-shortcodes' ),
			'desc' =>  __( 'Put the content in container.', 'magee-shortcodes' ),
			'std' => 'no',
			'options' => $reverse_choices
		),
		
		'content' => array(
			'std' => __('Section content.', 'magee-shortcodes'),
			'type' => 'textarea',
			'label' => __( 'Section Content', 'magee-shortcodes' ),
			'desc' => __( 'Insert content for section.', 'magee-shortcodes' ),
		),
		
		'top_separator' => array(
			'std' => 'yes',
			'type' => 'select',
			'label' => __( 'Top Separator', 'magee-shortcodes' ),
			'desc' => '',
			'options' => array(
				'' => __('None', 'magee-shortcodes'),
				'triangle' => __('Triangle', 'magee-shortcodes'),
				'doublediagonal' => __('Doublediagonal', 'magee-shortcodes'),
				'halfcircle' => __('Halfcircle', 'magee-shortcodes'),
				'bigtriangle' => __('Bigtriangle', 'magee-shortcodes'),
				'bighalfcircle' => __('Bighalfcircle', 'magee-shortcodes'),
				'curl' => __('Curl', 'magee-shortcodes'),
				'multitriangles' => __('Multitriangles', 'magee-shortcodes'),
				'roundedsplit' => __('Roundedsplit', 'magee-shortcodes'),
				'boxes' => __('Boxes', 'magee-shortcodes'),
				'zigzag' => __('Zigzag', 'magee-shortcodes'),
				'clouds' => __('Clouds', 'magee-shortcodes'),
			)
		),
		'bottom_separator' => array(
			'std' => 'yes',
			'type' => 'select',
			'label' => __( 'Bottom Separator', 'magee-shortcodes' ),
			'desc' => '',
			'options' => array(
				'' => __('None', 'magee-shortcodes'),
				'triangle' => __('Triangle', 'magee-shortcodes'),
				'halfcircle' => __('Halfcircle', 'magee-shortcodes'),
				'bigtriangle' => __('Bigtriangle', 'magee-shortcodes'),
				'bighalfcircle' => __('Bighalfcircle', 'magee-shortcodes'),
				'curl' => __('Curl', 'magee-shortcodes'),
				'multitriangles' => __('Multitriangles', 'magee-shortcodes'),
				'roundedcorners' => __('Roundedcorners', 'magee-shortcodes'),
				'foldedcorner' => __('Foldedcorner', 'magee-shortcodes'),
				'boxes' => __('Boxes', 'magee-shortcodes'),
				'zigzag' => __('Zigzag', 'magee-shortcodes'),
				'stamp' => __('Stamp', 'magee-shortcodes'),
			)
		),
		'full_height' => array(
		    'std' => '',
			'type' => 'choose',
			'label' => __('Full Height' , 'magee-shortcodes'),
			'desc' => __('Choose to set the section height same as browser window.' , 'magee-shortcodes'),
			'options' => $reverse_choices
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes')
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),		
	),
	'shortcode' => '[ms_section background_color="{{background_color}}" background_image="{{background_image}}" background_repeat="{{background_repeat}}" background_position="{{background_position}}" background_parallax="{{background_parallax}}" border_size="{{border_size}}" border_color="{{border_color}}" border_style="{{border_style}}" padding_top="{{padding_top}}" padding_bottom="{{padding_bottom}}" padding_left="{{padding_left}}" padding_right="{{padding_right}}" contents_in_container="{{contents_in_container}}" top_separator="{{top_separator}}" bottom_separator="{{bottom_separator}}" full_height="{{full_height}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_section]',
	'popup_title' => __( 'Section Shortcode', 'magee-shortcodes' ),
	'name' => __('section-shortcode/','magee-shortcodes'),
);

/*-----------------------------------------------------------------------------------*/
/* Magee Slider Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['ms_slider'] = array(
	'no_preview' => true,
	'icon' => 'fa-sliders',
	'params' => array(
  
		'id' => array(
			'std' => '',
			'type' => 'select',
			'label' => __( 'Slider', 'magee-shortcodes' ),
			'desc' => '',
			'options' => $magee_sliders
		),		
		
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
		
	),),
	'shortcode' => '[ms_slider id="{{id}}" class="{{class}}"]',
	'popup_title' => __( 'Slider', 'magee-shortcodes' ),
	'name' => __('slider-shortcode/','magee-shortocdes'),
);

/*-----------------------------------------------------------------------------------*/
/* Social Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['social'] = array(
	'no_preview' => true,
	'icon' => 'fa-twitter',
	'params' => array(

		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Title ', 'magee-shortcodes' ),
			'desc' => __( 'Insert the title for the social icon.', 'magee-shortcodes' ),
			),
		'icon' => array(
			'type' => 'iconpicker',
				'label' => __( 'Icon', 'magee-shortcodes' ),
				'desc' => __( 'Click an icon to select, click again to deselect.', 'magee-shortcodes' ),
				'options' => $icons
			),
		'icon_size' => array(
			'std' => '13',
			'type' => 'number',
			'max' => '50',
			'min' => '0',
			'label' => __( 'Icon Size', 'magee-shortcodes' ),
			'desc' => __( 'In pixels (px), eg: 13px.', 'magee-shortcodes')
		),	
		'iconcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Icon Color', 'magee-shortcodes' ),
			'desc' => __( 'Set color for icon.', 'magee-shortcodes')
			),
		 'backgroundcolor' => array(
			'type' => 'colorpicker',
			'label' => __( 'Icon Circle Background Color', 'magee-shortcodes' ),
			'desc' => __( 'Set background color for icon.', 'magee-shortcodes')
		),
		 'effect_3d' => array(
		 	'std'=>'no',
			'type' => 'choose',
			'label' => __( 'Icon 3D effect' ),
			'desc' => __( 'Display box shadow for icon.', 'magee-shortcodes'),
			'options' => array(
				'yes' => __('Yes', 'magee-shortcodes'),
				'no' => __('No', 'magee-shortcodes'),
			)	
		),		
		'iconboxedradius' => array(
			'type' => 'select',
			'label' => __( 'Icon Box Radius Style', 'magee-shortcodes' ),
			//'desc' => __( '', 'magee-shortcodes' ),
			'options' => array(
				'normal' => __('Normal', 'magee-shortcodes'),
				'boxed' => __('Boxed', 'magee-shortcodes'),
				'rounded' => __('Rounded', 'magee-shortcodes'),
				'circle' => __('Circle ', 'magee-shortcodes'),				
			)
		),
		'iconlink' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Icon Link URL', 'magee-shortcodes' ),
			'desc' => __( 'Add the icon\'s url eg: http://example.com.', 'magee-shortcodes' ),
		),		
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
		),
	),
	'shortcode' => '[ms_social icon_size="{{icon_size}}" title="{{title}}" icon="{{icon}}" iconcolor="{{iconcolor}}" effect_3d="{{effect_3d}}" backgroundcolor="{{backgroundcolor}}" iconboxedradius="{{iconboxedradius}}" iconlink="{{iconlink}}"  class="{{class}}" id="{{id}}"][/ms_social]',
	'popup_title' => __( 'Social Shortcode', 'magee-shortcodes' ),
	'name' => __('social-shortcode/','magee-shortcodes'),
);

/*-----------------------------------------------------------------------------------*/
/*	Tabs Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['tabs'] = array(
	'no_preview' => true,
	'icon' => 'fa-list-alt',
	'params' => array(
		'style' => array(
			'type' => 'select',
			'label' => __( 'Style', 'magee-shortcodes' ),
			'desc' => __( 'Select tabs\' style.', 'magee-shortcodes' ),
			'options' => array(
				'simple' => __('Simple Style', 'magee-shortcodes'),
				'simple justified' => __('Simple Style Justified', 'magee-shortcodes'),
				'button' => __('Button Style', 'magee-shortcodes'),
				'button justified' => __('Button Style Justified', 'magee-shortcodes'),
				'normal' => __('Normal Style', 'magee-shortcodes'),
				'normal justified' => __('Normal Style Justified', 'magee-shortcodes'),
				'vertical' => __('Vertical Style', 'magee-shortcodes'),
				'vertical right' => __('Vertical Style Right', 'magee-shortcodes'),
			)
		),
		'title_color' => array(
			'type' => 'colorpicker',
			'label' => __( 'Title Color', 'magee-shortcodes' ),
			'desc' => __( 'Set color for tab item\'s title.', 'magee-shortcodes')
			),		
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
		),
		'content' => array(
				'std' => "\r\n[ms_tab title='Tab 1' icon='fa-flag']Tab content 1[/ms_tab]\r\n[ms_tab title='Tab 2' icon='fa-thumbs-up']Tab content 2[/ms_tab]\r\n[ms_tab title='Tab 3' icon='fa-leaf']Tab content 3[/ms_tab]\r\n",
				'type' => 'textarea',
				'label' => __( 'Tab Items', 'magee-shortcodes' ),
				'desc' => __( 'Insert tab items.', 'magee-shortcodes' )
			)
		
	),

	'shortcode' => '[ms_tabs style="{{style}}" title_color="{{title_color}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_tabs]',
	'popup_title' => __( 'Tab Shortcode', 'magee-shortcodes' ),
	'name' => __('tabs-shortcode/','magee-shortcodes'),

);

/*-----------------------------------------------------------------------------------*/
/*	Targeted_content Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['targeted_content'] = array(
    'no_preview' => true,
	'icon' => 'fa-eye' ,
    'params' => array(
	    'type' => array(
		    'type' => 'select',
			'label' => __( 'Type', 'magee-shortcodes'),
			'desc' => __( 'Select visible permissions.Private for author only. Members for logged-in users. Guests for users not logged in.', 'magee-shortcodes'),
			'options' => array(
			    'private' => __( 'Private','magee-shortcodes'),
				'members' => __( 'Members','magee-shortcodes'),
				'guests' => __('Guests','magee-shortcodes'),
			)
		),
		'content' => array(
			'std' => 'note text',
			'type' => 'textarea',
			'label' => __( 'Content', 'magee-shortcodes'),
			'desc' => __( 'Set content for targeted users.', 'magee-shortcodes')
		),
		'alternative' => array(
			'std' => 'alternative text',
			'type' => 'textarea',
			'label' => __( 'Alternative Content', 'magee-shortcodes'),
			'desc' => __( 'Set content for other users.', 'magee-shortcodes')
		),
	),
    'shortcode' => '[ms_targeted_content type="{{type}}" alternative="{{alternative}}"]{{content}}[/ms_targeted_content]',
	'popup_title' => __( 'Targeted Shortcode','magee-shortcodes'),
	'name' => __('targeted-shortcode/','magee-shortocdes'),
);

/*-----------------------------------------------------------------------------------*/
/* testimonial Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['testimonial'] = array(
	'no_preview' => true,
	'icon' => 'fa-commenting',
	'params' => array(
		'style' => array(
			'std' => '',
			'type' => 'select',
			'label' => __( 'Style ', 'magee-shortcodes' ),
			'desc' => __( 'Select testimonial\'s style', 'magee-shortcodes' ),
			'options' => array(
				'normal' => __('Normal', 'magee-shortcodes') ,
				'box' => __('Box', 'magee-shortcodes') ,
				),
			),
		'name' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Name', 'magee-shortcodes' ),
			'desc' => __( 'Name of testimonial\'s author.', 'magee-shortcodes' ),
			),
		'byline' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Byline', 'magee-shortcodes' ),
			'desc' => __( 'Byline of testimonial\'s author.', 'magee-shortcodes' ),
			),
		'avatar' => array(
				'type' => 'link',
				'label' => __( 'Avatar', 'magee-shortcodes' ),
				'desc' => __( 'Avatar of testimonial\'s author.', 'magee-shortcodes' ),
			),

		 'alignment' => array(
			'std' => '',
			'type' => 'select',
			'label' => __( 'Alignment', 'magee-shortcodes' ),
			'desc' => __( 'Select the content\'s alignment.', 'magee-shortcodes' ),
			'options' => array(
				'none' => __('None', 'magee-shortcodes') ,
				'center' => __('Center', 'magee-shortcodes') ,
				),
			),
		'content' => array(
				'std' => __('Testimonial Content', 'magee-shortcodes'),
				'type' => 'textarea',
				'label' => __( 'Testimonial Content', 'magee-shortcodes' ),
				'desc' => __( 'Insert content for testimonial.', 'magee-shortcodes' )
			),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
		),
	),
	'shortcode' => '[ms_testimonial style="{{style}}" name="{{name}}" avatar="{{avatar}}" byline="{{byline}}" alignment="{{alignment}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_testimonial]',
	'popup_title' => __( 'Testimonial Shortcode', 'magee-shortcodes' ),
	'name' => __('testimonial-shortcode/','magee-shortcodes'),
);


/*-----------------------------------------------------------------------------------*/
/*	Timeline Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['timeline'] = array(
	'no_preview' => true,
	'icon' => 'fa-history',
	'params' => array(
					  
		'columns' => array(
			'type' => 'select',
			'label' => __( 'Columns', 'magee-shortcodes' ),
			'desc' =>__( 'Number of items.', 'magee-shortcodes' ),
			'std' => '4',
			'options' => array(
				'2' => __( '2 columns', 'magee-shortcodes' ),
				'3' => __( '3 columns', 'magee-shortcodes' ),
				'4' => __( '4 columns', 'magee-shortcodes' ),
				'5' => __( '5 columns', 'magee-shortcodes' )
			)
		),

		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
		),	
		'content' => array(
			'std' => "\r\n[ms_timeline_item title='Moved In' time='2012']Vestibulum pharetra nibh sit amet consequat commodo.[/ms_timeline_item]\r\n[ms_timeline_item title='Upgraded In' time='2013']Vestibulum pharetra nibh sit amet consequat commodo.[/ms_timeline_item]\r\n[ms_timeline_item title='Extended In' time='2014']Vestibulum pharetra nibh sit amet consequat commodo.[/ms_timeline_item]\r\n[ms_timeline_item title='Presented In' time='2015']Vestibulum pharetra nibh sit amet consequat commodo.[/ms_timeline_item]\r\n",
			'type' => 'textarea',
			'label' => __( 'Timeline Items', 'magee-shortcodes' ),
			'desc' => __( 'Insert timeline items.', 'magee-shortcodes' ),
		),
		
		),
	'shortcode' => '[ms_timeline columns="{{columns}}"  class="{{class}}" id="{{id}}"]{{content}}[/ms_timeline]',
	'popup_title' => __( 'Timeline Shortcode', 'magee-shortcodes' ),
    'name' => __('timeline-shortcode/','magee-shortcodes'),

);

/*-----------------------------------------------------------------------------------*/
/*	Tooltip Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['tooltip'] = array(
	'no_preview' => true,
	'icon' => 'fa-comment-o',
	'params' => array(

		'title' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Tooltip Text', 'magee-shortcodes' ),
			'desc' => __( 'Insert the text that displays in the tooltip', 'magee-shortcodes' )
		),
		'placement' => array(
			'type' => 'select',
			'label' => __( 'Tooltip Position', 'magee-shortcodes' ),
			'desc' => __( 'Choose the display position.', 'magee-shortcodes' ),
			'options' => array(
				'top' => __('Top', 'magee-shortcodes'),
				'bottom' => __('Bottom', 'magee-shortcodes'),
				'left' => __('Left', 'magee-shortcodes'),
				'right' => __('Right', 'magee-shortcodes'),
			)
		),
		'trigger' => array(
			'type' => 'select',
			'label' => __( 'Tooltip Trigger', 'magee-shortcodes' ),
			'desc' => __( 'Choose action to trigger the tooltip.', 'magee-shortcodes' ),
			'options' => array(
				'hover' => __('Hover', 'magee-shortcodes'),
				'click' => __('Click', 'magee-shortcodes'),
			)
		),			
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __( 'Content', 'magee-shortcodes' ),
			'desc' => __( 'Insert the text that will activate the tooltip hover', 'magee-shortcodes' )
		),
		'class' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS Class', 'magee-shortcodes' ),
			'desc' => __( 'Add a class to the wrapping HTML element.', 'magee-shortcodes' )
		),
		'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes' )
		),			
	),
	'shortcode' => '[ms_tooltip title="{{title}}" placement="{{placement}}" trigger="{{trigger}}" class="{{class}}" id="{{id}}"]{{content}}[/ms_tooltip]',
	'popup_title' => __( 'Tooltip Shortcode', 'magee-shortcodes' ),
	'name' => __('tooltip-shortcode/','magee-shortocdes'),
);


/*-----------------------------------------------------------------------------------*/
/*	Video Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['video'] = array(
    'no_preview' => true,
	'icon' => 'fa-play-circle-o',    
    'params' => array(
	
	    'mp4_url' => array(
            'std' => '',
            'type' => 'link',
            'label' => __( 'Mp4 Video Url','magee-shortcodes'),
            'desc' => __( 'Add the URL of video in MPEG4 format. WebM and MP4 format must be included to render your video with cross browser compatibility. OGV is optional.', 'magee-shortcodes' ),  
        
        ),  
        'ogv_url' => array(
            'std' => '',
            'type' => 'link',
            'label' => __( 'Ogv Video Url','magee-shortcodes'),
            'desc' => __( 'Add the URL of video in OGV format. WebM and MP4 format must be included to render your video with cross browser compatibility. OGV is optional.', 'magee-shortcodes' ),  
        
        ),
        'webm_url' => array(
            'std' => '',
            'type' => 'link',
            'label' => __( 'Webm Video Url','magee-shortcodes'),
            'desc' => __( 'Add the URL of video in webm format. WebM and MP4 format must be included to render your video with cross browser compatibility. OGV is optional.', 'magee-shortcodes' ),  
        
        ),  
        'poster' => array(
            'std' => '',
            'type' => 'uploader',
            'label' => __( 'Poster','magee-shortcodes'),
            'desc' => __( 'Display a image when browser does not support HTML5 format.','magee-shortcodes'),
        
        ),		
		'width' => array(
		    'std' => '100%',
			'type' => 'text',
 			'label' => __('Width','magee-shortcodes'),
			'desc' => __('In pixels (px), eg: 1px.','magee-shortcodes'),
		),
	    'height' => array(
		    'std' => '100%',
		    'type' => 'text',
			'label' => __('Height','magee-shortcodes'),
			'desc' => __('In pixels (px), eg: 1px.','magee-shortcodes'), 
		),
		'mute' => array( 
		    'std' => '',  
		    'type' => 'choose',
			'label' => __('Mute Video' ,'magee-shortcodes'),
			'desc' => __('Choose to mute the video.','magee-shortcodes'), 
			'options' => $reverse_choices	 
		),
	    'autoplay' =>array(
		    'std' => '',
		    'type' => 'choose',
			'label' => __('Autoplay Video','magee-shortcodes'),
			'desc' => __('Choose to autoplay the video.','magee-shortcodes'), 
			'options' => array(
			    'yes' => __('Yes','magee-shortcodes'), 
			    'no' => __('No','magee-shortcodes'),
			)
		),
		'loop' =>array(
		    'std' => '',
		    'type' => 'choose',
			'label' => __('Loop Video','magee-shortcodes'),
			'desc' => __('Choose to loop the video.','magee-shortcodes'), 
			'options' => array(
			    'yes' => __('Yes','magee-shortcodes'), 
			    'no' => __('No','magee-shortcodes')
			)
		),
		'controls' =>array(
		    'std' => '',
		    'type' => 'choose',
			'label' => __('Show Controls','magee-shortcodes'),
			'desc' => __('Choose to display controls for the video player.','magee-shortcodes'), 
			'options' => array(
			    'yes' => __('Yes','magee-shortcodes'), 
			    'no' => __('No','magee-shortcodes')
			)
		),
	    'class' =>array(
		    'std' => '',
			'type' => 'text',
			'label' => __('CSS Class','magee-shortcodes'),
			'desc' => __('Add a class to the wrapping HTML element.','magee-shortcodes') 
		),   
	    'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),
	),
	'shortcode' => '[ms_video mp4_url="{{mp4_url}}" ogv_url="{{ogv_url}}" webm_url="{{webm_url}}" poster="{{poster}}"  width="{{width}}" height="{{height}}" mute="{{mute}}" autoplay="{{autoplay}}" loop="{{loop}}" controls="{{controls}}" class="{{class}}" id="{{id}}"][/ms_video]',   
    'popup_title' => __( 'Video Shortcode', 'magee-shortcodes' ),
	'name' => __('video-shortcode/','magee-shortocdes'),
);       
       

/*-----------------------------------------------------------------------------------*/
/*	Vimeo Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['vimeo'] = array(
    'no_preview' => true,
	'icon' => 'fa-vimeo-square',    
    'params' => array(
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Vimeo URL', 'magee-shortcodes' ),
			'desc' => __( 'Add the URL the video will link to, ex: http://example.com.', 'magee-shortcodes' ),
		),
		'width' => array(
		    'std' => '100%',
			'type' => 'text',
			'label' => __('Width','magee-shortcodes'),
			'desc' => __('In pixels (px), eg:1px.','magee-shortcodes'),
		),
	    'height' => array(
		    'std' => '100%',
			'type' => 'text',
			'label' => __('Height','magee-shortcodes'),
			'desc' => __('In pixels (px), eg:1px.','magee-shortcodes'), 
		),
		'mute' => array( 
		    'std' => '',  
		    'type' => 'choose',
			'label' => __('Mute Video' ,'magee-shortcodes'),
			'desc' => __('Choose to mute the video.','magee-shortcodes'), 
			'options' => $reverse_choices	 
		),
	    'autoplay' =>array(
		    'std' => '',
		    'type' => 'choose',
			'label' => __('Autoplay Video','magee-shortcodes'),
			'desc' => __('Choose to autoplay the video.','magee-shortcodes'), 
			'options' => array(
			    'yes' => __('Yes','magee-shortcodes'), 
			    'no' => __('No','magee-shortcodes'),
			)
		),
		'loop' =>array(
		    'std' => '',
		    'type' => 'choose',
			'label' => __('Loop Video','magee-shortcodes'),
			'desc' => __('Choose to loop the video.','magee-shortcodes'), 
			'options' => array(
			    'yes' => __('Yes','magee-shortcodes'), 
			    'no' => __('No','magee-shortcodes')
			)
		),
		'controls' =>array(
		    'std' => '',
		    'type' => 'choose',
			'label' => __('Show Controls','magee-shortcodes'),
			'desc' => __('Choose to display controls for the video player.','magee-shortcodes'), 
			'options' => array(
			    'yes' => __('Yes','magee-shortcodes'), 
			    'no' => __('No','magee-shortcodes')
			)
		),
	    'class' =>array(
		    'std' => '',
			'type' => 'text',
			'label' => __('CSS Class','magee-shortcodes'),
			'desc' => __('Add a class to the wrapping HTML element.','magee-shortcodes') 
		),   
	    'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),
	),
	'shortcode' => '[ms_vimeo link="{{link}}"  width="{{width}}" height="{{height}}" mute="{{mute}}" autoplay="{{autoplay}}" loop="{{loop}}" controls="{{controls}}" class="{{class}}" id="{{id}}"][/ms_vimeo]',   
    'popup_title' => __( 'Vimeo Shortcode', 'magee-shortcodes' ),
	'name' => __('vimeo-shortcode/','magee-shortocdes'),
);       
/*-----------------------------------------------------------------------------------*/
/*	Youtube Config
/*-----------------------------------------------------------------------------------*/

$magee_shortcodes['youtube'] = array(
    'no_preview' => true,
	'icon' => 'fa-youtube-square',    
    'params' => array(
	
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'Youtube URL', 'magee-shortcodes' ),
			'desc' => __( 'Add the URL the video will link to, ex: http://example.com.', 'magee-shortcodes' ),
		),
		'width' => array(
		    'std' => '100%',
			'type' => 'text',
			'label' => __('Width','magee-shortcodes'),
			'desc' => __('In pixels (px), eg:1px.','magee-shortcodes'),
		),
	    'height' => array(
		    'std' => '100%',
			'type' => 'text',
			'label' => __('Height','magee-shortcodes'),
			'desc' => __('In pixels (px), eg:1px.','magee-shortcodes'), 
		),
		'mute' => array( 
		    'std' => '',  
		    'type' => 'choose',
			'label' => __('Mute Video' ,'magee-shortcodes'),
			'desc' => __('Choose to mute the video.','magee-shortcodes'), 
			'options' => $reverse_choices	 
		),
	    'autoplay' =>array(
		    'std' => '',
		    'type' => 'choose',
			'label' => __('Autoplay Video','magee-shortcodes'),
			'desc' => __('Choose to autoplay the video.','magee-shortcodes'), 
			'options' => array(
			    'yes' => __('Yes','magee-shortcodes'), 
			    'no' => __('No','magee-shortcodes'),
			)
		),
		'loop' =>array(
		    'std' => '',
		    'type' => 'choose',
			'label' => __('Loop Video','magee-shortcodes'),
			'desc' => __('Choose to loop the video.','magee-shortcodes'), 
			'options' => array(
			    'yes' => __('Yes','magee-shortcodes'), 
			    'no' => __('No','magee-shortcodes')
			)
		),
		'controls' =>array(
		    'std' => '',
		    'type' => 'choose',
			'label' => __('Show Controls','magee-shortcodes'),
			'desc' => __('Choose to display controls for the video player.','magee-shortcodes'), 
			'options' => array(
			    'yes' => __('Yes','magee-shortcodes'), 
			    'no' => __('No','magee-shortcodes')
			)
		),
	    'class' =>array(
		    'std' => '',
			'type' => 'text',
			'label' => __('CSS Class','magee-shortcodes'),
			'desc' => __('Add a class to the wrapping HTML element.','magee-shortcodes') 
		),   
	    'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),
	),
	'shortcode' => '[ms_youtube link="{{link}}"  width="{{width}}" height="{{height}}" mute="{{mute}}" autoplay="{{autoplay}}" loop="{{loop}}" controls="{{controls}}" class="{{class}}" id="{{id}}"][/ms_youtube]',   
    'popup_title' => __( 'Youtube Shortcode', 'magee-shortcodes' ),
	'name' => __('youtube-shortcode/','magee-shortocdes'),
);       

/*-----------------------------------------------------------------------------------*/
/*	Widget Area
/*-----------------------------------------------------------------------------------*/   

$magee_shortcodes['widget_area'] = array(
    'no_preview' => true,
	'icon' => 'fa-cog',    
    'params' => array(
	    'name' => array(
		    'std' => '',
			'type' => 'select',
			'label' => __('Name','magee-shortcodes'),
			'desc' => __('Choose widget name to show','magee-shortcodes'),
			'options' => $magee_widget,
		),
		'background_color' => array(
		    'std' => '',
			'type' => 'colorpicker',
			'label' => __('Background Color','magee-shortcodes'),
			'desc' => __('Set background color for widget area','magee-shortcodes'),
		),
		'padding' => array(
		    'std' => '0',
			'max' => '200',
			'min' => '0',
			'type' => 'number',
			'label' =>  __('Padding','magee-shortcodes'),
			'desc' => __( 'Content Padding. eg:30', 'magee-shortcodes')
		),
	    'class' =>array(
		    'std' => '',
			'type' => 'text',
			'label' => __('CSS Class','magee-shortcodes'),
			'desc' => __('Add a class to the wrapping HTML element.','magee-shortcodes') 
		),   
	    'id' => array(
			'std' => '',
			'type' => 'text',
			'label' => __( 'CSS ID', 'magee-shortcodes' ),
			'desc' => __( 'Add an ID to the wrapping HTML element.', 'magee-shortcodes')
		),
	),
    'shortcode' => '[ms_widget_area name="{{name}}"  background_color="{{background_color}}" padding="{{padding}}" class="{{class}}" id="{{id}}"][/ms_widget_area]',
    'popup_title' => __( 'Widget Area Shortcode', 'magee-shortcodes' ),

);