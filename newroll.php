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

require 'include/db.php';

$q = $DB->prepare("SELECT url FROM rolls WHERE url = ?");
$url = null;

do {
	$url = base_convert(mt_rand(), 10, 36);
	$q->execute(array($url));
} while ($q->fetch());

$seed = mt_rand();
$st = $DB->prepare("INSERT INTO rolls (seed, url) VALUES (?, ?)");
$st->execute(array($seed, $url));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	header("Location: rolls/$url", TRUE, 307);
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	echo $url;
}
