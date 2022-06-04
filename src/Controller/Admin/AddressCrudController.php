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
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

class AddressCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Address::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('IP Address')
            ->setEntityLabelInPlural('IP Addresses')
            ->renderContentMaximized()
            //->renderSidebarMinimized()
            //->setDateFormat('...')
            ->setPageTitle('index', '%entity_label_plural%')
            ->setDefaultSort(['ip' => 'DESC']);
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        //yield IdField::new('id')
        //   ->onlyOnIndex();


        yield FormField::addPanel('Details');
            //->collapsible()
            //->setIcon('fa fa-info')
            //->setHelp('IP address details');

        yield Field::new('fullDnsName','Full DNS name')->setHelp('Eg. node01.domain.lan');
        yield Field::new('ip','IP Address')->setHelp('ipv4 or ipv6 address');


        yield FormField::addPanel('Properties');
            //->collapsible()
            //->setIcon('fa fa-info')
            //->setHelp('IP address properties');

        yield AssociationField::new('network');
        yield AssociationField::new('device');



        yield FormField::addPanel('Remote connectivity');
            //->collapsible()
            //->setIcon('fa fa-info')
            //->setHelp('IP address Options');

        yield Field::new('isDhcpEnabled');
        yield Field::new('isSshCapable');
        yield Field::new('isTelnetCapable');
        yield Field::new('isIpmiCapable');
        yield Field::new('isVncCapable');
        yield Field::new('isRdpCapable');


        
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
