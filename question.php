<?php
/*
    *  上学吧链接获取答案API接口
    *  1.0版本只能通过链接获取
    *  获取方式：REQUEST
    -  提交参数：url, class
    -  参数说明：url为上学吧链接
    -  class为输出结果参数，设置为kyz则直接输出答案
    *  请定时更新cookie值

    @author 中国DLAY
    @email zsxianoo@qq.com
    @weixin zs1692548226

*/


//获取当前时间戳
// +-----------------------------------------------------------------------
$unix = time();

//接受数据
// +-----------------------------------------------------------------------
$url = $_REQUEST['url'];
$class = $_REQUEST['class'];

//设置COOKIE
// +-----------------------------------------------------------------------
$cookie = 'sxbkefu=http://m.shangxueba.com/kefu/WeChatCode.htm; Hm_lvt_ca3532872d4922976ae77c7810c4fd7d=1629963734; sxbuid=1629963739-2f0fc9bc14b04a57a318821eb576ab21; anythe2Info=anythe2cday=13542300243&anythe2pday=D7D48E0C7A86CC5FEC0CAC1302887DBB&anythe2pid=67387497&loginDate=2021/8/28 10:50:12; Hm_lvt_ccdda4ee34254acf0834dc87f2429bc8=1629802246,1629956334,1629962877,1630119014; Hm_lpvt_ccdda4ee34254acf0834dc87f2429bc8=1630119031';

//加载httplib库
// +-----------------------------------------------------------------------
include 'dlay/httplib.php';

//实例化httplib
// +-----------------------------------------------------------------------
$http = new httplib();

//设置超时时间
// +-----------------------------------------------------------------------
$http->set_timeout(10);


//开始判断xueli，jxjy
// +-----------------------------------------------------------------------
if(strpos($url, "xueli.shangxueba.com") !== false){
    //xueli question
    // +-----------------------------------------------------------------------
    //echo 'xueli questions';
    //开始获取id
    // +-----------------------------------------------------------------------
    $str = substr($url, 29);
    $id = str_replace('.html', '', $str);

    $answerurl = 'https://xueli.shangxueba.com/GetAnswer.ashx?id='.$id.'&t='.$unix;

    //设置cookie
    // +-----------------------------------------------------------------------
    $http->set_cookie($cookie);

    //请求http
    // +-----------------------------------------------------------------------
    $http->request($answerurl);

    //获取数据
    // +-----------------------------------------------------------------------
    $answer = $http->get_data();
    $array = json_decode($answer, true);
    $Context = $array['data'][0]['Context'];
    //判断class是否为kyz，是则直接输出答案，否则输出json数据
    // +-----------------------------------------------------------------------
    if ($class == 'kyz') {
        echo $Context;
    } else{
        echo $answer;
    }
    

//下面为jxjy
// +-----------------------------------------------------------------------
} elseif(strpos($url, "jxjy") !== false){
    //jxjy question
    // +-----------------------------------------------------------------------
    //echo 'jxjy questions';
    //开始获取id
    // +-----------------------------------------------------------------------
    $str = substr($url, 29);
    $id = str_replace('.html', '', $str);

    $answerurl = 'https://www.shangxueba.com/jxjy/GetAnswer.ashx?id='.$id.'&t='.$unix;

    //设置cookie
    // +-----------------------------------------------------------------------
    $http->set_cookie($cookie);

    //请求http
    // +-----------------------------------------------------------------------
    $http->request($answerurl);

    //获取数据
    // +-----------------------------------------------------------------------
    $answer = $http->get_data();
    $array = json_decode($answer, true);
    $Context = $array['data'][0]['Context'];
    //判断class是否为kyz，是则直接输出答案，否则输出json数据
    // +-----------------------------------------------------------------------
    if ($class == 'kyz') {
        echo $Context;
    } else{
        echo $answer;
    }

//下面为zhishi
// +-----------------------------------------------------------------------
} elseif(strpos($url, "zhishi.shangxueba.com") !== false){
    //zhishi question
    // +-----------------------------------------------------------------------
    //echo 'zhishi questions';
    //开始获取id
    // +-----------------------------------------------------------------------
    $str = substr($url, 30);
    $id = str_replace('.html', '', $str);

    $answerurl = 'https://zhishi.shangxueba.com/GetAnswer.ashx?id='.$id.'&t='.$unix;

    //设置cookie
    // +-----------------------------------------------------------------------
    $http->set_cookie($cookie);

    //请求http
    // +-----------------------------------------------------------------------
    $http->request($answerurl);

    //获取数据
    // +-----------------------------------------------------------------------
    $answer = $http->get_data();
    $array = json_decode($answer, true);
    $Context = $array['data'][0]['Context'];
    //判断class是否为kyz，是则直接输出答案，否则输出json数据
    // +-----------------------------------------------------------------------
    if ($class == 'kyz') {
        echo $Context;
    } else{
        echo $answer;
    }

//下面为www
// +-----------------------------------------------------------------------
} elseif(strpos($url, "www.shangxueba.com") !== false){
    //www question
    // +-----------------------------------------------------------------------
    //echo 'www questions';
    //开始获取id
    // +-----------------------------------------------------------------------
    $str = substr($url, 31);
    $id = str_replace('.html', '', $str);

    $answerurl = 'https://www.shangxueba.com/ask/ajax/zuijiainfo.aspx?id='.$id.'&t='.$unix;

    //设置cookie
    // +-----------------------------------------------------------------------
    $http->set_cookie($cookie);

    //请求http
    // +-----------------------------------------------------------------------
    $http->request($answerurl);

    //获取数据
    // +-----------------------------------------------------------------------
    $str = $http->get_data();
    $answer = htmlentities($http->get_data());
    $start = mb_strpos($str, '<div class="xj_contextinfo">');
    $end = mb_strpos($str, '</h6>');
    $Context = mb_substr($str, $start+30, $end-$start-1);
    //判断class是否为kyz，是则直接输出答案，否则输出html数据
    // +-----------------------------------------------------------------------
    if ($class == 'kyz') {
        echo $Context;
    } else{
        echo $answer;
    }

} else{
    echo '获取类型失败！';
}



?>