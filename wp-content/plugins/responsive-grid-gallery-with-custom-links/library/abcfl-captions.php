<?php
/**
 * Caption builders
 * Version 1.1.5
 * linkdbl
*/
if ( !function_exists( 'abcfl_cptns_caption' ) ){
function abcfl_cptns_caption($capSrc, $dbRow, $customCptn=''){

    //print_r($capSrc);

    if($capSrc == 1) {return '';}
    //Custom caption
    if($capSrc == 18){
      $L2 = substr($customCptn, 0, 2);
      if($L2 == 'x|'){ $capSrc = 20; }
      if($L2 == '**'){ $capSrc = 21; }
    }
    return abcfl_cptns_txt($capSrc, $dbRow, $customCptn);
 }
}

//Get caption text based on caption source.
if ( !function_exists( 'abcfl_cptns_txt' ) ){
function abcfl_cptns_txt($capSrc, $dbRow, $customCptn, $arrayCptn=false){

    $out = '';
    $exif = '';
    if($arrayCptn){
       if($capSrc == 17) {$capSrc = 27;}
       if($capSrc == 19) {$capSrc = 29;}
    }

    switch ($capSrc) {
        case 2:
            $out = $dbRow->caption1;
            break;
        case 3:
            $out = $dbRow->caption2;
            break;
        case 4:
            $out = $dbRow->caption3;
            break;
        case 5:
            $out = $dbRow->caption4;
            break;
        case 6:
            $out = $dbRow->alt;
            break;
        case 7:
            $out = $dbRow->img_title;
            break;
        case 8:
            $out = $dbRow->description;
            break;
        case 9:
            $out = $dbRow->filename;
            break;
        case 10:
            $out = $dbRow->img_id;
            break;
        case 11:
            $out = $dbRow->sort_order;
            break;
       case 12:
            $out = abcfl_cptns_exif_cntr($exif);
            break;
        case 13:
            //$out = $latitude . ' ' . $longitude;
            $out = rtrim($dbRow->latitude_decimal , '0')  . ',&nbsp;' . rtrim($dbRow->longitude_decimal , '0');
            break;
       case 14:
            $out = abcfl_cptns_exif2_cntr($dbRow->option_value);
            break;
       case 15:
            $out = abcfl_cptns_dms($dbRow->gps_latitude_hemi, $dbRow->gps_latitude_d, $dbRow->gps_latitude_m, $dbRow->gps_latitude_s, $dbRow->gps_longitude_hemi, $dbRow->gps_longitude_d, $dbRow->gps_longitude_m, $dbRow->gps_longitude_s);
            break;
       case 16:
            $out = abcfl_cptns_fl_name($dbRow->user_id);
            break;
        case 17:
            $out = $dbRow->href1;
            break;
        case 18:
            $out = $customCptn;
            break;
        case 19:
            $out = $dbRow->hre2;
            break;
        case 20:
            $customCptn = substr($customCptn, 2);
            $out = abcfl_cptns_sball_cptn($customCptn, $dbRow);
            break;
        case 21:
            $out = abcfl_cptns_array_cptn($customCptn, $dbRow);
            break;
        case 22:
            $out = abcfl_cptns_display_name($dbRow->user_id);
            break;
        case 27:
            $out = abcfl_cptns_url($dbRow->href1, $dbRow->href1_target);
            break;
        case 29:
            $out = abcfl_cptns_url($dbRow->href2, $dbRow->href2_target);
            break;
        default:
            break;
    }

    return $out;
}
}

//=====================================================================================
//===ARRAY CAPTIONS=====================================================================
if ( !function_exists('abcfl_cptns_array_cptn') ){
function abcfl_cptns_array_cptn($cptn, $dbRow) {

    $out = '';
    $cptn = substr($cptn, 2);
    if(abcfl_html_isblank($cptn)) { return $out; }
    $cptnArray = abcfl_cptns_array_explode_with_keys($cptn);

    if(!is_array($cptnArray)) { return $out;}

    foreach ($cptnArray as $key => $val) {
        $out .= abcfl_cptns_segment($key, $val, $dbRow);
    }

    if(isset($cptn['trim'])) { $out = abcfl_cptns_trim($cptn['trim'], $out); }

    return $out;

//['txt-1'] = 'My text';
////-------------------------
//['db-1'] = **db-1||15
//['dbd-1'] = **db-1||15
////-------------------------
//$x['linkdb-1'] = '17';
//$x['linkdbd-1'] = '17';
////-------------------------
//['linktxtdb-1'] = **linktxtdb-1||Przykłady: |17
//['linktxtdb2-1'] = **linktxtdb-1||Przykłady: |17
////-------------------------
//['linkdbdb-1'] = '17|11';
//['linkdbdbd-1'] = '17|11';
////-------------------------
//['linktxt-1'] = 'Url';
//['linkurltxt-1'] = 'Url|Text.';
//['linkXXXXXX-1']||http://plfotoart.com/markery-przyklady/?setno=10|Przykłady.
//['linkurltxt-1']||http://plfotoart.com/markery-przyklady/?setno=10|Przykłady.
//-------------------------
//['txtdb-1'] = ||txtdb-1**Foto: |16
//['txtdbds-1'] =
//-------------------------
//['dbtxt-1'] = **dbtxt-1||12| Hello.
//-------------------------
//['trim'] = **trim||45

//foreach ($x as $key => $val) {
//    print "$key = $val\n";
//}
}}

//Return blank if DB part of the caption is empty
if ( !function_exists( 'abcfl_cptns_segment' ) ){
function abcfl_cptns_segment($key, $val, $dbRow) {

    $out = '';
    if(abcfl_html_isblank($val)){ return $out;}

    $keyPart = substr($key, 0, -2);

    switch ($keyPart) {
        case 'txt':
            $out = $val;
            break;
        case 'db':
            $out = abcfl_cptns_txt($val, $dbRow, '') . '&nbsp;';
            break;
        case 'dbd':
            $out = abcfl_cptns_txt($val, $dbRow, '')  . '.&nbsp;';
            break;
        case 'linkdbl':
            $out = abcfl_cptns_linkdbl($val, $dbRow, '&nbsp;');
            break;
        case 'linkdb':
            $out = abcfl_cptns_linkdb($val, $dbRow, '&nbsp;');
            break;
        case 'linkdbd':
            $out = abcfl_cptns_linkdb($val, $dbRow, '.&nbsp;');
            break;
        case 'linktxtdb':
            $out = abcfl_cptns_linktxtdb($val, $dbRow);
            break;
        case 'linktxtdb2':
            $out = abcfl_cptns_linktxtdb2($val, $dbRow);
            break;
        case 'linkdbdb':
            $out = abcfl_cptns_linkdbdb($val, $dbRow, '&nbsp;');
            break;
        case 'linkdbdbd':
            $out = abcfl_cptns_linkdbdb($val, $dbRow, '.&nbsp;');
            break;
        case 'linktxt':
            $out =  abcfl_html_a_tag($val, $val);
            break;
        case 'linkurltxt':
            $out =  abcfl_cptns_linkurltxt($val);
            break;
        case 'txtdb':
            $out = abcfl_cptns_txtdb($val, $dbRow, '&nbsp;');
            break;
        case 'txtdbd':
            $out = abcfl_cptns_txtdb($val, $dbRow, '.&nbsp;');
            break;
        case 'txtdbb':
            $out = abcfl_cptns_txtdb($val, $dbRow, '&nbsp;', true);
            break;
        case 'txtdbdb':
            $out = abcfl_cptns_txtdb($val, $dbRow, '.&nbsp;', true);
            break;
        case 'dbtxt':
            $out = abcfl_cptns_dbtxt($val, $dbRow);
            break;
        default:
            break;
    }
    return $out;
}
}

//-------------------------------------------------------------------------
if ( !function_exists( 'abcfl_cptns_linktxtdb' ) ){
function abcfl_cptns_linktxtdb($val, $dbRow){
//print_r($val);
    $parts = explode('|', $val);
    if(!is_array($parts)) {return '';}
    if(count($parts) != 2) {return '';}

    $url = abcfl_cptns_txt(intval($parts[1]), $dbRow, '', true);
//print_r($url);
    $url = abcfl_cptns_url_parts($url);

    if(abcfl_html_isblank($url['href'])) { return '';}

    $lnk = abcfl_html_a_tag($url['href'], $parts[0], $url['target']);
    return $lnk;
}}

if ( !function_exists( 'abcfl_cptns_linktxtdb2' ) ){
function abcfl_cptns_linktxtdb2($val, $dbRow){

    $parts = explode('|', $val);
    if(!is_array($parts)) {return '';}
    if(count($parts) != 2) {return '';}

    $url = abcfl_cptns_txt(intval($parts[1]), $dbRow, '', true);
    $url = abcfl_cptns_url_parts($url);
    if(abcfl_html_isblank($url['href'])) { return '';}

    $lnk = abcfl_html_a_tag($url['href'], $url['href'], $url['target']);
    return $parts[0] . $lnk;
}}

if ( !function_exists( 'abcfl_cptns_linkdbdb' ) ){
function abcfl_cptns_linkdbdb($val, $dbRow, $suffix){

    $parts = explode('|', $val);
    if(!is_array($parts)) {return '';}
    if(count($parts) != 2) {return '';}

    $url = abcfl_cptns_txt(intval($parts[0]), $dbRow, '', true);
    $url = abcfl_cptns_url_parts($url);
    if(abcfl_html_isblank($url['href'])){return '';}

    $txt = abcfl_cptns_txt(intval($parts[1]), $dbRow, '');
    if(abcfl_html_isblank($txt)){ $txt = $url['href'];}

    $lnk = abcfl_html_a_tag($url['href'], $txt, $url['target']);

    return $lnk . $suffix;
}}

if ( !function_exists( 'abcfl_cptns_linkdb' ) ){
function abcfl_cptns_linkdb($val, $dbRow, $suffix){

    $url = abcfl_cptns_txt(intval($val), $dbRow, '', true);
    $url = abcfl_cptns_url_parts($url);
    if(abcfl_html_isblank($url['href'])){return '';}

    $lnk = abcfl_html_a_tag($url['href'], $url['href'], $url['target']);
    return $lnk . $suffix;
}}

//Parse DB value into link + text. Sample: http://abcfolio.com/|Blog.
if ( !function_exists( 'abcfl_cptns_linkdbl' ) ){
function abcfl_cptns_linkdbl($val, $dbRow, $suffix){

    $dbValue = '';
    $val = intval($val);

    switch ($val) {
        case 2:
        case 3:
        case 4:
        case 5:
        case 8:
            $dbValue = abcfl_cptns_txt($val, $dbRow, '', true);
            break;
        default:
            break;
	}

	if(empty($dbValue)){ return ''; }

	$parts = explode('|', $dbValue);
	if(!is_array($parts)) {return '';}
	if(count($parts) != 2) {return '';}

	$lnk = abcfl_html_a_tag($parts[0], $parts[1] . $suffix );
	return $lnk;
}}

if ( !function_exists( 'abcfl_cptns_linkurltxt' ) ){
function abcfl_cptns_linkurltxt($val){

    $parts = explode('|', $val);
    if(!is_array($parts)) {return '';}
    if(count($parts) != 2) {return '';}

    $lnk = abcfl_html_a_tag($parts[0], $parts[1]);

    return $lnk;
}}

if ( !function_exists( 'abcfl_cptns_txtdb' ) ){
function abcfl_cptns_txtdb($val, $dbRow, $suffix, $dbBold=true){

//var_dump($val);

    $parts = explode('|', $val);
    if(!is_array($parts)) {return '';}
    if(count($parts) != 2) {return '';}

    $db = abcfl_cptns_txt($parts[1], $dbRow, '');
    //if(empty($db)){return '';}
    if(abcfl_html_isblank($db)){return '';}

    $dbValue = $db;
    if($dbBold){$dbValue = '<strong>' . $db . '</strong>';}

    return $parts[0] . $dbValue . $suffix;
}}

if ( !function_exists( 'abcfl_cptns_dbtxt' ) ){
function abcfl_cptns_dbtxt($val, $dbRow){

    $parts = explode('|', $val);
    if(!is_array($parts)) {return '';}
    if(count($parts) != 2) {return '';}

    $db = abcfl_cptns_txt(intval($parts[0]), $dbRow, '');
    if(abcfl_html_isblank($db)){return '';}

    return $db . $parts[1];
}}

//Trim caption
if ( !function_exists( 'abcfl_cptns_trim' ) ){
function abcfl_cptns_trim($trim, $caption){

    $out = $caption;
    if(abcfl_html_isblank($trim)){return $out;}
    if(!is_numeric($trim)){return $out;}

    $suffix = '...';
    $len = intval($trim);

    if(strlen($caption) > $len){ $out = substr($caption, 0, $len) . $suffix; }

    return $out;
}}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//==============================================================
//===============================================================
if ( !function_exists( 'abcfl_cptns_array_explode_with_keys' ) ){
function abcfl_cptns_array_explode_with_keys($cptn){

    $return = array();
    $pieces = explode('**',$cptn);
    foreach($pieces as $piece){
        $keyval = explode('||',$piece);
        if (count($keyval) > 1){
        $return[$keyval[0]] = $keyval[1];
        } else {
        $return[$keyval[0]] = '';
        }
    }
    return $return;

    //$cptn = 'txt-1**Foto: ||db-1**15||link-1**17|Hello.';
    //var_dump(array_explode_with_keys($val));
}}

if ( !function_exists( 'abcfl_cptns_url' ) ){
function abcfl_cptns_url($href, $target ) {

    $x['href'] = $href;
    $x['target'] = $target;
    return $x;
}
}

//Always return array. Input parameter can be array or string
if ( !function_exists( 'abcfl_cptns_url_parts' ) ){
function abcfl_cptns_url_parts($href_Target) {

    $default['href'] = '';
    $default['target'] = '';

    if(!is_array($href_Target)) {
            $default['href'] = $href_Target;
            return $default;
    }

    return wp_parse_args($href_Target, $default );
}
}


if ( !function_exists( 'abcfl_cptns_display_name' ) ){
function abcfl_cptns_display_name($user_id) {

    $usr = get_userdata( $user_id );
    $out = '';
    if($usr) { $out = $usr->display_name; }
    return $out;
}
}
if ( !function_exists( 'abcfl_cptns_fl_name' ) ){
function abcfl_cptns_fl_name($user_id) {

    $usr = get_userdata( $user_id );
    $flName = '';
    if($usr) { $flName = $usr->first_name . ' ' . $usr->last_name; }
    return $flName;
}
}

if ( !function_exists( 'abcfl_cptns_div_single_img_out_lnk' ) ){
function abcfl_cptns_div_single_img_out_lnk($gATag, $cls, $style, $skin, $clsPfix){

    if(abcfl_html_isblank($gATag)) { return '';}

    $divLinkS = abcfl_html_tag('div','', $clsPfix .'SImgGalLnk');
    $divLinkE = abcfl_html_tag_end('div');

    return  $divLinkS . $gATag . $divLinkE;
}
}
//==========================================================
if ( !function_exists( 'abcfl_cptns_dms' ) ){
function abcfl_cptns_dms($gps_latitude_hemi, $gps_latitude_d, $gps_latitude_m, $gps_latitude_s,
                 $gps_longitude_hemi, $gps_longitude_d, $gps_longitude_m, $gps_longitude_s){

    if(abcfl_html_isblank($gps_latitude_hemi)) { return '';}

    //Degrees, Minutes and Seconds DDD° MM' SS.S"
    //32° 18' 23.1" N 122° 36' 52.5" W
    return $gps_latitude_d . '&deg; ' . $gps_latitude_m . '\' ' . floatval($gps_latitude_s) . '" ' . $gps_latitude_hemi . '&nbsp; &nbsp;' .
        $gps_longitude_d . '&deg; ' . $gps_longitude_m . '\' ' . floatval($gps_longitude_s) . '" ' . $gps_longitude_hemi;
}
}

if ( !function_exists( 'abcfl_cptns_exif2_cntr' ) ){
function abcfl_cptns_exif2_cntr($exif){

    if(abcfl_html_isblank($exif)) { return '';}
    $exif = unserialize( $exif );

    $time = abcfl_cptns_exif2_item($exif, 'ExposureTime');
    $fstop = abcfl_cptns_exif2_item($exif, 'FNumber');
    $iso = abcfl_cptns_exif2_item($exif, 'ISO');

    //return '<p>' . $time . ' &nbsp; ' . $fstop . ' &nbsp; ' . $iso . '</p>';
    return $time . ' &nbsp; ' . $fstop . ' &nbsp; ' . $iso;
}
}


if ( !function_exists( 'abcfl_cptns_exif2_item' ) ){
function abcfl_cptns_exif2_item($exif, $key){

   $out = '';
   if(array_key_exists ( $key , $exif )){
       $out = abcfl_cptns_exif_lbl($key) . $exif[$key];
   }
   return $out;
}
}

if ( !function_exists( 'abcfl_cptns_exif_cntr' ) ){
function abcfl_cptns_exif_cntr($exif){

    if(abcfl_html_isblank($exif)) { return '';}
    $exif = unserialize( $exif );

    $cpntsCntrS = '<div class="abcfgtmCpntsCntr">';
    $divCol1 = '<div class="abcfgtmCpntsCol1">';
    $divCol2 = '<div class="abcfgtmCpntsCol2">';
    $col1 = '';
    $col2 = '';
    $col3 = '';
    $cpntsCntrE = '<div class="abcfClr"></div></div>';

    $col1 .= abcfl_cptns_exif_div($exif, 'ExposureTime');
    $col1 .= abcfl_cptns_exif_div($exif, 'FNumber');
    $col1 .= abcfl_cptns_exif_div($exif, 'ISO');
    if(!abcfl_html_isblank($col1)){ $col1 = $divCol1 . $col1 . '</div>'; }

    $col2 .= abcfl_cptns_exif_div($exif, 'MeteringMode');
    $col2 .= abcfl_cptns_exif_div($exif, 'ExposureMode');
    $col2 .= abcfl_cptns_exif_div($exif, 'Model');
    if(!abcfl_html_isblank($col2)){ $col2 = $divCol2 . $col2 . '</div>'; }

    $in35 = abcfl_cptns_exif_value($exif, 'FocalLengthIn35mmFilm');
    if(!abcfl_html_isblank($in35)) { $in35 = $in35 . ' in 35mm)'; }
    $col3 .= abcfl_cptns_exif_div($exif, 'FocalLength', $in35);
    $col3 .= abcfl_cptns_exif_div($exif, 'LensModel');
    $col3 .= abcfl_cptns_exif_div($exif, 'DateTimeOriginal');
    if(!abcfl_html_isblank($col3)){ $col3 = $divCol2 . $col3 . '</div>'; }

    return $cpntsCntrS  . $col1 . $col2 . $col3 . $cpntsCntrE;
}
}

if ( !function_exists( 'abcfl_cptns_exif_div' ) ){
function abcfl_cptns_exif_div($exif, $key, $suffix=''){

   $out = '';
   if(array_key_exists ( $key , $exif )){
       $out = '<div>' . abcfl_cptns_exif_lbl($key) . $exif[$key] . $suffix .'</div>';
   }
   return $out;
}
}

if ( !function_exists( 'abcfl_cptns_exif_value' ) ){
function abcfl_cptns_exif_value($exif, $key){

   $out = '';
   if(array_key_exists ( $key , $exif )){
       $out = abcfl_cptns_exif_lbl($key) . $exif[$key];
   }
   return $out;
}
}

if ( !function_exists( 'abcfl_cptns_exif_lbl' ) ){
function abcfl_cptns_exif_lbl($key){

    $out = '';
    $lbls = array(
          'Model' => 'Camera: ',
          'ExposureTime'  => 'Time: ',
          'LensModel'  => 'Lens: ',
          'ISO'  => 'ISO: ',
          'FocalLengthIn35mmFilm'  => ' (',
          'FocalLength'  => 'Focal length: ',
          'FNumber'  => 'F-stop: ',
          'MeteringMode'  => 'Metering: ',
          'ImgSize'  => 'Imgage Size: ',
          'MP'  => 'MP ',
          'ExposureMode'  => 'Exposure: ',
          'DateTimeOriginal'  => 'Date: '
      );

   //return apply_filters( 'abcfic_exif_exclude_custom', $vars );

    if(array_key_exists ( $key, $lbls )){ $out = $lbls[$key]; }
    return $out;
}
}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//====LEGACY CODE ==============================================
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//==SNOWBALL CAPTIONS=compounded=======================================================
if ( !function_exists( 'abcfl_cptns_sball_cptn' ) ){
function abcfl_cptns_sball_cptn($strParts, $dbRow) {

    //$strParts = 'x|xFoto:&nbsp;|16|x&nbsp;&nbsp;Nr:&nbsp;|10';
    //x|10|x. |16|$x. Caption1: $2$x.|#10;
    //print_r($strParts);

//# = Last part. Trim #

//# = Prefix for max lenght of the caption. Prefix # + mummber. Has to be added as a last part of the snowball caption.
//x = Prefix for literal caption.
//$x = Prefix for literal text + DB value. If DB value = blank, return empty string.

    if(abcfl_html_isblank($strParts)){ return '';}

    $caption = '';
    $stop = false;
    $parts = explode('|', $strParts);

    foreach($parts as $part) {
        if(abcfl_html_isblank($part)){ continue; }

        if(substr($part, 0, 1) == '#') {
            $caption = abcfl_cptns_sball_trim($part, $caption);
            $stop = true;
        }

        if(!$stop){
            $caption .= abcfl_cptns_sball_cptn_part($part, $dbRow);
        }
    }
    return $caption;
}
}

//Trim caption
if ( !function_exists( 'abcfl_cptns_sball_trim' ) ){
function abcfl_cptns_sball_trim($part, $caption){

    $value = substr($part, 1);

    $out = $caption;
    if(abcfl_html_isblank($value)){return $out;}
    if(!is_numeric($value)){return $out;}

    $suffix = '...';
    $len = intval($value);

    if(strlen($caption) > $len){ $out = substr($caption, 0, $len) . $suffix; }

    return $out;
}
}

//Create part of the caption content from each of the options.
if ( !function_exists( 'abcfl_cptns_sball_cptn_part' ) ){
function abcfl_cptns_sball_cptn_part($part, $dbRow) {

    if(abcfl_html_isblank($part)){ return '';}
    $out = '';
    $left1 = substr($part, 0, 1);

    //Part = literal string
    if($left1 == 'x'){ return substr($part, 1); }

    if($left1 == '$'){ return abcfl_cptns_sball_composite($part, $dbRow); }

    //Part = DB value
    if(is_numeric($part)){ return abcfl_cptns_txt(intval($part), $dbRow, ''); }

    return $out;
}
}

//Literal + DB value. If DB value = blank, return empty string
if ( !function_exists( 'abcfl_cptns_sball_composite' ) ){
function abcfl_cptns_sball_composite($compositePart, $dbRow) {

    //x|10|x. |16|$x. Caption1: $2$x.
    //x|xFoto:|16|x.  |2|3
    //x|$xFoto: $16$x.  |2|3

    //Strip leading $
    $parts = explode('$', substr($compositePart, 1));
    $out = '';

    foreach($parts as $val) {
        $part = abcfl_cptns_sball_composite_txt($val, $dbRow);

        //If DB value is blank, return empty string.
        if($part['blank']){ return ''; }
        $out .= $part['txt'];
    }
    return $out;
}
}

//Return blank if DB part of the caption is empty
if ( !function_exists( 'abcfl_cptns_sball_composite_txt' ) ){
function abcfl_cptns_sball_composite_txt($part, $dbRow) {

    $out['txt'] = '';
    $out['blank'] = true;

    if(abcfl_html_isblank($part)){ return $out;}

    //String
    $start1 = substr($part, 0, 1);
    if($start1 == 'x'){
        //Strip leading x. Return rest of the string
        $txt = substr($part, 1);
        $out['blank'] = false;
        $out['txt'] = $txt;
        return $out;
    }

    //Get value from DB. If empty, set blank = true.
    if(is_numeric($part)){
        $capSrc = intval($part);
        $txt = abcfl_cptns_txt($capSrc, $dbRow, '');

        if(abcfl_html_isblank($txt)){
            $out['txt'] = '';
            $out['blank'] = true;
            return $out;
        }
        $out['txt'] = $txt;
        $out['blank'] = false;
    }
     return $out;
}
}
