<?php
/**
 * Created by sapphire.php@gmail.com
 * User: yongze
 * Date: 2017/8/18
 * Time: 下午11:27
 * 闭包 匿名
 */

$closureFunc = function($str){

     echo $str;

};

$closureFunc("hello world!");


function closureFunc1(){
    $func = function(){
        echo "hello";
    };
    $func();
}

closureFunc1();


function closureFunc2(){
    $num = 1;
    $func = function() use($num){
        echo $num;
    };
    $func();
}

closureFunc2();
//Notice: Undefined variable: num



function closureFunc3(){
    $num = 1;
    $func = function() use($num){
        echo $num;
    };
    return $func;
}
$func = closureFunc3(); //函数返回匿名函数
$func(); //然后我们在用$func() 调用



function closureFunc4(){
    $num = 1;
    $func = function($str,$k) use($num){
        echo $num;
        echo "\n";
        echo $str;
        echo $k;
    };
    return $func;
}
$func = closureFunc4();
$func("hello, closure4",'xxx');


echo "========\n";

function callFunc($func){
    $func("argvxxx");
}

callFunc(function($str){
    echo $str;
});




function myfunction($value,$key)
{
    echo "The key $key has the value $value<br>";
}
$a=array("a"=>"red","b"=>"green","c"=>"blue");
array_walk($a,"myfunction");


echo "==========\n";
//$kb = ['x','y'];
//$b = new stdClass();
$b = @ (object) $kb;
$b->d = 'dddddddddd';
$b->h = 'b';
$b->z = 'zzzzzzzzzz';
print_r($b);

echo "==========\n";

function am(&$x){
//    echo '-';
//    echo $x;
//    print_r($x);
    if($x == 'b'){
        unset($x);
    }else{
        return $x;
    }
}

$x = array_map('am',(array)$b);

print_r($x);
die;

echo "==========\n";


$arr = [
    ['id'=>45,'name'=>'x','data'=>'bbbbbbbbbb'],
    ['id'=>4,'name'=>'y','data'=>'ddddbbbbb'],
    ['id'=>6,'name'=>'a','data'=>'ddddbbbbb'],
    ['id'=>8,'name'=>'b','data'=>'ddddbbbbb'],
    'x'=>['id'=>67,'name'=>'z','data'=>'ddddbbbbb'],
];

function yz(&$v,&$key,$x) {
//    print_r($argv);
//    echo $key;
    $v['data'] .= $x[0].'-xxxx';
//    $v="yellow";
//    $key=$v['id'];
};
array_walk($arr,"yz",['xxxx','bbbbb']);
print_r($arr);


echo "=========== yzh \n";
function yzh(&$v,&$z,&$i) {
    $v['id'] .= '-'.$i.'-xxxx';
    $i++;
};
print_r(array_walk($arr,'yzh',5));
print_r($arr);





function ak(  $a,$b){
    print_r($a['m']);
    print_r($b->m);
}


$obj = new stdClass();
$obj->m = 'xxxxxx';
$obj->n = 'qqqqqqq';
print_r($obj);
$b = $obj;
ak((array)$obj,$b);




function dh($v){
    return "=========>".$v['name'];
}
print_r(array_map("dh",$arr));
print_r(array_keys(array_map("dh",$arr)));
print_r(implode(',',array_values(array_map("dh",$arr))));





class ArrayWalk {
    /**
     * properties:
     */
    private $body_chunk = array('0'=>['id'=>'Dewen'], '1'=>['id'=>'PHP'], 2=>['id'=>'Linux']);
    /////////////////////////////////////////////////
    // VARIABLE METHODS
    /////////////////////////////////////////////////
    public function ArrayWalkx (){

    }

    public function func_1(){
        print_r($this->body_chunk);
        array_walk ($this->body_chunk, array($this,'SpellStrToLower'),$this->body_chunk);
        print_r($this->body_chunk);
    }
    public function SpellStrToLower (&$str){
        if($str['id'] == 'php'){
//            countine;
//            unset($str);
//            continue;
//            break;
            exit(1);
        }
        $str['id'] = strtolower ($str['id']);
        $str['name'] = 'hhhhh';
//        $str['O'] = 'xxxxxx';
    }
}
$obj = new ArrayWalk();
echo '<PRE>';
$obj->func_1();
echo '</PRE>';

