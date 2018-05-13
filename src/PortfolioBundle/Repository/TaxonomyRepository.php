<?php

namespace PortfolioBundle\Repository;

use Doctrine\ORM\EntityRepository;



class TaxonomyRepository extends EntityRepository{


    public function getQueryBuilder(array $params = array()){

        $qb = $this->createQueryBuilder('t');

        $qb->select('t, COUNT(p.id) as projectCount')
            ->leftJoin('t.projects', 'p')
            ->groupBy('t.id');

        return $qb;

    }

    public function getAsArray(){

        $qb = $this->createQueryBuilder('t')
                    ->select('t.id', 't.name')
                    ->getQuery()
                    ->getArrayResult();

        return $qb;
    }

}