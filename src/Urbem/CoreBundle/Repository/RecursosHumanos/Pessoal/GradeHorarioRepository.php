<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

class GradeHorarioRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getNextCodGrade()
    {
        return $this->nextVal('cod_grade');
    }
}
