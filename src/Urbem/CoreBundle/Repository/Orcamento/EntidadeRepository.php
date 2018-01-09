<?php

namespace Urbem\CoreBundle\Repository\Orcamento;

use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\CoreBundle\Repository\Administracao\ConfiguracaoRepository;

/**
 * Class EntidadeRepository
 * @package Urbem\CoreBundle\Repository\Orcamento
 */
class EntidadeRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @param string $params
     * @return array
     */
    public function findEntidades($exercicio, $params = '')
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf(
                " SELECT
                     C.numcgm,
                     C.nom_cgm,
                     E.cod_entidade,
                     concat(E.cod_entidade, ' - ', C.nom_cgm) as entidade
                 FROM
                     orcamento.entidade      as   E,
                     sw_cgm                  as   C
                 WHERE
                     E.numcgm = C.numcgm
                  AND E.exercicio = '%s'
                  %s
                GROUP BY
                     C.numcgm,
                     C.nom_cgm,
                     E.cod_entidade
                ORDER BY
                     C.nom_cgm",
                $exercicio,
                $params
            )
        );

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function getEntidadeByCgmAndExercicio($exercicio)
    {
        $sql = "
            SELECT
                E.cod_entidade,                      
                C.nom_cgm                            
                FROM                                     
                orcamento.entidade      as   E,      
                sw_cgm                  as   C       
                WHERE                                    
                E.numcgm = C.numcgm AND              
                ( 
                    E.cod_entidade || '-' || exercicio in (
                        SELECT cod_entidade || '-' || exercicio  
                            FROM orcamento.usuario_entidade WHERE exercicio = '$exercicio'
                        )  OR E.exercicio < (
                            SELECT substring(valor,7,4) 
                                from administracao.configuracao 
                                where parametro ='data_implantacao' and exercicio= '$exercicio' and cod_modulo=9
                            )
                )  AND E.exercicio = '$exercicio' ORDER BY cod_entidade
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $exercicio
     * @param null $codEntidade
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getEntidadeByCgmAndExercicioQueryBuilder($exercicio, $codEntidade = null)
    {
        $qb = $this->createQueryBuilder('e');
        $qb->select('e, c');

        $qb->join('e.fkSwCgm', 'c');

        $qb->andWhere('e.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);
        if ($codEntidade) {
            $qb->andWhere('e.codEntidade = :codEntidade');
            $qb->setParameter('codEntidade', $codEntidade);
        }

        return $qb;
    }


    /**
     * @return array|bool
     */
    public function getDistinctExercicios()
    {
        $distinct = $this
            ->_em
            ->createQueryBuilder()
            ->addSelect('e.exercicio')
            ->from(Entidade::class, 'e')
            ->distinct(true)
            ->orderBy('e.exercicio', 'DESC')
            ->getQuery()
            ->getResult()
        ;

        if (!count($distinct)) {
            return false;
        }

        $exercicios = [];

        foreach ($distinct as $key => $exercicio) {
            $exercicios[$exercicio['exercicio']] = $exercicio['exercicio'];
        }

        return $exercicios;
    }

    /**
     * @return array
     */
    public function getResponsaveis()
    {
        $sql = 'SELECT
                  CGM.numcgm,
                  CGM.nom_cgm,
                  PF.cpf,
                  PJ.cnpj,
                  CASE
                    WHEN PF.cpf IS NOT NULL THEN PF.cpf
                    ELSE PJ.cnpj
                  END AS documento
                FROM SW_CGM AS CGM
                LEFT JOIN sw_cgm_pessoa_fisica AS PF
                  ON CGM.numcgm = PF.numcgm
                LEFT JOIN sw_cgm_pessoa_juridica AS PJ
                  ON CGM.numcgm = PJ.numcgm
                WHERE CGM.numcgm <> 0
                AND pf.numcgm IS NOT NULL
                ORDER BY LOWER(cgm.nom_cgm);';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * @return array
     */
    public function getResponsaveisTecnicos()
    {
        $sql = 'SELECT
                  CASE
                    WHEN rp.numcgm IS NOT NULL THEN rp.numcgm
                    WHEN re.numcgm IS NOT NULL THEN re.numcgm
                  END AS numcgm,
                  cgm.nom_cgm,
                  rp.cod_profissao,
                  rp.nom_profissao,
                  rp.num_registro,
                  rp.cod_uf,
                  rp.nom_registro,
                  rp.nom_uf
                FROM sw_cgm AS cgm
                LEFT JOIN (SELECT
                  rp.*,
                  p.nom_profissao,
                  c.nom_registro,
                  uf.nom_uf
                FROM economico.responsavel_tecnico AS rp,
                     cse.profissao AS p,
                     cse.conselho AS c,
                     sw_uf AS uf
                WHERE rp.cod_profissao ::varchar IN (SELECT
                  valor
                FROM administracao.configuracao
                WHERE parametro = \'cod_contador\'
                OR parametro = \'cod_tec_contabil\')
                AND rp.cod_profissao = p.cod_profissao
                AND p.cod_conselho = c.cod_conselho
                AND rp.cod_uf = uf.cod_uf) AS rp
                  ON rp.numcgm = cgm.numcgm
                LEFT JOIN (SELECT DISTINCT
                  numcgm,
                  sequencia
                FROM economico.responsavel_empresa) AS re
                  ON re.numcgm = cgm.numcgm
                WHERE (rp.numcgm = cgm.numcgm
                OR re.numcgm = cgm.numcgm)
                order by cgm.nom_cgm ASC;';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }


    /**
     * @return array
     */
    public function getEntidadesParaCadastro()
    {
        $sql = 'SELECT
                  CGM.numcgm,
                  CGM.nom_cgm
                FROM SW_CGM AS CGM
                LEFT JOIN sw_cgm_pessoa_fisica AS PF
                  ON CGM.numcgm = PF.numcgm
                LEFT JOIN sw_cgm_pessoa_juridica AS PJ
                  ON CGM.numcgm = PJ.numcgm
                WHERE CGM.numcgm <> 0
                AND pj.numcgm IS NOT NULL
                ORDER BY LOWER(cgm.nom_cgm)';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return int
     */
    public function getNextEntidadeCod()
    {
        return $this->nextVal('cod_entidade');
    }

    /**
     * @param $codEntidade
     * @param $exercicio
     * @return bool
     */
    public function removeUsuariosEntidade($codEntidade, $exercicio)
    {
        $sql = 'DELETE FROM orcamento.usuario_entidade ue WHERE ue.exercicio = :exercicio AND ue.cod_entidade = :cod_entidade';
        $query = $this->_em
            ->getConnection()
            ->prepare($sql);
        $query->bindParam('exercicio', $exercicio, \PDO::PARAM_INT);
        $query->bindParam('cod_entidade', $codEntidade, \PDO::PARAM_INT);

        return $query->execute();
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function getUsuariosDisponiveis($exercicio)
    {
        $sql = "SELECT
                  U.*,
                  C.nom_cgm
                FROM administracao.usuario AS U,
                     sw_cgm AS C
                WHERE U.numcgm = C.numcgm
                AND NOT EXISTS (SELECT
                  1
                FROM orcamento.usuario_entidade oue
                WHERE oue.numcgm = U.numcgm
                AND oue.cod_entidade = 7
                AND oue.exercicio = '{$exercicio}')
                ORDER BY C.nom_cgm";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param Entidade $entidade
     */
    public function getUsuariosSelecionados(Entidade $entidade)
    {
        $exercicio = !empty($entidade->getExercicio())
            ? " AND ue.exercicio = '{$entidade->getExercicio()}' "
            : ''
        ;
        $sql = 'SELECT
                    ue.numcgm AS numcgm,
                    cgm.nom_cgm AS nom_cgm
                FROM orcamento.usuario_entidade ue
                left join public.sw_cgm AS cgm
                on ue.numcgm=cgm.numcgm
                WHERE ue.cod_entidade = ' . $entidade->getCodEntidade()
            . $exercicio;

        // @TODO Implement in a proper way
    }


    /**
     * @param $exercicio
     * @return array
     */
    public function getAllEntidades($exercicio)
    {
        $sql = "SELECT
                  E.*,
                  CGM.numcgm,
                  CGM.nom_cgm
                FROM orcamento.entidade AS E,
                     sw_cgm AS CGM
                WHERE E.numcgm = CGM.numcgm
                AND exercicio = '{$exercicio}'
                ORDER BY cod_entidade";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string $exercicio
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findAllByExercicioAsQueryBuilder($exercicio)
    {
        return $this->createQueryBuilder('e')->andWhere('e.exercicio = :e')->setParameter('e', $exercicio);
    }

    /**
     * @param $exercicio
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function withExercicioQueryBuilder($exercicio)
    {
        $qb = $this->createQueryBuilder('e');
        $qb->select('e, fkOrcamentoEntidadeLogotipo, fkTcemgConfiguracaoReglic, fkTcemgOperacaoCreditoAro, fkTcmgoConfiguracaoIde');
        $qb->leftJoin('e.fkOrcamentoEntidadeLogotipo', 'fkOrcamentoEntidadeLogotipo');
        $qb->leftJoin('e.fkTcemgConfiguracaoReglic', 'fkTcemgConfiguracaoReglic');
        $qb->leftJoin('e.fkTcemgOperacaoCreditoAro', 'fkTcemgOperacaoCreditoAro');
        $qb->leftJoin('e.fkTcmgoConfiguracaoIde', 'fkTcmgoConfiguracaoIde');
        $qb->where('e.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);
        $qb->orderBy('e.sequencia', 'ASC');

        return $qb;
    }

    /**
     * @param $exercicio
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function withRpsExercicioQueryBuilder($exercicio)
    {
        $codModulo = Modulo::MODULO_ORCAMENTO;
        $sql = "SELECT valor FROM administracao.configuracao c
                  WHERE exercicio = '{$exercicio}'
                  AND cod_modulo = '{$codModulo}'
                  AND parametro = 'cod_entidade_rpps' limit 1";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $codEntidade = $query->fetchColumn(0);

        return $this->createQueryBuilder('e')
            ->andWhere('e.exercicio = :e')
            ->andWhere('e.codEntidade = :codEntidade')
            ->setParameter('e', $exercicio)
            ->setParameter('codEntidade', !empty($codEntidade) ? $codEntidade : 0);
    }

    public function getCnpjByCodEntidade($codEntidade, $financialYear)
    {
        $sql = "SELECT sw.cnpj AS cnpj
                  FROM orcamento.entidade AS e
                  JOIN public.sw_cgm_pessoa_juridica AS sw ON sw.numcgm = e.numcgm
                  WHERE e.exercicio = :exercicio
                  AND e.cod_entidade = :codEntidade";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindParam('exercicio', $financialYear);
        $query->bindParam('codEntidade', $codEntidade);
        $query->execute();

        return $query->fetch();
    }

    /**
     * @param $key
     * @return null|object
     */
    public function getByKey($key)
    {
        $key = explode('~', $key);

        if (2 !== count($key)) {
            return null;
        }

        list ($exercicio, $codEntidade) = $key;

        return $this->findOneBy([
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade
        ]);
    }

    /**
     * gestaoFinanceira/fontes/PHP/orcamento/classes/componentes/ITextBoxSelectEntidadeUsuario.class.php:82
     * gestaoFinanceira/fontes/PHP/orcamento/classes/negocio/ROrcamentoEntidade.class.php:750
     * gestaoFinanceira/fontes/PHP/orcamento/classes/mapeamento/TOrcamentoEntidade.class.php:363
     *
     * @param $exercicio
     * @param SwCgm $swCgm
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getByExercicioAndSwCgmAsQueryBuilder($exercicio, SwCgm $swCgm)
    {
        /** @var ConfiguracaoRepository $repo */
        $repo = $this->_em->getRepository(Configuracao::class);

        $value = $repo->pegaConfiguracao(
            Configuracao::PARAMETRO_DATA_IMPLANTACAO,
            Modulo::MODULO_CONTABILIDADE,
            true,
            $exercicio
        );

        $value = substr($value, 6, 4);

        $qb = $this->createQueryBuilder('Entidade');
        $qb->join('Entidade.fkOrcamentoUsuarioEntidades', 'UsuarioEntidade');

        $expr = $qb->expr();

        $andX = $expr->andX(
            $expr->eq('UsuarioEntidade.numcgm', ':numcgm'),
            $expr->eq('UsuarioEntidade.exercicio', ':exercicio')
        );

        $orx = $expr->orX();
        $orx->add($andX);
        $orx->add($expr->andX('Entidade.exercicio < :value'));

        $qb->andWhere($orx);
        $qb->andWhere('Entidade.exercicio = :exercicio');

        $qb->setParameter('value', $value);
        $qb->setParameter('numcgm', $swCgm->getNumcgm());
        $qb->setParameter('exercicio', $exercicio);

        $qb->addGroupBy('Entidade.exercicio');
        $qb->addGroupBy('Entidade.codEntidade');

        $qb->orderBy('Entidade.codEntidade', 'ASC');

        return $qb;
    }
}
