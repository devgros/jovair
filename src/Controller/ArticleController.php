<?php

namespace App\Controller;

use App\Controller\AdminController as MyAdminController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Event\EasyAdminEvents;

class ArticleController extends MyAdminController
{
    protected function createEditForm($entity, array $entityProperties)
    {
        $entity->setPrixHt($entity->getLastPrix()->getPrixHt());

        return parent::createEditForm($entity, $entityProperties);
    }

    protected function newAction()
    {
        $response = parent::newAction();
        $entity = $this->request->attributes->get('easyadmin')['item'];
        if ($response instanceof RedirectResponse) {
            return $this->redirectToRoute('admin', ['entity' => 'ArticleFormone', 'action' => 'new', 'article_id' => $entity->getId()]);
        }

        return $response;
    }

    public function addFormoneAction()
    {
    	$article_id = $this->request->query->get('id');
    	$referer = $this->request->query->get('referer');
    	if($referer != "")
    	{
	    	$referer = str_replace("list", "show", $referer);
	    	$referer .= "%26id%3D".$article_id;
	    }
    	return $this->redirectToRoute('easyadmin', array(
            'action' => 'new',
            'entity' => 'ArticleFormone',
            'article_id' => $article_id,
            'menuIndex' => 5,
            'referer' => $referer,
        ));
    }
}