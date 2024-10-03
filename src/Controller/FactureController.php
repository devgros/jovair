<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use App\Form\ExportFactureType;
use App\Entity\Facture;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FactureController extends MyAdminController
{


	protected function showAction()
    {
        $response = parent::showAction();

        //regenerer Facture
        $facture = $this->request->attributes->get('easyadmin')['item'];

        if($facture->getNumFacture() == "F203-24-JOV'AIR"){

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

    public function exportcsvAction()
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

			$data = [];
			$totalMensuelHT = 0;
			$totauxMensuelTTC = 0;

			foreach($factures as $facture){
				$num_facture = $facture->getNumFacture();
				$date_devis = $facture->getDevis()->getDateCreation();

				$tauxTva = 20;
				//if($facture->getDevis()->getIs85Tva()) $tauxTva = 8.5;
				//if($facture->getDevis()->getIsExoTva() or $facture->getDevis()->getIsNoTva() or $facture->getDevis()->getIsTvaIntra()) $tauxTva = 0;
				if($facture->getDevis()->getIsTvaIntra()) $tauxTva = 0;

				$totalRemise = 0;
				$totalHT = 0;
				$totalTTC = 0;

				// Article du dossier
				if($facture->getDevis()->getDossier()){
					foreach ($facture->getDevis()->getDossier()->getDossierArticle() as $dossier_article) {
						$margeHT = round((($dossier_article->getArticleFormone()->getArticle()->getPeriodePrix($date_devis) * $dossier_article->getArticleFormone()->getArticle()->getPeriodeMarge($date_devis)) / 100),2);
						$prixHT = $dossier_article->getArticleFormone()->getArticle()->getPeriodePrix($date_devis) + $margeHT;
				        $remiseHT = round((($prixHT * $dossier_article->getRemise()) / 100),2);
						$prixHTRemise = $prixHT - $remiseHT;
				        $totalHTArticle = $prixHTRemise * $dossier_article->getQuantite();
				        $tva = round((($totalHTArticle * $tauxTva) / 100),2);
						$totalTTCArticle = $tva != 0 ? $totalHTArticle + $tva : 0;

						$totalHT += $totalHTArticle;
						$totalTTC += $totalTTCArticle;
					}
				}

				// Article du devis
				foreach ($facture->getDevis()->getDevisArticle() as $devis_article) {
					$margeHT = round((($devis_article->getArticleFormone()->getArticle()->getPeriodePrix($date_devis) * $devis_article->getArticleFormone()->getArticle()->getPeriodeMarge($date_devis)) / 100),2);
					$prixHT = $devis_article->getArticleFormone()->getArticle()->getPeriodePrix($date_devis) + $margeHT;
			        $remiseHT = round((($prixHT * $devis_article->getRemise()) / 100),2);
					$prixHTRemise = $prixHT - $remiseHT;
			        $totalHTArticle = $prixHTRemise * $devis_article->getQuantite();
			        $tva = round((($totalHTArticle * $tauxTva) / 100),2);
					$totalTTCArticle = $tva != 0 ? $totalHTArticle + $tva : 0;

					$totalHT += $totalHTArticle;
					$totalTTC += $totalTTCArticle;
				}

				// Article externe du dossier
				if($facture->getDevis()->getDossier()){
					foreach ($facture->getDevis()->getDossier()->getDossierArticleExternes() as $dossier_article_externe) {
						$prixHT = $dossier_article_externe->getPrixHt();
				        $remiseHT = round((($prixHT * $dossier_article_externe->getRemise()) / 100),2);
						$prixHTRemise = $prixHT - $remiseHT;
				        $totalHTArticle = $prixHTRemise * $dossier_article_externe->getQuantite();
				        $tva = round((($totalHTArticle * $tauxTva) / 100),2);
						$totalTTCArticle = $tva != 0 ? $totalHTArticle + $tva : 0;

						$totalHT += $totalHTArticle;
						$totalTTC += $totalTTCArticle;
					}
				}

				// Article externe du devis
				foreach ($facture->getDevis()->getArticleExterne() as $article_externe) {
					$prixHT = $article_externe->getPrixHt();
			        $remiseHT = round((($prixHT * $article_externe->getRemise()) / 100),2);
					$prixHTRemise = $prixHT - $remiseHT;
			        $totalHTArticle = $prixHTRemise * $article_externe->getQuantite();
			        $tva = round((($totalHTArticle * $tauxTva) / 100),2);
					$totalTTCArticle = $tva != 0 ? $totalHTArticle + $tva : 0;

					$totalHT += $totalHTArticle;
					$totalTTC += $totalTTCArticle;
				}

				// Main d'oeuvre du dossier
				if($facture->getDevis()->getDossier()){
					foreach ($facture->getDevis()->getDossier()->getGroupDossierMainOeuvre() as $groupDossierMainoeuvre) {
						$dossierMainoeuvre = $groupDossierMainoeuvre[0];
						$prixHT = $dossierMainoeuvre->getMainOeuvre()->getPeriodePrix($date_devis);
				        $totalHTArticle = $prixHT * $dossierMainoeuvre->getQuantite();
				        $tva = round((($totalHTArticle * $tauxTva) / 100),2);
						$totalTTCArticle = $tva != 0 ? $totalHTArticle + $tva : 0;

						$totalHT += $totalHTArticle;
						$totalTTC += $totalTTCArticle;
					}
				}

				// Main d'oeuvre du devis
				foreach ($facture->getDevis()->getDevisMainOeuvre() as $mainoeuvre) {
					$prixHT = $mainoeuvre->getMainOeuvre()->getPeriodePrix($date_devis);
			        $remiseHT = round((($prixHT * $mainoeuvre->getRemise()) / 100),2);
					$prixHTRemise = $prixHT - $remiseHT;
			        $totalHTArticle = $prixHTRemise * $mainoeuvre->getQuantite();
			        $tva = round((($totalHTArticle * $tauxTva) / 100),2);
					$totalTTCArticle = $tva != 0 ? $totalHTArticle + $tva : 0;

					$totalHT += $totalHTArticle;
					$totalTTC += $totalTTCArticle;
				}

				// Outils du dossier
				if($facture->getDevis()->getDossier()){
					foreach ($facture->getDevis()->getDossier()->getDossierOutils() as $dossier_outils) {
						$prixHT = $dossier_outils->getOutillage()->getOutillage()->getPeriodePrix($date_devis);
						$totalHTArticle = $prixHT;
				        $tva = round((($totalHTArticle * $tauxTva) / 100),2);
						$totalTTCArticle = $tva != 0 ? $totalHTArticle + $tva : 0;

						$totalHT += $totalHTArticle;
						$totalTTC += $totalTTCArticle;
					}
				}

				// Frais de port des pièces
				$fdp_piece = $facture->getDevis()->getFdpPiece();
				if($fdp_piece > 0){
					$prixHT = $fdp_piece;
					$totalHTArticle = $prixHT;
					$tva = round((($totalHTArticle * $tauxTva) / 100),2);
					$totalTTCArticle = $tva != 0 ? $totalHTArticle + $tva : 0;

					$totalHT += $totalHTArticle;
					$totalTTC += $totalTTCArticle;
				}

				// Frais de port du dossier
				if($facture->getDevis()->getDossier()){
					foreach ($facture->getDevis()->getDossier()->getGroupDossierFraisPort() as $groupDossierFraisPort) {
						$dossierFraisPort = $groupDossierFraisPort[0];
						$prixHT = $dossierFraisPort->getFraisPort()->getPrixHt();
						$totalHTArticle = $prixHT;
				        $tva = round((($totalHTArticle * $tauxTva) / 100),2);
						$totalTTCArticle = $tva != 0 ? $totalHTArticle + $tva : 0;

						$totalHT += $totalHTArticle;
						$totalTTC += $totalTTCArticle;
					}
				}

				// Frais de port du devis
				foreach ($facture->getDevis()->getDevisFraisPort() as $fraisport) {
					$prixHT = $fraisport->getFraisPort()->getPrixHt();
					$totalHTArticle = $prixHT;
			        $tva = round((($totalHTArticle * $tauxTva) / 100),2);
					$totalTTCArticle = $tva != 0 ? $totalHTArticle + $tva : 0;

					$totalHT += $totalHTArticle;
					$totalTTC += $totalTTCArticle;
				}

				// Frais de certif des pièces
				$fdc_piece = $facture->getDevis()->getFdcPiece();
				if($fdc_piece > 0){
					$prixHT = $fdc_piece;
					$totalHTArticle = $prixHT;
					$tva = round((($totalHTArticle * $tauxTva) / 100),2);
					$totalTTCArticle = $tva != 0 ? $totalHTArticle + $tva : 0;

					$totalHT += $totalHTArticle;
					$totalTTC += $totalTTCArticle;
				}

				// Frais de certif du dossier
				if($facture->getDevis()->getDossier()){
					foreach ($facture->getDevis()->getDossier()->getGroupDossierFraisCertif() as $groupDossierFraisCertif) {
						$dossierFraisCertif = $groupDossierFraisCertif[0];
						$prixHT = $dossierFraisCertif->getFraisCertif()->getPrixHt();
						$totalHTArticle = $prixHT;
				        $tva = round((($totalHTArticle * $tauxTva) / 100),2);
						$totalTTCArticle = $tva != 0 ? $totalHTArticle + $tva : 0;

						$totalHT += $totalHTArticle;
						$totalTTC += $totalTTCArticle;
					}
				}

				// Frais de certif du devis
				foreach ($facture->getDevis()->getDevisFraisCertif() as $fraiscertif) {
					$prixHT = $fraiscertif->getFraisCertif()->getPrixHt();
					$totalHTArticle = $prixHT;
			        $tva = round((($totalHTArticle * $tauxTva) / 100),2);
					$totalTTCArticle = $tva != 0 ? $totalHTArticle + $tva : 0;

					$totalHT += $totalHTArticle;
					$totalTTC += $totalTTCArticle;
				}

				$totalMensuelHT += $totalHT;
				$totauxMensuelTTC += $totalTTC;

				$data[] = [$num_facture, $totalHT, $totalTTC];
            }
			$data[] = ["Total", $totalMensuelHT, $totauxMensuelTTC];
			$filename = 'AVIONICS_factures-'.$year_export.'-'.$month_export.'.csv';

			$response = new StreamedResponse(function () use ($data) {
			$handle = fopen('php://output', 'w+');

	            // Add CSV header
			fputcsv($handle, array("Num facture", "Total HT", "Total TTC"), ";");

	            // Add CSV rows
			foreach ($data as $row) {
				fputcsv($handle, $row, ";");
			}

				fclose($handle);
			});

			$response->headers->set('Content-Type', 'text/csv');
			$response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

			return $response;
        }

        return $this->render('easy_admin/Facture/exportcsv.html.twig', array('form' => $form->createView()));
    }

	public function addAcompteAction()
    {
		$facture_id = $this->request->query->get('id');
		$referer = $this->request->query->get('referer');
		if($referer != "")
		{
			$referer = str_replace("list", "show", $referer);
			$referer .= "%26id%3D".$facture_id;
		}
		return $this->redirectToRoute('easyadmin', array(
            'action' => 'new',
            'entity' => 'FactureAcompte',
            'facture_id' => $facture_id,
            'menuIndex' => $this->request->query->get('menuIndex'),
            'referer' => $referer,
        ));
    }

	
}
