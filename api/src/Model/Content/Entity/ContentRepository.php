<?php

namespace App\Model\Content\Entity;

use App\Model\Type\UUIDType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use DomainException;

class ContentRepository
{
    private EntityManagerInterface $em;
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $em, EntityRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function get(UUIDType $id): Content
    {
        /** @var Content|null $mark */
        $mark = $this->repository->find($id->getValue());
        return $this->fetch($mark);
    }

    public function add(Content $mark): void
    {
        $this->em->persist($mark);
    }

    public function remove(Content $mark): void
    {
        $this->em->remove($mark);
    }

    public function hasById(UUIDType $uuid): bool
    {
        return $this->repository->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.id = :id')
                ->setParameter(':id', $uuid->getValue())
                ->getQuery()
                ->getSingleScalarResult() > 0;
    }

    public function countAll(): int
    {
        return $this->repository->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getAll(?int $limit, ?int $offset): array
    {
        $queryBuilder = $this->repository->createQueryBuilder('t')
            ->orderBy('t.updatedAt', 'DESC');

        if ($limit !== 0) {
            $queryBuilder = $queryBuilder
                ->setMaxResults($limit)
                ->setFirstResult($offset);
        }

        /** @var array|null $rows */
        $rows = $queryBuilder
            ->getQuery()
            ->getResult();

        return $this->fetchAll($rows);
    }

    public function fetch(?Content $mark): Content
    {
        if (!$mark) {
            throw new DomainException('Content is not found.');
        }

        return $mark;
    }

    private function fetchAll(?array $rows): array
    {
        return $rows;
    }
}
