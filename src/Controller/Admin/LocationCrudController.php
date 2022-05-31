<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\Routing\Annotation\Route;

class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
    }

    public function configureFields(string $pageName): iterable
    {
        //yield IdField::new('id')
        //   ->onlyOnIndex();

        yield Field::new('name');
        yield Field::new('slug');

        yield AssociationField::new('racks')
            ->onlyOnIndex();
        yield Field::new('createdAt')
            ->hideOnForm();
    }

}
