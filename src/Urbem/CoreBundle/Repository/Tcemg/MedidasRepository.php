<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Entity\Tcemg\Medidas;
use Urbem\CoreBundle\Repository\AbstractRepository;

class MedidasRepository extends AbstractRepository
{
    public function getAll()
    {
        return $this->findBy([], ['codMedida' => 'ASC']);
    }

    /**
     * @param array|Medidas $medidas
     */
    public function deleteExcept(array $medidas)
    {
        $codMedidas = [];

        foreach ($medidas as $medida) {
            $codMedidas[] = $medida->getCodMedida();
        }

        $codMedidas = array_filter($codMedidas);

        $qb = $this->createQueryBuilder('Medidas');
        $qb->delete(Medidas::class, 'Medidas');

        if (0 < count($codMedidas)) {
            $qb->andWhere($qb->expr()->notIn('Medidas.codMedida', $codMedidas));
        }

        $qb->getQuery()->execute();
    }
}
