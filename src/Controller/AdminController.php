<?php 

namespace App\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;

class AdminController extends BaseAdminController
{
	public function notificationsAction()
	{
		$alertes =  $this->getDoctrine()->getManager()->getRepository('App:Alerte')->findAll();
		return $this->render("easy_admin/notifications.html.twig", array('alertes' => $alertes));
	}
}