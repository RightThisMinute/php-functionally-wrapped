<?php
declare(strict_types=1);


namespace RightThisMinute\FunctionallyWrapped\Monad;


use RightThisMinute\FunctionallyWrapped\Monad\exception\ResultIsErrorException;
use RightThisMinute\FunctionallyWrapped\Monad\exception\ResultIsOKException;
use RightThisMinute\FunctionallyWrapped\Monad\MaybeResult\Base;
use RightThisMinute\FunctionallyWrapped\Monad\MaybeResult\Error;

class Result extends AbstractResult
{

  /**
   * @param callable $transform
   *
   * @return $this;
   */
  function map (callable $transform)
  {
    if ($this->isError())
      return $this;

    try {
      $new = $transform($this->getOK());
      return static::ok($new);
    }
    catch (\Exception $e) {
      return static::error($e);
    }
  }

  /**
   * @inheritDoc
   */
  function flatMap (callable $transform)
  {
    $new = $this->map($transform);

    if ($new->isOK() and $new->getOK() instanceof static)
      return $new->getOK();

    return $new;
  }
}
