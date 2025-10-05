<?php

function debug($data, $print = True, $die = True)
{
    print("\n<pre style='text-align: left;'>");
    if (!is_string($data) || !is_numeric($data)) {
        $data = \print_r($data, true);
    }
    if ($print) print($data);
    print("</pre>\n");
    if ($die) die();
    log_message('debug', $data);
}
