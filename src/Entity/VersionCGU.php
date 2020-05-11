<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VersionCGURepository")
 */
class VersionCGU
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="versionCgu_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $version_cgu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description_cgu;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_activation;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Utilisateur", mappedBy="version_cgu")
     */
    private $utilisateurs;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersionCgu(): ?string
    {
        return $this->version_cgu;
    }

    public function setVersionCgu(string $version_cgu): self
    {
        $this->version_cgu = $version_cgu;

        return $this;
    }

    public function getDescriptionCgu(): ?string
    {
        return $this->description_cgu;
    }

    public function setDescriptionCgu(string $description_cgu): self
    {
        $this->description_cgu = $description_cgu;

        return $this;
    }

    public function getDateActivation(): ?\DateTimeInterface
    {
        return $this->date_activation;
    }

    public function setDateActivation(\DateTimeInterface $date_activation): self
    {
        $this->date_activation = $date_activation;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
            $utilisateur->setVersionCgu($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->removeElement($utilisateur);
            // set the owning side to null (unless already changed)
            if ($utilisateur->getVersionCgu() === $this) {
                $utilisateur->setVersionCgu(null);
            }
        }

        return $this;
    }
}
