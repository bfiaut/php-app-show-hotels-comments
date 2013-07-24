<?php if ( !defined('BASEPATH')) exit('No direct script access allowed');

class Comments_model extends CI_Model {

	function Comments_model() {
		parent::__construct();
		$this->load->library('doctrine');
		$this->em = $this->doctrine->em;
	}

	function createComment($comment) {

		$entityHotel = $this->em->find('Entity\Hotel', $comment['hotel_id']);
		$new = new Entity\Comment;
		$new->setAuthor($comment['author']);
		$new->setContent($comment['content']);
		$date = new \DateTime();
		$date->format("Y-m-d H:i:s");
		$new->setCreationDate($date);
		$new->setHotel($entityHotel);
		$this->em->persist($new);
		$this->em->flush();
		return true;
	}

	function getCommentsFromId($hotel_id, $id) {

		$entityHotel = $this->em->find('Entity\Hotel', $hotel_id);
		$qb = $this->em->createQueryBuilder();

		$qb->select('c')
			->from('Entity\Comment', 'c')
			->where('c.id > :from_id')
			->andWhere('c.hotel = :hotel')
			->setParameters(array('from_id' => $id, 'hotel' => $entityHotel))
			->orderBy('c.id', 'DESC');
		return $qb->getQuery()->getArrayResult();
	}

	function updateComment($id, $content) {
		
		$qb = $this->em->createQueryBuilder();
		$qb->update('Entity\Comment', 'c')
			->set('c.content', $qb->expr()->literal($content))
			->where('c.id=?1')
			->setParameter(1, $id);
		return $qb->getQuery()->getArrayResult();
	}

}