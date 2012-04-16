<?php
/*
 *  This file is part of 3d6.com.ar.

 *  3d6.com.ar is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.

 *  3d6.com.ar is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU Affero General Public License for more details.

 *  You should have received a copy of the GNU Affero General Public
 *  License along with 3d6.com.ar.  If not, see
 *  <http://www.gnu.org/licenses/>.
 */

require_once 'PHPUnit/Framework.php';
require("../parser.php");

class ParserTest extends PHPUnit_Framework_TestCase
{
	function testSingleNumbersShouldParseStraight()
	{
		$x = parseRoll('4');

		$this->assertEquals(array(array('text' => '4',
		                                'rolls' => array(4))),
		                    $x);
	}

	function testSingleNumbersShouldParseStraight2()
	{
		$x = parseRoll('4567890');

		$this->assertEquals(array(array('text' => '4567890',
		                                'rolls' => array(4567890))),
		                    $x);
	}

	function testASimpleAdditionShouldNotHaveExtraFluff()
	{
		$x = parseRoll('4+4');

		$this->assertEquals(array(array('text' => '4+4',
		                                'rolls' => array(4, 4))),
	                        $x);
	}

	function testSpacesAreIrrelevant()
	{
		$x = parseRoll('3d6 + 2');

		$this->assertEquals(array(array('text' => '3d6 + 2',
		                                'rolls' => array(array('count' => '3',
		                                                       'sides' => '6'),
		                                2))),
		                    $x);
	}

	function testTrivialNegativeCase()
	{
		$x = parseRoll('-4');

		$this->assertEquals(array(array('text' => '-4',
		                                'rolls' => array(-4))),
		                    $x);
	}

	function testSimpleCase()
	{
		$x = parseRoll('3d6');

		$this->assertEquals(array(array('text' => '3d6',
		                                'rolls' => array(array('count' => 3, 'sides' => 6)))),
		                    $x);
	}

	function testSimpleRollSubstraction()
	{
		$x = parseRoll('1d10 - 1d10');

		$this->assertEquals((array(array('text' => '1d10 - 1d10',
		                                 'rolls' => array(array('count' => 1,
		                                                        'sides' => 10),
		                                                  array('count' => -1,
		                                                        'sides' => 10))))),
		                    $x);
	}

	function testSimpleMultipleDigits()
	{
		$x = parseRoll('3d10');

		$this->assertEquals(array(array('text' => '3d10',
		                                'rolls' => array(array('count' => 3, 'sides' => 10)))),
		                    $x);
	}

	function testSimpleNegativeCase()
	{
		$x = parseRoll('-3d6');

		$this->assertEquals(array(array('text' => '-3d6',
		                                'rolls' => array(array('count' => -3, 'sides' => 6)))),
		                    $x);
	}

	function testSimpleAddition()
	{
		$x = parseRoll('3d6+4');

		$this->assertEquals(array(array('text' => '3d6+4',
		                                'rolls' => array(array('count' => 3, 'sides' => 6),
		                                                 4))),
		                    $x);
	}

	function testSimpleSubstraction()
	{
		$x = parseRoll('3d6-4');

		$this->assertEquals(array(array('text' => '3d6-4',
		                                'rolls' => array(array('count' => 3, 'sides' => 6),
		                                                 -4))),
		                    $x);
	}

	function testSimpleLabel()
	{
		$x = parseRoll('4 [Str]');


		$this->assertEquals(array(array('text' => '4',
		                                'name' => 'Str',
		                                'rolls' => array(4))),
		                    $x);
	}

	function testMultipleRolls()
	{
		$x = parseRoll('3d6; 2d4; 1d8');

		$this->assertEquals(array(array('text' => '3d6',
		                                'rolls' => array(array('count' => 3, 'sides' => 6))),
		                          array('text' => '2d4',
		                                'rolls' => array(array('count' => 2, 'sides' => 4))),
		                          array('text' => '1d8',
		                                'rolls' => array(array('count' => 1, 'sides' => 8)))),
		                    $x);
	}

	function testMultipleLabels()
	{
		$x = parseRoll('3d6 [Str]; 2d4 [Starting Cash]; 1d8 [HP]');


		$this->assertEquals(array(array('text' => '3d6',
		                                'name' => 'Str',
		                                'rolls' => array(array('count' => 3, 'sides' => 6))),
		                          array('text' => '2d4',
		                                'name' => 'Starting Cash',
		                                'rolls' => array(array('count' => 2, 'sides' => 4))),
		                          array('text' => '1d8',
		                                'name' => 'HP',
		                                'rolls' => array(array('count' => 1, 'sides' => 8)))),
		                    $x);
	}

	function testSimpleRepetition()
	{
		$x = parseRoll('4 veces 3d6');

		$this->assertEquals(array(array('text' => '3d6',
		                                'rolls' => array(array('count' => 3, 'sides' => 6))),
		                          array('text' => '3d6',
		                                'rolls' => array(array('count' => 3, 'sides' => 6))),
		                          array('text' => '3d6',
		                                'rolls' => array(array('count' => 3, 'sides' => 6))),
		                          array('text' => '3d6',
		                                'rolls' => array(array('count' => 3, 'sides' => 6)))),
		                    $x);
	}

	function testSimpleRepetitionLabels()
	{
		$x = parseRoll('4 veces 3d6 [Str, Dex, Int, Sab]');

		$this->assertEquals(array(array('text' => '3d6',
		                                'name' => 'Str',
		                                'rolls' => array(array('count' => 3, 'sides' => 6))),
		                          array('text' => '3d6',
		                                'name' => 'Dex',
		                                'rolls' => array(array('count' => 3, 'sides' => 6))),
		                          array('text' => '3d6',
		                                'name' => 'Int',
		                                'rolls' => array(array('count' => 3, 'sides' => 6))),
		                          array('text' => '3d6',
		                                'name' => 'Sab',
		                                'rolls' => array(array('count' => 3, 'sides' => 6)))),
		                    $x);
	}

	function testBetter()
	{
		$x = parseRoll('3 mejores de 4d6');

		$this->assertEquals(array(array('text' => '3 mejores de 4d6',
		                                'rolls' => array(array('top' => 3,
		                                                       'count' => 4,
		                                                       'sides' => 6)))),
		                    $x);
	}

	function testLongBetter()
	{
		$x = parseRoll('300 mejores de 400d6');

		$this->assertEquals(array(array('text' => '300 mejores de 400d6',
		                                'rolls' => array(array('top' => 300,
		                                                       'count' => 400,
		                                                       'sides' => 6)))),
		                    $x);
	}

	function testWorse()
	{
		$x = parseRoll('3 peores de 4d6');


		$this->assertEquals(array(array('text' => '3 peores de 4d6',
		                                'rolls' => array(array('bottom' => 3,
		                                                       'count' => 4,
		                                                       'sides' => 6)))),
		                    $x);
	}

	function testDNDGen()
	{
		$x = parseRoll('6 veces 3 mejores de 4d6 [Fue, Des, Con, Int, Sab, Car]');

		$this->assertEquals(array(array('text' => '3 mejores de 4d6',
		                                'name' => 'Fue',
		                                'rolls' => array(array('top' => 3,
		                                                       'count' => 4,
		                                                       'sides' => 6))),
		                          array('text' => '3 mejores de 4d6',
		                                'name' => 'Des',
		                                'rolls' => array(array('top' => 3,
		                                                       'count' => 4,
		                                                       'sides' => 6))),
		                          array('text' => '3 mejores de 4d6',
		                                'name' => 'Con',
		                                'rolls' => array(array('top' => 3,
		                                                       'count' => 4,
		                                                       'sides' => 6))),
		                          array('text' => '3 mejores de 4d6',
		                                'name' => 'Int',
		                                'rolls' => array(array('top' => 3,
		                                                       'count' => 4,
		                                                       'sides' => 6))),
		                          array('text' => '3 mejores de 4d6',
		                                'name' => 'Sab',
		                                'rolls' => array(array('top' => 3,
		                                                       'count' => 4,
		                                                       'sides' => 6))),
		                          array('text' => '3 mejores de 4d6',
		                                'name' => 'Car',
		                                'rolls' => array(array('top' => 3,
		                                                       'count' => 4,
		                                                       'sides' => 6)))),
		                    $x);
	}

	function testHalfAssedLabels()
	{
		$x = parseRoll('3d4 [Fue]; 2d4');

		$this->assertEquals(array(array('text' => '3d4',
		                                'name' => 'Fue',
		                                'rolls' => array(array('count' => 3, 'sides' => 4))),
		                          array('text' => '2d4',
		                                'rolls' => array(array('count' => 2, 'sides' => 4)))),
		                    $x);
	}

	function testMixedRepeatAndSeparate()
	{
		$x = parseRoll('2 veces 2d4; 1d4');

		$this->assertEquals(array(array('text' => '2d4',
		                                'rolls' => array(array('count' => 2, 'sides' => 4))),
		                          array('text' => '2d4',
		                                'rolls' => array(array('count' => 2, 'sides' => 4))),
		                          array('text' => '1d4',
		                                'rolls' => array(array('count' => 1, 'sides' => 4)))),
		                    $x);
	}

	function testSimpleReroll()
	{
		$x = parseRoll('3d6 repitiendo 1');

		$this->assertEquals(array(array('text' => '3d6 repitiendo 1',
		                                'rolls' => array(array('count' => 3,
		                                                       'sides' => 6,
		                                                       'reroll' => array(1))))),
		                    $x);
	}

	function testMultipleReroll()
	{
		$x = parseRoll('3d6 repitiendo 1, 2');

		$this->assertEquals(array(array('text' => '3d6 repitiendo 1, 2',
		                                'rolls' => array(array('count' => 3,
		                                                       'sides' => 6,
		                                                       'reroll' => array(1, 2))))),
		                    $x);
	}

	function testBigRepeat()
	{
		$x = parseRoll('20 veces 4');

		$this->assertEquals(array_fill(0, 20, array('text' => '4', 'rolls' => array(4))),
		                    $x);
	}

	function testIgnoreShouldAddTopIfThereIsNone()
	{
		$x = parseRoll('3d6 ignorando 1');

		$this->assertEquals(array(array('text' => '3d6 ignorando 1',
		                                'rolls' => array(array('top' => 3,
		                                                       'count' => 3,
		                                                       'sides' => 6,
		                                                       'reroll' => array(1))))),
		                    $x);
	}

	function testIgnoreShouldNotAddTopIfThereIsOne()
	{
		$x = parseRoll('3 mejores de 4d6 ignorando 1');

		$this->assertEquals(array(array('text' => '3 mejores de 4d6 ignorando 1',
		                                'rolls' => array(array('top' => 3,
		                                                       'count' => 4,
		                                                       'sides' => 6,
		                                                       'reroll' => array(1))))),
		                    $x);
	}

	function testExplode()
	{
		$x = parseRoll('3d6 continuando 6');

		$this->assertEquals(array(array('text' => '3d6 continuando 6',
		                                'rolls' => array(array('count' => 3,
		                                                       'sides' => 6,
		                                                       'explode' => array(6))))),
		                    $x);
	}

	function testEternalRepeat()
	{
		$x = parseRoll('3d6 continuando 1,2,3,4,5,6');

		$this->assertEquals(array(array('text' => '3d6 continuando 1,2,3,4,5,6',
		                                'rolls' => array(array('count' => 3,
		                                                       'sides' => 6,
		                                                       'explode' => array())))),
		                    $x);
	}
}
