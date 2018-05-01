<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossierOutilsRepository")
 */
class DossierOutils
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Dossier", inversedBy="dossier_outils")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dossier;

    /**
     * @ORM\ManyToOne(targetEntity="OutillageCertificat", inversedBy="dossier_outils")
     * @ORM\OrderBy({"id" = "DESC"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $outillage;

    /**
     * @ORM\OneToOne(targetEntity="Compressiometre", inversedBy="dossier_outils", cascade={"persist", "remove"})
     */
    private $compressiometre;

    public function __toString()
    {
        return $this->getDossier()." - ".$this->getOutillage();
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
     * Set dossier.
     *
     * @param \App\Entity\Dossier|null $dossier
     *
     * @return DossierTravaux
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

    /**
     * Set outillage.
     *
     * @param \App\Entity\OutillageCertificat|null $outillage
     *
     * @return DossierTravaux
     */
    public function setOutillage(\App\Entity\OutillageCertificat $outillage = null)
    {
        $this->outillage = $outillage;

        return $this;
    }

    /**
     * Get outillage.
     *
     * @return \App\Entity\OutillageCertificat|null
     */
    public function getOutillage()
    {
        return $this->outillage;
    }

    /**
     * Set compressiometre.
     *
     * @param \App\Entity\Compressiometre $compressiometre
     *
     * @return DossierOutils
     */
    public function setCompressiometre(\App\Entity\Compressiometre $compressiometre)
    {
        //$compressiometre->setDossierOutils($this);
        $this->compressiometre = $compressiometre;

        return $this;
    }

    /**
     * Get compressiometre.
     *
     * @return \App\Entity\Compressiometre
     */
    public function getCompressiometre()
    {
        return $this->compressiometre;
    }
}
