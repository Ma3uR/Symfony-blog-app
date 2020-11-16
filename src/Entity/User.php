<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Doctrine\ORM\PersistentCollection;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\Table;

/**
 * @Table(name="user",
 *    uniqueConstraints={
 *        @UniqueConstraint(name="username_unique",
 *            columns={"username"})
 *    }
 * )
 * @ORM\Entity()
 * @HasLifecycleCallbacks
 * @UniqueEntity("username", message="This username allready exist")
 * @ORM\EntityListeners({"App\EntityListener\UserListener"})
 */
class User implements UserInterface, Serializable {
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
     * @Groups("main")
     *
     */
    private string $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Username should not be blank")
     * @Assert\Length(
     *      min = 2,
     *      max = 30,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     * @Groups("main")
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
     * @Groups("main")
     */
    private ?string $lastName;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @Assert\Length(
     *      min = 8,
     *      max = 255,
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

    /**
     * @Assert\NotBlank(message="Password should not be blank")
     * @Assert\Length(
     *      min = 8,
     *      max = 255,
     *      minMessage = "Your password must be at least {{ limit }} characters long",
     *      maxMessage = "Your password cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private ?string $plainPassword = null;


    /**
     * @ORM\OneToMany(targetEntity=ApiToken::class, mappedBy="user", orphanRemoval=true)
     */
    private $apiTokens;

    public function __construct() {
        $this->articles = new ArrayCollection();
        $this->apiTokens = new ArrayCollection();
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

    public function setPlainPassword($password): void {
        $this->plainPassword = $password;
    }

    public function getPlainPassword(): ?string {
        return $this->plainPassword;
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

    public function getSalt() {

    }

    public function getRoles() {
        return [
            'ROLE_USER'
        ];
    }

    public function eraseCredentials() {
        // TODO: Implement eraseCredentials() method.
    }

    public function serialize() {
        return serialize([
            $this->id,
            $this->username,
            $this->password
        ]);
    }

    public function unserialize($serialized) {
        [
            $this->id,
            $this->username,
            $this->password
        ] = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function getApiTokens(): Collection {
        return $this->apiTokens;
    }

    public function addApiToken(ApiToken $apiToken): User
    {
        if (!$this->apiTokens->contains($apiToken)) {
            $this->apiTokens[] = $apiToken;
        }
        return $this;
    }
}
