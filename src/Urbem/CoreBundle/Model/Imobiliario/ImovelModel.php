<?php

namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor;
use Urbem\CoreBundle\Entity\Imobiliario\Confrontacao;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelConfrontacao;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelImobiliaria;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelLote;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\MatriculaImovel;
use Urbem\CoreBundle\Entity\Imobiliario\Proprietario;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwBairroLogradouro;
use Urbem\CoreBundle\Entity\SwCepLogradouro;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwLogradouro;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Repository\Imobiliario\ImovelRepository;

class ImovelModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ImovelRepository
     */
    protected $repository;

    /**
     * NivelModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Imovel::class);
    }

    /**
     * @return int
     */
    public function getProximoInscricaoMunicipal()
    {
        /** @var Imovel $lastImovel */
        $lastImovel = $this->repository->findOneBy(array(), array('inscricaoMunicipal' => 'DESC'));
        return ($lastImovel) ? $lastImovel->getInscricaoMunicipal() + 1 : 1;
    }

    /**
     * @return int
     */
    public function getProximoCodSublote()
    {
        /** @var Imovel $lastImovel */
        $lastImovel = $this->repository->findOneBy(array(), array('codSublote' => 'DESC'));
        return ($lastImovel) ? $lastImovel->getCodSublote() + 1 : 1;
    }

    /**
     * @param Imovel $imovel
     * @return bool
     */
    public function verificaBaixa(Imovel $imovel)
    {
        $baixa = $imovel->getFkImobiliarioBaixaImoveis()->filter(
            function ($entry) {
                if (!$entry->getDtTermino()) {
                    return $entry;
                }
            }
        );
        return ($baixa->count()) ? true : false;
    }

    /**
     * @return bool
     */
    public function verificaCaracteristicas()
    {
        $caracteristicas = $this
            ->entityManager
            ->getRepository(AtributoDinamico::class)
            ->findOneBy(
                array(
                    'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO,
                    'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_IMOVEL
                )
            );
        return ($caracteristicas) ? true : false;
    }

    /**
     * @param Imovel $imovel
     * @param $form
     * @param $request
     */
    public function salvarImovel(Imovel $imovel, $form, $request)
    {
        $em = $this->entityManager;

        /** @var SwCepLogradouro $swCepLogradouro */
        $swCepLogradouro = $form->get('cep')->getData();

        $imovel->setInscricaoMunicipal($this->getProximoInscricaoMunicipal());
        $imovel->setCodSublote($this->getProximoCodSublote());
        $imovel->setCep($swCepLogradouro->getCep());

        if ($form->get('imobiliariaImovel_creci')->getData()) {
            $imovelImobiliaria = new ImovelImobiliaria();
            $imovelImobiliaria->setFkImobiliarioImovel($imovel);
            $imovelImobiliaria->setTimestamp($imovel->getTimestamp());
            $imovelImobiliaria->setFkImobiliarioCorretagem($form->get('imobiliariaImovel_creci')->getData());
            $imovel->setFkImobiliarioImovelImobiliaria($imovelImobiliaria);
        }

        if ($form->get('fkSwProcesso')->getData()) {
            $imovelProcesso = new ImovelProcesso();
            $imovelProcesso->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $imovelProcesso->setTimestamp($imovel->getTimestamp());
            $imovel->addFkImobiliarioImovelProcessos($imovelProcesso);
        }

        $matriculaImovel = new MatriculaImovel();
        $matriculaImovel->setMatRegistroImovel($form->get('matriculaImovel_matRegistroImovel')->getData());
        $matriculaImovel->setZona($form->get('matriculaImovel_zona')->getData());
        $imovel->addFkImobiliarioMatriculaImoveis($matriculaImovel);

        $imovelLote = new ImovelLote();
        $imovelLote->setFkImobiliarioLote($form->get('lote')->getData());
        $imovel->addFkImobiliarioImovelLotes($imovelLote);

        /** @var SwLogradouro $logradouro */
        $logradouro = $form->get('endereco')->getData();

        /** @var Lote $lote */
        $lote = $form->get('lote')->getData();
        /** @var Confrontacao $confrontacao */
        $confrontacao = $lote->getFkImobiliarioConfrontacoes()->filter(
            function ($entry) use ($logradouro) {
                if ($entry->getFkImobiliarioConfrontacaoTrecho()) {
                    if (($entry->getFkImobiliarioConfrontacaoTrecho()->getPrincipal()) && ($entry->getFkImobiliarioConfrontacaoTrecho()->getCodLogradouro() == $logradouro->getCodLogradouro() )) {
                        return $entry;
                    }
                }
            }
        )->first();

        $imovelConfrontacao = new ImovelConfrontacao();
        $imovelConfrontacao->setFkImobiliarioConfrontacaoTrecho($confrontacao->getFkImobiliarioConfrontacaoTrecho());
        $imovel->setFkImobiliarioImovelConfrontacao($imovelConfrontacao);

        $this->manterProprietarios($imovel, $request);

        if ($form->get('imovelCorrespondencia')->getData()) {
            /** @var SwCepLogradouro $swCepLogradouro */
            $swCepLogradouro = $form->get('correspondencia_cep')->getData();

            /** @var SwBairro $swBairro */
            $swBairro = $form->get('fkSwBairro')->getData();
            /** @var SwLogradouro $swLogradouro */
            $swLogradouro = $form->get('fkSwLogradouro')->getData();

            /** @var SwBairroLogradouro $swBairroLogradouro */
            $swBairroLogradouro = $em->getRepository(SwBairroLogradouro::class)
                ->findOneBy(
                    array(
                        'codUf' => $swBairro->getCodUf(),
                        'codMunicipio' => $swBairro->getCodMunicipio(),
                        'codBairro' => $swBairro->getCodBairro(),
                        'codLogradouro' => $swLogradouro->getCodLogradouro()
                    )
                );

            if (!$swBairroLogradouro) {
                $swBairroLogradouro = new SwBairroLogradouro();
                $swBairroLogradouro->setFkSwLogradouro($swLogradouro);
                $swBairroLogradouro->setFkSwBairro($swBairro);
            }

            $imovelCorrespondencia = new ImovelCorrespondencia();
            $imovelCorrespondencia->setCep($swCepLogradouro->getCep());
            $imovelCorrespondencia->setNumero($form->get('correspondencia_numero')->getData());
            $imovelCorrespondencia->setCaixaPostal($form->get('correspondencia_caixa_postal')->getData());
            $imovelCorrespondencia->setComplemento(($form->get('correspondencia_complemento')->getData()) ? $form->get('correspondencia_complemento')->getData() : '');
            $imovelCorrespondencia->setFkSwLogradouro($swLogradouro);
            $imovelCorrespondencia->setFkSwBairroLogradouro($swBairroLogradouro);
            $imovel->addFkImobiliarioImovelCorrespondencias($imovelCorrespondencia);
        }

        $this->atributoDinamico($imovel, $request->get('atributoDinamico'), $imovel->getTimestamp(), false);
    }

    /**
     * @param Imovel $imovel
     * @param $form
     * @param $request
     */
    public function alterarImovel(Imovel $imovel, $form, $request)
    {
        $em = $this->entityManager;

        if ($form->get('imobiliariaImovel_creci')->getData()) {
            $imovelImobiliaria = new ImovelImobiliaria();
            $imovelImobiliaria->setFkImobiliarioImovel($imovel);
            $imovelImobiliaria->setTimestamp($imovel->getTimestamp());
            $imovelImobiliaria->setFkImobiliarioCorretagem($form->get('imobiliariaImovel_creci')->getData());
            $imovel->setFkImobiliarioImovelImobiliaria($imovelImobiliaria);
        }

        /** @var SwCepLogradouro $swCepLogradouro */
        $swCepLogradouro = $form->get('cep')->getData();

        $imovel->setTimestamp(new DateTimeMicrosecondPK());
        $imovel->setCep($swCepLogradouro->getCep());

        if ($form->get('fkSwProcesso')->getData()) {
            $imovelProcesso = new ImovelProcesso();
            $imovelProcesso->setFkSwProcesso($form->get('fkSwProcesso')->getData());
            $imovelProcesso->setTimestamp($imovel->getTimestamp());
            $imovel->addFkImobiliarioImovelProcessos($imovelProcesso);
        }

        $matriculaImovel = new MatriculaImovel();
        $matriculaImovel->setMatRegistroImovel($form->get('matriculaImovel_matRegistroImovel')->getData());
        $matriculaImovel->setZona($form->get('matriculaImovel_zona')->getData());
        $imovel->addFkImobiliarioMatriculaImoveis($matriculaImovel);

        $imovelLote = new ImovelLote();
        $imovelLote->setFkImobiliarioLote($form->get('lote')->getData());
        $imovel->addFkImobiliarioImovelLotes($imovelLote);

        /** @var SwLogradouro $logradouro */
        $logradouro = $form->get('endereco')->getData();

        /** @var Lote $lote */
        $lote = $form->get('lote')->getData();
        /** @var Confrontacao $confrontacao */
        $confrontacao = $lote->getFkImobiliarioConfrontacoes()->filter(
            function ($entry) use ($logradouro) {
                if ($entry->getFkImobiliarioConfrontacaoTrecho()) {
                    if (($entry->getFkImobiliarioConfrontacaoTrecho()->getPrincipal()) && ($entry->getFkImobiliarioConfrontacaoTrecho()->getCodLogradouro() == $logradouro->getCodLogradouro() )) {
                        return $entry;
                    }
                }
            }
        )->first();

        $imovel->getFkImobiliarioImovelConfrontacao()->setFkImobiliarioConfrontacaoTrecho($confrontacao->getFkImobiliarioConfrontacaoTrecho());

        $this->manterProprietarios($imovel, $request);

        if ($form->get('imovelCorrespondencia')->getData()) {
            /** @var SwCepLogradouro $swCepLogradouro */
            $swCepLogradouro = $form->get('correspondencia_cep')->getData();

            /** @var SwBairro $swBairro */
            $swBairro = $form->get('fkSwBairro')->getData();
            /** @var SwLogradouro $swLogradouro */
            $swLogradouro = $form->get('fkSwLogradouro')->getData();

            /** @var SwBairroLogradouro $swBairroLogradouro */
            $swBairroLogradouro = $em->getRepository(SwBairroLogradouro::class)
                ->findOneBy(
                    array(
                        'codUf' => $swBairro->getCodUf(),
                        'codMunicipio' => $swBairro->getCodMunicipio(),
                        'codBairro' => $swBairro->getCodBairro(),
                        'codLogradouro' => $swLogradouro->getCodLogradouro()
                    )
                );

            if (!$swBairroLogradouro) {
                $swBairroLogradouro = new SwBairroLogradouro();
                $swBairroLogradouro->setFkSwLogradouro($swLogradouro);
                $swBairroLogradouro->setFkSwBairro($swBairro);
            }

            if ($imovel->getFkImobiliarioImovelCorrespondencias()->count()) {
                $imovelCorrespondencia = $imovel->getFkImobiliarioImovelCorrespondencias()->last();
                $imovelCorrespondencia->setCep($swCepLogradouro->getCep());
                $imovelCorrespondencia->setNumero($form->get('correspondencia_numero')->getData());
                $imovelCorrespondencia->setCaixaPostal($form->get('correspondencia_caixa_postal')->getData());
                $imovelCorrespondencia->setComplemento(($form->get('correspondencia_complemento')->getData()) ? $form->get('correspondencia_complemento')->getData() : '');
                $imovelCorrespondencia->setFkSwLogradouro($swLogradouro);
                $imovelCorrespondencia->setFkSwBairroLogradouro($swBairroLogradouro);
            } else {
                $imovelCorrespondencia = new ImovelCorrespondencia();
                $imovelCorrespondencia->setCep($swCepLogradouro->getCep());
                $imovelCorrespondencia->setNumero($form->get('correspondencia_numero')->getData());
                $imovelCorrespondencia->setCaixaPostal($form->get('correspondencia_caixa_postal')->getData());
                $imovelCorrespondencia->setComplemento(($form->get('correspondencia_complemento')->getData()) ? $form->get('correspondencia_complemento')->getData() : '');
                $imovelCorrespondencia->setFkSwLogradouro($swLogradouro);
                $imovelCorrespondencia->setFkSwBairroLogradouro($swBairroLogradouro);
                $imovel->addFkImobiliarioImovelCorrespondencias($imovelCorrespondencia);
            }
        } else {
            if ($imovel->getFkImobiliarioImovelCorrespondencias()->count()) {
                $imovel
                    ->getFkImobiliarioImovelCorrespondencias()
                    ->removeElement(
                        $imovel
                            ->getFkImobiliarioImovelCorrespondencias()
                            ->last()
                    );
            }
        }
    }

    /**
     * @param Imovel $imovel
     * @param $atributosDinamicos
     * @param $dtAtual
     * @param bool $limpar
     * @return bool|\Exception
     */
    public function atributoDinamico(Imovel $imovel, $atributosDinamicos, $dtAtual, $limpar = true)
    {
        try {
            $em = $this->entityManager;
            $atributoDinamicoModel = new AtributoDinamicoModel($em);

            foreach ($atributosDinamicos as $codAtributo => $valorAtributo) {
                /** @var AtributoDinamico $atributoDinamico */
                $atributoDinamico = $em->getRepository(AtributoDinamico::class)
                    ->findOneBy(
                        array(
                            'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_IMOVEL,
                            'codAtributo' => $codAtributo
                        )
                    );

                $atributoImovelValor = new AtributoImovelValor();
                $atributoImovelValor->setFkAdministracaoAtributoDinamico($atributoDinamico);

                $valor = $atributoDinamicoModel
                    ->processaAtributoDinamicoPersist(
                        $atributoImovelValor,
                        $valorAtributo
                    );

                $atributoImovelValor->setValor($valor);
                $atributoImovelValor->setTimestamp($dtAtual);
                $atributoImovelValor->setFkImobiliarioImovel($imovel);
                $imovel->addFkImobiliarioAtributoImovelValores($atributoImovelValor);
            }

            if ($limpar) {
                $em->persist($imovel);
                $em->flush();
            }
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param Imovel $imovel
     * @param null $timestamp
     * @return array
     */
    public function getNomAtributoValorByImovel(Imovel $imovel, $timestamp = null)
    {
        if (!$timestamp) {
            /** @var AtributoImovelValor $lastAtributoImovelValor */
            $lastAtributoImovelValor = $this->entityManager
                ->getRepository(AtributoImovelValor::class)
                ->findOneByInscricaoMunicipal($imovel->getInscricaoMunicipal(), array('timestamp' => 'DESC'));
            if ($lastAtributoImovelValor) {
                $timestamp = $lastAtributoImovelValor->getTimestamp();
            } else {
                return null;
            }
        }

        $atributosDinamicos = array();

        $atributoImovelValores = $imovel->getFkImobiliarioAtributoImovelValores()->filter(
            function ($entry) use ($timestamp) {
                if ($entry->getTimestamp() == $timestamp) {
                    return $entry;
                }
            }
        );

        foreach ($atributoImovelValores as $atributoImovelValor) {
            $atributoDinamico = $atributoImovelValor->getFkAdministracaoAtributoDinamico();
            $atributosDinamicos[$atributoDinamico->getCodAtributo()]['nomAtributo'] = $atributoDinamico->getNomAtributo();
            $selecteds = explode(',', $atributoImovelValor->getValor());
            if ($atributoDinamico->getCodTipo() == AtributoDinamico::COD_TIPO_LISTA || $atributoDinamico->getCodTipo() == AtributoDinamico::COD_TIPO_LISTA_MULTIPLA) {
                foreach ($atributoDinamico->getFkAdministracaoAtributoValorPadroes() as $atributoValorPadrao) {
                    if (in_array($atributoValorPadrao->getCodValor(), $selecteds)) {
                        $atributosDinamicos[$atributoDinamico->getCodAtributo()]['valor'][] = $atributoValorPadrao->getValorPadrao();
                    }
                }
            } else {
                $atributos[$atributoDinamico->getCodAtributo()]['valor'][] = $atributoImovelValor->getValor();
            }
        }
        return $atributosDinamicos;
    }

    /**
     * @param Imovel $imovel
     * @param $request
     */
    public function manterProprietarios(Imovel $imovel, $request)
    {
        $em = $this->entityManager;

        if ($imovel->getFkImobiliarioProprietarios()->count()) {
            /** @var Proprietario $proprietario */
            foreach ($imovel->getFkImobiliarioProprietarios() as $proprietario) {
                if (!in_array($this->getObjectIdentifier($proprietario), ($request->get('proprietarios_old')) ? $request->get('proprietarios_old') : array())) {
                    $imovel->getFkImobiliarioProprietarios()->removeElement($proprietario);
                }
            }
        }

        $proprietarios = $request->get('proprietarios');
        $proprietarioQuotas = $request->get('proprietario_quotas');

        $ordem = 1;
        foreach ($proprietarios as $key => $numcgm) {
            if ($numcgm != "") {
                /** @var SwCgm $swCgm */
                $swCgm = $em->getRepository(SwCgm::class)->find($numcgm);

                $proprietario = new Proprietario();
                $proprietario->setFkSwCgm($swCgm);
                $proprietario->setPromitente(false);
                $proprietario->setOrdem($ordem);
                $proprietario->setCota((int) $proprietarioQuotas[$key]);
                $imovel->addFkImobiliarioProprietarios($proprietario);
                $ordem++;
            }
        }

        $promitentes = $request->get('promitentes');
        $promitenteQuotas = $request->get('promitente_quotas');

        $ordem = 1;
        foreach ($promitentes as $key => $numcgm) {
            if ($numcgm != "") {
                /** @var SwCgm $swCgm */
                $swCgm = $em->getRepository(SwCgm::class)->find($numcgm);

                $proprietario = new Proprietario();
                $proprietario->setFkSwCgm($swCgm);
                $proprietario->setPromitente(true);
                $proprietario->setOrdem($ordem);
                $proprietario->setCota((int) $promitenteQuotas[$key]);
                $imovel->addFkImobiliarioProprietarios($proprietario);
                $ordem++;
            }
        }
    }

    /**
     * @param $params
     * @return array
     */
    public function findImoveis($params)
    {
        return $this->repository->findImoveis($params);
    }

    public function consultar($params)
    {
        $em = $this->entityManager;

        $valor = null;
        if (isset($params['codLote']['value']) && $params['codLote']['value'] != '') {
            /** @var Lote $lote */
            $lote = $em->getRepository(Lote::class)->find($params['codLote']['value']);
            $valor = $lote->getFkImobiliarioLoteLocalizacao()->getValor();
        }

        $codigoComposto = null;
        if (isset($params['codLocalizacao']['value']) && $params['codLocalizacao']['value'] != '') {
            /** @var Localizacao $localizacao */
            $localizacao = $em->getRepository(Localizacao::class)->find($params['codLocalizacao']['value']);
            $codigoComposto = $localizacao->getCodigoComposto();
        }

        $params = [
            'inscricaoMunicipal' => (isset($params['inscricaoMunicipal']['value'])) ? $params['inscricaoMunicipal']['value'] : null,
            'valor' => $valor,
            'codigoComposto' => $codigoComposto,
            'numcgm' => (isset($params['numcgm']['value'])) ? $params['numcgm']['value'] : null,
            'numero' => (isset($params['numero']['value'])) ? $params['numero']['value'] : null,
            'complemento' => (isset($params['complemento']['value'])) ? $params['complemento']['value'] : null,
            'codLogradouro' => (isset($params['codLogradouro']['value'])) ? $params['codLogradouro']['value'] : null,
            'codBairro' => (isset($params['codBairro']['value'])) ? $params['codBairro']['value'] : null,
            'codCondominio' => (isset($params['codCondominio']['value'])) ? $params['codCondominio']['value'] : null
        ];

        return $this->repository->consultar($params);
    }

    /**
     * @param $inscricaoMunicipal
     * @return mixed
     */
    public function consultaAreaImovel($inscricaoMunicipal)
    {
        return $this->repository->consultaAreaImovel($inscricaoMunicipal);
    }

    /**
     * @param $inscricaoMunicipal
     * @return mixed
     */
    public function consultaAreaImovelLote($inscricaoMunicipal)
    {
        return $this->repository->consultaAreaImovelLote($inscricaoMunicipal);
    }

    /**
     * @param $inscricaoMunicipal
     * @return mixed
     */
    public function consultaFracaoIdeal($inscricaoMunicipal)
    {
        return $this->repository->consultaFracaoIdeal($inscricaoMunicipal);
    }

    /**
     * @param $params
     */
    public function getInscricaoImobiliariabyCodAndLoteAndLocalizacao($params)
    {
        return $this->repository->getInscricaoImobiliariabyCodAndLoteAndLocalizacao($params);
    }

    /**
     * @param $inscricaoMunicipal
     * @return mixed
     */
    public function consultaSituacaoImovel($inscricaoMunicipal)
    {
        return $this->repository->getSituacaoImovel($inscricaoMunicipal);
    }

    /**
     * @param $inscricaoMunicipal
     * @return mixed
     */
    public function getListaValorVenal($inscricaoMunicipal)
    {
        return $this->repository->getListaValorVenal($inscricaoMunicipal);
    }

    /**
     * @param $inscricaoMunicipal
     * @return mixed
     */
    public function getListaLancamentos($inscricaoMunicipal)
    {
        return $this->repository->getListaLancamentos($inscricaoMunicipal);
    }

    /**
     * @param $inscricaoMunicipal
     * @return mixed
     */
    public function getListaCalculosNaoLancados($inscricaoMunicipal)
    {
        return $this->repository->getListaCalculosNaoLancados($inscricaoMunicipal);
    }
    
    /**
     * @param array $filtro
     * @param string $situacao
     * @param string $orderBy
     * @param boolean $distinct
     * @return array
     */
    public function getCadastroList(Array $filtro, $situacao = null, $orderBy = '', $distinct = true)
    {
        return $this->repository->getCadastroList($filtro, $situacao, $orderBy, $distinct);
    }
    
    /**
     * @param array $where
     * @param array $parameters
     * @param string $order
     * @return array
     */
    public function getBoletimCadastroImobiliario(Array $where = [], Array $parameters = [], $order = null)
    {
        return $this->repository->getBoletimCadastroImobiliario($where, $parameters, $order);
    }
}
