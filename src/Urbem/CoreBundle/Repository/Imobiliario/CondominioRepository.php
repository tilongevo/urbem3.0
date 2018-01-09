<?php

namespace Urbem\CoreBundle\Repository\Imobiliario;

use Urbem\CoreBundle\Repository\AbstractRepository;

class CondominioRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getNextVal()
    {
        return $this->nextVal("cod_condominio");
    }


    /**
     * @param $params
     * @return array
     */
    public function getCondominioByNomeAndCodigo($params)
    {
        $where = "";
        if (isset($params['nome']) && $params['nome'] != "") {
            $where .= ($where == "")
                ? sprintf(" WHERE UPPER( condominio.nom_condominio ) LIKE UPPER( '%%%s%%' )", strtoupper($params['nome']))
                    : sprintf(" AND UPPER( condominio.nom_condominio ) LIKE UPPER( '%%%s%%' )", strtoupper($params['nome']));
        }

        if (isset($params['condominioDe']) && $params['condominioDe'] != "") {
            $where .= ($where == "")
                ? sprintf(" WHERE condominio.cod_condominio BETWEEN %s AND %s", $params['condominioDe'], ($params['condominioAte']) ? $params['condominioAte'] : $params['condominioDe'])
                : sprintf(" AND condominio.cod_condominio BETWEEN %s AND %s", $params['condominioDe'], ($params['condominioAte']) ? $params['condominioAte'] : $params['condominioDe']);
        }

        $sql = "SELECT
                    condominio.nom_condominio,
                    condominio.cod_condominio,
                    tipo_condominio.cod_tipo,
                    tipo_condominio.nom_tipo
                FROM imobiliario.condominio
                INNER JOIN imobiliario.tipo_condominio
                ON  tipo_condominio.cod_tipo = condominio.cod_tipo  
              ".$where;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $params
     * @return array
     */
    public function getInformacoesCondominioByCodigo($codigoCondominio)
    {
        $sql = "select
                    imovel_condominio.inscricao_municipal,
                    (
                        select
                            proprietario.numcgm
                        from
                            imobiliario.proprietario
                        where
                            proprietario.inscricao_municipal = imovel_condominio.inscricao_municipal limit 1
                    ) as numcgm_proprietario,
                    (
                        select
                            (
                                select
                                    sw_cgm.nom_cgm
                                from
                                    sw_cgm
                                where
                                    sw_cgm.numcgm = proprietario.numcgm
                            )
                        from
                            imobiliario.proprietario
                        where
                            proprietario.inscricao_municipal = imovel_condominio.inscricao_municipal limit 1
                    ) as nomcgm_proprietario,
                    arrecadacao.fn_consulta_endereco_todos(
                        imovel_condominio.inscricao_municipal,
                        1,
                        1
                    ) as logradouro,
                    (
                        select
                            cod_lote
                        from
                            imobiliario.imovel_lote inner join(
                                select
                                    max( timestamp ) as timestamp,
                                    inscricao_municipal
                                from
                                    imobiliario.imovel_lote
                                group by
                                    inscricao_municipal
                            ) as tmp on
                            tmp.inscricao_municipal = imovel_lote.inscricao_municipal
                            and tmp.timestamp = imovel_lote.timestamp
                        where
                            imovel_lote.inscricao_municipal = imovel_condominio.inscricao_municipal
                    ) as cod_lote
                from
                    imobiliario.imovel_condominio where imovel_condominio.cod_condominio =". $codigoCondominio;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}
