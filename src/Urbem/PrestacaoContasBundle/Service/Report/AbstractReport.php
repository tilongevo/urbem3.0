<?php

namespace Urbem\PrestacaoContasBundle\Service\Report;

use DateTime;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class AbstractReport
 *
 * @package Urbem\PrestacaoContasBundle\Service\Report
 */
abstract class AbstractReport implements InterfaceReport
{
    /** @var EntityManager */
    protected $entityManager;

    /** @var Filesystem */
    protected $filesystem;

    /**
     * AbstractReport constructor.
     *
     * @param EntityManager $entityManager
     * @param Filesystem    $filesystem
     */
    public function __construct(EntityManager $entityManager, Filesystem $filesystem)
    {
        $this->entityManager = $entityManager;
        $this->filesystem = $filesystem;
    }

    /**
     * @param integer|string $exercicio
     *
     * @return $this
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;

        return $this;
    }

    /**
     * @param array $data
     * @param array $keys
     *
     * @return array
     */
    public function selectColumnsToReport(array $data, array $keys)
    {
        $newData = [];

        foreach ($data as $index => $item) {
            foreach ($keys as $key) {
                $newData[$index][$key] = $item[$key];
            }
        }

        return $newData;
    }

    /**
     * @return array
     */
    public function generate(DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        return $this->getData($dataInicial, $dataFinal, $exercicio);
    }

    /**
     * @param string     $glue
     * @param DateTime   $dataInicial
     * @param DateTime   $dataFinal
     * @param string|int $exercicio
     *
     * @return array
     */
    public function generateAsString($glue, DateTime $dataInicial, DateTime $dataFinal, $exercicio)
    {
        $data = $this->generate($dataInicial, $dataFinal, $exercicio);

        if (is_null($data)) {
            return [];
        }

        return array_map(function ($item) use ($glue) {
            return trim(implode($glue, $item));
        }, $data);
    }

    /**
     * @return array
     */
    public abstract function getData(DateTime $dataInicial, DateTime $dataFinal, $exercicio);
}
