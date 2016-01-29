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

use ArrayObject;
use GanbaroDigital\ArrayTools\Exceptions\E4xx_UnsupportedType;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * @coversDefaultClass GanbaroDigital\ArrayTools\Parsers\ConvertKeyValuePairsToArray
 */
class ConvertKeyValuePairsToArrayTest extends PHPUnit_Framework_TestCase
{
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new ConvertKeyValuePairsToArray;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(ConvertKeyValuePairsToArray::class, $unit);
    }

    /**
     * @covers ::__invoke
     * @dataProvider provideDataToConvert
     */
    public function testCanUseAsObject($data, $kvSeparator, $valueSeparator, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ConvertKeyValuePairsToArray;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($data, $kvSeparator, $valueSeparator);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::from
     * @dataProvider provideDataToConvert
     */
    public function testCanCallStatically($data, $kvSeparator, $valueSeparator, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = ConvertKeyValuePairsToArray::from($data, $kvSeparator, $valueSeparator);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromString
     * @dataProvider provideStringsToConvert
     */
    public function testStringsAreConvertedToArrays($data, $kvSeparator, $valueSeparator, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ConvertKeyValuePairsToArray;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($data, $kvSeparator, $valueSeparator);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::fromTraversable
     * @dataProvider provideTraversablesToConvert
     */
    public function testTraversablesHaveTheirContentsConverted($data, $kvSeparator, $valueSeparator, $expectedResult)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ConvertKeyValuePairsToArray;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($data, $kvSeparator, $valueSeparator);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @covers ::nothingMatchesTheInputType
     * @expectedException GanbaroDigital\ArrayTools\Exceptions\E4xx_UnsupportedType
     * @dataProvider provideEverythingElseToConvert
     */
    public function testEverythingElseIsRejected($data, $kvSeparator, $valueSeparator)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ConvertKeyValuePairsToArray;

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit($data, $kvSeparator, $valueSeparator);

        // ----------------------------------------------------------------
        // test the results
    }

    public function provideDataToConvert()
    {
        return array_merge(
            $this->provideStringsToConvert(),
            $this->provideTraversablesToConvert()
        );
    }

    public function provideStringsToConvert()
    {
        return [
            [ "scope global interface lo eth0", ' ', ' ', [ 'scope' => 'global', 'interface' => 'lo'] ],
            [ "scope global interface lo", ' ', ' ', [ 'scope' => 'global', 'interface' => 'lo'] ],
        ];
    }

    public function provideTraversablesToConvert()
    {
        return [
            [ new ArrayObject([ "scope global interface lo"]), ' ', ' ', [[ 'scope' => 'global', 'interface' => 'lo']] ],
            [ (object)[ "scope global interface lo"], ' ', ' ', [[ 'scope' => 'global', 'interface' => 'lo']] ],
        ];
    }

    public function provideEverythingElseToConvert()
    {
        return [
            [ true, ' ', ' ' ],
            [ false, ' ', ' ' ],
        ];
    }
}
