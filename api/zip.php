<?php
# define file array
$zip_folder = "";
	$album_download_directory = 'album/'.uniqid().'/';
	mkdir($album_download_directory, 0777);

	$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);

$files = array(
    'https://fbcdn-photos-c-a.akamaihd.net/hphotos-ak-xlt1/v/t1.0-0/p480x480/14333619_1111934492232118_6470590623646460055_n.jpg?oh=d495193c1d25899721b47c62c317081a&oe=5876ACDD&__gda__=1485090998_7ae4fc0a80fc5f6c1cfdcb0d920415bb',
    'https://fbcdn-photos-d-a.akamaihd.net/hphotos-ak-xap1/v/t1.0-0/p480x480/14344242_1111934502232117_2175435662633291272_n.jpg?oh=fd511374b745ac3edb615410aa6bbef9&oe=5867A14C&__gda__=1484500596_18d707e29bfc02e1b7888fe6c4c0c93f'
);

# create new zip opbject
//$zip = new ZipArchive();

# create a temp file & open it
//$tmp_file = tempnam('.','');
//$zip->open($tmp_file, ZipArchive::CREATE);
$j=1;
# loop through each file
foreach($files as $file){

    # download file
    //file_put_contents(''.$j.".jpg", fopen( $file, 'r'),false, stream_context_create($arrContextOptions));
			

	$album_directory = $album_download_directory.'House';
		if ( !file_exists( $album_directory ) ) {
			mkdir($album_directory, 0777);
		}
    $download_file = file_get_contents($file,false, stream_context_create($arrContextOptions));
    //file_get_contents($file,false, stream_context_create($arrContextOptions));
    file_put_contents( $album_directory.'/'.$j.".jpg",$download_file) ;

    #add it to the zip
   // $zip->addFromString(''.$j.'.jpg',$download_file);
     $j++;
}

# close zip
//$zip->close();

require_once('zipper.php');
		$zipper = new zipper();
		echo $zipper->get_zip($album_download_directory);
		/*if($zipper->zip('album/','./compressed.zip')){
			echo "true";
		}
		else{
			echo "false";
		}*/

# send the file to the browser as a download
//header('Content-disposition: attachment; filename=download3.zip');
//header('Content-type: application/zip');
//readfile($tmp_file);

//unlink($tmp_file);

?>