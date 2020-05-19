<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PeripheriqueRepository")
 */
class Peripherique
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="peripherique_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $adresse_mac;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $p_type;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $p_os;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $p_brand;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $p_useragent;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $p_lang;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $p_browser;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="peripheriques")
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SessionWifi", mappedBy="peripherique")
     */
    private $sessionWifis;

    public function __construct()
    {
        $this->sessionWifis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresseMac(): ?string
    {
        return $this->adresse_mac;
    }

    public function setAdresseMac(string $adresse_mac): self
    {
        $this->adresse_mac = $adresse_mac;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPType(): ?string
    {
        return $this->p_type;
    }

    public function setPType(string $p_type): self
    {
        $this->p_type = $p_type;

        return $this;
    }

    public function getPOs(): ?string
    {
        return $this->p_os;
    }

    public function setPOs(string $p_os): self
    {
        $this->p_os = $p_os;

        return $this;
    }

    public function getPBrand(): ?string
    {
        return $this->p_brand;
    }

    public function setPBrand(string $p_brand): self
    {
        $this->p_brand = $p_brand;

        return $this;
    }

    public function getPUseragent(): ?string
    {
        return $this->p_useragent;
    }

    public function setPUseragent(string $p_useragent): self
    {
        $this->p_useragent = $p_useragent;

        return $this;
    }

    public function getPLang(): ?string
    {
        return $this->p_lang;
    }

    public function setPLang(string $p_lang): self
    {
        $this->p_lang = $p_lang;

        return $this;
    }

    public function getPBrowser(): ?string
    {
        return $this->p_browser;
    }

    public function setPBrowser(string $p_browser): self
    {
        $this->p_browser = $p_browser;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection|SessionWifi[]
     */
    public function getSessionWifis(): Collection
    {
        return $this->sessionWifis;
    }

    public function addSessionWifi(SessionWifi $sessionWifi): self
    {
        if (!$this->sessionWifis->contains($sessionWifi)) {
            $this->sessionWifis[] = $sessionWifi;
            $sessionWifi->setPeripherique($this);
        }

        return $this;
    }

    public function removeSessionWifi(SessionWifi $sessionWifi): self
    {
        if ($this->sessionWifis->contains($sessionWifi)) {
            $this->sessionWifis->removeElement($sessionWifi);
            // set the owning side to null (unless already changed)
            if ($sessionWifi->getPeripherique() === $this) {
                $sessionWifi->setPeripherique(null);
            }
        }

        return $this;
    }
}
