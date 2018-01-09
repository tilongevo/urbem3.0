<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetora;
use Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Patrimonio\Patrimonio\InventarioRepository;

/**
 * Class ArquivoColetoraDadosModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Patrimonio
 */
class ArquivoColetoraDadosModel extends AbstractModel
{
    /** @var ORM\EntityManager|null $entityManager */
    protected $entityManager = null;
    /** @var InventarioRepository $repository */
    protected $repository = null;

    /**
     * InventarioModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Patrimonio\\ArquivoColetoraDados");
    }

    /**
     * @param object $object
     */
    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    /**
     * @param $codLocal
     * @param $numPlaca
     * @param ArquivoColetora $arquivoColetora
     * @return ArquivoColetoraDados
     */
    public function findOneOrSaveBasedArquivoColetora($codLocal, $numPlaca, ArquivoColetora $arquivoColetora)
    {
        $arquivoColetoraDados = $this->repository->findOneBy([
            'codLocal' => $codLocal,
            'numPlaca' => $numPlaca,
            'codigo' => $arquivoColetora->getCodigo()
        ]);
        if (is_null($arquivoColetoraDados)) {
            /** @var ArquivoColetoraDados $arquivoColetoraDados */
            $arquivoColetoraDados = new ArquivoColetoraDados();
        }
        $arquivoColetoraDados->setCodLocal($codLocal);
        $arquivoColetoraDados->setNumPlaca($numPlaca);
        $arquivoColetoraDados->setFkPatrimonioArquivoColetora($arquivoColetora);

        $this->entityManager->persist($arquivoColetoraDados);

        return $arquivoColetoraDados;
    }

    /**
     * @param $placa
     * @return mixed
     */
    public function consultaPlaca($placa)
    {
        return $this->repository->consultaPlaca($placa);
    }
}
