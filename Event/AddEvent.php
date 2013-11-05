<?php

namespace ADesigns\CalendarBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use ADesigns\CalendarBundle\Entity\EventEntity;

/**
 * Event used to store EventEntitys
 *
 * @author Mike Yudin <mikeyudin@gmail.com>
 */
class AddEvent extends Event {

	const CONFIGURE = 'calendar.add_event';

	private $userId;

	private $startDatetime;

	private $endDatetime;

	private $eventId;

	private $title;

	private $installationId;

	/**
	 * Constructor method requires a start and end time for event listeners to use.
	 *
	 * @param \DateTime $start
	 *        	Begin datetime to use
	 * @param \DateTime $end
	 *        	End datetime to use
	 */
	public function __construct(\DateTime $start,\DateTime $end, $userId, $installationId) {
		$this->userId = $userId;
		$this->startDatetime = $start;
		$this->endDatetime = $end;
		$this->installationId = $installationId;
	}

	public function getStartDatetime() {
		return $this->startDatetime;
	}

	public function getEndDatetime() {
		return $this->endDatetime;
	}

	public function getUserId() {
		return $this->userId;
	}

	public function setUserId($id) {
		$this->userId = $id;
		return $this;
	}

	public function getEventId() {
		return $this->eventId;
	}

	public function setEventId($eventId) {
		$this->eventId = $eventId;
		return $this;
	}

	public function getTitle() {
		return $this->title;
	}

	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	public function setStartDatetime($startDatetime) {
		$this->startDatetime = $startDatetime;
		return $this;
	}

	public function setEndDatetime($endDatetime) {
		$this->endDatetime = $endDatetime;
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