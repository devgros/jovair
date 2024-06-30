<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

class FactureAcompteController extends MyAdminController
{
    protected function prePersistEntity($entity)
    {
        if (null !== $facture_id = $this->request->query->get('facture_id')) {
            $facture =  $this->em->getRepository('App:Facture')->find($facture_id);
            $entity->setFacture($facture);
        }
        parent::prePersistEntity($entity);
    }

    protected function newAction()
	{
		$response = parent::newAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Facture', 'action' => 'show', 'id' => $entity->getFacture()->getId()]);
        }

        return $response;
	}

    protected function editAction()
    {
        $response = parent::editAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Facture', 'action' => 'show', 'id' => $entity->getFacture()->getId()]);
        }

        return $response;
    }

    protected function deleteAction()
    {
        $response = parent::deleteAction();

        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Facture', 'action' => 'show', 'id' => $entity->getFacture()->getId()]);
        }

        return $response;
    }

    protected function listAction()
    {
        return $this->redirectToRoute('admin', ['entity' => 'Facture', 'action' => 'list']);
    }
}
