<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossierRepository")
 * @Vich\Uploadable
 */
class Dossier
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $num_bc;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $statut = 0;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $num_bl;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_cf;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $time_cf;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lieu_cf;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $remarque_aprs;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_valid_ctrl_ok = false;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $horametre_aprs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $scan_bc;

    /**
     * @Assert\File(
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Merci de sélectionner un fichier PDF"
     * )
     * @Vich\UploadableField(mapping="scanBcFile", fileNameProperty="scan_bc")
     * @var File
     */
    private $scanBcFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedBcAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $carte_travail;

    /**
     * @Assert\File(
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Merci de sélectionner un fichier PDF"
     * )
     * @Vich\UploadableField(mapping="carteTravailFile", fileNameProperty="carte_travail")
     * @var File
     */
    private $carteTravailFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $dossier_final;

    /**
     * @Assert\File(
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Merci de sélectionner un fichier PDF"
     * )
     * @Vich\UploadableField(mapping="dossierFinalFile", fileNameProperty="dossier_final")
     * @var File
     */
    private $dossierFinalFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedDfAt;

    /**
     * @Assert\GreaterThanOrEqual(0)
     */
    private $heure_derniere_aprs;

    /**
     * @ORM\ManyToOne(targetEntity="Appareil", inversedBy="appareil_dossier")
     * @ORM\JoinColumn(nullable=false)
     */
    private $appareil;

    /**
     * @ORM\ManyToOne(targetEntity="Mecanicien", inversedBy="dossier")
     * @ORM\JoinColumn(nullable=true)
     */
    private $mecanicien;

    /**
     * @ORM\OneToMany(targetEntity="DossierTravaux", mappedBy="dossier", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $travaux;

    /**
     * @ORM\OneToMany(targetEntity="DossierCnad", mappedBy="dossier", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $cnad;

    /**
     * @ORM\OneToMany(targetEntity="DossierTravauxSup", mappedBy="dossier", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $travaux_sup;

    /**
     * @ORM\OneToMany(targetEntity="DossierMainOeuvre", mappedBy="dossier", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $dossier_main_oeuvre;

    /**
     * @ORM\OneToMany(targetEntity="DossierFraisPort", mappedBy="dossier", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $dossier_frais_port;

    /**
     * @ORM\OneToMany(targetEntity="DossierFraisCertif", mappedBy="dossier", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $dossier_frais_certif;

    /**
     * @ORM\OneToMany(targetEntity="DossierArticle", mappedBy="dossier", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $dossier_article;

    /**
     * @ORM\OneToMany(targetEntity="DossierOutils", mappedBy="dossier", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $dossier_outils;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Devis", mappedBy="dossier")
     */
    private $devis;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DossierArticleExterne", mappedBy="dossier", orphanRemoval=true)
     */
    private $dossier_article_externes;

    public function __toString()
    {
        return $this->num_bl;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->travaux = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cnad = new \Doctrine\Common\Collections\ArrayCollection();
        $this->travaux_sup = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dossier_main_oeuvre = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dossier_frais_port = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dossier_frais_certif = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dossier_article = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dossier_outils = new \Doctrine\Common\Collections\ArrayCollection();
        $this->devis = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dossier_article_externes = new ArrayCollection();
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
     * Set numBc.
     *
     * @param string $numBc
     *
     * @return Dossier
     */
    public function setNumBc($numBc)
    {
        $this->num_bc = $numBc;

        return $this;
    }

    /**
     * Get numBc.
     *
     * @return string
     */
    public function getNumBc()
    {
        return $this->num_bc;
    }

    /**
     * Set dateCreation.
     *
     * @param \DateTime $dateCreation
     *
     * @return Dossier
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
     * Set statut.
     *
     * @param int $statut
     *
     * @return Dossier
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut.
     *
     * @return int
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set numBl.
     *
     * @param string $numBl
     *
     * @return Dossier
     */
    public function setNumBl($numBl)
    {
        $this->num_bl = $numBl;

        return $this;
    }

    /**
     * Get numBl.
     *
     * @return string
     */
    public function getNumBl()
    {
        return $this->num_bl;
    }

    /**
     * Set dateCf.
     *
     * @param \DateTime $dateCf
     *
     * @return Dossier
     */
    public function setDateCf($dateCf)
    {
        $this->date_cf = $dateCf;

        return $this;
    }

    /**
     * Get dateCf.
     *
     * @return \DateTime
     */
    public function getDateCf()
    {
        return $this->date_cf;
    }

    /**
     * Set lieuBc.
     *
     * @param string $lieuBc
     *
     * @return Dossier
     */
    public function setLieuCf($lieuCf)
    {
        $this->lieu_cf = $lieuCf;

        return $this;
    }

    /**
     * Get lieuBc.
     *
     * @return string
     */
    public function getLieuCf()
    {
        return $this->lieu_cf;
    }

    /**
     * Set remarqueAprs.
     *
     * @param string $remarqueAprs
     *
     * @return Dossier
     */
    public function setRemarqueAprs($remarqueAprs)
    {
        $this->remarque_aprs = $remarqueAprs;

        return $this;
    }

    /**
     * Get remarqueAprs.
     *
     * @return string
     */
    public function getRemarqueAprs()
    {
        return $this->remarque_aprs;
    }

    /**
     * Set isValidCtrlOk.
     *
     * @param bool $isValidCtrlOk
     *
     * @return Dossier
     */
    public function setIsValidCtrlOk($isValidCtrlOk)
    {
        $this->is_valid_ctrl_ok = $isValidCtrlOk;

        return $this;
    }

    /**
     * Get isValidCtrlOk.
     *
     * @return bool
     */
    public function getIsValidCtrlOk()
    {
        return $this->is_valid_ctrl_ok;
    }

    /**
     * Set horametreAprs.
     *
     * @param int $horametreAprs
     *
     * @return Dossier
     */
    public function setHorametreAprs($horametreAprs)
    {
        $this->horametre_aprs = $horametreAprs;

        return $this;
    }

    /**
     * Get horametreAprs.
     *
     * @return int
     */
    public function getHorametreAprs()
    {
        return $this->horametre_aprs;
    }

    /**
     * Set scanBc.
     *
     * @param string $scanBc
     *
     * @return Dossier
     */
    public function setScanBc($scanBc)
    {
        $this->scan_bc = $scanBc;

        return $this;
    }

    /**
     * Get scanBc.
     *
     * @return string
     */
    public function getscanBc()
    {
        return $this->scan_bc;
    }

    public function setScanBcFile(File $image = null)
    {
        $this->scanBcFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedBcAt' is not defined in your entity, use another property
            $this->updatedBcAt = new \DateTime('now');
        }
    }

    public function getScanBcFile()
    {
        return $this->scanBcFile;
    }

    /**
     * Set updatedBcAt.
     *
     * @param \DateTime $updatedBcAt
     *
     * @return Dossier
     */
    public function setUpdatedBcAt($updatedBcAt)
    {
        $this->updatedBcAt = $updatedBcAt;

        return $this;
    }

    /**
     * Get updatedBcAt.
     *
     * @return \DateTime
     */
    public function getUpdatedBcAt()
    {
        return $this->updatedBcAt;
    }

    /**
     * Set carteTravail.
     *
     * @param string $carteTravail
     *
     * @return Dossier
     */
    public function setCarteTravail($carteTravail)
    {
        $this->carte_travail = $carteTravail;

        return $this;
    }

    /**
     * Get carteTravail.
     *
     * @return string
     */
    public function getCarteTravail()
    {
        return $this->carte_travail;
    }

    public function setCarteTravailFile(File $image = null)
    {
        $this->carteTravailFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getCarteTravailFile()
    {
        return $this->carteTravailFile;
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
     * Set dossierFinal.
     *
     * @param string $dossierFinal
     *
     * @return Dossier
     */
    public function setDossierFinal($dossierFinal)
    {
        $this->dossier_final = $dossierFinal;

        return $this;
    }

    /**
     * Get dossierFinal.
     *
     * @return string
     */
    public function getDossierFinal()
    {
        return $this->dossier_final;
    }

    public function setDossierFinalFile(File $image = null)
    {
        $this->dossierFinalFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedDfAt = new \DateTime('now');
        }
    }

    public function getDossierFinalFile()
    {
        return $this->dossierFinalFile;
    }

    /**
     * Set updatedDfAt.
     *
     * @param \DateTime $updatedDfAt
     *
     * @return Dossier
     */
    public function setUpdatedDfAt($updatedDfAt)
    {
        $this->updatedDfAt = $updatedDfAt;

        return $this;
    }

    /**
     * Get updatedDfAt.
     *
     * @return \DateTime
     */
    public function getUpdatedDfAt()
    {
        return $this->updatedDfAt;
    }

    /**
     * Set appareil.
     *
     * @param \App\Entity\Appareil|null $appareil
     *
     * @return Dossier
     */
    public function setAppareil(\App\Entity\Appareil $appareil = null)
    {
        $this->appareil = $appareil;

        return $this;
    }

    /**
     * Get appareil.
     *
     * @return \App\Entity\Appareil|null
     */
    public function getAppareil()
    {
        return $this->appareil;
    }

    /**
     * Add travaux.
     *
     * @param \App\Entity\DossierTravaux $travaux
     *
     * @return Dossier
     */
    public function addTravaux(\App\Entity\DossierTravaux $travaux)
    {
        $travaux->setDossier($this);
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

    public function getFirstTravaux(){
        return $this->travaux->first();
    }

    /**
     * Add cnad.
     *
     * @param \App\Entity\DossierCnad $cnad
     *
     * @return Dossier
     */
    public function addCnad(\App\Entity\DossierCnad $cnad)
    {
        $cnad->setDossier($this);
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
     * Add dossierMainOeuvre.
     *
     * @param \App\Entity\DossierMainOeuvre $dossierMainOeuvre
     *
     * @return Dossier
     */
    public function addDossierMainOeuvre(\App\Entity\DossierMainOeuvre $dossierMainOeuvre)
    {
        $dossierMainOeuvre->setDossier($this);
        $this->dossier_main_oeuvre[] = $dossierMainOeuvre;

        return $this;
    }

    /**
     * Remove dossierMainOeuvre.
     *
     * @param \App\Entity\DossierMainOeuvre $dossierMainOeuvre
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDossierMainOeuvre(\App\Entity\DossierMainOeuvre $dossierMainOeuvre)
    {
        return $this->dossier_main_oeuvre->removeElement($dossierMainOeuvre);
    }

    /**
     * Get dossierMainOeuvre.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDossierMainOeuvre()
    {
        return $this->dossier_main_oeuvre;
    }

    public function getGroupDossierMainOeuvre()
    {
        $groupDossierMainOeuvre = array();

        foreach($this->dossier_main_oeuvre as $key=>$dossier_main_oeuvre){
            $groupDossierMainOeuvre[$dossier_main_oeuvre->getMainOeuvre()->getId()][] = $dossier_main_oeuvre;
        }

        return $groupDossierMainOeuvre;
    }

    /**
     * Add dossierFraisPort.
     *
     * @param \App\Entity\DossierFraisPort $dossierFraisPort
     *
     * @return Dossier
     */
    public function addDossierFraisPort(\App\Entity\DossierFraisPort $dossierFraisPort)
    {
        $dossierFraisPort->setDossier($this);
        $this->dossier_frais_port[] = $dossierFraisPort;

        return $this;
    }

    /**
     * Remove dossierFraisPort.
     *
     * @param \App\Entity\DossierFraisPort $dossierFraisPort
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDossierFraisPort(\App\Entity\DossierFraisPort $dossierFraisPort)
    {
        return $this->dossier_frais_port->removeElement($dossierFraisPort);
    }

    /**
     * Get dossierFraisPort.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDossierFraisPort()
    {
        return $this->dossier_frais_port;
    }

    public function getGroupDossierFraisPort()
    {
        $groupDossierFraisPort = array();

        foreach($this->dossier_frais_port as $key=>$dossier_frais_port){
            $groupDossierFraisPort[$dossier_frais_port->getFraisPort()->getId()][] = $dossier_frais_port;
        }

        return $groupDossierFraisPort;
    }



    /**
     * Add dossierFraisCertif.
     *
     * @param \App\Entity\DossierFraisCertif $dossierFraisCertif
     *
     * @return Dossier
     */
    public function addDossierFraisCertif(\App\Entity\DossierFraisCertif $dossierFraisCertif)
    {
        $dossierFraisCertif->setDossier($this);
        $this->dossier_frais_certif[] = $dossierFraisCertif;

        return $this;
    }

    /**
     * Remove dossierFraisPort.
     *
     * @param \App\Entity\DossierFraisCertif $dossierFraisCertif
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDossierFraisCertif(\App\Entity\DossierFraisCertif $dossierFraisCertif)
    {
        return $this->dossier_frais_certif->removeElement($dossierFraisCertif);
    }

    /**
     * Get dossierFraisPort.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDossierFraisCertif()
    {
        return $this->dossier_frais_certif;
    }

    public function getGroupDossierFraisCertif()
    {
        $groupDossierFraisCertif = array();

        foreach($this->dossier_frais_certif as $key=>$dossier_frais_certif){
            $groupDossierFraisCertif[$dossier_frais_certif->getFraisCertif()->getId()][] = $dossier_frais_certif;
        }

        return $groupDossierFraisCertif;
    }

    /**
     * Add dossierArticle.
     *
     * @param \App\Entity\DossierArticle $dossierArticle
     *
     * @return Dossier
     */
    public function addDossierArticle(\App\Entity\DossierArticle $dossierArticle)
    {
        $dossierArticle->setDossier($this);
        $this->dossier_article[] = $dossierArticle;

        return $this;
    }

    /**
     * Remove dossierArticle.
     *
     * @param \App\Entity\DossierArticle $dossierArticle
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDossierArticle(\App\Entity\DossierArticle $dossierArticle)
    {
        return $this->dossier_article->removeElement($dossierArticle);
    }

    /**
     * Get dossierArticle.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDossierArticle()
    {
        return $this->dossier_article;
    }

    /**
     * Add travauxSup.
     *
     * @param \App\Entity\DossierTravauxSup $travauxSup
     *
     * @return Dossier
     */
    public function addTravauxSup(\App\Entity\DossierTravauxSup $travauxSup)
    {
        $travauxSup->setDossier($this);
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
     * Add dossierOutil.
     *
     * @param \App\Entity\DossierOutils $dossierOutil
     *
     * @return Dossier
     */
    public function addDossierOutil(\App\Entity\DossierOutils $dossierOutil)
    {
        $dossierOutil->setDossier($this);
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

    /**
     * Set mecanicien.
     *
     * @param \App\Entity\Mecanicien|null $mecanicien
     *
     * @return Dossier
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
     * Set timeCf.
     *
     * @param string|null $timeCf
     *
     * @return Dossier
     */
    public function setTimeCf($timeCf = null)
    {
        $this->time_cf = $timeCf;

        return $this;
    }

    /**
     * Get timeCf.
     *
     * @return string|null
     */
    public function getTimeCf()
    {
        return $this->time_cf;
    }

    /**
     * Set titre.
     *
     * @param string $titre
     *
     * @return Dossier
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre.
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Add devi.
     *
     * @param \App\Entity\Devis $devi
     *
     * @return Dossier
     */
    public function addDevi(\App\Entity\Devis $devi)
    {
        $this->devis[] = $devi;

        return $this;
    }

    /**
     * Remove devi.
     *
     * @param \App\Entity\Devis $devi
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDevi(\App\Entity\Devis $devi)
    {
        return $this->devis->removeElement($devi);
    }

    /**
     * Get devis.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevis()
    {
        return $this->devis;
    }

    /**
     * Set heureDerniereAprs.
     *
     * @param string $heureDerniereAprs
     *
     * @return Appareil
     */
    public function setHeureDerniereAprs($heureDerniereAprs)
    {
        $this->heure_derniere_aprs = $heureDerniereAprs;

        return $this;
    }

    /**
     * Get heureDerniereAprs.
     *
     * @return string
     */
    public function getHeureDerniereAprs()
    {
        return $this->heure_derniere_aprs;
    }

    /**
     * @return Collection|DossierArticleExterne[]
     */
    public function getDossierArticleExternes(): Collection
    {
        return $this->dossier_article_externes;
    }

    public function addDossierArticleExterne(DossierArticleExterne $dossier_article_externe): self
    {
        if (!$this->dossier_article_externes->contains($dossier_article_externe)) {
            $this->dossier_article_externes[] = $dossier_article_externe;
            $dossier_article_externe->setDossier($this);
        }

        return $this;
    }

    public function removeDossierArticleExterne(DossierArticleExterne $dossier_article_externe): self
    {
        if ($this->dossier_article_externes->contains($dossier_article_externe)) {
            $this->dossier_article_externes->removeElement($dossier_article_externe);
            // set the owning side to null (unless already changed)
            if ($dossier_article_externe->getDossier() === $this) {
                $dossier_article_externe->setDossier(null);
            }
        }

        return $this;
    }

}
