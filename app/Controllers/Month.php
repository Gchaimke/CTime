<?php

namespace App\Controllers;

class Month extends BaseController
{
    public function __construct()
    {
    }

    public function index()
    {
        $year = isset($_GET["year"]) ? $_GET["year"] : $this->now->getYear();
        $month = isset($_GET["month"]) ? $_GET["month"] : $this->now->getMonth();
        if (isset($this->data['user'])) {
            $this->data["timers"] = $this->timerModel->get_timers($year, $month, $this->data['user']['id']);
            $this->data["last_action"] = $this->timerModel->get_last_action($this->data["user"]["id"]);
        } else {
            return redirect()->to("/login");
        }
        return view("month", $this->data);
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

    function edit_date()
    {
        $return = null;
        $timers = false;
        $date_id = esc($this->request->getVar('date_id'));

        if (isset($date_id)) {
            $user_id = esc($this->request->getVar('user_id'));
            $in = array_filter(esc($this->request->getVar('in')));
            $out = array_filter(esc($this->request->getVar('out')));
            $date_status = esc($this->request->getVar('date_status'));
            $date = explode("/", $date_id);
            $timers = $this->timerModel->get_timers($date[2], $date[1], $user_id);
        }
        // die(\print_r($timers));
        if ($timers != false) {
            $timers[$date_id]["in"] = $in;
            $timers[$date_id]["out"] = $out;
            $timers[$date_id]["total"] = count_total($timers[$date_id]);
            $timers[$date_id]["is_started"] = count($in) > count($out) ? true : false;
            if ($date_status == "holiday") $timers[$date_id]["holiday"] = true;
            if ($date_status == "sickday") $timers[$date_id]["sickday"] = true;
            if ($date_status == "regular") {
                $timers[$date_id]["holiday"] = false;
                $timers[$date_id]["sickday"] = false;
            }
            $timers_file =  DATAPATH . "timers/$date[2]/$date[1]/$user_id.json";
            $return = $this->timerModel->put_timers($timers_file, $timers);
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
