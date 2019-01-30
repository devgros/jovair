<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleMargeRepository")
 */
class ArticleMarge
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
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
    private $marge;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="article_marge")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    public function __toString()
    {
        return $this->marge;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateChange(): ?\DateTimeInterface
    {
        return $this->date_change;
    }

    public function setDateChange(\DateTimeInterface $date_change): self
    {
        $this->date_change = $date_change;

        return $this;
    }

    public function getMarge()
    {
        return $this->marge;
    }

    public function setMarge($marge): self
    {
        $this->marge = $marge;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
