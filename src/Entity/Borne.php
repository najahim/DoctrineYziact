<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BorneRepository")
 */
class Borne
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="borne_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $adresse_mac;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $hostname;

    /**
     * @ORM\Column(type="datetime")
     */
    private $derniere_emission;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ssid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prog_wifi;

    /**
     * @ORM\Column(type="integer")
     */
    private $channel;

    /**
     * @ORM\Column(type="boolean")
     */
    private $affichage_map;

    /**
     * @ORM\Column(type="boolean")
     */
    private $partage_stats;

    /**
     * @ORM\Column(type="integer")
     */
    private $quota_user_duree;

    /**
     * @ORM\Column(type="integer")
     */
    private $quota_user_max_bytes;

    /**
     * @ORM\Column(type="boolean")
     */
    private $filtrage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $portail_url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $upload_rate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $download_rate;

    /**
     * @ORM\Column(type="integer")
     */
    private $txpower;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ip_adress_vpn_admin;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_mise_en_service;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_expiration_test;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $commentaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ModeleBorne", inversedBy="bornes")
     */
    private $modeleborne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etat", inversedBy="bornes")
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Serveur", inversedBy="bornes")
     */
    private $serveur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contact", inversedBy="bornes")
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Emplacement", inversedBy="bornes")
     */
    private $emplacement;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Desactivation", mappedBy="borne")
     */
    private $desactivations;

    /**
     * @ORM\ManyToMany(targetEntity="Flotte", inversedBy="bornes")
     * @ORM\JoinTable(name="bornes_flottes")
     */
    private $flottes;


    /**
     * @ORM\ManyToMany(targetEntity="Nouveaute", inversedBy="bornes")
     * @ORM\JoinTable(name="bornes_nouveautes")
     */
    private $nouveautes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SessionWifi", mappedBy="borne")
     */
    private $sessionWifis;

    /**
     * @return mixed
     */
    public function getNouveautes()
    {
        return $this->nouveautes;
    }

    /**
     * @param mixed $nouveautes
     */
    public function setNouveautes($nouveautes): void
    {
        $this->nouveautes = $nouveautes;
    }

    /**
     * @return mixed
     */
    public function getFlottes()
    {
        return $this->flottes;
    }

    /**
     * @param mixed $flottes
     */
    public function setFlottes($flottes): void
    {
        $this->flottes = $flottes;
    }



    public function __construct()
    {
        $this->desactivations = new ArrayCollection();
        $this->flottes = new ArrayCollection();
        $this->nouveautes = new ArrayCollection();
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

    public function getHostname(): ?string
    {
        return $this->hostname;
    }

    public function setHostname(string $hostname): self
    {
        $this->hostname = $hostname;

        return $this;
    }

    public function getDerniereEmission(): ?\DateTimeInterface
    {
        return $this->derniere_emission;
    }

    public function setDerniereEmission(\DateTimeInterface $derniere_emission): self
    {
        $this->derniere_emission = $derniere_emission;

        return $this;
    }

    public function getSsid(): ?string
    {
        return $this->ssid;
    }

    public function setSsid(string $ssid): self
    {
        $this->ssid = $ssid;

        return $this;
    }

    public function getProgWifi(): ?string
    {
        return $this->Prog_wifi;
    }

    public function setProgWifi(string $Prog_wifi): self
    {
        $this->Prog_wifi = $Prog_wifi;

        return $this;
    }

    public function getChannel(): ?int
    {
        return $this->channel;
    }

    public function setChannel(int $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function getAffichageMap(): ?bool
    {
        return $this->affichage_map;
    }

    public function setAffichageMap(bool $affichage_map): self
    {
        $this->affichage_map = $affichage_map;

        return $this;
    }

    public function getPartageStats(): ?bool
    {
        return $this->partage_stats;
    }

    public function setPartageStats(bool $partage_stats): self
    {
        $this->partage_stats = $partage_stats;

        return $this;
    }

    public function getQuotaUserDuree(): ?int
    {
        return $this->quota_user_duree;
    }

    public function setQuotaUserDuree(int $quota_user_duree): self
    {
        $this->quota_user_duree = $quota_user_duree;

        return $this;
    }

    public function getQuotaUserMaxBytes(): ?int
    {
        return $this->quota_user_max_bytes;
    }

    public function setQuotaUserMaxBytes(int $quota_user_max_bytes): self
    {
        $this->quota_user_max_bytes = $quota_user_max_bytes;

        return $this;
    }

    public function getFiltrage(): ?bool
    {
        return $this->filtrage;
    }

    public function setFiltrage(bool $filtrage): self
    {
        $this->filtrage = $filtrage;

        return $this;
    }

    public function getPortailUrl(): ?string
    {
        return $this->portail_url;
    }

    public function setPortailUrl(string $portail_url): self
    {
        $this->portail_url = $portail_url;

        return $this;
    }

    public function getUploadRate(): ?string
    {
        return $this->upload_rate;
    }

    public function setUploadRate(string $upload_rate): self
    {
        $this->upload_rate = $upload_rate;

        return $this;
    }

    public function getDownloadRate(): ?string
    {
        return $this->download_rate;
    }

    public function setDownloadRate(string $download_rate): self
    {
        $this->download_rate = $download_rate;

        return $this;
    }

    public function getTxpower(): ?int
    {
        return $this->txpower;
    }

    public function setTxpower(int $txpower): self
    {
        $this->txpower = $txpower;

        return $this;
    }

    public function getIpAdressVpnAdmin(): ?string
    {
        return $this->ip_adress_vpn_admin;
    }

    public function setIpAdressVpnAdmin(string $ip_adress_vpn_admin): self
    {
        $this->ip_adress_vpn_admin = $ip_adress_vpn_admin;

        return $this;
    }

    public function getDateMiseEnService(): ?\DateTimeInterface
    {
        return $this->date_mise_en_service;
    }

    public function setDateMiseEnService(\DateTimeInterface $date_mise_en_service): self
    {
        $this->date_mise_en_service = $date_mise_en_service;

        return $this;
    }

    public function getDateExpirationTest(): ?\DateTimeInterface
    {
        return $this->date_expiration_test;
    }

    public function setDateExpirationTest(\DateTimeInterface $date_expiration_test): self
    {
        $this->date_expiration_test = $date_expiration_test;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getModeleborne(): ?ModeleBorne
    {
        return $this->modeleborne;
    }

    public function setModeleborne(?ModeleBorne $modeleborne): self
    {
        $this->modeleborne = $modeleborne;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getServeur(): ?Serveur
    {
        return $this->serveur;
    }

    public function setServeur(?Serveur $serveur): self
    {
        $this->serveur = $serveur;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getEmplacement(): ?Emplacement
    {
        return $this->emplacement;
    }

    public function setEmplacement(?Emplacement $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    /**
     * @return Collection|Desactivation[]
     */
    public function getDesactivations(): Collection
    {
        return $this->desactivations;
    }

    public function addDesactivation(Desactivation $desactivation): self
    {
        if (!$this->desactivations->contains($desactivation)) {
            $this->desactivations[] = $desactivation;
            $desactivation->setBorne($this);
        }

        return $this;
    }

    public function removeDesactivation(Desactivation $desactivation): self
    {
        if ($this->desactivations->contains($desactivation)) {
            $this->desactivations->removeElement($desactivation);
            // set the owning side to null (unless already changed)
            if ($desactivation->getBorne() === $this) {
                $desactivation->setBorne(null);
            }
        }

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
            $sessionWifi->setBorne($this);
        }

        return $this;
    }

    public function removeSessionWifi(SessionWifi $sessionWifi): self
    {
        if ($this->sessionWifis->contains($sessionWifi)) {
            $this->sessionWifis->removeElement($sessionWifi);
            // set the owning side to null (unless already changed)
            if ($sessionWifi->getBorne() === $this) {
                $sessionWifi->setBorne(null);
            }
        }

        return $this;
    }
}
