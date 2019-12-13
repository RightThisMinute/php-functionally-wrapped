<?php
declare(strict_types=1);


namespace RightThisMinute\FunctionallyWrapped\Monad;


use RightThisMinute\FunctionallyWrapped\Monad\exception\ResultIsErrorException;
use RightThisMinute\FunctionallyWrapped\Monad\exception\ResultIsOKException;
use RightThisMinute\FunctionallyWrapped\Monad\ExceptionWrap;

/**
 * Class AbstractResult
 *
 * This extra layer of abstraction is meant to hide away the OK vs Error
 * logic. I want to protect the logic that determines whether or not an
 * instance is OK or Error so that there is less of a chance of accidentally
 * getting in a state where it thinks it's okay, but it's actually error and
 * vice-versa.
 *
 * @package RightThisMinute\FunctionallyWrapped\Monad
 */
abstract class AbstractResult implements ResultInterface
{
  private $ok;
  private $error;
  private $is_ok;

  protected function __construct ($value, bool $is_ok)
  {
    $this->ok = $is_ok ? $value : null;
    $this->error = $is_ok ? null : $value;
    $this->is_ok = $is_ok;
  }

  /**
   * @inheritDoc
   */
  static public function ok ($value)
  {
    return new static($value, true);
  }

  /**
   * @inheritDoc
   */
  static public function error ($error)
  {
    return new static($error, false);
  }

  public function isOK () : bool
  {
    return $this->is_ok;
  }

  public function isError () : bool
  {
    return !$this->isOK();
  }

  public function getOK ()
  {
    if ($this->isOK())
      return $this->ok;

    $previous = $this->error instanceof \Throwable
      ? $this->error : (new ExceptionWrap($this->error));

    throw new ResultIsErrorException($previous);
  }

  public function getError ()
  {
    if ($this->isError())
      return $this->error;

    throw new ResultIsOKException();
  }
}
