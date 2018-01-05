<?php 
namespace test;
use test\Test;
/**
* 
*/
class Test3
{
    
    function __construct()
    {
        # code...
    }

    public function index($value='Test3.php')
    {
        return $value;
    }

    public function fromTest()
    {
        $test = new Test();
        return $test->out();
    }
}
?>