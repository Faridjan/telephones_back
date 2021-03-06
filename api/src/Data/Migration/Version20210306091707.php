<?php

declare(strict_types=1);

try {
    $dbh = new PDO('pgsql:host=srv-db-pgsql01.ps.kz;port=5432;dbname=inplusk2_dima;', 'inplusk2_testdimon', 'a2O#q8f1');

    $db->exec('CREATE TABLE content (id UUID NOT NULL, content_json VARCHAR(255) DEFAULT NULL, content_html VARCHAR(255) DEFAULT NULL, content_img VARCHAR(255) DEFAULT NULL, content_file VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
    $db->exec('COMMENT ON COLUMN content.id IS \'(DC2Type:uuid_type)\'');
    $db->exec('COMMENT ON COLUMN content.content_html IS \'(DC2Type:content_html_type)\'');
    $db->exec('COMMENT ON COLUMN content.content_img IS \'(DC2Type:content_img_type)\'');
    $db->exec('COMMENT ON COLUMN content.content_file IS \'(DC2Type:content_file_type)\'');
    $db->exec('COMMENT ON COLUMN content.created_at IS \'(DC2Type:datetime_immutable)\'');
    $db->exec('COMMENT ON COLUMN content.updated_at IS \'(DC2Type:datetime_immutable)\'');
    $db->exec('CREATE TABLE mark (id UUID NOT NULL, content_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, coordinates VARCHAR(255) NOT NULL, options VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
    $db->exec('CREATE UNIQUE INDEX UNIQ_6674F2715E237E06 ON mark (name)');
    $db->exec('CREATE UNIQUE INDEX UNIQ_6674F27184A0A3ED ON mark (content_id)');
    $db->exec('COMMENT ON COLUMN mark.id IS \'(DC2Type:uuid_type)\'');
    $db->exec('COMMENT ON COLUMN mark.content_id IS \'(DC2Type:uuid_type)\'');
    $db->exec('COMMENT ON COLUMN mark.created_at IS \'(DC2Type:datetime_immutable)\'');
    $db->exec('COMMENT ON COLUMN mark.updated_at IS \'(DC2Type:datetime_immutable)\'');
    $db->exec('ALTER TABLE mark ADD CONSTRAINT FK_6674F27184A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

/**
use Psr\Container\ContainerInterface;
use Slim\App;

http_response_code(500);

require_once __DIR__ . '/../vendor/autoload.php';

var_dump('asdfasd');

/** @var ContainerInterface $container
$container = require_once __DIR__ . '/../config/container.php';

/** @var App $app
$app = (require_once __DIR__ . '/../config/app.php')($container);
$app->run();
 **/
