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

?>
<ol id="rollresults">
<?php
foreach (array_reverse($rolls) as $roll) {
	echo '<li>', "\n";
	if (isset($roll['name'])) {
		echo '<h2>', htmlentities($roll['name'], ENT_COMPAT, "utf-8"), '</h2>';
	}

	echo '<p>', htmlentities($roll['text'], ENT_COMPAT, "utf-8"), ' = ', $roll['total'], ': ';

	foreach($roll['rolls'] as $count => $val) {
		if (is_array($val)) {
			if ($val['count'] < 0) {
				echo ' - ';
			} else if ($count > 0) {
				echo ' + ';
			}
			echo '[';

			for ($i = 0; $i < count($val['detail']); $i++) {
				echo '<span', $val['detail'][$i]['chosen'] ? ' class="selected"' : '', '>';
				echo $val['detail'][$i][0];
				echo '</span>';

				if ($i < count($val['detail']) - 1) {
					echo ', ';
				}
			}

			echo ']';
		} else {
			if ($val < 0) {
				echo ' - ';
			} else if ($count > 0) {
				echo ' + ';
			}
			echo abs($val);
		}
	}

	echo '</p>', "\n";

	echo '</li>', "\n";
}
?>
</ol>
