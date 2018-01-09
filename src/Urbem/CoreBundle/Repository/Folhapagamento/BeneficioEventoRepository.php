<?php

namespace Urbem\CoreBundle\Repository\Folhapagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class BeneficioEventoRepository extends AbstractRepository
{
    public function getConfiguracaoBeneficioPlanoSaude(array $params)
    {
        $query = $this->_em->createQueryBuilder();
        $query->select('be');
        $query->from('CoreBundle:Folhapagamento\BeneficioEvento', 'be');
        $query->andWhere('be.codTipo = 2');
        $query->andWhere('be.timestamp = :timestamp');
        
        return $query->getQuery()->execute($params);
    }
}
