<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoContaHistorico;
use Urbem\CoreBundle\Helper\DateTimeIdHelper;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;

class PlanoContaModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;
    const COD_CLASSIFICACAO = 4;
    const TYPE_LIQUIDACAO = 'liquidacao';
    const TYPE_ALMOXARIFADO = 'almoxarifado';

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Contabilidade\\PlanoConta");
    }

    public function canRemove($object)
    {
    }

    public function findPlanoContaByExercicioAndMascara($exercicio, $mascara)
    {
        return $this->repository->findPlanoContaByExercicioAndMascara($exercicio, $mascara);
    }

    public function findByCodConta($id)
    {
        return $this->repository->findByCodConta($id);
    }

    public function getPlanoContaByExercicioAndEntidadeAndCodEstrutura($exercicio, $codEntidade, $codEstrutural)
    {
        return $this->repository->getPlanoContaByExercicioAndEntidadeAndCodEstrutura($exercicio, $codEntidade, $codEstrutural);
    }

    public function filterPlanoConta($filter)
    {
        $sql = "
        select
            pa.cod_plano,
            pc.cod_estrutural,
            pc.nom_conta,
            pc.cod_conta,
            publico.fn_mascarareduzida(pc.cod_estrutural) as cod_reduzido,
            pc.cod_classificacao,
            pc.cod_sistema,
            pb.exercicio,
            pb.cod_banco,
            pb.cod_agencia,
            pb.conta_corrente,
            pb.cod_conta_corrente,
            mb.num_banco,
            ma.num_agencia,
            pa.natureza_saldo,
            pc.atributo_tcepe,
            pc.atributo_tcemg,
            case
                when publico.fn_nivel(cod_estrutural)> 4 then 5
                else publico.fn_nivel(cod_estrutural)
            end as nivel,
            rec.cod_recurso
        from
            contabilidade.plano_conta as pc left join contabilidade.plano_conta_encerrada on
            plano_conta_encerrada.cod_conta = pc.cod_conta
            and plano_conta_encerrada.exercicio = pc.exercicio left join contabilidade.plano_analitica as pa on
            pc.cod_conta = pa.cod_conta
            and pc.exercicio = pa.exercicio left join contabilidade.plano_recurso as pr on
            pr.cod_plano = pa.cod_plano
            and pr.exercicio = pa.exercicio left join orcamento.recurso as rec on
            rec.cod_recurso = pr.cod_recurso
            and rec.exercicio = pr.exercicio left join contabilidade.plano_banco as pb on
            pb.cod_plano = pa.cod_plano
            and pb.exercicio = pa.exercicio left join monetario.banco as mb on
            pb.cod_banco = mb.cod_banco left join monetario.agencia as ma on
            pb.cod_agencia = ma.cod_agencia
            and pb.cod_banco = ma.cod_banco
        where 1 = 1 ";

        if (isset($filter['codReduzido'])) {
            if ($filter['codReduzido']['value'] !== "") {
                $sql .= " AND pa.cod_plano = :cod_plano";
            }
        }
        if (isset($filter['banco'])) {
            if ($filter['banco']['value'] !== "") {
                $sql .= " AND PB.cod_banco = :cod_banco";
            }
        }
        if (isset($filter['agencia'])) {
            if ($filter['agencia']['value'] !== "") {
                $sql .= " AND PB.cod_agencia = :cod_agencia";
            }
        }

        if (isset($filter['contaCorrente'])) {
            if (isset($filter['contaCorrente']['value']) && $filter['contaCorrente']['value'] !== "") {
                $sql .= " AND PB.conta_corrente = :conta_corrente";
            }
        }
        if (isset($filter['recurso'])) {
            if ($filter['recurso']['value'] !== "") {
                $sql .= " AND PR.cod_recurso = :cod_recurso";
            }
        }

        $sql .= " order by cod_estrutural";

        $query = $this->entityManager->getConnection()->prepare($sql);

        if (isset($filter['codReduzido'])) {
            if ($filter['codReduzido']['value'] !== "") {
                $query->bindValue(':cod_plano', $filter['codReduzido']['value'], \PDO::PARAM_INT);
            }
        }

        if (isset($filter['banco'])) {
            if ($filter['banco']['value'] !== "") {
                $query->bindValue(':cod_banco', $filter['banco']['value'], \PDO::PARAM_STR);
            }
        }
        if (isset($filter['agencia'])) {
            if ($filter['agencia']['value'] !== "") {
                $query->bindValue(':cod_agencia', $filter['agencia']['value'], \PDO::PARAM_INT);
            }
        }
        if (isset($filter['contaCorrente'])) {
            if ($filter['contaCorrente']['value'] !== "") {
                $filter['contaCorrente']['value'] = explode('/', $filter['contaCorrente']['value'])[1];
                $query->bindValue(':conta_corrente', $filter['contaCorrente']['value'], \PDO::PARAM_STR);
            }
        }
        if (isset($filter['recurso'])) {
            if ($filter['recurso']['value'] !== "") {
                $filter['recurso']['value'] = explode('-', $filter['recurso']['value'])[0];
                $query->bindValue(':cod_recurso', $filter['recurso']['value'], \PDO::PARAM_INT);
            }
        }

        $query->execute();

        $res = $query->fetchAll(\PDO::FETCH_OBJ);

        return $res;
    }

    public function getVersoesPlanoContaGeralDisponiveis($exercicio)
    {
        $sql = '
          SELECT    uf.cod_uf, pcg.versao, pcg.cod_plano,
                    CASE WHEN uf.cod_uf = 0 THEN \'União\' ELSE uf.sigla_uf END AS sigla_uf
            FROM    contabilidade.plano_conta_geral pcg
            JOIN    sw_uf uf ON uf.cod_uf = pcg.cod_uf
            JOIN    administracao.configuracao c ON CAST(c.valor AS integer) = CAST(uf.cod_uf as integer) AND c.parametro = \'cod_uf\' AND c.cod_modulo = 2 and c.exercicio = :exercicio
        GROUP BY    uf.nom_uf, uf.cod_uf, uf.sigla_uf, pcg.versao, pcg.cod_plano
        ORDER BY    pcg.cod_plano DESC';

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindParam(':exercicio', $exercicio, \PDO::PARAM_STR);
        $query->execute();

        $result = [];

        foreach ($query->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            if (false === array_key_exists($row['sigla_uf'], $result)) {
                $result[$row['sigla_uf']] = [];
            }

            $key = sprintf('%s~%s~%s', $row['cod_uf'], $row['cod_plano'], $exercicio);

            $result[$row['sigla_uf']][$key] = new \ArrayObject(['key' => $key, 'versao' => $row['versao']]);
        }

        return $result;
    }

    public function savePlanoContaGeral(\ArrayObject $data)
    {
        $data = explode('~', $data['key']);

        if (3 !== count($data)) {
            throw new \Exception('Informe cod_uf, cod_plano e exercicio');
        }

        $codUf = (int) $data['0'];
        $codPlano = (int) $data[1];
        $exercicio = $data[2];

        if (0 > $codUf || 0 > $codPlano || 0 > $exercicio) {
            throw new \Exception('Informe cod_uf, cod_plano e exercicio');
        }

        $configuracao = new ConfiguracaoModel($this->entityManager);

        if ($codUf !== $currentUf = (int) $configuracao->pegaConfiguracao('cod_uf', 2, $exercicio, true)) {
            throw new \Exception(sprintf('O estado do plano de contas não pode ser alterado. Selecione uma versão do plano de contas do Estado %s', $currentUf));
        }

        $historico = $this->getUltimoPlanoContaGeral($exercicio);

        if ('' !== $historico['cod_plano']) {
            if ($codUf === $historico['cod_uf'] && $codPlano === $historico['cod_plano'] && $exercicio == $historico['exercicio']) {
                throw new \Exception('Plano escolhido já é o plano atual.');
            }

            if ($codUf === $historico['cod_uf'] && $codPlano < $historico['cod_plano'] && $exercicio == $historico['exercicio']) {
                throw new \Exception('Não é possível escolher uma versão anterior a atual.');
            }
        }

        if (null === $configuracao->pegaConfiguracao('masc_plano_contas', 9, $exercicio, true)) {
            throw new \Exception('Para escolher o plano é necessário que a versão da virada tenha sido aplicada!');
        }

        $planoContaHistorico = new PlanoContaHistorico();
        $planoContaHistorico->setExercicio($exercicio);
        $planoContaHistorico->setCodPlano($codPlano);
        $planoContaHistorico->setTimestamp(new DateTimeMicrosecondPK());
        $planoContaHistorico->setCodUf($codUf);

        $this->entityManager->persist($planoContaHistorico);
        $this->entityManager->flush($planoContaHistorico);

        (new SistemaContabilModel($this->entityManager))->replicarSistemaContabeis($exercicio);
        (new ClassificacaoContabilModel($this->entityManager))->replicarClassificacaoContabeis($exercicio);
    }

    public function getUltimoPlanoContaGeral($exercicio)
    {
        $sql = '
            SELECT  CASE WHEN uf.cod_uf = 0 THEN \'União\' ELSE uf.nom_uf END AS nom_uf, pcg.versao, pch.cod_plano, pch.cod_uf
              FROM  contabilidade.plano_conta_historico pch
              JOIN  contabilidade.plano_conta_geral pcg ON pcg.cod_uf = pch.cod_uf AND pcg.cod_plano = pch.cod_plano 
              JOIN  sw_uf uf ON uf.cod_uf = pch.cod_uf 
             WHERE  pch.timestamp = (SELECT MAX(plano_conta_historico.timestamp) FROM contabilidade.plano_conta_historico)
               AND  pch.exercicio = :exercicio
             LIMIT  1
        ';

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindParam(':exercicio', $exercicio, \PDO::PARAM_STR);
        $query->execute();

        $row = $query->fetchAll(\PDO::FETCH_ASSOC);

        $result = ['versao' => '', 'exercicio' => '', 'cod_plano' => '', 'key' => ''];

        if (0 < count($row)) {
            $row = reset($row);

            $result['versao'] = sprintf('%s - %s', $row['nom_uf'], $row['versao']);
            $result['exercicio'] = $exercicio;
            $result['cod_plano'] = (int) $row['cod_plano'];
            $result['cod_uf'] = (int) $row['cod_uf'];
            $result['key'] = sprintf('%s~%s~%s', $row['cod_uf'], $row['cod_plano'], $exercicio);
        }

        return $result;
    }

    public function getContasExtra(array $paramsWhere, $exercicio, $tipoConta = "arrecadacao_extra")
    {
        $tipoEstrutural = "4.5.%";
        if ($tipoConta == "pagamento_extra") {
            $tipoEstrutural = "3.5.%";
        }
        if ($exercicio > '2012') {
            $paramsWhere[] = "( pc.cod_estrutural like '1.1.2.%'
                                    OR pc.cod_estrutural like '1.1.3.%'
                                    OR pc.cod_estrutural like '1.1.4.9.%'
                                    OR pc.cod_estrutural like '1.2.1.%'
                                    OR pc.cod_estrutural like '2.1.1.%'
                                    OR pc.cod_estrutural like '2.1.2.%'
                                    OR pc.cod_estrutural like '2.1.8.%'
                                    OR pc.cod_estrutural like '2.1.9.%'
                                    OR pc.cod_estrutural like '2.2.1.%'
                                    OR pc.cod_estrutural like '2.2.2.%'
                                    OR pc.cod_estrutural like '{$tipoEstrutural}' )";
        } else {
            $paramsWhere[] = "( pc.cod_estrutural like '1.1.2.%'
                                    OR pc.cod_estrutural like '2.1.1.%'
                                    OR pc.cod_estrutural like '5%'
                                    OR pc.cod_estrutural like '6%' )";
        }
        $paramsWhere[] = "pa.cod_plano is not null";

        return $this->repository->findContasArrecadacaoExtraReceita($paramsWhere);
    }

    public function insertLancamento($exercicio, $codPlanoDebito, $codPlanoCredito, $codEstruturalDebito, $codEstruturalCredito, $vlLancamento, $codLote, $codEntidade, $codHistorico, $tipo, $complemento)
    {
        return $this->repository->insertLancamento($exercicio, $codPlanoDebito, $codPlanoCredito, $codEstruturalDebito, $codEstruturalCredito, $vlLancamento, $codLote, $codEntidade, $codHistorico, $tipo, $complemento);
    }

    /**
     * @param $exercicio
     * @param $codPlano
     * @param $numCgm
     * @return mixed
     */
    public function getPlanoContaSaldoPorEntidade($exercicio, $codPlano, $numCgm)
    {
        return $this->repository->getPlanoContaSaldoPorEntidade($exercicio, $codPlano, $numCgm);
    }

    /**
     * @param $exercicio
     * @param $nomeConta
     * @return mixed
     */
    public function getPlanoContaByExercicioAndCodReduzidoAndCodEstrutural($exercicio, $nomeConta, $like)
    {
        return $this->repository->getPlanoContaByExercicioAndCodEstruturalAndCodReduzido($exercicio, $nomeConta, $like);
    }

    /**
     * @param $codAcao
     * @return mixed
     */
    public function getNumCgmPorCodAcao($codAcao)
    {
        return $this->repository->getNumCgmPorCodAcao($codAcao);
    }

    /**
     * @param $exercicio
     * @param $nomeConta
     * @return mixed
     */
    public function getPlanoContabyNomeContaAndExercicioReceita($exercicio, $nomeConta)
    {
        return $this->repository->getPlanoContabyNomeContaAndExercicio($exercicio, $nomeConta, true);
    }

    /**
     * @param $exercicio
     * @param $nomeConta
     * @return mixed
     */
    public function getPlanoContabyNomeContaAndExercicioBanco($exercicio, $nomeConta)
    {
        return $this->repository->getPlanoContabyNomeContaAndExercicio($exercicio, $nomeConta, false);
    }

    /**
     * @param $exercicio
     * @param $codEstrutural
     * @return mixed
     */
    public function verificaContaDesdobrada($exercicio, $codEstrutural)
    {
        return $this->repository->verificaContaDesdobrada($exercicio, $codEstrutural);
    }

    /**
     * @param $exercicio
     * @param $codEstrutural
     * @return mixed
     */
    public function verificaMovimentacaoConta($exercicio, $codEstrutural)
    {
        return $this->repository->verificaMovimentacaoConta($exercicio, $codEstrutural);
    }

    /**
     * @param $codEstrutural
     * @param $exercicio
     * @param $modulo
     * @return mixed
     */
    public function verificaLancamentosEmConta($codEstrutural, $exercicio, $modulo)
    {
        return $this->repository->verificaLancamentosEmConta($codEstrutural, $exercicio, $modulo);
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function getGrupoContasChoiceType($exercicio)
    {
        $choices = [];
        $result = $this->repository->findGrupoContas($exercicio);

        foreach ($result as $grupoConta) {
            $key = $grupoConta['cod_grupo'] . " - " . $grupoConta['nom_conta']; ;
            $choices[$key] = $grupoConta['cod_grupo'];
        }

        return $choices;
    }
}
