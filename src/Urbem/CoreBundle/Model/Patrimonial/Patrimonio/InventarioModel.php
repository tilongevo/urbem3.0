<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem;
use Urbem\CoreBundle\Entity\Patrimonio\Inventario;
use Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Patrimonio\Patrimonio\InventarioRepository;

/**
 * Class InventarioModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Patrimonio
 */
class InventarioModel implements Model\InterfaceModel
{
    /** @var ORM\EntityManager|null $entityManager */
    private $entityManager = null;
    /** @var InventarioRepository $repository */
    protected $repository = null;

    /**
     * InventarioModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Patrimonio\\Inventario");
    }

    /**
     * @param Inventario $object
     */
    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    /**
     * Retorna o número do proximo idInventario
     *
     * @param $complemento
     * @return mixed
     */
    public function getProximoId($complemento)
    {
        return $this->repository->getProximoId($complemento);
    }

    /**
     * Retorna carrega os bens para o InventarioHistoricoBem
     *
     * @param $params
     * @return mixed
     */
    public function cargaInventarioPatrimonio($params)
    {
        return $this->repository->cargaInventarioPatrimonio($params);
    }

    /**
     * @param \DateTime $vigencia
     *
     * @return array
     */
    public function getOrgaoBens(\DateTime $vigencia)
    {
        return $this->repository->getOrgaoBens($vigencia);
    }

    /**
     * Retorna o historico bem do bem informado
     *
     * @param  array $codBem
     *      código do bem
     * @return HistoricoBem
     *      historicoBem object
     */
    public function getBemHistoricoInfo($codBem)
    {
        $bem = $this->entityManager
            ->getRepository("CoreBundle:Patrimonio\\Bem")
            ->findOneBy(['codBem' => $codBem]);

        /** @var HistoricoBem $historicoBem */
        $historicoBem = $this->entityManager
            ->getRepository("CoreBundle:Patrimonio\\HistoricoBem")
            ->findOneBy(['fkPatrimonioBem' => $bem]);

        return $historicoBem;
    }

    /**
     * @param $codBem
     * @param $exercicio
     * @param $idIventario
     * @return InventarioHistoricoBem
     */
    public function getIventarioHistoricoBemInfo($codBem, $exercicio, $idIventario)
    {
        /** @var InventarioHistoricoBem $historicoBem */
        $historicoBem = $this->entityManager
            ->getRepository("CoreBundle:Patrimonio\\InventarioHistoricoBem")
            ->findBy(
                [
                    'codBem' => $codBem,
                    'idInventario' => $idIventario,
                    'exercicio' => $exercicio
                ],
                [
                    'timestamp' => 'ASC'
                ]
            );

        return $historicoBem[0];
    }

    /**
     * Processa o Inventário
     *
     * @param  object     $object   inventario object
     * @return array                historicoBem object
     */
    public function processarInventario($object)
    {
        return $this->repository->processarInventario($object);
    }

    /**
     * @param $exercicio
     * @param $codInventario
     * @return array
     */
    public function carregaDadosAberturaInventario($exercicio, $codInventario)
    {
        return $this->repository->carregaDadosAberturaInventario($exercicio, $codInventario);
    }

    /**
     * @param $exercicio
     * @param $codInventario
     * @return array
     */
    public function carregaDadosEncerramentoInventario($exercicio, $codInventario)
    {
        return $this->repository->carregaDadosEncerramentoInventario($exercicio, $codInventario);
    }

    /**
     * @param \DateTime $vigencia
     * @param $exercicio
     * @param $idInventario
     * @return array
     */
    public function recuperaOrgaosInventario(\DateTime $vigencia, $exercicio, $idInventario)
    {
        return $this->repository->recuperaOrgaosInventario($vigencia, $exercicio, $idInventario);
    }

    /**
     * @param $places
     * @return array
     */
    public function getListColetoraInventario($places)
    {
        return $this->repository->getListColetoraInventario($places);
    }

    /**
     * @param $places
     * @return array
     */
    public function getListColetoraCadastro($places)
    {
        return $this->repository->getListColetoraCadastro($places);
    }
}
