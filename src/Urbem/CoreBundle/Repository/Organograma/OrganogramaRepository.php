<?php

namespace Urbem\CoreBundle\Repository\Organograma;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Organograma\Organograma;

class OrganogramaRepository extends ORM\EntityRepository
{
    public function getOrgaosOrganogramaByCodOrganograma($codOrganograma)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf(
                "SELECT cod_orgao, descricao FROM (
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
                      WHERE  tabela.cod_organograma = '%s' AND  tabela.cod_nivel = 1 AND  tabela.nivel = 1",
                $codOrganograma
            )
        );

        $query->execute();
        return $query->fetchAll();
    }

    public function getOrganogramaByCodOrganograma($codOrganograma)
    {
        $niveis = $this->_em->getRepository('CoreBundle:Organograma\Nivel')
            ->findByCodOrganograma($codOrganograma, array('codNivel' => 'ASC'));

        $organograma = '';
        $nivel = 2;
        $numNiveis = count($niveis);

        $sql = "SELECT cod_orgao, orgao, inativacao FROM organograma.vw_orgao_nivel where cod_organograma = " . $codOrganograma . " AND nivel = 1";
        $qry = $this->_em->getConnection()->prepare(sprintf($sql));
        $qry->execute();
        $rlt = $qry->fetchAll();
        foreach ($rlt as $info) {
            $orgao = $this->_em->getRepository('CoreBundle:Organograma\Orgao')
                ->find($info['cod_orgao']);
            $inativo = '';
            if ($info['inativacao'] != null) {
                $inativo = ' class="orgao-inativo"';
            }
            $exp = explode('.', $info['orgao']);
            $codigoComposto = $exp[0];

            $organograma .= '<ul class="nivel_1">';
            $organograma .= '<li' . $inativo . '><span class="orgao-codigo">' . $info['orgao'] . '</span> - <span class="orgao-titulo"> ' . $orgao->getFkOrganogramaOrgaoDescricoes()->last() . '</span></li>';
            $organograma .= $this->getSubNivelHtml($codOrganograma, $nivel, $codigoComposto, $numNiveis);
            $organograma .= '</ul>';
        }

        return $organograma;
    }

    public function getSubNivel($codOrganograma, $nivel, $codigoComposto, $numNiveis)
    {
        $sql = "SELECT cod_orgao, orgao, inativacao FROM organograma.vw_orgao_nivel where orgao like :orgao AND cod_organograma = " . $codOrganograma . " AND nivel = " . $nivel;
        $qry = $this->_em->getConnection()->prepare(sprintf($sql));
        $qry->bindValue('orgao', "{$codigoComposto}%");
        $qry->execute();
        $rlt = $qry->fetchAll();
        $organograma = [];
        foreach ($rlt as $info) {
            $organograma[$info['cod_orgao']] = [
                'codOrgao' => $info['cod_orgao'],
                'codigoComposto' => $info['orgao'],
                'inativacao' => $info['inativacao']
            ];
            if (($nivel + 1) <= $numNiveis) {
                $exp = explode('.', $info['orgao']);
                ($codigoComposto == '') ? $codigoComposto = $exp[($nivel - 1)] : $codigoComposto .= '.' . $exp[($nivel - 1)];
                $nivel++;
                $organograma[$info['cod_orgao']]['subOrgaos'] = $this->getSubNivel($codOrganograma, $nivel, $codigoComposto, $numNiveis);
            } else {
                $organograma[$info['cod_orgao']]['subOrgaos'] = array();
            }
        }
        return $organograma;
    }

    public function getSubNivelHtml($codOrganograma, $nivel, $codigoComposto, $numNiveis)
    {
        $sql = "SELECT cod_orgao, orgao, inativacao FROM organograma.vw_orgao_nivel where orgao like :orgao AND cod_organograma = " . $codOrganograma . " AND nivel = " . $nivel;
        $qry = $this->_em->getConnection()->prepare(sprintf($sql));
        $qry->bindValue('orgao', "{$codigoComposto}%");
        $qry->execute();
        $rlt = $qry->fetchAll();
        $html = '';
        foreach ($rlt as $info) {
            $orgao = $this->_em->getRepository('CoreBundle:Organograma\Orgao')
                ->find($info['cod_orgao']);
            $inativo = '';
            if ($info['inativacao'] != null) {
                $inativo = ' class="orgao-inativo"';
            }
            $subNivel = $nivel;
            $html .= '<ul class="nivel_2">';
            $html .= '<li' . $inativo . '><span class="orgao-codigo">' . $info['orgao'] . '</span> - <span class="orgao-titulo"> ' . $orgao->getFkOrganogramaOrgaoDescricoes()->last() . '</span></li>';
            if (($subNivel + 1) <= $numNiveis) {
                $exp = explode('.', $info['orgao']);
                (strpos($codigoComposto, '.001.001')) ? $codigoComposto = $exp[($nivel -3 )] .'.' .$exp[($nivel -2 )] .'.'. $exp[($nivel - 1)] : $codigoComposto .= '.' . $exp[($nivel - 1)];
                $subNivel++;
                $html .= $this->getSubNivelHtml($codOrganograma, $subNivel, $codigoComposto, $numNiveis);
            }
            $html .= '</ul>';
        }
        return $html;
    }

    /**
     * @param $codOrganograma
     * @param $codOrgao
     * @param $codNivel
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function listarOrgaosRelacionadosDescricaoComponente($codOrganograma, $codNivel, $codOrgao)
    {
        $sql = "
        SELECT * FROM (
             SELECT orgao.cod_orgao
                  , orgao_descricao.descricao
                  , MAX(orgao_descricao.timestamp)
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
             ) as tabela
             WHERE tabela.cod_nivel = tabela.nivel
             and tabela.cod_organograma = $codOrganograma";

        if ($codOrgao) {
            $sql .= " AND tabela.orgao like '".$codOrgao."%' ";
        }

        if ($codNivel) {
            $sql .= " AND tabela.cod_nivel = " .$codNivel;
        }

        $sql .= " ORDER BY tabela.cod_nivel, tabela.orgao;";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $codOrganograma
     * @param $codOrgao
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function consultaOrgao($codOrganograma, $codOrgao)
    {
        $sql = "
        SELECT
            publico.fn_mascarareduzida (organograma.fn_consulta_orgao (:codOrganograma,
                    :codOrgao)) AS orgao
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute([
            'codOrganograma' => $codOrganograma,
            'codOrgao' => $codOrgao
        ]);

        return $query->fetchAll();
    }

    /**
     * Recupera a descrição do orgão, função do sistema legado
     * @param  array   $params
     * @return \PDO::FETCH_OBJ
     */
    public function recuperaDescricaoOrgao(array $params)
    {
        $sql = "
        SELECT
            recuperaDescricaoOrgao (:inCodOrgao,
                :stData) AS descricao
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute($params);
        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findCanMigraOrganograma()
    {
        $query = $this->_em->getConnection()->prepare(
            "SELECT
                CASE WHEN count(1) = 0
                THEN 'true'
                ELSE 'false'
                END as finalizado
            FROM  organograma.de_para_orgao
                WHERE  de_para_orgao.cod_orgao_new IS null;"
        );

        $query->execute();
        return current($query->fetchAll());
    }

    /**
     * @TODO Mover para Configuracao Repository e criar metodo inteligente para isso, se possivel com base em entidade
     *
     * @param $exercicio
     *
     * @return bool|false
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findAtributeMigrationOrganograma($exercicio)
    {
        $sql = sprintf(
            "SELECT * FROM administracao.configuracao WHERE exercicio = '%s' AND cod_modulo = '%s' AND parametro = '%s' AND valor = '%s'",
            $exercicio,
            Modulo::MODULO_ORGANOGRAMA,
            'migra_orgao',
            'true'
        );
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        if (!$query->fetchAll()) {
            $sqlDelete = sprintf(
                "DELETE FROM administracao.configuracao WHERE exercicio = '%s' AND cod_modulo = '%s' AND parametro = '%s'",
                $exercicio,
                Modulo::MODULO_ORGANOGRAMA,
                'migra_orgao'
            );
            $sqlInsert = sprintf(
                "INSERT INTO administracao.configuracao VALUES ('%s', '%s', '%s', '%s')",
                $exercicio,
                Modulo::MODULO_ORGANOGRAMA,
                'migra_orgao',
                'true'
            );

            $query = $this->_em->getConnection()->prepare($sqlDelete);
            $query->execute();

            $query = $this->_em->getConnection()->prepare($sqlInsert);
            $query->execute();
        }

        return true;
    }

    /**
     * @param $currentUser
     *
     * @return bool|false
     * @throws \Doctrine\DBAL\DBALException
     */
    public function executeMigrationOrganograma(Organograma $organograma, Usuario $currentUser)
    {
        // Executa funcao no banco
        $query = $this->_em->getConnection()->prepare("select * FROM organograma.fn_migra_orgaos({$currentUser->getNumcgm()})");
        $query->execute();

        $migraOrgaos = current($query->fetchAll());

        if ($migraOrgaos['fn_migra_orgaos']) {
            // Desativa todos os organogramas
            $query = $this->_em->getConnection()->prepare("UPDATE organograma.organograma SET ativo = FALSE");
            $query->execute();

            // Ativa somente o atual
            $query = $this->_em->getConnection()->prepare("UPDATE organograma.organograma SET ativo = TRUE WHERE cod_organograma = {$organograma->getCodOrganograma()}");
            $query->execute();

            return true;
        }

        return false;
    }
}
