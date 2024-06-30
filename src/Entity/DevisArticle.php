<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisArticleRepository")
 */
class DevisArticle
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
     * @ORM\Column(type="decimal", nullable=true, scale=2, options={"default" : 0})
     * @Assert\GreaterThanOrEqual(0)
     */
    private $remise;

    /**
     * @ORM\ManyToOne(targetEntity="Devis", inversedBy="devis_article")
     * @ORM\JoinColumn(nullable=false)
     */
    private $devis;

    /**
     * @ORM\ManyToOne(targetEntity="ArticleFormone", inversedBy="devis_article")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article_formone;

    public function __toString()
    {
        return $this->devis->getNumDevis()." - ".$this->article_formone->getSn()." | qte:".$this->quantite;
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
     * @return DevisArticle
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
     * @return DevisArticle
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
     * Set devis.
     *
     * @param \App\Entity\Devis $devis
     *
     * @return DevisArticle
     */
    public function setDevis(\App\Entity\Devis $devis)
    {
        $this->devis = $devis;

        return $this;
    }

    /**
     * Get devis.
     *
     * @return \App\Entity\Devis
     */
    public function getDevis()
    {
        return $this->devis;
    }

    /**
     * Set articleFormone.
     *
     * @param \App\Entity\ArticleFormone $articleFormone
     *
     * @return DevisArticle
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
}
