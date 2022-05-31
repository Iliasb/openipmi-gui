<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Device;

use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
 
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
    public function index(AdminUrlGenerator $adminUrlGenerator): Response
    {
        $devices = $this->doctrine
            ->getRepository(Device::class)
            ->findAll(array('positionStart' => 'DESC'));
 
        $data = [];
 
        foreach ($devices as $device) {

            $show_url = $adminUrlGenerator
            ->setController('App\Controller\Admin\DeviceCrudController')
            ->setAction(Crud::PAGE_DETAIL)
            ->setEntityId($device->getId())
            ->generateUrl();

            $edit_url = $adminUrlGenerator
            ->setController('App\Controller\Admin\DeviceCrudController')
            ->setAction(Crud::PAGE_EDIT)
            ->setEntityId($device->getId())
            ->generateUrl();

           $data[] = [
               'id' => $device->getId(),
               'name' => $device->getName(),
               'ipv4' => $device->getIpv4(),
               'ipv6' => $device->getIpv6(),
               'positionStart' => $device->getPositionStart(),
               'positionEnd' => $device->getPositionEnd(),
               'rack' => $device->getRack()->getId(),
               'url_link' => $device->getIpv4().$device->getDeviceGroup()->getWebInterface(),
               'url_show' => $show_url,
               'url_edit' => $edit_url,
           ];
        }
 
        return $this->json($data);
    }

 
    /**
     * @Route("/device/{id}", name="device_show", methods={"GET"})
     */
    public function show(int $id,AdminUrlGenerator $adminUrlGenerator): Response
    {
        $device = $this->doctrine
            ->getRepository(Device::class)
            ->find($id);
 
        if (!$device) {
 
            return $this->json('No device found for id' . $id, 404);
        }

        $show_url = $adminUrlGenerator
            ->setController('App\Controller\Admin\DeviceCrudController')
            ->setAction(Crud::PAGE_DETAIL)
            ->setEntityId($id)
            ->generateUrl();

        $edit_url = $adminUrlGenerator
            ->setController('App\Controller\Admin\DeviceCrudController')
            ->setAction(Crud::PAGE_EDIT)
            ->setEntityId($id)
            ->generateUrl();

        $url_list_reservation = $adminUrlGenerator
            ->setController('App\Controller\Admin\ReservationCrudController')
            ->setAction(Crud::PAGE_INDEX)
            //->setFilter($device->getName())
            ->generateUrl();

        $url_new_reservation = $adminUrlGenerator
            ->setController('App\Controller\Admin\ReservationCrudController')
            ->setAction(Crud::PAGE_NEW)
            ->generateUrl();
 
        $data =  [
            'id' => $device->getId(),
               'name' => $device->getName(),
               'ipv4' => $device->getIpv4(),
               'ipv6' => $device->getIpv6(),
               'positionStart' => $device->getPositionStart(),
               'positionEnd' => $device->getPositionEnd(),
               'rack' => $device->getRack()->getId(),
               'url_link' => $device->getIpv4().$device->getDeviceGroup()->getWebInterface(),
               'url_show' => $show_url,
               'url_edit' => $edit_url,
               'url_list_reservation' => $url_list_reservation,
               'url_new_reservation' => $url_new_reservation,
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
    public function showLocation(int $rack_id,AdminUrlGenerator $adminUrlGenerator): Response
    {
        $devices = $this->doctrine
            ->getRepository(Device::class)
            ->findBy(['rack' => $rack_id],array('positionStart' => 'DESC'));
 
        foreach ($devices as $device) {

            $show_url = $adminUrlGenerator
            ->setController('App\Controller\Admin\DeviceCrudController')
            ->setAction(Crud::PAGE_DETAIL)
            ->setEntityId($device->getId())
            ->generateUrl();

            $edit_url = $adminUrlGenerator
            ->setController('App\Controller\Admin\DeviceCrudController')
            ->setAction(Crud::PAGE_EDIT)
            ->setEntityId($device->getId())
            ->generateUrl();

           $data[] = [
               'id' => $device->getId(),
               'name' => $device->getName(),
               'ipv4' => $device->getIpv4(),
               'ipv6' => $device->getIpv6(),
               'positionStart' => $device->getPositionStart(),
               'positionEnd' => $device->getPositionEnd(),
               'rack' => $device->getRack()->getId(),
               'url_link' => $device->getIpv4().$device->getDeviceGroup()->getWebInterface(),
               'url_show' => $show_url,
               'url_edit' => $edit_url,
           ];
        }
 
        if (isset($data)) {
            return $this->json($data);
        }else{
            return $this->json(null, $status = 404);
        }
        
    }
 

 
 
}