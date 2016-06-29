<?php

namespace ADesigns\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ADesigns\CalendarBundle\Event\CalendarEvent;
use ADesigns\CalendarBundle\Event\SaveEvent;
use ADesigns\CalendarBundle\Event\AddEvent;

class CalendarController extends Controller {

	/**
	 * Dispatch a CalendarEvent and return a JSON Response of any events returned.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function loadCalendarAction(Request $request) {
		$startDatetime = new \DateTime ();
		$startDatetime->setTimestamp ( $request->get ( 'start' ) );
		$endDatetime = new \DateTime ();
		$endDatetime->setTimestamp ( $request->get ( 'end' ) );

		$events = $this->container->get ( 'event_dispatcher' )->dispatch (
			CalendarEvent::CONFIGURE, new CalendarEvent (
				$startDatetime,
				$endDatetime ) )->getEvents ();

		$response = new \Symfony\Component\HttpFoundation\Response ();
		$response->headers->set ( 'Content-Type', 'application/json' );

		$return_events = array ();

		foreach ( $events as $event ) {
			$return_events [] = $event->toArray ();
		}

		$response->setContent ( json_encode ( $return_events ) );

		return $response;
	}

	public function eventDraggedAction(Request $request) {
		$id = $request->get ( 'id' );

		$startDatetime = \DateTime::createFromFormat('D M d Y H:i:s e+', 
			$request->get ( 'date' ) );
		$endDatetime = \DateTime::createFromFormat('D M d Y H:i:s e+',
			$request->get ( 'end' ) );

		$event = $this->container->get ( 'event_dispatcher' )->dispatch ( SaveEvent::CONFIGURE,
			new SaveEvent (
				$id,
				$startDatetime,
				$endDatetime ) );

		$response = new \Symfony\Component\HttpFoundation\Response ();
		$response->headers->set ( 'Content-Type', 'application/json' );

		// $response->setContent(json_encode($return_events));

		return $response;
	}

	public function eventDroppedAction(Request $request) {
		$userId = $request->get ( 'id' );

		$startDatetime = \DateTime::createFromFormat('D M d Y H:i:s e+', 
			$request->get ( 'date' ) );
		$endDatetime = clone $startDatetime;
		$endDatetime->add ( new \DateInterval (
			'PT4H' ) );

		$installationId = $request->get ( 'installationId' );

		$addEvent = new AddEvent (
			$startDatetime,
			$endDatetime,
			$userId,
			$installationId );

		$event = $this->container->get ( 'event_dispatcher' )->dispatch ( AddEvent::CONFIGURE,
			$addEvent );

		$eventData = new \stdClass ();
		$eventData->title = $event->getTitle ();
		$eventData->id = $event->getEventId ();
		$eventData->start = $addEvent->getStartDatetime ()->getTimestamp ();
		$eventData->end = $addEvent->getEndDatetime ()->getTimestamp ();
		$eventData->allDay = false;

		$response = new \Symfony\Component\HttpFoundation\Response ();
		$response->headers->set ( 'Content-Type', 'application/json' );

		$response->setContent ( json_encode ( $eventData ) );

		return $response;
	}
}
