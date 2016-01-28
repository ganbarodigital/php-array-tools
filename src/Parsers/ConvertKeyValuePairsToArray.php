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
 * @package   ArrayTools/Parsers
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://code.ganbarodigital.com/php-array-tools
 */

namespace GanbaroDigital\ArrayTools\Parsers;

use GanbaroDigital\ArrayTools\Exceptions\E4xx_UnsupportedType;
use GanbaroDigital\Reflection\Maps\MapTypeToMethod;
use GanbaroDigital\Reflection\ValueBuilders\SimpleType;
use Traversable;

class ConvertKeyValuePairsToArray
{
    /**
     * convert a line containing key value pairs into an array
     *
     * @param  mixed $data
     *         the data to convert
     * @param  string $kvSeparator
     *         the separator between keys and values
     * @param  string $valueSeparator
     *         the separator between values and the next key
     * @return mixed
     *         will return the same time that $data was
     */
    public function __invoke($data, $kvSeparator, $valueSeparator)
    {
        return self::from($data, $kvSeparator, $valueSeparator);
    }

    /**
     * convert a line containing key value pairs into an array
     *
     * @param  mixed $data
     *         the data to convert
     * @param  string $kvSeparator
     *         the separator between keys and values
     * @param  string $valueSeparator
     *         the separator between values and the next key
     * @return mixed
     *         will return the same time that $data was
     */
    public static function from($data, $kvSeparator, $valueSeparator)
    {
        $method = MapTypeToMethod::using($data, self::$dispatchMap);
        return self::$method($data, $kvSeparator, $valueSeparator);
    }

    /**
     * convert a line containing key value pairs into an array
     *
     * @param  Traversable|array $data
     *         the data to convert
     * @param  string $kvSeparator
     *         the separator between keys and values
     * @param  string $valueSeparator
     *         the separator between values and the next key
     * @return array
     *         a list of the key/value pairs
     */
    private static function fromTraversable($data, $kvSeparator, $valueSeparator)
    {
        // we're going to convert the contents of $data, item by item
        $retval = [];

        // build our real array
        foreach ($data as $key => $item) {
            $retval[$key] = self::from($item, $kvSeparator, $valueSeparator);
        }

        // all done :)
        return $retval;
    }

    /**
     * convert a line containing key value pairs into an array
     *
     * @param  string $data
     *         the data to convert
     * @param  string $kvSeparator
     *         the separator between keys and values
     * @param  string $valueSeparator
     *         the separator between values and the next key
     * @return array
     *         a list of the key/value pairs
     */
    private static function fromString($data, $kvSeparator, $valueSeparator)
    {
        $matches = [];
        preg_match_all("|([^$kvSeparator]+)$kvSeparator([^$valueSeparator]+)|", $data, $matches);

        $retval = array_combine($matches[1], $matches[2]);
        return $retval;
    }

    /**
     * called when we have a data type that we cannot convert
     *
     * @param  mixed $data
     *         the data to convert
     * @return void
     * @throws E4xx_UnsupportedType
     */
    private static function nothingMatchesTheInputType($data)
    {
        throw new E4xx_UnsupportedType(SimpleType::from($data));
    }

    /**
     * lookup map of how to convert which data type
     *
     * @var array
     */
    private static $dispatchMap = [
        'String' => 'fromString',
        'Traversable' => 'fromTraversable',
    ];
}
