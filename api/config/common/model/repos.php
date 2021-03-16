<?php

use App\Model\Content\Entity\Content;
use App\Model\Content\Entity\ContentRepository;
use App\Model\Mark\Entity\Mark;
use App\Model\Mark\Entity\MarkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;

return [
    ContentRepository::class => static function (ContainerInterface $container): ContentRepository {
        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);

        /** @var EntityRepository $repo */
        $repo = $em->getRepository(Content::class);

        return new ContentRepository($em, $repo);
    },

    MarkRepository::class => static function (ContainerInterface $container): MarkRepository {
        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);

        /** @var EntityRepository $repo */
        $repo = $em->getRepository(Mark::class);

        return new MarkRepository($em, $repo);
    },
];
