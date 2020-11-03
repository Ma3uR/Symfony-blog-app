<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
 * @UniqueEntity("username", message="This username allready exist")
 */
class User {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "Your user name must be at least {{ limit }} characters long",
     *      maxMessage = "Your user name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "Your last name must be at least {{ limit }} characters long",
     *      maxMessage = "Your last name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private ?string $lastName;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 8,
     *      max = 32,
     *      minMessage = "Your user name must be at least {{ limit }} characters long",
     *      maxMessage = "Your user name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private string $password;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="author")
     */
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getUsername(): ?string {
        return $this->username;
    }

    public function setUsername(string $username): self {
        $this->username = $username;

        return $this;
    }

    public function getFirstName(): ?string {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection {
        return $this->articles;
    }

    public function addArticle(Article $article): self {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAuthor($this);
        }

        return $this;
    }
}
