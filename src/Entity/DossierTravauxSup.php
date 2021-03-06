<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossierTravauxSupRepository")
 * @Vich\Uploadable
 */
class DossierTravauxSup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $designation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $action_corrective;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $carte_travail_tarvaux_sup;

    /**
     * @Assert\File(
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Merci de sélectionner un fichier PDF"
     * )
     * @Vich\UploadableField(mapping="carteTravailTravauxSupFile", fileNameProperty="carte_travail_tarvaux_sup")
     * @var File
     */
    private $carteTravailTravauxSupFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Dossier", inversedBy="travaux_sup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dossier;

    /**
     * @ORM\ManyToOne(targetEntity="Mecanicien", inversedBy="travaux_sup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mecanicien;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $date_signature;

    /**
     * @ORM\ManyToOne(targetEntity="Mecanicien", inversedBy="travaux_sup_control")
     * @ORM\JoinColumn(nullable=true)
     */
    private $mecanicien_control;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="change", field={"mecanicien_control"})
     */
    private $date_signature_control;

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
     * Set designation.
     *
     * @param string $designation
     *
     * @return DossierTravauxSup
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation.
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Set actionCorrective.
     *
     * @param string $actionCorrective
     *
     * @return DossierTravauxSup
     */
    public function setActionCorrective($actionCorrective)
    {
        $this->action_corrective = $actionCorrective;

        return $this;
    }

    /**
     * Get actionCorrective.
     *
     * @return string
     */
    public function getActionCorrective()
    {
        return $this->action_corrective;
    }

    /**
     * Set carteTravail.
     *
     * @param string $carteTravail
     *
     * @return Dossier
     */
    public function setCarteTravailTravauxSup($carteTravailTravauxSup)
    {
        $this->carte_travail_tarvaux_sup = $carteTravailTravauxSup;

        return $this;
    }

    /**
     * Get carteTravail.
     *
     * @return string
     */
    public function getCarteTravailTravauxSup()
    {
        return $this->carte_travail_tarvaux_sup;
    }

    public function setCarteTravailTravauxSupFile(File $image = null)
    {
        $this->carteTravailTravauxSupFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getCarteTravailTravauxSupFile()
    {
        return $this->carteTravailTravauxSupFile;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Dossier
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
     * Set dossier.
     *
     * @param \App\Entity\Dossier $dossier
     *
     * @return DossierTravauxSup
     */
    public function setDossier(\App\Entity\Dossier $dossier)
    {
        $this->dossier = $dossier;

        return $this;
    }

    /**
     * Get dossier.
     *
     * @return \App\Entity\Dossier
     */
    public function getDossier()
    {
        return $this->dossier;
    }

    /**
     * Set mecanicien.
     *
     * @param \App\Entity\Mecanicien|null $mecanicien
     *
     * @return DossierTravauxSup
     */
    public function setMecanicien(\App\Entity\Mecanicien $mecanicien = null)
    {
        $this->mecanicien = $mecanicien;

        return $this;
    }

    /**
     * Get mecanicien.
     *
     * @return \App\Entity\Mecanicien|null
     */
    public function getMecanicien()
    {
        return $this->mecanicien;
    }

    /**
     * Set dateSignature.
     *
     * @param \DateTime|null $dateSignature
     *
     * @return DossierTravauxSup
     */
    public function setDateSignature($dateSignature = null)
    {
        $this->date_signature = $dateSignature;

        return $this;
    }

    /**
     * Get dateSignature.
     *
     * @return \DateTime|null
     */
    public function getDateSignature()
    {
        return $this->date_signature;
    }

    /**
     * Set dateSignatureControl.
     *
     * @param \DateTime|null $dateSignatureControl
     *
     * @return DossierTravauxSup
     */
    public function setDateSignatureControl($dateSignatureControl = null)
    {
        $this->date_signature_control = $dateSignatureControl;

        return $this;
    }

    /**
     * Get dateSignatureControl.
     *
     * @return \DateTime|null
     */
    public function getDateSignatureControl()
    {
        return $this->date_signature_control;
    }

    /**
     * Set mecanicienControl.
     *
     * @param \App\Entity\Mecanicien|null $mecanicienControl
     *
     * @return DossierTravauxSup
     */
    public function setMecanicienControl(\App\Entity\Mecanicien $mecanicienControl = null)
    {
        $this->mecanicien_control = $mecanicienControl;

        return $this;
    }

    /**
     * Get mecanicienControl.
     *
     * @return \App\Entity\Mecanicien|null
     */
    public function getMecanicienControl()
    {
        return $this->mecanicien_control;
    }

    /**
     * Set carteTravailTarvauxSup.
     *
     * @param string|null $carteTravailTarvauxSup
     *
     * @return DossierTravauxSup
     */
    public function setCarteTravailTarvauxSup($carteTravailTarvauxSup = null)
    {
        $this->carte_travail_tarvaux_sup = $carteTravailTarvauxSup;

        return $this;
    }

    /**
     * Get carteTravailTarvauxSup.
     *
     * @return string|null
     */
    public function getCarteTravailTarvauxSup()
    {
        return $this->carte_travail_tarvaux_sup;
    }
}
