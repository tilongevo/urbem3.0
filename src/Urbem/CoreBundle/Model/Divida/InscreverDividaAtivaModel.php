<?php

namespace Urbem\CoreBundle\Model\Divida;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao;
use Urbem\CoreBundle\Entity\Divida\DividaAtiva;
use Urbem\CoreBundle\Entity\Divida\DividaCgm;
use Urbem\CoreBundle\Entity\Divida\DividaEmpresa;
use Urbem\CoreBundle\Entity\Divida\DividaImovel;
use Urbem\CoreBundle\Entity\Divida\DividaParcelamento;
use Urbem\CoreBundle\Entity\Divida\DividaProcesso;
use Urbem\CoreBundle\Entity\Divida\Documento;
use Urbem\CoreBundle\Entity\Divida\EmissaoDocumento;
use Urbem\CoreBundle\Entity\Divida\Parcelamento;
use Urbem\CoreBundle\Entity\Divida\ParcelaOrigem;
use Urbem\CoreBundle\Repository\Tributario\DividaAtiva\InscreverDividaAtivaRepository;

/**
 * Class InscreverDividaAtivaModel
 * @package Urbem\CoreBundle\Model\Divida
 */
class InscreverDividaAtivaModel extends AbstractModel
{
    const VALOR_TOTAL = 1;
    const VALOR_TOTAL_POR_CREDITO = 2;
    const PARCELAS_INDIVIDUAIS = 3;
    const PARCELAS_INDIVIDUAIS_POR_CREDITO = 4;
    const COD_MOTIVO = 11;
    const DIVIDA_TIPO_INSCRICAO_IMOVEL = 'im';
    const DIVIDA_TIPO_INSCRICAO_EMPRESA = 'ie';

    protected $em;
    protected $repository;
    protected $divida = [];
    protected $livro = [];
    protected $modalidade = [];
    protected $modalidades = [];
    protected $autoridade = [];
    protected $calculo = [];
    protected $filtro = [];

    /**
     * InscreverDividaAtivaModel constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = new InscreverDividaAtivaRepository($this->em);
    }

    /**
    * @param array $divida
    * @param array $livro
    * @param array $modalidades
    * @param array $filtro
    * @return array
    */
    public function inscreverDividaAtiva(array $divida, array $livro, array $modalidades, array $filtro)
    {
        $this->divida = $divida;
        $this->livro = $livro;
        $this->modalidades = $modalidades;
        $this->modalidade = reset($this->modalidades);
        $this->autoridade = $this->repository->fetchAutoridade($filtro['autoridade']);
        $this->filtro = $filtro;

        $lancamentoCalculos = $this->repository->fetchLancamentoCalculos($this->divida['cod_lancamento']);
        $parcelasDivida = $this->repository->fetchParcelasDivida($this->divida['cod_lancamento']);

        $codCalculos = !empty($lancamentoCalculos) ? array_column($lancamentoCalculos, 'cod_calculo') : [];
        $this->calculo = $this->repository->fetchCalculo($codCalculos);

        $codParcelas = !empty($parcelasDivida) ? array_column($parcelasDivida, 'cod_parcela') : [];
        $carnesCancelar = $this->repository->fetchCarnesParaCancelar($codParcelas);
        foreach ($carnesCancelar as $carneCancelar) {
            $carneDevolucao = (new CarneDevolucao())
                ->setCodMotivo($this::COD_MOTIVO)
                ->setNumeracao($carneCancelar['numeracao'])
                ->setCodConvenio($carneCancelar['codConvenio'])
                ->setDtDevolucao(date('d/m/Y'));

            $this->em->persist($carneDevolucao);
        }

        $dividasAtivas = [];

        if ($this->modalidade['cod_forma_inscricao'] == $this::VALOR_TOTAL) {
            $dividasAtivas = $this->inscreverPorValorTotal($parcelasDivida);
        }

        if ($this->modalidade['cod_forma_inscricao'] == $this::VALOR_TOTAL_POR_CREDITO) {
            $dividasAtivas = $this->inscreverPorValorTotalPorCredito();
        }

        if ($this->modalidade['cod_forma_inscricao'] == $this::PARCELAS_INDIVIDUAIS) {
            $dividasAtivas = $this->inscreverPorParcelasIndividuais();
        }

        if ($this->modalidade['cod_forma_inscricao'] == $this::PARCELAS_INDIVIDUAIS_POR_CREDITO) {
            $dividasAtivas = $this->inscreverPorParcelasIndividuaisPorCredito($parcelasDivida);
        }

        $this->em->flush();

        foreach ($dividasAtivas as $dividaAtiva) {
            $this->repository->lancarAcrescimos($this->filtro['exercicio'], $dividaAtiva->getCodInscricao());
        }

        return $dividasAtivas;
    }

    /**
    * @param DividaAtiva $dividaAtiva
    */
    public function emitirDocumentos(DividaAtiva $dividaAtiva)
    {
        $parcelamento = $dividaAtiva->getFkDividaDividaParcelamentos()->last()->getFkDividaParcelamento();
        foreach ($parcelamento->getFkDividaDocumentos() as $documento) {
            $ultimoEmissaoDocumento = $this->em->getRepository(EmissaoDocumento::class)->findOneBy([], ['numDocumento' => 'DESC']);

            $numDocumento = $ultimoEmissaoDocumento ? $ultimoEmissaoDocumento->getNumDocumento() : 0;

            $emissaoDocumento = (new EmissaoDocumento())
                ->setFkAdministracaoUsuario($parcelamento->getNumcgmUsuario())
                ->setExercicio($parcelamento->getExercicio())
                ->setNumDocumento(++$numDocumento)
                ->setNumEmissao(1)
                ->setFkDividaDocumento($documento);

            $documento->addFkDividaEmissaoDocumentos($emissaoDocumento);
        }

        $this->em->persist($dividaAtiva);
        $this->em->flush();
    }

    /**
    * @param array $parcelasDivida
    * @return array
    */
    protected function inscreverPorValorTotal(array $parcelasDivida)
    {
        $dividaAtiva = $this->populateDividaAtiva();
        $parcelamento = $dividasAtiva->getFkDividaDividaParcelamentos()->last()->getFkDividaParcelamento();

        foreach ($parcelasDivida as $parcelaDivida) {
            $parcelaOrigem = (new ParcelaOrigem())
                ->setCodCredito($parcelaDivida['codCredito'])
                ->setCodNatureza($parcelaDivida['codNatureza'])
                ->setCodGenero($parcelaDivida['codGenero'])
                ->setCodEspecie($parcelaDivida['codEspecie'])
                ->setCodParcela($parcelaDivida['cod_parcela'])
                ->setValor($parcelaDivida['valor'])
                ->setFkDividaParcelamento($parcelamento);

            $parcelamento->addFkDividaParcelaOrigens($parcelaOrigem);
        }

        $this->em->persist($dividaAtiva);

        return [$dividaAtiva];
    }

    /**
    * @return array
    */
    protected function inscreverPorValorTotalPorCredito()
    {
        $parcelasCredito = [];
        foreach ($parcelasDivida as $parcelaDivida) {
            if ($parcelaDivida['valor'] <= 0) {
                continue;
            }

            $idCredito = sprintf('%d~%d~%d~%d', $parcelaDivida['codCredito'], $parcelaDivida['codNatureza'], $parcelaDivida['codGenero'], $parcelaDivida['codEspecie']);

            $parcelasCredito[$idCredito][] = $parcelaDivida;
        }

        $dividasAtivas = [];
        foreach ($parcelasCredito as $idCredito => $parcelas) {
            $dividaAtiva = $this->populateDividaAtiva($divida, $livro, $modalidades, $filtro);
            $parcelamento = $dividasAtiva->getFkDividaDividaParcelamentos()->last()->getFkDividaParcelamento();

            foreach ($parcelas as $parcela) {
                $parcelaOrigem = (new ParcelaOrigem())
                    ->setCodCredito($parcela['codCredito'])
                    ->setCodNatureza($parcela['codNatureza'])
                    ->setCodGenero($parcela['codGenero'])
                    ->setCodEspecie($parcela['codEspecie'])
                    ->setCodParcela($parcela['cod_parcela'])
                    ->setValor($parcela['valor'])
                    ->setFkDividaParcelamento($parcelamento);

                $parcelamento->addFkDividaParcelaOrigens($parcelaOrigem);
            }

            $this->em->persist($dividaAtiva);

            $dividasAtivas[] = $dividaAtiva;
        }

        return $dividasAtivas;
    }

    /**
    * @return array
    */
    protected function inscreverPorParcelasIndividuais()
    {
        $parcelasCredito = [];
        foreach ($parcelasDivida as $parcelaDivida) {
            if ($parcelaDivida['valor'] <= 0) {
                continue;
            }

            $parcelasCredito[$parcelaDivida['cod_parcela']][] = $parcelaDivida;
        }

        $dividasAtivas = [];
        foreach ($parcelasCredito as $parcelas) {
            $dividaAtiva = $this->populateDividaAtiva($divida, $livro, $modalidades, $filtro);
            $parcelamento = $dividasAtiva->getFkDividaDividaParcelamentos()->last()->getFkDividaParcelamento();

            foreach ($parcelas as $parcela) {
                $parcelaOrigem = (new ParcelaOrigem())
                    ->setCodCredito($parcela['codCredito'])
                    ->setCodNatureza($parcela['codNatureza'])
                    ->setCodGenero($parcela['codGenero'])
                    ->setCodEspecie($parcela['codEspecie'])
                    ->setCodParcela($parcela['cod_parcela'])
                    ->setValor($parcela['valor'])
                    ->setFkDividaParcelamento($parcelamento);

                $parcelamento->addFkDividaParcelaOrigens($parcelaOrigem);
            }

            $this->em->persist($dividaAtiva);

            $dividasAtivas[] = $dividaAtiva;
        }

        return $dividasAtivas;
    }

    /**
    * @param array $parcelasDivida
    * @return array
    */
    protected function inscreverPorParcelasIndividuaisPorCredito(array $parcelasDivida)
    {
        $dividasAtivas = [];
        foreach ($parcelasDivida as $parcelaDivida) {
            $dividaAtiva = $this->populateDividaAtiva($divida, $livro, $modalidades, $filtro);
            $parcelamento = $dividasAtiva->getFkDividaDividaParcelamentos()->last()->getFkDividaParcelamento();

            $parcelaOrigem = (new ParcelaOrigem())
                ->setCodCredito($parcelaDivida['codCredito'])
                ->setCodNatureza($parcelaDivida['codNatureza'])
                ->setCodGenero($parcelaDivida['codGenero'])
                ->setCodEspecie($parcelaDivida['codEspecie'])
                ->setCodParcela($parcelaDivida['cod_parcela'])
                ->setValor($parcelaDivida['valor'])
                ->setFkDividaParcelamento($parcelamento);

            $parcelamento->addFkDividaParcelaOrigens($parcelaOrigem);

            $this->em->persist($dividaAtiva);

            $dividasAtivas[] = $dividaAtiva;
        }

        return $dividasAtivas;
    }

    /**
    * @return DividaAtiva
    */
    protected function populateDividaAtiva()
    {
        $codInscricao = $this->repository->fetchUltimoCodInscricao($this->filtro['exercicio']);
        $dividaAtiva = (new DividaAtiva())
            ->setNumLivro($this->livro['num_livro'])
            ->setNumFolha($this->livro['num_folha'])
            ->setExercicio($this->filtro['exercicio'])
            ->setCodInscricao($codInscricao)
            ->setCodAutoridade($this->autoridade['cod_autoridade'])
            ->setNumcgmUsuario($this->autoridade['numcgm'])
            ->setDtInscricao($this->filtro['dtInscricao'])
            ->setDtVencimentoOrigem($this->divida['dt_vencimento_origem'])
            ->setExercicioOriginal($this->calculo['exercicio'])
            ->setExercicioLivro($this->livro['exercicio_livro']);

        $dividaCgm = (new DividaCgm())
            ->setNumcgm($this->divida['numcgm'])
            ->setFkDividaDividaAtiva($dividaAtiva);

        $dividaAtiva->addFkDividaDividaCgns($dividaCgm);

        if (strtolower($this->divida['tipo_inscricao']) == $this::DIVIDA_TIPO_INSCRICAO_IMOVEL) {
            $dividaImovel = (new DividaImovel())
                ->setInscricaoMunicipal($this->divida['inscricao'])
                ->setFkDividaDividaAtiva($dividaAtiva);

            $dividaAtiva->addFkDividaDividaImoveis($dividaImovel);
        }

        if (strtolower($this->divida['tipo_inscricao']) == $this::DIVIDA_TIPO_INSCRICAO_EMPRESA) {
            $dividaEmpresa = (new DividaEmpresa())
                ->setInscricaoEconomica($this->divida['inscricao'])
                ->setFkDividaDividaAtiva($dividaAtiva);

            $dividaAtiva->addFkDividaDividaEmpresas($dividaEmpresa);
        }

        $numParcelamento = $this->repository->fetchUltimoNumParcelamento();
        $parcelamento = (new Parcelamento())
            ->setNumParcelamento($numParcelamento)
            ->setNumcgmUsuario($this->autoridade['numcgm'])
            ->setCodModalidade($this->modalidade['cod_modalidade'])
            ->setTimestampModalidade($this->modalidade['timestamp'])
            ->setNumeroParcelamento(-1)
            ->setExercicio(-1);

        foreach ($this->modalidades as $modalidadeDocumento) {
            $documento = (new Documento())
                ->setFkDividaParcelamento($parcelamento)
                ->setCodDocumento($modalidadeDocumento['cod_documento'])
                ->setCodTipoDocumento($modalidadeDocumento['cod_tipo_documento'])
                ->setFkDividaParcelamento($parcelamento);

            $parcelamento->addFkDividaDocumentos($documento);
        }

        $dividaParcelamento = (new DividaParcelamento())
            ->setFkDividaParcelamento($parcelamento)
            ->setFkDividaDividaAtiva($dividaAtiva);

        $dividaAtiva->addFkDividaDividaParcelamentos($dividaParcelamento);

        if (!empty($this->filtro['processos'])) {
            list($anoExercicio, $codProcesso) = explode('~', $this->filtro['processos']);
            $dividaProcesso = (new DividaProcesso())
                ->setAnoExercicio($anoExercicio)
                ->setCodProcesso($codProcesso)
                ->setFkDividaDividaAtiva($dividaAtiva);

            $dividaAtiva->addFkDividaDividaProcessos($dividaProcesso);
        }

        return $dividaAtiva;
    }
}
