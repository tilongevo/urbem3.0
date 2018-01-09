<?php

namespace Urbem\CoreBundle\Repository\Folhapagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class FeriasEventoRepository extends AbstractRepository
{
    /**
     * Retorna um evento por tipo e ordenado pelo timestamp mais recente
     * @param  array  $params
     * @return Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento
     */
    public function findOneEventoByCodTipo(array $params)
    {
        $query = $this->_em->createQueryBuilder();
        $query->select('fe');
        $query->from('CoreBundle:Folhapagamento\FeriasEvento', 'fe');
        $query->andWhere('fe.codTipo = :codTipo');
        $query->orderBy('fe.timestamp', 'DESC');
        $query->setMaxResults(1);

        $result = $query->getQuery()->execute($params);

        return reset($result);
    }
}
