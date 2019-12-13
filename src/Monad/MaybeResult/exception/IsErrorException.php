<?php


namespace RightThisMinute\FunctionallyWrapped\Monad\MaybeResult\exception;


use Throwable;

class IsErrorException extends \Exception
{
  public function __construct (Throwable $previous)
  {
    parent::__construct
      ('Expected OK value but found Error.', 0, $previous);
  }
}
