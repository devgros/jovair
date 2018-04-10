<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OutillageCertificatRepository")
 * @Vich\Uploadable
 */
class OutillageCertificat
{

	/**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Outillage", inversedBy="outillage_certificats")
     */
    private $outillage;

    /**
     * @ORM\Column(type="date")
     */
    private $date_validite;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $certificat;

    /**
     * @Assert\File(
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Merci de sélectionner un fichier PDF"
     * )
     * @Vich\UploadableField(mapping="certificat_files", fileNameProperty="certificat")
     * @var File
     */
    private $certificatFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="DossierOutils", mappedBy="outillage", cascade={"ALL"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    private $dossier_outils;

    public function __toString()
    {
        return $this->outillage->getNom()." - Sn:".$this->outillage->getSn()." - Date:".$this->date_validite->format('d/m/Y');
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dossier_outils = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set dateValidite.
     *
     * @param \DateTime $dateValidite
     *
     * @return OutillageCertificat
     */
    public function setDateValidite($dateValidite)
    {
        $this->date_validite = $dateValidite;

        return $this;
    }

    /**
     * Get dateValidite.
     *
     * @return \DateTime
     */
    public function getDateValidite()
    {
        return $this->date_validite;
    }

    /**
     * Set certificat.
     *
     * @param string $certificat
     *
     * @return OutillageCertificat
     */
    public function setCertificat($certificat)
    {
        $this->certificat = $certificat;

        return $this;
    }

    /**
     * Get certificat.
     *
     * @return string
     */
    public function getCertificat()
    {
        return $this->certificat;
    }

    public function setCertificatFile(File $file = null)
    {
        $this->certificatFile = $file;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($file) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getCertificatFile()
    {
        return $this->certificatFile;
    }


    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return OutillageCertificat
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
     * Set outillage.
     *
     * @param \App\Entity\Outillage $outillage
     *
     * @return OutillageCertificat
     */
    public function setOutillage(\App\Entity\Outillage $outillage)
    {
        $this->outillage = $outillage;

        return $this;
    }

    /**
     * Get outillage.
     *
     * @return \App\Entity\Outillage
     */
    public function getOutillage()
    {
        return $this->outillage;
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
     * Add dossierOutil.
     *
     * @param \App\Entity\DossierOutils $dossierOutil
     *
     * @return Outillage
     */
    public function addDossierOutil(\App\Entity\DossierOutils $dossierOutil)
    {
        $dossier_outils->setOutillage($this);
        $this->dossier_outils[] = $dossierOutil;

        return $this;
    }

    /**
     * Remove dossierOutil.
     *
     * @param \App\Entity\DossierOutils $dossierOutil
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDossierOutil(\App\Entity\DossierOutils $dossierOutil)
    {
        return $this->dossier_outils->removeElement($dossierOutil);
    }

    /**
     * Get dossierOutils.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDossierOutils()
    {
        return $this->dossier_outils;
    }
}
