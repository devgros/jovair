<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

class DossierOutilsController extends MyAdminController
{
    protected function prePersistEntity($entity)
    {
        if (null !== $dossier_id = $this->request->query->get('dossier_id')) {
            $dossier =  $this->em->getRepository('App:Dossier')->find($dossier_id);
            $entity->setDossier($dossier);
        }
        parent::prePersistEntity($entity);
    }

    protected function newAction()
    {
        $response = parent::newAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            if($entity->getOutillage()->getOutillage()->getType() == "1"){
                return $this->redirectToRoute('admin', ['entity' => 'Compressiometre', 'action' => 'new', 'dossier_outil_id' => $entity->getId()]);
            }else{
                return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'show', 'id' => $entity->getDossier()->getId()]);
            }
        }

        return $response;
    }

    protected function editAction()
    {
        $response = parent::editAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'show', 'id' => $entity->getDossier()->getId()]);
        }

        return $response;
    }

    protected function deleteAction()
    {
        $entity = $this->request->attributes->get('easyadmin')['item'];

        $response = parent::deleteAction();

        
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'show', 'id' => $entity->getDossier()->getId()]);
        }

        return $response;
    }

    protected function listAction()
    {
        return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'list']);
    }
}