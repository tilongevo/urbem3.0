<?php

namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Economico\Responsavel;
use Urbem\CoreBundle\Entity\Imobiliario\AreaConstrucao;
use Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeAutonoma;
use Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeDependente;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaImovelValor;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaLoteValor;
use Urbem\CoreBundle\Entity\Imobiliario\Construcao;
use Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao;
use Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoOutros;
use Urbem\CoreBundle\Entity\Imobiliario\DataConstrucao;
use Urbem\CoreBundle\Entity\Imobiliario\EmissaoDocumento;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\Licenca;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaBaixa;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaDocumento;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelArea;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaConstrucao;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelNovaEdificacao;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeAutonoma;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaImovelUnidadeDependente;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaLote;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteArea;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteLoteamento;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteParcelamentoSolo;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaProcesso;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaResponsavelTecnico;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\Loteamento;
use Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo;
use Urbem\CoreBundle\Entity\Imobiliario\Permissao;
use Urbem\CoreBundle\Entity\Imobiliario\TipoBaixa;
use Urbem\CoreBundle\Entity\Imobiliario\TipoLicenca;
use Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma;
use Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario\LicencaAdmin;

class LicencaModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository;

    /**
     * NivelModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Licenca::class);
    }

    /**
     * @param $exercicio
     * @return mixed
     */
    public function getNextVal($exercicio)
    {
        return $this->repository->getNextVal($exercicio);
    }

    /**
     * @param $exercicio
     * @return int
     */
    public function retornaLicencaDocumentoNumDocumento($exercicio)
    {
        return $this->repository->getNextNumDocumento($exercicio);
    }

    /**
     * @param Usuario $usuario
     * @param TipoLicenca $tipoLicenca
     * @return null|Permissao
     */
    public function retornaImobiliarioPermissao(Usuario $usuario, TipoLicenca $tipoLicenca)
    {
        /** @var Permissao $permissao */
        $permissao = $usuario->getFkImobiliarioPermissoes()->filter(
            function ($entry) use ($tipoLicenca) {
                if ($entry->getCodTipo() == $tipoLicenca->getCodTipo()) {
                    return $entry;
                }
            }
        )->first();
        return ($permissao) ? $permissao : null;
    }

    /**
     * @param TipoLicenca $tipoLicenca
     * @param Licenca $licenca
     * @param string $exercicio
     * @param Usuario $usuario
     * @param $form
     * @param $request
     */
    public function concederLicenca(TipoLicenca $tipoLicenca, Licenca $licenca, $exercicio, $usuario, $form, $request)
    {
        $dtAtual = new \DateTime();

        $licenca->setCodLicenca($this->getNextVal($exercicio));
        $licenca->setExercicio($exercicio);
        $licenca->setFkImobiliarioPermissao($this->retornaImobiliarioPermissao($usuario, $tipoLicenca));

        if ($form->get('fkSwProcesso')->getData()) {
            $licencaProcesso = new LicencaProcesso();
            $licencaProcesso->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $licenca->addFkImobiliarioLicencaProcessos($licencaProcesso);
        }

        $licencaDocumento = new LicencaDocumento();
        $licencaDocumento->setNumDocumento($this->retornaLicencaDocumentoNumDocumento($exercicio));
        $licencaDocumento->setFkAdministracaoModeloDocumento($form->get('fkAdministracaoModeloDocumento')->getData());
        $licencaDocumento->setFkImobiliarioLicenca($licenca);

        if ($form->get('emissaoDocumentos')->getData()) {
            $emissaoDocumento = new EmissaoDocumento();
            $emissaoDocumento->setFkAdministracaoUsuario($usuario);
            $emissaoDocumento->setDtEmissao($dtAtual);
            $licencaDocumento->setFkImobiliarioEmissaoDocumento($emissaoDocumento);
        }
        $licenca->addFkImobiliarioLicencaDocumentos($licencaDocumento);

        $responsaveisTecnicos = $request->get('responsaveis-tecnicos');
        foreach ($responsaveisTecnicos as $codigo) {
            if ($codigo != '') {
                list($numcgm, $sequencia) = explode('~', $codigo);
                /** @var Responsavel $responsavel */
                $responsavel = $this->entityManager->getRepository(Responsavel::class)->findOneBy(
                    array(
                        'numcgm' => $numcgm,
                        'sequencia' => $sequencia
                    )
                );
                $licencaResponsavelTecnico = new LicencaResponsavelTecnico();
                $licencaResponsavelTecnico->setFkEconomicoResponsavel($responsavel);
                $licenca->addFkImobiliarioLicencaResponsavelTecnicos($licencaResponsavelTecnico);
            }
        }

        $grupoLicencaLote = [
            TipoLicenca::TIPO_LICENCA_LOTEAMENTO,
            TipoLicenca::TIPO_LICENCA_DESMEMBRAMENTO,
            TipoLicenca::TIPO_LICENCA_AGLUTINACAO
        ];

        $codTipo = $tipoLicenca->getCodTipo();
        if (in_array($codTipo, $grupoLicencaLote)) {
            $licencaLote = new LicencaLote();
            $licencaLote->setFkImobiliarioLote($form->get('fkImobiliarioLote')->getData());
            $licencaLote->setFkImobiliarioLicenca($licenca);

            $licencaLoteArea = new LicencaLoteArea();
            $licencaLoteArea->setArea($form->get('area')->getData());
            $licencaLote->setFkImobiliarioLicencaLoteArea($licencaLoteArea);

            if ($codTipo == TipoLicenca::TIPO_LICENCA_LOTEAMENTO) {
                $licencaLoteLoteamento = new LicencaLoteLoteamento();
                $licencaLoteLoteamento->setFkImobiliarioLoteamento($form->get('fkImobiliarioLoteamento')->getData());
                $licencaLote->addFkImobiliarioLicencaLoteLoteamentos($licencaLoteLoteamento);
            } elseif ($codTipo == TipoLicenca::TIPO_LICENCA_DESMEMBRAMENTO) {
                $licencaLoteParcelamentoSolo = new LicencaLoteParcelamentoSolo();
                $licencaLoteParcelamentoSolo->setFkImobiliarioParcelamentoSolo($form->get('fkImobiliarioParcelamentoSolo')->getData());
                $licencaLote->addFkImobiliarioLicencaLoteParcelamentoSolos($licencaLoteParcelamentoSolo);
            }

            if ($request->get('atributoDinamico')) {
                $this->atributoDinamicoLicencaLote($licencaLote, $request->get('atributoDinamico'), $licenca->getTimestamp());
            }

            $licenca->addFkImobiliarioLicencaLotes($licencaLote);
        } else {
            /** @var Imovel $imovel */
            $imovel = $form->get('fkImobiliarioImovel')->getData();

            $licencaImovel = new LicencaImovel();
            $licencaImovel->setFkImobiliarioImovel($imovel);
            $licencaImovel->setFkImobiliarioLicenca($licenca);

            $licencaImovelArea = new LicencaImovelArea();
            $licencaImovelArea->setArea($form->get('area')->getData());

            $licencaImovel->setFkImobiliarioLicencaImovelArea($licencaImovelArea);

            if ($request->get('atributoDinamico')) {
                $this->atributoDinamicoLicencaImovel($licencaImovel, $request->get('atributoDinamico'), $licenca->getTimestamp());
            }
        }

        if ($codTipo == 1) {
            if ($form->get('novaUnidade')->getData() == LicencaAdmin::NOVA_UNIDADE_CONSTRUCAO) {
                $construcao = $this->novaConstrucao($form, $request);

                $licencaImovelNovaConstrucao = new LicencaImovelNovaConstrucao();
                $licencaImovelNovaConstrucao->setFkImobiliarioConstrucao($construcao);
                $licencaImovel->setFkImobiliarioLicencaImovelNovaConstrucao($licencaImovelNovaConstrucao);
            } else {
                $construcaoEdificacao = $this->novaEdificacao($form, $request);

                $licencaImovelNovaEdificacao = new LicencaImovelNovaEdificacao();
                $licencaImovelNovaEdificacao->setFkImobiliarioConstrucaoEdificacao($construcaoEdificacao);
                $licencaImovel->setFkImobiliarioLicencaImovelNovaEdificacao($licencaImovelNovaEdificacao);
            }
            $licenca->addFkImobiliarioLicencaImoveis($licencaImovel);
        } elseif ($codTipo == 2 || $codTipo == 3 || $codTipo == 4 || $codTipo == 5 || $codTipo == 6) {
            /** @var Construcao $construcao */
            $construcao = $form->get('fkImobiliarioConstrucao')->getData();
            if (!$construcao->getFkImobiliarioUnidadeDependentes()->count()) {
                /** @var UnidadeAutonoma $unidadeAutonoma */
                $unidadeAutonoma = $construcao->getFkImobiliarioConstrucaoEdificacoes()->last()->getFkImobiliarioUnidadeAutonomas()->last();
                $licencaImovelUnidadeAutonoma = new LicencaImovelUnidadeAutonoma();
                $licencaImovelUnidadeAutonoma->setFkImobiliarioUnidadeAutonoma($unidadeAutonoma);
                $licencaImovel->addFkImobiliarioLicencaImovelUnidadeAutonomas($licencaImovelUnidadeAutonoma);
            } else {
                $licencaImovelUnidadeDependente = new LicencaImovelUnidadeDependente();
                $licencaImovelUnidadeDependente->setFkImobiliarioUnidadeDependente($construcao->getFkImobiliarioUnidadeDependentes()->last());
                $licencaImovel->addFkImobiliarioLicencaImovelUnidadeDependentes($licencaImovelUnidadeDependente);
            }
            $licenca->addFkImobiliarioLicencaImoveis($licencaImovel);
        }
    }

    /**
     * @param Licenca $licenca
     * @param $usuario
     * @param $form
     * @param $request
     */
    public function alterarLicenca(Licenca $licenca, $usuario, $form, $request)
    {
        $dtAtual = new \DateTime();

        if (($form->get('fkSwProcesso')->getData()) && ($licenca->getFkImobiliarioLicencaProcessos()->count())) {
            $licencaProcesso = $licenca->getFkImobiliarioLicencaProcessos()->last();
            $licencaProcesso->setFkSwProcesso($form->get('fkSwProcesso')->getData());
        } else {
            $licencaProcesso = new LicencaProcesso();
            $licencaProcesso->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $licenca->addFkImobiliarioLicencaProcessos($licencaProcesso);
        }

        $licencaDocumento = $licenca->getFkImobiliarioLicencaDocumentos()->last();
        $licencaDocumento->setFkAdministracaoModeloDocumento($form->get('fkAdministracaoModeloDocumento')->getData());

        if ($form->get('emissaoDocumentos')->getData()) {
            $emissaoDocumento = new EmissaoDocumento();
            $emissaoDocumento->setFkAdministracaoUsuario($usuario);
            $emissaoDocumento->setDtEmissao($dtAtual);
            $licencaDocumento->setFkImobiliarioEmissaoDocumento($emissaoDocumento);
        }

        if ($licenca->getFkImobiliarioLicencaResponsavelTecnicos()->count()) {
            /** @var LicencaResponsavelTecnico $licencaResponsavelTecnico */
            foreach ($licenca->getFkImobiliarioLicencaResponsavelTecnicos() as $licencaResponsavelTecnico) {
                if (!in_array($this->getObjectIdentifier($licencaResponsavelTecnico), ($request->get('responsaveis-tecnicos-old')) ? $request->get('responsaveis-tecnicos-old') : array())) {
                    $licenca->getFkImobiliarioLicencaResponsavelTecnicos()->removeElement($licencaResponsavelTecnico);
                }
            }
        }

        $responsaveisTecnicos = $request->get('responsaveis-tecnicos');
        foreach ($responsaveisTecnicos as $codigo) {
            if ($codigo != '') {
                list($numcgm, $sequencia) = explode('~', $codigo);
                /** @var Responsavel $responsavel */
                $responsavel = $this->entityManager->getRepository(Responsavel::class)->findOneBy(
                    array(
                        'numcgm' => $numcgm,
                        'sequencia' => $sequencia
                    )
                );
                $licencaResponsavelTecnico = new LicencaResponsavelTecnico();
                $licencaResponsavelTecnico->setFkEconomicoResponsavel($responsavel);
                $licenca->addFkImobiliarioLicencaResponsavelTecnicos($licencaResponsavelTecnico);
            }
        }

        $grupoLicencaLote = [
            TipoLicenca::TIPO_LICENCA_LOTEAMENTO,
            TipoLicenca::TIPO_LICENCA_DESMEMBRAMENTO,
            TipoLicenca::TIPO_LICENCA_AGLUTINACAO
        ];

        $dtms = new DateTimeMicrosecondPK();
        $codTipo = $licenca->getCodTipo();
        if (in_array($codTipo, $grupoLicencaLote)) {
            $licencaLoteArea = $licenca->getFkImobiliarioLicencaLotes()->last()->getFkImobiliarioLicencaLoteArea();
            $licencaLoteArea->setArea($form->get('area')->getData());

            if ($request->get('atributoDinamico')) {
                $this->atributoDinamicoLicencaLote($licenca->getFkImobiliarioLicencaLotes()->last(), $request->get('atributoDinamico'), $dtms);
            }
        } else {
            $licencaImovelArea = $licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioLicencaImovelArea();
            $licencaImovelArea->setArea($form->get('area')->getData());

            if ($request->get('atributoDinamico')) {
                $this->atributoDinamicoLicencaImovel($licenca->getFkImobiliarioLicencaImoveis()->last(), $request->get('atributoDinamico'), $dtms);
            }
        }

        if ($codTipo == 1) {
            $construcaoModel = new ConstrucaoModel($this->entityManager);
            $newTimestamp = new DateTimeMicrosecondPK();
            if ($licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioLicencaImovelNovaConstrucao()) {
                /** @var Construcao $construcao */
                $construcao = $licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioLicencaImovelNovaConstrucao()->getFkImobiliarioConstrucao();
                $construcao->getFkImobiliarioConstrucaoOutros()->setDescricao($form->get('descricao')->getData());
                $construcao->getFkImobiliarioDataConstrucao()->setDataConstrucao($form->get('dtTermino')->getData());
                $construcao->getFkImobiliarioUnidadeDependentes()->last()->getFkImobiliarioAreaUnidadeDependentes()->last()->setArea($form->get('area')->getData());
                if ($request->get('atributoDinamico')) {
                    $construcaoModel->atributoDinamicoOutros($construcao->getFkImobiliarioConstrucaoOutros(), $request->get('atributoDinamico'), $newTimestamp);
                }
            } else {
                /** @var ConstrucaoEdificacao $construcaoEdificacao */
                $construcaoEdificacao = $licenca->getFkImobiliarioLicencaImoveis()->last()->getFkImobiliarioLicencaImovelNovaEdificacao()->getFkImobiliarioConstrucaoEdificacao();
                $construcaoEdificacao->getFkImobiliarioConstrucao()->getFkImobiliarioDataConstrucao()->setDataConstrucao($form->get('dtTermino')->getData());
                if ($construcaoEdificacao->getFkImobiliarioConstrucao()->getFkImobiliarioUnidadeDependentes()->count()) {
                    $construcaoEdificacao->getFkImobiliarioConstrucao()->getFkImobiliarioUnidadeDependentes()->last()->getFkImobiliarioAreaUnidadeDependentes()->last()->setArea($form->get('area')->getData());
                } else {
                    $construcaoEdificacao->getFkImobiliarioUnidadeAutonomas()->last()->getFkImobiliarioAreaUnidadeAutonomas()->last()->setArea($form->get('area')->getData());
                }
                if ($request->get('atributoDinamico')) {
                    $construcaoModel->atributoDinamico($construcaoEdificacao, $request->get('atributoDinamico'), $newTimestamp);
                }
            }
        }
    }

    /**
     * @param $form
     * @param $request
     * @return Construcao
     */
    public function novaConstrucao($form, $request)
    {
        $construcaoModel = new ConstrucaoModel($this->entityManager);

        $construcao = new Construcao();
        $construcao->setCodConstrucao($construcaoModel->getNextVal());

        $dataConstrucao = new DataConstrucao();
        $dataConstrucao->setDataConstrucao($form->get('dtTermino')->getData());
        $construcao->setFkImobiliarioDataConstrucao($dataConstrucao);

        $construcaoOutros = new ConstrucaoOutros();
        $construcaoOutros->setDescricao($form->get('descricao')->getData());
        $construcao->setFkImobiliarioConstrucaoOutros($construcaoOutros);

        /** @var Imovel $imovel */
        $imovel = $form->get('fkImobiliarioImovel')->getData();
        $dados = $construcaoModel->unidadeAutonoma($imovel->getInscricaoMunicipal());

        /** @var UnidadeAutonoma $unidadeAutonoma */
        $unidadeAutonoma = $this
            ->entityManager
            ->getRepository(UnidadeAutonoma::class)
            ->findOneBy(
                array(
                    'inscricaoMunicipal' => $dados['inscricao_municipal'],
                    'codConstrucao' => $dados['cod_construcao']
                )
            );

        $unidadeDependente = new UnidadeDependente();
        $unidadeDependente->setFkImobiliarioUnidadeAutonoma($unidadeAutonoma);
        $unidadeDependente->setFkImobiliarioConstrucao($construcao);

        $areaUnidadeDependente = new AreaUnidadeDependente();
        $areaUnidadeDependente->setArea($form->get('area')->getData());
        $areaUnidadeDependente->setTimestamp($construcao->getTimestamp());
        $areaUnidadeDependente->setFkImobiliarioUnidadeDependente($unidadeDependente);

        $unidadeDependente->addFkImobiliarioAreaUnidadeDependentes($areaUnidadeDependente);

        $construcao->addFkImobiliarioUnidadeDependentes($unidadeDependente);

        if ($request->get('atributoDinamico')) {
            $construcaoModel->atributoDinamicoOutros($construcaoOutros, $request->get('atributoDinamico'), $construcao->getTimestamp());
        }

        return $construcao;
    }

    /**
     * @param $form
     * @param $request
     * @return ConstrucaoEdificacao
     */
    public function novaEdificacao($form, $request)
    {
        $construcaoModel = new ConstrucaoModel($this->entityManager);

        $construcao = new Construcao();
        $construcao->setCodConstrucao($construcaoModel->getNextVal());

        $dataConstrucao = new DataConstrucao();
        $dataConstrucao->setDataConstrucao($form->get('dtTermino')->getData());
        $construcao->setFkImobiliarioDataConstrucao($dataConstrucao);

        $construcaoEdificacao = new ConstrucaoEdificacao();
        $construcaoEdificacao->setFkImobiliarioTipoEdificacao($form->get('fkImobiliarioTipoEdificacao')->getData());
        $construcao->addFkImobiliarioConstrucaoEdificacoes($construcaoEdificacao);

        /** @var Imovel $imovel */
        $imovel = $form->get('fkImobiliarioImovel')->getData();

        if ($imovel->getFkImobiliarioUnidadeAutonomas()->count()) {
            /** @var UnidadeAutonoma $unidadeAutonoma */
            $unidadeAutonoma = $imovel->getFkImobiliarioUnidadeAutonomas()->last();

            $unidadeDependente = new UnidadeDependente();
            $unidadeDependente->setFkImobiliarioUnidadeAutonoma($unidadeAutonoma);
            $unidadeDependente->setFkImobiliarioConstrucao($construcao);

            $areaUnidadeDependente = new AreaUnidadeDependente();
            $areaUnidadeDependente->setArea($form->get('area')->getData());
            $areaUnidadeDependente->setTimestamp($construcao->getTimestamp());
            $areaUnidadeDependente->setFkImobiliarioUnidadeDependente($unidadeDependente);

            $unidadeDependente->addFkImobiliarioAreaUnidadeDependentes($areaUnidadeDependente);

            $construcao->addFkImobiliarioUnidadeDependentes($unidadeDependente);
        } else {
            $unidadeAutonoma = new UnidadeAutonoma();
            $unidadeAutonoma->setFkImobiliarioConstrucaoEdificacao($construcaoEdificacao);
            $unidadeAutonoma->setFkImobiliarioImovel($imovel);

            $areaUnidadeAutonoma = new AreaUnidadeAutonoma();
            $areaUnidadeAutonoma->setFkImobiliarioUnidadeAutonoma($unidadeAutonoma);
            $areaUnidadeAutonoma->setArea($form->get('area')->getData());

            $unidadeAutonoma->addFkImobiliarioAreaUnidadeAutonomas($areaUnidadeAutonoma);
            $imovel->addFkImobiliarioUnidadeAutonomas($unidadeAutonoma);

            $construcaoEdificacao->addFkImobiliarioUnidadeAutonomas($unidadeAutonoma);

            $areaConstrucao = new AreaConstrucao();
            $areaConstrucao->setAreaReal($form->get('area')->getData());
            $construcao->addFkImobiliarioAreaConstrucoes($areaConstrucao);
        }

        if ($request->get('atributoDinamico')) {
            $construcaoModel->atributoDinamico($construcaoEdificacao, $request->get('atributoDinamico'), $construcao->getTimestamp());
        }
        return $construcaoEdificacao;
    }

    /**
     * @param $codLocalizacao
     * @return array
     */
    public function getOptionsLotesByCodLocalizacao($codLocalizacao)
    {
        $qb = $this->entityManager->getRepository(Lote::class)->createQueryBuilder('o');
        $qb->leftJoin('o.fkImobiliarioLoteLocalizacao', 'l');
        $qb->andWhere('l.codLocalizacao = :codLocalizacao');
        $qb->setParameter('codLocalizacao', $codLocalizacao);
        $qb->leftJoin('o.fkImobiliarioBaixaLotes', 'b');
        $qb->andWhere('b.dtInicio is not null AND b.dtTermino is not null OR b.dtInicio is null');
        $qb->orderBy('o.codLote', 'ASC');
        $rlt = $qb->getQuery()->getResult();

        $options = array();

        /** @var Lote $lote */
        foreach ($rlt as $lote) {
            $options[$lote->getCodLote()] = (string) $lote;
        }

        return $options;
    }

    /**
     * @param $codLote
     * @param $novaUnidade
     * @return array
     */
    public function getOptionsImoveisByCodLote($codLote, $novaUnidade)
    {
        $qb = $this->entityManager->getRepository(Imovel::class)->createQueryBuilder('o');
        $qb->leftJoin('o.fkImobiliarioImovelConfrontacao', 'ic');
        if (!$novaUnidade) {
            $qb->leftJoin('o.fkImobiliarioUnidadeAutonomas', 'ua');
            $qb->where('ua.inscricaoMunicipal is not null');
        }
        $qb->andWhere('ic.codLote = :codLote');
        $qb->setParameter('codLote', $codLote);
        $qb->orderBy('o.inscricaoMunicipal', 'ASC');
        $rlt = $qb->getQuery()->getResult();

        $options = array();

        /** @var Imovel $imovel */
        foreach ($rlt as $imovel) {
            $options[$imovel->getInscricaoMunicipal()] = (string) $imovel;
        }

        return $options;
    }

    /**
     * @param $inscricaoMunicipal
     * @return array
     */
    public function getOptionsConstrucoesByIncricaoMunicipal($inscricaoMunicipal)
    {
        $qb = $this->entityManager->getRepository(Construcao::class)->createQueryBuilder('o');
        $qb->leftJoin('o.fkImobiliarioUnidadeDependentes', 'ud');
        $qb->leftJoin('o.fkImobiliarioConstrucaoEdificacoes', 'ce');
        $qb->leftJoin('ce.fkImobiliarioUnidadeAutonomas', 'ua');
        $qb->where($qb->expr()->orX(
            $qb->expr()->eq('ud.inscricaoMunicipal', ':inscricaoMunicipal'),
            $qb->expr()->eq('ua.inscricaoMunicipal', ':inscricaoMunicipal')
        ));
        $qb->setParameter('inscricaoMunicipal', $inscricaoMunicipal);
        $rlt = $qb->getQuery()->getResult();

        $options = array();

        /** @var Construcao $construcao */
        foreach ($rlt as $construcao) {
            $options[$construcao->getCodConstrucao()] = (string) $construcao;
        }

        return $options;
    }

    /**
     * @param $codLote
     * @return array
     */
    public function getOptionsLoteamentosByCodLote($codLote)
    {
        $qb = $this->entityManager->getRepository(Loteamento::class)->createQueryBuilder('o');
        $qb->leftJoin('o.fkImobiliarioLoteamentoLoteOrigens', 'lo');
        $qb->andWhere('lo.codLote = :codLote');
        $qb->setParameter('codLote', $codLote);
        $qb->orderBy('o.codLoteamento', 'ASC');
        $rlt = $qb->getQuery()->getResult();

        $options = array();

        /** @var Loteamento $loteamento */
        foreach ($rlt as $loteamento) {
            $options[$loteamento->getCodLoteamento()] = (string) $loteamento;
        }

        return $options;
    }

    /**
     * @param $codLote
     * @param $codTipo
     * @return array
     */
    public function getOptionsParcelamentosSoloByCodLote($codLote, $codTipo)
    {
        $qb = $this->entityManager->getRepository(ParcelamentoSolo::class)->createQueryBuilder('o');
        $qb->andWhere('o.codLote = :codLote');
        $qb->andWhere('o.codTipo = :codTipo');
        $qb->setParameters([
            'codLote' => $codLote,
            'codTipo' => $codTipo
        ]);
        $qb->orderBy('o.codParcelamento', 'ASC');
        $rlt = $qb->getQuery()->getResult();

        $options = array();

        /** @var ParcelamentoSolo $parcelamentoSolo */
        foreach ($rlt as $parcelamentoSolo) {
            $options[$parcelamentoSolo->getCodParcelamento()] = (string) $parcelamentoSolo;
        }

        return $options;
    }

    /**
     * @param Licenca $licenca
     * @param \DateTime $dtBaixa
     * @param string $motivo
     * @return \Exception|LicencaBaixa
     */
    public function baixarLicenca(Licenca $licenca, $dtBaixa, $motivo)
    {
        try {
            $em = $this->entityManager;

            /** @var TipoBaixa $tipoBaixa */
            $tipoBaixa = $em->getRepository(TipoBaixa::class)->find(TipoBaixa::TIPO_BAIXA_BAIXA);

            $licencaBaixa = new LicencaBaixa();
            $licencaBaixa->setFkImobiliarioTipoBaixa($tipoBaixa);
            $licencaBaixa->setDtInicio($dtBaixa);
            $licencaBaixa->setMotivo($motivo);
            $licencaBaixa->setFkImobiliarioLicenca($licenca);

            $em->persist($licencaBaixa);
            $em->flush();

            return $licencaBaixa;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param Licenca $licenca
     * @return bool
     */
    public function verificaBaixa(Licenca $licenca)
    {
        $baixa = $licenca->getFkImobiliarioLicencaBaixas()->filter(
            function ($entry) {
                if ($entry->getCodTipo() == TipoBaixa::TIPO_BAIXA_BAIXA) {
                    return $entry;
                }
            }
        );
        return ($baixa->count()) ? true : false;
    }

    /**
     * @param Licenca $licenca
     * @param \DateTime $dtSuspensao
     * @param \DateTime $dtTermino
     * @param string $motivo
     * @return \Exception|LicencaBaixa
     */
    public function suspenderLicenca(Licenca $licenca, $dtSuspensao, $dtTermino, $motivo)
    {
        try {
            $em = $this->entityManager;

            /** @var TipoBaixa $tipoBaixa */
            $tipoBaixa = $em->getRepository(TipoBaixa::class)->find(TipoBaixa::TIPO_BAIXA_SUSPENSAO);

            $licencaBaixa = new LicencaBaixa();
            $licencaBaixa->setFkImobiliarioTipoBaixa($tipoBaixa);
            $licencaBaixa->setDtInicio($dtSuspensao);
            if ($dtTermino) {
                $licencaBaixa->setDtTermino($dtTermino);
            }
            $licencaBaixa->setMotivo($motivo);
            $licencaBaixa->setFkImobiliarioLicenca($licenca);

            $em->persist($licencaBaixa);
            $em->flush();

            return $licencaBaixa;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param Licenca $licenca
     * @return bool
     */
    public function verificaSuspensao(Licenca $licenca)
    {
        $baixa = $licenca->getFkImobiliarioLicencaBaixas()->filter(
            function ($entry) {
                if (($entry->getCodTipo() == TipoBaixa::TIPO_BAIXA_SUSPENSAO) && ($entry->getDtTermino() >= (new \DateTime()))) {
                    return $entry;
                }
            }
        );
        return ($baixa->count()) ? true : false;
    }

    /**
     * @param Licenca $licenca
     * @param \DateTime $dtTermino
     * @param string $motivo
     * @return \Exception|LicencaBaixa
     */
    public function cancelarSuspensaoLicenca(Licenca $licenca, $dtTermino, $motivo)
    {
        try {
            $em = $this->entityManager;

            $licencaBaixa = $licenca->getFkImobiliarioLicencaBaixas()->filter(
                function ($entry) {
                    if (($entry->getCodTipo() == TipoBaixa::TIPO_BAIXA_SUSPENSAO) && (!$entry->getDtTermino())) {
                        return $entry;
                    }
                }
            )->first();

            $licencaBaixa->setDtTermino($dtTermino);
            $licencaBaixa->setMotivo($motivo);
            $licencaBaixa->setFkImobiliarioLicenca($licenca);

            $em->persist($licencaBaixa);
            $em->flush();

            return $licencaBaixa;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param Licenca $licenca
     * @return bool
     */
    public function verificaSuspensaoACancelar(Licenca $licenca)
    {
        $baixa = $licenca->getFkImobiliarioLicencaBaixas()->filter(
            function ($entry) {
                if (($entry->getCodTipo() == TipoBaixa::TIPO_BAIXA_SUSPENSAO) && (!$entry->getDtTermino())) {
                    return $entry;
                }
            }
        );
        return ($baixa->count()) ? true : false;
    }

    /**
     * @param Licenca $licenca
     * @param \DateTime $dtCassacao
     * @param string $motivo
     * @return \Exception|LicencaBaixa
     */
    public function cassarLicenca(Licenca $licenca, $dtCassacao, $motivo)
    {
        try {
            $em = $this->entityManager;

            /** @var TipoBaixa $tipoBaixa */
            $tipoBaixa = $em->getRepository(TipoBaixa::class)->find(TipoBaixa::TIPO_BAIXA_CASSACAO);

            $licencaBaixa = new LicencaBaixa();
            $licencaBaixa->setFkImobiliarioTipoBaixa($tipoBaixa);
            $licencaBaixa->setDtInicio($dtCassacao);
            $licencaBaixa->setMotivo($motivo);
            $licencaBaixa->setFkImobiliarioLicenca($licenca);

            $em->persist($licencaBaixa);
            $em->flush();

            return $licencaBaixa;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param Licenca $licenca
     * @return bool
     */
    public function verificaCassacao(Licenca $licenca)
    {
        $baixa = $licenca->getFkImobiliarioLicencaBaixas()->filter(
            function ($entry) {
                if ($entry->getCodTipo() == TipoBaixa::TIPO_BAIXA_CASSACAO) {
                    return $entry;
                }
            }
        );
        return ($baixa->count()) ? true : false;
    }

    /**
     * @param LicencaImovel $licencaImovel
     * @param $atributosDinamicos
     * @param $dtAtual
     */
    public function atributoDinamicoLicencaImovel(LicencaImovel $licencaImovel, $atributosDinamicos, $dtAtual)
    {
        $em = $this->entityManager;
        $atributoDinamicoModel = new AtributoDinamicoModel($em);

        foreach ($atributosDinamicos as $codAtributo => $valorAtributo) {
            /** @var AtributoTipoLicenca $atributoTipoLicenca */
            $atributoTipoLicenca = $em->getRepository(AtributoTipoLicenca::class)
                ->findOneBy(
                    array(
                        'codTipo' => $licencaImovel->getFkImobiliarioLicenca()->getCodTipo(),
                        'codAtributo' => $codAtributo,
                        'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO,
                        'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_LICENCAS
                    )
                );

            if ($atributoTipoLicenca) {
                $atributoTipoLicencaImovelValor = new AtributoTipoLicencaImovelValor();
                $atributoTipoLicencaImovelValor->setFkImobiliarioAtributoTipoLicenca($atributoTipoLicenca);
                $valor = $atributoDinamicoModel
                    ->processaAtributoDinamicoPersist(
                        $atributoTipoLicenca,
                        $valorAtributo
                    );
                $atributoTipoLicencaImovelValor->setValor($valor);
                $atributoTipoLicencaImovelValor->setTimestamp($dtAtual);
                $licencaImovel->addFkImobiliarioAtributoTipoLicencaImovelValores($atributoTipoLicencaImovelValor);
            }
        }
    }

    /**
     * @param LicencaLote $licencaLote
     * @param $atributosDinamicos
     * @param $dtAtual
     */
    public function atributoDinamicoLicencaLote(LicencaLote $licencaLote, $atributosDinamicos, $dtAtual)
    {
        $em = $this->entityManager;
        $atributoDinamicoModel = new AtributoDinamicoModel($em);

        foreach ($atributosDinamicos as $codAtributo => $valorAtributo) {
            /** @var AtributoTipoLicenca $atributoTipoLicenca */
            $atributoTipoLicenca = $em->getRepository(AtributoTipoLicenca::class)
                ->findOneBy(
                    array(
                        'codTipo' => $licencaLote->getFkImobiliarioLicenca()->getCodTipo(),
                        'codAtributo' => $codAtributo,
                        'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO,
                        'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_LICENCAS
                    )
                );

            if ($atributoTipoLicenca) {
                $atributoTipoLicencaLoteValor = new AtributoTipoLicencaLoteValor();
                $atributoTipoLicencaLoteValor->setFkImobiliarioAtributoTipoLicenca($atributoTipoLicenca);
                $valor = $atributoDinamicoModel
                    ->processaAtributoDinamicoPersist(
                        $atributoTipoLicenca,
                        $valorAtributo
                    );
                $atributoTipoLicencaLoteValor->setValor($valor);
                $atributoTipoLicencaLoteValor->setTimestamp($dtAtual);
                $licencaLote->addFkImobiliarioAtributoTipoLicencaLoteValores($atributoTipoLicencaLoteValor);
            }
        }
    }
}
