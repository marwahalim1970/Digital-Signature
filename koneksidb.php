<?php
	date_default_timezone_set("Asia/Bangkok");
	$koneksi = 	@new mysqli('localhost', 'siakad', 'noinoi-titi', 'si_dsis');
	if (mysqli_connect_error()) 
	{
		die('<div style="border: 1px dotted #FF0000; color: #FF0000; padding: 5px;">GAGAL melakukan Koneksi ke server, coba beberapa saat lagi !!!!</div>');
	}
	$ip_add = "https://localhost";

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
function kodeacak($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'marwa';
    $secret_iv = 'halim';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'acak' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'balik' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}
function UploadImageResize($new_name,$file,$dir,$width){
   //direktori gambar
   $vdir_upload = $dir;
   $vfile_upload = $vdir_upload . $_FILES[''.$file.'']["name"];

   //Simpan gambar dalam ukuran sebenarnya
   move_uploaded_file($_FILES[''.$file.'']["tmp_name"], $dir.$_FILES[''.$file.'']["name"]);

   //identitas file asli
   $im_src = imagecreatefromjpeg($vfile_upload);
   $src_width = imageSX($im_src);
   $src_height = imageSY($im_src);

   //Set ukuran gambar hasil perubahan
   $dst_width = $width;
   $dst_height = ($dst_width/$src_width)*$src_height;

   //proses perubahan ukuran
   $im = imagecreatetruecolor($dst_width,$dst_height);
   imagecopyresampled($im, $im_src, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);

   //Simpan gambar
   imagejpeg($im,$vdir_upload . $new_name,100);
   
   //Hapus gambar di memori komputer
   imagedestroy($im_src);
   imagedestroy($im);
   $remove_small = unlink("$vfile_upload");
 }?>