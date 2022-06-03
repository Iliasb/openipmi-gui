<?php

namespace App\Controller\Admin;

use App\Entity\Address;
use App\Service\CsvExporter;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use App\EasyAdmin\VotesField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Factory\FilterFactory;

class AddressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Address::class;
    }

    public function configureFields(string $pageName): iterable
    {
        //yield IdField::new('id')
        //   ->onlyOnIndex();



        yield Field::new('fullDnsName');
        yield Field::new('ip');
        yield Field::new('isDhcpEnabled');
        yield Field::new('isSshCapable');
        yield Field::new('isTelnetCapable');
        yield Field::new('isIpmiCapable');
        yield Field::new('isVncCapable');
        yield Field::new('isRdpCapable');
        yield AssociationField::new('network');
        yield AssociationField::new('device');

        
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('fullDnsName')
            ->add('ip')
            ->add('isDhcpEnabled')
            ->add('isSshCapable')
            ->add('isTelnetCapable')
            ->add('isIpmiCapable')
            ->add('isVncCapable')
            ->add('isRdpCapable')
            ->add('network')
            ->add('device');
    }
}
