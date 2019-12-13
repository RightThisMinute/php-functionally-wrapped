<?php
declare(strict_types=1);


namespace RightThisMinute\FunctionallyWrapped\Monad;


interface MonadInterface
{

  /**
   * @param callable $transform
   *
   * @return $this
   */
  function map (callable $transform);

  /**
   * @param callable $transform
   *
   * @return $this
   */
  function flatMap (callable $transform);
}
