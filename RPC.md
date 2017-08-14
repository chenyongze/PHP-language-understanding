# rpc是什么？php中流行的rpc框架有哪些
# rpc之远程调用框架

>什么是rpc框架
先回答第一个问题：什么是RPC框架？ 如果用一句话概括RPC就是：远程调用框架（Remote Procedure Call）

那什么是远程调用？

通常我们调用一个PHP中的方法，比如这样一个函数方法: localAdd(10, 20)，localAdd方法的具体实现要么是用户自己定义的，要么是php库函数中自带的，也就说在localAdd方法的代码实现在本地，它是一个本地调用！

远程调用意思就是：被调用方法的具体实现不在程序运行本地，而是在别的某个远程地方。

远程调用原理

比如 A (client) 调用 B (server) 提供的remoteAdd方法：

首先A与B之间建立一个TCP连接；

然后A把需要调用的方法名（这里是remoteAdd）以及方法参数（10， 20）序列化成字节流发送出去；

B接受A发送过来的字节流，然后反序列化得到目标方法名，方法参数，接着执行相应的方法调用（可能是localAdd）并把结果30返回；

A接受远程调用结果,输出30。

RPC框架就是把我刚才说的这几点些细节给封装起来，给用户暴露简单友好的API使用。

远程调用的好处

解耦：当server需要对方法内实现修改时，client完全感知不到，不用做任何变更；这种方式在跨部门，跨公司合作的时候经常用到，并且方法的提供者我们通常称为：服务的暴露。

RPC与Socket有什么区别？

通过上面的简单阐述，好像RPC与Socket 好像啊。都是调用远程的方法，都是client/server模式，我之前也写了一篇文章: 细说socket 那他们有啥区别呢?

RPC（远程过程调用）采用客户机/服务器模式实现两个进程之间相互通信。socket是RPC经常采用的通信手段之一，RPC是在Socket的基础上实现的，它比socket需要更多的网络和系统资源。除了Socket，RPC还有其他的通信方法，比如：http、操作系统自带的管道等技术来实现对于远程程序的调用。微软的Windows系统中，RPC就是采用命名管道进行通信。

RPC与REST有什么区别？

通过了解RPC后，我们知道是RPC是client/server模式的，调用远程的方法，REST也是我们熟悉的一套API调用协议方法，它也是基于client/server模式的，调用远程的方法的，那他俩又有啥区别呢？

REST API 和 RPC 都是在 Server端 把一个个函数封装成接口暴露出去，以供 Client端 调用，不过 REST API 是基于HTTP协议的，REST致力于通过http协议中的POST/GET/PUT/DELETE等方法和一个可读性强的URL来提供一个http请求。而 RPC 则可以不基于 HTTP协议
因此，如果是后端两种语言互相调用，用 RPC 可以获得更好的性能（省去了 HTTP 报头等一系列东西），应该也更容易配置。如果是前端通过 AJAX 调用后端，那么用 REST API 的形式比较好（因为无论如何也避不开 HTTP 这道坎）。

php中流行的rpc框架有哪些

既然php是世界上最好的语言，那php中流行的RPC框架有哪些呢？

先列举下： phprpc，yar, thrift, gRPC, swoole, hprose

因为时间和精力有限，不可能一个一个的去学习和使用，我选几个世面上用的最多的几个用下吧。因为RPC原理是一样的，都是Client/Server模式，只是每个框架的使用方式不一样而已。

主要讲解一下 phprpc 和 yar 是我目前听说和接触最多的了。

phprpc

先从官网下载最新稳定版的phprpc:下载链接 解压。

安装

我们会发现里面有很多文件和文件夹，结构如下：

dhparams/
pecl/
bigint.php
compat.php
phprpc_date.php
xxtea.php
dhparams.php
phprpc_server.php
phprpc_client.php
其中有dhparams和pecl是文件夹，pecl中的是php的xxtea扩展，按照官网的描述，可以安装也可以不安装，不安装phprpc也是可以运行的。但是如果你需要更快的加密处理能力，可以安装下。

我还是安装吧。毕竟加密能力更快，是好事：

安装步骤如下，先将pecl下的xxtea文件夹复制到php源码的etx目录：/lamp/php-5.4.11/ext下。然后用phpize进行扩展重新编译。

[root@localhost /]# cd /lamp/php-5.4.11/ext/xxtea
[root@localhost xxtea]# /usr/local/php/bin/phpize
[root@localhost xxtea]# ./configure --enable-xxtea=shared --with-php-config=/usr/local/php/bin/php-config
make && make install
OK ,编译完成，提示我们xxtea.so已经在/usr/local/php/lib/php/extensions/no-debug-zts-20100525/xxtea.so 下了。

下面，我们就需要在php.ini的最后将这个xxtea.so加上：

[root@localhost /]# vi /usr/local/php/etc/php.ini

[xxtea]
extension=xxtea.so
好。加好了后，我们需要重启下apache或者php-fpm

重启apache
[root@localhost /]# /usr/local/apache/bin/apachectl restart

平滑重启php-fpm
kill -USR2 `cat /usr/local/php/var/run/php-fpm.pid`
重启完毕后，打开phpinfo()页面，搜索一下，应该就能够看到xxtea了。

开始使用

先来个简单的例子，phprpc也是分为服务器端和客户端的。所以文件夹中对应的就是phprpc_server.php 和 phprpc_client.php

我们参考官网的几个例子，练习下：

server.php 服务端：这样写就完成了一个最简单的helloword的接口。

<?php
include ("phprpc/phprpc_server.php");
function HelloWorld() {
    return 'Hello World!';
}
$server = new PHPRPC_Server();
$server->add('HelloWorld');
$server->start();
运行下server.php，我擦，居然报错了！！！

PHP Strict Standards:  Non-static method PHPRPC_Server::initSession()....
Cannot redeclare gzdecode().....
google了下，说是先把 phprpc_server.php的413行的initSession()改成static function

 static function initSession() {
    ****
 }
PS. 我了个擦，这么大的错误，phprpc是怎么发布的！！！

在把compat.php 的第 71行的 gzdecode()函数，php5.4已经实现了这个函数了。这样函数就被重写了，就报错了，所以加个判断：

if (!function_exists('gzdecode')) {
    //将gzdecode函数包括进来
}
好。改完，保存。再运行下server.php 。ok 了。不报错了。输出：

phprpc_functions="YToxOntpOjA7czo5OiJoZWxsb3dvcmQiO30=";
我们接下来写客户端 client.php, 看是如何写的？

<?php
include ("phprpc/phprpc_client.php");
$client = new PHPRPC_Client('http://127.0.0.1/server.php');
echo $client->HelloWorld();
?>
我们在执行以下client.php，如愿以偿的输出了：

Hello Word!
这样一个简单的Server/Clent交付就搞定了。虽然中间出了点差错，但是总体来说还是蛮简单易懂的!

其他的更高级的用法可以参考官网的。

yar

yar 是国内著名的php大神鸟哥惠新宸的大作，在微博产品中已经开始使用。它也是一款rpc框架。它由于使用纯C编写的用于php的扩展，所以，效率应该是蛮高的，而且支持异步并行，这点还是赞的。

下载安装

官网下载：http://pecl.php.net/package/yar 最新的版本 yar-1.2.4.tgz

然后解压复制到php源码的etx目录：/lamp/php-5.4.11/ext下。然后用phpize进行扩展重新编译。

[root@localhost yar-1.2.4]# /usr/local/php/bin/phpize
[root@localhost yar-1.2.4]# ./configure --with-php-config=/usr/local/php/bin/php-config
但是出现了点问题：提示，curl 有问题：

configure: error: Please reinstall the libcurl distribution - easy.h should be in <curl-dir>/include/curl/
估计是我本机curl 有问题，那用yum 安装一下吧：

yum -y install curl-devel
安装完成curl 后继续编译安装，就没啥问题了：

[root@localhost yar-1.2.4]# /usr/local/php/bin/phpize
[root@localhost yar-1.2.4]# ./configure --with-php-config=/usr/local/php/bin/php-config
[root@localhost yar-1.2.4]# make && make install
成功之后，提示我们 yar.so 扩展在已经在/usr/local/php/lib/php/extensions/no-debug-zts-20100525/ 下了。

我们vi编辑一下 php.ini ,最后面加上yar.so扩展，然后重启一下 apache 或者php-pfm就可以了。

[root@localhost /]# vi /usr/local/php/etc/php.ini

[yar]
extension=yar.so
好。加好了后，我们需要重启下apache或者php-fpm

重启apache
[root@localhost /]# /usr/local/apache/bin/apachectl restart

平滑重启php-fpm
kill -USR2 `cat /usr/local/php/var/run/php-fpm.pid`
重启完毕后，打开phpinfo()页面，搜索一下，应该就能够看到yar了。

开始使用

和其他的rpc框架一样，yar也是server/client模式，所以，我们也一样，开始写一个简单的例子来说下如何调用。

yar_server.php表示服务器端

<?php
class API {
    public function api($parameter, $option = "foo") {
        return $parameter;
    }
    protected function client_can_not_see() {
    }
}
$service = new Yar_Server(new API());
$service->handle();
好，我们在浏览器里运行一下，就会出现如下图所示的输出。很高端啊！！！鸟哥说这样做的用途是可以一目了然的知道我这个rpc提供了多少接口，把api文档都可以省略了。

此处输入图片的描述

好，我们开始写yar_client.php 这个是客户端：

$client = new Yar_Client("http://127.0.0.1/yar_server.php");
echo $client->api('helo word');
好，像其他的 swoole，hprose等基本都是这个原理，只是看谁的功能更加，用起来更顺手罢了。

done!