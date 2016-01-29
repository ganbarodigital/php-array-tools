<?php

/**
 * Copyright (c) 2016-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Libraries
 * @package   ArrayTools/Filters
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://code.ganbarodigital.com/php-array-tools
 */

namespace GanbaroDigital\ArrayTools\Filters;

use GanbaroDigital\Reflection\Maps\MapTypeToMethod;
use Traversable;

class ExtractFirstItem
{
    /**
     * extract the first item from a dataset
     *
     * @param  mixed $data
     *         the data to filter
     * @param  mixed $default
     *         the data to return when we cannot filter $data
     * @return mixed
     */
    public function __invoke($data, $default)
    {
        return self::from($data, $default);
    }

    /**
     * extract the first item from a dataset
     *
     * @param  mixed $data
     *         the data to filter
     * @param  mixed $default
     *         the data to return when we cannot filter $data
     * @return mixed
     */
    public static function from($data, $default)
    {
        $method = MapTypeToMethod::using($data, self::$dispatchMap);
        return self::$method($data, $default);
    }

    /**
     * extract the first item from a dataset held in a string
     *
     * we take a very simplistic approach here, and assume that the string
     * contains space-separated data
     *
     * @param  string $data
     *         the data to filter
     * @param  mixed $default
     *         the data to return when we cannot filter $data
     * @return mixed
     */
    private static function fromString($data, $default)
    {
        // special case - $data is empty
        if (trim($data) === '') {
            return $default;
        }

        // treat it as a whitespace-separated string
        $parts = explode(' ', $data);
        return self::fromTraversable($parts, $default);
    }

    /**
     * extract the first item from a dataset
     *
     * @param  array|Traversable $data
     *         the data to filter
     * @param  mixed $default
     *         the data to return when we cannot filter $data
     * @return mixed
     */
    private static function fromTraversable($data, $default)
    {
        // return the first item available in $data
        //
        // we use a foreach() loop here because it is compatible with
        // both arrays and iterators
        foreach ($data as $item) {
            return $item;
        }

        // if we get here, then $data was empty
        return $default;
    }

    /**
     * called when we've been given a data type we do not support
     *
     * @param  mixed $data
     *         the data to filter
     * @param  mixed $default
     *         the data to return when we cannot filter $data
     * @return mixed
     */
    private static function nothingMatchesTheInputType($data, $default)
    {
        return $default;
    }

    /**
     * lookup map of how to convert which data type
     *
     * @var array
     */
    private static $dispatchMap = [
        'String' => 'fromString',
        'Traversable' => 'fromTraversable'
    ];
}
