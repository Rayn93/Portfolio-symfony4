<?php

namespace PortfolioBundle\Repository;

use Doctrine\ORM\EntityRepository;



class ProjectRepository extends EntityRepository{


    public function getQueryBuilder(array $params = array()){

        $qb = $this->createQueryBuilder('p');

        $qb ->select('p, c, t')
            ->leftJoin('p.category', 'c')
            ->leftJoin('p.tags', 't');

        if(!empty($params['home'])){
            $qb ->where('p.homePage = :true')
                ->setParameter('true', true);
        }

        if(!empty($params['orderBy'])){
            $qb ->orderBy($params['orderBy'], $params['orderDir']);
        }

        if(!empty($params['tag'])){
            $qb ->andWhere('t.slug = :tag')
                ->setParameter('tag', $params['tag']);
        }

        if(!empty($params['category'])){
            $qb ->andWhere('c.slug = :category')
                ->setParameter('category', $params['category']);
        }

        if(!empty($params['titleLike'])){
            $searchTitle = '%'.$params['titleLike'].'%';
            $qb ->andWhere('p.title LIKE :searchTitle')
                ->setParameter('searchTitle', $searchTitle);
        }

        if(!empty($params['categoryId'])){
            $qb ->andWhere('c.id = :categoryid')
                ->setParameter('categoryid', $params['categoryId']);
        }

        return $qb;
    }

    public function moveToCategory($oldCategoryId, $newCategoryId) {
        return $this->createQueryBuilder('p')
            ->update()
            ->set('p.category', ':newCategoryId')
            ->where('p.category = :oldCategoryId')
            ->setParameters(array(
                'newCategoryId' => $newCategoryId,
                'oldCategoryId' => $oldCategoryId
            ))
            ->getQuery()
            ->execute();
    }

}