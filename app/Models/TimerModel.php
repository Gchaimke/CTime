<?php

namespace App\Models;

class TimerModel extends JsonModel
{
    protected $table         = 'timers';
    protected $allowedFields = [
        'in', 'out', 'total',
    ];
    protected $returnType    = \App\Entities\ClockTime::class;
    protected $useTimestamps = true;

    function get_timers($year, $month, $user_id)
    {
        $timers_file =  DATAPATH . "timers/$year/$month/$user_id.json";
        if (file_exists($timers_file)) {
            return json_decode(file_get_contents($timers_file), true);
        } else {
            return array();
        }
    }

    function put_timers($timers_file, $data)
    {
        ksort($data);
        return file_put_contents($timers_file, json_encode($data));
    }

    public function add_time($day, $month, $year, $time, $action, $user_id)
    {
        $timers_folder = DATAPATH . "timers/$year/$month";
        $timers_file =  "$timers_folder/$user_id.json";
        if (!file_exists($timers_folder)) {
            mkdir($timers_folder, 0644, true);
        }
        $timers = $this->get_timers($year, $month, $user_id);

        $date = "$day/$month/$year";

        if (!isset($timers[$date])) {
            $new_date = new \App\Entities\Timer;
            $new_date->in = array($time);
            $new_date->out = array();
            $new_date->total = 0;
            $timers[$date] = $new_date;
        } else {
            $timers[$date][$action][] = $time;
            $timers[$date]["total"] = $this->count_total($timers[$date]);
        }

        $this->put_timers($timers_file, $timers);
    }

    public function count_total($timers)
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

    public function get_last_action($user_id)
    {
        $all_timers = $this->get_timers(date("y"), date("m"), $user_id);
        $date_key = date("d") . "/" . date("m") . "/" . date("y");
        if (isset($all_timers[$date_key])) {
            $diff = count($all_timers[$date_key]["in"]) >  count($all_timers[$date_key]["out"]);
            if ($diff) {
                return array(
                    "action" => "in",
                    "time" => end($all_timers[$date_key]["in"])
                );
            } else {
                return array(
                    "action" => "out",
                    "time" => end($all_timers[$date_key]["out"])
                );
            }
        } else {
            return array(
                "action" => "none",
                "time" => ""
            );
        }
    }
}
