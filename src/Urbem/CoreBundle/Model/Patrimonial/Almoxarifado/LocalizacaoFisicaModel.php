<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\LocalizacaoFisica;

class LocalizacaoFisicaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager
            ->getRepository('CoreBundle:Almoxarifado\LocalizacaoFisica');
    }

    public function getRelatedCatalogoItemMarca(LocalizacaoFisica $localizacaoFisica)
    {
        $queryBuilder = $this->repository
            ->createQueryBuilder('lf')
            ->select('cim')
            ->where('lf.codLocalizacao = :codLocalizacao')
            ->leftJoin('CoreBundle:Almoxarifado\LocalizacaoFisicaItem', 'lfi', 'WITH', 'lf.codLocalizacao = lfi.codLocalizacao')
            ->leftJoin('CoreBundle:Almoxarifado\CatalogoItemMarca', 'cim', 'WITH', 'cim.codItem = lfi.codItem AND cim.codMarca = lfi.codMarca')
            ->setParameters(['codLocalizacao' => $localizacaoFisica->getCodLocalizacao()]);

        return $queryBuilder->getQuery()->getResult();
    }
}
