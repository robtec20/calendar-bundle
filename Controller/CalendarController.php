<?php

namespace ADesigns\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use ADesigns\CalendarBundle\Event\CalendarEvent;
use ADesigns\CalendarBundle\Event\SaveEvent;
use ADesigns\CalendarBundle\Event\AddEvent;

class CalendarController extends Controller
{
    /**
     * Dispatch a CalendarEvent and return a JSON Response of any events returned.
     *
     * @param Request $request
     * @return Response
     */
    public function loadCalendarAction(Request $request)
    {
        $startDatetime = new \DateTime();
        $startDatetime->setTimestamp($request->get('start'));

        $endDatetime = new \DateTime();
        $endDatetime->setTimestamp($request->get('end'));

        $events = $this->container->get('event_dispatcher')->dispatch(CalendarEvent::CONFIGURE, new CalendarEvent($startDatetime, $endDatetime))->getEvents();

        $response = new \Symfony\Component\HttpFoundation\Response();
        $response->headers->set('Content-Type', 'application/json');

        $return_events = array();

        foreach($events as $event) {
            $return_events[] = $event->toArray();
        }

        $response->setContent(json_encode($return_events));

        return $response;
    }

    public function eventDraggedAction(Request $request)
    {
    	$id = $request->get('id');

    	$startDatetime = new \DateTime($request->get('start'));
        $endDatetime = new \DateTime($request->get('end'));

    	$event = $this->container->get('event_dispatcher')->dispatch(SaveEvent::CONFIGURE, new SaveEvent($id, $startDatetime, $endDatetime));

    	$response = new \Symfony\Component\HttpFoundation\Response();
    	$response->headers->set('Content-Type', 'application/json');

//     	$response->setContent(json_encode($return_events));

    	return $response;
    }

    public function eventDroppedAction(Request $request)
    {
    	$userId = $request->get('id');

    	$startDatetime = new \DateTime($request->get('start'));
    	$endDatetime = clone $startDatetime;
    	$endDatetime->add(new \DateInterval('P60M'));

    	$event = $this->container->get('event_dispatcher')->dispatch(AddEvent::CONFIGURE, new AddEvent($startDatetime, $endDatetime, $userId));

    	$response = new \Symfony\Component\HttpFoundation\Response();
    	$response->headers->set('Content-Type', 'application/json');

    	//     	$response->setContent(json_encode($return_events));

    	return $response;
    }
}
