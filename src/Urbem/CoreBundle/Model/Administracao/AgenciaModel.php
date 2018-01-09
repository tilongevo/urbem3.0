<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class AgenciaModel extends AbstractModel
{
    protected $entityManager = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAgencias()
    {
        $sql = "
        SELECT a.*,
               b.*,
               nom_banco
               || ' - '
               || nom_agencia AS banco_agencia
        FROM   administracao.agencia a
               inner join administracao.banco b
                       ON a.cod_banco = b.cod_banco
        ORDER  BY nom_banco,
                  nom_agencia;";

        $query = $this->entityManager->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }
}
