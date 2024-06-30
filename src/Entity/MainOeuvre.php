<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MainOeuvreRepository")
 */
class MainOeuvre
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
     * @ORM\OneToMany(targetEntity="MainOeuvrePrix", mappedBy="main_oeuvre", cascade={"ALL"}, indexBy="date_change")
     * @ORM\OrderBy({"date_change" = "DESC"})
     */
    private $main_oeuvre_prix;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(0)
     */
    private $prix_ht;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $deleted = 0;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $deletedAt;

    /**
     * @ORM\OneToMany(targetEntity="DossierMainOeuvre", mappedBy="main_oeuvre", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $dossier_main_oeuvre;

    /**
     * @ORM\OneToMany(targetEntity="DevisMainOeuvre", mappedBy="main_oeuvre", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $devis_main_oeuvre;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->main_oeuvre_prix = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dossier_main_oeuvre = new \Doctrine\Common\Collections\ArrayCollection();
        $this->devis_main_oeuvre = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom;
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
     * @return MainOeuvre
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
     * Add mainOeuvrePrix.
     *
     * @param \App\Entity\MainOeuvrePrix $mainOeuvrePrix
     *
     * @return MainOeuvre
     */
    public function addMainOeuvrePrix(\App\Entity\MainOeuvrePrix $mainOeuvrePrix)
    {
        $this->main_oeuvre_prix[] = $mainOeuvrePrix;

        return $this;
    }

    /**
     * Remove mainOeuvrePrix.
     *
     * @param \App\Entity\MainOeuvrePrix $mainOeuvrePrix
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMainOeuvrePrix(\App\Entity\MainOeuvrePrix $mainOeuvrePrix)
    {
        return $this->main_oeuvre_prix->removeElement($mainOeuvrePrix);
    }

    /**
     * Get mainOeuvrePrix.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMainOeuvrePrix()
    {
        return $this->main_oeuvre_prix;
    }

    /**
     * Set prixHt.
     *
     * @param string $prixHt
     *
     * @return ArticlePrix
     */
    public function setPrixHt($prixHt)
    {
        $this->prix_ht = $prixHt;

        return $this;
    }

    /**
     * Get prixHt.
     *
     * @return string
     */
    public function getPrixHt()
    {
        return $this->prix_ht;
    }

    public function getLastPrix(){
    	return $this->main_oeuvre_prix->first();
    }

    public function getPeriodePrix($date){
        $prix_ht = 0;
        foreach($this->main_oeuvre_prix as $main_oeuvre_prix){
            if($main_oeuvre_prix->getDateChange() < $date){
                $prix_ht = $main_oeuvre_prix->getPrixHT();
                break;
            }
        }
        if($prix_ht == 0){
            $main_oeuvre_prix = $this->main_oeuvre_prix->last();
            $prix_ht = $main_oeuvre_prix->getPrixHT();
        }
        return $prix_ht;
    }

    /**
     * Add dossierMainOeuvre.
     *
     * @param \App\Entity\DossierMainOeuvre $dossierMainOeuvre
     *
     * @return MainOeuvre
     */
    public function addDossierMainOeuvre(\App\Entity\DossierMainOeuvre $dossierMainOeuvre)
    {
        $dossierMainOeuvre->setMainOeuvre($this);
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

    /**
     * Add devisMainOeuvre.
     *
     * @param \App\Entity\DevisMainOeuvre $devisMainOeuvre
     *
     * @return MainOeuvre
     */
    public function addDevisMainOeuvre(\App\Entity\DevisMainOeuvre $devisMainOeuvre)
    {
        $devisMainOeuvre->setMainOeuvre($this);
        $this->devis_main_oeuvre[] = $devisMainOeuvre;

        return $this;
    }

    /**
     * Remove devisMainOeuvre.
     *
     * @param \App\Entity\DevisMainOeuvre $devisMainOeuvre
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeDevisMainOeuvre(\App\Entity\DevisMainOeuvre $devisMainOeuvre)
    {
        return $this->devis_main_oeuvre->removeElement($devisMainOeuvre);
    }

    /**
     * Get devisMainOeuvre.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevisMainOeuvre()
    {
        return $this->devis_main_oeuvre;
    }

    /**
     * Set deleted.
     *
     * @param int $deleted
     *
     * @return MainOeuvre
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted.
     *
     * @return int
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set deletedAt.
     *
     * @param \DateTime $deletedAt
     *
     * @return MainOeuvre
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt.
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}
