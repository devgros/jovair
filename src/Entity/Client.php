<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
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
    private $entreprise;

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
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Appareil", mappedBy="client")
     */
    private $appareils;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Devis", mappedBy="client")
     */
    private $devis;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Facture", mappedBy="client")
     */
    private $facture;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Todo", mappedBy="client")
     */
    private $todos;

    public function __construct()
    {
        $this->appareils = new ArrayCollection();
        $this->devis = new ArrayCollection();
        $this->todos = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->entreprise." - ".$this->nom." ".$this->prenom;
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
     * Set entreprise.
     *
     * @param string $entreprise
     *
     * @return Client
     */
    public function setEntreprise($entreprise)
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    /**
     * Get entreprise.
     *
     * @return string
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return Client
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
     * @return Client
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
     * Set email.
     *
     * @param string $email
     *
     * @return Client
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set tel.
     *
     * @param int $tel
     *
     * @return Client
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel.
     *
     * @return int
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set adresse.
     *
     * @param string $adresse
     *
     * @return Client
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse.
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set cp.
     *
     * @param int $cp
     *
     * @return Client
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp.
     *
     * @return int
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set ville.
     *
     * @param string $ville
     *
     * @return Client
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville.
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Add appareil.
     *
     * @param \App\Entity\Appareil $appareil
     *
     * @return Client
     */
    public function addAppareil(\App\Entity\Appareil $appareil)
    {
        $this->appareils[] = $appareil;

        return $this;
    }

    /**
     * Remove appareil.
     *
     * @param \App\Entity\Appareil $appareil
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeAppareil(\App\Entity\Appareil $appareil)
    {
        return $this->appareils->removeElement($appareil);
    }

    /**
     * Get appareils.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAppareils()
    {
        return $this->appareils;
    }

    public function getAdresseComplete()
    {
        return $this->adresse." ".$this->cp." ".$this->ville;
    }

    /**
     * Add devis.
     *
     * @param \App\Entity\Devis $devis
     *
     * @return Client
     */
    /*public function addDevis(\App\Entity\Devis $devis)
    {
        $this->devis[] = $devis;

        return $this;
    }*/

    /**
     * Remove devis.
     *
     * @param \App\Entity\Devis $devis
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    /*public function removeDevis(\App\Entity\Devis $devis)
    {
        return $this->devis->removeElement($devis);
    }*/

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
     * Add devi.
     *
     * @param \App\Entity\Devis $devi
     *
     * @return Client
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
     * Add facture.
     *
     * @param \App\Entity\Facture $facture
     *
     * @return Client
     */
    public function addFacture(\App\Entity\Facture $facture)
    {
        $this->facture[] = $facture;

        return $this;
    }

    /**
     * Remove facture.
     *
     * @param \App\Entity\Facture $facture
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeFacture(\App\Entity\Facture $facture)
    {
        return $this->facture->removeElement($facture);
    }

    /**
     * Get facture.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Add todo.
     *
     * @param \App\Entity\Todo $todo
     *
     * @return Client
     */
    public function addTodo(\App\Entity\Todo $todo)
    {
        $this->todos[] = $todo;

        return $this;
    }

    /**
     * Remove todo.
     *
     * @param \App\Entity\Todo $todo
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTodo(\App\Entity\Todo $todo)
    {
        return $this->todos->removeElement($todo);
    }

    /**
     * Get todos.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTodos()
    {
        return $this->todos;
    }
}
