<?php

namespace ADesigns\CalendarBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use ADesigns\CalendarBundle\Entity\EventEntity;

/**
 * Event used to store EventEntitys
 *
 * @author Mike Yudin <mikeyudin@gmail.com>
 */
class RemoveEvent extends Event {

	const CONFIGURE = 'calendar.remove_event';

	private $id;

	/**
	 * Constructor method requires a start and end time for event listeners to use.
	 *
	 * @param \DateTime $start
	 *        	Begin datetime to use
	 * @param \DateTime $end
	 *        	End datetime to use
	 */
	public function __construct($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
		return $this;
	}
}