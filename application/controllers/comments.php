<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends CI_Controller {

	public $em;

	public function __construct() {
		parent::__construct();
		$this->load->library('doctrine');
		$this->em = $this->doctrine->em;
	}

	public function index() {
		redirect('comments/show');
	}

	public function show() {

		$this->load->view('comments/hotels');
	}

}