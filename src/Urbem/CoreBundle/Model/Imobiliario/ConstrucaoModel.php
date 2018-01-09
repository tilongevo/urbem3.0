<?php

namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Imobiliario\AreaConstrucao;
use Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeAutonoma;
use Urbem\CoreBundle\Entity\Imobiliario\AreaUnidadeDependente;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoConstrucaoOutrosValor;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacao;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoEdificacaoValor;
use Urbem\CoreBundle\Entity\Imobiliario\Construcao;
use Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoCondominio;
use Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoEdificacao;
use Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoOutros;
use Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso;
use Urbem\CoreBundle\Entity\Imobiliario\DataConstrucao;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\UnidadeAutonoma;
use Urbem\CoreBundle\Entity\Imobiliario\UnidadeDependente;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;

class ConstrucaoModel extends AbstractModel
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
        $this->repository = $this->entityManager->getRepository(Construcao::class);
    }

    /**
     * @return int
     */
    public function getNextVal()
    {
        return $this->repository->getNextVal();
    }

    /**
     * @param Construcao $construcao
     * @return bool
     */
    public function verificaBaixa(Construcao $construcao)
    {
        $baixa = $construcao->getFkImobiliarioBaixaConstrucoes()->filter(
            function ($entry) {
                if (!$entry->getDtTermino()) {
                    return $entry;
                }
            }
        );
        return ($baixa->count()) ? true : false;
    }

    /**
     * @param $inscricaoMunicipal
     * @return mixed
     */
    public function cadastroImobiliario($inscricaoMunicipal)
    {
        return $this->repository->cadastroImobiliario($inscricaoMunicipal);
    }

    /**
     * @param $inscricaoMunicipal
     * @return mixed
     */
    public function areaImovel($inscricaoMunicipal)
    {
        return $this->repository->areaImovel($inscricaoMunicipal);
    }

    /**
     * @param $inscricaoMunicipal
     * @return mixed
     */
    public function unidadeAutonoma($inscricaoMunicipal)
    {
        return $this->repository->unidadeAutonoma($inscricaoMunicipal);
    }

    /**
     * @param Construcao $construcao
     * @param null $timestamp
     * @return array
     */
    public function getNomAtributoValorByConstrucao(Construcao $construcao, $timestamp = null)
    {
        if (!$timestamp) {
            $timestamp = ($construcao->getFkImobiliarioConstrucaoEdificacoes()->last()->getFkImobiliarioAtributoTipoEdificacaoValores()->count())
                ? $construcao->getFkImobiliarioConstrucaoEdificacoes()->last()->getFkImobiliarioAtributoTipoEdificacaoValores()->last()->getTimestamp()
                : null;
        }

        $atributosDinamicos = array();

        $atributoTipoEdificacaoValores = $construcao->getFkImobiliarioConstrucaoEdificacoes()->last()->getFkImobiliarioAtributoTipoEdificacaoValores()->filter(
            function ($entry) use ($timestamp) {
                if ($entry->getTimestamp() == $timestamp) {
                    return $entry;
                }
            }
        );

        /** @var AtributoTipoEdificacaoValor $atributoTipoEdificacaoValor */
        foreach ($atributoTipoEdificacaoValores as $atributoTipoEdificacaoValor) {
            $atributoDinamico = $atributoTipoEdificacaoValor->getFkImobiliarioAtributoTipoEdificacao()->getFkAdministracaoAtributoDinamico();
            $atributosDinamicos[$atributoDinamico->getCodAtributo()]['nomAtributo'] = $atributoDinamico->getNomAtributo();
            $selecteds = explode(',', $atributoTipoEdificacaoValor->getValor());
            if ($atributoDinamico->getCodTipo() == AtributoDinamico::COD_TIPO_LISTA || $atributoDinamico->getCodTipo() == AtributoDinamico::COD_TIPO_LISTA_MULTIPLA) {
                foreach ($atributoDinamico->getFkAdministracaoAtributoValorPadroes() as $atributoValorPadrao) {
                    if (in_array($atributoValorPadrao->getCodValor(), $selecteds)) {
                        $atributosDinamicos[$atributoDinamico->getCodAtributo()]['valor'][] = $atributoValorPadrao->getValorPadrao();
                    }
                }
            } else {
                $atributosDinamicos[$atributoDinamico->getCodAtributo()]['valor'][] = $atributoTipoEdificacaoValor->getValor();
            }
        }
        return $atributosDinamicos;
    }

    /**
     * @param ConstrucaoOutros $construcaoOutros
     * @param null $timestamp
     * @return array
     */
    public function getNomAtributoValorByConstrucaoOutros(ConstrucaoOutros $construcaoOutros, $timestamp = null)
    {
        if (!$timestamp) {
            $timestamp = ($construcaoOutros->getFkImobiliarioAtributoConstrucaoOutrosValores()->count())
                ? $construcaoOutros->getFkImobiliarioAtributoConstrucaoOutrosValores()->last()->getTimestamp()
                : null;
        }

        $atributosDinamicos = array();

        $atributoConstrucaoOutrosValores = $construcaoOutros->getFkImobiliarioAtributoConstrucaoOutrosValores()->filter(
            function ($entry) use ($timestamp) {
                if ($entry->getTimestamp() == $timestamp) {
                    return $entry;
                }
            }
        );

        /** @var AtributoConstrucaoOutrosValor $atributoConstrucaoOutrosValor */
        foreach ($atributoConstrucaoOutrosValores as $atributoConstrucaoOutrosValor) {
            $atributoDinamico = $atributoConstrucaoOutrosValor->getFkAdministracaoAtributoDinamico();
            $atributosDinamicos[$atributoDinamico->getCodAtributo()]['nomAtributo'] = $atributoDinamico->getNomAtributo();
            $selecteds = explode(',', $atributoConstrucaoOutrosValor->getValor());
            if ($atributoDinamico->getCodTipo() == AtributoDinamico::COD_TIPO_LISTA || $atributoDinamico->getCodTipo() == AtributoDinamico::COD_TIPO_LISTA_MULTIPLA) {
                foreach ($atributoDinamico->getFkAdministracaoAtributoValorPadroes() as $atributoValorPadrao) {
                    if (in_array($atributoValorPadrao->getCodValor(), $selecteds)) {
                        $atributosDinamicos[$atributoDinamico->getCodAtributo()]['valor'][] = $atributoValorPadrao->getValorPadrao();
                    }
                }
            } else {
                $atributosDinamicos[$atributoDinamico->getCodAtributo()]['valor'][] = $atributoConstrucaoOutrosValor->getValor();
            }
        }
        return $atributosDinamicos;
    }

    /**
     * @param ConstrucaoEdificacao $construcaoEdificacao
     * @param $atributosDinamicos
     * @param $dtAtual
     */
    public function atributoDinamico(ConstrucaoEdificacao $construcaoEdificacao, $atributosDinamicos, $dtAtual)
    {
        $em = $this->entityManager;
        $atributoDinamicoModel = new AtributoDinamicoModel($em);

        foreach ($atributosDinamicos as $codAtributo => $valorAtributo) {
            /** @var AtributoTipoEdificacao $atributoTipoEdificacao */
            $atributoTipoEdificacao = $em->getRepository(AtributoTipoEdificacao::class)
                ->findOneBy(
                    array(
                        'codTipo' => $construcaoEdificacao->getFkImobiliarioTipoEdificacao()->getCodTipo(),
                        'codAtributo' => $codAtributo,
                        'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO,
                        'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_TIPO_EDIFICACAO
                    )
                );

            if ($atributoTipoEdificacao) {
                $atributoTipoEdificacaoValor = new AtributoTipoEdificacaoValor();
                $atributoTipoEdificacaoValor->setFkImobiliarioAtributoTipoEdificacao($atributoTipoEdificacao);

                $valor = $atributoDinamicoModel
                    ->processaAtributoDinamicoPersist(
                        $atributoTipoEdificacao,
                        $valorAtributo
                    );

                $atributoTipoEdificacaoValor->setValor($valor);
                $atributoTipoEdificacaoValor->setTimestamp($dtAtual);

                $construcaoEdificacao->addFkImobiliarioAtributoTipoEdificacaoValores($atributoTipoEdificacaoValor);
            }
        }
    }

    /**
     * @param ConstrucaoOutros $construcaoOutros
     * @param $atributosDinamicos
     * @param $dtAtual
     */
    public function atributoDinamicoOutros(ConstrucaoOutros $construcaoOutros, $atributosDinamicos, $dtAtual)
    {
        $em = $this->entityManager;
        $atributoDinamicoModel = new AtributoDinamicoModel($em);

        foreach ($atributosDinamicos as $codAtributo => $valorAtributo) {
            /** @var AtributoDinamico $atributoDinamico */
            $atributoDinamico = $em->getRepository(AtributoDinamico::class)
                ->findOneBy(
                    array(
                        'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO,
                        'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_CONSTRUCAO,
                        'codAtributo' => $codAtributo
                    )
                );

            if ($atributoDinamico) {
                $atributoConstrucaoOutrosValor = new AtributoConstrucaoOutrosValor();
                $atributoConstrucaoOutrosValor->setFkAdministracaoAtributoDinamico($atributoDinamico);

                $valor = $atributoDinamicoModel
                    ->processaAtributoDinamicoPersist(
                        $atributoConstrucaoOutrosValor,
                        $valorAtributo
                    );

                $atributoConstrucaoOutrosValor->setValor($valor);
                $atributoConstrucaoOutrosValor->setTimestamp($dtAtual);

                $construcaoOutros->addFkImobiliarioAtributoConstrucaoOutrosValores($atributoConstrucaoOutrosValor);
            }
        }
    }

    /**
     * @param Construcao $construcao
     * @param $form
     * @param $request
     */
    public function popularConstrucaoEdificacao(Construcao $construcao, $form, $request)
    {
        $construcao->setCodConstrucao($this->getNextVal());

        $dataConstrucao = new DataConstrucao();
        $dataConstrucao->setDataConstrucao($form->get('dataConstrucao')->getData());
        $construcao->setFkImobiliarioDataConstrucao($dataConstrucao);

        if ($form->get('fkSwProcesso')->getData()) {
            $construcaoProcesso = new ConstrucaoProcesso();
            $construcaoProcesso->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $construcaoProcesso->setTimestamp($construcao->getTimestamp());
            $construcao->addFkImobiliarioConstrucaoProcessos($construcaoProcesso);
        }

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
            $areaUnidadeDependente->setArea($form->get('areaReal')->getData());
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
            $areaUnidadeAutonoma->setArea($form->get('areaReal')->getData());

            $unidadeAutonoma->addFkImobiliarioAreaUnidadeAutonomas($areaUnidadeAutonoma);
            $imovel->addFkImobiliarioUnidadeAutonomas($unidadeAutonoma);

            $construcaoEdificacao->addFkImobiliarioUnidadeAutonomas($unidadeAutonoma);

            $areaConstrucao = new AreaConstrucao();
            $areaConstrucao->setAreaReal($form->get('areaReal')->getData());
            $construcao->addFkImobiliarioAreaConstrucoes($areaConstrucao);
        }

        if ($request->get('atributoDinamico')) {
            $this->atributoDinamico($construcaoEdificacao, $request->get('atributoDinamico'), $construcao->getTimestamp());
        }
    }

    /**
     * @param Construcao $construcao
     * @param $form
     */
    public function alterarConstrucaoEdificacao(Construcao $construcao, $form)
    {
        if (($form->get('fkSwProcesso')->getData()) && (!$construcao->getFkImobiliarioConstrucaoProcessos()->count())) {
            $construcaoProcesso = new ConstrucaoProcesso();
            $construcaoProcesso->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $construcaoProcesso->setTimestamp($construcao->getTimestamp());
            $construcao->addFkImobiliarioConstrucaoProcessos($construcaoProcesso);
        }

        if ($construcao->getFkImobiliarioDataConstrucao()) {
            $dataConstrucao = $construcao->getFkImobiliarioDataConstrucao();
            $dataConstrucao->setDataConstrucao($form->get('dataConstrucao')->getData());
        } else {
            $dataConstrucao = new DataConstrucao();
            $dataConstrucao->setDataConstrucao($form->get('dataConstrucao')->getData());
            $construcao->setFkImobiliarioDataConstrucao($dataConstrucao);
        }

        if ($construcao->getFkImobiliarioUnidadeDependentes()->count()) {
            $construcao->getFkImobiliarioUnidadeDependentes()->last()->getFkImobiliarioAreaUnidadeDependentes()->last()->setArea($form->get('areaReal')->getData());
        }

        if ($construcao->getFkImobiliarioAreaConstrucoes()->count()) {
            $construcao->getFkImobiliarioAreaConstrucoes()->last()->setAreaReal($form->get('areaReal')->getData());

            /** @var Imovel $imovel */
            $imovel = $form->get('fkImobiliarioImovel')->getData();

            if ($imovel->getFkImobiliarioUnidadeAutonomas()->count()) {
                $imovel->getFkImobiliarioUnidadeAutonomas()->last()->getFkImobiliarioAreaUnidadeAutonomas()->last()->setArea($form->get('areaReal')->getData());
                $this->entityManager->persist($imovel);
            }
        }
    }

    /**
     * @param Construcao $construcao
     * @param $form
     * @param $request
     */
    public function popularConstrucaoCondominio(Construcao $construcao, $form, $request)
    {
        $construcao->setCodConstrucao($this->getNextVal());

        $dataConstrucao = new DataConstrucao();
        $dataConstrucao->setDataConstrucao($form->get('dataConstrucao')->getData());
        $construcao->setFkImobiliarioDataConstrucao($dataConstrucao);

        if ($form->get('fkSwProcesso')->getData()) {
            $construcaoProcesso = new ConstrucaoProcesso();
            $construcaoProcesso->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $construcaoProcesso->setTimestamp($construcao->getTimestamp());
            $construcao->addFkImobiliarioConstrucaoProcessos($construcaoProcesso);
        }

        $areaConstrucao = new AreaConstrucao();
        $areaConstrucao->setAreaReal($form->get('areaReal')->getData());
        $construcao->addFkImobiliarioAreaConstrucoes($areaConstrucao);

        $construcaoEdificacao = new ConstrucaoEdificacao();
        $construcaoEdificacao->setFkImobiliarioTipoEdificacao($form->get('fkImobiliarioTipoEdificacao')->getData());
        $construcao->addFkImobiliarioConstrucaoEdificacoes($construcaoEdificacao);

        if ($form->get('fkImobiliarioCondominio')->getData()) {
            $construcaoCondominio = new ConstrucaoCondominio();
            $construcaoCondominio->setFkImobiliarioCondominio($form->get('fkImobiliarioCondominio')->getData());
            $construcao->addFkImobiliarioConstrucaoCondominios($construcaoCondominio);

            if ($request->get('atributoDinamico')) {
                $this->atributoDinamico($construcaoEdificacao, $request->get('atributoDinamico'), $construcao->getTimestamp());
            }
        }
    }

    /**
     * @param Construcao $construcao
     * @param $form
     */
    public function alterarConstrucaoCondominio(Construcao $construcao, $form)
    {
        $dataConstrucao = $construcao->getFkImobiliarioDataConstrucao();
        $dataConstrucao->setDataConstrucao($form->get('dataConstrucao')->getData());

        if (($form->get('fkSwProcesso')->getData()) && (!$construcao->getFkImobiliarioConstrucaoProcessos()->count())) {
            $construcaoProcesso = new ConstrucaoProcesso();
            $construcaoProcesso->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $construcaoProcesso->setTimestamp($construcao->getTimestamp());
            $construcao->addFkImobiliarioConstrucaoProcessos($construcaoProcesso);
        }

        $areaConstrucao = $construcao->getFkImobiliarioAreaConstrucoes()->last();
        $areaConstrucao->setAreaReal($form->get('areaReal')->getData());
    }

    /**
     * @param Construcao $construcao
     * @param $form
     * @param $request
     */
    public function popularConstrucaoOutros(Construcao $construcao, $form, $request)
    {
        $construcao->setCodConstrucao($this->getNextVal());

        $dataConstrucao = new DataConstrucao();
        $dataConstrucao->setDataConstrucao($form->get('dataConstrucao')->getData());
        $construcao->setFkImobiliarioDataConstrucao($dataConstrucao);

        if ($form->get('fkSwProcesso')->getData()) {
            $construcaoProcesso = new ConstrucaoProcesso();
            $construcaoProcesso->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $construcaoProcesso->setTimestamp($construcao->getTimestamp());
            $construcao->addFkImobiliarioConstrucaoProcessos($construcaoProcesso);
        }

        $construcaoOutros = new ConstrucaoOutros();
        $construcaoOutros->setDescricao($form->get('descricao')->getData());
        $construcao->setFkImobiliarioConstrucaoOutros($construcaoOutros);

        /** @var Imovel $imovel */
        $imovel = $form->get('fkImobiliarioImovel')->getData();
        $dados = $this->unidadeAutonoma($imovel->getInscricaoMunicipal());

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
            $this->atributoDinamicoOutros($construcaoOutros, $request->get('atributoDinamico'), $construcao->getTimestamp());
        }
    }

    /**
     * @param Construcao $construcao
     * @param $form
     */
    public function alterarConstrucaoOutros(Construcao $construcao, $form)
    {
        $construcao->getFkImobiliarioDataConstrucao()->setDataConstrucao($form->get('dataConstrucao')->getData());
        $construcao->getFkImobiliarioConstrucaoOutros()->setDescricao($form->get('descricao')->getData());
        $construcao->getFkImobiliarioUnidadeDependentes()->last()->getFkImobiliarioAreaUnidadeDependentes()->last()->setArea($form->get('area')->getData());

        if (($form->get('fkSwProcesso')->getData()) && (!$construcao->getFkImobiliarioConstrucaoProcessos()->count())) {
            $construcaoProcesso = new ConstrucaoProcesso();
            $construcaoProcesso->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $construcaoProcesso->setTimestamp($construcao->getTimestamp());
            $construcao->addFkImobiliarioConstrucaoProcessos($construcaoProcesso);
        }
    }

    /**
     * @param Construcao $construcao
     * @param $form
     * @param $request
     */
    public function popularConstrucaoOutrosCondominio(Construcao $construcao, $form, $request)
    {
        $construcao->setCodConstrucao($this->getNextVal());

        $dataConstrucao = new DataConstrucao();
        $dataConstrucao->setDataConstrucao($form->get('dataConstrucao')->getData());
        $construcao->setFkImobiliarioDataConstrucao($dataConstrucao);

        if ($form->get('fkSwProcesso')->getData()) {
            $construcaoProcesso = new ConstrucaoProcesso();
            $construcaoProcesso->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $construcaoProcesso->setTimestamp($construcao->getTimestamp());
            $construcao->addFkImobiliarioConstrucaoProcessos($construcaoProcesso);
        }

        $areaConstrucao = new AreaConstrucao();
        $areaConstrucao->setAreaReal($form->get('area')->getData());
        $construcao->addFkImobiliarioAreaConstrucoes($areaConstrucao);

        $construcaoOutros = new ConstrucaoOutros();
        $construcaoOutros->setDescricao($form->get('descricao')->getData());
        $construcao->setFkImobiliarioConstrucaoOutros($construcaoOutros);

        if ($form->get('fkImobiliarioCondominio')->getData()) {
            $construcaoCondominio = new ConstrucaoCondominio();
            $construcaoCondominio->setFkImobiliarioCondominio($form->get('fkImobiliarioCondominio')->getData());
            $construcao->addFkImobiliarioConstrucaoCondominios($construcaoCondominio);
        }

        if ($request->get('atributoDinamico')) {
            $this->atributoDinamicoOutros($construcaoOutros, $request->get('atributoDinamico'), $construcao->getTimestamp());
        }
    }

    /**
     * @param Construcao $construcao
     * @param $form
     */
    public function alterarConstrucaoOutrosCondominio(Construcao $construcao, $form)
    {
        $construcao->getFkImobiliarioDataConstrucao()->setDataConstrucao($form->get('dataConstrucao')->getData());
        if ($construcao->getFkImobiliarioAreaConstrucoes()->count()) {
            $construcao->getFkImobiliarioAreaConstrucoes()->last()->setAreaReal($form->get('area')->getData());
        } else {
            $areaConstrucao = new AreaConstrucao();
            $areaConstrucao->setAreaReal($form->get('area')->getData());
            $construcao->addFkImobiliarioAreaConstrucoes($areaConstrucao);
        }
        $construcao->getFkImobiliarioConstrucaoOutros()->setDescricao($form->get('descricao')->getData());

        if (($form->get('fkSwProcesso')->getData()) && (!$construcao->getFkImobiliarioConstrucaoProcessos()->count())) {
            $construcaoProcesso = new ConstrucaoProcesso();
            $construcaoProcesso->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $construcaoProcesso->setTimestamp($construcao->getTimestamp());
            $construcao->addFkImobiliarioConstrucaoProcessos($construcaoProcesso);
        }
    }

    /**
     * @param Construcao $construcao
     * @return bool
     */
    public function verificaDependentes(Construcao $construcao)
    {
        $unidadeDependente = $this->entityManager->getRepository(UnidadeDependente::class)
            ->findOneBy(
                array(
                    'codConstrucao' => $construcao->getCodConstrucao()
                )
            );
        return ($unidadeDependente) ? true : false;
    }
    
    /**
     * @param array $where
     * @param array $param
     * @param string $order
     * @return array
     */
    public function getCaracteristicasEdificacao(Array $where = [], Array $param = [], $order = null)
    {
        return $this->repository->getCaracteristicasEdificacao($where, $param, $order);
    }
}
