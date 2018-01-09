<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 24/08/16
 * Time: 10:34
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras;

class PublicacaoCompraDiretaModel
{
    private $entityManager;
    protected $repository;

    /**
     * PublicacaoCompraDiretaModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\PublicacaoCompraDireta::class);
    }

    /**
     * Coloca os atributos de Compra Direta em Publicacao de Compra Direta
     *
     * @param Compras\PublicacaoCompraDireta $publicacaoCompraDireta
     * @param Compras\CompraDireta $compraDireta
     * @return Compras\PublicacaoCompraDireta
     */
    public function addToPublicacaoCompraDiretaAttributes(
        Compras\PublicacaoCompraDireta $publicacaoCompraDireta,
        Compras\CompraDireta $compraDireta = null
    ) {

        if (is_null($compraDireta)) {
            $compraDireta = $publicacaoCompraDireta->getCodCompraDireta();
        }

        $publicacaoCompraDireta->setCodEntidade($compraDireta->getCodEntidade());
        $publicacaoCompraDireta->setExercicioEntidade($compraDireta->getExercicioEntidade());
        $publicacaoCompraDireta->setCodModalidade($compraDireta->getCodModalidade());

        $publicacaoCompraDireta->setFkComprasCompraDireta($compraDireta);

        return $publicacaoCompraDireta;
    }
}
