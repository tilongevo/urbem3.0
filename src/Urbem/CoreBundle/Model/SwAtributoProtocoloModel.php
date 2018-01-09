<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\SwAssunto;

class SwAtributoProtocoloModel extends AbstractModel implements InterfaceModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:SwAtributoProtocolo');
    }

    public function canRemove($object)
    {
        $assuntoAtributoRepository = $this->entityManager->getRepository("CoreBundle:SwAssuntoAtributo");
        $result = $assuntoAtributoRepository->findOneByCodAtributo($object->getCodAtributo());

        return is_null($result);
    }

    /**
     * @param SwAssunto $swAssunto
     *
     * @return array
     */
    public function getAtributosBySwAssunto(SwAssunto $swAssunto)
    {
        $queryBuilder = $this->repository
            ->createQueryBuilder('ap')
            ->join('ap.fkSwAssuntoAtributos', 'aa')
            ->where('aa.codAssunto = :codAssunto')
            ->andWhere('aa.codClassificacao = :codClassificacao')
            ->setParameters([
                'codAssunto' => $swAssunto->getCodAssunto(),
                'codClassificacao' => $swAssunto->getCodClassificacao()
            ])
            ->getQuery()
        ;

        return $queryBuilder->getResult(ORM\AbstractQuery::HYDRATE_SIMPLEOBJECT);
    }
}
