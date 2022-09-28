<?php

declare(strict_types=1);

namespace Tests\Sushi;

use PHPUnit\Framework\TestCase;
use Sushi\ObjectCollection;

class ObjectCollectionTest extends TestCase
{
    private object $objectOfRightType;

    public function setUp(): void
    {
        $this->objectOfRightType = new class () {};
    }

    public function testAddWrongType(): void
    {
        $this->expectError();
        $collection = $this->prepareCollection($this->objectOfRightType::class, []);
        $collection[] = new class () {};
    }

    public function testAddDifferent(): void
    {
        $collection = $this->prepareCollection($this->objectOfRightType::class, []);
        $collection[] = $this->objectOfRightType;
        $this->assertCount(1, $collection);
        $this->assertSame($this->objectOfRightType, $collection[0]);
    }

    public function testInit(): void
    {
        $collection = $this->prepareCollection($this->objectOfRightType::class, [$this->objectOfRightType]);
        $this->assertCount(1, $collection);
        $this->assertSame($this->objectOfRightType, $collection[0]);
    }

    private function prepareCollection(string $typeAsString, object|array $input): ObjectCollection
    {
        $collection = new class ($input) extends ObjectCollection {};
        $assignTheRightTypeToCollection = fn(string $typeAsString) => static::$type = $typeAsString;
        ($assignTheRightTypeToCollection)->call($collection, $typeAsString);

        return $collection;
    }
}
