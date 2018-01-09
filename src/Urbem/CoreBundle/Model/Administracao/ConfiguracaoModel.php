<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico;
use Urbem\CoreBundle\Entity\Monetario\Moeda;
use Urbem\CoreBundle\Entity\Orcamento\PosicaoDespesa;
use Urbem\CoreBundle\Entity\Orcamento\PosicaoReceita;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Administracao\ConfiguracaoRepository;
use Urbem\FinanceiroBundle\Controller\Ppa\ConfiguracaoController;

class ConfiguracaoModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var ConfiguracaoRepository
     */
    protected $repository = null;

    const PARAM_UTILIZAR_ENCERRAMENTO_MES = 'utilizar_encerramento_mes';
    const PARAM_VIRADA_GF = 'virada_GF';
    const MODULO_FINANCEIRO_EMPENHO = 10;
    const MODULO_PATRIMONAL_PATRIMONIO = 6;
    const MODULO_PATRIMONIAL_COMPRAS = 35;
    const MODULO_ADMINISTRACAO = 2;
    const MODULO_PROTOCOLO = 5;
    const MODULO_FINANCEIRO_CONTABILIDADE = 9;
    const MODULO_RH_RESCISAO_CONTRATO = 22;
    const MODULO_RH_PESSOAL = 22;
    const MODULO_RH_FOLHAPAGAMENTO = 27;
    const MODULO_TRIBUTARIO_ECONOMICO = 14;
    const MODULO_TRIBUTARIO_MONETARIO_ACRESCIMOS = 28;
    const MODULO_TRIBUTARIO_ARRECADACAO = 25;
    const MODULO_TRIBUTARIO_DIVIDA_ATIVA = 33;
    const TIPO_EVENTO_DECIMO = 1;
    const MODULO_TRIBUTARIO_IMOBILIARIO_TIPO_EDIFICACAO = 12;
    const MODULO_FINANCEIRO_ORCAMENTO = 8;

    const DIVIDA_ATIVA_CONFIGURACAO_LIVRO = 'configurar-livro';
    const DIVIDA_ATIVA_CONFIGURACAO_LIVRO_FOLHA = 'livro_folha';
    const DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO = 'configurar-inscricao';
    const DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_UTILIZAR_VALOR_REF = 'utilizar_valor_referencia';
    const DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_TIPO_VALOR_REF = 'tipo_valor_referencia';
    const DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_MOEDA_VALOR_REF = 'moeda_valor_referencia';
    const DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_LIMITE_VALOR_REF = 'limite_valor_referencia';
    const DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_VALOR_REF = 'valor_referencia';
    const DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_NUM_INSCRICAO = 'numeracao_inscricao';
    const DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_INDICADOR_VALOR_REF = 'indicador_valor_referencia';

    const DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA = 'remissao-automatica';
    const DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_LANCAMENTO_ATIVO = 'lancamento_ativo';
    const DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_INSCRICAO_AUTOMATICA = 'inscricao_automatica';
    const DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_VALIDACAO = 'validacao';
    const DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_MOD_INSCRICAO_AUTOMATICA = 'modalidade_inscricao_automatica';
    const DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_LIMITES = 'limites';

    const DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS = 'configurar-documentos';
    const DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_SECRETARIA = 'secretaria';
    const DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_MSG_DOC = 'msg_doc';
    const DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_COORDENADOR = 'coordenador';
    const DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_CHEFE_DEPARTAMENTO = 'chefe_departamento';
    const DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_SETOR_ARRECADACAO = 'setor_arrecadacao';
    const DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_LEI = 'nro_lei_inscricao_da';
    const DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_METODOLOGIA_CALCULO = 'metodologia_calculo';
    const DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_UTILINCVAL_DOC = 'utilincval_doc';
    const DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_UTILMSG_DOC = 'utilmsg_doc';
    const DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_UTILRESP2_DOC = 'utilresp2_doc';
    const DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_UTILLEIDA_DOC = 'utilleida_doc';

    const PARAM_PROTOCOLO_PROCESSO_MASCARA_PROCESSO = 'mascara_processo';
    const PARAM_CLASSIFICACAO_RECEITA_DEDUTORA = 'mascara_classificacao_receita_dedutora';
    const PARAM_CLASSIFICACAO_RECEITA = 'mascara_classificacao_receita';
    const PARAM_CLASS_DEFESA = 'masc_class_despesa';

    public function __construct(ORM\EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Administracao\\Configuracao");
    }

    public function getAtributosDinamicosPorModuloeExercicio($info)
    {
        return $this->repository->getAtributosDinamicosPorModuloeExercicio($info);
    }

    public function updateAtributosDinamicos($info)
    {
        return $this->repository->updateAtributosDinamicos($info);
    }

    public function selectAtributosDinamicosEntidade($info)
    {
        return $this->repository->selectAtributosDinamicosEntidade($info);
    }

    public function selectInsertUpdateAtributosDinamicosSolicitacao($info)
    {
        $info['campo'] = 'data_fixa_solicitacao_compra';

        return $this->repository->selectInsertUpdateAtributosDinamicos($info);
    }

    public function selectInsertUpdateAtributosDinamicosCompras($info)
    {
        $info['campo'] = 'data_fixa_compra';
        return $this->repository->selectInsertUpdateAtributosDinamicos($info);
    }

    public function getAtributosDinamicosPorModuloeExercicioParametro($info)
    {
        return $this->repository->getAtributosDinamicosPorModuloeExercicioParametro($info);
    }

    public function getEntidades($exercicio = false)
    {
        return $this->repository->montaRecuperaEntidadeGeral($exercicio);
    }

    /**
     * @param array $params
     * @param $exercicio
     * @return array
     */
    public function findConfiguracaoByParameters(array $params, $exercicio)
    {
        return $this->repository->findConfiguracaoByParameters($params, $exercicio);
    }

    /**
     * @deprecated Use o método `getConfiguracao` ao invés desse.
     * @param $stParametro
     * @param $inCodModulo
     * @param $inExercicio
     * @param bool|false $returnValor
     * @return array|null
     */
    public function pegaConfiguracao($stParametro, $inCodModulo, $inExercicio, $returnValor = false)
    {
        return $this->getConfiguracao($stParametro, $inCodModulo, $returnValor, $inExercicio);
    }

    /**
     * @param      $stParametro
     * @param      $inCodModulo
     * @param bool $returnValor
     * @param bool $exercicio
     *
     * @return array|string|integer
     */
    public function getConfiguracao($stParametro, $inCodModulo, $returnValor = false, $exercicio = false)
    {
        return $this->repository->pegaConfiguracao($stParametro, $inCodModulo, $returnValor, $exercicio);
    }

    /**
     * Pega a configuracao do exercicio fornecido ou anterior ao mesmo.
     *
     * @param $parametro
     * @param $codModulo
     * @param $exercicio
     *
     * @return mixed
     */
    public function getConfiguracaoOuAnterior($parametro, $codModulo, $exercicio)
    {
        $queryBuilder = $this->repository->createQueryBuilder('c');
        $queryBuilder
            ->select('c.valor')
            ->where('c.codModulo = :codModulo')
            ->andWhere('c.parametro = :parametro')
            ->andWhere('c.exercicio <= :exercicio')
            ->setParameters([
                'codModulo' => $codModulo,
                'parametro' => $parametro,
                'exercicio' => $exercicio
            ])
            ->orderBy('c.exercicio', 'DESC')
            ->setMaxResults(1)
        ;

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function getContaCaixaEntidade($params)
    {
        return $this->repository->getContaCaixaEntidade($params);
    }

    /**
     * @param \Urbem\CoreBundle\Entity\Administracao\Configuracao $configuracao
     * @return null|object|\Urbem\CoreBundle\Entity\Administracao\Configuracao
     */
    public function getAnaliticsTraking(Configuracao $configuracao)
    {
        return $this->getConfiguracaoByConfiguracao($configuracao);
    }

    /**
     * @param \Urbem\CoreBundle\Entity\Administracao\Configuracao $configuracao
     * @return null|object
     */
    public function findByConfiguracao(Configuracao $configuracao)
    {
        return $this->repository->findOneBy(
            [
                'exercicio' => $configuracao->getExercicio(),
                'codModulo' => $configuracao->getCodModulo(),
                'parametro' => $configuracao->getParametro()
            ]
        );
    }

    /**
     * @param \Urbem\CoreBundle\Entity\Administracao\Configuracao $configuracao
     * @return null|object|\Urbem\CoreBundle\Entity\Administracao\Configuracao
     */
    public function getConfiguracaoByConfiguracao(Configuracao $configuracao)
    {
        $configSearch = $this->findByConfiguracao($configuracao);

        if (!isset($configSearch)) {
            $this->entityManager->persist($configuracao);
            $this->entityManager->flush();

            return $configuracao;
        }

        return $configSearch;
    }

    /**
     * @param \Urbem\CoreBundle\Entity\Administracao\Configuracao $configuracao
     * @return null|object|\Urbem\CoreBundle\Entity\Administracao\Configuracao
     */
    public function setInitialConfig(Configuracao $configuracao)
    {
        $config = $this->getConfiguracaoByConfiguracao($configuracao);
        $config->setValor($configuracao->getValor());

        $this->entityManager->persist($config);
        $this->entityManager->flush();
        return $config;
    }

    /**
     * Salva configurações de PPA
     * @param $parametro
     * @param $codModulo
     * @param $exercicio
     * @param $valor
     * @return bool|\Exception
     */
    public function salvarConfiguracaoPpa($parametro, $codModulo, $exercicio, $valor)
    {
        try {
            $em = $this->entityManager;
            $periodo = (new Model\Orcamento\OrgaoModel($em))->getPpaByExercicio($exercicio);
            $modulo = $em->getRepository(Modulo::class)->find($codModulo);

            for ($ano = (int) $exercicio; $ano <= (int) $periodo->getAnoFinal(); $ano++) {
                $configuracao = $em->getRepository(Configuracao::class)->findOneBy(
                    array(
                        'exercicio' => $ano,
                        'codModulo' => $codModulo,
                        'parametro' => $parametro
                    )
                );

                if ($configuracao) {
                    $configuracao->setValor($valor);
                } else {
                    $configuracao = new Configuracao();
                    $configuracao->setExercicio((string) $ano);
                    $configuracao->setParametro((string) $parametro);
                    $configuracao->setValor((string) $valor);
                    $configuracao->setFkAdministracaoModulo($modulo);
                }

                $em->persist($configuracao);
            }
            $em->flush();
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Retorna configuração de Fontes de Recurso
     * @param $exercicio
     * @return bool
     */
    public function utilizaFontesRecurso($exercicio)
    {
        $configuracao = $this->pegaConfiguracao(
            ConfiguracaoController::PARAMETRO_FONTES_RECURSO,
            Modulo::MODULO_PPA,
            $exercicio
        );

        if (count($configuracao)) {
            return ($configuracao[0]["valor"] === "true") ? true : false;
        }
        return false;
    }

    public function getAtributosDinamicosPorModuloeExercicioWithNotIn($info)
    {
        return $this->repository->getAtributosDinamicosPorModuloeExercicioWithNotIn($info);
    }

    /**
     * Atualiza ou cria registros na tabela de configuração
     * @param  string $exercicio
     * @param  integer $codModulo
     * @param  string $parametro
     * @param  string $valor
     * @param  Configuracao $configuracao
     */
    public function persistConfiguracao($exercicio, $codModulo, $parametro, $valor, Configuracao $configuracao = null)
    {
        if (! $configuracao) {
            $fkAdministracaoModulo = $this->entityManager->getRepository('CoreBundle:Administracao\Modulo')
            ->find($codModulo);

            $configuracao = new Configuracao();
            $configuracao->setExercicio($exercicio);
            $configuracao->setFkAdministracaoModulo($fkAdministracaoModulo);
        }

        $configuracao->setParametro($parametro);
        $configuracao->setValor($valor);
        $this->entityManager->persist($configuracao);
        $this->entityManager->flush();
    }

    /**
     * @param $codModulo
     * @param $parametro
     * @param $exercicio
     * @return array
     */
    public function getConfiguracaoLivroFolha($codModulo, $parametro, $exercicio)
    {
        $configuracao = $this->repository->findConfiguracao($codModulo, $parametro, $exercicio);
        $entityLivroFolha = new \stdClass();
        $entityLivroFolha->numeroInicial = 0;
        $entityLivroFolha->sequenciaLivro = '';
        $entityLivroFolha->numeroFolhasLivro = 0;
        $entityLivroFolha->numeracaoFolha = '';
        if (!empty($configuracao)) {
            $dados = explode(';', $configuracao->getValor());
            $entityLivroFolha->numeroInicial = current($dados);
            $entityLivroFolha->sequenciaLivro = next($dados);
            $entityLivroFolha->numeroFolhasLivro = next($dados);
            $entityLivroFolha->numeracaoFolha = next($dados);
        }
        return [$entityLivroFolha, $configuracao];
    }

    /**
     * Busca os valores de cada configuração - Configurar inscrição
     *
     * @param $codModulo
     * @param $exercicio
     * @return ArrayCollection
     */
    public function getValoresConfigurarInscricao($codModulo, $exercicio)
    {
        $collection = new ArrayCollection();
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_UTILIZAR_VALOR_REF);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_TIPO_VALOR_REF);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_MOEDA_VALOR_REF);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_INDICADOR_VALOR_REF);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_LIMITE_VALOR_REF);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_VALOR_REF);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_NUM_INSCRICAO);

        return $this->getAllConfiguracaoes($codModulo, $exercicio, $collection);
    }

    /**
     * Busca os valores de cada configuração - Configurar remissão automatica
     *
     * @param $codModulo
     * @param $exercicio
     * @return ArrayCollection
     */
    public function getValoresConfigurarRemissaoAutomatica($codModulo, $exercicio)
    {
        $collection = new ArrayCollection();
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_LANCAMENTO_ATIVO);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_INSCRICAO_AUTOMATICA);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_VALIDACAO);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_MOD_INSCRICAO_AUTOMATICA);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_LIMITES);

        return $this->getAllConfiguracaoes($codModulo, $exercicio, $collection);
    }

    /**
     * @param $codModulo
     * @param $exercicio
     * @return ArrayCollection
     */
    public function getValoresConfigurarDocumentos($codModulo, $exercicio)
    {
        $collection = new ArrayCollection();
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_LANCAMENTO_ATIVO);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_INSCRICAO_AUTOMATICA);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_VALIDACAO);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_MOD_INSCRICAO_AUTOMATICA);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_LIMITES);

        return $this->getAllConfiguracaoes($codModulo, $exercicio, $collection);
    }

    /**
     * @return array
     */
    public function cmbValoresLimites($translator)
    {
        return [
            $translator->transChoice('label.configuracaoDividaAtiva.remissaoAutomatica.limiteCredito', 0, [], 'messages') => 1,
            $translator->transChoice('label.configuracaoDividaAtiva.remissaoAutomatica.limiteExercicio', 0, [], 'messages') => 2,
            $translator->transChoice('label.configuracaoDividaAtiva.remissaoAutomatica.limiteTotal', 0, [], 'messages') => 3,
            $translator->transChoice('label.configuracaoDividaAtiva.remissaoAutomatica.limiteCreditoLimiteTotal', 0, [], 'messages') => 4,
            $translator->transChoice('label.configuracaoDividaAtiva.remissaoAutomatica.limiteExercicioLimiteTotal', 0, [], 'messages') => 5,
            $translator->transChoice('label.configuracaoDividaAtiva.remissaoAutomatica.limiteCreditoExercicioLimiteTotal', 0, [], 'messages') => 6,
            $translator->transChoice('label.configuracaoDividaAtiva.remissaoAutomatica.limiteCreditoLimiteExercicio', 0, [], 'messages') => 7
        ];
    }

    /**
     * @param $translator
     * @return array
     */
    public function stDocumento($translator)
    {
        return [
            $translator->transChoice('label.configuracaoDividaAtiva.documentos.certidaoDividaAtiva', 0, [], 'messages') => 1,
            $translator->transChoice('label.configuracaoDividaAtiva.documentos.termoInscricaoDividaAtiva', 0, [], 'messages') => 2,
            $translator->transChoice('label.configuracaoDividaAtiva.documentos.memorialCalculoDividaAtiva', 0, [], 'messages') => 3,
            $translator->transChoice('label.configuracaoDividaAtiva.documentos.termoConsolidacao', 0, [], 'messages') => 4,
            $translator->transChoice('label.configuracaoDividaAtiva.documentos.termoParcelamento', 0, [], 'messages') => 5,
            $translator->transChoice('label.configuracaoDividaAtiva.documentos.notificacaoDividaAtiva', 0, [], 'messages') => 6
        ];
    }

    /**
     * @return array
     */
    public function getModalidade()
    {
        $modalidades = $this->repository->findModalidade(1, (new \DateTime())->format('Y-m-d'), 't');
        $arrayModalidade = new ArrayCollection();

        foreach ($modalidades as $modalidade) {
            $arrayModalidade->set($modalidade['descricao'], $modalidade['codModalidade']);
        }

        return $arrayModalidade->toArray();
    }

    /**
     * Monta um array collection com os resultados das configurações
     *
     * @param $codModulo
     * @param $exercicio
     * @param $collection
     * @param $piece
     * @return ArrayCollection
     */
    protected function getAllConfiguracaoes($codModulo, $exercicio, $collection, $piece = null)
    {
        $init = new ArrayCollection();
        foreach ($collection->toArray() as $parametroConf) {
            $retornoConf = $this->repository->findConfiguracao($codModulo, $parametroConf . $piece, $exercicio);
            if (!empty($retornoConf)) {
                $init->set($parametroConf, $retornoConf->getValor());
            } else {
                $init->set($parametroConf, null);
            }
        }
        return $init;
    }

    /**
     * @return ArrayCollection
     */
    public function findAllMoedas()
    {
        $moedas = $this->entityManager->getRepository(Moeda::class)->findAll();
        $collection = new ArrayCollection();

        if (!empty($moedas)) {
            foreach ($moedas as $moeda) {
                $collection->set(sprintf('%s - %s', $moeda->getDescricaoSingular(), $moeda->getSimbolo()), $moeda->getCodMoeda());
            }
        }

        return $collection;
    }

    /**
     * @return ArrayCollection
     */
    public function findIndicadorEconomico()
    {
        $indicadores = $this->entityManager->getRepository(IndicadorEconomico::class)->findAll();
        $collection = new ArrayCollection();

        if (!empty($indicadores)) {
            foreach ($indicadores as $indicador) {
                $collection->set($indicador->getDescricao(), $indicador->getCodIndicador());
            }
        }

        return $collection;
    }

    /**
     * @param $childrens
     * @param $exercicio
     */
    public function prePersistConfiguracao($childrens, $exercicio)
    {
        switch ($childrens['tipo']->getViewData()) {
            case self::DIVIDA_ATIVA_CONFIGURACAO_LIVRO:
                $this->prePersistConfiguracaoLivro($childrens, $exercicio);
                break;
            case self::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO:
                $this->prePersistConfiguracaoInscricao($childrens, $exercicio);
                break;
            case self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA:
                $this->prePersistConfiguracaoRemissaoAutomatica($childrens, $exercicio);
                break;
            case self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS:
                $this->prePersistConfiguracaoDocumentos($childrens, $exercicio);
                break;
        }
    }

    /**
     * @param $childrens
     * @param $exercicio
     */
    protected function prePersistConfiguracaoLivro($childrens, $exercicio)
    {
        list($entityLivroFolha, $configuracao) = $this->getConfiguracaoLivroFolha(self::MODULO_TRIBUTARIO_DIVIDA_ATIVA, self::DIVIDA_ATIVA_CONFIGURACAO_LIVRO_FOLHA, $exercicio);
        $value = sprintf(
            '%s;%s;%s;%s;%s',
            $childrens['numeroInicial']->getViewData(),
            $childrens['sequenciaLivro']->getViewData(),
            $childrens['numeroFolhasLivro']->getViewData(),
            $childrens['numeracaoFolha']->getViewData(),
            $exercicio
        );
        $configuracao->setExercicio($exercicio);
        $configuracao->setValor($value);
        $this->save($configuracao);
    }

    /**
     * @param $childrens
     * @param $exercicio
     */
    protected function prePersistConfiguracaoInscricao($childrens, $exercicio)
    {
        $this->saveConfiguracaoDividaAtiva(self::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_UTILIZAR_VALOR_REF, $childrens['utilizarValorReferencia']->getViewData(), $exercicio);
        $this->saveConfiguracaoDividaAtiva(self::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_NUM_INSCRICAO, $childrens['numeroInscricao']->getViewData(), $exercicio);
        $this->saveConfiguracaoDividaAtiva(self::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_TIPO_VALOR_REF, $childrens['tipoValorReferencia']->getViewData(), $exercicio);
        $this->saveConfiguracaoDividaAtiva(self::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_MOEDA_VALOR_REF, $childrens['moeda']->getViewData(), $exercicio);
        $this->saveConfiguracaoDividaAtiva(self::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_INDICADOR_VALOR_REF, $childrens['indicador']->getViewData(), $exercicio);
        $this->saveConfiguracaoDividaAtiva(self::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_LIMITE_VALOR_REF, $childrens['valorReferencia__minMax']->getViewData(), $exercicio);
        $this->saveConfiguracaoDividaAtiva(self::DIVIDA_ATIVA_CONFIGURACAO_INSCRICAO_VALOR_REF, str_replace('.', ',', $childrens['valorReferencia__valorMoeda']->getViewData()), $exercicio);
    }

    /**
     * @param $childrens
     * @param $exercicio
     */
    protected function prePersistConfiguracaoRemissaoAutomatica($childrens, $exercicio)
    {
        $this->saveConfiguracaoDividaAtiva(self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_LANCAMENTO_ATIVO, $childrens['lancamentosAtivos']->getViewData(), $exercicio);
        $this->saveConfiguracaoDividaAtiva(self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_INSCRICAO_AUTOMATICA, $childrens['inscricaoAutomatica']->getViewData(), $exercicio);
        $this->saveConfiguracaoDividaAtiva(self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_VALIDACAO, $childrens['formaValidacaoRemissao']->getViewData(), $exercicio);
        $this->saveConfiguracaoDividaAtiva(self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_LIMITES, $childrens['valoresLimites']->getViewData(), $exercicio);
        $this->saveConfiguracaoDividaAtiva(self::DIVIDA_ATIVA_CONFIGURACAO_REMISSAO_AUTOMATICA_MOD_INSCRICAO_AUTOMATICA, $childrens['modalidade']->getViewData(), $exercicio);
    }

    /**
     * @param $parametro
     * @param $value
     * @param $exercicio
     */
    protected function saveConfiguracaoDividaAtiva($parametro, $value, $exercicio)
    {
        $configuracao = $this->repository->findConfiguracao(self::MODULO_TRIBUTARIO_DIVIDA_ATIVA, $parametro, $exercicio);
        if (empty($configuracao)) {
            $configuracao = new Configuracao();
            $configuracao->setCodModulo(self::MODULO_TRIBUTARIO_DIVIDA_ATIVA);
            $configuracao->setParametro($parametro);
        }
        $configuracao->setExercicio($exercicio);
        $configuracao->setValor($value);
        $this->save($configuracao);
    }

    /**
     * @param $value
     * @param $exercicio
     * @return ArrayCollection
     */
    public function gerValoresConfiguracaoDocumentos($value, $exercicio)
    {
        $collection = new ArrayCollection();
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_MSG_DOC);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_SECRETARIA);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_COORDENADOR);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_CHEFE_DEPARTAMENTO);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_SETOR_ARRECADACAO);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_UTILMSG_DOC);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_UTILRESP2_DOC);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_UTILLEIDA_DOC);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_LEI);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_METODOLOGIA_CALCULO);
        $collection->add(self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_UTILINCVAL_DOC);
        return $this->getAllConfiguracaoes(self::MODULO_TRIBUTARIO_DIVIDA_ATIVA, $exercicio, $collection, '_' . $value);
    }

    /**
     * @param $childrens
     * @param $exercicio
     */
    protected function prePersistConfiguracaoDocumentos($childrens, $exercicio)
    {
        $documentosId = $childrens['documentos']->getViewData();
        $this->saveConfiguracaoDividaAtiva(sprintf('%s_%s', self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_MSG_DOC, $documentosId), $childrens['mensagem']->getViewData(), $exercicio);
        $this->saveConfiguracaoDividaAtiva(sprintf('%s_%s', self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_SECRETARIA, $documentosId), $childrens['secretaria']->getViewData(), $exercicio);
        $this->saveConfiguracaoDividaAtiva(sprintf('%s_%s', self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_COORDENADOR, $documentosId), $childrens['coordenador']->getViewData(), $exercicio);
        $this->saveConfiguracaoDividaAtiva(sprintf('%s_%s', self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_CHEFE_DEPARTAMENTO, $documentosId), $childrens['chefeDepartamento']->getViewData(), $exercicio);
        $this->saveConfiguracaoDividaAtiva(sprintf('%s_%s', self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_SETOR_ARRECADACAO, $documentosId), $childrens['setorArrecadacao']->getViewData(), $exercicio);
        $this->saveConfiguracaoDividaAtiva(sprintf('%s_%s', self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_UTILMSG_DOC, $documentosId), 1, $exercicio);
        $this->saveConfiguracaoDividaAtiva(sprintf('%s_%s', self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_UTILRESP2_DOC, $documentosId), 1, $exercicio);
        $this->saveConfiguracaoDividaAtiva(sprintf('%s_%s', self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_UTILLEIDA_DOC, $documentosId), 1, $exercicio);
        if ($documentosId <= 2) {
            if ($documentosId == 1) {
                $this->saveConfiguracaoDividaAtiva(sprintf('%s_%s', self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_LEI, $documentosId), $childrens['leiMunicipalCertidaoDA']->getViewData(), $exercicio);
            }
            $this->saveConfiguracaoDividaAtiva(sprintf('%s_%s', self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_METODOLOGIA_CALCULO, $documentosId), $childrens['metodologiaCalculo']->getViewData(), $exercicio);
            $this->saveConfiguracaoDividaAtiva(sprintf('%s_%s', self::DIVIDA_ATIVA_CONFIGURACAO_DOCUMENTOS_UTILINCVAL_DOC, $documentosId), $childrens['incidenciaSobreValorDebitoDA']->getViewData(), $exercicio);
        }
    }

    /**
     * @param $valor
     * @param $tipoContaReceita
     * @param $exercicio
     */
    public function savePosicaoReceita($valor, $tipoContaReceita, $exercicio)
    {
        $explode = explode('.', $valor);
        foreach ($explode as $key => $value) {
            $aux = $key + 1;
            $class = new PosicaoReceita();
            $class->setMascara($value);
            $class->setExercicio($exercicio);
            $class->setCodPosicao($aux);
            $class->setFkOrcamentoTipoContaReceita($tipoContaReceita);
            $this->save($class);
        }
    }

    /**
     * @param $valor
     * @param $exercicio
     */
    public function savePosicaoDespesa($valor, $exercicio)
    {
        $explode = explode('.', $valor);
        foreach ($explode as $key => $value) {
            $aux = $key + 1;
            $class = new PosicaoDespesa();
            $class->setMascara($value);
            $class->setExercicio($exercicio);
            $class->setCodPosicao($aux);
            $this->save($class);
        }
    }

    /**
     * @param array $params
     * @return null|object
     */
    public function findOneByParams(array $params)
    {
        return $this->repository->findOneBy($params);
    }
}
