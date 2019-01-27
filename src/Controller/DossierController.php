<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Generator\URLGeneratorInterface;

use App\Entity\Devis;
use App\Entity\Mecanicien;

use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class DossierController extends MyAdminController
{
	protected function prePersistEntity($entity)
	{
		$last_dossier =  $this->em->getRepository('App:Dossier')->getLastDossier();

		if(sizeof($last_dossier)>0){
			$last_num_dossier = $last_dossier[0]->getNumBl();
			$last_num = substr($last_num_dossier, 0, 3);
			$last_year = substr($last_num_dossier, 4, 2);
			$current_year = date("y");
			if($current_year > $last_year){
				$new_num = "001-".$current_year."-JOV'AIR";
			}else{
				$new_num = str_pad(($last_num+1), 3, "0", STR_PAD_LEFT)."-".$current_year."-JOV'AIR";
			}
		}else{
			$new_num = "026-".$current_year."-JOV'AIR";
		}
		$entity->setNumBl($new_num);

		$heure_aprs = $entity->getHeureDerniereAprs();
        if($heure_aprs){
        	$appareil = $entity->getAppareil();
        	$appareil->setHeureDerniereAprs($heure_aprs);

        	if($appareil->getHtCellule()) $appareil->setHtCellule($this->addAPRSTime($appareil->getHtCellule(), $heure_aprs));
	        if($appareil->getHrgCellule()) $appareil->setHrgCellule($this->addAPRSTime($appareil->getHrgCellule(), $heure_aprs));
	        if($appareil->getHtMoteur1()) $appareil->setHtMoteur1($this->addAPRSTime($appareil->getHtMoteur1(), $heure_aprs));
	        if($appareil->getHrgMoteur1()) $appareil->SetHrgMoteur1($this->addAPRSTime($appareil->getHrgMoteur1(), $heure_aprs));
	        if($appareil->getHtMoteur2()) $appareil->setHtMoteur2($this->addAPRSTime($appareil->getHtMoteur2(), $heure_aprs));
	        if($appareil->getHrgMoteur2()) $appareil->SetHrgMoteur2($this->addAPRSTime($appareil->getHrgMoteur2(), $heure_aprs));
	        if($appareil->getHtHelice1()) $appareil->setHtHelice1($this->addAPRSTime($appareil->getHtHelice1(), $heure_aprs));
	        if($appareil->getHrgHelice1()) $appareil->setHrgHelice1($this->addAPRSTime($appareil->getHrgHelice1(), $heure_aprs));
	        if($appareil->getHtHelice2()) $appareil->setHtHelice2($this->addAPRSTime($appareil->getHtHelice2(), $heure_aprs));
	        if($appareil->getHrgHelice2()) $appareil->setHrgHelice2($this->addAPRSTime($appareil->getHrgHelice2(), $heure_aprs));
	        $this->em->flush();
        }
		
		parent::prePersistEntity($entity);
	}

	protected function preUpdateEntity($entity)
    {
        $heure_aprs = $entity->getHeureDerniereAprs();
        if($heure_aprs){
        	$appareil = $entity->getAppareil();
        	$appareil->setHeureDerniereAprs($heure_aprs);

        	if($appareil->getHtCellule()) $appareil->setHtCellule($this->addAPRSTime($appareil->getHtCellule(), $heure_aprs));
	        if($appareil->getHrgCellule()) $appareil->setHrgCellule($this->addAPRSTime($appareil->getHrgCellule(), $heure_aprs));
	        if($appareil->getHtMoteur1()) $appareil->setHtMoteur1($this->addAPRSTime($appareil->getHtMoteur1(), $heure_aprs));
	        if($appareil->getHrgMoteur1()) $appareil->SetHrgMoteur1($this->addAPRSTime($appareil->getHrgMoteur1(), $heure_aprs));
	        if($appareil->getHtMoteur2()) $appareil->setHtMoteur2($this->addAPRSTime($appareil->getHtMoteur2(), $heure_aprs));
	        if($appareil->getHrgMoteur2()) $appareil->SetHrgMoteur2($this->addAPRSTime($appareil->getHrgMoteur2(), $heure_aprs));
	        if($appareil->getHtHelice1()) $appareil->setHtHelice1($this->addAPRSTime($appareil->getHtHelice1(), $heure_aprs));
	        if($appareil->getHrgHelice1()) $appareil->setHrgHelice1($this->addAPRSTime($appareil->getHrgHelice1(), $heure_aprs));
	        if($appareil->getHtHelice2()) $appareil->setHtHelice2($this->addAPRSTime($appareil->getHtHelice2(), $heure_aprs));
	        if($appareil->getHrgHelice2()) $appareil->setHrgHelice2($this->addAPRSTime($appareil->getHrgHelice2(), $heure_aprs));
	        $this->em->flush();
        }
        
        
        parent::preUpdateEntity($entity);
    }

    protected function addAPRSTime($ht, $heure_aprs)
    {
    	list($htH,$htM) = explode('.',$ht);
    	list($haprsH,$haprsM) = explode('.',$heure_aprs);
    	$HT = $htH+$haprsH;
    	$MT = $htM+$haprsM;
    	while($MT > 60){
    		$HT++;
    		$MT = $MT-60;
    	}
    	$new_ht = $HT.".".str_pad(($MT), 2, "0", STR_PAD_LEFT);
    	return $new_ht;
    }

    protected function validateAction(){
		$this->request->query->set("menuIndex", "1");
		$id = $this->request->query->get('id');
		$easyadmin = $this->request->attributes->get('easyadmin');
		$entity = $easyadmin['item'];
		if($entity->getDateCf() != null){
			$value_date = $entity->getDateCf()->format('Y-m-d');
		}else{
			$value_date = date('Y-m-d');
		}
		if($entity->getTimeCf() != null){
			$value_time = substr($entity->getTimeCf(), 0, 5);
		}else{
			$value_time = date('H:i');
		}
		
		$editForm = $this->createFormBuilder($entity)
			->add('horametreAprs', NumberType::class, array("label"=>"Horamètre APRS", 'required' => false, 'attr' => ['min' => '0']))
			->add('remarqueAprs', TextType::class, array("label"=>"Remarques CRS", 'required' => false))
			->add('isValidCtrlOk', CheckboxType::class, array('label'=> "Sous réserve de l’exécution satisfaisante du vol de contrôle", 'required' => false))
			->add('dateCf', DateType::class, array("label"=>"Date du contrôle final", 'widget'=> 'single_text', 'attr' => ['value'=>$value_date]))
			->add('timeCf', TimeType::class, array("label"=>"Heure du contrôle final", 'input'  => 'string', 'widget'=> 'single_text', 'attr' => ['value'=>$value_time]))
			->add('lieuCf', TextType::class, array("label"=>"Lieu du contrôle final"))
			
			->add('carteTravailFile', VichFileType::class, [
				"label"=>"Carte de travail",
				'required' => false,
				'allow_delete' => true,
			])
			->add('mecanicien', EntityType::class, array('class' => Mecanicien::class, 'attr' => ['data-widget' => 'select2']))
			->add('save', SubmitType::class, array('label' => 'PDF', 'attr' => ['class'=>"btn btn-success"]))
			->getForm()
		;

		$editForm->handleRequest($this->request);
		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$this->em->flush();
			/*
			 * GENERATION PDF DOSSIER
			 */
			
			if (file_exists($this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_CRI.pdf')) {
				unlink($this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_CRI.pdf');
			}

			if (file_exists($this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_CRS.pdf')) {
				unlink($this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_CRS.pdf');
			}

			if (file_exists($this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_APRS.pdf')) {
				unlink($this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_APRS.pdf');
			}


			$this->container->get('knp_snappy.pdf')->generateFromHtml(
				$this->renderView(
					'easy_admin/Dossier/pdf_crs.html.twig',
					array('entity' => $entity)
				),
				$this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_CRS.pdf',
				array('orientation'=>'Landscape')
			);
			$url = $this->generateUrl('dossier_qrcode', array('entity'=> 'Dossier', 'id'=> $entity->getId()), URLGeneratorInterface::ABSOLUTE_URL);
			$this->container->get('knp_snappy.pdf')->generateFromHtml(
				$this->renderView(
					'easy_admin/Dossier/pdf_aprs.html.twig',
					array('entity' => $entity, 'url'=> $url)
				),
				$this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_APRS.pdf'
			);
			$this->container->get('knp_snappy.pdf')->generateFromHtml(
	            $this->renderView(
	                'easy_admin/Dossier/pdf_cri.html.twig',
	                array('entity' => $entity)
	            ),
	            $this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_CRI.pdf'
	        );

	        $pdf = new \PDFMerger();

	        if($entity->getScanBc()){
				$pdf->addPDF($this->container->get('kernel')->getProjectDir().$this->get("vich_uploader.templating.helper.uploader_helper")->asset($entity, 'scanBcFile'), 'all');
			}
	        $pdf->addPDF($this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_CRI.pdf', 'all');
			$pdf->addPDF($this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_CRS.pdf', 'all');
			$pdf->addPDF($this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_APRS.pdf', 'all');

			foreach($entity->getTravaux() as $travaux){
				if($travaux->getCarteTravailTravaux()){
					$pdf->addPDF($this->container->get('kernel')->getProjectDir().$this->get("vich_uploader.templating.helper.uploader_helper")->asset($travaux, 'carteTravailTravauxFile'), 'all');
				}
			}

			foreach($entity->getCnad() as $cnad){
				if($cnad->getCarteTravailCnad()){
					$pdf->addPDF($this->container->get('kernel')->getProjectDir().$this->get("vich_uploader.templating.helper.uploader_helper")->asset($cnad, 'carteTravailCnadFile'), 'all');
				}
			}

			foreach($entity->getTravauxSup() as $travaux_sup){
				if($travaux_sup->getCarteTravailTravauxSup()){
					$pdf->addPDF($this->container->get('kernel')->getProjectDir().$this->get("vich_uploader.templating.helper.uploader_helper")->asset($travaux_sup, 'carteTravailTravauxSupFile'), 'all');
				}
			}

			if($entity->getCarteTravail()){
				$pdf->addPDF($this->container->get('kernel')->getProjectDir().$this->get("vich_uploader.templating.helper.uploader_helper")->asset($entity, 'carteTravailFile'), 'all');
			}
			foreach($entity->getDossierArticle() as $article){
				if($article->getArticleFormone()->getFormone()){
					$pdf->addPDF($this->container->get('kernel')->getProjectDir().$this->get("vich_uploader.templating.helper.uploader_helper")->asset($article->getArticleFormone(), 'formoneFile'), 'all');
				}
			}

			$pdf->merge('file', $this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'.pdf');

			unlink($this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_CRI.pdf');
			unlink($this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_CRS.pdf');
			//unlink($this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_APRS.pdf');

			return $this->redirectToRoute('dossier_aprs', ['entity' => 'Dossier', 'id' => $entity->getId()]);
			
		}


		$parameters = array(
			'form' => $editForm->createView(),
			'entity_fields' => array(),
			'entity' => $entity,
			'delete_form' => $editForm->createView(),
		);

		return $this->render("easy_admin/Dossier/validate.html.twig", $parameters);
	}

	protected function getDossierAction(){
		$this->request->query->set("menuIndex", "1");
		$id = $this->request->query->get('id');
		$easyadmin = $this->request->attributes->get('easyadmin');
		$entity = $easyadmin['item'];

		if($entity->getStatut() > 0 && $entity->getDossierFinal() != null){
			$dossier_path = $this->container->get('kernel')->getProjectDir().'/public/dossier_final/'.$entity->getNumBl().'.pdf';
		}else{
			$dossier_path = $this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'.pdf';
		}

		$response = new BinaryFileResponse($dossier_path);
		$response->setContentDisposition(ResponseHeaderBag::DISPOSITION_INLINE, $entity->getNumBl().'.pdf');

		return $response;
	}

	protected function cloturerAction(){
		$this->request->query->set("menuIndex", "1");
		$id = $this->request->query->get('id');
		$easyadmin = $this->request->attributes->get('easyadmin');
		$entity = $easyadmin['item'];
		
		$editForm = $this->createFormBuilder($entity)
			->add('dossierFinalFile', VichFileType::class, [
				"label"=>"Télécharger le dossier final",
				'required' => false,
				'allow_delete' => true,
			])
			->add('save', SubmitType::class, array('label' => 'Cloturer', 'attr' => ['class'=>"btn btn-success"]))
			->getForm()
		;

		$editForm->handleRequest($this->request);
		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$entity->setStatut(1);
			$this->em->flush();

			/*
			 * CREATION DU PRO FORMAT SI NON EXISTANT
			 */
			
			$devis = $this->em->getRepository('App:Devis')->findBy(array('dossier'=>$entity->getId()));
			if(!$devis){
				$devis = new Devis();
				$devis->setDossier($entity);

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
				$devis->setNumDevis($new_num);
				$devis->setStatut(0);
				if(!$devis->getClient()){
					$client = $devis->getDossier()->getAppareil()->getClient();
					$devis->setClient($client);
				}


				$this->em->persist($devis);
				$this->em->flush();

				//creation de la liste des articles et main d'oeuvre associé au dossier si c'est le 1er devis sur le dossier
				$nb_devis_dossier = count($devis->getDossier()->getDevis());
           		if($nb_devis_dossier == 1){
           			foreach($devis->getDossier()->getDossierArticle() as $dossier_article){
	           			$devis->addFirstDossierArticle($dossier_article);
	           		}
	           		foreach($devis->getDossier()->getDossierMainOeuvre() as $dossier_main_oeuvre){
	           			$devis->addFirstDossierMainOeuvre($dossier_main_oeuvre);
	           		}
           		}
           		$this->em->flush();
			}
			return $this->redirectToRoute('admin', ['entity' => 'Dossier', 'action' => 'show', 'id' => $entity->getId()]);
		}

		$parameters = array(
			'form' => $editForm->createView(),
			'entity_fields' => array(),
			'entity' => $entity,
			'delete_form' => $editForm->createView(),
		);

		return $this->render("easy_admin/Dossier/cloturer.html.twig", $parameters);
	}
}