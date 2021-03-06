<?php

namespace IDCI\Bundle\SimpleScheduleBundle\Repository;

use Doctrine\ORM\EntityRepository;
use IDCI\Bundle\SimpleScheduleBundle\Entity\Category;

/**
 * CalendarEntityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CalendarEntityRepository extends EntityRepository
{
    /**
     * getRelatedAvailableCalendarEntitiesQueryBuilder
     *
     * @param $entity CalendarEntity
     * @return QueryBuilder
     */
    public function getRelatedAvailableCalendarEntitiesQueryBuilder($entity = null)
    {
        $qb = $this->createQueryBuilder('cer');

        if($entity) {
            $ids = array();
            foreach($entity->getRelateds() as $related) {
                $ids[] = $related->getRelatedTo()->getId();
            }

            $qb
                ->where('cer.id not in (:entities_id)')
                ->setParameter('entities_id', array_merge(
                    array($entity->getId()),
                    $ids
                ))
            ;
        }

        $qb->orderBy('cer.startAt', 'ASC');

        return $qb;
    }

    /**
     * getRelatedAvailableCalendarEntitiesQuery
     *
     * @param $entity CalendarEntity
     * @return Query
     */
    public function getRelatedAvailableCalendarEntitiesQuery($entity = null)
    {
        $qb = $this->getRelatedAvailableCalendarEntitiesQueryBuilder($entity);

        return is_null($qb) ? $qb : $qb->getQuery();
    }

    /**
     * getRelatedAvailableCalendarEntities
     *
     * @param $entity CalendarEntity
     * @return DoctrineCollection
     */
    public function getRelatedAvailableCalendarEntities($entity = null)
    {
        $q = $this->getRelatedAvailableCalendarEntitiesQuery($entity);

        return is_null($q) ? array() : $q->getResult();
    }

    /**
     * getAllOrderByStartAtQueryBuilder
     *
     * @return QueryBuilder
     */
    public function getAllOrderByStartAtQueryBuilder()
    {
        $qb = $this->createQueryBuilder('cer');
        $qb->orderBy('cer.startAt', 'ASC');

        return $qb;
    }

    /**
     * getAllOrderByStartAtQuery
     *
     * @return Query
     */
    public function getAllOrderByStartAtQuery()
    {
        $qb = $this->getAllOrderByStartAtQueryBuilder();

        return is_null($qb) ? $qb : $qb->getQuery();
    }

    /**
     * getAllOrderByStartAt
     *
     * @return DoctrineCollection
     */
    public function getAllOrderByStartAt()
    {
        $q = $this->getAllOrderByStartAtQuery();

        return is_null($q) ? array() : $q->getResult();
    }

    /**
     * queryQueryBuilder
     *
     * @param array Parameters
     * @return QueryBuilder
     */
    public function queryQueryBuilder($params)
    {
        $qb = $this->createQueryBuilder('cer');
        $qb->orderBy('cer.startAt', 'ASC');


        if(isset($params['id'])) {
            $qb
                ->andWhere('cer.id = :id')
                ->setParameter('id', $params['id'])
            ;
        }

        if(isset($params['ids'])) {
            $qb
                ->andWhere($qb->expr()->in('cer.id', $params['ids']))
            ;
        }

        if(isset($params['category_id'])) {
            $qb
                ->leftJoin('cer.categories', 'c')
                ->andWhere('c.id = :cat_id')
                ->setParameter('cat_id', $params['category_id'])
            ;
        }

        if(isset($params['category_ids'])) {
            $qb
                ->leftJoin('cer.categories', 'cs')
                ->andWhere($qb->expr()->in('cs.id', $params['category_ids']))
            ;
        }

        if(isset($params['parent_category_id'])) {
            $qb
                ->leftJoin('cer.categories', 'pc')
                ->andWhere('pc.parent = :parent_id')
                ->setParameter('parent_id', $params['parent_category_id'])
            ;
        }

        if(isset($params['parent_category_ids'])) {
            $qb
                ->leftJoin('cer.categories', 'pcs')
                ->andWhere($qb->expr()->in('pcs.parent', $params['parent_category_ids']))
            ;
        }

        if(isset($params['ancestor_category_id'])) {
            $qb
                ->leftJoin('cer.categories', 'pc')
                ->andWhere($qb->expr()->like('pc.tree', sprintf(
                    "'%%%d%s'",
                    $params['ancestor_category_id'],
                    Category::getTreeSeparator()
                )))
            ;
        }

        if(isset($params['ancestor_category_ids'])) {
            $qb->leftJoin('cer.categories', 'pcs');
            $temp = array();
            foreach($params['ancestor_category_ids'] as $id) {
                $temp[] = $qb->expr()->like('pcs.tree', sprintf(
                    "'%%%d%s'",
                    $id,
                    Category::getTreeSeparator()
                ));
            }
            $qb->andWhere(call_user_func_array(array($qb->expr(),'orx'), $temp));
        }

        if(isset($params['location_id'])) {
            $qb
                ->andWhere('cer.location = :location_id')
                ->setParameter('location_id', $params['location_id'])
            ;
        }

        if(isset($params['location_ids'])) {
            $qb
                ->andWhere($qb->expr()->in('cer.location', $params['location_ids']))
            ;
        }


        return $qb;
    }

    /**
     * queryQuery
     *
     * @param array Parameters
     * @return Query
     */
    public function queryQuery($params)
    {
        $qb = $this->queryQueryBuilder($params);

        return is_null($qb) ? $qb : $qb->getQuery();
    }

    /**
     * query
     *
     * @param array Parameters
     * @return DoctrineCollection
     */
    public function query($params)
    {
        $q = $this->queryQuery($params);

        return is_null($q) ? array() : $q->getResult();
    }
}
