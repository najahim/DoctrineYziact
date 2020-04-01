<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrganisationRepository")
 */
class Organisation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="organisation_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom_organisation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeOrganisation", inversedBy="organisations")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Manager", inversedBy="organisations")
     */
    private $manager;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomOrganisation(): ?string
    {
        return $this->nom_organisation;
    }

    public function setNomOrganisation(string $nom_organisation): self
    {
        $this->nom_organisation = $nom_organisation;

        return $this;
    }

    public function getType(): ?TypeOrganisation
    {
        return $this->type;
    }

    public function setType(?TypeOrganisation $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getManager(): ?Manager
    {
        return $this->manager;
    }

    public function setManager(?Manager $manager): self
    {
        $this->manager = $manager;

        return $this;
    }
}
