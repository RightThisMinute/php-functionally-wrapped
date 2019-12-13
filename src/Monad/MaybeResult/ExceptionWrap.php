<?php
declare(strict_types=1);


namespace RightThisMinute\FunctionallyWrapped\Monad\MaybeResult;


use Throwable;

class ExceptionWrap extends \Exception
{

  private $value;

  public function __construct ($value)
  {
    parent::__construct();
    $this->value = $value;
  }

  /**
   * @return mixed
   */
  public function getValue ()
  {
    return $this->value;
  }

}
