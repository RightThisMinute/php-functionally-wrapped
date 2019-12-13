<?php


namespace RightThisMinute\FunctionallyWrapped\Monad\MaybeResult;


use RightThisMinute\FunctionallyWrapped\Monad\MaybeResult\exception\IsErrorException;

class Error extends Base
{
  protected $error;

  public function __construct ($error, ?array $empty_values=NULL)
  {
    parent::__construct($empty_values);
    $this->error = $error;
  }

  public function isEmpty () : bool
  {
    return false;
  }

  public function errorIfEmpty ($error)
  {
    return $this;
  }

  public function map (callable $transform, ?string $empty_error = NULL)
  {
    return $this;
  }

  public function bind (callable $transform, ?string $empty_error = NULL) : Base
  {
    return $this;
  }

  public function isOK () : bool
  {
    return false;
  }

  /**
   * @inheritDoc
   */
  public function getMaybe ()
  {
    $previous = $this->error instanceof \Throwable
      ? $this->error : (new ExceptionWrap($this->error));

    throw new IsErrorException($previous);
  }

}
