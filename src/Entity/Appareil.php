<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AppareilRepository")
 */
class Appareil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="appareils")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $immatriculation;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThanOrEqual(0)
     */
    private $heure_derniere_aprs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque_cellule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model_cellule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $num_serie_cellule;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_rg_cellule;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $ht_cellule;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $hrg_cellule;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque_moteur1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model_moteur1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $num_serie_moteur1;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_rg_moteur1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $ht_moteur1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $hrg_moteur1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $marque_moteur2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $model_moteur2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $num_serie_moteur2;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_rg_moteur2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $ht_moteur2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $hrg_moteur2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque_helice1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $model_helice1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $num_serie_helice1;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_rg_helice1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $ht_helice1;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $hrg_helice1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $marque_helice2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $model_helice2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $num_serie_helice2;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_rg_helice2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $ht_helice2;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $hrg_helice2;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_responsable_vol;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom_responsable_vol;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email_responsable_vol;

    /**
     * @ORM\OneToMany(targetEntity="ProgrammeEntretien", mappedBy="appareil", cascade={"ALL"}, indexBy="date")
     * @ORM\OrderBy({"date" = "DESC"})
     */
    private $appareil_pe;

    /**
     * @ORM\OneToMany(targetEntity="AmmCellule", mappedBy="appareil", cascade={"ALL"}, indexBy="date")
     * @ORM\OrderBy({"date" = "DESC"})
     */
    private $appareil_amm_cellule;

    /**
     * @ORM\OneToMany(targetEntity="AmmMoteur", mappedBy="appareil", cascade={"ALL"}, indexBy="date")
     * @ORM\OrderBy({"date" = "DESC"})
     */
    private $appareil_amm_moteur;

    /**
     * @ORM\OneToMany(targetEntity="Dossier", mappedBy="appareil", cascade={"ALL"}, indexBy="date_creation")
     * @ORM\OrderBy({"date_creation" = "DESC"})
     */
    private $appareil_dossier;

    public function __toString()
    {
        return $this->immatriculation;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->appareil_pe = new \Doctrine\Common\Collections\ArrayCollection();
        $this->appareil_amm_cellule = new \Doctrine\Common\Collections\ArrayCollection();
        $this->appareil_amm_moteur = new \Doctrine\Common\Collections\ArrayCollection();
        $this->appareil_dossier = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set immatriculation.
     *
     * @param string $immatriculation
     *
     * @return Appareil
     */
    public function setImmatriculation($immatriculation)
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    /**
     * Get immatriculation.
     *
     * @return string
     */
    public function getImmatriculation()
    {
        return $this->immatriculation;
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
     * Set marqueCellule.
     *
     * @param string $marqueCellule
     *
     * @return Appareil
     */
    public function setMarqueCellule($marqueCellule)
    {
        $this->marque_cellule = $marqueCellule;

        return $this;
    }

    /**
     * Get marqueCellule.
     *
     * @return string
     */
    public function getMarqueCellule()
    {
        return $this->marque_cellule;
    }

    /**
     * Set modelCellule.
     *
     * @param string $modelCellule
     *
     * @return Appareil
     */
    public function setModelCellule($modelCellule)
    {
        $this->model_cellule = $modelCellule;

        return $this;
    }

    /**
     * Get modelCellule.
     *
     * @return string
     */
    public function getModelCellule()
    {
        return $this->model_cellule;
    }

    /**
     * Set numSerieCellule.
     *
     * @param string $numSerieCellule
     *
     * @return Appareil
     */
    public function setNumSerieCellule($numSerieCellule)
    {
        $this->num_serie_cellule = $numSerieCellule;

        return $this;
    }

    /**
     * Get numSerieCellule.
     *
     * @return string
     */
    public function getNumSerieCellule()
    {
        return $this->num_serie_cellule;
    }

    /**
     * Set dateRgCellule.
     *
     * @param \DateTime|null $dateRgCellule
     *
     * @return Appareil
     */
    public function setDateRgCellule($dateRgCellule = null)
    {
        $this->date_rg_cellule = $dateRgCellule;

        return $this;
    }

    /**
     * Get dateRgCellule.
     *
     * @return \DateTime|null
     */
    public function getDateRgCellule()
    {
        return $this->date_rg_cellule;
    }

    /**
     * Set htCellule.
     *
     * @param int|null $htCellule
     *
     * @return Appareil
     */
    public function setHtCellule($htCellule = null)
    {
        $this->ht_cellule = $htCellule;

        return $this;
    }

    /**
     * Get htCellule.
     *
     * @return int|null
     */
    public function getHtCellule()
    {
        return $this->ht_cellule;
    }

    /**
     * Set hrgCellule.
     *
     * @param int|null $hrgCellule
     *
     * @return Appareil
     */
    public function setHrgCellule($hrgCellule = null)
    {
        $this->hrg_cellule = $hrgCellule;

        return $this;
    }

    /**
     * Get hrgCellule.
     *
     * @return int|null
     */
    public function getHrgCellule()
    {
        return $this->hrg_cellule;
    }

    /**
     * Set marqueMoteur1.
     *
     * @param string $marqueMoteur1
     *
     * @return Appareil
     */
    public function setMarqueMoteur1($marqueMoteur1)
    {
        $this->marque_moteur1 = $marqueMoteur1;

        return $this;
    }

    /**
     * Get marqueMoteur1.
     *
     * @return string
     */
    public function getMarqueMoteur1()
    {
        return $this->marque_moteur1;
    }

    /**
     * Set modelMoteur1.
     *
     * @param string $modelMoteur1
     *
     * @return Appareil
     */
    public function setModelMoteur1($modelMoteur1)
    {
        $this->model_moteur1 = $modelMoteur1;

        return $this;
    }

    /**
     * Get modelMoteur1.
     *
     * @return string
     */
    public function getModelMoteur1()
    {
        return $this->model_moteur1;
    }

    /**
     * Set numSerieMoteur1.
     *
     * @param string $numSerieMoteur1
     *
     * @return Appareil
     */
    public function setNumSerieMoteur1($numSerieMoteur1)
    {
        $this->num_serie_moteur1 = $numSerieMoteur1;

        return $this;
    }

    /**
     * Get numSerieMoteur1.
     *
     * @return string
     */
    public function getNumSerieMoteur1()
    {
        return $this->num_serie_moteur1;
    }

    /**
     * Set dateRgMoteur1.
     *
     * @param \DateTime|null $dateRgMoteur1
     *
     * @return Appareil
     */
    public function setDateRgMoteur1($dateRgMoteur1 = null)
    {
        $this->date_rg_moteur1 = $dateRgMoteur1;

        return $this;
    }

    /**
     * Get dateRgMoteur1.
     *
     * @return \DateTime|null
     */
    public function getDateRgMoteur1()
    {
        return $this->date_rg_moteur1;
    }

    /**
     * Set htMoteur1.
     *
     * @param int|null $htMoteur1
     *
     * @return Appareil
     */
    public function setHtMoteur1($htMoteur1 = null)
    {
        $this->ht_moteur1 = $htMoteur1;

        return $this;
    }

    /**
     * Get htMoteur1.
     *
     * @return int|null
     */
    public function getHtMoteur1()
    {
        return $this->ht_moteur1;
    }

    /**
     * Set hrgMoteur1.
     *
     * @param int|null $hrgMoteur1
     *
     * @return Appareil
     */
    public function setHrgMoteur1($hrgMoteur1 = null)
    {
        $this->hrg_moteur1 = $hrgMoteur1;

        return $this;
    }

    /**
     * Get hrgMoteur1.
     *
     * @return int|null
     */
    public function getHrgMoteur1()
    {
        return $this->hrg_moteur1;
    }

    /**
     * Set marqueMoteur2.
     *
     * @param string|null $marqueMoteur2
     *
     * @return Appareil
     */
    public function setMarqueMoteur2($marqueMoteur2 = null)
    {
        $this->marque_moteur2 = $marqueMoteur2;

        return $this;
    }

    /**
     * Get marqueMoteur2.
     *
     * @return string|null
     */
    public function getMarqueMoteur2()
    {
        return $this->marque_moteur2;
    }

    /**
     * Set modelMoteur2.
     *
     * @param string|null $modelMoteur2
     *
     * @return Appareil
     */
    public function setModelMoteur2($modelMoteur2 = null)
    {
        $this->model_moteur2 = $modelMoteur2;

        return $this;
    }

    /**
     * Get modelMoteur2.
     *
     * @return string|null
     */
    public function getModelMoteur2()
    {
        return $this->model_moteur2;
    }

    /**
     * Set numSerieMoteur2.
     *
     * @param string|null $numSerieMoteur2
     *
     * @return Appareil
     */
    public function setNumSerieMoteur2($numSerieMoteur2 = null)
    {
        $this->num_serie_moteur2 = $numSerieMoteur2;

        return $this;
    }

    /**
     * Get numSerieMoteur2.
     *
     * @return string|null
     */
    public function getNumSerieMoteur2()
    {
        return $this->num_serie_moteur2;
    }

    /**
     * Set dateRgMoteur2.
     *
     * @param \DateTime|null $dateRgMoteur2
     *
     * @return Appareil
     */
    public function setDateRgMoteur2($dateRgMoteur2 = null)
    {
        $this->date_rg_moteur2 = $dateRgMoteur2;

        return $this;
    }

    /**
     * Get dateRgMoteur2.
     *
     * @return \DateTime|null
     */
    public function getDateRgMoteur2()
    {
        return $this->date_rg_moteur2;
    }

    /**
     * Set htMoteur2.
     *
     * @param int|null $htMoteur2
     *
     * @return Appareil
     */
    public function setHtMoteur2($htMoteur2 = null)
    {
        $this->ht_moteur2 = $htMoteur2;

        return $this;
    }

    /**
     * Get htMoteur2.
     *
     * @return int|null
     */
    public function getHtMoteur2()
    {
        return $this->ht_moteur2;
    }

    /**
     * Set hrgMoteur2.
     *
     * @param int|null $hrgMoteur2
     *
     * @return Appareil
     */
    public function setHrgMoteur2($hrgMoteur2 = null)
    {
        $this->hrg_moteur2 = $hrgMoteur2;

        return $this;
    }

    /**
     * Get hrgMoteur2.
     *
     * @return int|null
     */
    public function getHrgMoteur2()
    {
        return $this->hrg_moteur2;
    }

    /**
     * Set marqueHelice1.
     *
     * @param string $marqueHelice1
     *
     * @return Appareil
     */
    public function setMarqueHelice1($marqueHelice1)
    {
        $this->marque_helice1 = $marqueHelice1;

        return $this;
    }

    /**
     * Get marqueHelice1.
     *
     * @return string
     */
    public function getMarqueHelice1()
    {
        return $this->marque_helice1;
    }

    /**
     * Set modelHelice1.
     *
     * @param string $modelHelice1
     *
     * @return Appareil
     */
    public function setModelHelice1($modelHelice1)
    {
        $this->model_helice1 = $modelHelice1;

        return $this;
    }

    /**
     * Get modelHelice1.
     *
     * @return string
     */
    public function getModelHelice1()
    {
        return $this->model_helice1;
    }

    /**
     * Set numSerieHelice1.
     *
     * @param string $numSerieHelice1
     *
     * @return Appareil
     */
    public function setNumSerieHelice1($numSerieHelice1)
    {
        $this->num_serie_helice1 = $numSerieHelice1;

        return $this;
    }

    /**
     * Get numSerieHelice1.
     *
     * @return string
     */
    public function getNumSerieHelice1()
    {
        return $this->num_serie_helice1;
    }

    /**
     * Set dateRgHelice1.
     *
     * @param \DateTime|null $dateRgHelice1
     *
     * @return Appareil
     */
    public function setDateRgHelice1($dateRgHelice1 = null)
    {
        $this->date_rg_helice1 = $dateRgHelice1;

        return $this;
    }

    /**
     * Get dateRgHelice1.
     *
     * @return \DateTime|null
     */
    public function getDateRgHelice1()
    {
        return $this->date_rg_helice1;
    }

    /**
     * Set htHelice1.
     *
     * @param int|null $htHelice1
     *
     * @return Appareil
     */
    public function setHtHelice1($htHelice1 = null)
    {
        $this->ht_helice1 = $htHelice1;

        return $this;
    }

    /**
     * Get htHelice1.
     *
     * @return int|null
     */
    public function getHtHelice1()
    {
        return $this->ht_helice1;
    }

    /**
     * Set hrgHelice1.
     *
     * @param int|null $hrgHelice1
     *
     * @return Appareil
     */
    public function setHrgHelice1($hrgHelice1 = null)
    {
        $this->hrg_helice1 = $hrgHelice1;

        return $this;
    }

    /**
     * Get hrgHelice1.
     *
     * @return int|null
     */
    public function getHrgHelice1()
    {
        return $this->hrg_helice1;
    }

    /**
     * Set marqueHelice2.
     *
     * @param string|null $marqueHelice2
     *
     * @return Appareil
     */
    public function setMarqueHelice2($marqueHelice2 = null)
    {
        $this->marque_helice2 = $marqueHelice2;

        return $this;
    }

    /**
     * Get marqueHelice2.
     *
     * @return string|null
     */
    public function getMarqueHelice2()
    {
        return $this->marque_helice2;
    }

    /**
     * Set modelHelice2.
     *
     * @param string|null $modelHelice2
     *
     * @return Appareil
     */
    public function setModelHelice2($modelHelice2 = null)
    {
        $this->model_helice2 = $modelHelice2;

        return $this;
    }

    /**
     * Get modelHelice2.
     *
     * @return string|null
     */
    public function getModelHelice2()
    {
        return $this->model_helice2;
    }

    /**
     * Set numSerieHelice2.
     *
     * @param string|null $numSerieHelice2
     *
     * @return Appareil
     */
    public function setNumSerieHelice2($numSerieHelice2 = null)
    {
        $this->num_serie_helice2 = $numSerieHelice2;

        return $this;
    }

    /**
     * Get numSerieHelice2.
     *
     * @return string|null
     */
    public function getNumSerieHelice2()
    {
        return $this->num_serie_helice2;
    }

    /**
     * Set dateRgHelice2.
     *
     * @param \DateTime|null $dateRgHelice2
     *
     * @return Appareil
     */
    public function setDateRgHelice2($dateRgHelice2 = null)
    {
        $this->date_rg_helice2 = $dateRgHelice2;

        return $this;
    }

    /**
     * Get dateRgHelice2.
     *
     * @return \DateTime|null
     */
    public function getDateRgHelice2()
    {
        return $this->date_rg_helice2;
    }

    /**
     * Set htHelice2.
     *
     * @param int|null $htHelice2
     *
     * @return Appareil
     */
    public function setHtHelice2($htHelice2 = null)
    {
        $this->ht_helice2 = $htHelice2;

        return $this;
    }

    /**
     * Get htHelice2.
     *
     * @return int|null
     */
    public function getHtHelice2()
    {
        return $this->ht_helice2;
    }

    /**
     * Set hrgHelice2.
     *
     * @param int|null $hrgHelice2
     *
     * @return Appareil
     */
    public function setHrgHelice2($hrgHelice2 = null)
    {
        $this->hrg_helice2 = $hrgHelice2;

        return $this;
    }

    /**
     * Get hrgHelice2.
     *
     * @return int|null
     */
    public function getHrgHelice2()
    {
        return $this->hrg_helice2;
    }

    /**
     * Set nomResponsableVol.
     *
     * @param string $nomResponsableVol
     *
     * @return Appareil
     */
    public function setNomResponsableVol($nomResponsableVol)
    {
        $this->nom_responsable_vol = $nomResponsableVol;

        return $this;
    }

    /**
     * Get nomResponsableVol.
     *
     * @return string
     */
    public function getNomResponsableVol()
    {
        return $this->nom_responsable_vol;
    }

    /**
     * Set prenomResponsableVol.
     *
     * @param string $prenomResponsableVol
     *
     * @return Appareil
     */
    public function setPrenomResponsableVol($prenomResponsableVol)
    {
        $this->prenom_responsable_vol = $prenomResponsableVol;

        return $this;
    }

    /**
     * Get prenomResponsableVol.
     *
     * @return string
     */
    public function getPrenomResponsableVol()
    {
        return $this->prenom_responsable_vol;
    }

    /**
     * Set emailResponsableVol.
     *
     * @param string $emailResponsableVol
     *
     * @return Appareil
     */
    public function setEmailResponsableVol($emailResponsableVol)
    {
        $this->email_responsable_vol = $emailResponsableVol;

        return $this;
    }

    /**
     * Get emailResponsableVol.
     *
     * @return string
     */
    public function getEmailResponsableVol()
    {
        return $this->email_responsable_vol;
    }

    /**
     * Set client.
     *
     * @param \App\Entity\Client|null $client
     *
     * @return Appareil
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

    public function getNomClient()
    {
        return $this->client->getNom()." ".$this->client->getPrenom();
    }

    public function getResponsableVol()
    {
        return $this->nom_responsable_vol." ".$this->prenom_responsable_vol." ( ".$this->email_responsable_vol." )";
    }

    public function getTableHead()
    {
        return "";
    }

    /**
     * Add appareilPe.
     *
     * @param \App\Entity\ProgrammeEntretien $appareilPe
     *
     * @return Appareil
     */
    public function addAppareilPe(\App\Entity\ProgrammeEntretien $appareilPe)
    {
        $this->appareil_pe[] = $appareilPe;

        return $this;
    }

    /**
     * Remove appareilPe.
     *
     * @param \App\Entity\ProgrammeEntretien $appareilPe
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAppareilPe(\App\Entity\ProgrammeEntretien $appareilPe)
    {
        return $this->appareil_pe->removeElement($appareilPe);
    }

    /**
     * Get appareilPe.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAppareilPe()
    {
        return $this->appareil_pe;
    }

    /**
     * Add appareilAmmCellule.
     *
     * @param \App\Entity\AmmCellule $appareilAmmCellule
     *
     * @return Appareil
     */
    public function addAppareilAmmCellule(\App\Entity\AmmCellule $appareilAmmCellule)
    {
        $this->appareil_amm_cellule[] = $appareilAmmCellule;

        return $this;
    }

    /**
     * Remove appareilAmmCellule.
     *
     * @param \App\Entity\AmmCellule $appareilAmmCellule
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAppareilAmmCellule(\App\Entity\AmmCellule $appareilAmmCellule)
    {
        return $this->appareil_amm_cellule->removeElement($appareilAmmCellule);
    }

    /**
     * Get appareilAmmCellule.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAppareilAmmCellule()
    {
        return $this->appareil_amm_cellule;
    }

    /**
     * Add appareilAmmMoteur.
     *
     * @param \App\Entity\AmmMoteur $appareilAmmMoteur
     *
     * @return Appareil
     */
    public function addAppareilAmmMoteur(\App\Entity\AmmMoteur $appareilAmmMoteur)
    {
        $this->appareil_amm_moteur[] = $appareilAmmMoteur;

        return $this;
    }

    /**
     * Remove appareilAmmMoteur.
     *
     * @param \App\Entity\AmmMoteur $appareilAmmMoteur
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAppareilAmmMoteur(\App\Entity\AmmMoteur $appareilAmmMoteur)
    {
        return $this->appareil_amm_moteur->removeElement($appareilAmmMoteur);
    }

    /**
     * Get appareilAmmMoteur.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAppareilAmmMoteur()
    {
        return $this->appareil_amm_moteur;
    }

    /**
     * Add appareilDossier.
     *
     * @param \App\Entity\Dossier $appareilDossier
     *
     * @return Appareil
     */
    public function addAppareilDossier(\App\Entity\Dossier $appareilDossier)
    {
        $this->appareil_dossier[] = $appareilDossier;

        return $this;
    }

    /**
     * Remove appareilDossier.
     *
     * @param \App\Entity\Dossier $appareilDossier
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAppareilDossier(\App\Entity\Dossier $appareilDossier)
    {
        return $this->appareil_dossier->removeElement($appareilDossier);
    }

    /**
     * Get appareilDossier.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAppareilDossier()
    {
        return $this->appareil_dossier;
    }
}
