# 消息队列

## 消息队列概念

- 队列结构的中间件
- 消息放入后，不需要立即处理
- 由订阅者/消费者按顺序处理

## 核心结构

业务系统 --入队--> 消息队列 --出队--> 队列处理系统

## 应用场景

- 数据冗余
- 系统解耦
- 流量削峰（秒杀、抢购）
- 异步通信
- 扩张性
- 排序保证

## 常见队列实现优缺点

### 队列介质

- Mysql：可靠性高、易实现、速度慢
- Redis：速度快、单条大消息包时效率低
- 消息系统：专业性强、可靠、学习成本高（MQ）

### 消息处理触发机制

- 死循环方式读取：易实现，故障时无法及时恢复（适合做秒杀）
- 定时任务：压力均分，有处理量上限（需要考虑上一个定时任务没处理完，下一个定时任务又开始了的情况）
- 守护进程：类似于 PHP-FPM 和 PHP-CG ，需要shell基础

## 解耦案例：队列处理订单系统和配送系统

访问 `域名/order/create?mobile=手机号` 创建

定时处理发货任务

```
*/1 * * * * /mnt/hgfs/myproject/php-demo/public/delivery.sh >> /mnt/hgfs/myproject/php-demo/public/delivery.log 2>&1
```

监控日志文件

```
tail -f delivery.log
```

## 流量削峰案例：Redis的List类型实现秒杀

### Redis数据类型中的List类型

- LPUSH/LPUSHX：将值插入到（/存在的）列表头部
- RPUSH/RPUSHX：将值插入到（/存在的）列表尾部
- LPOP：移除并获取列表的第一个元素
- RPOP：移除并获取列表的最后一个元素
- LTRIM：保留指定区间内的元素
- LLEN：获取列表长度
- LSET：通过索引设置列表元素的值
- LINDEX：通过索引获取列表中的元素
- LRANGE：获取列表指定范围内的元素

### 代码级设计

- 秒杀程序把请求写入Redis。（Uid，time_stamp）
- 检查Redis已存放数据的长度，超出上限直接丢弃。
- 死循环处理存入Redis的数据并入库

## RabbitMQ

### RabbitMQ的架构和原理

- 特点：完整的实现了AMQP、集群简化、持久化、跨平台

### RabbitMQ使用

- RabbitMQ安装（rabbitmq-server、php-amqplib）
- 生产者向消息通道发送消息
- 消费者处理消息

### Work Queues

