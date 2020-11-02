<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository {
    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Article::class);
    }

    public function selectArticles(): \Doctrine\ORM\QueryBuilder {
        return $this->createQueryBuilder('a')
            ->select('a.id')
            ->addSelect("CONCAT(u.firstName,' ',u.lastName) AS full_name")
            ->addSelect('a.title AS article_title')
            ->addSelect('a.description')
            ->addSelect('c.title AS category_title')
            ->innerJoin('a.author', 'u')
            ->innerJoin('a.category', 'c');
    }

    public function getAllArticles(): array {

        return $this->selectArticles()
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getLatest() {

        return $this->selectArticles()
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
}
