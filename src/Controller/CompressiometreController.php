<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

class CompressiometreController extends MyAdminController
{
    protected function prePersistEntity($entity)
    {
        if (null !== $dossier_outil_id = $this->request->query->get('dossier_outil_id')) {
            $dossier_outil =  $this->em->getRepository('App:DossierOutils')->find($dossier_outil_id);
            $entity->setDossierOutils($dossier_outil);
        }
        parent::prePersistEntity($entity);
    }

    protected function newAction()
    {
        $response = parent::newAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'show', 'id' => $entity->getDossierOutils()->getDossier()->getId()]);
        }

        return $response;
    }

    protected function editAction()
    {
        $response = parent::editAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'show', 'id' => $entity->getDossierOutils()->getDossier()->getId()]);
        }

        return $response;
    }

    protected function deleteAction()
    {
        $response = parent::deleteAction();

        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'show', 'id' => $entity->getDossierOutils()->getDossier()->getId()]);
        }

        return $response;
    }

    protected function listAction()
    {
        return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'list']);
    }
}