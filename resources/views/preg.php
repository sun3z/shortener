<?php 


$pattern = "/(http[s]{0,1}|ftp)://[a-zA-Z0-9\\.\\-]+\\.([a-zA-Z]{2,4})(:\\d+)?(/[a-zA-Z0-9\\.\\-~!@#$%^&*+?:_/=<>]*)?/";
$pattern2 = "/^(http[s]{0,1}:\\/\\/)?[a-zA-Z0-9\\.\\-]+\.([a-zA-Z]{2,4})(:\\d+)?(\\/[a-zA-Z0-9\\.\\-~!@#$%^&*+?:_\\/=<>]*)?$/";
$pattern3 = "/^(http[s]?)/";


var_dump(preg_match($pattern3, 'http://www.com.cn:8/a'));
var_dump(preg_match($pattern3, 'a.cn'));

// var_dump(preg_replace($pattern3, subject))

echo mt_rand(1000, 9999);
