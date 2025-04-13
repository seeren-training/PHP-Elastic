<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;

class ORM
{
    private EntityManagerInterface $entityManager;

    public function __construct()
    {
        $this->entityManager = require_once __DIR__ . "/../../bin/bootstrap.php";
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}
