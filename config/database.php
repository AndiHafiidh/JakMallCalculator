<?php 

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array("./src/models"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);


// database configuration parameters
$conn = array(
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'dbname'   => 'jakmall',
    'user'     => 'root',
    'password' => ''
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);

?>