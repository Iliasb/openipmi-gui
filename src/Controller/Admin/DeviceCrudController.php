<?php

namespace App\Controller\Admin;

use App\Entity\Device;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;


class DeviceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Device::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Device')
            ->setEntityLabelInPlural('Devices')
            ->renderContentMaximized()
            //->renderSidebarMinimized()
            //->setDateFormat('...')
            ->setPageTitle('index', '%entity_label_plural%')
            ->setDefaultSort(['name' => 'DESC'])
            //->overrideTemplates([
                //'crud/index' => 'Device/index.html.twig',
                //'crud/field/textarea' => 'admin/fields/dynamic_textarea.html.twig',
            //])
            ;
        
    }

    public function export(AdminContext $context, CsvExporter $csvExporter)
    {
        $fields = FieldCollection::new($this->configureFields(Crud::PAGE_INDEX));
        $filters = $this->container->get(FilterFactory::class)->create($context->getCrud()->getFiltersConfig(), $fields, $context->getEntity());
        $queryBuilder = $this->createIndexQueryBuilder($context->getSearch(), $context->getEntity(), $fields, $filters);

        return $csvExporter->createResponseFromQueryBuilder($queryBuilder, $fields, 'devices.csv');
    }

    public function configureActions(Actions $actions): Actions
    {
        $exportAction = Action::new('export')
            ->linkToCrudAction('export')
            ->addCssClass('btn btn-success')
            ->setIcon('fa fa-download')
            ->createAsGlobalAction();
        return parent::configureActions($actions)
            ->add(Crud::PAGE_INDEX, $exportAction);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return parent::configureFilters($filters)
            ->add('positionStart')
            ->add('positionEnd')
            ->add('name')
            ->add('serialNr')

            ->add('deviceGroup')
            ->add('rack')
            ->add('project')
            ->add('addresses')
            ->add('reservations');
    }

    public function configureFields(string $pageName): iterable
    {
        //yield IdField::new('id')
        //   ->onlyOnIndex();

        yield FormField::addPanel('Details');
            //->collapsible()
            //->setIcon('fa fa-info')
            //->setHelp('Device details');

        yield Field::new('positionStart')->setHelp('Starting position of the device in the rack.');
        yield Field::new('positionEnd')->hideOnIndex()->setHelp('Stop position of the device in the rack.');
        yield Field::new('name');
        yield Field::new('serialNr');
        yield Field::new('description')->hideOnIndex();

        yield FormField::addPanel('Properties');
            //->collapsible()
            //->setIcon('fa fa-info')
            //->setHelp('Device properties');

        yield AssociationField::new('deviceGroup');
        yield AssociationField::new('project');
        yield AssociationField::new('rack');

        yield AssociationField::new('addresses');
        yield AssociationField::new('reservations')->hideOnForm();


    }
}
