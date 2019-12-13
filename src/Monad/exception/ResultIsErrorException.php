<?php


namespace RightThisMinute\FunctionallyWrapped\Monad\exception;


use Throwable;

class ResultIsErrorException extends \Exception
{
  public function __construct (Throwable $previous)
  {
    parent::__construct
      ('Expected OK value but found Error.', 0, $previous);
  }
}
