<?php

namespace Typomedia\Fciv\Exception;

use Exception;
use Throwable;
use Typomedia\Fciv\Entity\Error;

class InvalidHashException extends Exception
{
    protected $message;

    public function __construct($messages, $code = 0, Throwable $previous = null)
    {
        foreach ($messages as $error) {
            /** @var Error $error */
            $this->message .= $error->file . ' ' . $error->algo . ' ' . $error->hash . PHP_EOL;
        }

        parent::__construct($this->message, $code, $previous);
    }
}
