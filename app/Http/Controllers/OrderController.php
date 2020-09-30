<?php

namespace App\Http\Controllers;

use App\OrderQueue;
use Illuminate\Http\Request;

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
}
