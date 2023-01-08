<?php

namespace ScheMeZa\SMSPortal;

class EmptyMessageException extends \Exception
{

    public function __construct($message, $code = 4000, \Throwable $previous = null) {
        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
}