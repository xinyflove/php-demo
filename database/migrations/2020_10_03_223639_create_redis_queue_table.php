<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRedisQueueTable extends Migration
{
    private $table = 'redis_queue';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('uid')->default(0)->comment('用户ID');
            $table->string('time_stamp', 24)->comment('微秒时间戳');
            $table->engine = 'InnoDB';
        });
        $prefix = config('database.connections.mysql.prefix');
        DB::statement("ALTER TABLE `" . $prefix.$this->table . "` comment 'Redis队列表'");
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
