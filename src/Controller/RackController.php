<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Rack;
 
/**
 * @Route("/api", name="api_")
 */
class RackController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine) {

    }

    /**
     * @Route("/rack", name="rack_index", methods={"GET"})
     */
    public function index(): Response
    {
        $racks = $this->doctrine
            ->getRepository(Rack::class)
            ->findAll();
 
        $data = [];
 
        foreach ($racks as $rack) {
           $data[] = [
               'id' => $rack->getId(),
               'tag' => $rack->getTag(),
               'devices' => $rack->getDeviceCount(),
               'locationId' => $rack->getLocation()->getId(),
           ];
        }
 
        return $this->json($data);
    }

 
    /**
     * @Route("/rack/{id}", name="rack_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $rack = $this->doctrine
            ->getRepository(Rack::class)
            ->find($id);
 
        if (!$rack) {
 
            return $this->json('No rack found for id' . $id, 404);
        }
 
        $data =  [
            'id' => $rack->getId(),
            'tag' => $rack->getTag(),
            'devices' => $rack->getDeviceCount(),
            'locationId' => $rack->getLocation()->getId(),
        ];
         
        return $this->json($data);
    }

    /**
     * @Route("/rack/location/{location_id}", name="rack_location_index", methods={"GET"})
     */
    public function showLocation(int $location_id): Response
    {
        $racks = $this->doctrine
            ->getRepository(Rack::class)
            ->findBy(['location' => $location_id],);
 
        foreach ($racks as $rack) {
           $data[] = [
               'id' => $rack->getId(),
               'tag' => $rack->getTag(),
               'devices' => $rack->getDeviceCount(),
               'locationId' => $rack->getLocation()->getId(),
           ];
        }
 
         
        return $this->json($data);
    }
 

 
 
}