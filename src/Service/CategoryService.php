<?php


namespace App\Service;


use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService
{
    private EntityManagerInterface $em;

    public  function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function createAndPersist($title): Category
    {
        $category = new Category();
        $category->setTitle($title);
        $em = $this->em;
        $em->persist($category);
        $em->flush();

        return $category;
    }
}