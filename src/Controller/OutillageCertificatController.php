<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

class OutillageCertificatController extends MyAdminController
{

    protected function prePersistEntity($entity)
    {
    	if (null !== $outillage_id = $this->request->query->get('outillage_id')) {
            $outillage =  $this->em->getRepository('App:Outillage')->find($outillage_id);
	    	$entity->setOutillage($outillage);
        }
    	parent::prePersistEntity($entity);
    }

    protected function newAction()
	{
		$response = parent::newAction();
		
	    if ($response instanceof RedirectResponse) {
	        $response = $this->redirectToRoute('easyadmin', [
	            'action' => 'list',
	            'entity' => 'Outillage'
	        ]);
	    }

	    return $response;
	}
}