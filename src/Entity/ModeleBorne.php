<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModeleBorneRepository")
 */
class ModeleBorne
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="modeleBorne_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lan_interface;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $wan_interface;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chemin_led_status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chemin_led_ok;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chemin_led_erreur;

    /**
     * @ORM\Column(type="integer")
     */
    private $gain_antenne;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $radio_dev;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ht_capab;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Borne", mappedBy="modeleborne")
     */
    private $bornes;

    public function __construct()
    {
        $this->bornes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLanInterface(): ?string
    {
        return $this->lan_interface;
    }

    public function setLanInterface(string $lan_interface): self
    {
        $this->lan_interface = $lan_interface;

        return $this;
    }

    public function getWanInterface(): ?string
    {
        return $this->wan_interface;
    }

    public function setWanInterface(string $wan_interface): self
    {
        $this->wan_interface = $wan_interface;

        return $this;
    }

    public function getCheminLedStatus(): ?string
    {
        return $this->chemin_led_status;
    }

    public function setCheminLedStatus(string $chemin_led_status): self
    {
        $this->chemin_led_status = $chemin_led_status;

        return $this;
    }

    public function getCheminLedOk(): ?string
    {
        return $this->chemin_led_ok;
    }

    public function setCheminLedOk(string $chemin_led_ok): self
    {
        $this->chemin_led_ok = $chemin_led_ok;

        return $this;
    }

    public function getCheminLedErreur(): ?string
    {
        return $this->chemin_led_erreur;
    }

    public function setCheminLedErreur(string $chemin_led_erreur): self
    {
        $this->chemin_led_erreur = $chemin_led_erreur;

        return $this;
    }

    public function getGainAntenne(): ?int
    {
        return $this->gain_antenne;
    }

    public function setGainAntenne(int $gain_antenne): self
    {
        $this->gain_antenne = $gain_antenne;

        return $this;
    }

    public function getRadioDev(): ?string
    {
        return $this->radio_dev;
    }

    public function setRadioDev(string $radio_dev): self
    {
        $this->radio_dev = $radio_dev;

        return $this;
    }

    public function getHtCapab(): ?string
    {
        return $this->ht_capab;
    }

    public function setHtCapab(string $ht_capab): self
    {
        $this->ht_capab = $ht_capab;

        return $this;
    }

    /**
     * @return Collection|Borne[]
     */
    public function getBornes(): Collection
    {
        return $this->bornes;
    }

    public function addBorne(Borne $borne): self
    {
        if (!$this->bornes->contains($borne)) {
            $this->bornes[] = $borne;
            $borne->setModeleborne($this);
        }

        return $this;
    }

    public function removeBorne(Borne $borne): self
    {
        if ($this->bornes->contains($borne)) {
            $this->bornes->removeElement($borne);
            // set the owning side to null (unless already changed)
            if ($borne->getModeleborne() === $this) {
                $borne->setModeleborne(null);
            }
        }

        return $this;
    }
}
