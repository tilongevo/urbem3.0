<?php

namespace Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Inscricao;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Divida\DividaAtiva;
use Urbem\CoreBundle\Entity\Divida\DividaCancelada;
use Urbem\CoreBundle\Entity\Divida\Documento;
use Urbem\CoreBundle\Entity\Divida\EmissaoDocumento;
use Urbem\CoreBundle\Entity\Divida\ProcessoCancelamento;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Repository\Tributario\DividaAtiva\InscricaoRepository;

class InscricaoModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var InscricaoRepository|null  */
    protected $repository = null;

    protected $exercicio;

    const NOTIFICACAO_DIVIDA = 'notificacaoDAUrbem';
    const NOTIFICACAO_DIVIDA_FILE = 'notificacao_da';
    const NOTIFICACAO_DIVIDA_COD = '25';

    const TERMO_CONSOLIDACAO = 'termoConsolidacaoDAUrbem';
    const TERMO_CONSOLIDACAO_FILE = 'termo_consolidacao_da';
    const TERMO_CONSOLIDACAO_COD = '23';

    const TERMO_INSCRICAO = 'termoConsolidacaoDAUrbem';
    const TERMO_INSCRICAO_FILE = 'termo_consolidacao_da';
    const TERMO_INSCRICAO_COD = '19';

    const MEMORIAL_CALCULO = 'memorialCalculoDAUrbem';
    const MEMORIAL_CALCULO_FILE = 'memorial_calculo_da';
    const MEMORIAL_CALCULO_COD = '21';

    const CERTIDAO = 'memorialCalculoDAUrbem';
    const CERTIDAO_FILE = 'memorial_calculo_da';
    const CERTIDAO_COD = '20';

    /**
     * AutoridadeModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, $exercicio)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(DividaCancelada::class);
        $this->exercicio = $exercicio;
    }

    /**
     * @param $object
     * @return ArrayCollection
     */
    public function initAdmin($object)
    {
        $init = new ArrayCollection();
        if (empty($object->getCodInscricao())) {
            $init->set('inscricaoAno', $this->helperArray($this->repository->findAllInscricaoAno(), 'nom_cgm', 'exercicio_inscricao', true)->toArray());
            $init->set('processoClassificacao', $this->helperArray($this->repository->findSwClassificacao(), 'nomClassificacao', 'codClassificacao', true)->toArray());
            $init->set('processoAssunto', []);
            $init->set('processo', []);
            $init->set('emitirDocumento', $this->opcoesEmitirDocumento());
        }
        return $init;
    }

    /**
     * @param $codClassificacao
     * @return array
     */
    public function findSwAssunto($codClassificacao)
    {
        return $this->helperArray($this->repository->findSwAssunto($codClassificacao), 'assuntoClassificacao', 'nomAssunto', false)->toArray();
    }

    /**
     * @param $codClassificacaoAssunto
     * @return array
     */
    public function findProcessos($codClassificacaoAssunto)
    {
        $classificacaoAssunto = explode('-', $codClassificacaoAssunto);
        return array_flip($this->helperArray($this->repository->findProcessos($classificacaoAssunto[0], $classificacaoAssunto[1]), 'nom_cgm', 'cod_processo_completo', true)->toArray());
    }

    /**
     * @return array
     */
    public function opcoesEmitirDocumento()
    {
        return [
            'sim' => true,
            'nao' => false
        ];
    }

    /**
     * @param $array
     * @param $value
     * @param $key
     * @param bool $exibirKey
     * @return ArrayCollection
     */
    protected function helperArray($array, $value, $key, $exibirKey = true)
    {
        $collection = new ArrayCollection();
        if (!empty($array)) {
            foreach ($array as $values) {
                $string = sprintf('%s - %s', $values[$key], $values[$value]);
                if ($exibirKey) {
                    $collection->set($string, $values[$key]);
                } else {
                    $collection->set($values[$value], $values[$key]);
                }
            }
        }
        return $collection;
    }

    /**
     * @param $object
     * @param $childrens
     * @param $container
     */
    public function prePersist($object, $childrens, $container)
    {
        $this->appendDividaAtiva($object, $childrens);
        $object->setFkAdministracaoUsuario($container->get('security.token_storage')->getToken()->getUser());
        if (!empty($childrens['hiddenProcesso']->getViewData())) {
            $this->appendProcesso($object, $childrens);
        }
    }

    /**
     * @param $object
     * @return bool|EmissaoDocumento
     */
    public function buildEmissaoDocumento($object, $tipoDoc)
    {
        $parcelamento = $this->findDividaParcelamento($object->getCodInscricao(), $object->getExercicio());
        if (empty($parcelamento)) {
            return false;
        }

        $dadosDocumento = $this->repository->findDadosDocumento($parcelamento['numParcelamento']);
        if (empty($dadosDocumento)) {
            return false;
        }

        $codDocumento = null;
        switch ($tipoDoc) {
            case self::CERTIDAO:
                $codDocumento = self::CERTIDAO_COD;
                break;
            case self::NOTIFICACAO_DIVIDA:
                $codDocumento = self::NOTIFICACAO_DIVIDA_COD;
                break;
            case self::TERMO_CONSOLIDACAO:
                $codDocumento = self::TERMO_CONSOLIDACAO_COD;
                break;
            case self::TERMO_INSCRICAO:
                $codDocumento = self::TERMO_INSCRICAO_COD;
                break;
            case self::MEMORIAL_CALCULO:
                $codDocumento = self::MEMORIAL_CALCULO_COD;
                break;
        }

        $emissaoDocumentoPorExercicio = $this->repository->findDividaEmissaoDocumento($codDocumento, $dadosDocumento['cod_tipo_documento'], $this->exercicio);
        $numEmissao = 1;
        $numDocumento = 1;

        if (!empty($emissaoDocumentoPorExercicio)) {
            $numEmissao = ($numEmissao + $emissaoDocumentoPorExercicio['numEmissao']);
            $numDocumento = ($numDocumento + $emissaoDocumentoPorExercicio['numDocumento']);
        }

        $emissaoDocumento = new EmissaoDocumento();
        $dividaDocumento = $this->entityManager->getRepository(Documento::class)->findOneBy(
            [
                'numParcelamento' => $dadosDocumento['num_parcelamento'],
                'codDocumento' => $codDocumento,
            ]
        );

        $emissaoDocumento->setFkDividaDocumento($dividaDocumento);
        $emissaoDocumento->setFkAdministracaoUsuario($object->getFkAdministracaoUsuario());
        $emissaoDocumento->setNumEmissao($numEmissao);
        $emissaoDocumento->setNumDocumento($numDocumento);
        $emissaoDocumento->setExercicio($this->exercicio);

        return $emissaoDocumento;
    }

    /**
     * @param $object
     * @param $childrens
     * @return null|object
     */
    public function validaDividaAtiva($object, $childrens)
    {
        return $this->findDividaCancelada($childrens);
    }

    /**
     * @param $object
     * @param $childrens
     */
    protected function appendDividaAtiva($object, $childrens)
    {
        $exercicioInscricao = explode('/', $childrens['inscricaoAno']->getNormData());
        $exercicio = current($exercicioInscricao);
        next($exercicioInscricao);
        $codInscricao = current($exercicioInscricao);
        $dividaAtiva = $this->entityManager->getRepository(DividaAtiva::class)->findOneBy(['codInscricao' => $codInscricao, 'exercicio' => $exercicio]);
        if (!empty($dividaAtiva)) {
            $object->setFkDividaDividaAtiva($dividaAtiva);
        }
    }

    /**
     * @param $object
     * @param $childrens
     */
    protected function appendProcesso($object, $childrens)
    {
        $processoCancelamento = new ProcessoCancelamento();
        $processoExercicio = explode('/', $childrens['hiddenProcesso']->getViewData());
        $codProcesso = current($processoExercicio);
        next($processoExercicio);
        $exercicioProcesso = current($processoExercicio);

        $processo = $this->entityManager->getRepository(SwProcesso::class)->findOneBy(['codProcesso' => (int) $codProcesso, 'anoExercicio' => $exercicioProcesso]);
        if (!empty($processo)) {
            $processoCancelamento->setFkSwProcesso($processo);
        }

        $processoCancelamento->setFkDividaDividaCancelada($object);
        $object->setFkDividaProcessoCancelamento($processoCancelamento);
    }

    /**
     * @param $childrens
     * @return null|object
     */
    protected function findDividaCancelada($childrens)
    {
        $exercicioInscricao = explode('/', $childrens['inscricaoAno']->getNormData());
        $exercicio = current($exercicioInscricao);
        next($exercicioInscricao);
        $codInscricao = current($exercicioInscricao);

        $dividaCancelada = $this->findByOneDividaCancelada($codInscricao, $exercicio);
        return $dividaCancelada;
    }

    /**
     * @param $numParcelamento
     * @param $codInscricao
     * @param $exercicio
     * @return array
     */
    public function findRegistros($numParcelamento, $codInscricao, $exercicio)
    {
        return $this->repository->findRegistros($numParcelamento, $codInscricao, $exercicio);
    }

    /**
     * @param $codInscricao
     * @param $exercicio
     * @return null|object
     */
    public function findByOneDividaCancelada($codInscricao, $exercicio)
    {
        return  $this->repository->findOneBy(['codInscricao' => $codInscricao, 'exercicio' => $exercicio]);
    }

    /**
     * @param $codInscricao
     * @param $exercicio
     * @return mixed
     */
    public function findDividaParcelamento($codInscricao, $exercicio)
    {
        return $this->repository->findDividaParcelamento($codInscricao, $exercicio);
    }

    /**
     * @param $numParcelamento
     * @return mixed
     */
    public function findDadosDocumentoNotificacaoDa($numParcelamento)
    {
        return $this->repository->findDadosDocumentoNotificacaoDa($numParcelamento);
    }

    /**
     * @param $numParcelamento
     * @param $codTipoDocumento
     * @return mixed
     */
    public function findDadosTermoConsolidacaoDa($numParcelamento, $codTipoDocumento)
    {
        return $this->repository->findDadosTermoConsolidacaoDa($numParcelamento, $codTipoDocumento);
    }

    /**
     * @param $numParcelamento
     * @param $numEmissao
     * @param $codTipoDocumento
     * @param $codDocumento
     * @param $numDocumento
     * @param $exercicio
     * @return null|object
     */
    public function findEmissaoDocumento($numParcelamento, $numEmissao, $codTipoDocumento, $codDocumento, $numDocumento, $exercicio)
    {
        return $this->entityManager->getRepository(EmissaoDocumento::class)->findOneBy([
            'numParcelamento' => $numParcelamento,
            'numEmissao' => $numEmissao,
            'codTipoDocumento' => $codTipoDocumento,
            'codDocumento' => $codDocumento,
            'numDocumento' => $numDocumento,
            'exercicio' => $exercicio
        ]);
    }

    /**
     * @param $dados
     * @return array
     */
    public function dadosNotificacaoDa($dados)
    {
        $total = $dados['valor_origem'];

        $acrescimoC = explode(';', $dados['acrescimos_c']);
        $acrescimoJ = explode(';', $dados['acrescimos_j']);
        $acrescimoM = explode(';', $dados['acrescimos_m']);
        $reducao = $dados['total_reducao'];

        $total = ($total + current($acrescimoC));
        $total = ($total + current($acrescimoJ));
        $total = ($total + current($acrescimoM));

        $totalComReducao = ($total - $reducao);

        return [
            'inscricao' => sprintf('%s/%s', $dados['cod_inscricao'], $dados['exercicio']),
            'data' => $dados['dt_notificacao'],
            'totalDivida' => $totalComReducao,
            'total' => $total,
            'reducao' => $reducao,
            'valorOrigem' => $dados['valor_origem'],
            'correcaoMonetaria' => current($acrescimoC),
            'multa' => current($acrescimoM),
            'juros' => current($acrescimoJ),
            'contribuinte' => $dados['contribuinte'],
            'inscricaoMunicipal' => $dados['inscricao_municipal'],
            'inscricaoEconomica' => $dados['inscricao_economica'],
            'endereco' => $dados['endereco'],
            'bairro' => $dados['bairro'],
            'cep' => $dados['cep'],
            'cpfCnpj' => $dados['cpf_cnpj'],
            'numcgm' => $dados['numcgm'],
            'rg' => $dados['rg'],
            'orgaoEmissor' => $dados['orgao_emissor'],
            'creditoOrigem' => $dados['credito_origem']
        ];
    }

    /**
     * @param $dados
     * @return array
     */
    public function dadosTermoConsolidacao($dados)
    {
        return [
            'contribuinte' => $dados['contribuinte'],
            'domicilioFiscal' => $dados['domicilio_fiscal'],
            'cpfCnpj' => $dados['cpf_cnpj'],
            'inscricaoMunicipal' => $dados['inscricao_municipal'],
            'tipoInscricao' => $dados['tipo_inscricao'],
            'dtNotificacao' => $dados['dt_notificacao'],
            'nrAcordoAdministrativo' => $dados['nr_acordo_administrativo'],
            'parcelas' => $dados['parcelas'],
            'dtVencimento' => $dados['dt_vencimento'],
            'vlrParcela' => $dados['vlr_parcela'],
            'situacao' => $dados['situacao'],
            'dtPagamento' => $dados['dt_pagamento'],
            'valorPago' => $dados['valor_pago'],
            'valorTotalParcelas' => ($dados['num_parcela']*$dados['vlr_parcela'])
        ];
    }
}
