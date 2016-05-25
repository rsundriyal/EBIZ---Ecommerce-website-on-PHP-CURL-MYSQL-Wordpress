<?php
$position_css = "";
if ($position == 'top-left'){
    $position_css = "top: 0; left: 0;";
}else if ($position == 'top-right'){
    $position_css = "top: 0; right: 0;";
}else if ($position == 'bottom-left'){
    $position_css = "bottom: 0; left: 0;";
}else if ($position == 'bottom-right'){
    $position_css = "bottom: 0; right: 0;";
}

//--wpml-------------
$text = yith_wcbm_wpml_string_translate( 'yith-woocommerce-badges-management', sanitize_title( $text ), $text );
//-------------------

?>
<style>
    .yith-wcbm-badge-<?php echo $product_id ?>-<?php echo $id_badge ?>{

<?php
    if ($type == 'text') {
    ?>
    color: <?php echo $txt_color?>; 
    background-color: <?php echo $bg_color ?>; 
    width: <?php echo $width ?>px; 
    height: <?php echo $height ?>px; 
    line-height: <?php echo $height ?>px;
<?php
}else{
    // IMAGE BADGE
    $image_url = YITH_WCBM_ASSETS_URL . '/images/' . $image_url;
    $text = '<img src="'. $image_url . '" />';
}
?>
<?php echo $position_css ?>
}
</style>
<div class='yith-wcbm-badge yith-wcbm-badge-<?php echo $product_id ?>-<?php echo $id_badge?>'>
    <?php echo $text ?>
</div><!--yith-wcbm-badge-->