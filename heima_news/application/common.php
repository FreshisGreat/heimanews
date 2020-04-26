<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
// Redis数据库连接
if(!function_exists('getRedis')){
    /**
     * 封闭连接Redis
     */
    function getRedis(){
        //连接$redis数据库
        $redis = new \Redis();
        //读取config.php文件中的redis配置
        $config_redis = config('redis');
        $redis->connect($config_redis['host'],$config_redis['port'],$config_redis['timeout']);
        //进行数据库口令验证
        $redis->auth($config_redis['auth']);
        return $redis;
    }
}

if(!function_exists('api')){
    function api(array $data = [], int $httpCode = 200){
        return json([
            'status' => 200,
            'msg' => '成功',
            'data' => $data
        ],$httpCode,[
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'GET, POST, PATCH, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With'
        ]);
    }
}
