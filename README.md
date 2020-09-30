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

