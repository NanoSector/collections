<?php

/*
 * Copyright 2021 NanoSector
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

declare(strict_types=1);

namespace Yoshi2889\Collections;

trait ValidatesTypes
{
    /**
     * The validator closure which determines if the value is valid.
     *
     * @var Closure(mixed): bool
     */
    protected $validator;

    /**
     * Determines whether a given value passes type validation.
     *
     * @param mixed $value
     *
     * @return boolean
     */
    public function validateType($value): bool
    {
        return ($this->validator)($value);
    }

    /**
     * Determines whether a given array passes type validation.
     *
     * @param array<mixed> $array
     *
     * @return boolean
     */
    public function validateArray(array $array): bool
    {
        foreach ($array as $value) {
            if (!$this->validateType($value)) {
                return false;
            }
        }

        return true;
    }
}
