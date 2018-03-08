<?php
namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;
use app\entity\Article;
use app\entity\ArticlePrix;
use app\entity\MainOeuvre;
use app\entity\MainOeuvrePrix;
use app\entity\DossierArticle;
use app\entity\ArticleFormone;

class EasyAdminSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            'easy_admin.post_persist' => array(array('addArticlePrix'), array('addMainOeuvrePrix'), array('newQteArticle')),
            'easy_admin.post_update' => array(array('addArticlePrix'), array('addMainOeuvrePrix')),
            'easy_admin.pre_edit' => array(array('storeQteArticle')),
            'easy_admin.pre_update' => array(array('updateQteArticle')),
        );
    }

    public function addArticlePrix(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof Article) {
            $create_articleprix = false;
            if($entity->getLastPrix())
            {
                if($entity->getPrixHt() != $entity->getLastPrix()->getPrixHt()) $create_articleprix = true;
            }else{
                $create_articleprix = true;
            }
            if($create_articleprix)
            {
                $article_prix = new ArticlePrix();
                $article_prix->setPrixHt($entity->getPrixHt());
                $article_prix->setArticle($entity);
                $event['em']->persist($article_prix);
                $event['em']->flush($article_prix);
            }
        }
    }

    public function addMainOeuvrePrix(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof MainOeuvre) {
            $create_prix = false;
            if($entity->getLastPrix())
            {
                if($entity->getPrixHt() != $entity->getLastPrix()->getPrixHt()) $create_prix = true;
            }else{
                $create_prix = true;
            }
            if($create_prix)
            {
                $main_oeuvre_prix = new MainOeuvrePrix();
                $main_oeuvre_prix->setPrixHt($entity->getPrixHt());
                $main_oeuvre_prix->setMainOeuvre($entity);
                $event['em']->persist($main_oeuvre_prix);
                $event['em']->flush($main_oeuvre_prix);
            }
        }
    }

    public function newQteArticle(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof DossierArticle) {
            $qte_stock = $entity->getArticleFormone()->getQuantite();
            $qte_utilise = $entity->getQuantite();

            $new_qte_stock = $qte_stock - $qte_utilise;
            $entity->getArticleFormone()->setQuantite($new_qte_stock);
            $event['em']->persist($entity->getArticleFormone());
            $event['em']->flush($entity->getArticleFormone());
        }
    }

    public function storeQteArticle(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if($entity['name'] == "DossierArticle")
        {
            $old_qte_dossier_article = $event['em']->getRepository(DossierArticle::class, 'default')->findOldQte($event['request']->get('id'));
            $session = new Session();
            $session->set('old_qte_dossier_article', $old_qte_dossier_article->getQuantite());
        }
    }

    public function updateQteArticle(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof DossierArticle) {
            $session = new Session();
            $old_qte_dossier_article = $session->get('old_qte_dossier_article');

            $qte_stock = $entity->getArticleFormone()->getQuantite();
            $qte_utilise = $entity->getQuantite();

            if($qte_utilise == $old_qte_dossier_article){
                $new_qte_stock = $qte_stock;
            }elseif($qte_utilise > $old_qte_dossier_article){
                $new_qte_stock = $qte_stock - ($qte_utilise-$old_qte_dossier_article);
            }else{
                $new_qte_stock = $qte_stock + ($old_qte_dossier_article-$qte_utilise);
            }

            $entity->getArticleFormone()->setQuantite($new_qte_stock);
            $event['em']->persist($entity->getArticleFormone());
            $event['em']->flush($entity->getArticleFormone());
            $session->remove('old_qte_dossier_article');
        }
    }
}