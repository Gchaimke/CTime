<?php

namespace App\Controllers;

use DateTime;

class Month extends BaseController
{
    public function __construct()
    {
    }

    public function index()
    {
        $year = isset($_GET["year"]) ? $_GET["year"] : $this->now->getYear();
        $month = isset($_GET["month"]) ? $_GET["month"] : $this->now->getMonth();
        $last_action = $this->timerModel->get_last_action($this->data["user"]["id"]);
        $this->data["timers"] = $this->timerModel->get_timers($year, $month, $this->data['user']['id']);
        $this->data["last_action"] = $last_action;
        $this->data["in"] = $last_action["action"] == "in" ? 'hidden' : '';
        $this->data["out"] = $last_action["action"] == "out" ? 'hidden' : '';
        $this->data["month"] = $month;
        $this->data["month_name"] = DateTime::createFromFormat('!m', $month)->format('F');
        return view("month/view", $this->data);
    }

    function action()
    {
        $action = $this->request->getVar('action');
        $time = $this->now->toTimeString();
        $this->timerModel->add_time(
            $this->now->getDay(),
            $this->now->getMonth(),
            $this->now->getYear(),
            $time,
            $action,
            $this->data['user']['id']
        );
        echo "$action: $time";
    }

    function add_date()
    {
        $user_id = esc($this->request->getVar('user_id'));
        $date = esc($this->request->getVar('date')); //2022-02-03
        $date = explode("-", $date);
        if (\count($date) == 3) {
            $yaer = intval($date[0]);
            $month = intval($date[1]);
            $day = intval($date[2]);
            $timers = $this->timerModel->get_timers($yaer, $month, $user_id);
            if (\in_array("$day/$month/$yaer", $timers)) {
                return "This date already set";
            }
            $new_date = new \App\Entities\Timer;
            $timers["{$day}/{$month}/{$yaer}"] = $new_date;
            $timers_folder =  DATAPATH . "timers/$yaer/$month";
            $this->timerModel->put_timers($timers_folder, $user_id, $timers);
            return "The new date added successfutly";
        }
    }

    function edit_date()
    {
        $return = null;
        $timers = false;
        $date_id = esc($this->request->getVar('date_id'));
        $user_id = esc($this->request->getVar('user_id'));
        $date_status = esc($this->request->getVar('date_status'));

        if (isset($date_id)) {
            $date = explode("/", $date_id);
            $timers = $this->timerModel->get_timers($date[2], $date[1], $user_id);
            $in = array_filter(esc($this->request->getVar('in')));
            $out = array_filter(esc($this->request->getVar('out')));
        }
        if ($timers != false) {
            $timers[$date_id]["in"] = $in;
            $timers[$date_id]["out"] = $out;
            $timers[$date_id]["total"] = count_total($timers[$date_id]);
            $timers[$date_id]["is_started"] = count($in) > count($out) ? true : false;
            if ($date_status == "holiday") $timers[$date_id]["holiday"] = true;
            if ($date_status == "sick_day") $timers[$date_id]["sick_day"] = true;
            if ($date_status == "regular") {
                $timers[$date_id]["holiday"] = false;
                $timers[$date_id]["sick_day"] = false;
            }
            $timers_folder =  DATAPATH . "timers/$date[2]/$date[1]";
            $return = $this->timerModel->put_timers($timers_folder, $user_id, $timers);
        }
        if (isset($return)) {
            if ($return) {
                $this->data['message_type'] = "success";
                $this->data['message_text'] = "Date updated!";
            } else {
                $this->data['message_type'] = "danger";
                $this->data['message_text'] = "Date not updated!";
            }
        }
        return $this->index();
    }
}
