<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use App\Entity\Mecanicien;

use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
		parent::prePersistEntity($entity);
	}

	protected function validateAction(){
		$this->request->query->set("menuIndex", "1");
		$id = $this->request->query->get('id');
		$easyadmin = $this->request->attributes->get('easyadmin');
		$entity = $easyadmin['item'];
		
		$editForm = $this->createFormBuilder($entity)
			->add('horametreAprs', IntegerType::class, array("label"=>"Horamètre APRS", 'required' => false, 'attr' => ['min' => '0']))
			->add('remarqueAprs', TextType::class, array("label"=>"Remarques CRS", 'required' => false))
			->add('isValidCtrlOk', CheckboxType::class, array('label'=> "Sous réserve de l’exécution satisfaisante du vol de contrôle", 'required' => false))
			->add('dateCf', DateType::class, array("label"=>"Date du contrôle final", 'widget'=> 'single_text', 'attr' => ['value'=>date('Y-m-d')]))
			->add('timeCf', TimeType::class, array("label"=>"Heure du contrôle final", 'input'  => 'string', 'widget'=> 'single_text', 'attr' => ['value'=>date('H:i')]))
			->add('lieuCf', TextType::class, array("label"=>"Lieu du contrôle final"))
			
			->add('carteTravailFile', VichFileType::class, [
				"label"=>"Carte de travail",
				'required' => false,
				'allow_delete' => true,
			])
			->add('mecanicien', EntityType::class, array('class' => Mecanicien::class, 'attr' => ['data-widget' => 'select2']))
			->add('save', SubmitType::class, array('label' => 'Cloturer le dossier', 'attr' => ['class'=>"btn btn-danger"]))
			->getForm()
		;

		$editForm->handleRequest($this->request);
		if ($editForm->isSubmitted() && $editForm->isValid()) {
			$entity->setStatut(1);
			$this->em->flush();

			/*
			 * GENERATION PDF DOSSIER
			 */
			$this->container->get('knp_snappy.pdf')->generateFromHtml(
				$this->renderView(
					'easy_admin/Dossier/pdf_crs.html.twig',
					array('entity' => $entity)
				),
				$this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_CRS.pdf',
				array('orientation'=>'Landscape')
			);
			$this->container->get('knp_snappy.pdf')->generateFromHtml(
				$this->renderView(
					'easy_admin/Dossier/pdf_aprs.html.twig',
					array('entity' => $entity)
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

			if($entity->getCarteTravail()){
				$pdf->addPDF($this->container->get('kernel')->getProjectDir().$this->get("vich_uploader.templating.helper.uploader_helper")->asset($entity, 'carteTravailFile'), 'all');
			}
			foreach($entity->getDossierArticle() as $article){
				$pdf->addPDF($this->container->get('kernel')->getProjectDir().$this->get("vich_uploader.templating.helper.uploader_helper")->asset($article->getArticleFormone(), 'formoneFile'), 'all');
			}
			
			
			$pdf->merge('file', $this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'.pdf');

			unlink($this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_CRI.pdf');
			unlink($this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_CRS.pdf');
			unlink($this->container->get('kernel')->getProjectDir().'/public/dossier/'.$entity->getNumBl().'_APRS.pdf');

			return $this->redirectToRoute('dossier_cri', ['entity' => 'Dossier', 'id' => $entity->getId()]);

		}


		$parameters = array(
			'form' => $editForm->createView(),
			'entity_fields' => array(),
			'entity' => $entity,
			'delete_form' => $editForm->createView(),
		);

		return $this->render("easy_admin/Dossier/validate.html.twig", $parameters);
	}
}