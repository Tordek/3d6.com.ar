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

$help = array(
	"Ponele nombre a tus tiradas" => "3d6 [Fuerza]",
	"Tirá dos tipos de dados a la vez" => "2d10; 2d4",
	"Hacé varias tiradas juntas" => "4 veces 4d4",
	"Elegí los dados que más te convengan" => "3 mejores de 4d6; 2 peores de 3d10",
	"Volvé a tirar cuando sea necesario (como especialista en MdT)" => "5d10 repitiendo 10",
	"O ignorá los números feos (creando PJs 'más grosos' en AD&D)" => "3d6 ignorando 1",
	"O seguí tirando mientras saques el mismo número (atacando en L5A)" => "3 mejores de 5d10 continuando 10",
	"Y no es necesario repetir de a uno" => "3d6 continuando 5, 6",
	"Hacé aritmética básica" => "2d10 + 2; 3d6 - 4; 1d6 - 1d6",
	"Generá un personaje de D&D 3era" => "6 veces 3 mejores de 4d6 [Fue, Des, Con, Int, Sab, Car]",
	"¡Y mezclalas como más te guste!" => "2d10 - 2 + 3 mejores de 5d6 + 3 peores de 4d8 continuando 6, 7, 8"
	);

ShowTemplate('help', array('help' => $help));
