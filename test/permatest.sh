#!/bin/bash

#   This file is part of 3d6.com.ar.
#
#   3d6.com.ar is free software: you can redistribute it and/or modify
#   it under the terms of the GNU Affero General Public License as
#   published by the Free Software Foundation, either version 3 of the
#   License, or (at your option) any later version.
#
#   3d6.com.ar is distributed in the hope that it will be useful,
#   but WITHOUT ANY WARRANTY; without even the implied warranty of
#   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#   GNU Affero General Public License for more details.
#
#   You should have received a copy of the GNU Affero General Public
#   License along with 3d6.com.ar.  If not, see
#   <http://www.gnu.org/licenses/>.

while true; do
    while inotifywait -rqq -e modify ..; do
        time php all_tests.php
    done
    sleep 1
done
