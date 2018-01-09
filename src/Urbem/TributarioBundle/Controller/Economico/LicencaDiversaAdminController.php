<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\Assinatura;
use Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Economico\AtributoLicencaDiversaValor;
use Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa;
use Urbem\CoreBundle\Entity\Economico\Licenca;
use Urbem\CoreBundle\Entity\Economico\LicencaDiversa;
use Urbem\CoreBundle\Entity\Economico\LicencaDocumento;
use Urbem\CoreBundle\Entity\Economico\LicencaObservacao;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;

/**
 * Class LicencaDiversaAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class LicencaDiversaAdminController extends CRUDController
{
    const COD_MODULO = 14;
    const FAZENDA = 'Fazenda';
    const FISCAL = 'Fiscal';
    const DESPARTAMENTO_FISCAL = 'chefe_departamento_1';

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }

    /**
     * @param Request $request
     */
    public function imprimirAction(Request $request)
    {
        $url = $request->attributes->get('id');
        list($codLicenca, $exercicio) = explode('~', $url);
        $em = $this->getDoctrine()->getManager();

        $licencaDiversa = $em->getRepository(LicencaDiversa::class)
            ->findOneBy(['codLicenca' => $codLicenca, 'exercicio' => $exercicio]);

        $swPessoa = [
            'cnpjEntidade' => null,
            'rg' => null,
            'inscricaoMunicipal' => null,
            'inscricaoImobiliaria' => null,
            'natureza' => null
        ];

        $sw = $em->getRepository(SwCgm::class)
            ->findOneByNumcgm($licencaDiversa->getNumcgm());
        $swPessoaJuridica = $em->getRepository(SwCgmPessoaJuridica::class)
            ->findOneByNumcgm($sw->getNumcgm());
        if ($swPessoaJuridica) {
            $cnpj = $this->mask($swPessoaJuridica->getCnpj(), '##.###.###/####-##');
            $swPessoa['cnpjEntidade'] = $cnpj;
            $swPessoa['inscricaoEstadual'] = $swPessoaJuridica->getInscEstadual();
            $licencaImovel = $em->getRepository(LicencaImovel::class)
                ->findOneBy(['codLicenca' => $codLicenca,'exercicio' => $exercicio]);
            if ($licencaImovel) {
                $swPessoa['inscricaoMunicipal'] = $licencaImovel->getInscricaoMunicipal();
            }
            $swPessoa['inscricaoMunicipal'] = null;
            $swPessoa['inscricaoImobiliaria'] = null;
        } elseif (!$swPessoaJuridica) {
            $swPessoaFisica = $em->getRepository(SwCgmPessoaFisica::class)
                ->findOneByNumcgm($sw->getNumcgm());
            if ($swPessoaFisica) {
                $swPessoa['rg'] = $swPessoaFisica->getRg();
            }
        }

        $numero = null;
        if ($sw->getFoneComercial()) {
            $numero = $sw->getFoneComercial();
        } elseif ($sw->getFoneResidencial()) {
            $numero = $sw->getFoneResidencial();
        } elseif ($sw->getFoneCelular()) {
            $numero = $sw->getFoneCelular();
        }

        $infoEntidade = [
            'nomEntidade' => $sw->getNomCgm(),
            'foneEntidade' => $numero,
            'emailEntidade' => $sw->getEMail(),
            'logradouro' => $sw->getLogradouro().' '.$sw->getNumero(),
            'bairroEntidade' => $sw->getBairro(),
            'cepEntidade' => $sw->getCep(),
            'natureza' => $swPessoa['natureza'],
            'cnpjEntidade' => $swPessoa['cnpjEntidade'],
            'rg' => $swPessoa['rg'],
            'inscricaoMunicipal' => $swPessoa['inscricaoMunicipal'],
            'inscricaoImobiliaria' => $swPessoa['inscricaoImobiliaria']
        ];

        $doc = [
            'validade' => null,
            'restricoes' => null,
            'assinaturaCargoLeft' => null,
            'assinaturaNomeLeft' => null,
            'assinaturaCargoRight' => null,
            'assinaturaNomeRight' => null
        ];

        $container = $this->container;
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        $assinaturas = $this->getAssinaturas($usuario, $exercicio);
        if ($assinaturas) {
            $doc['assin_left_cargo'] = $assinaturas['left']['cargo'];
            $doc['assin_left_resp'] = $assinaturas['left']['responsavel'];
            $doc['assin_right_cargo'] = $assinaturas['right']['cargo'];
            $doc['assin_right_resp'] = $assinaturas['right']['responsavel'];
        }

        $licenca = $em->getRepository(Licenca::class)
            ->findOneBy(['codLicenca' => $licencaDiversa->getCodLicenca(), 'exercicio' =>  $licencaDiversa->getExercicio()]);
        ($licenca->getDtTermino()) ? $doc['validade'] = $licenca->getDtTermino() : $doc['validade'] = '-';

        $licencaObservacao = $em->getRepository(LicencaObservacao::class)
            ->findOneBy(['codLicenca' => $codLicenca, 'exercicio' => $exercicio]);
        $observacao = ($licencaObservacao) ? $licencaObservacao->getObservacao() : null;
        $doc['restricoes'] = $observacao;

        $licencaDocumento = $em->getRepository(LicencaDocumento::class)
            ->findOneBy(['codLicenca' => $codLicenca, 'exercicio' => $exercicio]);
        $header = $this->getHeaderMunicipio($usuario, $exercicio, $licencaDocumento->getCodDocumento());
        $infoLicencaDiversa = array_merge($header, $infoEntidade, $doc);

        $atributos = [];
        foreach ($licencaDiversa->getFkEconomicoAtributoLicencaDiversaValores() as $key => $licencaDiversaAtributo) {
            $atributo = $licencaDiversaAtributo->getFkEconomicoAtributoTipoLicencaDiversa()->getFkAdministracaoAtributoDinamico();

            if (!in_array($atributo->getCodTipo(), [3, 4])) {
                array_push($atributos, ['nomAtributo' => $atributo->getNomAtributo(), 'valores' => [$licencaDiversaAtributo->getValor()]]);

                continue;
            }

            foreach ($atributo->getFkAdministracaoAtributoValorPadroes() as $valorPadrao) {
                if ($licencaDiversaAtributo->getValor() != $valorPadrao->getCodValor()) {
                    continue;
                }

                array_push($atributos, ['nomAtributo' => $atributo->getNomAtributo(), 'valores' => [$valorPadrao->getValorPadrao()]]);
            }
        }

        $html = $this->renderView(
            'TributarioBundle:Economico/Licenca:imprimirLicencaDiversa.html.twig',
            [
                'infoLicencaAtividade' => $infoLicencaDiversa,
                'dtEmissao' => new \DateTime('now'),
                'modulo' => 'Econômico',
                'entidade'  => $this->get('urbem.entidade')->getEntidade(),
                'versao' => $container->getParameter('version'),
                'subModulo' => 'Licença',
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'funcao' => 'Conceder Outras Licenças',
                'nomRelatorio' => $infoLicencaDiversa['infoTipoAlvara'],
                'atributos' => $atributos,
                'elementos' => $licencaDiversa->getFkEconomicoElementoLicencaDiversas(),
                'logoTipo' => $container->get('urbem.configuracao')->getLogoTipo()

            ]
        );

        $date = new \DateTime('now');
        $filename = sprintf('Licenca-diversa-%s.pdf', date('Y-m-d'));
        return new Response(
            $this->get('knp_snappy.pdf')
                ->getOutputFromHtml(
                    $html,
                    array(
                        'encoding' => 'utf-8',
                        'enable-javascript' => false,
                        'footer-line' => true,
                        'footer-left' => 'URBEM - CNM',
                        'footer-right' => '[page]',
                        'footer-center' => 'www.cnm.org.br',
                    )
                ),
            200,
            array(
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            )
        );
    }

    /**
     * @param $user
     * @param $exercicio
     * @param $alvara
     * @return array
     */
    public function getHeaderMunicipio($user, $exercicio, $codDocumento)
    {
        $em = $this->getDoctrine()->getManager();
        $modulo = $em->getRepository(Modulo::class)
            ->findOneByCodModulo($this::COD_MODULO);
        $configPrefeitura = $em->getRepository(Configuracao::class)
            ->getInformacoesPrefeituraByModuloAbdExercicio($modulo->getCodModulo(), $exercicio);

        $configuracaoModel = new ConfiguracaoModel($em);
        $codUf = $configuracaoModel->pegaConfiguracao('cod_uf', Modulo::MODULO_ADMINISTRATIVO, $exercicio, true);
        $codMunicipio = $configuracaoModel->pegaConfiguracao('cod_municipio', Modulo::MODULO_ADMINISTRATIVO, $exercicio, true);
        $uf = $municipio = $infoEstado = null;
        if (((int) $codUf) && ((int) $codMunicipio)) {
            $uf = $em->getRepository(SwUf::class)
                ->find((integer) $codUf);
            $municipio = $em->getRepository(SwMunicipio::class)
                ->findOneBy(array('codMunicipio' => (integer) $codMunicipio, 'codUf' => (integer) $codUf));
            $infoEstado = $municipio->getNomMunicipio() . ' ' .$uf->getSiglaUf();
        }

        $infoPrefeitura = $configPrefeitura["nom_prefeitura"];
        $cnpj = $configPrefeitura["cnpj"];
        $infoTipoAlvaraDesc = ''; // provisoriamente

        $modeloArquivoDocumento = $em->getRepository(ModeloArquivosDocumento::class)
            ->findOneBy(['codArquivo' => $codDocumento]);
        if ($modeloArquivoDocumento) {
            $modeloDocumento = $em->getRepository(ModeloDocumento::class)
                ->findOneBy(['codDocumento' => $modeloArquivoDocumento->getCodDocumento()]);
            $nomAlvara = $modeloDocumento->getNomeDocumento();
            $isAlvaraSanitario = false;
            if (strstr($nomAlvara, '-')) {
                $nomAlvara = explode('-', $nomAlvara);
                $nomAlvara = trim(array_shift($nomAlvara));
                $isAlvaraSanitario = true;
            } elseif (strstr($nomAlvara, '_')) {
                $nomAlvara = str_replace('_', ' ', $nomAlvara);
            }
        } else {
            $nomAlvara = '--';
            $isAlvaraSanitario = null;
        }

        $infoSecretaria = ($isAlvaraSanitario) ? $configPrefeitura["sec_saude"] : $configPrefeitura["sec_fazenda"];
        $infoTipoAlvara = $nomAlvara;

        $cnpj = $this->mask($cnpj, '##.###.###/####-##');

        $header = [
            'infoEstado' => $infoEstado,
            'infoPrefeitura' => $infoPrefeitura,
            'infoSecretaria' => $infoSecretaria,
            'exercicio' => $exercicio,
            'cnpjSecretaria' => $cnpj,
            'infoTipoAlvaraDesc' => $infoTipoAlvaraDesc,
            'infoTipoAlvara' => $infoTipoAlvara
        ];

        return $header;
    }

    /**
     * @param $user
     * @param $exercicio
     * @return array
     */
    public function getAssinaturas($user, $exercicio)
    {
        $em = $this->getDoctrine()->getManager();
        $modulo = $em->getRepository(Modulo::class)
            ->findOneByCodModulo($this::COD_MODULO);

        $moduloAssinatura = $em->getRepository(AssinaturaModulo::class)
            ->findOneBy(['codModulo' => $modulo->getCodModulo(), 'numcgm' => $user->getNumcgm()], ['exercicio' => 'DESC']);

        $secretFazenda = $em->getRepository(Assinatura::class)
            ->getSecretarioMunicipalFazendaByCargo(self::FAZENDA);
        $configuracao = $em->getRepository(Configuracao::class)
            ->findOneBy(['parametro' => self::DESPARTAMENTO_FISCAL], ['exercicio' => 'DESC']);
        $fiscal = [
            'fiscal' => null,
            'cargo' => self::FISCAL
        ];
        if ($configuracao) {
            $valor = $configuracao->getValor();
            if (strstr($valor, ',')) {
                $fiscal_arr = explode(',', $valor);
                $fiscal['fiscal'] = $fiscal_arr[0];
                $fiscal['cargo'] = $fiscal_arr[1];
            } else {
                $fiscal['fiscal'] = $valor;
            }
        }
        $assinaturas = array();
        $assinaturas = [
            'left' => array(
                'responsavel' => $fiscal['fiscal'],
                'cargo' =>  $fiscal['cargo']
            ),
            'right' => array(
                'responsavel' => ($secretFazenda) ? $secretFazenda['responsavel'] : null,
                'cargo' =>  ($secretFazenda) ? $secretFazenda['cargo'] : null
            )
        ];

        return $assinaturas;
    }

    /**
     * @param $val
     * @param $mask
     * @return string
     */
    public function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for ($i=0; $i<=strlen($mask)-1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function apiElementoTipoLicencaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $results = ['items' => []];
        if (!$request->get('codTipoLicenca')) {
            return new JsonResponse($results);
        }

        $qb = $em->getRepository(ElementoTipoLicencaDiversa::class)->createQueryBuilder('o');

        $qb->join('o.fkEconomicoElemento', 'e');

        $qb->where('o.codTipo >= :codTipo');
        $qb->setParameter('codTipo', (int) $request->get('codTipoLicenca'));

        $qb->orderBy('e.nomElemento', 'ASC');

        foreach ((array) $qb->getQuery()->getResult() as $elementoTipoLicencaDiversa) {
            $results['items'][] = [
                'id' => sprintf('%s~%s', $elementoTipoLicencaDiversa->getCodElemento(), $elementoTipoLicencaDiversa->getCodTipo()),
                'label' => (string) $elementoTipoLicencaDiversa->getFkEconomicoElemento()->getNomElemento(),
            ];
        }

        return new JsonResponse($results);
    }
}
