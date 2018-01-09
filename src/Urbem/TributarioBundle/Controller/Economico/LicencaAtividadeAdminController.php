<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao\ModuloAdmin;
use Urbem\CoreBundle\Entity\Administracao\Assinatura;
use Urbem\CoreBundle\Entity\Administracao\AssinaturaModulo;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\DiasSemana;
use Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Economico\Atividade;
use Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica;
use Urbem\CoreBundle\Entity\Economico\LicencaAtividade;
use Urbem\CoreBundle\Entity\Economico\LicencaDiasSemana;
use Urbem\CoreBundle\Entity\Economico\LicencaDocumento;
use Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoAssinatura;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaImovel;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Economico\AtividadeModel;
use Urbem\CoreBundle\Model\Economico\LicencaAtividadeModel;
use Urbem\CoreBundle\Model\Economico\LicencaModel;
use Urbem\CoreBundle\Model\Economico\NaturezaJuridicaModel;
use Urbem\CoreBundle\Model\SwCgmModel;

/**
 * Class LicencaAtividadeAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class LicencaAtividadeAdminController extends CRUDController
{
    const COD_MODULO = 14;
    const FAZENDA = 'Fazenda';
    const FISCAL = 'Fiscal';
    const DESPARTAMENTO_FISCAL = 'chefe_departamento_1';

    /**
     * @param Request $request
     */
    public function imprimirAction(Request $request)
    {
        $id = $request->get($this->admin->getIdParameter());
        $licencaAtividade = $this->admin->getObject($id);
        $modeloDocumento = $licencaAtividade->getFkEconomicoLicenca()->getFkEconomicoLicencaDocumentos()->last()->getFkAdministracaoModeloDocumento();
        if ($modeloDocumento->getNomeArquivoAgt() == 'alvara_atividade_sanitario_MARIANA.odt') {
            $this->imprimeAlvaraSanitarioMariana($licencaAtividade, $modeloDocumento);

            return;
        }


        $url = $request->attributes->get('id');
        list($codLicenca, $exercicio, $codAtividade, $inscricaoEconomica, $ocorrenciaAtividade, $ocorrenciaLicenca) = explode('~', $url);
        $em = $this->getDoctrine()->getManager();

        $licencaAtividade = (new LicencaAtividadeModel($em))
            ->getSwCgmByInscricaoEconomica($inscricaoEconomica);

        $codCgm = null;
        foreach ($licencaAtividade as $cgm) {
            $codCgm = $cgm['numcgm'];
        }
        $sw = $em->getRepository(SwCgm::class)
            ->findOneByNumcgm($codCgm);

        $swPessoa = [
            'cnpjEntidade' => null,
            'rg' => null,
            'inscricaoMunicipal' => null,
            'inscricaoImobiliaria' => null,
            'natureza' => null,
        ];
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

        $horarioAtividades_arr = array();
        $licencaDiasSemana = $em->getRepository(LicencaDiasSemana::class)
            ->findBy(['codLicenca' => $codLicenca, 'exercicio' => $exercicio]);
        $diasSemana = $em->getRepository(DiasSemana::class)
            ->findAll();
        foreach ($diasSemana as $dia) {
            if ($licencaDiasSemana) {
                $l = $em->getRepository(LicencaDiasSemana::class)
                    ->findOneBy(['codLicenca' => $codLicenca, 'exercicio' => $exercicio, 'codDia' => $dia->getCodDia()]);
                $dias_list = [
                    'nomDia' => $dia->getNomDia(),
                    'inicio' => ($l) ? $l->getHrInicio() : null,
                    'termino' => ($l) ? $l->getHrTermino() : null,
                ];
            } else {
                $dias_list = [
                    'nomDia' => $dia->getNomDia(),
                    'inicio' => null,
                    'termino' => null
                ];
            }
            array_push($horarioAtividades_arr, $dias_list);
        }

        $natureza = $em->getRepository(EmpresaDireitoNaturezaJuridica::class)
            ->findOneByInscricaoEconomica($inscricaoEconomica);
        if ($natureza) {
            $naturezaJuridica = (new NaturezaJuridicaModel($em))
                ->getNaturezaJuridicaByCodNatureza($natureza->getCodNatureza());
            $swPessoa['natureza'] = $naturezaJuridica->getNomNatureza();
        }

        $numero = null;
        if ($sw->getFoneComercial()) {
            $numero = $sw->getFoneComercial();
        } elseif ($sw->getFoneResidencial()) {
            $numero = $sw->getFoneResidencial();
        } elseif ($sw->getFoneCelular()) {
            $numero = $sw->getFoneCelular();
        }

        $container = $this->container;
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

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

        $assinaturas = $this->getAssinaturas($usuario, $exercicio);
        if ($assinaturas) {
            $doc['assin_left_cargo'] = $assinaturas['left']['cargo'];
            $doc['assin_left_resp'] = $assinaturas['left']['responsavel'];
            $doc['assin_right_cargo'] = $assinaturas['right']['cargo'];
            $doc['assin_right_resp'] = $assinaturas['right']['responsavel'];
        }

        $licencaAtividade = (new LicencaAtividadeModel($em))
            ->getLicencaAtividadeByCodLicencaAndExercicio($codLicenca, $exercicio);

        $atividadeCadastroEconomico_arr = array();
        foreach ($licencaAtividade as $a) {
            $atividade = (new AtividadeModel($em))
                ->getAtividade($a->getCodAtividade());
            $atividadeCadastroEconomico = $em->getRepository(AtividadeCadastroEconomico::class)
                ->findOneByCodAtividade($a->getCodAtividade());
            array_push($atividadeCadastroEconomico_arr, $atividadeCadastroEconomico);
            ($a->getDtTermino()) ? $doc['validade'] = $a->getDtTermino() : $doc['validade'] = '-';
            $doc['restricoes'] = $a->getOcorrenciaLicenca();
        }

        $infoAtividades = [
            'codAtividadePrincipal' => null,
            'nomAtividadePrincipal' => null,
            'atividadesSecundarias' => array(),
            'horarioAtividades' => $horarioAtividades_arr
        ];

        $infoAtividadesSecundarias = null;

        $atividadesSecundarias_arr = array();
        foreach ($atividadeCadastroEconomico_arr as $ae) {
            $atividade = (new AtividadeModel($em))
                ->getAtividade($ae->getCodAtividade());
            $atividade = array_shift($atividade);
            if ($ae->getPrincipal()) {
                $infoAtividades['codAtividadePrincipal'] = $atividade->getCodEstrutural();
                $infoAtividades['nomAtividadePrincipal'] = $atividade->getNomAtividade();
            } elseif (!$ae->getPrincipal()) {
                $atividadeSecundaria['codAtividadeSecundaria'] = $atividade->getCodEstrutural();
                $atividadeSecundaria['nomAtividadeSecundaria'] = $atividade->getNomAtividade();
                array_push($atividadesSecundarias_arr, $atividadeSecundaria);
            }
        }
        $infoAtividades['atividadesSecundarias'] = $atividadesSecundarias_arr;

        $licencaDocumento = $em->getRepository(LicencaDocumento::class)
            ->findOneBy(['codLicenca' => $codLicenca, 'exercicio' => $exercicio]);

        $header = $this->getHeaderMunicipio($usuario, $exercicio, $licencaDocumento->getCodDocumento());
        $infoLicencaAtividade = array_merge($header, $infoEntidade, $infoAtividades, $doc);

        $html = $this->renderView(
            'TributarioBundle:Economico/Licenca:imprimirLicenca.html.twig',
            array(
                'infoLicencaAtividade' => $infoLicencaAtividade,
                'dtEmissao' => new \DateTime('now'),
                'modulo' => 'Econômico',
                'entidade' => $container->get('urbem.entidade')->getEntidade(),
                'versao' => $container->getParameter('version'),
                'subModulo' => 'Licença',
                'usuario' => $usuario,
                'funcao' => 'Conceder Licença Atividade',
                'nomRelatorio' => $infoLicencaAtividade['infoTipoAlvara'],
                'logoTipo' => $container->get('urbem.configuracao')->getLogoTipo(),
            )
        );

        $date = new \DateTime('now');
        $filename = sprintf('Licenca-atividade-%s.pdf', date('Y-m-d'));

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
     * @param $user
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
    * @param LicencaAtividade $licencaAtividade
    * @param ModeloDocumento $modeloDocumento
    * @return void
    */
    protected function imprimeAlvaraSanitarioMariana(LicencaAtividade $licencaAtividade, ModeloDocumento $modeloDocumento)
    {
        setlocale(LC_ALL, 'pt_BR.utf8');

        $em = $this->getDoctrine()->getManager();

        $tributarioTemplatePath = $this->container->getParameter('tributariobundle');

        $template = sprintf('%s%s', $tributarioTemplatePath['templateOdt'], $modeloDocumento->getNomeArquivoAgt());
        $dadosArquivo = (new LicencaAtividadeModel($em))->fetchDadosAlvaraSanitarioMariana($licencaAtividade, $this->admin->getExercicio());

        $openTBS = $this->get('opentbs');
        $openTBS->ResetVarRef(false);
        $openTBS->VarRef = $dadosArquivo['vars'];
        $openTBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8);

        foreach ($dadosArquivo['blocks'] as $block => $dados) {
            $openTBS->MergeBlock($block, $dados);
        }

        $openTBS->Show(OPENTBS_DOWNLOAD, $modeloDocumento->getNomeArquivoAgt());
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function showLicencaAtividadesAction(Request $request)
    {
        $id = $this->admin->getIdParameter();

        $this->admin->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));
        $container = $this->container;
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        try {
            $id = $request->get($this->admin->getIdParameter());

            list($codLicenca, $exercicio) = explode('~', $id);

            $licenca = (new LicencaModel($em))->getLicencaByCodLicencaAndExercicio($codLicenca, $exercicio);
            $licencaAtividades = (new LicencaAtividadeModel($em))->getLicencaAtividadeByCodLicencaAndExercicio($codLicenca, $exercicio);

            return $this->render('TributarioBundle::Economico/Licenca/show_licenca_atividades.html.twig', array(
                'licenca' => $licenca,
                'licencaAtividades' => $licencaAtividades
            ));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.economico.licenca.erroLicencaAtividades'));
        }
    }
}
