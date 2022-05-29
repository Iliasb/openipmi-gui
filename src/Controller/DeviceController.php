<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Device;
 
/**
 * @Route("/api", name="api_")
 */
class DeviceController extends AbstractController
{

    public function __construct(private ManagerRegistry $doctrine) {

    }

    /**
     * @Route("/device", name="device_index", methods={"GET"})
     */
    public function index(): Response
    {
        $devices = $this->doctrine
            ->getRepository(Device::class)
            ->findAll();
 
        $data = [];
 
        foreach ($devices as $device) {
           $data[] = [
               'id' => $device->getId(),
               'name' => $device->getName(),
               'ipv4' => $device->getIpv4(),
               'ipv6' => $device->getIpv6(),
               'positionStart' => $device->getPositionStart(),
               'positionEnd' => $device->getPositionEnd(),
               'rack' => $device->getRack()->getId(),
           ];
        }
 
        return $this->json($data);
    }

 
    /**
     * @Route("/device/{id}", name="device_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $device = $this->doctrine
            ->getRepository(Device::class)
            ->find($id);
 
        if (!$device) {
 
            return $this->json('No device found for id' . $id, 404);
        }
 
        $data =  [
            'id' => $device->getId(),
               'name' => $device->getName(),
               'ipv4' => $device->getIpv4(),
               'ipv6' => $device->getIpv6(),
               'positionStart' => $device->getPositionStart(),
               'positionEnd' => $device->getPositionEnd(),
               'rack' => $device->getRack()->getId(),
        ];
         
        if ($data) {
            return $this->json($data);
        }else{
            return $this->json(null, $status = 404);
        }
    }

    /**
     * @Route("/device/rack/{rack_id}", name="device_location_index", methods={"GET"})
     */
    public function showLocation(int $rack_id): Response
    {
        $devices = $this->doctrine
            ->getRepository(Device::class)
            ->findBy(['rack' => $rack_id],);
 
        foreach ($devices as $device) {
           $data[] = [
               'id' => $device->getId(),
               'name' => $device->getName(),
               'ipv4' => $device->getIpv4(),
               'ipv6' => $device->getIpv6(),
               'positionStart' => $device->getPositionStart(),
               'positionEnd' => $device->getPositionEnd(),
               'rack' => $device->getRack()->getId(),
           ];
        }
 
        if (isset($data)) {
            return $this->json($data);
        }else{
            return $this->json(null, $status = 404);
        }
        
    }
 

 
 
}