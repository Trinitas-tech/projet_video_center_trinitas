<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Video>
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Video::class);
    }

    /**
     * Vidéos visibles par l'utilisateur, les plus récentes d'abord.
     * Un visiteur ou un utilisateur non vérifié ne voit pas les vidéos premium.
     */
    public function queryVisible(?User $user): QueryBuilder
    {
        $qb = $this->createQueryBuilder('v')
            ->orderBy('v.createdAt', 'DESC');

        if (!$user || !$user->isVerified()) {
            $qb->andWhere('v.premiumVideo = false');
        }

        return $qb;
    }

    /**
     * Recherche sur le titre et la description, limitée aux vidéos visibles.
     */
    public function querySearch(string $term, ?User $user): QueryBuilder
    {
        return $this->queryVisible($user)
            ->andWhere('v.title LIKE :term OR v.description LIKE :term')
            ->setParameter('term', '%' . $term . '%');
    }
}
