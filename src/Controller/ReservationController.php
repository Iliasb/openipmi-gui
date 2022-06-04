<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Reservation;

use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
 
/**
 * @Route("/api", name="api_")
 */
class ReservationController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine) {

    }

    /**
     * @Route("/reservation", name="reservation_index", methods={"GET"})
     */
    public function index(): Response
    {
        $reservations = $this->doctrine
            ->getRepository(Reservation::class)
            ->findAll();
 
        $data = [];
 
        foreach ($reservations as $reservation) {
           $data[] = [
               'id' => $reservation->getId(),
               'startAt' => $reservation->getStartAt(),
               'stopAt' => $reservation->getStopAt(),
               'user' => $reservation->getUser()->getId(),
               'created' => $reservation->getCreated(),
               'updated' => $reservation->getUpdated(),
           ];
        }
 
        return $this->json($data);
    }

 
    /**
     * @Route("/reservation/{id}", name="reservation_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $reservation = $this->doctrine
            ->getRepository(Reservation::class)
            ->find($id);
 
        if (!$reservation) {
 
            return $this->json('No reservation found for id' . $id, 404);
        }
 
        $data =  [
               'id' => $reservation->getId(),
               'startAt' => $reservation->getStartAt(),
               'stopAt' => $reservation->getStopAt(),
               'user' => $reservation->getUser()->getId(),
               'created' => $reservation->getCreated(),
               'updated' => $reservation->getUpdated(),
        ];
         
        return $this->json($data);
    }

    /**
     * @Route("/reservation/device/{device_id}", name="reservation_device_index", methods={"GET"})
     */
    public function showDevice(int $device_id): Response
    {
        $reservations = $this->doctrine
            ->getRepository(Reservation::class)
            ->findBy(['device' => $device_id],);

        $data = [];
 
        foreach ($reservations as $reservation) {
           $data[] = [
               'id' => $reservation->getId(),
               'startAt' => $reservation->getStartAt(),
               'stopAt' => $reservation->getStopAt(),
               'user' => $reservation->getUser()->getId(),
               'created' => $reservation->getCreated(),
               'updated' => $reservation->getUpdated(),
           ];
        }

         
        return $this->json($data);
    }
 

 
 
}