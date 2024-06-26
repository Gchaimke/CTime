<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use CodeIgniter\I18n\Time;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $session;
    public $data;
    public $now;
    public $userModel;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        helper("time");
        helper("debug");
        helper('html');
        $this->userModel = model('App\Models\UserModel');
        $this->timerModel = model('App\Models\TimerModel');
        $this->projectModel = model('App\Models\ProjectModel');


        $this->session = \Config\Services::session();
        $time = new Time();
        $this->now = $time->now($this->session->timezone);

        $this->data = array();
        $this->data["message_type"] = "primary";
        $this->data["message_text"] = "";
        $this->data["now"] = $this->now;

        if (!isset($this->session->logged_in) || !$this->session->logged_in) {
            return redirect()->to("/login");
        } else {
            $this->data["user"] = [
                'id'  => $this->session->id,
                "username" => $this->session->username,
                "view_name" => $this->session->view_name,
                "logged_in" => $this->session->logged_in,
                "timezone" => $this->session->timezone,
                "role" => $this->session->role,
            ];
        }
    }
}
