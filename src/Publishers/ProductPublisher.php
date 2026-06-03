<?php

namespace Sqmatheus\Ecommerce\Publishers;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Sqmatheus\Ecommerce\DTOs\BuyProductDto;

class ProductPublisher {

    private const string QUEUE = 'product_bought';

    private AMQPChannel $channel;

    public function __construct()
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');

        $this->channel = $connection->channel();

        $this->channel->queue_declare(self::QUEUE, durable: true, auto_delete: false);
    }

    public function bought(BuyProductDto $dto): void {
        $message = new AMQPMessage($dto->userName . ' bought ' . $dto->idProduct);
        $this->channel->basic_publish($message, routing_key: self::QUEUE);
    }
}