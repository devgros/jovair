<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticlePrixRepository")
 */
class ArticlePrix
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $date_change;

    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $prix_ht;

    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="article_prix")
     */
    private $article;

    public function __toString()
    {
        return $this->prix_ht;
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
     * Get dateChange.
     *
     * @return \DateTime
     */
    public function getDateChange()
    {
        return $this->date_change;
    }

    /**
     * Set dateChange.
     *
     * @param \DateTime $dateChange
     *
     * @return ArticlePrix
     */
    public function setDateChange($dateChange)
    {
        $this->date_change = $dateChange;

        return $this;
    }

    /**
     * Set prixHt.
     *
     * @param string $prixHt
     *
     * @return ArticlePrix
     */
    public function setPrixHt($prixHt)
    {
        $this->prix_ht = $prixHt;

        return $this;
    }

    /**
     * Get prixHt.
     *
     * @return string
     */
    public function getPrixHt()
    {
        return $this->prix_ht;
    }

    /**
     * Set article.
     *
     * @param \App\Entity\Article|null $article
     *
     * @return ArticlePrix
     */
    public function setArticle(\App\Entity\Article $article = null)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article.
     *
     * @return \App\Entity\Article|null
     */
    public function getArticle()
    {
        return $this->article;
    }
}
