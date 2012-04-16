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


function mark($numbers, $count, $top = true)
{
	$sorted = array();

	foreach ($numbers as $index => $value) {
		$sorted[$index] = array($value, $index);
	}

	array_multisort($sorted, $top ? SORT_DESC : SORT_ASC);

	$picked = array_slice($sorted, 0, $count);

	foreach ($numbers as &$value) {
		$value = array($value, false);
	}

	foreach ($picked as $element) {
		$numbers[$element[1]]['chosen'] = true;
	}

	return $numbers;
}

function roll($rolls, $seed, $count=0)
{
	mt_srand($seed);

	for ($i = 0; $i < $count; ++$i) {
		mt_rand();
	}

	foreach ($rolls as &$roll) {
		$total = 0;

		foreach ($roll['rolls'] as &$die) {
			if (is_array($die)) {
				$value = 0;
				$detail = array();

				if (abs($die['count']) > 100) {
					die('Dejate de joder, no tenés tantos dados.');
				}

				for ($i = 0; $i < abs($die['count']); ++$i) {
					$sum = 0;

					do {
						$number = mt_rand(1, $die['sides']);
						$count++;
						$sum += $number;
					} while (isset($die['explode']) && in_array($number, $die['explode']));

					$detail[] = $sum;

					if (isset($die['reroll']) && in_array($number, $die['reroll'])) {
						--$i;
					}
				}

				$detail = mark($detail,
				               isset($die['top'])    ? $die['top'] :
				              (isset($die['bottom']) ? $die['bottom'] :
				                                       count($detail)),
				               isset($die['top']));

				foreach ($detail as $rolled) {
					if (isset($rolled['chosen'])) {
						if ($die['count'] > 0) {
							$value += $rolled[0];
						} else {
							$value -= $rolled[0];
						}
					}
				}

				$die['detail'] = $detail;
				$die['value'] = $value;
			} else {
				$value = $die;
			}

			$total += $value;
		}

		$roll['total'] = $total;
	}

	return $rolls;
}
