<?php

namespace App\Controller\Admin;

use App\Entity\Container;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ContainerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Container::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
