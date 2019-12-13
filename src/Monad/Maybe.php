<?php
declare(strict_types=1);


namespace RightThisMinute\FunctionallyWrapped\Monad;


class Maybe implements MaybeInterface
{
  const DEFAULT_EMPTY_VALUES = [null, '', []];

  private $value;
  private $empty_values;

  /**
   * @param $value
   * @param array|null $empty_values
   * @return self
   */
  public static function of
    ($value, ?array $empty_values=self::DEFAULT_EMPTY_VALUES)
  {
    $maybe = new Maybe();
    $maybe->value = $value;
    $maybe->empty_values = $empty_values ?? static::DEFAULT_EMPTY_VALUES;
    return $maybe;
  }

  public function hasValue () : bool
  {
    return !$this->isEmpty();
  }

  public function isEmpty () : bool
  {
    return in_array($this->value, $this->empty_values, true);
  }

  public function getValue ()
  {
    return $this->value;
  }

  public function getValueOrDefault ($default)
  {
    return $this->isEmpty() ? $default : $this->value;
  }

  /**
   * @inheritDoc
   */
  public function map (callable $transform)
  {
    if ($this->isEmpty())
      return $this;

    return static::of($transform($this->value), $this->empty_values);
  }

  /**
   * @inheritDoc
   */
  public function flatMap (callable $transform)
  {
    if ($this->isEmpty())
      return $this;

    $new = $transform($this->value);
    if ($new instanceof static)
      return $new;

    return static::of($new, $this->empty_values);
  }

  public function getEmptyValues () : array
  {
    return $this->empty_values;
  }
}
