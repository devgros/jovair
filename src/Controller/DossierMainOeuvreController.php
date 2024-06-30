<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

class DossierMainOeuvreController extends MyAdminController
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
            $devis_array = $entity->getDossier()->getDevis();
            if(sizeof($devis_array) == 1){
                $devis = $devis_array[0];
                if($devis->getStatut() == 0 && $devis->getNewDevis() == 1)
                {
                    $entity->addNewDevis($devis);
                    $devis->addNewDossierMainOeuvre($entity);
                    $this->em->flush();
                }
            }

            return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'show', 'id' => $entity->getDossier()->getId()]);
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
        $devis_array = $entity->getDossier()->getDevis();
        $allow_delete = true;
        if(sizeof($devis_array) > 0){
            foreach($devis_array as $devis){
                if($devis->getDossierMainOeuvres()->contains($entity) && $devis->getStatut() == 1 && $devis->getNewDevis() == 1){
                    $allow_delete = false;
                }
            }
        }

        if($allow_delete)
        {
            $response = parent::deleteAction();
            
            if ($response instanceof RedirectResponse) {               
                if(sizeof($devis_array) == 1){
                    $devis = $devis_array[0];
                    if($devis->getStatut() == 0 && $devis->getNewDevis() == 1)
                    {
                        $devis->removeDossierMainOeuvre($entity);
                        $this->em->flush();
                    }

                }

                return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'show', 'id' => $entity->getDossier()->getId()]);
            }

            return $response;
        }else{
            $this->addFlash("error", "Cette main d'oeuvre ne peux pas être supprimer car elle a déjà été facturé");
            return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'show', 'id' => $entity->getDossier()->getId()]);
        }
    }

    protected function listAction()
    {
        return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'list']);
    }
}