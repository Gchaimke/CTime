<?php
function convertToHoursMins($time, $format = '%02d:%02d')
{
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}

function count_total($timers)
{
    $total = 0;
    if (isset($timers["out"])) {
        foreach ($timers["out"] as $key => $value) {
            if (isset($timers["in"][$key])) {
                $sub_total = (strtotime($value) - strtotime($timers["in"][$key])) / 60;
                if ($sub_total < 0) {
                    $sub_total = (24 * 60) - abs($sub_total);
                }
                $total += $sub_total;
            }
        }
    }
    return $total;
}
