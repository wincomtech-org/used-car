<?php
namespace payment\test;

// use app\funds\model\PayModel;

/**
* 测试
*/
// class Test extends PayModel
class Test
{
    var $constant = 'constant';
    
    function __construct($var='')
    {
        $this->var = $var;
    }

    public function out($data=[])
    {
        $post = [
            'constant'=>$this->constant,
            'var' => $this->var,
            'data'=> $data,
        ];

        // $post = [1,2,3];

        // var_dump($post);
        return $post;
    }

    public function FunctionName($value='')
    {
        # code...
    }






}