<?php

namespace PortfolioBundle\Repository;

use Doctrine\ORM\EntityRepository;


class UserRepository extends EntityRepository{

    public function getQueryBuilder(array $params = array()){

        $qb = $this->createQueryBuilder('u')
            ->select('u');

        if(!empty($params['usernameLike'])){
            $usernameLike = '%'.$params['usernameLike'].'%';
            $qb->andWhere('u.username LIKE :usernameLike')
                ->setParameter('usernameLike', $usernameLike);
        }

        return $qb;

    }

}