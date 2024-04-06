<?php

function debug($data, $print = false, $die = false)
{
    if (!is_string($data) || !is_numeric($data)) {
        $data = \print_r($data, true);
    }
    if ($print) print($data);
    if ($die) die();
    log_message('debug', $data);
}
