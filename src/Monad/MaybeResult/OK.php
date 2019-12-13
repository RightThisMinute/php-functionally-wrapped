<?php


namespace RightThisMinute\FunctionallyWrapped\Monad\MaybeResult;


use RightThisMinute\FunctionallyWrapped\Monad\MaybeResult\exception\IsOKException;

class OK extends Base
{
  protected $value;

  public function __construct ($value, ?array $empty_values=null)
  {
    parent::__construct($empty_values);
    $this->value = $value;
  }

  public function errorIfEmpty ($error) : Base
  {
    if (!$this->isEmpty())
      return $this;

    return (new Error($error, $this->empty_values));
  }

  public function map (callable $transform, ?string $empty_error=null) : Base
  {
    if (!$this->isEmpty())
      return $this;

    try {
      $new = $transform($this->value);

      if (isset($empty_error)
          and self::isEmpty_($new, $this->empty_values))
        return (new Error($empty_error, $this->empty_values));

      return new static($new, $this->empty_values);
    }
    catch (\Exception $e) {
      return new Error($e, $this->empty_values);
    }
  }

  public function bind (callable $transform, ?string $empty_error=null) : Base
  {
    $new = $this->map($transform, $empty_error);

    if ($new->isOK() and $new->getMaybe() instanceof Base)
      return $new->getMaybe();

    return $new;
  }

  public function isEmpty () : bool
  {
    return self::isEmpty_($this->value, $this->empty_values);
  }

  public function isOK () : bool
  {
    return true;
  }

  /**
   * @inheritDoc
   */
  public function getMaybe ()
  {
    # @todo This should return a `Maybe` monad once those exist.
    return $this->value;
  }

  /**
   * @inheritDoc
   */
  public function getError ()
  {
    throw new IsOKException();
  }

  private static function isEmpty_ ($value, array $empty_values) : bool
  {
    return in_array($value, $empty_values, true);
  }
}
