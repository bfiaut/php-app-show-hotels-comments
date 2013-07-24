<?php 

namespace Entity;

/**
 * Comment model
 *
 * @Entity
 * @Table(name="comments")
 * @author Bastien Fiaut <bastien.fiaut@gmail.com>
 */
class Comment {

	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @Column(type="string", length=64, nullable=false)
	 */
	protected $author;

	/**
	 * @Column(type="string", length=512, nullable=false)
	 */
	protected $content;

	/**
	 * @Column(type="date")
	 */
	protected $creation_date;

	/**
	 * @ManyToOne(targetEntity="Hotel")
	 * @JoinColumn(name="hotel_id", referencedColumnName="id")
	 */
	protected $hotel;

	/**
	 * Assign the comment to a hotel
	 *
	 * @param	Entity\Hotel	$hotel
	 * @return	void
	 */
	public function setHotel(Hotel $hotel)
	{
		$this->hotel = $hotel;

		// The association must be defined in both directions
		if (!$hotel->getComments()->contains($this)) {
			$hotel->addComment($this);
		}
	}

	/**
	 * Get author
	 * 
	 * @return string
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * Set author
	 * 
	 * @param string $author
	 * @return Comment
	 */
	public function setAuthor($author) {
		$this->author = $author;
		return $this;
	}

	/**
	 * Get id
	 * 
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Get content
	 *
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * Set content
	 * 
	 * @param string $content
	 * @return Comment
	 */
	public function setContent($content) {
		$this->content = $content;
		return $this;
	}

	/**
	 * Get Creation date
	 *
	 * @return date
	 */
	public function getCreationDate() {
		return $this->creation_date;
	}

	/**
	 * Set creation date
	 * 
	 * @param date $creation_date 
	 * @return Comment
	 */
	public function setCreationDate($creation_date) {
		$this->creation_date = $creation_date;
		return $this;
	}

	/**
	 * Get Hotel
	 *
	 * @return Hotel
	 */
	public function getHotel() {
		return $this->hotel;
	}

}