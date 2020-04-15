<?php


namespace App\Entity;


use DateTime;

class UtilisateurSearch
{

    /**
     * @var datetime|null
     */
    private $date;

    /**
     * @var string|null
     */
    private $email;
    /**
     * @var boolean|null
     */
    private $validation;

    /**
     * @return DateTime|null
     */
    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime|null $date_creation
     */
    public function setDate(?DateTime $date_creation): void
    {
        $this->date = $date_creation;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return bool|null
     */
    public function getValidation(): ?bool
    {
        return $this->validation;
    }

    /**
     * @param bool|null $validation
     */
    public function setValidation(?bool $validation): void
    {
        $this->validation = $validation;
    }


}