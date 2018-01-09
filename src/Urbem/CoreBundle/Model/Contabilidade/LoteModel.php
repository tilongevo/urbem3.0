<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Contabilidade\ContaCredito;
use Urbem\CoreBundle\Entity\Contabilidade\ContaDebito;
use Urbem\CoreBundle\Entity\Contabilidade\HistoricoContabil;
use Urbem\CoreBundle\Entity\Contabilidade\Lancamento;
use Urbem\CoreBundle\Entity\Contabilidade\Lote;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica;
use Urbem\CoreBundle\Entity\Contabilidade\ValorLancamento;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model;
use Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade\LoteAdmin;

class LoteModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager|null
     */
    protected $entityManager;

    /**
     * @var ORM\EntityRepository|null
     */
    protected $repository;

    const TYPE_NOME_LOTE_IMPLANTACAO_SALDO_AUTOMATICA = 'Implantação de Saldo Automática';
    const TYPE_LOTE_IMPLANTACAO_SALDO_AUTOMATICA = 'I';
    const TYPE_LOTE_LANCAMENTO_CONTABIL = 'M';

    /**
     * LoteModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Contabilidade\\Lote");
    }

    /**
     * @param string $dtLote
     * @param string $exercicio
     * @return bool
     */
    public function verificaMesProcessamento($dtLote, $exercicio)
    {
        $em = $this->entityManager;

        $mesProcessamento = $em->getRepository('CoreBundle:Administracao\Configuracao')
            ->findOneBy([
                'codModulo' => 9,
                'parametro' => 'mes_processamento',
                'exercicio' => $exercicio
            ]);

        list($dia, $mes, $ano) = explode('/', $dtLote);
        $dtLote = strtotime(sprintf('%s-%s-%s', $ano, $mes, $dia));
        $mes = date('m', $dtLote);
        if ((int) $mes == (int) $mesProcessamento->getValor()) {
            return true;
        }

        return false;
    }

    /**
     * @param string $dtLote
     * @param string $exercicio
     * @return bool
     */
    public function verificaAnoProcessamento($dtLote, $exercicio)
    {
        list($dia, $mes, $ano) = explode('/', $dtLote);
        $dtLote = strtotime(sprintf('%s-%s-%s', $ano, $mes, $dia));
        $ano = date('Y', $dtLote);
        if ((int) $ano == (int) $exercicio) {
            return true;
        }

        return false;
    }

    /**
     * @param string $dtLote
     * @param string $exercicio
     * @return bool
     */
    public function verificaMesEncerramento($dtLote, $exercicio)
    {
        $em = $this->entityManager;

        $configuracao = $em->getRepository('CoreBundle:Administracao\Configuracao')
            ->findOneBy([
                'codModulo' => 9,
                'parametro' => 'utilizar_encerramento_mes',
                'exercicio' => $exercicio
            ]);
        if ($configuracao->getValor() == "true") {
            $encerramentoMes = $em->getRepository('CoreBundle:Contabilidade\EncerramentoMes')
                ->findOneBy([
                    'exercicio' => $exercicio,
                    'situacao' => 'F'
                ], ['timestamp' => 'DESC']);

            if ($encerramentoMes) {
                $mesEncerammento = $encerramentoMes->getMes();
                list($dia, $mes, $ano) = explode('/', $dtLote);
                $dtLote = strtotime(sprintf('%s-%s-%s', $ano, $mes, $dia));
                $mesLote = date('m', $dtLote);
                if ($mesEncerammento >= (int) $mesLote) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param $codEntidade
     * @param $tipo
     * @param $exercicio
     * @return int
     */
    public function getProximoCodLote($codEntidade, $tipo, $exercicio)
    {
        $em = $this->entityManager;
        $lote = $em->getRepository('CoreBundle:Contabilidade\Lote')
            ->findOneBy([
                'codEntidade' => $codEntidade,
                'tipo' => $tipo,
                'exercicio' => $exercicio
            ], ['codLote' => 'DESC']);

        if (!$lote) {
            $proximoCodLote = 1;
        } else {
            $proximoCodLote = $lote->getCodLote() + 1;
        }

        return $proximoCodLote;
    }

    /**
     * @return int
     */
    public function getProximaSequencia()
    {
        $em = $this->entityManager;
        $lancamento = $em->getRepository('CoreBundle:Contabilidade\Lancamento')
            ->findOneBy([], ['sequencia' => 'DESC']);
        if (!$lancamento) {
            $proximaSequencia = 1;
        } else {
            $proximaSequencia = $lancamento->getSequencia() + 1;
        }

        return $proximaSequencia;
    }

    /**
     * @return int
     */
    public function getProximoOidLancamento()
    {
        $em = $this->entityManager;
        $valorLancamento = $em->getRepository('CoreBundle:Contabilidade\ValorLancamento')
            ->findOneBy([], ['oidLancamento' => 'DESC']);
        if (!$valorLancamento) {
            $proximoOidLancamento = 1;
        } else {
            $proximoOidLancamento = $valorLancamento->getOidLancamento() + 1;
        }

        return $proximoOidLancamento;
    }

    /**
     * Resgata um lote, de acordo com os parametros passados
     *
     * @param array $params ['codLote', 'exercicio', 'tipo', 'codEntidade']
     * @return Lote
     */
    public function findOneBy($params)
    {
        return $this->repository->findOneBy($params);
    }

    /**
     * @param $exercicio
     * @return mixed
     */
    public function verificaImplantacaoSaldo($exercicio)
    {
        return $this->repository->verificaImplantacaoSaldo($exercicio);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getLotes($params)
    {
        return $this->repository->getLotes($params);
    }

    /**
     * @param $lotes
     * @param $exercicio
     * @param $tipo
     */
    public function excluiLancamentosAberturaAnteriores($lotes, $exercicio, $tipo)
    {
        $em = $this->entityManager;

        foreach ($lotes as $lote) {
            // CONTA DEBITO
            $contasDebito = $em->getRepository('CoreBundle:Contabilidade\\ContaDebito')
                ->findBy([
                    'exercicio' => $exercicio,
                    'codEntidade' => $lote['cod_entidade'],
                    'tipo' => $tipo,
                    'tipoValor' => ContaDebitoModel::TYPE_TIPO_VALOR,
                    'codLote' => $lote['cod_lote']
                ]);

            foreach ($contasDebito as $contaDebito) {
                $this->entityManager->remove($contaDebito);
            }

            // CONTA CREDITO
            $contasCredito = $em->getRepository('CoreBundle:Contabilidade\\ContaCredito')
                ->findBy([
                    'exercicio' => $exercicio,
                    'codEntidade' => $lote['cod_entidade'],
                    'tipo' => $tipo,
                    'tipoValor' => ContaCreditoModel::TYPE_TIPO_VALOR,
                    'codLote' => $lote['cod_lote']
                ]);

            foreach ($contasCredito as $contaCredito) {
                $this->entityManager->remove($contaCredito);
            }

            // VALOR LANCAMENTO
            $valoresLancamento = $em->getRepository('CoreBundle:Contabilidade\\ValorLancamento')
                ->findBy([
                    'exercicio' => $exercicio,
                    'codEntidade' => $lote['cod_entidade'],
                    'tipo' => $tipo,
                    'codLote' => $lote['cod_lote']
                ]);

            foreach ($valoresLancamento as $valorLancamento) {
                $this->entityManager->remove($valorLancamento);
            }

            // LANCAMENTO
            $lancamentos = $em->getRepository('CoreBundle:Contabilidade\\Lancamento')
                ->findBy([
                    'exercicio' => $exercicio,
                    'codEntidade' => $lote['cod_entidade'],
                    'tipo' => $tipo,
                    'codLote' => $lote['cod_lote']
                ]);

            foreach ($lancamentos as $lancamento) {
                $this->entityManager->remove($lancamento);
            }

            // LOTE
            $loteObj = $em->getRepository('CoreBundle:Contabilidade\\Lote')
                ->findOneBy([
                    'exercicio' => $exercicio,
                    'codEntidade' => $lote['cod_entidade'],
                    'tipo' => $tipo,
                    'codLote' => $lote['cod_lote']
                ]);

            $this->entityManager->remove($loteObj);
        }

        $this->entityManager->flush();
    }

    /**
     * @param $contas
     * @param $exercicio
     */
    public function insereLancamentosCreditoAReceber($contas, $exercicio)
    {
        $em = $this->entityManager;

        foreach ($contas as $conta) {
            // Recupera ultimo lote por entidade
            $loteObj = $em->getRepository('CoreBundle:Contabilidade\\Lote')
                ->findOneBy([
                    'exercicio' => $exercicio,
                    'codEntidade' => $conta['cod_entidade'],
                    'tipo' => 'M',
                ], ['codLote' => 'DESC']);

            $codLote = 1;
            if ($loteObj) {
                $codLote = $loteObj->getCodLote() + 1;
            }

            $entidadeObj = $em->getRepository('CoreBundle:Orcamento\\Entidade')
                ->findOneBy([
                    'exercicio' => $exercicio,
                    'codEntidade' => $conta['cod_entidade']
                ]);

            $lote = new Lote();
            $lote->setCodLote($codLote);
            $lote->setFkOrcamentoEntidade($entidadeObj);
            $lote->setTipo('M');
            $lote->setDtLote(new \DateTime($exercicio . '-02-01'));
            $lote->setNomLote('Previsão de crédito tributário a receber');

            $this->entityManager->persist($lote);
            $this->entityManager->flush();

            $planoContaModel = new PlanoContaModel($this->entityManager);
            $planoContaModel->insertLancamento(
                $exercicio,
                $conta['cod_plano'],
                $conta['cod_plano_credito'],
                '',
                '',
                $conta['vl_original'],
                $codLote,
                $conta['cod_entidade'],
                850,
                'M',
                ''
            );
        }
    }

    /**
     * @param $exercicio
     * @param $dtLote
     * @param $tipo
     * @param $codEntidade
     * @param $nomLote
     * @return null|object|Lote
     */
    public function getOrCreateLote($exercicio, $dtLote, $tipo, $codEntidade, $nomLote)
    {
        $em = $this->entityManager;

        $repository = $this->repository;
        $lote = $repository->findOneBy([
            'dtLote' => $dtLote,
            'tipo' => $tipo,
            'codEntidade' => $codEntidade,
            'nomLote' => $nomLote
        ]);

        if (!$lote) {
            $entidade = $em->getRepository('CoreBundle:Orcamento\Entidade')
                ->findOneBy([
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade
                ]);
            $lote = new Lote();
            $codLote = $this->getProximoCodLote($entidade, $tipo, $exercicio);
            $lote->setFkOrcamentoEntidade($entidade);
            $lote->setCodLote($codLote);
            $lote->setTipo($tipo);
            $lote->setNomLote($nomLote);
            $lote->setDtLote($dtLote);
            $em->persist($lote);
            $em->flush();
        }
        return $lote;
    }

    /**
     * @param $exercicio
     * @param $contaDebito
     * @param $contaCredito
     * @param $valor
     * @param $codLote
     * @param $codEntidade
     * @param $codHistorico
     * @param $tipo
     * @param $complemento
     * @return mixed
     */
    public function insereLancamento($exercicio, $contaDebito, $contaCredito, $valor, $codLote, $codEntidade, $codHistorico, $tipo, $complemento)
    {
        $em = $this->entityManager;
        $repository = $em->getRepository('CoreBundle:Contabilidade\Lancamento');
        $sequencia = $repository->insereLancamento($exercicio, $contaDebito, $contaCredito, $valor, $codLote, $codEntidade, $codHistorico, $tipo, $complemento);
        return $sequencia;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $codLote
     * @param $tipo
     */
    public function removeLancamento($exercicio, $codEntidade, $codLote, $tipo)
    {
        $this->repository->removeLancamento($exercicio, $codEntidade, $codLote, $tipo);
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function consultarLote($exercicio, $processar = false)
    {
        $lotes = $this->repository
            ->findBy([
                'nomLote' => 'Abertura do Exercicio Restos a Pagar',
                'exercicio' => $exercicio
            ]);

        if (count($lotes) > 0 && $processar) {
            $retorno = $this->processarCancelarAberturaRestosAPagar($lotes, $exercicio);
        } else {
            $retorno['message'] = 'financeiro.cancelarAberturaRestosAPagar.processoExecutado';
            $retorno['status'] = 'error';
        }

        return $retorno;
    }

    /**
     * @param array $lotes
     * @param $exercicio
     * @return string
     */
    public function processarCancelarAberturaRestosAPagar(array $lotes, $exercicio)
    {
        $em = $this->entityManager;

        foreach ($lotes as $lote) {
            $exercicio = $lote->getExercicio();
            try {
                // CONTA CREDITO
                $contaCreditos = $em->getRepository('CoreBundle:Contabilidade\\ContaCredito')
                    ->findBy([
                        'exercicio' => $lote->getExercicio(),
                        'codEntidade' => $lote->getFkOrcamentoEntidade()->getCodEntidade(),
                        'tipo' => $lote->getTipo(),
                        'codLote' => $lote->getCodLote()
                    ]);

                foreach ($contaCreditos as $contaCredito) {
                    $this->entityManager->remove($contaCredito);
                }

                // CONTA CREDITO
                $contaDebitos = $em->getRepository('CoreBundle:Contabilidade\\ContaDebito')
                    ->findBy([
                        'exercicio' => $lote->getExercicio(),
                        'codEntidade' => $lote->getFkOrcamentoEntidade()->getCodEntidade(),
                        'tipo' => $lote->getTipo(),
                        'codLote' => $lote->getCodLote()
                    ]);
                foreach ($contaDebitos as $contaDebito) {
                    $this->entityManager->remove($contaDebito);
                }

                // VALOR LANCAMENTO
                $valorLancamentos = $em->getRepository('CoreBundle:Contabilidade\\ValorLancamento')
                    ->findBy([
                        'exercicio' => $lote->getExercicio(),
                        'codEntidade' => $lote->getFkOrcamentoEntidade()->getCodEntidade(),
                        'tipo' => $lote->getTipo(),
                        'codLote' => $lote->getCodLote()
                    ]);
                foreach ($valorLancamentos as $valorLancamento) {
                    $this->entityManager->remove($valorLancamento);
                }

                //LANCAMENTO
                $lancamentos = $em->getRepository('CoreBundle:Contabilidade\\Lancamento')
                    ->findBy([
                        'exercicio' => $lote->getExercicio(),
                        'codEntidade' => $lote->getFkOrcamentoEntidade()->getCodEntidade(),
                        'tipo' => $lote->getTipo(),
                        'codLote' => $lote->getCodLote()
                    ]);

                foreach ($lancamentos as $lancamento) {
                    $this->entityManager->remove($lancamento);
                }

                //EXCLUI O LOTE
                $this->entityManager->remove($lote);
                $this->entityManager->flush();
            } catch (\Exception $e) {
                $retorno['message'] = 'financeiro.cancelarAberturaRestosAPagar.erro';
                $retorno['status'] = 'error';
                return $retorno;
            }
        }

        $configuracao = $em->getRepository('CoreBundle:Administracao\\Configuracao')
            ->findOneBy([
                'parametro' => 'abertura_RP',
                'codModulo' => 9,
                'exercicio' => $exercicio
            ]);

        $configuracao->setValor('F');
        $this->entityManager->persist($configuracao);
        $this->entityManager->flush();

        $retorno['message'] = 'Operação Efetuada com Sucesso!';
        $retorno['status'] = 'success';

        return $retorno;
    }

    /**
     * @param $codLote
     * @param $exercicio
     * @param $tipo
     * @param $codEntidade
     * @param $codPlano
     * @return int|null
     */
    public function verificaPlanoAnaliticaExisteLote($codLote, $exercicio, $tipo, $codEntidade, $codPlano)
    {
        $qb = $this->repository->createQueryBuilder('o');
        $qb->select('COUNT(o)');
        $qb->join('o.fkContabilidadeLancamentos', 'l');
        $qb->join('l.fkContabilidadeValorLancamentos', 'vl');
        $qb->leftJoin('vl.fkContabilidadeContaDebito', 'cd');
        $qb->leftJoin('vl.fkContabilidadeContaCredito', 'cc');
        $qb->where('o.codLote = :codLote');
        $qb->andWhere('o.exercicio = :exercicio');
        $qb->andWhere('o.tipo = :tipo');
        $qb->andWhere('o.codEntidade = :codEntidade');
        $qb->andWhere($qb->expr()->orX(
            $qb->expr()->eq('cd.codPlano', ':codPlano'),
            $qb->expr()->eq('cc.codPlano', ':codPlano')
        ));
        $qb->setParameters(
            array(
                'codLote' => $codLote,
                'exercicio' => $exercicio,
                'tipo' => $tipo,
                'codEntidade' => $codEntidade,
                'codPlano' => $codPlano
            )
        );
        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param $codLote
     * @param $exercicio
     * @param $tipo
     * @param $codEntidade
     * @return array
     */
    public function getValoresGerarNota($codLote, $exercicio, $tipo, $codEntidade)
    {
        $lote = $this->repository->findOneBy(['codLote' => $codLote, 'exercicio' => $exercicio, 'tipo' => $tipo, 'codEntidade' => $codEntidade]);
        $contaDebito = new ArrayCollection();
        $contaCredito = clone $contaDebito;
        $swCgm = $lote->getFkOrcamentoEntidade()->getFkSwCgm();

        $dadosEntidade = new \stdClass();
        $dadosEntidade->codEntidade = $lote->getFkOrcamentoEntidade()->getCodEntidade();
        $dadosEntidade->nomEntidade = trim($swCgm->getNomCgm());
        $dadosEntidade->fone = $swCgm->getFoneResidencial();
        $dadosEntidade->fax = $swCgm->getFoneComercial();
        $dadosEntidade->email = trim($swCgm->getEMail());
        $dadosEntidade->logradouro = sprintf('%s, %s - %s', trim($swCgm->getLogradouro()), $swCgm->getNumero(), $swCgm->getBairro());
        $dadosEntidade->cep = $swCgm->getCep();
        $dadosEntidade->cnpj = $swCgm->getFkSwCgmPessoaJuridica()->getCnpj();
        $totalDebito = 0;
        $totalCredito = 0;

        if (!empty($lote)) {
            foreach ($lote->getFkContabilidadeLancamentos() as $lancamento) {
                $objetoDebito = new \stdClass();
                $objetoCredito = clone $objetoDebito;

                $historico = sprintf('%s (%s)', trim($lancamento->getFkContabilidadeHistoricoContabil()), $lancamento->getfkContabilidadeValorLancamentos()->last()->getFkContabilidadeLancamento()->getComplemento());
                $valor = $lancamento->getfkContabilidadeValorLancamentos()->last()->getVlLancamento();

                if (!empty($lancamento->getfkContabilidadeValorLancamentos()->last()->getFkContabilidadeContaDebito())) {
                    $objetoDebito->conta = $lancamento->getfkContabilidadeValorLancamentos()->last()->getFkContabilidadeContaDebito()->getFkContabilidadePlanoAnalitica();

                    $objetoDebito->historico = $historico;
                    $objetoDebito->valor = $valor;
                    $totalDebito += $objetoDebito->valor;
                    $contaDebito->add($objetoDebito);
                }
                if (!empty($lancamento->getfkContabilidadeValorLancamentos()->last()->getFkContabilidadeContaCredito())) {
                    $objetoCredito->conta = $lancamento->getfkContabilidadeValorLancamentos()->last()->getFkContabilidadeContaCredito()->getFkContabilidadePlanoAnalitica();

                    $objetoCredito->historico = $historico;
                    $objetoCredito->valor = $valor;
                    $totalCredito += $objetoCredito->valor;
                    $contaCredito->add($objetoCredito);
                }
            }
        }

        return [$lote, $dadosEntidade, $contaDebito, $totalDebito,$contaCredito, $totalCredito];
    }

    /**
     * @param Lote $lote
     * @param $request
     */
    public function salvarLancamentos($lote, $request)
    {
        $em = $this->entityManager;

        $credito_sequencia = (new LancamentoModel($em))->getProximaSequencia($lote->getCodLote(), $lote->getTipo(), $lote->getExercicio(), $lote->getCodEntidade());
        $debito_sequencia = $credito_sequencia + 1;

        $credito_codPlano = $request->get('credito_codPlano');
        $credito_codHistorico = $request->get('credito_codHistorico');
        $credito_vlLancamento = $request->get('credito_vlLancamento');
        $credito_complemento = $request->get('credito_complemento');

        $debito_codPlano = $request->get('debito_codPlano');
        $debito_codHistorico = $request->get('debito_codHistorico');
        $debito_vlLancamento = $request->get('debito_vlLancamento');
        $debito_complemento = $request->get('debito_complemento');

        foreach ($credito_codPlano as $key => $item) {
            /** @var HistoricoContabil $historicoContabil */
            $historicoContabil = $em->getRepository(HistoricoContabil::class)->findOneBy([
                'codHistorico' => $credito_codHistorico[$key],
                'exercicio' => $lote->getExercicio()
            ]);

            /** @var PlanoAnalitica $planoAnalitica */
            $planoAnalitica = $em->getRepository(PlanoAnalitica::class)->findOneBy([
                'codPlano' => $item,
                'exercicio' => $lote->getExercicio()
            ]);

            $lancamento = new Lancamento();
            $lancamento->setSequencia($credito_sequencia);
            $lancamento->setFkContabilidadeLote($lote);
            $lancamento->setFkContabilidadeHistoricoContabil($historicoContabil);
            $lancamento->setComplemento($credito_complemento[$key]);

            $valorLancamento = new ValorLancamento();
            $valorLancamento->setFkContabilidadeLancamento($lancamento);
            $valorLancamento->setTipoValor(LoteAdmin::TYPE_CREDITO);
            $valorLancamento->setVlLancamento(($credito_vlLancamento[$key] * -1));

            $contaCredito = new ContaCredito();
            $contaCredito->setFkContabilidadePlanoAnalitica($planoAnalitica);
            $valorLancamento->setFkContabilidadeContaCredito($contaCredito);

            $lancamento->addFkContabilidadeValorLancamentos($valorLancamento);
            $em->persist($lancamento);
            $lote->addFkContabilidadeLancamentos($lancamento);

            $credito_sequencia = (isset($debito_codPlano[$key])) ? $credito_sequencia + 2 : $credito_sequencia + 1;
        }

        foreach ($debito_codPlano as $key => $item) {
            /** @var HistoricoContabil $historicoContabil */
            $historicoContabil = $em->getRepository(HistoricoContabil::class)->findOneBy([
                'codHistorico' => $debito_codHistorico[$key],
                'exercicio' => $lote->getExercicio()
            ]);

            /** @var PlanoAnalitica $planoAnalitica */
            $planoAnalitica = $em->getRepository(PlanoAnalitica::class)->findOneBy([
                'codPlano' => $item,
                'exercicio' => $lote->getExercicio()
            ]);

            $lancamento = new Lancamento();
            $lancamento->setSequencia($debito_sequencia);
            $lancamento->setFkContabilidadeLote($lote);
            $lancamento->setFkContabilidadeHistoricoContabil($historicoContabil);
            $lancamento->setComplemento($debito_complemento[$key]);

            $valorLancamento = new ValorLancamento();
            $valorLancamento->setFkContabilidadeLancamento($lancamento);
            $valorLancamento->setTipoValor(LoteAdmin::TYPE_DEBITO);
            $valorLancamento->setVlLancamento($debito_vlLancamento[$key]);

            $contaDebito = new ContaDebito();
            $contaDebito->setFkContabilidadePlanoAnalitica($planoAnalitica);
            $valorLancamento->setFkContabilidadeContaDebito($contaDebito);

            $lancamento->addFkContabilidadeValorLancamentos($valorLancamento);
            $em->persist($lancamento);
            $lote->addFkContabilidadeLancamentos($lancamento);

            $debito_sequencia = (isset($credito_codPlano[($key + 1)])) ? $debito_sequencia + 2 : $debito_sequencia + 1;
        }
    }

    /**
     * @param Lote $lote
     * @param $request
     */
    public function alterarLancamentos($lote, $request)
    {
        $lancamentos = array();
        /** @var Lancamento $lancamento */
        foreach ($lote->getFkContabilidadeLancamentos() as $lancamento) {
            $lancamentos[$lancamento->getSequencia()] = $lancamento;
        }

        $em = $this->entityManager;

        $credito_sequencia = (new LancamentoModel($em))->getProximaSequencia($lote->getCodLote(), $lote->getTipo(), $lote->getExercicio(), $lote->getCodEntidade());
        $debito_sequencia = $credito_sequencia;

        $credito_id = $request->get('credito_id');
        $credito_codPlano = $request->get('credito_codPlano');
        $credito_codHistorico = $request->get('credito_codHistorico');
        $credito_vlLancamento = $request->get('credito_vlLancamento');
        $credito_complemento = $request->get('credito_complemento');
        $credito_novo = $request->get('credito_novo');

        $debito_id = $request->get('debito_id');
        $debito_codPlano = $request->get('debito_codPlano');
        $debito_codHistorico = $request->get('debito_codHistorico');
        $debito_vlLancamento = $request->get('debito_vlLancamento');
        $debito_complemento = $request->get('debito_complemento');
        $debito_novo = $request->get('debito_novo');

        foreach ($credito_novo as $key => $item) {
            if ($item == 0) {
                $lancamento = $lancamentos[$credito_id[$key]];
                if (!((isset($lancamentos[$debito_id[$key]])) && ($lancamento == $lancamentos[$debito_id[$key]]))) {
                    unset($lancamentos[$credito_id[$key]]);
                }

                /** @var HistoricoContabil $historicoContabil */
                $historicoContabil = $em->getRepository(HistoricoContabil::class)->findOneBy([
                    'codHistorico' => $credito_codHistorico[$key],
                    'exercicio' => $lote->getExercicio()
                ]);

                /** @var PlanoAnalitica $planoAnalitica */
                $planoAnalitica = $em->getRepository(PlanoAnalitica::class)->findOneBy([
                    'codPlano' => $credito_codPlano[$key],
                    'exercicio' => $lote->getExercicio()
                ]);

                $lancamento->setFkContabilidadeHistoricoContabil($historicoContabil);
                $lancamento->setComplemento($credito_complemento[$key]);

                /** @var ValorLancamento $valorLancamento */
                $valorLancamento = $lancamento->getFkContabilidadeValorLancamentos()->filter(
                    function ($entry) {
                        if ($entry->getTipoValor() == LoteAdmin::TYPE_CREDITO) {
                            return $entry;
                        }
                    }
                )->first();
                $valorLancamento->setVlLancamento(($credito_vlLancamento[$key] * -1));
                $valorLancamento->getFkContabilidadeContaCredito()->setFkContabilidadePlanoAnalitica($planoAnalitica);
            } else {
                /** @var HistoricoContabil $historicoContabil */
                $historicoContabil = $em->getRepository(HistoricoContabil::class)->findOneBy([
                    'codHistorico' => $credito_codHistorico[$key],
                    'exercicio' => $lote->getExercicio()
                ]);

                /** @var PlanoAnalitica $planoAnalitica */
                $planoAnalitica = $em->getRepository(PlanoAnalitica::class)->findOneBy([
                    'codPlano' => $credito_codPlano[$key],
                    'exercicio' => $lote->getExercicio()
                ]);

                $lancamento = new Lancamento();
                $lancamento->setSequencia($credito_sequencia);
                $lancamento->setFkContabilidadeLote($lote);
                $lancamento->setFkContabilidadeHistoricoContabil($historicoContabil);
                $lancamento->setComplemento($credito_complemento[$key]);

                $valorLancamento = new ValorLancamento();
                $valorLancamento->setFkContabilidadeLancamento($lancamento);
                $valorLancamento->setTipoValor(LoteAdmin::TYPE_CREDITO);
                $valorLancamento->setVlLancamento(($credito_vlLancamento[$key] * -1));

                $contaCredito = new ContaCredito();
                $contaCredito->setFkContabilidadePlanoAnalitica($planoAnalitica);
                $valorLancamento->setFkContabilidadeContaCredito($contaCredito);

                $lancamento->addFkContabilidadeValorLancamentos($valorLancamento);
                $em->persist($lancamento);
                $lote->addFkContabilidadeLancamentos($lancamento);

                $credito_sequencia = (isset($debito_codPlano[$key])) ? $credito_sequencia + 2 : $credito_sequencia + 1;
            }
        }

        foreach ($debito_novo as $key => $item) {
            if (isset($credito_codPlano[($key)])) {
                $debito_sequencia++;
            }
            if ($item == 0) {
                $lancamento = $lancamentos[$debito_id[$key]];
                unset($lancamentos[$debito_id[$key]]);

                /** @var HistoricoContabil $historicoContabil */
                $historicoContabil = $em->getRepository(HistoricoContabil::class)->findOneBy([
                    'codHistorico' => $debito_codHistorico[$key],
                    'exercicio' => $lote->getExercicio()
                ]);

                /** @var PlanoAnalitica $planoAnalitica */
                $planoAnalitica = $em->getRepository(PlanoAnalitica::class)->findOneBy([
                    'codPlano' => $debito_codPlano[$key],
                    'exercicio' => $lote->getExercicio()
                ]);

                $lancamento->setFkContabilidadeHistoricoContabil($historicoContabil);
                $lancamento->setComplemento($debito_complemento[$key]);

                /** @var ValorLancamento $valorLancamento */
                $valorLancamento = $lancamento->getFkContabilidadeValorLancamentos()->filter(
                    function ($entry) {
                        if ($entry->getTipoValor() == LoteAdmin::TYPE_DEBITO) {
                            return $entry;
                        }
                    }
                )->first();
                $valorLancamento->setVlLancamento($debito_vlLancamento[$key]);
                $valorLancamento->getFkContabilidadeContaDebito()->setFkContabilidadePlanoAnalitica($planoAnalitica);
            } else {
                /** @var HistoricoContabil $historicoContabil */
                $historicoContabil = $em->getRepository(HistoricoContabil::class)->findOneBy([
                    'codHistorico' => $debito_codHistorico[$key],
                    'exercicio' => $lote->getExercicio()
                ]);

                /** @var PlanoAnalitica $planoAnalitica */
                $planoAnalitica = $em->getRepository(PlanoAnalitica::class)->findOneBy([
                    'codPlano' => $debito_codPlano[$key],
                    'exercicio' => $lote->getExercicio()
                ]);

                $lancamento = new Lancamento();
                $lancamento->setSequencia($debito_sequencia);
                $lancamento->setFkContabilidadeLote($lote);
                $lancamento->setFkContabilidadeHistoricoContabil($historicoContabil);
                $lancamento->setComplemento($debito_complemento[$key]);

                $valorLancamento = new ValorLancamento();
                $valorLancamento->setFkContabilidadeLancamento($lancamento);
                $valorLancamento->setTipoValor(LoteAdmin::TYPE_DEBITO);
                $valorLancamento->setVlLancamento($debito_vlLancamento[$key]);

                $contaDebito = new ContaDebito();
                $contaDebito->setFkContabilidadePlanoAnalitica($planoAnalitica);
                $valorLancamento->setFkContabilidadeContaDebito($contaDebito);

                $lancamento->addFkContabilidadeValorLancamentos($valorLancamento);
                $em->persist($lancamento);
                $lote->addFkContabilidadeLancamentos($lancamento);

                $debito_sequencia = (isset($credito_codPlano[($key + 1)])) ? $debito_sequencia + 2 : $debito_sequencia + 1;
            }
        }

        foreach ($lancamentos as $lancamento) {
            $em->remove($lancamento);
            $em->flush();
        }
    }
}
