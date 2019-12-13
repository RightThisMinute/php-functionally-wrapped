<?php
declare(strict_types=1);


namespace RightThisMinute\FunctionallyWrapped\Monad\MaybeResult\exception;


class IsOKException extends \Exception
{
  public function __construct ()
  {
    parent::__construct('Expected Error but found OK value.');
  }
}
