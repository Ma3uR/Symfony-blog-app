<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getAllArticles(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT a.id, CONCAT(u.first_name, u.last_name) AS fulname, a.title, a.description FROM article AS a
        INNER JOIN user AS u ON a.id = u.id     
        ORDER BY a.id ASC
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function getAllArticlesBuilder(): array
    {
        return $this
            ->createQueryBuilder('a')
            ->select('a.id')
            ->addSelect("CONCAT(u.firstName,' ',u.lastName) AS full_name")
            ->addSelect('a.title AS article_title')
            ->addSelect('a.description')
            ->addSelect('c.title AS category_title')
            ->innerJoin('a.author', 'u')
            ->innerJoin('a.category', 'c')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    #get the count of articles in each category
    public function getCountOfArticles()
    {
        return $this->createQueryBuilder('a')
                    ->select('c.title')
                    ->addSelect('COUNT(a.id) AS count_of_articles')
                    ->innerJoin('a.category', 'c')
                    ->groupBy('a.category')
                    ->orderBy('count_of_articles', 'DESC')
                    ->getQuery()
                    ->getResult();
    }

    #get the user with the most count of articles

    public function selectUsersCountOfArticles(): QueryBuilder
    {
        return $this->createQueryBuilder('a')
                    ->select ('u.id AS author_of_articles')
                    ->innerJoin('a.author','u')
                    ->addSelect('COUNT(a.author) AS count_of_articles');
    }

    public function getUserWithMostArticles()
    {
        return $this->selectUsersCountOfArticles()
                    ->orderBy('a.author')
                    ->setMaxResults('1')
                    ->getQuery()
                    ->getResult();
    }




    public function selectAllArticlesWithAuthors(): QueryBuilder {
        return $this->createQueryBuilder('a')
            ->select('a, u')
            ->innerJoin('a.author', 'u');
    }

    public function getAllArticlesWithAuthorsOrderedByTitle() {
        return $this->selectAllArticlesWithAuthors()
            ->orderBy('a.title','DESC')
            ->getQuery()
            ->getResult();
    }

    public function getAllArticlesWithAuthorsOrderedByDescription() {
        return $this->selectAllArticlesWithAuthors()
            ->orderBy('a.description','DESC')
            ->getQuery()
            ->getResult();
    }
}
