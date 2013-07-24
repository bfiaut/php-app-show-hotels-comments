<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Services extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('hotels_model');
		$this->load->model('comments_model');
		$this->load->library('doctrine');
		$this->em = $this->doctrine->em;
	}

	function getHotels() {
		echo json_encode($this->hotels_model->getHotels());
	}

	function getCommentsForHotel($hotel_id) {
		echo json_encode($this->hotels_model->getCommentsForHotel($hotel_id));
	}

	function createComment() {
		$comment = array(
			'author' => $this->input->post('author'),
			'content' => $this->input->post('content'),
			'hotel_id' => $this->input->post('hotel_id'),
		);
		echo json_encode($this->comments_model->createComment($comment));
	}

	function getHotelsFromId($id) {
		echo json_encode($this->hotels_model->getHotelsFromId($id));
	}

	function getCommentsFromId($hotel_id, $id) {
		echo json_encode($this->comments_model->getCommentsFromId($hotel_id, $id));
	}

	function updateComment($comment_id) {
		$content = $this->input->post('content');
		echo json_encode($this->comments_model->updateComment($comment_id, $content));
	}

}
