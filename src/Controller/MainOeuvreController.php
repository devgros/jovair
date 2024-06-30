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

    public function deletedAction()
    {
        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];
        $entity->setDeleted(1);
        $entity->setDeletedAt(new \DateTime());

        $this->em->flush();

        return $this->redirectToRoute('admin', ['entity' => 'MainOeuvre', 'action' => 'list', 'menuIndex' => '7']);
    }

    public function undeletedAction()
    {
        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];
        $entity->setDeleted(0);
        $entity->setDeletedAt(null);
        $this->em->flush();

        return $this->redirectToRoute('admin', ['entity' => 'MainOeuvreSuppr', 'action' => 'list', 'menuIndex' => '16']);
    }
}