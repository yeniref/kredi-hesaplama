<?php
function kredi_hesaplama( $atts ) {
    $atts = shortcode_atts( array(
        'title' => true,
        'faiz_oran' => true,
        'bsmv' => true,
        'kkdf' => true,
    ), $atts );
     
    ob_start();
    $banka_adi = $atts['title'];
    $faiz_oran = $atts['faiz_oran'];
    $bsmv = $atts['bsmv'];
    $kkdf = $atts['kkdf'];
    include 'form.php'; 
    return ob_get_clean(); 
}
add_shortcode( 'kredi_hesaplama', 'kredi_hesaplama' );