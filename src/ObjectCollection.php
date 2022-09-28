<?php

declare(strict_types=1);

namespace Sushi;

use ArrayIterator;
use ArrayObject;
use stdClass;
use TypeError;

class ObjectCollection extends ArrayObject
{
    private const ERROR_MSG = '%s: only values of type %s are supported';

    protected static string $type = stdClass::class;
    protected static string $iteratorClass = ArrayIterator::class;
    protected static int $flags = 0;

    public function __construct(
        object|array $input = []
    ) {
        $this->init($input);
        parent::__construct($input, static::$flags, static::$iteratorClass);
    }

    public function offsetSet(mixed $key, mixed $value): void
    {
        $this->checkType($value);
        parent::offsetSet($key, $value);
    }

    private function init(object|array $input): void
    {
        array_walk($input, fn(mixed $item) => $this->checkType($item));
        $this->exchangeArray($input);
    }

    private function checkType(mixed $value): void
    {
        if (!$value instanceof static::$type) {
            throw new TypeError(sprintf(self::ERROR_MSG, static::class, static::$type));
        }
    }
}
