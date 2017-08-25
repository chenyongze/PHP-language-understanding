# RabbitMq简单应用
服务端：
```
<?php
//配置信息
$conn_args = array(
    'host' => '127.0.0.1',
    'port' => '5672',
    'login' => 'guest',
    'password' => 'guest',
    'vhost'=>'/'
);
$e_name = 'switch_name'; //交换机名
//$q_name = 'queue_name'; //无需队列名
$k_route = 'route_key'; //路由key

//创建连接和channel
$conn = new AMQPConnection($conn_args);
if (!$conn->connect()) {
    die("Cannot connect to the broker!\n");
}
$channel = new AMQPChannel($conn);

//创建交换机对象
$ex = new AMQPExchange($channel);
$ex->setName($e_name);

//发送消息
$channel->startTransaction(); //开始事务
for ($i=1; $i < 5; $i++) {
    //消息内容
    $message = "这是消息".rand(1000,9999).',发送时间：'.date('Y-m-d H:i:s',time());
    echo "Send Message:".$ex->publish($message, $k_route)."\n";
}

$channel->commitTransaction(); //提交事务

$conn->disconnect();
```

客户端：
```
<?php
//配置信息
$conn_args = array(
    'host' => '127.0.0.1',
    'port' => '5672',
    'login' => 'guest',
    'password' => 'guest',
    'vhost'=>'/'
);
$e_name = 'switch_name'; //交换机名
$q_name = 'queue_name'; //队列名
$k_route = 'route_key'; //路由key

//创建连接和channel
$conn = new AMQPConnection($conn_args);
if (!$conn->connect()) {
    die("Cannot connect to the broker!\n");
}
$channel = new AMQPChannel($conn);

//创建交换机
$ex = new AMQPExchange($channel);
$ex->setName($e_name);
$ex->setType(AMQP_EX_TYPE_DIRECT); //direct类型
$ex->setFlags(AMQP_DURABLE); //持久化
echo "Exchange Status:".$ex->declare()."\n";

//创建队列
$q = new AMQPQueue($channel);
$q->setName($q_name);
$q->setFlags(AMQP_DURABLE); //持久化
echo "Message Total:".$q->declare()."\n";

//绑定交换机与队列，并指定路由键
echo 'Queue Bind: '.$q->bind($e_name, $k_route)."\n";

//阻塞模式接收消息
echo "Message:\n";
while(True){
    $q->consume('processMessage');
    // $q->consume('processMessage', AMQP_AUTOACK); //自动ACK应答
}
$conn->disconnect();

/**
 * 消费回调函数
 * 处理消息
 */
function processMessage($envelope, $queue) {
    $msg = $envelope->getBody();
    echo $msg."\n"; //处理消息
    $queue->ack($envelope->getDeliveryTag()); //手动发送ACK应答
}
```