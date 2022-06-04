<?php

namespace App\Controller\Admin;

use App\Entity\Rack;
use App\Service\CsvExporter;
use Doctrine\ORM\QueryBuilder;
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
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Factory\FilterFactory;

class RackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Rack::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Rack')
            ->setEntityLabelInPlural('Racks')
            ->renderContentMaximized()
            //->renderSidebarMinimized()
            //->setDateFormat('...')
            ->setPageTitle('index', '%entity_label_plural%')
            ->setDefaultSort(['tag' => 'DESC']);
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        //yield IdField::new('id')
        //   ->onlyOnIndex();

        yield Field::new('tag');
        yield Field::new('size');

        yield Field::new('description')->hideOnIndex();

        yield AssociationField::new('location');
        yield AssociationField::new('devices')->onlyOnIndex();
        //yield Field::new('createdAt')
        //    ->hideOnForm();
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('tag')
            ->add('size')
            ->add('location')
            ->add('devices');
    }
}
