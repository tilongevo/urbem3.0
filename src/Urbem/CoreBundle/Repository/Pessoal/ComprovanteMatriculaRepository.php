<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class ComprovanteMatriculaRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getNextCodComprovante()
    {
        return $this->nextVal('cod_comprovante');
    }
}
