<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use App\Entity\DevisFraisPort;
use App\Entity\DossierFraisPort;

class FraisPortController extends MyAdminController
{
    protected function persistEntity($entity)
    {
        parent::persistEntity($entity);

        if (null !== $devis_id = $this->request->query->get('devis_id')) {

            $devis = $this->em->getRepository('App:Devis')->find($devis_id);

            $devis_frais_port = new DevisFraisPort();

            $devis_frais_port->setDevis($devis);
            $devis_frais_port->setFraisPort($entity);

            $this->em->persist($devis_frais_port);
            $this->em->flush();
        }

        if (null !== $dossier_id = $this->request->query->get('dossier_id')) {

            $dossier = $this->em->getRepository('App:Dossier')->find($dossier_id);

            $dossier_frais_port = new DossierFraisPort();

            $dossier_frais_port->setDossier($dossier);
            $dossier_frais_port->setFraisPort($entity);

            $this->em->persist($dossier_frais_port);
            $this->em->flush();
        }
    }

    protected function newAction()
	{
		$response = parent::newAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            if (null !== $devis_id = $this->request->query->get('devis_id')) {
                return $this->redirectToRoute('admin', ['entity' => 'Devis', 'action' => 'show', 'id' => $devis_id]);
            }elseif(null !== $dossier_id = $this->request->query->get('dossier_id')){
                return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'show', 'id' => $dossier_id]);
            }else{
                return $this->redirectToRoute('admin', ['entity' => 'Devis', 'action' => 'list']);
            }
        }

        return $response;
	}

	protected function editAction()
    {
        $response = parent::editAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            if (null !== $devis_id = $this->request->query->get('devis_id')) {
                return $this->redirectToRoute('admin', ['entity' => 'Devis', 'action' => 'show', 'id' => $devis_id]);
            }elseif(null !== $dossier_id = $this->request->query->get('dossier_id')){
                return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'show', 'id' => $dossier_id]);
            }else{
                return $this->redirectToRoute('admin', ['entity' => 'Devis', 'action' => 'list']);
            }
        }

        return $response;
    }

    protected function deleteAction()
    {

        $response = parent::deleteAction();

        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            if(null !== $devis_frais_port = $entity->getDevisFraisPort()[0]){
                return $this->redirectToRoute('admin', ['entity' => 'Devis', 'action' => 'show', 'id' => $devis_frais_port->getDevis()->getId()]);
            }elseif(null !== $dossier_frais_port = $entity->getDossierFraisPort()[0]){
                return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'show', 'id' => $dossier_frais_port->getDossier()->getId()]);
            }else{
                return $this->redirectToRoute('admin', ['entity' => 'Devis', 'action' => 'list']);
            }
        }

        return $response;
    }

    protected function listAction()
    {
        return $this->redirectToRoute('admin', ['entity' => 'Devis', 'action' => 'list']);
    }
}
