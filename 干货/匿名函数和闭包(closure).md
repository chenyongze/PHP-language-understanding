# 匿名函数和闭包(closure)
   匿名函数的定义：
```php
    $closureFunc = function(){

    　　　　....

     };

```

** 闭包 **

     将匿名函数放在普通函数中，也可以将匿名函数返回，这就构成了一个简单的闭包

```php
function closureFunc1(){
    $func = function(){
        echo "hello";
    };
    $func();
}
closureFunc1();
```