<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article implements \JsonSerializable {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Title should not be blank")
     * @Assert\Length(
     *      min = 5,
     *      max = 100,
     *      minMessage = "Your title must be at least {{ limit }} characters long",
     *      maxMessage = "Your title cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     * @Groups("main")
     */
    private string $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Description should not be blank")
     * * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "Your desctription must be at least {{ limit }} characters long",
     *      maxMessage = "Your desctription cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     * @Groups("main")
     */
    private string $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("main")
     */
    private User $author;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=true)
     * @Groups("main")
     */
    private ?Category $category;

//    public function __construct(User $author) { todo Cannot find whats wrong with this constructor
//        $this->author = $author;
//    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getTitle(): ?string {
        return $this->title;
    }

    public function setTitle(string $title): self {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): self {
        $this->description = $description;

        return $this;
    }

    public function getAuthor(): User {
        return $this->author;
    }

    public function setAuthor(User $author): self {
        $this->author = $author;

        return $this;
    }

    public function getCategory(): ?Category {
        return $this->category;
    }

    public function setCategory(?Category $category): self {
        $this->category = $category;

        return $this;
    }

    public function jsonSerialize(): array {
        return [
            "title" => $this->getTitle(),
            "description" => $this->getDescription()
        ];
    }
}
