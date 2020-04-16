<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmplacementRepository")
 */
class Emplacement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="emplacement_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_etablissement;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     */
    private $latitude;

    /**
     * @ORM\Column(type="decimal", precision=20, scale=2)
     */
    private $longitude;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Adresse", inversedBy="emplacements",cascade={"persist"})
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Borne", mappedBy="emplacement")
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

    public function getNomEtablissement(): ?string
    {
        return $this->nom_etablissement;
    }

    public function setNomEtablissement(string $nom_etablissement): self
    {
        $this->nom_etablissement = $nom_etablissement;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

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
            $borne->setEmplacement($this);
        }

        return $this;
    }

    public function removeBorne(Borne $borne): self
    {
        if ($this->bornes->contains($borne)) {
            $this->bornes->removeElement($borne);
            // set the owning side to null (unless already changed)
            if ($borne->getEmplacement() === $this) {
                $borne->setEmplacement(null);
            }
        }

        return $this;
    }
}
