<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService {
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function createAndPersist(Category $category): Category {
        $title = $category->getTitle();
        $category->setTitle($title);
        $em = $this->em;
        $em->persist($category);
        $em->flush();

        return $category;
    }

    public function persistAndFlush(Category $category) {
        $em = $this->em;
        $em->persist($category);
        $em->flush();
    }
}
