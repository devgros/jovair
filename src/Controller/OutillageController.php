<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

class OutillageController extends MyAdminController
{
    protected function createEditForm($entity, array $entityProperties)
    {
        if(! $entity->getLastPrix()){
            $entity->setPrixHt(0);

        }else{
            $entity->setPrixHt($entity->getLastPrix()->getPrixHt());

        }
        
        return parent::createEditForm($entity, $entityProperties);
    }
    
	protected function addCertificatAction()
	{
		
		return $this->redirectToRoute('easyadmin', array(
            'action' => 'new',
            'entity' => 'OutillageCertificat',
            'outillage_id' => $this->request->query->get('id'),
            'menuIndex' => $this->request->query->get('menuIndex'),
            'referer' => $this->request->query->get('referer')
        ));
	}

    protected function newAction()
    {
        $response = parent::newAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'OutillageCertificat', 'action' => 'new', 'outillage_id' => $entity->getId()]);
        }

        return $response;
    }
}