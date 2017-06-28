<?php
/**
 * Copyright 2017 NanoSector
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

namespace Yoshi2889\Collections;

class Collection extends \ArrayObject
{
	/**
	 * @var \Closure
	 */
	protected $validator = '';

	/**
	 * Collection constructor.
	 *
	 * @param \Closure $valueValidator
	 * @param array $initialValues
	 *
	 * @internal param string $expectedValueType
	 */
	public function __construct(\Closure $valueValidator, array $initialValues = [])
	{
		$this->validator = $valueValidator;

		foreach ($initialValues as $key => $initialValue)
			$this->offsetSet($key, $initialValue);
	}

	/**
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function contains($value): bool
	{
		return in_array($value, (array) $this);
	}

	/**
	 * @param $value
	 *
	 * @return false|int|string|mixed
	 */
	public function getOffset($value)
	{
		return array_search($value, (array) $this);
	}

	/**
	 * @return array
	 */
	public function keys(): array
	{
		return array_keys((array) $this);
	}

	/**
	 * @inheritdoc
	 */
	public function offsetSet($offset, $value)
	{
		if (!$this->validateType($value))
			throw new \InvalidArgumentException('Given value does not match expected value type for this collection.');

		parent::offsetSet($offset, $value);
	}

	/**
	 * @param mixed $value
	 */
	public function removeAll($value)
	{
		while ($this->contains($value))
			$this->offsetUnset($this->getOffset($value));
	}

	/**
	 * @param $value
	 *
	 * @return bool
	 */
	public function validateType($value): bool
	{
		return ($this->validator)($value);
	}

	/**
	 * @return array
	 */
	public function values(): array
	{
		return array_values((array) $this);
	}
}