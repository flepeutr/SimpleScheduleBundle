<?php

namespace IDCI\Bundle\SimpleScheduleBundle\Service;

class Manager
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getEntityManager()
    {
        return $this->container->get('doctrine.orm.entity_manager');
    }

    public function getExporterManager()
    {
        return $this->container->get('idci_exporter.manager');
    }

    /**
     * getAll
     *
     * @return DoctrineCollection
     */
    public function getAll()
    {
        $entities = $this
            ->getEntityManager()
            ->getRepository('IDCISimpleScheduleBundle:CalendarEntity')
            ->getAllOrderByStartAt()
        ;

        return $entities;
    }

    /**
     * query
     *
     * @param array $params
     * @return ExportResult
     */
    public function query($params)
    {
        $entities = $this
            ->getEntityManager()
            ->getRepository('IDCISimpleScheduleBundle:CalendarEntity')
            ->query($params)
        ;

        return $this->getExporterManager()
            ->export($entities, self::getFormat($params))
        ;
    }

    /**
     * getFormat
     *
     * @param array $params
     * @return string The format
     */
    static function getFormat($params)
    {
        return isset($params['format']) ? $params['format'] : 'xml';
    }
}
