<?php

/*
 * Copyright 2021 NanoSector
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace Yoshi2889\Collections;

use ArrayObject;
use Closure;
use InvalidArgumentException;

/**
 * Class Collection
 *
 * @package  Yoshi2889\Collections
 * @extends  ArrayObject<int|string, T>
 * @template T
 */
class Collection extends ArrayObject
{
    use ValidatesTypes;

    /**
     * Collection constructor.
     *
     * @param Closure(mixed): bool $valueValidator
     * @param array<T> $initialValues
     *
     * @internal param string $expectedValueType
     */
    public function __construct(
        Closure $valueValidator,
        array $initialValues = []
    ) {
        parent::__construct();
        $this->validator = $valueValidator;

        foreach ($initialValues as $key => $initialValue) {
            $this->offsetSet($key, $initialValue);
        }
    }

    /**
     * Filter the collection by the given closure.
     *
     * @param Closure(T): bool $condition
     *
     * @return Collection<T>
     */
    public function filter(Closure $condition): Collection
    {
        $collection = new self($this->validator);
        foreach ($this->toArray() as $offset => $value) {
            if ($condition($value)) {
                $collection->offsetSet($offset, $value);
            }
        }

        return $collection;
    }

    /**
     * Determine whether this collection contains the given value.
     *
     * @param mixed $value
     *
     * @return boolean
     */
    public function contains($value): bool
    {
        return in_array($value, $this->toArray(), true);
    }

    /**
     * Returns the offset of the given value, or false if it does not exist.
     *
     * @param T $value
     *
     * @return int|string|false
     */
    public function getOffset($value)
    {
        return array_search($value, (array)$this, true);
    }

    /**
     * Sets a value at the given offset.
     *
     * @param int|string $key
     * @param T $value
     */
    public function offsetSet($key, $value): void
    {
        if (!$this->validateType($value)) {
            throw new InvalidArgumentException(
                'Given value does not match expected value type for this collection.'
            );
        }

        parent::offsetSet($key, $value);
    }

    /**
     * Removes all occurrences of the given value.
     *
     * @param T $value
     */
    public function removeAll($value): void
    {
        while ($this->contains($value)) {
            $offset = $this->getOffset($value);

            if ($offset === false) {
                continue;
            }

            $this->offsetUnset($offset);
        }
    }

    /**
     * Exchanges the current collection with the given array.
     *
     * @param array<T> $array
     * @return array<T>
     */
    public function exchangeArray($array): array
    {
        if (!$this->validateArray($array)) {
            throw new InvalidArgumentException(
                'The given array does not match expected type for this collection.'
            );
        }

        return parent::exchangeArray($array);
    }

    /**
     * Returns all keys in this collection.
     *
     * @return array<int|string>
     */
    public function keys(): array
    {
        return array_keys($this->toArray());
    }

    /**
     * Returns all values in this collection.
     *
     * @return array<int, T>
     */
    public function values(): array
    {
        return array_values($this->toArray());
    }

    /**
     * @return array<int|string, T>
     */
    public function toArray(): array
    {
        return $this->getArrayCopy();
    }
}
