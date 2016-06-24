<?php

namespace Ex\Domain;

use Doctrine\DBAL\Connection;

/**
 * Class ExRepository
 * @package Ex\Domain
 */
class ExRepository
{
    /**
     * @var Connection
     */
    protected $db;

    /**
     * @param Connection $db
     * @throws \Exception
     */
    public function __construct(Connection $db)
    {
        if (empty($db)) {
            throw new \Exception('Connection lost!');
        }

        $this->db = $db;
    }
}
