<?php

namespace App\Controller\Admin;

use App\Entity\Sensor;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
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
            //IdField::new('id'),
            TextField::new('name'),
        ];
    }
}
