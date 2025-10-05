<?php
function convertToHoursMins($time, $format = '%02d:%02d')
{
    if ($time < 0) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    $seconds = ($time - floor($time)) * 60;
    return sprintf($format, $hours, $minutes, $seconds);
}

function count_total($timers)
{
    $total = 0;
    // debug($timers, "Timers", true);
    foreach ($timers as $timer) {
        $sub_total = (strtotime(@$timer->out ?? date("Y-m-d H:i:s")) - strtotime(@$timer->in ?? date("Y-m-d H:i:s"))) / 60;
        if ($sub_total < 0) {
            $sub_total = (24 * 60) - abs($sub_total);
        }
        $total += $sub_total;
    }
    return $total;
}
