<?php
/*
 * MIT License
 *
 * Copyright (c) 2020 GameplayJDK
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

namespace Mixin;

use Exception;

/**
 * Class DynamicInheritance
 *
 * @package Mixin
 */
trait DynamicInheritance
{
    /**
     * @var array|object[]
     */
    private $mixin = [];

    /**
     * @param object $object
     */
    public function addMixin(object $object): void
    {
        $this->mixin[] = $object;
    }

    /**
     * @param string $method
     * @param array $argumentArray
     * @return mixed
     * @throws Exception
     */
    public function __call(string $method, array $argumentArray)
    {
        foreach ($this->mixin as $mixin) {
            if (method_exists($mixin, $method)) {
                return $mixin->$method(...$argumentArray);
            }
        }

        throw new Exception(__CLASS__ . " has no method " . $method);
    }

    /**
     * @param string $property
     * @return mixed
     * @throws Exception
     */
    public function __get(string $property)
    {
        foreach ($this->mixin as $mixin) {
            if (property_exists($mixin, $property)) {
                return $mixin->$property;
            }
        }

        throw new Exception(__CLASS__ . " has no property '{$property}'.");
    }

    /**
     * @param string $property
     * @param mixed $value
     * @throws Exception
     */
    public function __set(string $property, $value)
    {
        foreach ($this->mixin as $mixin) {
            if (property_exists($mixin, $property)) {
                return $mixin->$property = $value;
            }
        }

        throw new Exception(__CLASS__ . " has no property '{$property}'.");
    }
}
