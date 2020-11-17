<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @UniqueEntity("title", message="This category title allready exist")
 */
class Category {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", nullable=false)
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Category title should not be blank")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Your category title must be at least {{ limit }} characters long",
     *      maxMessage = "Your category title cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     * @Groups("main")
     */
    private string $title;

    private ?Collection $articles = null;

    public function __construct() {
        $this->articles = new ArrayCollection();
    }

    public function getId(): int {
        return $this->id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle(string $title): self {
        $this->title = $title;

        return $this;
    }

    public function getArticles(): ?Collection {
        return $this->articles;
    }

    public function addArticle(Article $article): self {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setCategory($this);
        }

        return $this;
    }
}
