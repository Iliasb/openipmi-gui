<?php
 
namespace App\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

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
    public function index(AdminUrlGenerator $adminUrlGenerator): Response
    {
        $racks = $this->doctrine
            ->getRepository(Rack::class)
            ->findAll();
 
        $data = [];
 
        foreach ($racks as $rack) {

            $show_url = $adminUrlGenerator
            ->setController('App\Controller\Admin\RackCrudController')
            ->setAction(Crud::PAGE_DETAIL)
            ->setEntityId($rack->getId())
            ->generateUrl();

            $edit_url = $adminUrlGenerator
            ->setController('App\Controller\Admin\RackCrudController')
            ->setAction(Crud::PAGE_EDIT)
            ->setEntityId($rack->getId())
            ->generateUrl();

           $data[] = [
               'id' => $rack->getId(),
               'tag' => $rack->getTag(),
               'devices' => $rack->getDeviceCount(),
               'locationId' => $rack->getLocation()->getId(),
               'url_show' => $show_url,
               'url_edit' => $edit_url,
           ];
        }
 
        return $this->json($data);
    }

 
    /**
     * @Route("/rack/{id}", name="rack_show", methods={"GET"})
     */
    public function show(int $id,AdminUrlGenerator $adminUrlGenerator): Response
    {
        $rack = $this->doctrine
            ->getRepository(Rack::class)
            ->find($id);
 
        if (!$rack) {
 
            return $this->json('No rack found for id' . $id, 404);
        }

        $show_url = $adminUrlGenerator
            ->setController('App\Controller\Admin\RackCrudController')
            ->setAction(Crud::PAGE_DETAIL)
            ->setEntityId($id)
            ->generateUrl();

            $edit_url = $adminUrlGenerator
            ->setController('App\Controller\Admin\RackCrudController')
            ->setAction(Crud::PAGE_EDIT)
            ->setEntityId($id)
            ->generateUrl();
 
        $data =  [
            'id' => $rack->getId(),
            'tag' => $rack->getTag(),
            'devices' => $rack->getDeviceCount(),
            'locationId' => $rack->getLocation()->getId(),
            'url_show' => $show_url,
            'url_edit' => $edit_url,
        ];
         
        return $this->json($data);
    }

    /**
     * @Route("/rack/location/{location_id}", name="rack_location_index", methods={"GET"})
     */
    public function showLocation(int $location_id, AdminUrlGenerator $adminUrlGenerator): Response
    {
        $racks = $this->doctrine
            ->getRepository(Rack::class)
            ->findBy(['location' => $location_id],);


        

        foreach ($racks as $rack) {

            $show_url = $adminUrlGenerator
            ->setController('App\Controller\Admin\RackCrudController')
            ->setAction(Crud::PAGE_DETAIL)
            ->setEntityId($rack->getId())
            ->generateUrl();

            $edit_url = $adminUrlGenerator
            ->setController('App\Controller\Admin\RackCrudController')
            ->setAction(Crud::PAGE_EDIT)
            ->setEntityId($rack->getId())
            ->generateUrl();

           $data[] = [
               'id' => $rack->getId(),
               'tag' => $rack->getTag(),
               'devices' => $rack->getDeviceCount(),
               'locationId' => $rack->getLocation()->getId(),
               'url_show' => $show_url,
               'url_edit' => $edit_url,
           ];
        }
 
         
        return $this->json($data);
    }
 

 
 
}