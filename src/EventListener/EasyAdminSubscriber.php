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
use app\entity\Outillage;
use app\entity\OutillagePrix;
use app\entity\DossierArticle;
use app\entity\DevisArticle;
use app\entity\ArticleFormone;

class EasyAdminSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            'easy_admin.post_persist' => array(array('addArticlePrix'), array('addMainOeuvrePrix'), array('addOutillagePrix'), array('newQteArticle')),
            'easy_admin.post_update' => array(array('addArticlePrix'), array('addMainOeuvrePrix'), array('addOutillagePrix')),
            'easy_admin.pre_edit' => array(array('storeQteArticle')),
            'easy_admin.pre_update' => array(array('updateQteArticle')),
            'easy_admin.pre_remove' => array(array('restockQteArticle')),
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

    public function addOutillagePrix(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof Outillage) {
            $create_outillageprix = false;
            if($entity->getLastPrix())
            {
                if($entity->getPrixHt() != $entity->getLastPrix()->getPrixHt()) $create_outillageprix = true;
            }else{
                $create_outillageprix = true;
            }
            if($create_outillageprix)
            {
                $outillage_prix = new OutillagePrix();
                $outillage_prix->setPrixHt($entity->getPrixHt());
                $outillage_prix->setOutillage($entity);
                $event['em']->persist($outillage_prix);
                $event['em']->flush($outillage_prix);
            }
        }
    }

    public function newQteArticle(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof DossierArticle or $entity instanceof DevisArticle) {
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
        if($entity['name'] == "DevisArticle")
        {
            $old_qte_dossier_article = $event['em']->getRepository(DevisArticle::class, 'default')->findOldQte($event['request']->get('id'));
            $session = new Session();
            $session->set('old_qte_dossier_article', $old_qte_dossier_article->getQuantite());
        }
    }

    public function updateQteArticle(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof DossierArticle or $entity instanceof DevisArticle) {
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

    public function restockQteArticle(GenericEvent $event)
    {
        $entity = $event->getSubject();
        if ($entity instanceof DossierArticle or $entity instanceof DevisArticle) {

            $qte_to_restock = $entity->getQuantite();
            $qte_stock = $entity->getArticleFormone()->getQuantite();
            $new_qte_stock = $qte_stock + $qte_to_restock;
            $entity->getArticleFormone()->setQuantite($new_qte_stock);
            $event['em']->persist($entity->getArticleFormone());
            $event['em']->flush($entity->getArticleFormone());

        }
    }
}