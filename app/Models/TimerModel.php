<?php

namespace App\Models;

use CodeIgniter\I18n\Time;

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
            if ($action == "holiday" || $action == "sickday") {
                $new_date->$action = true;
                $new_date->in = array();
                $new_date->total = 8.5 * 60;
            } else {
                $new_date->in = array($time);
                $new_date->total = 0;
            }
            $new_date->out = array();
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
        $time = new Time();
        $session = \Config\Services::session();

        $now = $time->now($session->timezone);
        $timers = $this->get_timers($now->getYear(), $now->getMonth(), $user_id);
        $date_key = $now->getDay() . "/" . $now->getMonth() . "/" . $now->getYear();
        if (isset($timers[$date_key])) {
            if ($timers[$date_key]["holiday"]) {
                return array(
                    "action" => "holiday",
                    "time" => ""
                );
            }
            if ($timers[$date_key]["sickday"]) {
                return array(
                    "action" => "sickday",
                    "time" => ""
                );
            }
            $diff = count($timers[$date_key]["in"]) >  count($timers[$date_key]["out"]);
            if ($diff) {
                return array(
                    "action" => "in",
                    "time" => end($timers[$date_key]["in"])
                );
            } else {
                return array(
                    "action" => "out",
                    "time" => end($timers[$date_key]["out"])
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
