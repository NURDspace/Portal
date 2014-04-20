<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

require_once __DIR__ . '/src/Addressbook.php';
require_once __DIR__ . '/src/Claim.php';
require_once __DIR__ . '/src/ClaimTransaction.php';
require_once __DIR__ . '/src/Invoice.php';
require_once __DIR__ . '/src/InvoiceTransaction.php';
require_once __DIR__ . '/src/Subscription.php';
require_once __DIR__ . '/src/Transaction.php';

$paths            = array(__DIR__ . 'src/');
$isDevMode        = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), $isDevMode, null, null, false);

// obtaining the entity manager
$entityManager = EntityManager::create($connectionParams, $config); 
