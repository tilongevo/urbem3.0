<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Imobiliario\CondominioModel;

class RelatorioCondominioAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function relatorioAction(Request $request)
    {
        $container = $this->container;
        $usuario = $container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $paramsFormulario = $request->query->all(); // valores do formulário

        try {
            $condominios = $this::getCondominios($em, $paramsFormulario);

            $condominiosContribuitesComAtributos = array();
            if ($condominios) {
                $index = 0;
                foreach ($condominios as $condominio) {
                    $condominiosContribuitesComAtributos[$index]['nom_condominio'] = $condominio['nom_condominio'];
                    $contribuintes = $this::getContribuintes($em, $index, $condominio);

                    if ($contribuintes) {
                        $indexContribuinte = 0;
                        foreach ($contribuintes as $contribuinte) {
                            $condominiosContribuitesComAtributos[$index]['contribuintes'][$indexContribuinte] = $this::getAtributosDinamicos($em, $contribuinte, $paramsFormulario);
                            $indexContribuinte++;
                        }
                    }
                    $index++;
                }
            }
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
            throw $e;
        }

        $html = $this->renderView(
            'TributarioBundle:Imobiliario/Relatorios:condominio.html.twig',
            [
                'condominios' => $condominiosContribuitesComAtributos,
                'logoTipo' => $container->get('urbem.configuracao')->getLogoTipo(),
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'modulo' => 'Cadastro Imobiliário',
                'subModulo' => 'Relatórios',
                'funcao' => 'Condomínios',
                'nomRelatorio' => 'Relatório de Condomínios',
                'dtEmissao' => new \DateTime(),
                'usuario' => $usuario,
                'versao' => $container->getParameter('version')
            ]
        );

        $filename = sprintf('RelatorioCondominio_%s.pdf', date('Y-m-d-His'));

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br',
                    'orientation' => 'portrait'
                ]
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]
        );
    }

    /**
     * @param $parametro
     * @return array
     */
    public function atributoStringParaArray($parametro)
    {
        $codAtributosSelecionados = array();
        if (isset($parametro)) {
            $codAtributosSelecionados = explode(', ', $parametro);
        }

        return $codAtributosSelecionados;
    }

    /**
     * @param $em
     * @param $paramsFormulario
     * @return mixed
     */
    public function getCondominios($em, $paramsFormulario)
    {
        $condominioModel = (new CondominioModel($em));
        return $condominioModel->getCondominioByNomeAndCodigo($paramsFormulario);
    }

    /**
     * @param $em
     * @param $index
     * @param $condominio
     * @return mixed
     */
    public function getContribuintes($em, $index, $condominio)
    {
        $condominioModel = (new CondominioModel($em));
        return $condominioModel->getInformacoesCondominioByCodigo($condominio['cod_condominio']);
    }

    /**
     * @param $em
     * @param $contribuintes
     * @param $paramsFormulario
     * @return mixed
     */
    public function getAtributosDinamicos($em, $contribuinte, $paramsFormulario)
    {

        $atributoDinamicoModel = new AtributoDinamicoModel($em);

        $codAtributoSelecionadosLote = array();
        if (isset($paramsFormulario['atributosLote'])) {
            $codAtributoSelecionadosLote = $this::atributoStringParaArray($paramsFormulario['atributosLote']);

            // Prepara os parametros para pegar os atributos do lote
            $params = array();
            $params['codCadastro'] = Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO;
            $params['codModulo'] = Modulo::MODULO_CADASTRO_IMOBILIARIO;
            $params['tabelaAtributo'] = "atributo_lote_urbano_valor";
            $params['campoAtributo'] = "cod_lote";
        }

        $codAtributoSelecionadosImovel = array();
        if (isset($paramsFormulario['atributosImovel'])) {
            $codAtributoSelecionadosImovel = $this::atributoStringParaArray($paramsFormulario['atributosImovel']);

            // Prepara os parametros para pegar os atributos do imóvel
            $params2 = array();
            $params2['codCadastro'] = Cadastro::CADASTRO_TRIBUTARIO_IMOVEL;
            $params2['codModulo'] = Modulo::MODULO_CADASTRO_IMOBILIARIO;
            $params2['tabelaAtributo'] = "atributo_imovel_valor";
            $params2['campoAtributo'] = "inscricao_municipal";
        }
        // Procura os atributos de lote e imóvel de cada contribuinte
        $params['codAtributo'] = $contribuinte['cod_lote'];
        $params2['codAtributo'] = $contribuinte['inscricao_municipal'];
        $indexCombinaAtributo = 0;

        if (isset($paramsFormulario['atributosLote'])) {
            $atributosLote = $atributoDinamicoModel->getValorAtributoDinamicoPorTabela($params);
            // Atributo de Lote
            foreach ($atributosLote as $atributo) {
                foreach ($codAtributoSelecionadosLote as $codAtributoSelecionadoLote) {
                    if ($atributo['cod_atributo'] == $codAtributoSelecionadoLote) {
                        $valor = ($em->getRepository('CoreBundle:Imobiliario\AtributoLoteUrbanoValor')->findBy(['codAtributo' => $atributo['cod_atributo'], 'codCadastro' => $atributo['cod_cadastro'], 'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO]));
                        $atributo['valorDescricao'] = '';
                        if ($valor) {
                            if (is_numeric(end($valor)->getValor())) {
                                $valorDescricao = ($em->getRepository('CoreBundle:Administracao\AtributoValorPadrao')->findOneBy(['codAtributo' => $atributo['cod_atributo'], 'codCadastro' => $atributo['cod_cadastro'], 'codValor' => end($valor)->getValor(), 'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO, 'ativo' => true]));
                                $atributo['valorDescricao'] = $valorDescricao->getValorPadrao();
                            }
                        }
                        $atributo['valorDescricao'] = '';
                        $contribuinte['atributos'][$indexCombinaAtributo] = $atributo;
                        $indexCombinaAtributo++;
                    }
                }
            }
        }

        if (isset($paramsFormulario['atributosImovel'])) {
            $atributosImovel = $atributoDinamicoModel->getValorAtributoDinamicoPorTabela($params2);
            // Atributo de Imóvel
            foreach ($atributosImovel as $atributo) {
                foreach ($codAtributoSelecionadosImovel as $codAtributoSelecionadoImovel) {
                    if ($atributo['cod_atributo'] == $codAtributoSelecionadoImovel) {
                        $valor = ($em->getRepository('CoreBundle:Imobiliario\AtributoImovelValor')->findBy(['inscricaoMunicipal' => $contribuinte['inscricao_municipal'], 'codAtributo' => $atributo['cod_atributo'], 'codCadastro' => $atributo['cod_cadastro'], 'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO]));
                        $atributo['valorDescricao'] = '';
                        if ($valor) {
                            if (is_numeric(end($valor)->getValor())) {
                                $valorDescricao = ($em->getRepository('CoreBundle:Administracao\AtributoValorPadrao')->findOneBy(['codAtributo' => $atributo['cod_atributo'], 'codCadastro' => $atributo['cod_cadastro'], 'codValor' => end($valor)->getValor(), 'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO, 'ativo' => true]));
                                $atributo['valorDescricao'] = $valorDescricao ? $valorDescricao->getValorPadrao() : '';
                            }
                        }
                        $contribuinte['atributos'][$indexCombinaAtributo] = $atributo;
                        $indexCombinaAtributo++;
                    }
                }
            }
        }
        return $contribuinte;
    }
}
