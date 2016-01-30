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

use ArrayObject;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * @coversDefaultClass GanbaroDigital\ArrayTools\Filters\ExtractFirstItemWithContent
 */
class ExtractFirstItemWithContentTest extends PHPUnit_Framework_TestCase
{
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new ExtractFirstItemWithContent;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(ExtractFirstItemWithContent::class, $unit);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideDataToFilter
     */
    public function testCanUseAsObject($data, $default, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ExtractFirstItemWithContent;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($data, $default);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::from
     * @dataProvider provideDataToFilter
     */
    public function testCanCallStatically($data, $default, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = ExtractFirstItemWithContent::from($data, $default);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromString
     * @dataProvider provideStringsToFilter
     */
    public function testStringsAreTreatedAsSpaceSeparated($data, $default, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ExtractFirstItemWithContent;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($data, $default);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromTraversable
     * @dataProvider provideTraversablesToFilter
     */
    public function testTraversablesHaveTheirFirstEntryReturned($data, $default, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ExtractFirstItemWithContent;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($data, $default);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromString
     * @covers ::fromTraversable
     * @dataProvider provideEmptyDataToFilter
     */
    public function testDefaultDataIsReturnedWhenTraversableIsEmpty($data, $default, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ExtractFirstItemWithContent;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($data, $default);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromString
     * @covers ::fromTraversable
     * @dataProvider provideTraversablesWithEmptyFirstItemToFilter
     */
    public function testDefaultDataIsReturnedWhenFirstItemInTraversableIsEmpty($data, $default, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ExtractFirstItemWithContent;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($data, $default);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::nothingMatchesTheInputType
     * @dataProvider provideEverythingElseToFilter
     */
    public function testDefaultDataIsReturnedWhenWeCannotFilter($data, $default, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ExtractFirstItemWithContent;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($data, $default);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function provideDataToFilter()
    {
        return array_merge(
            $this->provideStringsToFilter(),
            $this->provideTraversablesToFilter(),
            $this->provideTraversablesWithEmptyFirstItemToFilter(),
            $this->provideEmptyDataToFilter(),
            $this->provideEverythingElseToFilter()
        );
    }

    public function provideStringsToFilter()
    {
        return [
            [ "scope global interface lo eth0", null, 'scope' ],
            [ "scope global interface lo", null, 'scope' ],
        ];
    }

    public function provideTraversablesToFilter()
    {
        return [
            [ new ArrayObject(["scope", "global", "interface lo"]), null, 'scope' ],
            [ (object)[ "global interface", "lo"], null, "global interface" ],
        ];
    }

    public function provideTraversablesWithEmptyFirstItemToFilter()
    {
        return [
            [ new ArrayObject(["", "global", "interface lo"]), null, null ],
            [ (object)[ " ", "global interface", "lo"], null, null ],
        ];
    }

    public function provideEmptyDataToFilter()
    {
        return [
            [ new ArrayObject([]), 'hello', 'hello' ],
            [ (object)[], 'hello', 'hello' ],
            [ '', 'hello', 'hello' ]
        ];
    }

    public function provideEverythingElseToFilter()
    {
        return [
            [ true, 'hello', 'hello' ],
            [ false, 'hello', 'hello' ],
            [ 0.0, 'hello', 'hello' ],
            [ 3.1415927, 'hello', 'hello' ],
            [ 0, 'hello', 'hello' ],
            [ 100, 'hello', 'hello' ],
            [ STDIN, 'hello', 'hello' ]
        ];
    }
}
