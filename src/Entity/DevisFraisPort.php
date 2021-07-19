<?php

namespace App\Entity;

use App\Repository\DevisFraisPortRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DevisFraisPortRepository::class)
 */
class DevisFraisPort
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Devis", inversedBy="devis_frais_port")
     * @ORM\JoinColumn(nullable=false)
     */
    private $devis;

    /**
     * @ORM\ManyToOne(targetEntity="FraisPort", inversedBy="devis_frais_port")
     * @ORM\JoinColumn(nullable=false)
     */
    private $frais_port;

    public function __toString()
    {
        return $this->devis->getNumDevis()." - ".$this->frais_port->getDesignation();
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
     * Set fraisPort.
     *
     * @param \App\Entity\FraisPort $fraisPort
     *
     * @return DevisFraisPort
     */
    public function setFraisPort(\App\Entity\FraisPort $fraisPort)
    {
        $this->frais_port = $fraisPort;

        return $this;
    }

    /**
     * Get fraisPort.
     *
     * @return \App\Entity\FraisPort
     */
    public function getFraisPort()
    {
        return $this->frais_port;
    }
}
