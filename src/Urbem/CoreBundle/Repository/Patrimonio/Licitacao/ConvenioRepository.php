<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Licitacao\Convenio;
use Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade;
use Urbem\CoreBundle\Helper\DatePK;

/**
 * Class ConvenioRepository
 * @package Urbem\CoreBundle\Repository\Licitacao
 */
class ConvenioRepository extends ORM\EntityRepository
{
    /**
     * @param Convenio $convenio
     * @param VeiculosPublicidade $veiculosPublicidade
     * @param DatePK $dtPublicacao
     * @return mixed
     */
    public function veiculoPublicidadeExiste(Convenio $convenio, VeiculosPublicidade $veiculosPublicidade, DatePK $dtPublicacao)
    {
        $sql = "
            SELECT *
            FROM licitacao.publicacao_convenio publicacao_convenio 
                JOIN licitacao.veiculos_publicidade veiculos_publicidade ON publicacao_convenio.numcgm = veiculos_publicidade.numcgm 
            WHERE publicacao_convenio.num_convenio = :num_convenio 
                AND publicacao_convenio.exercicio = :exercicio
                AND veiculos_publicidade.numcgm = :numcgm
                AND publicacao_convenio.dt_publicacao = :dt_publicacao;
        ";

        /** @var ORM\Query $query */
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('num_convenio', $convenio->getNumConvenio());
        $query->bindValue('exercicio', $convenio->getExercicio());
        $query->bindValue('numcgm', $veiculosPublicidade->getFkSwCgm()->getNumcgm());
        $query->bindValue('dt_publicacao', $dtPublicacao->format('Y-m-d'));

        $query->execute();

        return $query
            ->fetchAll(\PDO::FETCH_OBJ);
    }
}
