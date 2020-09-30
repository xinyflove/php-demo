<?php

namespace App\Http\Controllers;

use App\OrderQueue;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    // 配送系统处理队列中的订单进行标记
    public function index()
    {
        // 1. 先把要处理的记录更新为等待处理
        $waiting = ['status'=>0];
        $lock = ['status'=>2];
        $res_lock = OrderQueue::where($waiting)->limit(2)->update($lock );
        dd($res_lock);
        // 2. 选择出刚刚更新的数据，进行配送系统的处理
        // 3. 把处理过的数据更新为已完成
    }
    
}
