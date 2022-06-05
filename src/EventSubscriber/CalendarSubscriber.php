<?php
//https://github.com/tattali/CalendarBundle/blob/master/src/Resources/doc/doctrine-crud.md
namespace App\EventSubscriber;

use App\Repository\ReservationRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $reservationRepository;
    private $router;

    public function __construct(
        ReservationRepository $reservationRepository,
        UrlGeneratorInterface $router
    ) {
        $this->reservationRepository = $reservationRepository;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change booking.beginAt by your start date property
        $reservations = $this->reservationRepository
            ->createQueryBuilder('reservation')
            ->where('reservation.startAt BETWEEN :start and :end OR reservation.stopAt BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult()
        ;

        foreach ($reservations as $reservation) {
            // this create the events with your data (here booking data) to fill calendar
            $reservationEvent = new Event(
                $reservation->getUser(),
                $reservation->getStartAt(),
                $reservation->getStopAt() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $reservationEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]);
            $reservationEvent->addOption(
                'url',
                $this->router->generate('app_calendar_show', [
                    'id' => $reservation->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($reservationEvent);
        }
    }
}