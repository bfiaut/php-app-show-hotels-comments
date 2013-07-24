<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Hotels_model extends CI_Model {

	function Hotels_model() {
		parent::__construct();
		$this->load->library('doctrine');
		$this->em = $this->doctrine->em;
	}

	function getHotels() {
		$entityHotels = $this->em->getRepository('Entity\Hotel')->findBy(array(), array('id' => 'DESC'));
		$hotels = array();
		$count = 0;
		foreach ($entityHotels as $hotel) {
			$hotels[$count]['id'] = $hotel->getId();
			$hotels[$count]['name'] = $hotel->getName();
			$hotels[$count]['cityname'] = $hotel->getCityname();
			$hotels[$count]['address'] = $hotel->getAddress();
			$count++;
		}
		return $hotels;
	}

	function getCommentsForHotel($hotel_id) {

		$entityHotel = $this->em->getRepository('Entity\Hotel')->findBy(array('id' => $hotel_id));
		$entityComments = $this->em->getRepository('Entity\Comment')->findBy(array('hotel' => $entityHotel), array('id' => 'DESC'));
		$comments = array();
		$count = 0;
		foreach ($entityComments as $comment) {
			$comments[$count]['id'] = $comment->getId();
			$comments[$count]['author'] = $comment->getAuthor();
			$comments[$count]['content'] = $comment->getContent();
			$comments[$count]['creation_date'] = $comment->getCreationDate();
			$count++;
		}
		return $comments;
	}

	function getHotelsFromId($id) {
		$qb = $this->em->createQueryBuilder();

		$qb->select('h')
			->from('Entity\Hotel', 'h')
			->where('h.id > :from_id')
			->setParameters(array('from_id' => $id))
			->orderBy('h.id', 'DESC');
		return $qb->getQuery()->getArrayResult();
	}

}