<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\Routing\Generator\URLGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MecanicienController extends MyAdminController
{
    private function generateCarnet($entity){
        $items = array();

        $i = 0;
        foreach(array_reverse($entity->getTravaux()->toArray()) as $travaux)
        {
            if($travaux->getDateSignature()){
                $date = $travaux->getDateSignature()->format("Ymd");
            }else{
                if($travaux->getDossier()->getDateCf()){
                    $date = $travaux->getDossier()->getDateCf()->format("Ymd");
                }else{
                    $date = $travaux->getDossier()->getDateCreation()->format("Ymd");
                }
            }
            $items[$date][$travaux->getDossier()->getId()][$i]['type'] = "travaux";
            $items[$date][$travaux->getDossier()->getId()][$i]['obj'] = $travaux;
            $i++;
        }

        foreach(array_reverse($entity->getTravauxControl()->toArray()) as $travauxCtrl)
        {
            if($travauxCtrl->getDateSignatureControl()){
                $date = $travauxCtrl->getDateSignatureControl()->format("Ymd");
            }else{
                if($travauxCtrl->getDossier()->getDateCf()){
                    $date = $travauxCtrl->getDossier()->getDateCf()->format("Ymd");
                }else{
                    $date = $travauxCtrl->getDossier()->getDateCreation()->format("Ymd");
                }
            }
            $items[$date][$travauxCtrl->getDossier()->getId()][$i]['type'] = "travauxCtrl";
            $items[$date][$travauxCtrl->getDossier()->getId()][$i]['obj'] = $travauxCtrl;
            $i++;
        }

        foreach(array_reverse($entity->getCnad()->toArray()) as $cnad)
        {
            if($cnad->getDateSignature()){
                $date = $cnad->getDateSignature()->format("Ymd");
            }else{
                if($cnad->getDossier()->getDateCf()){
                    $date = $cnad->getDossier()->getDateCf()->format("Ymd");
                }else{
                    $date = $cnad->getDossier()->getDateCreation()->format("Ymd");
                }
            }
            $items[$date][$cnad->getDossier()->getId()][$i]['type'] = "cnad";
            $items[$date][$cnad->getDossier()->getId()][$i]['obj'] = $cnad;
            $i++;
        }

        foreach(array_reverse($entity->getCnadControl()->toArray()) as $cnadCtrl)
        {
            if($cnadCtrl->getDateSignatureControl()){
                $date = $cnadCtrl->getDateSignatureControl()->format("Ymd");
            }else{
                if($cnadCtrl->getDossier()->getDateCf()){
                    $date = $cnadCtrl->getDossier()->getDateCf()->format("Ymd");
                }else{
                    $date = $cnadCtrl->getDossier()->getDateCreation()->format("Ymd");
                }
            }
            $items[$date][$cnadCtrl->getDossier()->getId()][$i]['type'] = "cnadCtrl";
            $items[$date][$cnadCtrl->getDossier()->getId()][$i]['obj'] = $cnadCtrl;
            $i++;
        }

        foreach(array_reverse($entity->getTravauxSup()->toArray()) as $travauxSup)
        {
            
            if($travauxSup->getDateSignature()){
                $date = $travauxSup->getDateSignature()->format("Ymd");
            }else{
                if($travauxSup->getDossier()->getDateCf()){
                    $date = $travauxSup->getDossier()->getDateCf()->format("Ymd");
                }else{
                    $date = $travauxSup->getDossier()->getDateCreation()->format("Ymd");
                }
            }
            $items[$date][$travauxSup->getDossier()->getId()][$i]['type'] = "travauxSup";
            $items[$date][$travauxSup->getDossier()->getId()][$i]['obj'] = $travauxSup;
            $i++;
        }

        foreach(array_reverse($entity->getTravauxSupControl()->toArray()) as $travauxSupCtrl)
        {
            if($travauxSupCtrl->getDateSignatureControl()){
                $date = $travauxSupCtrl->getDateSignatureControl()->format("Ymd");
            }else{
                if($travauxSupCtrl->getDossier()->getDateCf()){
                    $date = $travauxSupCtrl->getDossier()->getDateCf()->format("Ymd");
                }else{
                    $date = $travauxSupCtrl->getDossier()->getDateCreation()->format("Ymd");
                }
            }
            $items[$date][$travauxSupCtrl->getDossier()->getId()][$i]['type'] = "travauxSupCtrl";
            $items[$date][$travauxSupCtrl->getDossier()->getId()][$i]['obj'] = $travauxSupCtrl;
            $i++;
        }

        foreach(array_reverse($entity->getDossier()->toArray()) as $dossier)
        {
            if($dossier->getDateCf()){
                $date = $dossier->getDateCf()->format("Ymd");
            }else{
                $date = $dossier->getDateCreation()->format("Ymd");
            }
            $items[$date][$dossier->getId()][$i]['type'] = "aprs";
            $items[$date][$dossier->getId()][$i]['obj'] = $dossier;
            $items[$date][$dossier->getId()][$i]['qrcode'] = $this->generateUrl('dossier_qrcode', array('entity'=> 'Dossier', 'id'=> $dossier->getId()), URLGeneratorInterface::ABSOLUTE_URL);
            $i++;
        }
        krsort($items);
        //dump($items);

        return $items;
    }

    public function carnetAction()
    {
        $id = $this->request->query->get('id');
        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];

        $items = $this->generateCarnet($entity);


        $parameters = array(
            'entity' => $entity,
            'items' => $items,
            'id' =>  $id
        );

        return $this->render("easy_admin/Mecanicien/carnet.html.twig", $parameters);
    }

    
    public function exportAction()
    {
        $id = $this->request->query->get('id');
        $easyadmin = $this->request->attributes->get('easyadmin');
        $entity = $easyadmin['item'];

        $items = $this->generateCarnet($entity);

        $path_pdf = $this->container->get('kernel')->getProjectDir().'/public/carnet_mecanicien/carnet_'.$entity->getTrigramme().'_'.date("Y-m-d").'.pdf';

        if(file_exists($path_pdf)){
            unlink($path_pdf);
        }
        
        $this->container->get('knp_snappy.pdf')->generateFromHtml(
            $this->renderView(
                'easy_admin/Mecanicien/pdf_carnet.html.twig',
                array('entity' => $entity, 'items' => $items)
            ),
            $path_pdf
        );
        $url = $this->request->getScheme().'://'.$this->request->getHttpHost().$this->request->getBasePath().'/public/carnet_mecanicien/carnet_'.$entity->getTrigramme().'_'.date("Y-m-d").'.pdf';
        return new RedirectResponse($url);
    }
}