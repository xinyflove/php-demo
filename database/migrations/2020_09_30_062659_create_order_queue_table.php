<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateOrderQueueTable extends Migration
{
    private $table = 'order_queue';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id')->comment('订单ID');
            $table->string('mobile', 20)->comment('用户手机号');
            $table->string('address', 100)->comment('用户收货地址');
            $table->tinyInteger('status')->default(0)->comment('订单状态, 0:未处理, 1:已处理, 2:处理中');
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
        $prefix = config('database.connections.mysql.prefix');
        DB::statement("ALTER TABLE `" . $prefix.$this->table . "` comment '订单队列表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
