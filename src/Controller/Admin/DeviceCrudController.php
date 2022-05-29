<?php

namespace App\Controller\Admin;

use App\Entity\Device;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class DeviceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Device::class;
    }

    public function configureFields(string $pageName): iterable
    {
        //yield IdField::new('id')
        //   ->onlyOnIndex();

        yield Field::new('name');
        yield Field::new('ipv4');
        yield Field::new('ipv6');
        yield Field::new('positionStart');
        yield Field::new('positionEnd');

        yield AssociationField::new('deviceGroup');
        yield AssociationField::new('rack');
        //yield Field::new('createdAt')
        //    ->hideOnForm();
    }
}
