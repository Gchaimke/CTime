<?php

function debug($data, $print = True, $die = True)
{
    if (!is_string($data) || !is_numeric($data)) {
        $data = \print_r($data, true);
    }
    if ($print) print($data);
    if ($die) die();
    log_message('debug', $data);
}
