<?php
/*
 * Copyright (c) 2009, Guillermo O. <Tordek> Freschi
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *     * Redistributions of source code must retain the above copyright
 *       notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *     * Neither the name of Tordek nor the names of its contributors may be
 *       used to endorse or promote products derived from this software
 *       without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY Guillermo O. Freschi ''AS IS'' AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL <copyright holder> BE LIABLE FOR ANY
 * DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 * ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

define("TEMPLATE_DIR", 'template/');
define("COMPONENT_RUN_DIR", 'components/');
define("COMPONENT_TEMPLATE_DIR", 'template/components/');
define("LAYOUT_FILE", TEMPLATE_DIR . 'layout.php');

function ShowTemplate($template, $vars=null, $showLayout=true)
{
    if ($vars !== null) {
        extract($vars);
    }

    ob_start();
    include(TEMPLATE_DIR . $template . ".php");
    $tiny_content = ob_get_contents();
    ob_end_clean();

    if ($showLayout) {
        ob_start();
        include(LAYOUT_FILE);
        $output = ob_get_contents();
        ob_end_clean();
    } else {
        $output = $tiny_content;
    }

    echo $output;
}

function AddComponent($component)
{
    include(COMPONENT_RUN_DIR . $component . ".php");

    ob_start();
    include(COMPONENT_TEMPLATE_DIR. $component . ".php");
    $output = ob_get_contents();
    ob_end_clean();

    echo $output;
}
