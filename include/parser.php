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


function parseRoll($string)
{
	return array_map("parseSingleRoll", normalizeRolls($string));
}

function normalizeRolls($string)
{
	$raw_rolls = explode(';', $string);

	$unparsed_rolls = array();

	foreach ($raw_rolls as $roll) {
		if (preg_match('/(\d+)\s*v[eces]*\s*([^\[]*)(?:\[([^\]]+)\])?/', $roll, $matches)) {
			$times = min(intval($matches[1]), 100);

			$labels = isset($matches[3]) ? explode(',', $matches[3])
			                             : array_fill(0, $times, '');

			for ($i = 0; $i < $times; ++$i) {
				$unparsed_rolls[] = $matches[2] . ' [' . trim($labels[$i]) . ']';
			}
		} else if (trim($roll) !== '') {
			$unparsed_rolls[] = $roll;
		}
	}

	return $unparsed_rolls;
}

function parseSingleRoll($string)
{
	$result = array();

	preg_match('/([^\[]+)(?:\[([^\]]+)\])?/', $string, $matches);
	$result['text'] = trim($matches[1]);

	if(isset($matches[2])) {
		$result['name'] = $matches[2];
	}

	preg_match_all('/[+-]?[^+-]+/', $string, $matches);

	$result['rolls'] = array_map("parseSingleDie", $matches[0]);

	return $result;
}

function parseSingleDie($string)
{
	if (preg_match('/(-?)\s*(\d+)d(\d+)/', $string, $die)) {
		$roll = array();

		$roll['count'] = empty($die[1]) ?  intval($die[2])
		                                : -intval($die[2]);
		$roll['sides'] = intval($die[3]);

		if (preg_match('/(\d+)\s*m[ejores]*/', $string, $top)) {
			$roll['top'] = intval($top[1]);
		} elseif (preg_match('/(\d+)\s*p[eores]*/', $string, $bottom)) {
			$roll['bottom'] = intval($bottom[1]);
		}

		if (preg_match('/(r[epitiendo]*|(i[gnorando]*))\s*(\d+(\s*,\s*\d+)*)/', $string, $reroll)) {
			$rerolls = explode(',', $reroll[3]);
			$roll['reroll'] = array_map('intval', $rerolls);

			if(!empty($reroll[2]) && !isset($roll['top'])) {
				$roll['top'] = $roll['count'];
			}

			if ($roll['sides'] == count($roll['reroll'])) {
				$roll['reroll'] = array();
			}
		}

		if (preg_match('/c[ontinuando]*\s*(\d+(\s*,\s*\d+)*)/', $string, $reroll)) {
			$rerolls = explode(',', $reroll[1]);
			$roll['explode'] = array_map('intval', $rerolls);

			if ($roll['sides'] <= count($roll['explode'])) {
				$roll['explode'] = array();
			}
		}

		return $roll;
	} else {
		return intval(str_replace(' ', '', $string));
	}
}
