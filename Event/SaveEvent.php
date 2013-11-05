<?php

namespace ADesigns\CalendarBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use ADesigns\CalendarBundle\Entity\EventEntity;

/**
 * Event used to store EventEntitys
 *
 * @author Mike Yudin <mikeyudin@gmail.com>
 */
class SaveEvent extends Event {

	const CONFIGURE = 'calendar.save_event';

	private $id;

	private $startDatetime;

	private $endDatetime;

	private $installationId;

	/**
	 * Constructor method requires a start and end time for event listeners to use.
	 *
	 * @param \DateTime $start
	 *        	Begin datetime to use
	 * @param \DateTime $end
	 *        	End datetime to use
	 */
	public function __construct($id,\DateTime $start,\DateTime $end) {
		$this->id = $id;
		$this->startDatetime = $start;
		$this->endDatetime = $end;
	}

	public function getStartDatetime() {
		return $this->startDatetime;
	}

	public function getEndDatetime() {
		return $this->endDatetime;
	}

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
		return $this;
	}

	public function getInstallationId() {
		return $this->installationId;
	}

	public function setInstallationId($installationId) {
		$this->installationId = $installationId;
		return $this;
	}
}