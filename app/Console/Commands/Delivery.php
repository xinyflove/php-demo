<?php

namespace App\Console\Commands;

use App\OrderQueue;
use Illuminate\Console\Command;
// 配送系统处理队列中的订单进行标记
class Delivery extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:delivery';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '处理订单发货';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // 1. 先把要处理的记录更新为等待处理
        $waiting = ['status'=>0];
        $lock = ['status'=>2];
        $res_lock = OrderQueue::where($waiting)->limit(2)->update($lock);
        
        // 2. 选择出刚刚更新的数据，进行配送系统的处理
        if ($res_lock)
        {
            // 选出要处理的订单
            $res = OrderQueue::where($lock)->get();

            // 由配货系统进行配货处理
            // ......

            // 3. 把处理过的数据更新为已完成
            $success = ['status'=>1];
            $res_last = OrderQueue::where($lock)->update($success);
            if ($res_last)
            {
                $this->info("success {$res_last}!");
            }
            else
            {
                $this->info("fail {$res_last}!");
            }
        }
        else
        {
            $this->info("all finished");
        }
    }
}
