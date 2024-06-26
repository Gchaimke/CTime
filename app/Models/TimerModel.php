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

    function __construct()
    {
        parent::__construct();
        helper("time");
    }

    function get_timers($year, $month, $user_id)
    {
        $timers_file =  DATAPATH . "timers/$year/$month/$user_id.json";
        if (file_exists($timers_file)) {
            $timers =  json_decode(file_get_contents($timers_file), true);
            return $timers;
        } else {
            return array();
        }
    }

    function put_timers($timers_folder, $user_id, $data)
    {
        uksort($data, function ($a, $b) {
            $day1 = explode("/", $a)[0];
            $day2 = explode("/", $b)[0];
            return $day1 - $day2;
        });
        if(!file_exists($timers_folder)){
            mkdir($timers_folder, 0644, true);
        }
        return file_put_contents("$timers_folder/$user_id.json", json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    public function add_time($day, $month, $year, $time, $action, $user_id)
    {
        $timers_folder = DATAPATH . "timers/$year/$month";
        if (!file_exists($timers_folder)) {
            mkdir($timers_folder, 0744, true);
        }
        $timers = $this->get_timers($year, $month, $user_id);

        $date = "$day/$month/$year";

        if (!isset($timers[$date])) {
            $new_date = new \App\Entities\Timer;
            if ($action == "holiday" || $action == "sickday") {
                $new_date->$action = true;
                $new_date->total = 8.5 * 60;
            } else {
                $new_date->in = array($time);
                $new_date->is_started = true;
            }
            $timers[$date] = $new_date;
        } else {
            if ($action == "in") {
                $timers[$date]["is_started"] = true;
            } else {
                $timers[$date]["is_started"] = false;
            }
            $timers[$date][$action][] = $time;
            $timers[$date]["total"] = count_total($timers[$date]);
        }

        $this->put_timers($timers_folder, $user_id, $timers);
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

            $status = $timers[$date_key]["is_started"];
            if ($status) {
                return array(
                    "action" => "in",
                    "time" => isset($timers[$date_key]["in"]) ? end($timers[$date_key]["in"]) : ""
                );
            } else {
                return array(
                    "action" => "out",
                    "time" => isset($timers[$date_key]["out"]) ? end($timers[$date_key]["out"]) : ""
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
