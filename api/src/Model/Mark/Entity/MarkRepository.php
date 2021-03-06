<?php


namespace App\Model\Mark\Entity;


use App\Model\Type\UUIDType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use DomainException;

class MarkRepository
{
    private EntityManagerInterface $em;
    private EntityRepository $repository;

    public function __construct(EntityManagerInterface $em, EntityRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function get(UUIDType $id): Mark
    {
        /** @var Mark|null $mark */
        $mark = $this->repository->find($id->getValue());
        return $this->fetch($mark);
    }

    public function add(Mark $mark): void
    {
        $this->em->persist($mark);
    }

    public function remove(Mark $mark): void
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


    public function hasByName(string $name): bool
    {
        return $this->repository->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.name = :name_ru')
                ->setParameter(':name_ru', $name)
                ->getQuery()
                ->getSingleScalarResult() > 0;
    }

    public function hasByCoordinates(string $coordinates): bool
    {
        return $this->repository->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.coordinates = :coordinates')
                ->setParameter(':coordinates', $coordinates)
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

    public function countAllForFind(?string $name): int
    {
        $queryBuilder = $this->repository->createQueryBuilder('t')
            ->select('COUNT(t.id)');

        if ($name) {
            $queryBuilder = $queryBuilder
                ->orWhere('LOWER(t.name) LIKE :name')
                ->setParameter(':name', '%' . mb_strtolower($name, 'UTF-8') . '%');
        }

        return $queryBuilder->getQuery()->getSingleScalarResult();
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

    public function find(?string $name, $limit, $offset): array
    {
        $queryBuilder = $this->repository->createQueryBuilder('t')
            ->orderBy('t.updatedAt', 'DESC');

        if ($limit !== 0) {
            $queryBuilder = $queryBuilder
                ->setMaxResults($limit)
                ->setFirstResult($offset);
        }

        if ($name) {
            $queryBuilder = $queryBuilder
                ->orWhere('LOWER(t.name) LIKE :name')
                ->setParameter(':name', '%' . mb_strtolower($name, 'UTF-8') . '%');
        }

        /** @var array|null $rows */
        $rows = $queryBuilder->getQuery()->getResult();

        return $rows;
    }

    public function fetch(?Mark $mark): Mark
    {
        if (!$mark) {
            throw new DomainException('Mark is not found.');
        }

        return $mark;
    }

    private function fetchAll(?array $rows): array
    {
        return $rows;
    }
}
