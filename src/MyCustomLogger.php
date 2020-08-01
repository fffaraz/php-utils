<?php

namespace fffaraz\Utils;

use Monolog\Logger;

class MyCustomLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $logger = new Logger("MyLoggingHandler");
        return $logger->pushHandler(new MyLoggingHandler());
    }
}
