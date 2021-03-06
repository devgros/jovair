<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MecanicienRepository")
 * @Vich\Uploadable
 */
class Mecanicien
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $licence;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $trigramme;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $signature;

    /**
     * @Vich\UploadableField(mapping="signature_images", fileNameProperty="signature")
     * @var File
     */
    private $signatureFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="DossierTravaux", mappedBy="mecanicien", cascade={"ALL"})
     */
    private $travaux;

    /**
     * @ORM\OneToMany(targetEntity="DossierTravaux", mappedBy="mecanicien_control", cascade={"ALL"})
     */
    private $travaux_control;

    /**
     * @ORM\OneToMany(targetEntity="DossierCnad", mappedBy="mecanicien", cascade={"ALL"})
     */
    private $cnad;

    /**
     * @ORM\OneToMany(targetEntity="DossierCnad", mappedBy="mecanicien_control", cascade={"ALL"})
     */
    private $cnad_control;

    /**
     * @ORM\OneToMany(targetEntity="DossierTravauxSup", mappedBy="mecanicien", cascade={"ALL"})
     */
    private $travaux_sup;

    /**
     * @ORM\OneToMany(targetEntity="DossierTravauxSup", mappedBy="mecanicien_control", cascade={"ALL"})
     */
    private $travaux_sup_control;

    /**
     * @ORM\OneToMany(targetEntity="Dossier", mappedBy="mecanicien", cascade={"ALL"})
     */
    private $dossier;

    public function __toString()
    {
        return $this->nom." ".$this->prenom;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->travaux = new \Doctrine\Common\Collections\ArrayCollection();
        $this->travaux_control = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cnad = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cnad_control = new \Doctrine\Common\Collections\ArrayCollection();
        $this->travaux_sup = new \Doctrine\Common\Collections\ArrayCollection();
        $this->travaux_sup_control = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dossier = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nom.
     *
     * @param string $nom
     *
     * @return Mecanicien
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom.
     *
     * @param string $prenom
     *
     * @return Mecanicien
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom.
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set licence.
     *
     * @param string $licence
     *
     * @return Mecanicien
     */
    public function setLicence($licence)
    {
        $this->licence = $licence;

        return $this;
    }

    /**
     * Get licence.
     *
     * @return string
     */
    public function getLicence()
    {
        return $this->licence;
    }

    /**
     * Set signature.
     *
     * @param string $signature
     *
     * @return Mecanicien
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Get signature.
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }


    public function setSignatureFile(File $image = null)
    {
        $this->signatureFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getSignatureFile()
    {
        return $this->signatureFile;
    }



    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Mecanicien
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add travaux.
     *
     * @param \App\Entity\DossierTravaux $travaux
     *
     * @return Mecanicien
     */
    public function addTravaux(\App\Entity\DossierTravaux $travaux)
    {
        $this->travaux[] = $travaux;

        return $this;
    }

    /**
     * Remove travaux.
     *
     * @param \App\Entity\DossierTravaux $travaux
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTravaux(\App\Entity\DossierTravaux $travaux)
    {
        return $this->travaux->removeElement($travaux);
    }

    /**
     * Get travaux.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTravaux()
    {
        return $this->travaux;
    }

    /**
     * Add cnad.
     *
     * @param \App\Entity\DossierCnad $cnad
     *
     * @return Mecanicien
     */
    public function addCnad(\App\Entity\DossierCnad $cnad)
    {
        $this->cnad[] = $cnad;

        return $this;
    }

    /**
     * Remove cnad.
     *
     * @param \App\Entity\DossierCnad $cnad
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCnad(\App\Entity\DossierCnad $cnad)
    {
        return $this->cnad->removeElement($cnad);
    }

    /**
     * Get cnad.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCnad()
    {
        return $this->cnad;
    }

    /**
     * Add travauxSup.
     *
     * @param \App\Entity\DossierTravauxSup $travauxSup
     *
     * @return Mecanicien
     */
    public function addTravauxSup(\App\Entity\DossierTravauxSup $travauxSup)
    {
        $this->travaux_sup[] = $travauxSup;

        return $this;
    }

    /**
     * Remove travauxSup.
     *
     * @param \App\Entity\DossierTravauxSup $travauxSup
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTravauxSup(\App\Entity\DossierTravauxSup $travauxSup)
    {
        return $this->travaux_sup->removeElement($travauxSup);
    }

    /**
     * Get travauxSup.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTravauxSup()
    {
        return $this->travaux_sup;
    }

    /**
     * Add dossier.
     *
     * @param \App\Entity\Dossier $dossier
     *
     * @return Mecanicien
     */
    public function addDossier(\App\Entity\Dossier $dossier)
    {
        $this->dossier[] = $dossier;

        return $this;
    }

    /**
     * Remove dossier.
     *
     * @param \App\Entity\Dossier $dossier
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDossier(\App\Entity\Dossier $dossier)
    {
        return $this->dossier->removeElement($dossier);
    }

    /**
     * Get dossier.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDossier()
    {
        return $this->dossier;
    }

    /**
     * Add travauxControl.
     *
     * @param \App\Entity\DossierTravaux $travauxControl
     *
     * @return Mecanicien
     */
    public function addTravauxControl(\App\Entity\DossierTravaux $travauxControl)
    {
        $this->travaux_control[] = $travauxControl;

        return $this;
    }

    /**
     * Remove travauxControl.
     *
     * @param \App\Entity\DossierTravaux $travauxControl
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTravauxControl(\App\Entity\DossierTravaux $travauxControl)
    {
        return $this->travaux_control->removeElement($travauxControl);
    }

    /**
     * Get travauxControl.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTravauxControl()
    {
        return $this->travaux_control;
    }

    /**
     * Add cnadControl.
     *
     * @param \App\Entity\DossierCnad $cnadControl
     *
     * @return Mecanicien
     */
    public function addCnadControl(\App\Entity\DossierCnad $cnadControl)
    {
        $this->cnad_control[] = $cnadControl;

        return $this;
    }

    /**
     * Remove cnadControl.
     *
     * @param \App\Entity\DossierCnad $cnadControl
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCnadControl(\App\Entity\DossierCnad $cnadControl)
    {
        return $this->cnad_control->removeElement($cnadControl);
    }

    /**
     * Get cnadControl.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCnadControl()
    {
        return $this->cnad_control;
    }

    /**
     * Add travauxSupControl.
     *
     * @param \App\Entity\DossierTravauxSup $travauxSupControl
     *
     * @return Mecanicien
     */
    public function addTravauxSupControl(\App\Entity\DossierTravauxSup $travauxSupControl)
    {
        $this->travaux_sup_control[] = $travauxSupControl;

        return $this;
    }

    /**
     * Remove travauxSupControl.
     *
     * @param \App\Entity\DossierTravauxSup $travauxSupControl
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTravauxSupControl(\App\Entity\DossierTravauxSup $travauxSupControl)
    {
        return $this->travaux_sup_control->removeElement($travauxSupControl);
    }

    /**
     * Get travauxSupControl.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTravauxSupControl()
    {
        return $this->travaux_sup_control;
    }

    /**
     * Set trigramme.
     *
     * @param string $trigramme
     *
     * @return Mecanicien
     */
    public function setTrigramme($trigramme)
    {
        $this->trigramme = $trigramme;

        return $this;
    }

    /**
     * Get trigramme.
     *
     * @return string
     */
    public function getTrigramme()
    {
        return $this->trigramme;
    }
}
