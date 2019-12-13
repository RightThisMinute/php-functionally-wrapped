<?php
declare(strict_types=1);


namespace RightThisMinute\FunctionallyWrapped\Monad;


class MaybeResult extends Result
{
  protected $empty_values;

  protected function __construct ($value, bool $is_ok, ?array $empty_values=null)
  {
    if ($is_ok and !($value instanceof Maybe))
      $value = Maybe::of($value, $empty_values);

    $this->empty_values = $is_ok
      ? $value->getEmptyValues()
      : ($empty_values ?? Maybe::DEFAULT_EMPTY_VALUES);

    parent::__construct($value, $is_ok);
  }

  /**
   * @param $value
   * @param array|null $empty_values
   *
   * @return $this
   */
  public static function ok ($value, ?array $empty_values=null)
  {
    return new static($value, true, $empty_values);
  }

  public static function error ($error, ?array $empty_values=null)
  {
    return new static($error, false, $empty_values);
  }

  public function getOK () : Maybe
  {
    return parent::getOK();
  }

  public function map (callable $transform, $empty_error=null)
  {
    if ($this->isError() || $this->getOK()->isEmpty())
      return $this;

    $value = $this->getValue();

    try {
      $new = $transform($value);
    }
    catch (\Exception $exn) {
      return static::error($exn, $this->empty_values);
    }

    $new = Maybe::of($new, $this->empty_values);

    if (isset($empty_error) and $new->isEmpty()) {
      $error = is_callable($empty_error) ? $empty_error() : $empty_error;
      return static::error($error, $this->empty_values);
    }

    return static::ok($new, $this->empty_values);
  }

  public function flatMap (callable $transform, $empty_error=null)
  {
    $new = $this->map($transform, $empty_error);

    if ($new->isOK() and $new->getOK() instanceof static)
      return $new->getOK();

    return $new;
  }

  public function getValue ()
  {
    return $this->getOK()->getValue();
  }

  public function asResultWithDefault ($default) : Result
  {
    if ($this->isOK()) {
      $value = $this->getOK()->getValueOrDefault($default);
      return Result::ok($value);
    }

    return Result::error($this->getError());
  }
}
