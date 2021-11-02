<?php

namespace App\Process\Process;

use App\Redis\MessageQueue;
use Hyperf\Process\ProcessManager;
use Hyperf\Process\AbstractProcess;

class Message extends AbstractProcess
{
    public $name = 'message';

    public function handle(): void
    {
        $queue = 'queue' . getLocalUnique();
        $consumerGroup = 'group';
        $consumer = 'consumer';
        MessageQueue::getInstance()->createConsumerGroup($queue, $consumerGroup);

        while (ProcessManager::isRunning()) {
            $data = MessageQueue::getInstance()->pop($queue, $consumerGroup, $consumer);//弹出一条消息
            if (empty($data)) {
                continue;
            }
            $msgId = key($data[$queue]);
            $msg = $data[$queue][$msgId];
            $consumerLogic = $this->container->get(\App\Process\Consumer\EventExplain::class);
            $msg['msg_id'] = $msgId;
            $consumerLogic->consume($msg);
        }
    }
}