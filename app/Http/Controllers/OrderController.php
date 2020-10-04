<?php

namespace App\Http\Controllers;

use App\OrderQueue;
use App\RedisQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        // 这里应该首先是订单中心的处理流程
        // ......
        // 把用户传过来的数据进行过滤
        $order_id = rand(100000, 999999);

        // 把生成的订单信息
        $data = [
            'order_id' => $order_id,
            'mobile' => $request->input('mobile'),
            'address' => '测试地址',
            'status' => 0
        ];

        // 把数据存入到队列表中
        $res = OrderQueue::create($data);

        if ($res)
        {
            echo "[{$res->order_id}] save success";
        }
        else
        {
            echo 'save fail';
        }
    }

    public function saveToDb()
    {
        $redis_name = 'miaosha';
        // 用死循环
        while (1)
        {
            // 从队列最左侧取出一个值来
            $user = Redis::lpop($redis_name);

            // 然后判断这个值是否存在
            if (!$user || $user == '')
            {
                sleep(2);
                continue;
            }

            // 切割出uid和时间
            $user_arr = explode('%', $user);
            $insert_data = [
                'uid' => $user_arr[0],
                'time_stamp' => $user_arr[1]
            ];

            // 保存到数据库中
            $res = RedisQueue::create($insert_data);

            // 数据库插入的失败的时候的回滚机制
            if (!$res)
            {
                Redis::rpush($redis_name, $user);
            }
            sleep(2);
            
            // 释放redis
        }
    }
}
