<?php
// 解析xml
$file = "./public/baidusitemap.xml";
$xml = simplexml_load_file($file);
$urls = array();
foreach ($xml as $key => $value) {
    $url = array();
    $url = (array) $value->loc;
    $urls[] = current($url);
}
// 调用百度API
$api = 'http://data.zz.baidu.com/urls?site=https://qytayh.github.io&token=KXPzyqnAxEvFc9NJ';;
$ch = curl_init();
$options =  array(
    CURLOPT_URL => $api,
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => implode("\n", $urls),
    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
);
curl_setopt_array($ch, $options);
$result = curl_exec($ch);
// 返回结果记录
$time = date("Y-m-d H:i:s");
$content = $time . " --- " . $result . PHP_EOL;
$file = "push_sitemap.log";
$fp = fopen($file, "a+") or die("fail to open the file");
fwrite($fp, $content);
fclose($fp);

