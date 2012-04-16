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

require('include/tiny.php');
require('include/parser.php');
require('include/roll.php');
require 'include/db.php';

$url = $_GET['url'];

$st = $DB->prepare("SELECT * FROM rolls WHERE url = ?");
$st->execute(array($url));
$result = $st->fetch(PDO::FETCH_ASSOC);

$rawRolls = $result['roll'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	if ($result['verification'] !== '' &&
		$result['verification'] !== $_POST['verification']) {
		die("Wrong verification code.");
	}

	if ($rawRolls != '') {
		$rawRolls .= ';' . $_POST['rolls'];
	} else {
		$rawRolls = $_POST['rolls'];
	}

	$parsedRolls = parseRoll($rawRolls);

	if (count($parsedRolls) == 0) {
		header ("Location: /");
		die();
	}

	$verification = md5(mt_rand());

	$st = $DB->prepare("UPDATE rolls SET roll = ?, verification = ? WHERE url = ?");
	$st->execute(array($rawRolls, $verification, $url));

	$count = 0;
	$rolls = roll($parsedRolls, $result['seed'], &$count);

	ShowTemplate('roll', array('rolls' => $rolls,
	                           'url' => $url,
	                           'count' => $count,
	                           'verification' => $verification));
	die();
}

$rolls = roll(parseRoll($rawRolls), $result['seed']);

ShowTemplate('showroll', array('rolls' => $rolls));
