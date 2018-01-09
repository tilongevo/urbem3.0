<?php

namespace Urbem\CoreBundle\Repository\Economico;

use Urbem\CoreBundle\Repository\AbstractRepository;
use Doctrine\ORM\EntityRepository;

/**
 * Class ServicoRepository
 * @package Urbem\CoreBundle\Repository\Tributario\Economico
 */
class ServicoRepository extends AbstractRepository
{

    /**
     * @param $params
     * @return array
     */
    public function getServicoByCodAndVigencia(array $params)
    {

        if ($params['ordenacao'] == 'descricao') {
            $orderBy = 'servico.nom_servico';
        } else {
            $orderBy = 'servico.cod_estrutural';
        }

        $where = "";

        if (isset($params['nomeServico']) && $params['nomeServico'] != "") {
            $where .= ($where == "")
                ? "WHERE servico.nom_servico LIKE '%" . $params['nomeServico'] . "%'"
                : " AND servico.nom_servico LIKE '%" . $params['nomeServico'] . "%'";
        }

        if (isset($params['servicoDe']) && $params['servicoDe'] != "") {
            if (isset($params['servicoAte']) && $params['servicoAte'] != "") {
                $where .= ($where == "")
                    ? sprintf("WHERE servico.cod_estrutural BETWEEN '" . $params['servicoDe'] . "' AND '" . $params['servicoAte'] . "' ")
                    : sprintf(" AND servico.cod_estrutural BETWEEN '" . $params['servicoDe'] . "' AND '" . $params['servicoAte'] . "' ");
            } else {
                $where .= ($where == "")
                    ? sprintf("WHERE servico.cod_estrutural = '" . $params['servicoDe'] . "' ")
                    : sprintf(" AND servico.cod_estrutural = '" . $params['servicoDe'] . "' ");
            }
        }

        if (isset($params['servicoAte']) && $params['servicoAte'] != "") {
            if (!(isset($params['servicoDe']) && $params['servicoDe'] != "")) {
                $where .= ($where == "")
                    ? sprintf("WHERE servico.cod_estrutural = '" . $params['servicoAte'] . "' ")
                    : sprintf(" AND servico.cod_estrutural = '" . $params['servicoAte'] . "' ");
            }
        }

        if (isset($params['vigenciaDe']) && $params['vigenciaDe'] != "") {
            if (isset($params['vigenciaAte']) && $params['vigenciaAte'] != "") {
                $where .= ($where == "")
                    ? sprintf("WHERE vigencia_servico.dt_inicio BETWEEN '" . $params['vigenciaDe'] . "' AND '" . $params['vigenciaAte'] . "' ")
                    : sprintf(" AND vigencia_servico.dt_inicio BETWEEN '" . $params['vigenciaDe'] . "' AND '" . $params['vigenciaAte'] . "' ");
            } else {
                $where .= ($where == "")
                    ? sprintf("WHERE vigencia_servico.dt_inicio = '" . $params['vigenciaDe'] . "' ")
                    : sprintf(" AND vigencia_servico.dt_inicio = '" . $params['vigenciaDe'] . "' ");
            }
        }

        if (isset($params['vigenciaAte']) && $params['vigenciaAte'] != "") {
            if (!(isset($params['vigenciaDe']) && $params['vigenciaDe'] != "")) {
                $where .= ($where == "")
                    ? sprintf("WHERE vigencia_servico.dt_inicio = '" . $params['vigenciaAte'] . "' ")
                    : sprintf(" AND vigencia_servico.dt_inicio = '" . $params['vigenciaAte'] . "' ");
            }
        }

        $sql = "SELECT servico.cod_estrutural
	             , servico.nom_servico
	             , aliquota_servico.valor AS aliquota
	             , to_char(vigencia_servico.dt_inicio, 'dd/mm/yyyy' ) AS vigencia
	         FROM economico.servico
             LEFT JOIN ( SELECT tmp1.*
                           FROM economico.aliquota_servico AS tmp1
                     INNER JOIN ( SELECT max(timestamp) AS timestamp
                                       , cod_servico
                                    FROM economico.aliquota_servico
                                GROUP BY cod_servico
                                )AS tmp2
                             ON tmp2.cod_servico = tmp1.cod_servico
                            AND tmp2.timestamp = tmp1.timestamp
                       )AS aliquota_servico
                    ON aliquota_servico.cod_servico = servico.cod_servico
            INNER JOIN ( SELECT cod_servico
                              , nivel_servico_valor.cod_vigencia
                           FROM economico.nivel_servico_valor
                     INNER JOIN economico.nivel_servico
                             ON nivel_servico.cod_nivel = nivel_servico_valor.cod_nivel
                            AND nivel_servico.cod_vigencia = nivel_servico_valor.cod_vigencia
                       GROUP BY cod_servico
                              , nivel_servico_valor.cod_vigencia
                       )AS nivel_servico
                    ON nivel_servico.cod_servico = servico.cod_servico
            INNER JOIN economico.vigencia_servico
	            ON vigencia_servico.cod_vigencia = nivel_servico.cod_vigencia ";

        $sql .= $where;
        $sql .= " ORDER BY $orderBy";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
