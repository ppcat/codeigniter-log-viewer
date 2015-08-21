<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Log Controller
 *
 * @author Mike Feng
 */
class Log extends CI_Controller {

    /**
     * Default route for rendering view
     *
     * @param String $log_date
     */
    public function index($log_date = NULL)
	{
		$this->load->library('log_library');

        if ($log_date == NULL)
        {
        	// default: today
        	$log_date = date('Y-m-d');
        }

        $data['cols'] = $this->log_library->get_file('log-'. $log_date . '.php');
        $data['log_date'] = $log_date;

		$this->load->view('log_view', $data);
	}
}
