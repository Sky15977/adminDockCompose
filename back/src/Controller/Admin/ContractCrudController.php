<?php

namespace App\Controller\Admin;

use App\Entity\Contract;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContractCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contract::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(true),
            TextField::new('name'),
            AssociationField::new('container', 'Container')->setSortable(true),
            AssociationField::new('sensor', 'Sensor')->setSortable(true),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('container')
            ;
    }
}
