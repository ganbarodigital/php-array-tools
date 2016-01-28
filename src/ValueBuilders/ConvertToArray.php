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
 * @package   ArrayTools/ValueBuilders
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2016-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://code.ganbarodigital.com/php-text-tools
 */

namespace GanbaroDigital\ArrayTools\ValueBuilders;

use GanbaroDigital\Reflection\Maps\MapTypeToMethod;
use Traversable;

class ConvertToArray
{
    /**
     * convert a piece of data to be a real PHP array
     *
     * @param  mixed $data
     *         the data to convert
     * @return array
     */
    public function __invoke($data)
    {
        return self::from($data);
    }

    /**
     * convert a piece of data to be a real PHP array
     *
     * @param  mixed $data
     *         the data to convert
     * @return array
     */
    public static function from($data)
    {
        $method = MapTypeToMethod::using($data, self::$dispatchMap);
        return self::$method($data);
    }

    /**
     * convert a piece of data to be a real PHP array
     *
     * @param  array $data
     *         the data to convert
     * @return array
     */
    private static function fromArray($data)
    {
        // no conversion required :)
        return $data;
    }

    /**
     * convert a piece of data to be a real PHP array
     *
     * @param  null $data
     *         the data to convert
     * @return array
     */
    private static function fromNull($data)
    {
        // we convert NULL into an empty array
        return [];
    }

    /**
     * convert a piece of data to be a real PHP array
     *
     * @param  Traversable $data
     *         the data to convert
     * @return array
     */
    private static function fromTraversable($data)
    {
        // we're going to convert our input data into a real PHP array
        $retval = [];

        // build our real array
        foreach ($data as $key => $item) {
            $retval[$key] = $item;
        }

        // all done :)
        return $retval;
    }

    /**
     * convert a piece of data to be a real PHP array
     *
     * @param  mixed $data
     *         the data to convert
     * @return array
     */
    private static function nothingMatchesTheInputType($data)
    {
        return [ $data ];
    }

    /**
     * lookup map of how to convert which data type
     *
     * @var array
     */
    private static $dispatchMap = [
        'Array' => 'fromArray',
        'NULL' => 'fromNull',
        'Traversable' => 'fromTraversable'
    ];
}
