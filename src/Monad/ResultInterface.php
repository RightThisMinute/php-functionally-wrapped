<?php
declare(strict_types=1);


namespace RightThisMinute\FunctionallyWrapped\Monad;


use RightThisMinute\FunctionallyWrapped\Monad\exception\ResultIsErrorException;
use RightThisMinute\FunctionallyWrapped\Monad\exception\ResultIsOKException;

interface ResultInterface extends MonadInterface
{

  /**
   * @param $value
   *
   * @return $this
   */
  static function ok ($value);

  /**
   * @param $error
   *
   * @return $this
   */
  static function error ($error);

  function isOK () : bool;
  function isError () : bool;

  /**
   * @return mixed
   * @throws ResultIsErrorException
   */
  function getOK ();

  /**
   * @return mixed
   * @throws ResultIsOKException
   */
  function getError ();
}
