<?php
/**
 * Copyright 2017 NanoSector
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

use Yoshi2889\Collections\Collection;
use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
	public function getStringValidatorClosure(): \Closure
	{
		return function ($value)
		{
			return is_string($value);
		};
	}

	public function testAppend()
	{
		$collection = new Collection($this->getStringValidatorClosure());

		$string = 'Test string';
		$collection->append($string);

		self::assertEquals(1, $collection->count());
		self::assertCount(1, $collection->values());
		self::assertEquals($string, $collection[0]);
		self::assertEquals($string, $collection->getOffset(0));
	}

	public function testAppendWithKey()
	{
		$collection = new Collection($this->getStringValidatorClosure());

		$string = 'Test string';
		$key = 'test';

		$collection->offsetSet($key, $string);

		self::assertEquals(1, $collection->count());
		self::assertCount(1, $collection->values());
		self::assertEquals($string, $collection[$key]);
		self::assertEquals($string, $collection->getOffset($key));
		self::assertTrue($collection->offsetExists($key));
		self::assertSame([$key], $collection->keys());
	}

	public function testRemoveAll()
	{
		$collection = new Collection($this->getStringValidatorClosure());

		$string = 'Test string';
		$collection->append($string);
		$collection->append($string);
		$collection->append($string);

		self::assertEquals(3, $collection->count());
		self::assertTrue($collection->contains($string));

		$collection->removeAll($string);

		self::assertEquals(0, $collection->count());
		self::assertFalse($collection->contains($string));
	}

	public function testInvalidType()
	{
		$collection = new Collection($this->getStringValidatorClosure());

		self::assertFalse($collection->validateType(10));
		self::assertTrue($collection->validateType('Test'));

		$this->expectException(InvalidArgumentException::class);
		$collection->append(10);

		$this->expectException(InvalidArgumentException::class);
		$collection->offsetSet('test', 10);
	}
}
