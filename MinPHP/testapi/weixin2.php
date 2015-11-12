<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 15-3-30
 * Time: 14:18
 */
//echo urlencode("http://test.jingqubao.com/testapi/weixin2.php");
//print_r($_REQUEST);
//https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code

//提交数据
function socket_post($url, $postdata=array(), $files=array()) {
    $boundary = '-------'.substr(md5(rand(0,32000)),0,10);
    $encoded = "";
    if($postdata){
        while(list($k,$v) = each($postdata)){
            $encoded .= "--$boundary\r\nContent-Disposition: form-data;
			name=\"".rawurlencode($k)."\"\r\n\r\n";
            $encoded .= rawurlencode($v)."\r\n";
        }
    }
    if($files){
        foreach($files as $name=>$file){
            $ext= strtolower(strrchr($file,"."));
            switch($ext){
                case '.gif': $type = "image/gif"; break;
                case '.jpg': $type = "image/jpeg"; break;
                case '.png': $type = "image/png";
                    break; default: $type = "image/jpeg";
            }
            $encoded .= "--$boundary\r\nContent-Disposition: form-data;
			name=\"".rawurlencode($name)."\";
			filename=\"$file\"\r\nContent-Type: $type\r\n\r\n";
            $encoded .= join("", file($file)); $encoded .= "\r\n";
        }
    }
    $encoded .= "--$boundary--\r\n";
    $length = strlen($encoded);
    $uri = parse_url($url);
    $fp = fsockopen($uri['host'], $uri['port'] ? $uri['port'] : 80);
    if(!$fp) return "Failed to open socket to ".$uri['host'];
    fputs($fp, sprintf("POST %s%s%s HTTP/1.0\r\n", $uri['path'], $uri['query'] ? "?" : "", $uri['query']));
    fputs($fp, "Host: ".$uri['host']."\r\n");
    fputs($fp, "Content-type: multipart/form-data; boundary=$boundary\r\n");
    fputs($fp, "Content-length: $length\r\n");
    fputs($fp, "Connection: close\r\n\r\n");
    fputs($fp, $encoded);
    $results = "";
    while(!feof($fp)){
        $results .= fgets($fp,1024);
    }
    fclose($fp);
    return preg_replace('/^HTTP(.*?)\r\n\r\n/s','',$results);
}
//获取数据
function c_file_get_contents($durl){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $durl);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);
    curl_setopt($ch, CURLOPT_REFERER,_REFERER_);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $r = curl_exec($ch);
    curl_close($ch);
    return $r;
}


//define your token
define("TOKEN", "111111");
define("appid","wx203d7eb29a78bce8");
define("appsecret","94a32b0fd3098d628b019817b23d1075");

$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . appid . "&secret=" . appsecret;
$json = $this->http_request_json($url);
$data = json_decode($json, true);

die;
//print_r($_REQUEST);die;
//code存在，获取openid
if($_GET["code"]){
    $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".appid."&secret=".appsecret."&code=".$_GET["code"]."&grant_type=authorization_code";
    $result=c_file_get_contents($url);
    $result=json_decode($result,true);
    $openid=$result["openid"];
    $access_token=$result["access_token"];
}
//$access_token="OezXcEiiBSKSxW0eoylIeEkH57iStkl2HF-5eSKJh4VSnDJJfopasw3cefmqV-cMAlb1y6VG3bQGvXhUV8xqYv9Ycn7VDOca9y36PhVLPtz7IUET963BZWDLTfW3Q63k_n0eMgrNNgN41U8ns4zN3A";
//if($access_token){//根据openid获取用户信息
    $url="https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
    $result=c_file_get_contents($url);
    $result=json_decode($result,true);
    print_r($result);die;
//}

?>