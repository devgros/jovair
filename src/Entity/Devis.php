<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;


/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisRepository")
 */
class Devis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $num_devis;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $statut = 0;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="devis")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="Dossier", inversedBy="devis")
     * @ORM\JoinColumn(nullable=true)
     */
    private $dossier;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\OneToMany(targetEntity="DevisArticle", mappedBy="devis", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $devis_article;

    /**
     * @ORM\OneToMany(targetEntity="ArticleExterne", mappedBy="devis", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $article_externe;

    /**
     * @ORM\OneToMany(targetEntity="DevisFraisPort", mappedBy="devis", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $devis_frais_port;

    /**
     * @ORM\OneToMany(targetEntity="DevisFraisCertif", mappedBy="devis", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $devis_frais_certif;

    /**
     * @ORM\OneToMany(targetEntity="DevisMainOeuvre", mappedBy="devis", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $devis_main_oeuvre;

    /**
     * @ORM\OneToMany(targetEntity="Facture", mappedBy="devis")
     * @ORM\JoinColumn(nullable=true)
     */
    private $factures;

    /**
     * @ORM\ManyToMany(targetEntity="DossierArticle", inversedBy="devis")
     */
    private $dossier_articles;

    /**
     * @ORM\ManyToMany(targetEntity="DossierMainOeuvre", inversedBy="devis")
     */
    private $dossier_mainoeuvres;

    /**
     * @ORM\ManyToMany(targetEntity="dossierFraisPort", inversedBy="devis")
     */
    private $dossier_fraisports;

    /**
     * @ORM\ManyToMany(targetEntity="dossierFraisCertif", inversedBy="devis")
     */
    private $dossier_fraiscertifs;

     /**
     * @ORM\Column(type="boolean")
     */
    private $new_devis = 1;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $is_tva_intra;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $num_tva_intra;

    public function __toString()
    {
        return $this->num_devis;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->devis_frais_port = new \Doctrine\Common\Collections\ArrayCollection();
        $this->devis_frais_certif = new \Doctrine\Common\Collections\ArrayCollection();
        $this->devis_main_oeuvre = new \Doctrine\Common\Collections\ArrayCollection();
        $this->devis_article = new \Doctrine\Common\Collections\ArrayCollection();
        $this->article_externe = new \Doctrine\Common\Collections\ArrayCollection();
        $this->frais_port = new \Doctrine\Common\Collections\ArrayCollection();
        $this->frais_certif = new \Doctrine\Common\Collections\ArrayCollection();
        $this->factures = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set numDevis.
     *
     * @param string $numDevis
     *
     * @return Devis
     */
    public function setNumDevis($numDevis)
    {
        $this->num_devis = $numDevis;

        return $this;
    }

    /**
     * Get numDevis.
     *
     * @return string
     */
    public function getNumDevis()
    {
        return $this->num_devis;
    }

    /**
     * Set dateCreation.
     *
     * @param \DateTime $dateCreation
     *
     * @return Devis
     */
    public function setDateCreation($dateCreation)
    {
        $this->date_creation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation.
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * Set statut.
     *
     * @param int $statut
     *
     * @return Devis
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut.
     *
     * @return int
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set client.
     *
     * @param \App\Entity\Client $client
     *
     * @return Devis
     */
    public function setClient(\App\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client.
     *
     * @return \App\Entity\Client
     */
    public function getClient()
    {
   		return $this->client;
    }

    /**
     * Set dossier.
     *
     * @param \App\Entity\Dossier|null $dossier
     *
     * @return Devis
     */
    public function setDossier(\App\Entity\Dossier $dossier = null)
    {
        $this->dossier = $dossier;

        return $this;
    }

    /**
     * Get dossier.
     *
     * @return \App\Entity\Dossier|null
     */
    public function getDossier()
    {
        return $this->dossier;
    }

    public function getAppareil()
    {
        if($this->dossier){
            return $this->dossier->getAppareil();
        }else{
            return "";
        }
    }

    public function getDossierTitre()
    {
        if($this->dossier){
            return $this->dossier->getTitre();
        }else{
            return "";
        }
    }


    /**
     * Set commentaire.
     *
     * @param string|null $commentaire
     *
     * @return Devis
     */
    public function setCommentaire($commentaire = null)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire.
     *
     * @return string|null
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Add devisArticle.
     *
     * @param \App\Entity\DevisArticle $devisArticle
     *
     * @return Devis
     */
    public function addDevisArticle(\App\Entity\DevisArticle $devisArticle)
    {
    	$devisArticle->setDevis($this);
        $this->devis_article[] = $devisArticle;

        return $this;
    }

    /**
     * Remove devisArticle.
     *
     * @param \App\Entity\DevisArticle $devisArticle
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDevisArticle(\App\Entity\DevisArticle $devisArticle)
    {
        return $this->devis_article->removeElement($devisArticle);
    }

    /**
     * Get devisArticle.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevisArticle()
    {
        return $this->devis_article;
    }

    /**
     * Add devisMainOeuvre.
     *
     * @param \App\Entity\DevisMainOeuvre $devisMainOeuvre
     *
     * @return Devis
     */
    public function addDevisMainOeuvre(\App\Entity\DevisMainOeuvre $devisMainOeuvre)
    {
    	$devisMainOeuvre->setDevis($this);
        $this->devis_main_oeuvre[] = $devisMainOeuvre;

        return $this;
    }

    /**
     * Remove devisMainOeuvre.
     *
     * @param \App\Entity\DevisMainOeuvre $devisMainOeuvre
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDevisMainOeuvre(\App\Entity\DevisMainOeuvre $devisMainOeuvre)
    {
        return $this->devis_main_oeuvre->removeElement($devisMainOeuvre);
    }

    /**
     * Get devisMainOeuvre.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevisMainOeuvre()
    {
        return $this->devis_main_oeuvre;
    }


    /**
     * Add devisFraisPort.
     *
     * @param \App\Entity\DevisFraisPort $devisFraisPort
     *
     * @return Devis
     */
    public function addDevisFraisPort(\App\Entity\DevisFraisPort $devisFraisPort)
    {
        $devisFraisPort->setDevis($this);
        $this->devis_frais_port[] = $devisFraisPort;

        return $this;
    }

    /**
     * Remove devisFraisPort.
     *
     * @param \App\Entity\DevisFraisPort $devisFraisPort
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDevisFraisPort(\App\Entity\DevisFraisPort $devisFraisPort)
    {
        return $this->devis_frais_port->removeElement($devisFraisPort);
    }

    /**
     * Get devisFraisPort.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevisFraisPort()
    {
        return $this->devis_frais_port;
    }


    /**
     * Add devisFraisCertif.
     *
     * @param \App\Entity\DevisFraisCertif $devisFraisCertif
     *
     * @return Devis
     */
    public function addDevisFraisCertif(\App\Entity\DevisFraisCertif $devisFraisCertif)
    {
        $devisFraisCertif->setDevis($this);
        $this->devis_frais_certif[] = $devisFraisCertif;

        return $this;
    }

    /**
     * Remove devisFraisCertif.
     *
     * @param \App\Entity\DevisFraisCertif $devisFraisCertif
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDevisFraisCertif(\App\Entity\DevisFraisCertif $devisFraisCertif)
    {
        return $this->devis_frais_certif->removeElement($devisFraisCertif);
    }

    /**
     * Get devisFraisCertif.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevisFraisCertif()
    {
        return $this->devis_frais_certif;
    }


    /**
     * Add facture.
     *
     * @param \App\Entity\Facture $facture
     *
     * @return Devis
     */
    public function addFacture(\App\Entity\Facture $facture)
    {
        $this->factures[] = $facture;

        return $this;
    }

    /**
     * Remove facture.
     *
     * @param \App\Entity\Facture $facture
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFacture(\App\Entity\Facture $facture)
    {
        return $this->factures->removeElement($facture);
    }

    /**
     * Get factures.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFactures()
    {
        return $this->factures;
    }

    /**
     * Add articleExterne.
     *
     * @param \App\Entity\ArticleExterne $articleExterne
     *
     * @return Devis
     */
    public function addArticleExterne(\App\Entity\ArticleExterne $articleExterne)
    {
        $articleExterne->setDevis($this);
        $this->article_externe[] = $articleExterne;

        return $this;
    }

    /**
     * Remove articleExterne.
     *
     * @param \App\Entity\ArticleExterne $articleExterne
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeArticleExterne(\App\Entity\ArticleExterne $articleExterne)
    {
        return $this->article_externe->removeElement($articleExterne);
    }

    /**
     * Get articleExterne.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticleExterne()
    {
        return $this->article_externe;
    }

    /**
     * @return Collection|DossierArticle[]
     */
    public function getDossierArticles()
    {
        return $this->dossier_articles;
    }

    public function addDossierArticle(DossierArticle $dossier_article): self
    {
        if (!$this->dossier_articles->contains($dossier_article)) {
            $this->dossier_articles[] = $dossier_article;
            $dossier_article->addDevis($this);
        }

        return $this;
    }

    public function addFirstDossierArticle(DossierArticle $dossier_article): self
    {
            $this->dossier_articles[] = $dossier_article;
            $dossier_article->addDevis($this);

        return $this;
    }

    public function addNewDossierArticle(DossierArticle $dossier_article): self
    {
            $this->dossier_articles[] = $dossier_article;

        return $this;
    }

    public function removeDossierArticle(DossierArticle $dossier_article): self
    {
        if ($this->dossier_articles->contains($dossier_article)) {
            $this->dossier_articles->removeElement($dossier_article);
            $dossier_article->removeDevis($this);
        }

        return $this;
    }

    /**
     * @return Collection|DossierMainOeuvre[]
     */
    public function getDossierMainOeuvres()
    {
        return $this->dossier_mainoeuvres;
    }

    public function addDossierMainOeuvre(DossierMainOeuvre $dossier_mainoeuvre): self
    {
        if (!$this->dossier_mainoeuvres->contains($dossier_mainoeuvre)) {
            $this->dossier_mainoeuvres[] = $dossier_mainoeuvre;
            $dossier_mainoeuvre->addDevis($this);
        }

        return $this;
    }

    public function addFirstDossierMainOeuvre(DossierMainOeuvre $dossier_mainoeuvre): self
    {
            $this->dossier_mainoeuvres[] = $dossier_mainoeuvre;
            $dossier_mainoeuvre->addDevis($this);

        return $this;
    }

    public function addNewDossierMainOeuvre(DossierMainOeuvre $dossier_mainoeuvre): self
    {
        $this->dossier_mainoeuvres[] = $dossier_mainoeuvre;

        return $this;
    }

    public function removeDossierMainOeuvre(DossierMainOeuvre $dossier_mainoeuvre): self
    {
        if ($this->dossier_mainoeuvres->contains($dossier_mainoeuvre)) {
            $this->dossier_mainoeuvres->removeElement($dossier_mainoeuvre);
            $dossier_mainoeuvre->removeDevis($this);
        }

        return $this;
    }

    /**
     * @return Collection|DossierFraisPort[]
     */
    public function getDossierFraisPorts()
    {
        return $this->dossier_fraisports;
    }

    public function addDossierFraisPort(DossierFraisPort $dossier_fraisport): self
    {
        if (!$this->dossier_fraisports->contains($dossier_fraisport)) {
            $this->dossier_fraisports[] = $dossier_fraisport;
            $dossier_fraisport->addDevis($this);
        }

        return $this;
    }

    public function addFirstDossierFraisPort(DossierFraisPort $dossier_fraisport): self
    {
            $this->dossier_fraisports[] = $dossier_fraisport;
            $dossier_fraisport->addDevis($this);

        return $this;
    }

    public function addNewDossierFraisPort(DossierFraisPort $dossier_fraisport): self
    {
        $this->dossier_fraisports[] = $dossier_fraisport;

        return $this;
    }

    public function removeDossierFraisPort(DossierFraisPort $dossier_fraisport): self
    {
        if ($this->dossier_fraisports->contains($dossier_fraisport)) {
            $this->dossier_fraisports->removeElement($dossier_fraisport);
            $dossier_fraisport->removeDevis($this);
        }

        return $this;
    }

    /**
     * @return Collection|DossierFraisCertif[]
     */
    public function getDossierFraisCertifs()
    {
        return $this->dossier_fraiscertifs;
    }

    public function addDossierFraisCertif(DossierFraisCertif $dossier_fraiscertif): self
    {
        if (!$this->dossier_fraiscertifs->contains($dossier_fraiscertif)) {
            $this->dossier_fraiscertifs[] = $dossier_fraiscertif;
            $dossier_fraiscertif->addDevis($this);
        }

        return $this;
    }

    public function addFirstDossierFraisCertif(DossierFraisCertif $dossier_fraiscertif): self
    {
            $this->dossier_fraiscertifs[] = $dossier_fraiscertif;
            $dossier_fraiscertif->addDevis($this);

        return $this;
    }

    public function addNewDossierFraisCertif(DossierFraisCertif $dossier_fraiscertif): self
    {
        $this->dossier_fraiscertifs[] = $dossier_fraiscertif;

        return $this;
    }

    public function removeDossierFraisCertif(DossierFraisCertif $dossier_fraiscertif): self
    {
        if ($this->dossier_fraiscertifs->contains($dossier_fraiscertif)) {
            $this->dossier_fraiscertifs->removeElement($dossier_fraiscertif);
            $dossier_fraiscertif->removeDevis($this);
        }

        return $this;
    }

    /**
     * Set new_devis.
     *
     * @param int $new_devis
     *
     * @return Devis
     */
    public function setNewDevis($new_devis)
    {
        $this->new_devis = $new_devis;

        return $this;
    }

    /**
     * Get new_devis.
     *
     * @return int
     */
    public function getNewDevis()
    {
        return $this->new_devis;
    }

    public function getIsTvaIntra(): ?bool
    {
        return $this->is_tva_intra;
    }

    public function setIsTvaIntra(?bool $is_tva_intra): self
    {
        $this->is_tva_intra = $is_tva_intra;

        return $this;
    }

    public function getNumTvaIntra(): ?string
    {
        return $this->num_tva_intra;
    }

    public function setNumTvaIntra(?string $num_tva_intra): self
    {
        $this->num_tva_intra = $num_tva_intra;

        return $this;
    }

    public function getFdpPiece()
    {
        $fdp_piece_total = 0;
        foreach($this->article_externe as $article_externe)
        {
            if($article_externe->getMontantFdpHt() != null){
                $fdp_piece_total = $fdp_piece_total + $article_externe->getMontantFdpHt();
            }
        }

        foreach($this->devis_article as $devis_article)
        {
            if($devis_article->getArticleFormone()->getMontantFdpHt() != null){
                $fdp_piece_total = $fdp_piece_total + ($devis_article->getArticleFormone()->getMontantFdpHt() * $devis_article->getQuantite());
            }
        }

        if($this->getDossier())
        {
            foreach($this->getDossier()->getDossierArticleExternes() as $article_externe_dossier)
            {
                if($article_externe_dossier->getMontantFdpHt() != null){
                    $fdp_piece_total = $fdp_piece_total + $article_externe_dossier->getMontantFdpHt();
                }
            }
            foreach($this->getDossier()->getDossierArticle() as $article_dossier)
            {
                if($article_dossier->getArticleFormone()->getMontantFdpHt() != null){
                    $fdp_piece_total = $fdp_piece_total + $article_dossier->getArticleFormone()->getMontantFdpHt();
                }
            }
        }
        return $fdp_piece_total;
    }

    public function getFdcPiece()
    {
        $fdc_piece_total = 0;
        foreach($this->article_externe as $article_externe)
        {
            if($article_externe->getMontantFdcHt() != null){
                $fdc_piece_total = $fdc_piece_total + $article_externe->getMontantFdcHt();
            }
        }

        foreach($this->devis_article as $devis_article)
        {
            if($devis_article->getArticleFormone()->getMontantFdcHt() != null){
                $fdc_piece_total = $fdc_piece_total + ($devis_article->getArticleFormone()->getMontantFdcHt() * $devis_article->getQuantite());
            }
        }

        if($this->getDossier())
        {
            foreach($this->getDossier()->getDossierArticleExternes() as $article_externe_dossier)
            {
                if($article_externe_dossier->getMontantFdcHt() != null){
                    $fdc_piece_total = $fdc_piece_total + $article_externe_dossier->getMontantFdcHt();
                }
            }
            foreach($this->getDossier()->getDossierArticle() as $article_dossier)
            {
                if($article_dossier->getArticleFormone()->getMontantFdcHt() != null){
                    $fdc_piece_total = $fdc_piece_total + $article_dossier->getArticleFormone()->getMontantFdcHt();
                }
            }
        }
        return $fdc_piece_total;
    }
}
