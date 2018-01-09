<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\SwAssunto;

class SwDocumentoModel extends AbstractModel implements InterfaceModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:SwDocumento');
    }

    public function canRemove($object)
    {
        $documentoAssuntoRepository = $this->entityManager->getRepository('CoreBundle:SwDocumentoAssunto');
        $resultAssunto = $documentoAssuntoRepository->findOneByCodDocumento($object->getCodDocumento());

        $documentoProcessoRepository = $this->entityManager->getRepository('CoreBundle:SwDocumentoProcesso');
        $resultDocumentoProcesso = $documentoProcessoRepository->findOneByCodDocumento($object->getCodDocumento());

        return is_null($resultAssunto) && is_null($resultDocumentoProcesso);
    }

    /**
     * @param SwAssunto $swAssunto
     *
     * @return array
     */
    public function getDocumentosBySwAssunto(SwAssunto $swAssunto)
    {
        $queryBuilder = $this->repository
            ->createQueryBuilder('d')
            ->join('d.fkSwDocumentoAssuntos', 'da')
            ->where('da.codAssunto = :codAssunto')
            ->andWhere('da.codClassificacao = :codClassificacao')
            ->setParameters([
                'codAssunto' => $swAssunto->getCodAssunto(),
                'codClassificacao' => $swAssunto->getCodClassificacao()
            ])
            ->getQuery()
        ;

        return $queryBuilder->getResult(ORM\AbstractQuery::HYDRATE_SIMPLEOBJECT);
    }
}
