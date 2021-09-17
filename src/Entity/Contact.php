<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Contact
 * @package App\Entity
 */
class Contact
{

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(
     * min = 3,
     * max = 30,
     * minMessage = "Le titre du produit doit contenir au moins 3 caractères",
     * maxMessage = "Le titre du produit ne peut pas dépasser 30 caractères"
     * )
     */
    private $fullName;


    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(
     * min = 5,
     * max = 50,
     * minMessage = "Le titre du produit doit contenir au moins 5 caractères",
     * maxMessage = "Le titre du produit ne peut pas dépasser 50 caractères"
     * )
     */
    private $subject;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email
     */
    private $email;

    /**
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(
     * min = 10,
     * minMessage = "Le titre du produit doit contenir au moins 10 caractères"
     * )
     */
    private $message;



    /**
     * @return null|string
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     * @param null|string $fullName
     */
    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;

    }

    /**
     * @return null|string
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param null|string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;

    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param null|string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;

    }

    /**
     * @return null|string
     */

    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param null|string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;

    }
}
