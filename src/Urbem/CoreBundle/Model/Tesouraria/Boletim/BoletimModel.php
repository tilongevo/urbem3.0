<?php

namespace Urbem\CoreBundle\Model\Tesouraria\Boletim;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Contabilidade\LancamentoReceita;
use Urbem\CoreBundle\Entity\Contabilidade\Lote;
use Urbem\CoreBundle\Entity\Tesouraria\Abertura;
use Urbem\CoreBundle\Entity\Tesouraria\BoletimFechado;
use Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberado;
use Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoCancelado;
use Urbem\CoreBundle\Entity\Tesouraria\BoletimLiberadoLote;
use Urbem\CoreBundle\Entity\Tesouraria\BoletimReaberto;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Repository\Financeiro\Tesouraria\BoletimRepository;

/**
 * Class BoletimModel
 * @package Urbem\CoreBundle\Model\Tesouraria\Boletim
 */
class BoletimModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var BoletimRepository|null  */
    protected $repository = null;

    /**
     * BoletimModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:Tesouraria\\Boletim');
    }

    public function getRepository()
    {
        return $this->repository;
    }

    public function findOneBy($formRequest)
    {
        return $this->repository->findOneBy($formRequest);
    }

    public function getBoletins(array $params)
    {
        return $this->repository->findBoletins($params);
    }

    /**
     * Restorna a lista de arrecadacoes
     *
     * @param $retencao
     * @param null $boletim
     * @return null
     */
    public function listarArrecadacao($retencao, $boletim = null)
    {
        $retorno = null;
        if ($retencao) {
            $retorno = $this->repository->listaArrecadacaoSeRetencao();
        } else {
            //se a lista não existir, vai executar uma query para criar a lista
            $filtro = "";
            if ($boletim->getExercicio()) {
                $filtro .= " AND TB.exercicio = '{$boletim->getExercicio()}'::varchar ";
            }
            if ($boletim->getCodBoletim()) {
                $filtro .= " AND TB.cod_boletim = {$boletim->getCodBoletim()} ";
            }
            if ($boletim->getDtBoletim()) {
                $filtro .= " AND TB.dt_boletim = TO_DATE( '{$boletim->getDtBoletim()->format('d/m/Y')}', 'dd/mm/yyyy' ) ";
            }
            if ($boletim->getCodEntidade()) {
                $filtro .= " AND TB.cod_entidade IN( {$boletim->getCodEntidade()} ) ";
            }
            $retorno = $this->repository->listaArrecadacaoSeNaoRetencao($filtro);
        }
        return $retorno;
    }

    /**
     * Prepara o objeto Boletim para ser persistido no banco de dados
     *
     * @param $boletim
     * @param $exercicio
     * @param $terminal
     * @param $userId
     * @return mixed
     */
    public function dadosBoletim($boletim, $exercicio, $terminal, $userId)
    {
        $last = $this->repository->findOneBy(['codEntidade' => $boletim->getCodEntidade(), 'exercicio' => $exercicio], ['dtBoletim' => 'DESC','codBoletim' => 'DESC']);
        $codBoletim = 1;
        if (!empty($last)) {
            $codBoletim = ($last->getCodBoletim()+1);
        }

        $entidade = $this->entityManager->getRepository('CoreBundle:Orcamento\Entidade')->findOneBy(['codEntidade' => $boletim->getCodEntidade(), 'exercicio' => $exercicio]);
        $usuarioTerminal = $this->entityManager->getRepository('CoreBundle:Tesouraria\UsuarioTerminal')->findOneBy(['codTerminal' => $terminal['cod_terminal'], 'cgmUsuario' => $userId]);
        $boletim->setCodBoletim($codBoletim);
        $boletim->setFkOrcamentoEntidade($entidade);
        $boletim->setExercicio($exercicio);
        $boletim->setCgmUsuario($userId);
        $boletim->setFkTesourariaUsuarioTerminal($usuarioTerminal);
        $boletim->setTimestampTerminal(new DateTimeMicrosecondPK($terminal['timestamp_terminal']));
        $boletim->setTimestampUsuario(new DateTimeMicrosecondPK($terminal['timestamp_usuario']));
        return $boletim;
    }

    /**
     * Prepara o objeto Abertura, apartir do objeto Boletim para ser persistido no banco de dados
     *
     * @param $boletim
     * @return mixed
     */
    public function aberturaBoletim($boletim)
    {
        $aberturaBoletim = new Abertura();

        $aberturaBoletim->setFkTesourariaUsuarioTerminal($boletim->getFkTesourariaUsuarioTerminal());
        $aberturaBoletim->setFkTesourariaTerminal($boletim->getFkTesourariaUsuarioTerminal()->getFkTesourariaTerminal());
        $aberturaBoletim->setTimestampAbertura(new DateTimeMicrosecondPK());
        $aberturaBoletim->setFkTesourariaBoletim($boletim);
        $boletim->addFkTesourariaAberturas($aberturaBoletim);
        return $boletim;
    }

    /**
     * Prepara o objeto BoletimFechado, para persistir no banco de dados
     *
     * @param $boletim
     * @return BoletimFechado
     */
    public function dadosFecharBoletim($boletim)
    {
        $boletimFechado = new BoletimFechado();
        $boletimFechado->setTimestampFechamento(new DateTimeMicrosecondPK());
        $boletimFechado->setFkTesourariaBoletim($boletim);
        $boletimFechado->setFkOrcamentoEntidade($boletim->getFkOrcamentoEntidade());
        $boletimFechado->setFkTesourariaUsuarioTerminal($boletim->getFkTesourariaUsuarioTerminal());
        return $boletimFechado;
    }

    /**
     * Prepara o objeto BoletimLiberado, para persistir no banco de dados
     *
     * @param $boletim
     * @return BoletimLiberado
     */
    public function dadosliberarBoletim($boletim)
    {
        $now = new \DateTime();
        $boletimLiberado = new BoletimLiberado();
        $boletimFechado = $boletim->getFkTesourariaBoletimFechados()->first();
        $boletimLiberado->setFkTesourariaBoletimFechado($boletimFechado);
        $boletimLiberado->setFkTesourariaUsuarioTerminal($boletimFechado->getFkTesourariaUsuarioTerminal());
        return $boletimLiberado;
    }

    public function dadosCancelarBoletimLiberado($boletimLiberado, $boletimFechado)
    {
        $boletimLiberadoCancelado = new BoletimLiberadoCancelado();
        $boletimLiberadoCancelado->setFkTesourariaBoletimFechado($boletimFechado);
        $boletimLiberadoCancelado->setFkOrcamentoEntidade($boletimFechado->getFkOrcamentoEntidade());
        $boletimLiberadoCancelado->setFkTesourariaUsuarioTerminal($boletimFechado->getFkTesourariaUsuarioTerminal());
        $boletimLiberadoCancelado->setTimestampLiberado($boletimLiberado->getTimestampLiberado());
        return $boletimLiberadoCancelado;
    }

    /**
     * Prepara o objeto BoletimLiberadoLote, aparir do $boletimLiberado, para persistir no banco de dados
     *
     * @param $boletimLiberado
     * @param $lote
     * @return mixed
     */
    public function dadosliberarLoteBoletim($boletimLiberado, $lote)
    {
        $boletimLiberadoLote = new BoletimLiberadoLote();
        $boletimLiberadoLote->setTipo($lote->getTipo());
        $boletimLiberadoLote->setCodLote($lote->getCodLote());
        $boletimLiberadoLote->setFkLote($lote);
        $boletimLiberadoLote->setFkBoletimLiberado($boletimLiberado);
        $boletimLiberado->addCodBoletimLiberadoLote($boletimLiberadoLote);
        return $boletimLiberado;
    }


    /**
     * Prepara o objeto BoletimReaberto, para persistir no banco de dados
     * Essa e a opcao para reabrir o boletim
     *
     * @param $boletim
     * @return BoletimReaberto
     */
    public function dadosReabrirBoletim($boletim)
    {
        $boletimReaberto = new BoletimReaberto();
        $boletimFechado = $boletim->getFkTesourariaBoletimFechados()->last();
        $boletimReaberto->setFkTesourariaBoletimFechado($boletimFechado);
        $boletimReaberto->setFkOrcamentoEntidade($boletimFechado->getFkOrcamentoEntidade());
        $boletimReaberto->setFkTesourariaUsuarioTerminal($boletimFechado->getFkTesourariaUsuarioTerminal());
        return $boletimReaberto;
    }

    /**
     * Persist um novo lote para lancamento, o lote é inserido no banco de dados apartir da function fn_insere_lote
     * @param $lista
     * @return Lote
     * @throws \Exception
     */
    public function insereLote($lista)
    {
        $current = current($lista);

        $date = new \DateTime();
        $lote = new Lote();
        $lote->setExercicio($current['exercicio']);
        $lote->setCodEntidade($current['cod_entidade']);
        $lote->setNomLote("Arrecadação de Receita Boletim N. {$current['cod_boletim']}/{$current['exercicio']}");
        $lote->setDtLote($date->format('d/m/Y'));
        $lote->setTipo($current['tipo']);

        try {
            $codLote = $this->repository->insereLote($lote);
            $loteRepository = $this->entityManager->getRepository('CoreBundle:Contabilidade\\Lote');
            $arrayFindLote = ['codEntidade' => $current['cod_entidade'], 'codLote' => $codLote, 'tipo' => $current['tipo'], 'exercicio' => $current['exercicio']];
            $lote = $loteRepository->findOneBy($arrayFindLote);
        } catch (\Exception $e) {
            throw new \Exception($e);
        }

        return $lote;
    }

    /**
     * @param $arrecadacoes
     * @param $retencao
     * @return Lote
     * @throws \Exception
     */
    public function lancarArrecadacao($arrecadacoes, $retencao)
    {
        //insere o lote com o primeiro elemento do array
        $lote = $this->insereLote($arrecadacoes);

        foreach ($arrecadacoes as $arrecadacao) {
            $codPlanoUm = null;
            $codPlanoDois = null;
            $codEstruturalUm = '7.2.1.1.1.%';
            $codEstruturalDois = '8.2.1.1.1.%';

            //recupera Receita
            $receitaRepository = $this->entityManager->getRepository('CoreBundle:Orcamento\\Receita');
            $receita = $receitaRepository->findOneBy(['exercicio' => $arrecadacao['exercicio'], 'codReceita' => $arrecadacao['cod_receita']]);

            $configuracaoRepository = $this->entityManager->getRepository('CoreBundle:Administracao\\Configuracao');
            $configuracao = $configuracaoRepository->findOneBy(['exercicio' => $arrecadacao['exercicio'], 'codModulo' => 8, 'parametro' => 'recurso_destinacao']);

            //se o valor da configuração for true e a Receita tem um recurso
            if ($configuracao->getValor() && !empty($receita->getCodRecurso())) {
                $recursoDestinacaoRepository = $this->entityManager->getRepository('CoreBundle:Orcamento\\RecursoDestinacao');
                $recursoDestinacao = $recursoDestinacaoRepository->findOneBy(['codRecurso' => $receita->getCodRecurso(), 'exercicio' => $arrecadacao['exercicio']]);
                //No old ele não faz essa validacao, e mesmo retorno vazio de RecursoDestinacao
                if (!empty($recursoDestinacao)) {
                    $codRecurso = $this->repository->recuperaRecursoVinculoConta($recursoDestinacao, $codEstruturalDois);
                    $receita->setCodRecurso($codRecurso);
                }
            }

            //Se a Receita tem um recurso
            if (!empty($receita->getCodRecurso())) {
                //retorna o codigo do plano
                $codPlanoUm = $this->repository->verificaContasRecurso($receita->getCodRecurso(), $arrecadacao['exercicio'], $codEstruturalUm);
                $codPlanoDois = $this->repository->verificaContasRecurso($receita->getCodRecurso(), $arrecadacao['exercicio'], $codEstruturalDois);
                if (empty($codPlanoUm) || empty($codPlanoDois)) {
                    $codPlanoUm = $codPlanoUm == null ? $codEstruturalUm : '';
                    $codPlanoDois = $codPlanoDois == null ? $codEstruturalDois : '';

                    throw new \Exception(
                        sprintf(
                            "O recurso da receita não possui conta criada para o grupo %s %s!",
                            $codPlanoUm,
                            $codPlanoDois
                        )
                    );
                }
            }

            $desdobramentoReceitaRepository = $this->entityManager->getRepository('CoreBundle:Contabilidade\\DesdobramentoReceita');
            $receitaSecundaria = $desdobramentoReceitaRepository->findOneBy(['exercicio' => $arrecadacao['exercicio'], 'codReceitaPrincipal' => $arrecadacao['cod_receita']]);

            //Se existir vai fazer o lancamento da receita secundaria
            if (!empty($receitaSecundaria)) {
            }

            $dadosParaLancamento = $this->repository->dadosParaLancamento($arrecadacao['exercicio'], $arrecadacao['cod_receita']);

            //Persist o Lancamento, apartir da function RealizacaoReceitaVariavelTribunal
            $sequencia = $this->realizacaoReceitaVariavelTribunal($retencao, $arrecadacao, $receitaSecundaria, $dadosParaLancamento, $lote);

            if (!empty($sequencia)) {
                try {
                    $this->lancamentoReceita($lote, $arrecadacao, $sequencia, $receita);
                    if ($retencao) {
                        $this->realizacaoReceitaFixaTribunal($retencao, $arrecadacao, $receitaSecundaria, $lote);
                    }
                } catch (\Exception $e) {
                    throw new \Exception($e);
                }
            }
        }

        return $lote;
    }

    /**
     * Persist na tabela contabilidade.lancamento_receita
     *
     * @param $lote
     * @param $arrecadacao
     * @param $sequencia
     * @param $receita
     * @throws \Exception
     */
    protected function lancamentoReceita($lote, $arrecadacao, $sequencia, $receita)
    {
        $lancamento = [
            'codLote' => $lote->getCodLote(),
            'tipo' => $lote->getTipo(),
            'exercicio' => $arrecadacao['exercicio'],
            'codEntidade' => $arrecadacao['cod_entidade'],
            'sequencia' => $sequencia['sequencia']
        ];
        $lancamentoRepository = $this->entityManager->getRepository('CoreBundle:Contabilidade\\Lancamento');
        $lancamento = $lancamentoRepository->findOneBy($lancamento);

        $lancamentoReceita = new LancamentoReceita();
        $lancamentoReceita->setExercicio($arrecadacao['exercicio']);
        $lancamentoReceita->setCodLote($lote->getCodLote());
        $lancamentoReceita->setTipo($lote->getTipo());
        $lancamentoReceita->setSequencia($sequencia['sequencia']);
        $lancamentoReceita->setCodEntidade($arrecadacao['cod_entidade']);
        $lancamentoReceita->setCodReceita($arrecadacao['cod_receita']);
        $lancamentoReceita->setEstorno(false);
        $lancamentoReceita->setFkReceita($receita);

        $lancamento->addCodLancamentoReceita($lancamentoReceita);

        try {
            $this->save($lancamento);
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    /**
     * Persist na tabela contabilidade.lancamento, apatir da function RealizacaoReceitaVariavelTribunal()
     *
     * @param $retencao
     * @param $arrecadacao
     * @param $receitaSecundaria
     * @param $dadosParaLancamento
     * @param $lote
     * @return mixed
     * @throws \Exception
     */
    protected function realizacaoReceitaVariavelTribunal($retencao, $arrecadacao, $receitaSecundaria, $dadosParaLancamento, $lote)
    {
        list($codHistorico, $complemento) = $this->codHistoricoComplemento($retencao, $arrecadacao, $receitaSecundaria);
        $dadosRealizacaoReceita = [
            'conta_recebimento' => str_replace('.', '', $arrecadacao['cod_estrutural_debito']),
            'clas_receita' => str_replace('.', '', $dadosParaLancamento['cod_estrutural']),
            'exercicio' => $arrecadacao['exercicio'],
            'valor' => $arrecadacao['valor'],
            'complemento' => $complemento,
            'cod_lote' => $lote->getCodLote(),
            'tipo_lote' => $lote->getTipo(),
            'cod_entidade' => $arrecadacao['cod_entidade'],
            'cod_reduzido' => $arrecadacao['conta_credito'],
            'cod_historico' => $codHistorico,
            'cod_plano_conta_recebimento' => str_replace(".", "", $dadosParaLancamento["cod_plano"]),
            'cod_plano_clas_receita' => $arrecadacao['conta_credito']
        ];

        try {
            return $this->repository->realizacaoReceitaVariavelTribunal($dadosRealizacaoReceita);
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    /**
     * Persist apartir da function realizacaoReceitaFixaTribunal()
     * @param $retencao
     * @param $arrecadacao
     * @param $receitaSecundaria
     * @param $lote
     * @return mixed
     * @throws \Exception
     */
    protected function realizacaoReceitaFixaTribunal($retencao, $arrecadacao, $receitaSecundaria, $lote)
    {
        list($codHistorico, $complemento) = $this->codHistoricoComplemento($retencao, $arrecadacao, $receitaSecundaria);

        $dadosRealizacaoReceitaFixaTribunal = [
            'exercicio' => $arrecadacao['exercicio'],
            'valor' => $arrecadacao['valor'],
            'complemento' => $complemento,
            'cod_lote' => $lote->getCodLote(),
            'tipo_lote' => $lote->getTipo(),
            'cod_entidade' => $arrecadacao['cod_entidade'],
            'cod_historico' => $codHistorico
        ];

        try {
            return $this->repository->realizacaoReceitaFixaTribunal($dadosRealizacaoReceitaFixaTribunal);
        } catch (\Exception $e) {
            throw new \Exception($e);
        }
    }

    /**
     * Helper para pegar o codHistorico e o complemento
     *
     * @param $retencao
     * @param $arrecadacao
     * @param $receitaSecundaria
     * @return array
     */
    protected function codHistoricoComplemento($retencao, $arrecadacao, $receitaSecundaria)
    {
        $codHistorico = 950;
        if (!empty($retencao)) {
            if (empty($arrecadacao['cod_historico'])) {
                $codHistorico = 907;
            } else {
                $codHistorico = $arrecadacao['cod_historico'];
            }
        }

        if ($retencao) {
            $complemento = (!empty($arrecadacao['cod_ordem']) ? $arrecadacao['cod_ordem']. "/"  : ''). $arrecadacao['exercicio'];
            return array($codHistorico, $complemento);
        } else {
            $complemento = ($arrecadacao['numeracao'] ? $arrecadacao['numeracao'] : (($receitaSecundaria['cod_receita_secundaria']) ? $receitaSecundaria['cod_receita_secundaria'] : ""));
            return array($codHistorico, $complemento);
        }
    }

    /**
     * Quando o Boletim esta com o status Liberado, será possivel cancelar essa liberação
     * @param $arrayBoletimFechado
     * @return bool
     * @throws \Exception
     */
    public function cancelarLiberacaoBoletim($arrayBoletimFechado)
    {
        foreach ($arrayBoletimFechado as $boletimFechado) {
            foreach ($boletimFechado->getFkTesourariaBoletimLiberados() as $boletimLiberado) {
                //Delete nos lancamentos
                try {
                    $this->removeLancamentos($boletimLiberado);
                } catch (\Exception $e) {
                    throw new \Exception($e);
                }

                //Monta o objeto BoletimLiberadoCancelado
                $boletimLiberadoCancelado = $this->dadosCancelarBoletimLiberado($boletimLiberado, $boletimFechado);
                $boletimFechado->addFkTesourariaBoletimLiberadoCancelados($boletimLiberadoCancelado);

                //Delete no BoletimLiberado
                try {
                    $this->remove($boletimLiberado);
                } catch (\Exception $e) {
                    throw new \Exception($e);
                }

                //Atualiza o BoletimFechado agora com o BoletimLibeadoCancelado
                try {
                    $this->save($boletimFechado);
                } catch (\Exception $e) {
                    throw new \Exception($e);
                }
            }
        }
        return true;
    }

    /**
     * @param $boletimLiberado
     * @return bool
     * @throws \Exception
     */
    protected function removeLancamentos($boletimLiberado)
    {
        $lancamentoRepository = $this->entityManager->getRepository('CoreBundle:Contabilidade\\Lancamento');
        foreach ($boletimLiberado->getFkTesourariaBoletimLiberadoLotes() as $boletimLiberadoLote) {
            $condicoes = [
                'exercicio' => $boletimLiberadoLote->getExercicio(),
                'codLote' => $boletimLiberadoLote->getCodLote(),
                'tipo' => $boletimLiberadoLote->getTipo(),
                'codEntidade' => $boletimLiberadoLote->getCodEntidade()
            ];
            $lancamentos = $lancamentoRepository->findBy($condicoes);

            try {
                foreach ($lancamentos as $lancamento) {
                    $this->entityManager->remove($lancamento);
                }
                $this->entityManager->flush();
            } catch (\Exception $e) {
                throw new \Exception($e);
            }
        }
        return true;
    }

    /**
     * @param string|integer $codEntidade
     * @param string $exercicio
     * @return ORM\QueryBuilder|null
     */
    public function recuperaBoletimPorEntidadeQueryBuilder($codEntidade, $exercicio)
    {
        $repositoryRes = $this->repository->buscaBoletinsPorEntidade([
            'cod_entidade' => $codEntidade
        ]);

        if (empty($repositoryRes)) {
            return null;
        }

        $codBoletins = [];
        foreach ($repositoryRes as $singleResult) {
            $codBoletins[] = $singleResult['cod_boletim'];
        }

        $queryBuilder = $this->repository->createQueryBuilder('o');
        $rootAlias = $queryBuilder->getRootAliases()[0];

        $queryBuilder
            ->where($queryBuilder->expr()->in(sprintf('%s.codBoletim', $rootAlias), $codBoletins))
            ->andWhere(sprintf('%s.exercicio = :exercicio', $rootAlias))
            ->andWhere(sprintf('%s.codEntidade = :codEntidade', $rootAlias))
            ->setParameter('exercicio', $exercicio)
            ->setParameter('codEntidade', $codEntidade)
        ;

        return $queryBuilder;
    }

    /**
     * @param string|array|Orcamento\Entidade $entidade
     * @return array|null
     * @throws \Exception
     */
    public function recuperaBoletimPorEntidade($entidade)
    {
        $queryBuilder = null;
        $codEntidade = null;
        $exercicio = null;

        switch (gettype($entidade)) {
            case 'string':
                if (preg_match('/([0-9]{4}\~[0-9]+)/', $entidade)) {
                    $exercicio = explode('~', $entidade)[0];
                    $codEntidade = explode('~', $entidade)[1];
                } else {
                    throw new \Exception('Invalid composite key.');
                }

                break;
            case 'array':
                $exercicio = $entidade['exercicio'];
                $codEntidade = $entidade['cod_entidade'];

                break;
            case 'object':
                if ($entidade instanceof Orcamento\Entidade) {
                    $exercicio = $entidade->getExercicio();
                    $codEntidade = $entidade->getCodEntidade();
                } else {
                    throw new \Exception('Invalid Entidade object.');
                }

                break;
        }

        $queryBuilder = $this->recuperaBoletimPorEntidadeQueryBuilder($codEntidade, $exercicio);

        if ($queryBuilder instanceof ORM\QueryBuilder) {
            return $queryBuilder->getQuery()->getResult();
        }

        return null;
    }
}
