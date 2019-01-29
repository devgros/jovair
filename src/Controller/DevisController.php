<?php 

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Entity\Facture;

use EasyCorp\Bundle\EasyAdminBundle\Form\Util\LegacyFormHelper;
use Doctrine\ORM\EntityRepository;
use App\Entity\DossierArticle;
use App\Entity\DossierMainOeuvre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DevisController extends MyAdminController
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
		parent::preUpdateEntity($entity);
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
		$facture->setFacturePaye(false);
		$facture->setPaiementLiquide(false);
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
            
            if($entity->getDossier()){
	            $nb_devis_dossier = count($entity->getDossier()->getDevis());
	           	if($nb_devis_dossier > 1){
	           		//Selection des article et main d'oeuvre à ignorer
	           		return $this->redirectToRoute('admin', ['entity' => 'DevisDossierSuppl', 'action' => 'edit', 'id' => $entity->getId(), 'menuIndex'=>'2']);
	           	}else{
	           		//creation de la liste des articles et main d'oeuvre associé au dossier

	           		foreach($entity->getDossier()->getDossierArticle() as $dossier_article){
	           			$entity->addFirstDossierArticle($dossier_article);
	           		}
	           		foreach($entity->getDossier()->getDossierMainOeuvre() as $dossier_main_oeuvre){
	           			$entity->addFirstDossierMainOeuvre($dossier_main_oeuvre);
	           		}


	           		$this->em->flush();

	           		return $this->redirectToRoute('admin', ['entity' => 'Devis', 'action' => 'show', 'id' => $entity->getId(), 'menuIndex'=>'2']);
	           	}
	        }
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

    public function createDevisEntityFormBuilder($entity, $view)
    {
        $formBuilder = parent::createEntityFormBuilder($entity, $view);

        if($entity->getDossier() and $entity->getNewDevis() and $entity->getStatut() == 0)
        {

	        $dossier_id = $entity->getDossier()->getId();

	        $formBuilder->add('dossierArticles', EntityType::class, array( 
	        	'class' => DossierArticle::class,
	        	'choice_label' => 'getDossierArticleLabel',
	        	'label' => "Articles à ajouter",
	        	'required' => false,
	        	//'help' => "Cocher les articles à prendre en compte pour ce pro format",
	        	//'choice_label' => 'id', 
	        	'multiple' => true, 'expanded' => true, 
	            'query_builder' => function (EntityRepository $er) use ( $dossier_id ) {
	                return $er->createQueryBuilder('da')
	                	->innerJoin('da.dossier', 'd')
	                	->where('d.id = :id')                   
	                    ->setParameter('id', $dossier_id)
	                ;
	            }
	        ));

	        $formBuilder->add('dossierMainoeuvres', EntityType::class, array( 
	        	'class' => DossierMainOeuvre::class, 
	        	'choice_label' => 'getDossierMainOeuvreLabel',
	        	'label' => "Main d'oeuvre à ajouter",
	        	'required' => false,
	        	//'help' => "Cocher les articles à prendre en compte pour ce pro format",
	        	//'choice_label' => 'id', 
	        	'multiple' => true, 'expanded' => true, 
	            'query_builder' => function (EntityRepository $er) use ( $dossier_id ) {
	                return $er->createQueryBuilder('da')
	                	->innerJoin('da.dossier', 'd')
	                	->where('d.id = :id')                   
	                    ->setParameter('id', $dossier_id)
	                ;
	            }
	        ));
	    }

        return $formBuilder;
    }

    public function createDevisDossierSupplEntityFormBuilder($entity, $view)
    {
        return $this->createDevisEntityFormBuilder($entity, $view);
    }	
}