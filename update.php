<?php ini_set('display_errors','Off');

require_once 'pclzip.lib.php';

$domain = ''; // адрес для обновления

if(isset($_GET['source'])){ $source_file = $_GET['source']; }
if($source_file == ''){return;}

$output_file = basename($source_file);

if($domain != ''){ if($output_file != str_replace('http://', '', str_replace('.webflow.io/', '.zip', $domain))) 
{ header("Location: ".$_SERVER['HTTP_REFERER']); die; }}

curl_download($source_file, $output_file);

$zip = new PclZip($output_file);
$result = $zip->extract(PCLZIP_OPT_REPLACE_NEWER);

header("Location: ".$_SERVER['HTTP_REFERER']);

function curl_download($url, $file)
{
    $dest_file = @fopen($file, "w");
    $resource = curl_init();
    curl_setopt($resource, CURLOPT_URL, $url);
    curl_setopt($resource, CURLOPT_FILE, $dest_file);
    curl_setopt($resource, CURLOPT_HEADER, 0);
    curl_exec($resource);
    curl_close($resource);
    fclose($dest_file);
}
?>