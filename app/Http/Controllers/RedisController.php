<?php

namespace App\Http\Controllers;

use App\OrderQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function user(Request $request)
    {
        $redis_name = 'miaosha';
        $num = 10;

        // 使用for循环模拟瞬间有大量用户集中访问
        for ($i=0; $i<100; $i++)
        {
            // 接收用户的id
            //$uid = $request->input('uid');
            $uid = rand(100000, 999999);

            // 获取redis里面已有的数量
            // 如果当天人数少于10的时候，则加入这个队列
            if (Redis::llen($redis_name) < $num)
            {
                Redis::rpush($redis_name, $uid . '%' . microtime());
                echo $uid . '秒杀成功！';
            }
            else
            {
                // 如果当前人数已经达到了10人，则返回秒杀已完成
                echo '秒杀已结束！';
            }
        }
    }
}
