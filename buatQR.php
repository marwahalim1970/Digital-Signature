<?php    

function create_QR($data)
{
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;    
    $PNG_WEB_DIR = 'temp/';
    include "assets/phpqrcode/qrlib.php";    
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_WEB_DIR);
    $filename = $PNG_WEB_DIR.'test.png';
    $errorCorrectionLevel = 'Q';
    $matrixPointSize = 3;
        $filename = 'test'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($data, $PNG_WEB_DIR.$filename, $errorCorrectionLevel, $matrixPointSize, 1);
	return $filename;
}?>
	