<?php


namespace RightThisMinute\FunctionallyWrapped\Monad\MaybeResult;


use RightThisMinute\FunctionallyWrapped\Monad\MaybeResult\exception\IsErrorException;
use RightThisMinute\FunctionallyWrapped\Monad\MaybeResult\exception\IsOKException;

abstract class Base
{
  /** @var array */
  protected $empty_values;

  public function __construct (?array $empty_values=null)
  {
    $this->empty_values = $empty_values ?? [null, '', []];
  }

  abstract public function isEmpty () : bool;

  /**
   * @param mixed $error
   *
   * @return $this
   */
  abstract public function errorIfEmpty ($error);

  /**
   * @param callable $transform
   * @param string|null $empty_error
   *
   * @return $this
   */
  abstract public function map (callable $transform, ?string $empty_error=null);

  /**
   * @param callable $transform
   * @param string|null $empty_error
   *
   * @return $this
   */
  abstract public function bind (callable $transform, ?string $empty_error=null);

  abstract public function isOK () : bool;
  public function isError () : bool
  {
    return !$this->isOK();
  }

  /**
   * @return mixed
   *
   * @throws IsErrorException
   */
  abstract public function getMaybe ();

  /**
   * @return mixed
   *
   * @throws IsOKException
   */
  abstract public function getError ();
}
