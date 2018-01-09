<?php
namespace express;

// use ;
// import('express/kuaidi100/custom/coreFunc',EXTEND_PATH);

/**
* 快递接口
*/
class WorkPlugin
{
    private $p_set = [];
    private $notify_url = '';
    private $return_url = '';
    private $dir = '';// getcwd()
    private $host = '';

    function __construct()
    {
        # code...
    }

    public function work()
    {
        return '快递';
    }
}