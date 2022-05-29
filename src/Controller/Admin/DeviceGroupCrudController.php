<?php

namespace App\Controller\Admin;

use App\Entity\DeviceGroup;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class DeviceGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DeviceGroup::class;
    }

    public function configureFields(string $pageName): iterable
    {
        //yield IdField::new('id')
        //   ->onlyOnIndex();

        yield Field::new('name');
        yield Field::new('brand');
        yield Field::new('model');
        yield Field::new('webInterface');

        yield Field::new('isSshCapable');
        yield Field::new('isVncCapable');

        

    }
}
