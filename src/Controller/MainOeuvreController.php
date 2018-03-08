<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

class MainOeuvreController extends MyAdminController
{
    protected function createEditForm($entity, array $entityProperties)
    {
        $entity->setPrixHt($entity->getLastPrix()->getPrixHt());

        return parent::createEditForm($entity, $entityProperties);
    }
}