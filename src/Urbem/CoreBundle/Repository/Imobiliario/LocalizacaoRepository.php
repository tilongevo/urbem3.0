<?php

namespace Urbem\CoreBundle\Repository\Imobiliario;

use Doctrine\ORM;

class LocalizacaoRepository extends ORM\EntityRepository
{
    /**
     * @return array
     */
    public function getLocalizacoes()
    {
        $sql = "
            select
                l.cod_localizacao,
                l.nom_localizacao,
                l.codigo_composto
            from
                imobiliario.localizacao_nivel ln
            inner join
                imobiliario.localizacao l on ln.cod_localizacao = l.cod_localizacao
            where
                --ln.cod_vigencia = (select max(cod_vigencia) from imobiliario.vigencia where dt_inicio < CURRENT_DATE)
            --and
                (
                    select
                        max( cod_nivel )
                    from
                        imobiliario.localizacao_nivel
                    where
                        cod_localizacao = l.cod_localizacao
                        and cod_vigencia = ln.cod_vigencia
                        and(
                            valor != '0'
                            and valor != '00'
                        )
                ) = (select max(cod_nivel) from imobiliario.localizacao_nivel where cod_vigencia = ln.cod_vigencia);
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $codVigencia
     * @param $codNivel
     * @return array
     */
    public function getLocalizacaoByVigenciaNivel($codVigencia, $codNivel)
    {
        $sql = "
            select
                l.cod_localizacao,
                l.nom_localizacao,
                l.codigo_composto
            from
                imobiliario.localizacao l
            where
                (
                    select
                        max( cod_nivel )
                    from
                        imobiliario.localizacao_nivel
                    where
                        cod_localizacao = l.cod_localizacao
                        and cod_vigencia = :codVigencia
                        and(
                            valor != '0'
                            and valor != '00'
                        )
                ) = :codNivel;
        ";
        
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codVigencia', $codVigencia, \PDO::PARAM_INT);
        $query->bindValue('codNivel', $codNivel, \PDO::PARAM_INT);

        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $codVigencia
     * @param $codNivel
     * @param $valor1
     * @param null $valor2
     * @return bool|string
     */
    public function getLocalizacaoSuperior($codVigencia, $codNivel, $valor1, $valor2 = null)
    {
        $sql = "
            select
                cod_localizacao
            from
                imobiliario.localizacao_nivel
            where
                cod_nivel = :codNivel
                and cod_vigencia = :codVigencia
        ";
        if ($valor2) {
            $sql .= "and ((valor = :valor1) OR (valor = :valor2))";
        } else {
            $sql .= "and valor = :valor1";
        }


        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codVigencia', $codVigencia, \PDO::PARAM_INT);
        $query->bindValue('codNivel', $codNivel, \PDO::PARAM_INT);
        $query->bindValue('valor1', $valor1, \PDO::PARAM_STR);
        if ($valor2) {
            $query->bindValue('valor2', $valor2, \PDO::PARAM_STR);
        }

        $query->execute();
        return $query->fetchColumn(0);
    }

    /**
     * @param $codVigencia
     * @param $codLocalizacao
     * @param $codigoReduzido
     * @return array
     */
    public function getDependentes($codVigencia, $codLocalizacao, $codigoReduzido)
    {
        $sql = "
            select
                distinct l.*
            from
                imobiliario.localizacao l join imobiliario.localizacao_nivel n on
                l.cod_localizacao = n.cod_localizacao
            where
                l.codigo_composto like :codigoReduzido
                and l.cod_localizacao != :codLocalizacao
                and n.cod_vigencia = :codVigencia
        ";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codVigencia', $codVigencia, \PDO::PARAM_INT);
        $query->bindValue('codLocalizacao', $codLocalizacao, \PDO::PARAM_INT);
        $query->bindValue('codigoReduzido', $codigoReduzido . '%', \PDO::PARAM_STR);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}
