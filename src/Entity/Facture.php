<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactureRepository")
 */
class Facture
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
    private $num_facture;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $facture_paye;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="facture")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="Devis", inversedBy="factures")
     */
    private $devis;


    public function __toString()
    {
        return $this->num_facture;
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
     * Set numFacture.
     *
     * @param string $numFacture
     *
     * @return Facture
     */
    public function setNumFacture($numFacture)
    {
        $this->num_facture = $numFacture;

        return $this;
    }

    /**
     * Get numFacture.
     *
     * @return string
     */
    public function getNumFacture()
    {
        return $this->num_facture;
    }

    /**
     * Set dateCreation.
     *
     * @param \DateTime $dateCreation
     *
     * @return Facture
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
     * Set devis.
     *
     * @param \App\Entity\Devis|null $devis
     *
     * @return Facture
     */
    public function setDevis(\App\Entity\Devis $devis = null)
    {
        $this->devis = $devis;

        return $this;
    }

    /**
     * Get devis.
     *
     * @return \App\Entity\Devis|null
     */
    public function getDevis()
    {
        return $this->devis;
    }

    /**
     * Set client.
     *
     * @param \App\Entity\Client|null $client
     *
     * @return Facture
     */
    public function setClient(\App\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client.
     *
     * @return \App\Entity\Client|null
     */
    public function getClient()
    {
        return $this->client;
    }

    public function getDossier()
    {
        return $this->devis->getDossier();
    }

    public function getAppareil()
    {
        if($this->getDossier()){
            return $this->getDossier()->getAppareil();
        }else{
            return "";
        }
    }

    public function getDossierTitre()
    {
        if($this->getDossier()){
            return $this->getDossier()->getTitre();
        }else{
            return "";
        }
    }


    /**
     * Set facturePaye.
     *
     * @param bool $facturePaye
     *
     * @return Facture
     */
    public function setFacturePaye($facturePaye)
    {
        $this->facture_paye = $facturePaye;

        return $this;
    }

    /**
     * Get facturePaye.
     *
     * @return bool
     */
    public function getFacturePaye()
    {
        return $this->facture_paye;
    }
}
