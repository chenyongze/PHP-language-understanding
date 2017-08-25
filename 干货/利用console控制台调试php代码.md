# 利用console控制台调试php代码

```
/**
     * 控制台输出
     * @param $var
     * @param string $level
     */
    public function console($var,$level = 'debug')
    {
        if(is_array($var) || is_object($var)){
            $output = json_encode($var);
            $jsonDecode = json_decode($output);
            if(empty((array)$jsonDecode) && !empty($var)){
                echo "<script>console.{$level}('不支持输出')</script>";
                return;
            }
        }elseif(is_string($var)){
            $output = '"'.$var.'"';
        }else{
            $output = $var;
        }
        echo "<script>console.{$level}({$output})</script>";
        return;
    }
```
