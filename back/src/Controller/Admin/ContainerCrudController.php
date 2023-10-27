<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Filter\ContainerCustomFilter;
use App\Entity\Container;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContainerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Container::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->setDisabled(true),
            TextField::new('name'),
            AssociationField::new('group', 'Group')->setSortable(true),
            IntegerField::new('nbContracts', 'Nb Contracts')->setDisabled(true),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('name')
            ->add('group')
            ->add(ContainerCustomFilter::new('nbContracts'))
            ;
    }
}
