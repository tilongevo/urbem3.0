<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\SwDocumento;
use Urbem\CoreBundle\Entity\SwDocumentoProcesso;
use Urbem\CoreBundle\Entity\SwProcesso;

class SwDocumentoProcessoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:SwDocumentoProcesso');
    }

    /**
     * @param SwProcesso $swProcesso
     *
     * @return array
     */
    public function getDocumentosDoProcesso(SwProcesso $swProcesso)
    {
        $queryBuilder = $this->repository
            ->createQueryBuilder('dp')
            ->join('dp.fkSwProcesso', 'p')
            ->join('dp.fkSwCopiaDigitais', 'cd')
            ->where('p.codAssunto = :codAssunto')
            ->andWhere('p.codClassificacao = :codClassificacao')
            ->setParameters([
                'codAssunto' => $swProcesso->getCodAssunto(),
                'codClassificacao' => $swProcesso->getCodClassificacao()
            ])
            ->getQuery()
        ;

        return $queryBuilder->getResult();
    }

    /**
     * @param SwDocumento $swDocumento
     * @param SwProcesso  $swProcesso
     *
     * @return SwDocumentoProcesso
     */
    public function builOne(SwDocumento $swDocumento, SwProcesso $swProcesso)
    {
        $swDocumentoProcesso = (new SwDocumentoProcesso())
            ->setFkSwDocumento($swDocumento)
            ->setFkSwProcesso($swProcesso)
        ;

        return $swDocumentoProcesso;
    }
}
