<?php

namespace Urbem\CoreBundle\Repository\Organograma;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Organograma\VwOrgaoNivelView;
use Urbem\CoreBundle\Entity\Organograma\Orgao;

/**
 * @todo refatorar classe, tem muita coisa que não precisamos utilizar, e foi adicionado um método mais inteligente que pode nos ajudar muito.
 * Class OrgaoRepository
 * @package Urbem\CoreBundle\Repository\Organograma
 */
class OrgaoRepository extends ORM\EntityRepository
{
    public function getProximoValorByCodOrgao($codOrganograma, $codOrgao, $codNivel)
    {
        $niveis = $this->_em->getRepository('CoreBundle:Organograma\Nivel')
            ->findByCodOrganograma($codOrganograma, array('codNivel' => 'ASC'));
        $i = 0;
        foreach ($niveis as $nivel) {
            $i++;
            $listNiveis[$i] = $nivel;
            $orderNivel[$nivel->getCodNivel()] = $i;
        }
        $firstNivel = 1;

        $valorPai = array();
        for ($i=($orderNivel[$codNivel]-1); $i >= $firstNivel; $i--) {
            $nivel = $listNiveis[$i];
            $mascara = strlen($nivel->getMascaracodigo());
            $parameters = array(
                'codNivel' => $nivel->getCodNivel(),
                'codOrganograma' => $codOrganograma,
                'codOrgao' => $codOrgao
            );

            $order = $this->_em->getRepository('CoreBundle:Organograma\OrgaoNivel')
                ->findOneBy($parameters);

            $valorPai[] = str_pad($order->getValor(), $mascara, '0', STR_PAD_LEFT);
        }

        krsort($valorPai);

        $exp = implode('.', $valorPai);
        $exp .= '.';

        $sql = "SELECT regexp_replace(replace(orgao, :orgao, ''), '\.[\.0-9]*', '') as valor FROM organograma.vw_orgao_nivel where orgao like :orgaoLike and cod_organograma = :codOrganograma order by valor desc limit 1";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('orgao', $exp);
        $query->bindValue('orgaoLike', "{$exp}%");
        $query->bindValue('codOrganograma', $codOrganograma);
        $query->execute();
        $orgaoNivel = $query->fetchAll();
        $valor = array_shift($orgaoNivel);

        return (int) ($valor['valor'] +1);
    }

    /**
     * @param  $orgaoValues
     * @param  $codOrganograma
     * @return array
     */
    public function getCodOrgao(array $orgaoValues, $codOrganograma)
    {
        $sql = "SELECT cod_orgao FROM organograma.vw_orgao_nivel where orgao = :orgao AND cod_organograma = :codOrganograma";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codOrganograma', $codOrganograma);
        $query->bindValue('orgao', implode('.', $orgaoValues));
        $query->execute();

        $orgaoNivel = $query->fetchAll();

        return $orgaoNivel;
    }

    public function getInfoByCodOrgao($codOrgao)
    {
        $orgaoNiveis = $this->_em->getRepository('CoreBundle:Organograma\OrgaoNivel')
            ->findByCodOrgao($codOrgao, array('codNivel' => 'ASC'));

        $organograma = $this->_em->getRepository('CoreBundle:Organograma\Organograma')->findOneByCodOrganograma(current($orgaoNiveis)->getCodOrganograma());

        $info = ['organograma' => $organograma, 'nivel' => 0];
        $count = 0;
        $exp = [];
        foreach ($orgaoNiveis as $orgaoNivel) {
            if ($orgaoNivel->getValor() != '0') {
                $info = array(
                    'organograma' => $orgaoNivel->getFkOrganogramaNivel()->getFkOrganogramaOrganograma(),
                    'nivel' => $orgaoNivel->getFkOrganogramaNivel()
                );
                $mascara = strlen($orgaoNivel->getFkOrganogramaNivel()->getMascaracodigo());
                $exp[] = str_pad($orgaoNivel->getValor(), $mascara, '0', STR_PAD_LEFT);
                $count++;
            }
        }
        if (count($exp) != 1) {
            unset($exp[(count($exp) - 1)]);
            $exp = implode('.', $exp);
            $nivel = $count-1;
        } else {
            $exp = $exp[0];
            $nivel = 1;
        }

        $sql = "SELECT cod_orgao FROM organograma.vw_orgao_nivel where orgao like :orgao AND cod_organograma = " . $organograma->getCodOrganograma() . " AND nivel = " . $nivel;
        $query = $this->_em->getConnection()->prepare(sprintf($sql));
        $query->bindValue('orgao', "{$exp}%");

        $query->execute();
        $resultOrgao = $query->fetchAll();
        foreach ($resultOrgao as $value) {
            $orgao = $this->_em->getRepository('CoreBundle:Organograma\Orgao')
                ->find($value["cod_orgao"]);
            $info['orgaoSuperior'] = $orgao;
        }

        return $info;
    }

    public function getFilhoByCodOrgao($codOrgao)
    {
        $orgaoNiveis = $this->_em->getRepository('CoreBundle:Organograma\OrgaoNivel')
            ->findByCodOrgao($codOrgao, array('codNivel' => 'ASC'));

        $i = 0;
        foreach ($orgaoNiveis as $orgaoNivel) {
            if ($orgaoNivel->getValor() != '0') {
                $nivel = $orgaoNivel->getFkOrganogramaNivel();
                $organograma = $orgaoNivel->getCodOrganograma();
                $mascara = strlen($orgaoNivel->getFkOrganogramaNivel()->getMascaracodigo());
                $exp[] = str_pad($orgaoNivel->getValor(), $mascara, '0', STR_PAD_LEFT);
            }
            $i++;
            $orderNivel[$orgaoNivel->getCodNivel()] = $i;
        }
        if (count($exp) != 1) {
            $exp = implode('.', $exp);
        } else {
            $exp = $exp[0];
        }

        $sql = "SELECT cod_orgao FROM organograma.vw_orgao_nivel where inativacao is null AND orgao like :orgao AND cod_organograma = " . $organograma . " AND nivel = " . ($orderNivel[$nivel->getCodNivel()] + 1);
        $query = $this->_em->getConnection()->prepare(sprintf($sql));
        $query->bindValue('orgao', "{$exp}%");
        $query->execute();

        $orgaos = null;
        $codOrgao = $query->fetchAll();
        foreach ($codOrgao as $value) {
            $orgao = $this->_em->getRepository('CoreBundle:Organograma\Orgao')
                ->find($value['cod_orgao']);
            $orgaos[$value['cod_orgao']] = $orgao;
        }

        return $orgaos;
    }

    public function getFilhoByCodOrgaoCanRemove($codOrgao)
    {
        $orgaoNiveis = $this->_em->getRepository('CoreBundle:Organograma\OrgaoNivel')
            ->findByCodOrgao($codOrgao, array('codNivel' => 'ASC'));

        $i = 0;
        foreach ($orgaoNiveis as $orgaoNivel) {
            if ($orgaoNivel->getValor() != '0') {
                $nivel = $orgaoNivel->getFkOrganogramaNivel();
                $organograma = $orgaoNivel->getCodOrganograma();
                $mascara = strlen($orgaoNivel->getFkOrganogramaNivel()->getMascaracodigo());
                $exp[] = str_pad($orgaoNivel->getValor(), $mascara, '0', STR_PAD_LEFT);
            }
            $i++;
            $orderNivel[$orgaoNivel->getCodNivel()] = $i;
        }

        if (count($exp) != 1) {
            $exp = implode('.', $exp);
        } else {
            $exp = $exp[0];
        }

        $sql = "
        SELECT cod_orgao
        FROM organograma.vw_orgao_nivel
        WHERE orgao LIKE :orgao
          AND cod_organograma = :cod_organograma
          AND nivel = :nivel
        ";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('orgao', "{$exp}%");
        $query->bindValue('cod_organograma', $organograma);
        $query->bindValue('nivel', ($orderNivel[$nivel->getCodNivel()] + 1));

        $query->execute();

        $orgaos = null;
        $codOrgao = $query->fetchAll();
        foreach ($codOrgao as $value) {
            $orgao = $this->_em->getRepository('CoreBundle:Organograma\Orgao')
                ->find($value['cod_orgao']);
            $orgaos[$value['cod_orgao']] = $orgao;
        }

        return $orgaos;
    }

    /**
     * @TODO BLOCO REPETIDO =/
     * @param $codOrganograma
     * @param $codNivel
     * @return array
     */
    public function getOrgaosByCodNivel($codOrganograma, $codNivel, $codOrgao = null)
    {
        $codOrgaoQueryWhere = !empty($codOrgao) ? " AND orgao like '{$codOrgao}%'" : '';

        // Procura no organograma
        $sql = <<<SQL
  SELECT cod_orgao
  FROM organograma.vw_orgao_nivel
  WHERE cod_organograma = $codOrganograma
  AND nivel = $codNivel
  $codOrgaoQueryWhere
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        $orgaos = [];
        foreach ($query->fetchAll() as $value) {
            $orgao = $this->_em->getRepository('CoreBundle:Organograma\Orgao')->findOneByCodOrgao($value['cod_orgao']);
            $orgaos[$value['cod_orgao']] = $orgao;
        }

        return $orgaos;
    }

    public function getOrgaoSuperiorByCodNivel($codOrganograma, $codNivel)
    {
        $orgaos = [];

        // Procura um nível inferior ao meu no organograma
        $sql = sprintf(
            "SELECT cod_orgao FROM organograma.vw_orgao_nivel where cod_organograma = %s AND nivel = %s",
            (int) $codOrganograma,
            (int) ($codNivel)
        );
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        $codOrgao = $query->fetchAll();

        foreach ($codOrgao as $value) {
            $orgao = $this->_em->getRepository('CoreBundle:Organograma\Orgao')->findOneByCodOrgao($value['cod_orgao']);
            $orgaos[$value['cod_orgao']] = $orgao;
        }

        return $orgaos;
    }

    public function findSecretaria()
    {
        $sql = '
                SELECT * FROM (
                SELECT orgao.cod_orgao
                          , recuperaDescricaoOrgao(orgao.cod_orgao, now()::date) as descricao
                          , MAX(orgao_descricao.timestamp)
                          , orgao_nivel.cod_organograma
                          , organograma.fn_consulta_orgao(orgao_nivel.cod_organograma, orgao.cod_orgao) AS orgao
                           , publico.fn_mascarareduzida(organograma.fn_consulta_orgao( orgao_nivel.cod_organograma
                                                                                     , orgao.cod_orgao)) AS orgao_reduzido
                           , publico.fn_nivel(organograma.fn_consulta_orgao(orgao_nivel.cod_organograma, orgao.cod_orgao)) AS nivel
                           , orgao_nivel.cod_nivel
                           , orgao_nivel.valor
                        FROM organograma.orgao
                           , organograma.orgao_nivel
                           , organograma.orgao_descricao
                       WHERE orgao.cod_orgao = orgao_nivel.cod_orgao
                         AND orgao_descricao.cod_orgao = orgao.cod_orgao
                      GROUP BY orgao.cod_orgao
                             , orgao_nivel.cod_organograma
                             , orgao_nivel.cod_nivel
                             , orgao_nivel.valor
                      ) as tabela
                      WHERE  tabela.cod_organograma = 2 AND  tabela.cod_nivel = 2 AND  tabela.nivel = 2 AND  tabela.orgao like \'1%\'';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        /**
         * @TODO Tarefa incompleta, o @Elton estava trabalhando nisso parou no meio...
         * por ser tratar de um erro de PSR e não deveria estar na master, estamos lançando uma exception =/
         */
//        throw new \RuntimeException($query);
//        exit();

        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    public function getOrgaosOrganograma($codOrganograma)
    {
        $sql = "
        SELECT *
        FROM (
          SELECT orgao.cod_orgao
            , orgao_descricao.descricao
            , MAX(orgao_descricao.TIMESTAMP)
            , orgao_nivel.cod_organograma
            , publico.fn_nivel(organograma.fn_consulta_orgao(orgao_nivel.cod_organograma, orgao.cod_orgao)) AS nivel
            , organograma.fn_consulta_orgao(orgao_nivel.cod_organograma, orgao.cod_orgao) AS orgao
            , orgao_nivel.cod_nivel
            , orgao_nivel.valor
          FROM organograma.orgao
            , organograma.orgao_nivel
            , organograma.orgao_descricao
          WHERE orgao.cod_orgao = orgao_nivel.cod_orgao
            AND orgao_descricao.cod_orgao = orgao.cod_orgao
          GROUP BY orgao.cod_orgao
            , orgao_descricao.descricao
            , orgao_nivel.cod_organograma
            , orgao_nivel.cod_nivel
            , orgao_nivel.valor
          ) AS tabela
        WHERE tabela.cod_nivel = tabela.nivel
          AND tabela.cod_organograma = :cod_organograma
        ORDER BY tabela.cod_nivel
          , tabela.orgao
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cod_organograma', $codOrganograma);
        $query->execute();

        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @todo melhorar método, quebrar nas suas devidas responsabilidades, e melhorar legibilidade, extremamente útil na composição do organograma
     * @param $codOrgao
     * @param $codOrganograma
     * @param $codNivel
     * @return array
     */
    public function getOrgaosSuperiores($codOrgao, $codOrganograma, $codNivel)
    {
        $params = [
            "cod_orgao = {$codOrgao}",
            "cod_organograma = '{$codOrganograma}'",
            "nivel = '{$codNivel}'"
        ];
        $orgao = $this->findOrgaos($params);
        if (empty($orgao)) {
            return [];
        }

        $currentOrgao = current($orgao);
        $listSuperiores = ['nivel_' . $currentOrgao->nivel => $currentOrgao];
        if (!empty($currentOrgao)) {
            $superiores = explode(".", $currentOrgao->orgao_reduzido);
            array_pop($superiores);

            for ($t = count($superiores); $t > 0; $t--) {
                $itemAtual = implode(".", $superiores);
                // Faz a busca
                $params = [
                    "cod_organograma = {$codOrganograma}",
                    "orgao_reduzido = '{$itemAtual}'",
                    "cod_orgao <> {$codOrgao}",
                ];
                $orgao = current($this->findOrgaos($params));
                if (!$orgao) {
                    continue;
                }
                $listSuperiores['nivel_' . $orgao->nivel] = $orgao;

                // Recorta um item
                $superiores = explode(".", $itemAtual);
                array_pop($superiores);
            }
        }

        return $listSuperiores;
    }

    public function findOrgaoSuperior(VwOrgaoNivelView $vwOrgaoNivelView)
    {
        $superiores = explode(".", $vwOrgaoNivelView->getOrgaoReduzido());
        array_pop($superiores);

        $nivelSuperior = implode(".", $superiores);
        $params = [
            "cod_organograma = {$vwOrgaoNivelView->getCodOrganograma()}",
            "orgao_reduzido = '{$nivelSuperior}'",
            "cod_orgao < {$vwOrgaoNivelView->getCodOrgao()}",
        ];
        $orgaoSuperior = $this->findOrgaos($params);

        return !empty($orgaoSuperior) ? current($orgaoSuperior) : null;
    }

    /**
     * Efetua qualquer busca na view de órgão nível
     * @param array $paramsWhere
     * @param null $paramsExtra
     * @return array
     */
    public function findOrgaos(array $paramsWhere, $paramsExtra = null)
    {
        $sql = sprintf(
            "select * from organograma.vw_orgao_nivel WHERE %s",
            implode(" AND ", $paramsWhere)
        );
        $sql .= $paramsExtra ? " ".$paramsExtra : "";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Efetua qualquer busca na view de órgão nível
     * @param array $paramsWhere
     * @param null $paramsExtra
     * @return array
     */
    public function findOrgaosDePara(array $paramsWhere, $paramsExtra = null)
    {
        $sql = sprintf(
            "select * from organograma.vw_orgao_nivel o
              left join organograma.de_para_orgao n ON o.cod_orgao = n.cod_orgao AND o.cod_organograma = n.cod_organograma
               WHERE %s",
            implode(" AND ", $paramsWhere)
        );
        $sql .= $paramsExtra ? " ".$paramsExtra : "";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param array $paramsWhere
     * @param null $paramsExtra
     * @return mixed
     */
    public function findOneOrgao(array $paramsWhere, $paramsExtra = null)
    {
        return current($this->findOrgaos($paramsWhere, $paramsExtra));
    }

    /**
     * @param $vigencia
     * @param $codOrganograma
     * @return array
     */
    public function montaRecuperaOrgaos($vigencia, $codOrganograma)
    {
        $stSql  = "SELECT orgao_nivel.cod_estrutural
                 , recuperaDescricaoOrgao(orgao.cod_orgao,'".$vigencia."') as descricao
                 , orgao.cod_orgao
              FROM organograma.orgao
        INNER JOIN (SELECT orgao_nivel.*
                         , organograma.fn_consulta_orgao(orgao_nivel.cod_organograma, orgao_nivel.cod_orgao) AS cod_estrutural
                      FROM organograma.orgao_nivel) AS orgao_nivel
                ON orgao_nivel.cod_orgao = orgao.cod_orgao
               AND orgao_nivel.cod_nivel = publico.fn_nivel(cod_estrutural)
             WHERE (orgao.inativacao > '".$vigencia."' OR orgao.inativacao IS NULL) AND orgao_nivel.cod_organograma = $codOrganograma order by orgao_nivel.cod_estrutural;";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $term
     * @return ORM\QueryBuilder
     */
    public function getByTermAsQueryBuilder($term)
    {
        $qb = $this->createQueryBuilder('Orgao');
        $qb->join('Orgao.fkOrganogramaOrgaoDescricoes', 'OrganogramaOrgaoDescricao');

        $orx = $qb->expr()->orX();
        $orx->add($qb->expr()->like('lower(string(OrganogramaOrgaoDescricao.descricao))', ':term'));
        $orx->add($qb->expr()->like('string(Orgao.codOrgao)', ':term'));

        $qb->andWhere($orx);

        $qb->setParameter('term', sprintf('%%%s%%', strtolower($term)));

        $qb->orderBy('Orgao.codOrgao');
        $qb->setMaxResults(10);

        return $qb;
    }
}
