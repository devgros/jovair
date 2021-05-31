<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use App\Form\ExportFactureType;
use App\Entity\Facture;
use Symfony\Component\HttpFoundation\Response;

class FactureController extends MyAdminController
{


	protected function showAction()
    {
        $response = parent::showAction();

        //regenerer Facture
        $facture = $this->request->attributes->get('easyadmin')['item'];

        if($facture->getNumFacture() == "F118-21-JOV'AIR" || $facture->getNumFacture() == "F117-21-JOV'AIR" || $facture->getNumFacture() == "F116-21-JOV'AIR" || $facture->getNumFacture() == "F115-21-JOV'AIR" || $facture->getNumFacture() == "F114-21-JOV'AIR" ){

	        $path_pdf = $this->container->get('kernel')->getProjectDir().'/public/facture/facture_'.$facture->getNumFacture().'.pdf';

	        if(file_exists($path_pdf)){
				unlink($path_pdf);
			}

			$this->container->get('knp_snappy.pdf')->generateFromHtml(
					$this->renderView(
						'easy_admin/Facture/pdf_facture.html.twig',
						array('entity' => $facture)
					),
					$path_pdf
				);
		}

        return $response;
    }

    public function addAvoirAction()
    {
    	$facture_id = $this->request->query->get('id');
        $referer = $this->request->query->get('referer');
        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];

        $entity->setAvoir(true);
        $entity->setDateAvoir(new \Datetime());

        $last_avoir =  $this->em->getRepository('App:Facture')->getLastAvoir();

        if(empty($last_avoir)){
            $current_year = date("y");
            $new_num = "FA001-".$current_year."-JOV'AIR";
        }else{
            $last_num_avoir = $last_avoir[0]->getNumAvoir();
            $last_num = substr($last_num_avoir, 2, 3);
            $last_year = substr($last_num_avoir, 6, 2);
            $current_year = date("y");
            if($current_year > $last_year){
                $new_num = "FA001-".$current_year."-JOV'AIR";
            }else{
                $new_num = 'FA'.str_pad(($last_num+1), 3, "0", STR_PAD_LEFT)."-".$current_year."-JOV'AIR";
            }
        }
        $entity->setNumAvoir($new_num);

        $this->em->persist($entity);
        $this->em->flush();

        $path_pdf = $this->container->get('kernel')->getProjectDir().'/public/avoir/avoir_'.$entity->getNumAvoir().'.pdf';

        $this->container->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView(
                    'easy_admin/Facture/pdf_facture.html.twig',
                    array('entity' => $entity, 'is_avoir' => true)
                ),
                $path_pdf
            );

        if($referer != "")
        {
            $referer = str_replace("list", "show", $referer);
            $referer .= "%26id%3D".$facture_id;
        }
        return $this->redirectToRoute('easyadmin', array(
            'action' => 'showAvoir',
            'entity' => 'Facture',
            'id' => $facture_id,
            'menuIndex' => $this->request->query->get('menuIndex'),
            'referer' => $referer,
        ));
    }

    public function showAvoirAction()
    {
        //regenerer Avoir
        /*$avoir = $this->request->attributes->get('easyadmin')['item'];

        if($avoir->getNumAvoir() == "FA002-20-JOV'AIR"){

            $path_pdf = $this->container->get('kernel')->getProjectDir().'/public/avoir/avoir_'.$avoir->getNumAvoir().'.pdf';

            if(file_exists($path_pdf)){
                unlink($path_pdf);
            }

            $this->container->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView(
                    'easy_admin/Facture/pdf_facture.html.twig',
                    array('entity' => $avoir, 'is_avoir' => true)
                ),
                $path_pdf
            );
        }*/

        $response = parent::showAction();
        return $response;
    }

    public function exportAction()
    {
        $form = $this->createForm(ExportFactureType::class, array());
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fields = $form->getData();
            $date_export = $fields["month"];
            $date_export = explode("-", $date_export);
            $month_export = $date_export[0];
            $year_export = $date_export[1];

            $factures = $this->getDoctrine()->getRepository(Facture::class)->getFactureByMonth($month_export, $year_export);

            $files = [];

            foreach($factures as $facture){
                $path_pdf = $this->container->get('kernel')->getProjectDir().'/public/facture/facture_'.$facture->getNumFacture().'.pdf';
                array_push($files, $path_pdf);
            }

            $zipName = $this->container->get('kernel')->getProjectDir().'/public/facture/JOVAIR_factures-'.$year_export.'-'.$month_export.'.zip';

            $zip = new \ZipArchive();
            if ($zip->open($zipName, \ZIPARCHIVE::CREATE | \ZIPARCHIVE::OVERWRITE) === TRUE) {
                foreach ($files as $file) {
                    if (file_exists($file)) {
                        $filename = explode('/', $file);
                        $zip->addFile($file, end($filename));
                    }
                }
                $zip->close();
            }

            $response = new Response(file_get_contents($zipName));
            $response->headers->set('Content-Type', 'application/zip');
            $response->headers->set('Content-Disposition', 'attachment;filename="JOVAIR_factures-'.$year_export.'-'.$month_export.'.zip"');
            $response->headers->set('Content-length', filesize($zipName));

            unlink($zipName);

            return $response;

        }

        return $this->render('easy_admin/Facture/export.html.twig', array('form' => $form->createView()));
    }
}
