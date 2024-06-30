<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="boolean")
     */
    private $paiement_liquide;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="facture")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="Devis", inversedBy="factures")
     */
    private $devis;

    /**
     * @ORM\Column(type="boolean")
     */
    private $avoir;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $num_avoir;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_avoir;

        /**
     * @ORM\Column(type="boolean")
     */
    private $paiement_cheque;

    /**
     * @ORM\Column(type="boolean")
     */
    private $paiement_virement;

    /**
     * @ORM\OneToMany(targetEntity=FactureAcompte::class, mappedBy="facture", cascade={"ALL"}, indexBy="date")
     * @ORM\OrderBy({"date" = "DESC"})
     */
    private $facture_acompte;

    public function __construct()
    {
        $this->facture_acompte = new ArrayCollection();
    }


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

    /**
     * Set paiementLiquide.
     *
     * @param bool $paiementLiquide
     *
     * @return Facture
     */
    public function setPaiementLiquide($paiementLiquide)
    {
        $this->paiement_liquide = $paiementLiquide;

        return $this;
    }

    /**
     * Get paiementLiquide.
     *
     * @return bool
     */
    public function getPaiementLiquide()
    {
        return $this->paiement_liquide;
    }

    public function getAvoir(): ?bool
    {
        return $this->avoir;
    }

    public function setAvoir(bool $avoir): self
    {
        $this->avoir = $avoir;

        return $this;
    }

    public function getNumAvoir(): ?string
    {
        return $this->num_avoir;
    }

    public function setNumAvoir(?string $num_avoir): self
    {
        $this->num_avoir = $num_avoir;

        return $this;
    }

    public function getDateAvoir(): ?\DateTimeInterface
    {
        return $this->date_avoir;
    }

    public function setDateAvoir(?\DateTimeInterface $date_avoir): self
    {
        $this->date_avoir = $date_avoir;

        return $this;
    }

    public function getPaiementCheque(): ?bool
    {
        return $this->paiement_cheque;
    }

    public function setPaiementCheque(bool $paiement_cheque): self
    {
        $this->paiement_cheque = $paiement_cheque;

        return $this;
    }

    public function getPaiementVirement(): ?bool
    {
        return $this->paiement_virement;
    }

    public function setPaiementVirement(bool $paiement_virement): self
    {
        $this->paiement_virement = $paiement_virement;

        return $this;
    }

    /**
     * @return Collection<int, FactureAcompte>
     */
    public function getFactureAcompte(): Collection
    {
        return $this->facture_acompte;
    }

    public function addFactureAcompte(FactureAcompte $factureAcompte): self
    {
        if (!$this->facture_acompte->contains($factureAcompte)) {
            $this->facture_acompte[] = $factureAcompte;
            $factureAcompte->setFacture($this);
        }

        return $this;
    }

    public function removeFactureAcompte(FactureAcompte $factureAcompte): self
    {
        if ($this->facture_acompte->removeElement($factureAcompte)) {
            // set the owning side to null (unless already changed)
            if ($factureAcompte->getFacture() === $this) {
                $factureAcompte->setFacture(null);
            }
        }

        return $this;
    }
}
