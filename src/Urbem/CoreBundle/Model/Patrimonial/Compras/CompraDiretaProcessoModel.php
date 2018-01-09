<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 19/08/16
 * Time: 15:46
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\SwProcesso;

class CompraDiretaProcessoModel
{
    private $entityManager = null;
    protected $repository = null;

    /**
     * MapaCotacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\CompraDiretaProcesso::class);
    }

    /**
     * Constrói um Compras\CompraDiretaProcesso com base no Compras\CompraDireta
     * @param Compras\CompraDireta $compraDireta
     * @param SwProcesso $swProcesso
     * @return Compras\CompraDireta compraDireta
     */
    public function buildOneEqualCompraDireta(Compras\CompraDireta $compraDireta, SwProcesso $swProcesso)
    {
        $compraDiretaProcesso = $this->getCompraDiretaProcesso($compraDireta, $swProcesso);

        if (!is_null($compraDiretaProcesso)) {
            $compraDiretaProcesso = $compraDiretaProcesso;
        } else {
            $compraDiretaProcesso = new Compras\CompraDiretaProcesso();
        }
        $compraDiretaProcesso->setFkSwProcesso($swProcesso);
        $compraDiretaProcesso->setFkComprasCompraDireta($compraDireta);

        $compraDireta->setFkComprasCompraDiretaProcesso($compraDiretaProcesso);

        return $compraDireta;
    }

    /**
     * @param Compras\CompraDireta $compraDireta
     */
    public function removeAllCompraDiretaProcesso(Compras\CompraDireta $compraDireta)
    {
        $compraDiretaProcessoCollection = $compraDireta->getCompraDiretaProcessoCollection();

        foreach ($compraDiretaProcessoCollection as $compraDiretaProcesso) {
            $this->entityManager->remove($compraDiretaProcesso);
        }
    }

    /**
     * @param Compras\CompraDireta $compraDireta
     * @param SwProcesso $swProcesso
     * @return null|object|Compras\CompraDiretaProcesso
     */
    public function getCompraDiretaProcesso(Compras\CompraDireta $compraDireta, SwProcesso $swProcesso)
    {
        $compraDiretaProcesso = $this->repository->findOneBy([
            'codCompraDireta' => $compraDireta->getCodCompraDireta(),
            'codEntidade' => $compraDireta->getCodEntidade(),
            'exercicioEntidade' => $compraDireta->getExercicioEntidade(),
            'codModalidade' => $compraDireta->getCodModalidade(),
        ]);

        return $compraDiretaProcesso;
    }
}
