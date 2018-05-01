<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

class ArticleExterneController extends MyAdminController
{
	protected function prePersistEntity($entity)
    {
    	if (null !== $devis_id = $this->request->query->get('devis_id')) {
            $devis =  $this->em->getRepository('App:Devis')->find($devis_id);
            $entity->setDevis($devis);
            if($entity->getRemise() == null){
                $entity->setRemise(0);
            }
        }
    	parent::prePersistEntity($entity);
    }

    protected function newAction()
	{
		$response = parent::newAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Devis', 'action' => 'show', 'id' => $entity->getDevis()->getId()]);
        }

        return $response;
	}

	protected function editAction()
    {
        $response = parent::editAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Devis', 'action' => 'show', 'id' => $entity->getDevis()->getId()]);
        }

        return $response;
    }

    protected function deleteAction()
    {
        $response = parent::deleteAction();

        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Devis', 'action' => 'show', 'id' => $entity->getDevis()->getId()]);
        }

        return $response;
    }

    protected function listAction()
    {
        return $this->redirectToRoute('admin', ['entity' => 'Devis', 'action' => 'list']);
    }
}