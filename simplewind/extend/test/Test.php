<?php
namespace test;

// use app\funds\model\PayModel;
use traits\controller\Jump;//代码复用的方法，称为 trait。
// use think\Loader;

// Loader::import('controller/Jump', TRAIT_PATH, EXT);

/**
* 测试
*/
// class Test extends PayModel
class Test
{
    use Jump;
    var $constant = 'constant';
    private $p_set = [];
    private $dir = '';// getcwd()
    private $host = '';
    
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

    public function tp($value='')
    {
        //如何识别返回参数？去除后缀.html即可
        $str = cmf_get_domain();//末尾不带 '/'
        $str = cmf_url('funds/Pay/callBack','',false,$this->host);
        $str = url('funds/Pay/callBack','',false,$this->host);

        // $jump = new Jump();//traits不需要
        // $this->redirect('user/Profile/center');

        return $str;
        return false;
    }
}

/**
* 第二个类
*/
class Test2 extends Test
{
    public function __construct($var2='')
    {
        parent::__construct();
        // echo $this->var;die;
    }

    public function index($value='')
    {
        // return $this->var;
        return $value;
    }
}
/**
* 第三个类
*/
class Test3
{
    public function index($value='')
    {
        return $value;
    }
}