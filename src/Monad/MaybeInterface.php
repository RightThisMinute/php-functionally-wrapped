<?php
declare(strict_types=1);


namespace RightThisMinute\FunctionallyWrapped\Monad;


interface MaybeInterface extends MonadInterface
{
  function hasValue () : bool;
  function isEmpty () : bool;
  function getValue ();
  function getValueOrDefault ($default);
  function getEmptyValues () : array;
}
