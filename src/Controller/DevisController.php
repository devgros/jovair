<?php 

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Entity\Facture;

class DevisController extends BaseAdminController
{
	protected function prePersistEntity($entity)
	{
		$last_devis =  $this->em->getRepository('App:Devis')->getLastDevis();
		if(sizeof($last_devis)>0){
			$last_num_devis = $last_devis[0]->getNumDevis();
			$last_num = substr($last_num_devis, 1, 3);
			$last_year = substr($last_num_devis, 5, 2);
			$current_year = date("y");
			if($current_year > $last_year){
				$new_num = "D001-".$current_year."-JOV'AIR";
			}else{
				$new_num = 'D'.str_pad(($last_num+1), 3, "0", STR_PAD_LEFT)."-".$current_year."-JOV'AIR";
			}
		}else{
			$new_num = "D001-".date("y")."-JOV'AIR";
		}
		$entity->setNumDevis($new_num);
		$entity->setStatut(0);
		if(!$entity->getClient()){
			$client = $entity->getDossier()->getAppareil()->getClient();
			$entity->setClient($client);
		}
		parent::prePersistEntity($entity);
	}

	protected function preUpdateEntity($entity)
	{
		if(!$entity->getClient()){
			$client = $entity->getDossier()->getAppareil()->getClient();
			$entity->setClient($client);
		}
		parent::prePersistEntity($entity);
	}

	protected function generatePdfAction(){
		$easyadmin = $this->request->attributes->get('easyadmin');
		$entity = $easyadmin['item'];
		$path_pdf = $this->container->get('kernel')->getProjectDir().'/public/devis/devis_'.$entity->getNumDevis().'.pdf';

		if(file_exists($path_pdf)){
			unlink($path_pdf);
		}
		
		$this->container->get('knp_snappy.pdf')->generateFromHtml(
			$this->renderView(
				'easy_admin/Devis/pdf_devis.html.twig',
				array('entity' => $entity)
			),
			$path_pdf
		);
		$url = $this->request->getScheme().'://'.$this->request->getHttpHost().$this->request->getBasePath().'/public/devis/devis_'.$entity->getNumDevis().'.pdf';
		return new RedirectResponse($url);

	}

	protected function validateAction(){
		$id = $this->request->query->get('id');
		$easyadmin = $this->request->attributes->get('easyadmin');
		$entity = $easyadmin['item'];
		$entity->setStatut(1);

		$facture = new Facture();

		$last_facture =  $this->em->getRepository('App:Facture')->getLastFacture();
		if(sizeof($last_facture)>0){
			$last_num_facture = $last_facture[0]->getNumFacture();
			$last_num = substr($last_num_facture, 1, 3);
			$last_year = substr($last_num_facture, 5, 2);
			$current_year = date("y");
			if($current_year > $last_year){
				$new_num = "F001-".$current_year."-JOV'AIR";
			}else{
				$new_num = 'F'.str_pad(($last_num+1), 3, "0", STR_PAD_LEFT)."-".$current_year."-JOV'AIR";
			}
		}else{
			$new_num = "F247-".date("y")."-JOV'AIR";
		}
		$facture->setNumFacture($new_num);
		$facture->setDevis($entity);
		$facture->setClient($entity->getClient());
		$this->em->persist($facture);


		$this->em->flush();

		$path_pdf = $this->container->get('kernel')->getProjectDir().'/public/facture/facture_'.$facture->getNumFacture().'.pdf';

		$this->container->get('knp_snappy.pdf')->generateFromHtml(
				$this->renderView(
					'easy_admin/Facture/pdf_facture.html.twig',
					array('entity' => $facture)
				),
				$path_pdf
			);

		return $this->redirectToRoute('admin', ['entity' => 'Facture', 'action' => 'show', 'menuIndex' => '3', 'id' => $facture->getId()]);

		
	}

	protected function newAction()
	{
		$response = parent::newAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Devis', 'action' => 'show', 'id' => $entity->getId(), 'menuIndex'=>'2']);
        }

        return $response;
	}

    protected function editAction()
    {
        $response = parent::editAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'Devis', 'action' => 'show', 'id' => $entity->getId(), 'menuIndex'=>'2']);
        }

        return $response;
    }
}