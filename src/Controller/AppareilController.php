<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

class AppareilController extends MyAdminController
{

    public function addPeAction()
    {
    	$appareil_id = $this->request->query->get('id');
    	$referer = $this->request->query->get('referer');
    	if($referer != "")
    	{
	    	$referer = str_replace("list", "show", $referer);
	    	$referer .= "%26id%3D".$appareil_id;
	    }
    	return $this->redirectToRoute('easyadmin', array(
            'action' => 'new',
            'entity' => 'ProgrammeEntretien',
            'appareil_id' => $appareil_id,
            'menuIndex' => $this->request->query->get('menuIndex'),
            'referer' => $referer,
        ));
    }

    public function addAmmCelluleAction()
    {
        $appareil_id = $this->request->query->get('id');
        $referer = $this->request->query->get('referer');
        if($referer != "")
        {
            $referer = str_replace("list", "show", $referer);
            $referer .= "%26id%3D".$appareil_id;
        }
        return $this->redirectToRoute('easyadmin', array(
            'action' => 'new',
            'entity' => 'AmmCellule',
            'appareil_id' => $appareil_id,
            'menuIndex' => $this->request->query->get('menuIndex'),
            'referer' => $referer,
        ));
    }

    public function addAmmMoteurAction()
    {
        $appareil_id = $this->request->query->get('id');
        $referer = $this->request->query->get('referer');
        if($referer != "")
        {
            $referer = str_replace("list", "show", $referer);
            $referer .= "%26id%3D".$appareil_id;
        }
        return $this->redirectToRoute('easyadmin', array(
            'action' => 'new',
            'entity' => 'AmmMoteur',
            'appareil_id' => $appareil_id,
            'menuIndex' => $this->request->query->get('menuIndex'),
            'referer' => $referer,
        ));
    }
}