<?php
/**
 * http://blog.csdn.net/zzz_781111/article/details/9146999
 * Created by sapphire.php@gmail.com
 * User: yongze
 * Date: 2017/8/16
 * Time: 下午4:44
 * PHP中利用Redis管道加快执行 [pipeline]
 */
include './lib/redis-config.php';
function demo_multi(){
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);
    $pipe = $redis->multi(Redis::PIPELINE);
    for ($i = 1; $i <=  4; $i++) {
//    $pipe->set("key::$i", str_pad($i, 4, '0', 0));
        $pipe->get("yz-{$i}");
    }

    $replies = $pipe->exec();
    echo " ";
    print_r($replies);
}

//demo_multi();



function dev_lots_pre(){
    $starttime = explode(' ',microtime());
    $funName = __FUNCTION__;
//    echo "\n {$funName}:". microtime();

    $redis = new Redis();
    $redis->connect(HOST, PORT);
    $redis->auth(AUTH);
    $needleArr = [
        'personage_auction:hash:245:lotid:1406',
        'personage_auction:hash:226:lotid:1389',
        'personage_auction:hash:311:lotid:1478',
        'personage_auction:hash:323:lotid:1497',
        'personage_auction:hash:260:lotid:1408',
        'personage_auction:hash:224:lotid:1384',
        'personage_auction:hash:328:lotid:1502',
        'personage_auction:hash:290:lotid:1450',
        'personage_auction:hash:307:lotid:1468',
        'personage_auction:hash:328:lotid:1509',
        'personage_auction:hash:325:lotid:1507',
        'personage_auction:hash:259:lotid:1414',
        'personage_auction:hash:308:lotid:1458',
        'personage_auction:hash:296:lotid:1451',
        'personage_auction:hash:218:lotid:1371',
        'personage_auction:hash:325:lotid:1509',
        'personage_auction:hash:306:lotid:1466',
        'personage_auction:hash:266:lotid:1426',
        'personage_auction:hash:299:lotid:1460',
        'personage_auction:hash:311:lotid:1467',
        'personage_auction:hash:313:lotid:1478',
        'personage_auction:hash:221:lotid:1381',
        'personage_auction:hash:333:lotid:1510',
        'personage_auction:hash:300:lotid:1461',
        'personage_auction:hash:331:lotid:1524',
        'personage_auction:hash:328:lotid:1503',
        'personage_auction:hash:266:lotid:1425',
        'personage_auction:hash:323:lotid:1490',
        'personage_auction:hash:306:lotid:1467',
        'personage_auction:hash:271:lotid:1437',
        'personage_auction:hash:257:lotid:1408',
        'personage_auction:hash:310:lotid:1474',
        'personage_auction:hash:270:lotid:1434',
        'personage_auction:hash:234:lotid:1387',
        'personage_auction:hash:266:lotid:1415',
        'personage_auction:hash:309:lotid:1472'
    ];
    foreach ($needleArr as $v){
        $res[] = $redis->hGetAll($v);
    }

    $endtime = explode(' ',microtime());
    $thistime = $endtime[0]+$endtime[1]-($starttime[0]+$starttime[1]);
    $thistime = round($thistime,3);
//    print_r($res);
//    echo "\n执行耗时：".$thistime." 秒。".time();

    return $thistime;
}

//
//
//
//dev_lots_pre();
//dev_lots_pre();
//dev_lots_pre();
//dev_lots_pre();
//dev_lots_pre();
//dev_lots_pre();
//dev_lots_pre();
//dev_lots_pre();
//dev_lots_pre();
//dev_lots_pre();





/**
 *     'SESSION_REDIS_HOST'=>  '114.215.43.178', //分布式Redis,默认第一个为主服务器
'SESSION_REDIS_PORT'=>  '7379',       //端口,如果相同只填一个,用英文逗号分隔
'SESSION_REDIS_DBINDEX'=>  8,       //select db
'SESSION_REDIS_AUTH'    =>  'u&RYqLhY*06OuKW$Vye0',    //Redis auth认证(密钥中不能有逗号),如果相同只填一个,用英文逗号分隔 );

 */
function dev_lots(){
    $starttime = explode(' ',microtime());
    $funName = __FUNCTION__;
//    echo "\n {$funName}:". microtime();
    $redis = new Redis();
    $redis->connect(HOST, PORT);
    $redis->auth(AUTH);
    $pipe = $redis->multi(Redis::PIPELINE);
    $needleArr = [
        'personage_auction:hash:245:lotid:1406',
        'personage_auction:hash:226:lotid:1389',
        'personage_auction:hash:311:lotid:1478',
        'personage_auction:hash:323:lotid:1497',
        'personage_auction:hash:260:lotid:1408',
        'personage_auction:hash:224:lotid:1384',
        'personage_auction:hash:328:lotid:1502',
        'personage_auction:hash:290:lotid:1450',
        'personage_auction:hash:307:lotid:1468',
        'personage_auction:hash:328:lotid:1509',
        'personage_auction:hash:325:lotid:1507',
        'personage_auction:hash:259:lotid:1414',
        'personage_auction:hash:308:lotid:1458',
        'personage_auction:hash:296:lotid:1451',
        'personage_auction:hash:218:lotid:1371',
        'personage_auction:hash:325:lotid:1509',
        'personage_auction:hash:306:lotid:1466',
        'personage_auction:hash:266:lotid:1426',
        'personage_auction:hash:299:lotid:1460',
        'personage_auction:hash:311:lotid:1467',
        'personage_auction:hash:313:lotid:1478',
        'personage_auction:hash:221:lotid:1381',
        'personage_auction:hash:333:lotid:1510',
        'personage_auction:hash:300:lotid:1461',
        'personage_auction:hash:331:lotid:1524',
        'personage_auction:hash:328:lotid:1503',
        'personage_auction:hash:266:lotid:1425',
        'personage_auction:hash:323:lotid:1490',
        'personage_auction:hash:306:lotid:1467',
        'personage_auction:hash:271:lotid:1437',
        'personage_auction:hash:257:lotid:1408',
        'personage_auction:hash:310:lotid:1474',
        'personage_auction:hash:270:lotid:1434',
        'personage_auction:hash:234:lotid:1387',
        'personage_auction:hash:266:lotid:1415',
        'personage_auction:hash:309:lotid:1472'
    ];
    foreach ($needleArr as $v){
        $pipe->hGetAll($v);
    }

    $replies = $pipe->exec();
    $endtime = explode(' ',microtime());
    $thistime = $endtime[0]+$endtime[1]-($starttime[0]+$starttime[1]);
    $thistime = round($thistime,3);
//    print_r($replies);
//    echo "\n执行耗时：".$thistime." 秒。".time();
    return $thistime;
}

//dev_lots();
//dev_lots();
//dev_lots();
//dev_lots();
//dev_lots();
//dev_lots();
//dev_lots();
//dev_lots();
//dev_lots();
//dev_lots();
//dev_lots();
//dev_lots();
//dev_lots();
//dev_lots();
for ($i=0 ;$i<=10 ;$i++){
    $arr[] = dev_lots();
}
print_r($arr);
print_r(array_sum($arr)/count($arr));

