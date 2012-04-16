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

	header("Content-type: text/html; charset=utf-8");
?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="es" lang="es">
	<head>
		<title>3d6.com.ar</title>
        <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
		<link href="/estilo.css" rel="stylesheet" type="text/css" />
	</head>

	<body>
		<div class="centered">
			<h1 id="sitename"><a href="/">3<span>d</span>6</a></h1>
			<span id="sitename-sub">.COM.AR</span>
		</div>
		<div id="body">
			<div id="main">
				<?php echo $tiny_content; ?>
			</div>
			<div id="tutorial">
				<h2>¿Qué hago?</h2>
				<!--[if IE]><p>Lo primero y más importante sería que abandones Internet 
				Explorer.</p><![endif]-->

				<p>Corto: 3d6.</p>

				<p>Largo: Hacé las tiradas que quieras. Algunos ejemplos:</p>

				<ul>
					<li>3d6</li>
					<li>2d4 + 2d8</li>
					<li>3 veces 4d6</li>
					<li>3 mejores de 5d10</li>
					<li>3 veces 2 peores de 3d10 [Fue, Des, Agi]</li>
					<li><a href="/help.php">...y varios más!</a></li>
				</ul>

				<p>Probá, a ver si lográs romper algo.</p>

				<p><a href="http://www.gnu.org/licenses/agpl-3.0.html"><img src="http://www.gnu.org/graphics/agplv3-88x31.png" alt="Licensed under AGPLv3" /></a></p>

				<div id="megusta">
					<fb:like href="http://3d6.com.ar" width="250" font="arial"></fb:like>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
		<script src="/3d6.js" type="text/javascript"></script>
		<script src="http://connect.facebook.net/es_LA/all.js#xfbml=1" type="text/javascript"></script>
	</body>
</html>
