<?php
namespace test;

// use app\funds\model\PayModel;
use traits\controller\Jump;//代码复用的方法，称为 trait。
// use think\Loader;

// Loader::import('controller/Jump', TRAIT_PATH, EXT);

/**
* 测试
* 空类，只是与文件名一致，不用则报错。在别的地方使用时带上：use test\Test;new Test();
* 这里必须要有类的名字与文件的名字一样(Test.php)，否则报错。为什么？
*/
class Test{}

/**
* 第一个测试
*/
class Test1
{
    use Jump;
    // 赋值 值只能为常量等基础量，不能是 getcwd()这样的
    var $constant = 'constant';
    private $p_set = [];
    private $dir = '';
    private $host = '';
    private $string0 = '这是父类私有字符';//只在该类使用
    protected $string1 = '这是父类保护字符';//不外用
    public $string2 = '这是父类公开字符';//公用
    
    function __construct($var='父类构造')
    {
        $this->var = $var;
    }

    public function struct()
    {
        return $this->var;
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

    public function cmf()
    {
        //如何识别返回参数？去除后缀.html即可
        $str = cmf_get_domain();//末尾不带 '/'
        $str = cmf_url('funds/Pay/callBack','',false,$this->host);
        $str = url('funds/Pay/callBack','',false,$this->host);

        // $jump = new Jump();//traits不需要
        // $this->redirect('user/Profile/center');

        return $str;
    }

    protected function defense($value='')
    {
        return 'defense';
    }
}

/**
* 第二个类继承Test
* 使用时必须 use test\Test;
*/
class Test2 extends Test1
{
    // public function __construct($var2='子类构造')
    // {
    //     parent::__construct('子承父');
    //     // echo $this->string0;die;//Undefined property: test\Test2::$string0
    //     // echo $this->string1;die;
    //     // echo $this->string2;die;
    //     // echo $this->var;die;
    //     $this->var2 = $var2;
    // }

    public function index($value='Test2')
    {
        // $data = $this->struct();
        $data = $this->var;//(1)当子类构造不写时有效。(2)子类写了构造，且有parent::__construct('子承父')时有效。
        // $data = $this->var2;
        // $data = $value;

        return $data;
    }
}
/**
* 第二个类不继承Test
*/
// class Test2
// {
//     public function index($value='Test2')
//     {
//         return $value;
//     }
// }


/**
* 第三个类
* 如果这里被注释，则其它地方 use test\Test3时用的是 Test3.php
*/
class Test3
{
    public function index($value='Test.php')
    {
        return $value;
    }
}



/*接口测试*/


/*其它*/
final public function Handle($needSign = true){
    
}












