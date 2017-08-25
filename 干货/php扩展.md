# php扩展
    为什么要用C扩展

    C是静态编译的，执行效率比PHP代码高很多。同样的运算代码，使用C来开发，性能会比PHP要提升数百倍。

    另外C扩展是在进程启动时加载的，PHP代码只能操作Request生命周期的数据，C扩展可操作的范围更广。


   下载PHP7.1.1扩展

   1.下载地址： http://php.net/get/php-7.1.1.tar.bz2/from/a/mirror

   2.下载后进行解压

   创建扩展骨架

   ##本例用的是php7.1.1
   cd ext
   ./ext_skel --extname=helloworld


       Creating directory helloworld
       Creating basic files: config.m4 config.w32 .gitignore helloworld.c php_helloworld.h CREDITS EXPERIMENTAL tests/001.phpt helloworld.php [done].

       To use your new extension, you will have to execute the following steps:

       1.  $ cd ..
       2.  $ vi ext/helloworld/config.m4
       3.  $ ./buildconf
       4.  $ ./configure --[with|enable]-helloworld
       5.  $ make
       6.  $ ./sapi/cli/php -f ext/helloworld/helloworld.php
       7.  $ vi ext/helloworld/helloworld.c
       8.  $ make

       Repeat steps 3-6 until you are satisfied with ext/helloworld/config.m4 and
       step 6 confirms that your module is compiled into PHP. Then, start writing
       code and repeat the last two steps as often as necessary.

