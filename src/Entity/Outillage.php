<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OutillageRepository")
 */
class Outillage
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
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pn;

    /**
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(0)
     */
    private $prix_ht;

    /**
     * @ORM\OneToMany(targetEntity="OutillagePrix", mappedBy="outillage", cascade={"ALL"}, indexBy="date_change")
     * @ORM\OrderBy({"date_change" = "DESC"})
     */
    private $outillage_prix;

    /**
     * @ORM\OneToMany(targetEntity="OutillageCertificat", mappedBy="outillage", cascade={"ALL"}, indexBy="date_validite")
     * @ORM\OrderBy({"date_validite" = "DESC"})
     */
    private $outillage_certificats;

    public function __toString()
    {
        return $this->nom;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->outillage_prix = new \Doctrine\Common\Collections\ArrayCollection();
        $this->outillage_certificats = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Outillage
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
     * Set type.
     *
     * @param int $type
     *
     * @return Outillage
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set sn.
     *
     * @param string $sn
     *
     * @return Outillage
     */
    public function setSn($sn)
    {
        $this->sn = $sn;

        return $this;
    }

    /**
     * Get sn.
     *
     * @return string
     */
    public function getSn()
    {
        return $this->sn;
    }

    /**
     * Set pn.
     *
     * @param string $pn
     *
     * @return Outillage
     */
    public function setPn($pn)
    {
        $this->pn = $pn;

        return $this;
    }

    /**
     * Get pn.
     *
     * @return string
     */
    public function getPn()
    {
        return $this->pn;
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
        return $this->outillage_prix->first();
    }

    public function getPeriodePrix($date){
        $prix_ht = 0;
        foreach($this->outillage_prix as $outillage_prix){
            if($outillage_prix->getDateChange() < $date){
                $prix_ht = $outillage_prix->getPrixHT();
                break;
            }
        }
        return $prix_ht;
    }

    /**
     * Add outillageCertificat.
     *
     * @param \App\Entity\OutillageCertificat $outillageCertificat
     *
     * @return Outillage
     */
    public function addOutillageCertificat(\App\Entity\OutillageCertificat $outillageCertificat)
    {
        $this->outillage_certificats[] = $outillageCertificat;

        return $this;
    }

    /**
     * Remove outillageCertificat.
     *
     * @param \App\Entity\OutillageCertificat $outillageCertificat
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeOutillageCertificat(\App\Entity\OutillageCertificat $outillageCertificat)
    {
        return $this->outillage_certificats->removeElement($outillageCertificat);
    }

    /**
     * Get outillageCertificats.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOutillageCertificats()
    {
        return $this->outillage_certificats;
    }

    public function getLastDateCertificat(){
        return $this->outillage_certificats->first();
    }

    /**
     * Add outillagePrix.
     *
     * @param \App\Entity\OutillagePrix $outillagePrix
     *
     * @return Outillage
     */
    public function addOutillagePrix(\App\Entity\OutillagePrix $outillagePrix)
    {
        $this->outillage_prix[] = $outillagePrix;

        return $this;
    }

    /**
     * Remove outillagePrix.
     *
     * @param \App\Entity\OutillagePrix $outillagePrix
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeOutillagePrix(\App\Entity\OutillagePrix $outillagePrix)
    {
        return $this->outillage_prix->removeElement($outillagePrix);
    }

    /**
     * Get outillagePrix.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOutillagePrix()
    {
        return $this->outillage_prix;
    }
}
