<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DevisMainOeuvreRepository")
 */
class DevisMainOeuvre
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
     * @ORM\ManyToOne(targetEntity="Devis", inversedBy="devis_main_oeuvre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $devis;

    /**
     * @ORM\ManyToOne(targetEntity="MainOeuvre", inversedBy="devis_main_oeuvre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $main_oeuvre;

    public function __toString()
    {
        return $this->devis->getNumDevis()." - ".$this->main_oeuvre->getNom()." | qte:".$this->quantite;
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
     * @return DevisMainOeuvre
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
     * @return DevisMainOeuvre
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
     * @return DevisMainOeuvre
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
     * Set mainOeuvre.
     *
     * @param \App\Entity\MainOeuvre $mainOeuvre
     *
     * @return DevisMainOeuvre
     */
    public function setMainOeuvre(\App\Entity\MainOeuvre $mainOeuvre)
    {
        $this->main_oeuvre = $mainOeuvre;

        return $this;
    }

    /**
     * Get mainOeuvre.
     *
     * @return \App\Entity\MainOeuvre
     */
    public function getMainOeuvre()
    {
        return $this->main_oeuvre;
    }
}
