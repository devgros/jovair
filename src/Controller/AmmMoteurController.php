<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

class AmmMoteurController extends MyAdminController
{

    protected function prePersistEntity($entity)
    {
    	if (null !== $appareil_id = $this->request->query->get('appareil_id')) {
            $appareil =  $this->em->getRepository('App:Appareil')->find($appareil_id);
	    	$entity->setAppareil($appareil);
        }
    	parent::prePersistEntity($entity);
    }

    protected function newAction()
	{
		$response = parent::newAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Appareil', 'action' => 'show', 'id' => $entity->getAppareil()->getId()]);
        }

        return $response;
	}

    protected function editAction()
    {
        $response = parent::editAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Appareil', 'action' => 'show', 'id' => $entity->getAppareil()->getId()]);
        }

        return $response;
    }

    protected function deleteAction()
    {
        $response = parent::deleteAction();

        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Appareil', 'action' => 'show', 'id' => $entity->getAppareil()->getId()]);
        }

        return $response;
    }

    protected function listAction()
    {
        return $this->redirectToRoute('admin', ['entity' => 'Appareil', 'action' => 'list']);
    }
}