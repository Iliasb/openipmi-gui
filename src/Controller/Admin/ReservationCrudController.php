<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        //yield IdField::new('id')
        //   ->onlyOnIndex();

        yield AssociationField::new('user');
        yield AssociationField::new('device');

        yield Field::new('startAt');
        yield Field::new('stopAt');

        
    }
}
