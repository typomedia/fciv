<?php

namespace Typomedia\Fciv\Exception;

use Exception;
use Throwable;
use Typomedia\Fciv\Entity\Error;

/**
 * Class InvalidHashException
 * @package Typomedia\Fciv
 */
class InvalidHashException extends Exception
{
    /**
     * @var mixed|null
     */
    protected $message;

    public function __construct($messages, $code = 0, Throwable $throwable = null)
    {
        foreach ($messages as $message) {
            /** @var Error $error */
            $this->message .= $message->file . ' ' . $message->algo . ' ' . $message->hash . PHP_EOL;
        }

        parent::__construct($this->message, $code, $throwable);
    }
}
