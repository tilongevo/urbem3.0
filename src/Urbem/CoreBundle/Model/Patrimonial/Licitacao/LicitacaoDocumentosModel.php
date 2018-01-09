<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 28/09/16
 * Time: 11:45
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Licitacao\Documento;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\Licitacao\LicitacaoDocumentos;
use Urbem\CoreBundle\Model\InterfaceModel;

/**
 * Class LicitacaoDocumentosModel
 *
 * @package Urbem\CoreBundle\Model\Patrimonial\Licitacao
 */
class LicitacaoDocumentosModel extends AbstractModel implements InterfaceModel
{
    /**
     * LicitacaoDocumentosModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(LicitacaoDocumentos::class);
    }

    /**
     * @param Documento $documento
     * @param Licitacao $licitacao
     *
     * @return LicitacaoDocumentos
     */
    public function buildOne(Documento $documento, Licitacao $licitacao)
    {
        $licitacaoDocumentos = new LicitacaoDocumentos();
        $licitacaoDocumentos->setFkLicitacaoDocumento($documento);
        $licitacaoDocumentos->setFkLicitacaoLicitacao($licitacao);

        $this->entityManager->persist($licitacaoDocumentos);

        return $licitacaoDocumentos;
    }

    /**
     * @param Licitacao|null $licitacao
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getDocumentos(Licitacao $licitacao = null)
    {
        $licitacoesDocumento = $this->repository->findBy(['fkLicitacaoLicitacao' => $licitacao]);

        $ids = [];

        foreach ($licitacoesDocumento as $licitacaoDocumento) {
            $ids[] = $licitacaoDocumento->getCodDocumento();
        }

        $queryBuilderDocumento = $this->entityManager->createQueryBuilder();
        $queryBuilderDocumento
            ->select('documento')
            ->from(Documento::class, 'documento');

        if (count($ids) > 0) {
            $queryBuilderDocumento->where(
                $queryBuilderDocumento->expr()->notIn('documento.codDocumento', $ids)
            );
        }


        return $queryBuilderDocumento;
    }

    /**
     * @param LicitacaoDocumentos $licitacaoDocumentos
     *
     * @return boolean
     */
    public function canRemove($licitacaoDocumentos)
    {
        return $this->canRemoveWithAssociation($licitacaoDocumentos);
    }
}
