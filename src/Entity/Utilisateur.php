<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur extends Personne
{
     /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="utilisateur_id_seq", allocationSize=1, initialValue=1)
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nouveau_mot_de_passe;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_creation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $suppression;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $validation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $reseau_cree;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $acceptation_commercial;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $google_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $google_access_token;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook_access_token;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VersionCGU", inversedBy="utilisateurs")
     */
    private $version_cgu;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Peripherique", mappedBy="utilisateur")
     */
    private $peripheriques;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activation_token;

    public function __construct()
    {
        $this->peripheriques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNouveauMotDePasse(): ?string
    {
        return $this->nouveau_mot_de_passe;
    }

    public function setNouveauMotDePasse(?string $nouveau_mot_de_passe): self
    {
        $this->nouveau_mot_de_passe = $nouveau_mot_de_passe;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getSuppression(): ?bool
    {
        return $this->suppression;
    }

    public function setSuppression(bool $suppression): self
    {
        $this->suppression = $suppression;

        return $this;
    }

    public function getValidation(): ?bool
    {
        return $this->validation;
    }

    public function setValidation(bool $validation): self
    {
        $this->validation = $validation;

        return $this;
    }

    public function getReseauCree(): ?int
    {
        return $this->reseau_cree;
    }

    public function setReseauCree(int $reseau_cree): self
    {
        $this->reseau_cree = $reseau_cree;

        return $this;
    }

    public function getAcceptationCommercial(): ?bool
    {
        return $this->acceptation_commercial;
    }

    public function setAcceptationCommercial(bool $acceptation_commercial): self
    {
        $this->acceptation_commercial = $acceptation_commercial;

        return $this;
    }

    public function getGoogleId(): ?int
    {
        return $this->google_id;
    }

    public function setGoogleId(?int $google_id): self
    {
        $this->google_id = $google_id;

        return $this;
    }

    public function getGoogleAccessToken(): ?string
    {
        return $this->google_access_token;
    }

    public function setGoogleAccessToken(?string $google_access_token): self
    {
        $this->google_access_token = $google_access_token;

        return $this;
    }

    public function getFacebookId(): ?string
    {
        return $this->facebook_id;
    }

    public function setFacebookId(?string $facebook_id): self
    {
        $this->facebook_id = $facebook_id;

        return $this;
    }

    public function getFacebookAccessToken(): ?string
    {
        return $this->facebook_access_token;
    }

    public function setFacebookAccessToken(?string $facebook_access_token): self
    {
        $this->facebook_access_token = $facebook_access_token;

        return $this;
    }

    public function getVersionCgu(): ?VersionCGU
    {
        return $this->version_cgu;
    }

    public function setVersionCgu(?VersionCGU $version_cgu): self
    {
        $this->version_cgu = $version_cgu;

        return $this;
    }

    /**
     * @return Collection|Peripherique[]
     */
    public function getPeripheriques(): Collection
    {
        return $this->peripheriques;
    }

    public function addPeripherique(Peripherique $peripherique): self
    {
        if (!$this->peripheriques->contains($peripherique)) {
            $this->peripheriques[] = $peripherique;
            $peripherique->setUtilisateur($this);
        }

        return $this;
    }

    public function removePeripherique(Peripherique $peripherique): self
    {
        if ($this->peripheriques->contains($peripherique)) {
            $this->peripheriques->removeElement($peripherique);
            // set the owning side to null (unless already changed)
            if ($peripherique->getUtilisateur() === $this) {
                $peripherique->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(?string $activation_token): self
    {
        $this->activation_token = $activation_token;

        return $this;
    }
}
