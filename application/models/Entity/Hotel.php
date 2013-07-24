<?php 

namespace Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Hotel model
 *
 * @Entity
 * @Table(name="hotels")
 * @author Bastien Fiaut <bastien.fiaut@gmail.com>
 */
class Hotel {

	/**
	 * @Id
	 * @Column(type="integer", nullable=false)
	 * @GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @Column(type="string", length=64, nullable=false)
	 */
	protected $name;

	/**
	 * @Column(type="string", length=64, nullable=false)
	 */
	protected $cityname;

	/**
	 * @Column(type="string", length=256, nullable=false)
	 */
	protected $address;

	/**
	 * @OneToMany(targetEntity="Comment", mappedBy="hotel")
	 */
	protected $comments;

	/**
	 * Initialize any collection properties as ArraysColletions
	 */
	public function __construct() {
		$this->comments = new ArrayCollection;
	}

	/**
	 * Get Id
	 * 
	 * @return integer
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * Get Name
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * Set Name
	 * 
	 * @param string $name
	 * @return Hotel
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}

	/**
	 * Get Cityname
	 * 
	 * @return string
	 */
	public function getCityname() {
		return $this->cityname;
	}

	/**
	 * Set Cityname
	 * 
	 * @param string $cityname
	 * @return Hotel
	 */
	public function setCityname($cityname) {
		$this->cityname = $cityname;
		return $this;
	}

	/**
	 * Get Address
	 * 
	 * @return string
	 */
	public function getAddress() {
		return $this->address;
	}

	/**
	 * Set Address
	 * 
	 * @param string $address
	 * @return Hotel
	 */
	public function setAddress($address) {
		$this->address = $address;
		return $this;
	}

	/**
	 * Add comments
	 * 
	 * @param Entity\Comment $comments
	 * @return Hotel
	 */
	public function addComment(\Entity\Comment $comments) {
		$this->comments[] = $comments;
		return $this;
	}

	/**
	 * Get comments
	 * 
	 * @return Doctrine\Comment\Collections\Collection
	 */
	public function getComments() {
		return $this->comments;
	}

}

?>