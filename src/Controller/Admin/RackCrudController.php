<?php

namespace App\Controller\Admin;

use App\Entity\Rack;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class RackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Rack::class;
    }

    public function configureFields(string $pageName): iterable
    {
        //yield IdField::new('id')
        //   ->onlyOnIndex();

        yield Field::new('tag');
        yield Field::new('size');

        yield AssociationField::new('location');
        yield AssociationField::new('devices')->onlyOnIndex();
        //yield Field::new('createdAt')
        //    ->hideOnForm();
    }
}
