<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossierArticleRepository")
 */
class DossierArticle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $quantite;

    /**
     * @ORM\Column(type="decimal", scale=2, options={"default" : 0})
     * @Assert\GreaterThanOrEqual(0)
     */
    private $remise;

    /**
     * @ORM\ManyToOne(targetEntity="Dossier", inversedBy="dossier_article")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dossier;

    /**
     * @ORM\ManyToOne(targetEntity="ArticleFormone", inversedBy="dossier_article")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article_formone;

    /**
     * @ORM\ManyToMany(targetEntity="Devis", mappedBy="dossier_articles")
     */
    private $devis;

    public function __toString()
    {
        return $this->dossier->getNumBl()." - ".$this->article_formone->getSn()." | qte:".$this->quantite;
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
     * Set quantite.
     *
     * @param int $quantite
     *
     * @return DossierArticle
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite.
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set remise.
     *
     * @param string $remise
     *
     * @return DossierArticle
     */
    public function setRemise($remise)
    {
        $this->remise = $remise;

        return $this;
    }

    /**
     * Get remise.
     *
     * @return string
     */
    public function getRemise()
    {
        return $this->remise;
    }

    /**
     * Set dossier.
     *
     * @param \App\Entity\Dossier $dossier
     *
     * @return DossierArticle
     */
    public function setDossier(\App\Entity\Dossier $dossier)
    {
        $this->dossier = $dossier;

        return $this;
    }

    /**
     * Get dossier.
     *
     * @return \App\Entity\Dossier
     */
    public function getDossier()
    {
        return $this->dossier;
    }

    /**
     * Set articleFormone.
     *
     * @param \App\Entity\ArticleFormone $articleFormone
     *
     * @return DossierArticle
     */
    public function setArticleFormone(\App\Entity\ArticleFormone $articleFormone)
    {
        $this->article_formone = $articleFormone;

        return $this;
    }

    /**
     * Get articleFormone.
     *
     * @return \App\Entity\ArticleFormone
     */
    public function getArticleFormone()
    {
        return $this->article_formone;
    }

    public function getDossierId()
    {
        return $this->dossier->getId();
    }

    public function getDossierArticleLabel()
    {
        return $this->article_formone->getArticle()->getNom()." | sn:".$this->article_formone->getSn()." | qte:".$this->quantite;
    }

    /**
     * @return Collection|Devis[]
     */
    public function getDevis()
    {
        return $this->devis;
    }

    public function addDevis(Devis $devis): self
    {
        if (!$this->devis->contains($devis)) {
            $this->devis[] = $devis;
        }

        return $this;
    }

    public function addNewDevis(Devis $devis): self
    {
        $this->devis[] = $devis;
        

        return $this;
    }

    public function removeDevis(Devis $devis): self
    {
        if ($this->devis->contains($devis)) {
            $this->devis->removeElement($devis);
        }

        return $this;
    }
}
