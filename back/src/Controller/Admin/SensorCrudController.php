<?php

namespace App\Controller\Admin;

use App\Entity\Sensor;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SensorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sensor::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(true),
            TextField::new('name'),
            AssociationField::new('activeContract', 'Contract')->setSortable(true),
            //TextField::new('activeContract', 'Contract')->setDisabled(true),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ;
    }
}
