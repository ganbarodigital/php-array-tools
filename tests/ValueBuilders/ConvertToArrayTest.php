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
 * @link      http://code.ganbarodigital.com/php-array-tools
 */

namespace GanbaroDigital\ArrayTools\ValueBuilders;

use ArrayObject;
use PHPUnit_Framework_TestCase;
use stdClass;

// ----------------------------------------------------------------
// setup your test

// ----------------------------------------------------------------
// perform the change

// ----------------------------------------------------------------
// test the results



/**
 * @coversDefaultClass GanbaroDigital\ArrayTools\ValueBuilders\ConvertToArray
 */
class ConvertToArrayTest extends PHPUnit_Framework_TestCase
{
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new ConvertToArray;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(ConvertToArray::class, $unit);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideDataToConvert
     */
    public function testCanUseAsObject($data, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ConvertToArray;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($data);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::from
     * @dataProvider provideDataToConvert
     */
    public function testCanCallStatically($data, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = ConvertToArray::from($data);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromArray
     * @dataProvider provideArraysToConvert
     */
    public function testArraysAreReturnedUnchanged($data, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ConvertToArray;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($data);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromNull
     */
    public function testNullIsConvertedToEmptyArray()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ConvertToArray;
        $data = null;
        $expectedResult = [];

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($data);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromTraversable
     * @dataProvider provideTraversablesToConvert
     */
    public function testTraversablesAreConvertedToArray($data, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ConvertToArray;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($data);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::nothingMatchesTheInputType
     * @dataProvider provideEverythingElseToConvert
     */
    public function testEverythingElseIsWrappedInAnArray($data, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ConvertToArray;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($data);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function provideDataToConvert()
    {
        return [
            [ null, [], ],
            [ true, [ true ], ],
            [ false, [ false ], ],
            [ [], [], ],
            [ [ 1,2,3 ], [ 1, 2, 3 ], ],
            // [ function(){}, [ function(){} ] ]
        ];
    }

    public function provideArraysToConvert()
    {
        return [
            [ [], [], ],
            [ [ 1,2,3 ], [ 1, 2, 3 ], ],
            [ [ 'hello' => 'world'], [ 'hello' => 'world'] ],
        ];
    }

    public function provideTraversablesToConvert()
    {
        return [
            [ new ArrayObject(["hello" => "world"]), [ "hello" => "world" ] ],
            [ (object)['hello' => 'world'], ['hello' => 'world'] ],
        ];
    }

    public function provideEverythingElseToConvert()
    {
        return [
            [ true, [ true ], ],
            [ false, [ false ], ],
            [ "hello, world", [ "hello, world" ] ],
        ];
    }
}
