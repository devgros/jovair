<?php

namespace App\Entity;

use App\Repository\DevisFraisCertifRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DevisFraisCertifRepository::class)
 */
class DevisFraisCertif
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Devis", inversedBy="devis_frais_certif")
     * @ORM\JoinColumn(nullable=false)
     */
    private $devis;

    /**
     * @ORM\ManyToOne(targetEntity="FraisCertif", inversedBy="devis_frais_certif")
     * @ORM\JoinColumn(nullable=false)
     */
    private $frais_certif;

    public function __toString()
    {
        return $this->devis->getNumDevis()." - ".$this->frais_certif->getDesignation();
    }

    public function getId(): ?int
    {
        return $this->id;
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
 * Set fraisCertif.
 *
 * @param \App\Entity\FraisCertif $fraisCertif
 *
 * @return DevisFraisCertif
 */
public function setFraisCertif(\App\Entity\FraisCertif $fraisCertif)
{
    $this->frais_certif = $fraisCertif;

    return $this;
}

/**
 * Get FraisCertif.
 *
 * @return \App\Entity\FraisCertif
 */
public function getFraisCertif()
{
    return $this->frais_certif;
}
}
