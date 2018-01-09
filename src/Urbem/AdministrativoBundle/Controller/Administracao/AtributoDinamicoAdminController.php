<?php

namespace Urbem\AdministrativoBundle\Controller\Administracao;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;

/**
 * Class AtributoDinamicoAdminController
 *
 * @package Urbem\AdministrativoBundle\Controller\Administracao
 */
class AtributoDinamicoAdminController extends Controller
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function consultarModuloAction(Request $request)
    {
        $codGestao = $request->attributes->get('id');

        $modulos = $this->getDoctrine()
            ->getRepository('CoreBundle:Administracao\Modulo')
            ->findByCodGestao($codGestao, array('ordem' => 'ASC'));

        $listModulos = array();
        foreach ($modulos as $index => $modulo) {
            $listModulos[$index]['value'] = $modulo->getCodModulo();
            $listModulos[$index]['label'] = $modulo->getNomModulo();
        }

        $response = new Response();
        $response->setContent(json_encode($listModulos));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function consultarCadastroAction(Request $request)
    {
        $codModulo = $request->attributes->get('id');

        $cadastros = $this->getDoctrine()
            ->getRepository('CoreBundle:Administracao\Cadastro')
            ->findByCodModulo($codModulo, array('nomCadastro' => 'ASC'));

        $listCadastro = array();
        foreach ($cadastros as $index => $cadastro) {
            $listCadastro[$index]['value'] = $cadastro->getCodCadastro();
            $listCadastro[$index]['label'] = $cadastro->getNomCadastro();
        }

        $response = new Response();
        $response->setContent(json_encode($listCadastro));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function consultarCamposPorCadastroAction(Request $request)
    {
        // Somente para atualizar informações
        $entidade = $request->get('entidade');
        $fkEntidadeAtributoValor = $request->get('fkEntidadeAtributoValor');

        $codEntidade = null;
        if (!empty($request->get('codEntidade'))) {
            $codEntidade = $request->get('codEntidade');
        }

        $valorAtributos = array();
        if ($codEntidade) {
            $objEntidade = $this->getDoctrine()->getRepository($entidade)->findOneBy($codEntidade);

            if ($objEntidade) {
                foreach ($objEntidade->$fkEntidadeAtributoValor() as $atributoValor) {
                    if ($atributoValor->getValor() != '') {
                        $valorAtributos[$atributoValor->getCodAtributo()] = $atributoValor->getValor();
                    }
                }
            }
        }

        $prefix = $request->get('prefix');
        $prefixFieldName = is_null($prefix) ? "" : '[' . $prefix . ']';
        $prefixFieldId = is_null($prefix) ? "" : $prefix . '_';

        /** @var QueryBuilder $qb */
        $qb = $this->getDoctrine()->getRepository(AtributoDinamico::class)->createQueryBuilder('o');
        if ($request->get('fkEntidadeJoin')) {
            $qb->innerJoin(sprintf('o.%s', $request->get('fkEntidadeJoin')), 'j');
            if ($request->get('codEntidadeJoin')) {
                foreach ($request->get('codEntidadeJoin') as $chave => $valor) {
                    $qb->andWhere(sprintf('j.%s = :%s', $chave, $chave));
                    $qb->setParameter($chave, $valor);
                }
            }
        }
        $qb->andWhere('o.codModulo = :codModulo');
        $qb->andWhere('o.codCadastro = :codCadastro');
        $qb->setParameter('codModulo', $request->get('codModulo'));
        $qb->setParameter('codCadastro', $request->get('codCadastro'));
        $atributosDinamico = $qb->getQuery()->getResult();

        /** @var AtributoDinamico $atributoDinamico */
        foreach ($atributosDinamico as $atributoDinamico) {
            if ($atributoDinamico->getAtivo()) {
                $isRequired = (!$atributoDinamico->getNaoNulo()) ? true : false;

                $codAtributo = $atributoDinamico->getCodAtributo();
                $required = 'required="required"';
                $help = '';
                $valorPadrao = '';
                $nomAtributo = $atributoDinamico->getNomAtributo();

                if ($atributoDinamico->getNaoNulo()) {
                    $required = '';
                }
                if ($atributoDinamico->getAjuda()) {
                    $help = '<span class="help-block sonata-ba-field-help">' . $atributoDinamico->getAjuda() . '</span>';
                }
                if ($atributoDinamico->getValorPadrao()) {
                    $valorPadrao = $atributoDinamico->getValorPadrao();
                }

                $tipo = $atributoDinamico->getCodTipo();

                if ($tipo == 3) {
                    $valorPadrao = '<option value="">Selecione</option>';
                }

                foreach ($atributoDinamico->getFkAdministracaoAtributoValorPadroes() as $options) {
                    if ($options->getAtivo()) {
                        if (($tipo == 3) || ($tipo == 4)) {
                            $selected = '';
                            if (isset($valorAtributos[$atributoDinamico->getCodAtributo()])) {
                                $selecteds = explode(',', $valorAtributos[$atributoDinamico->getCodAtributo()]);
                                if (in_array($options->getCodValor(), $selecteds)) {
                                    $selected = 'selected';
                                }
                            }
                            $valorPadrao .= '<option ' . $selected . ' value="' . $options->getCodValor() . '">' . $options->getValorPadrao() . '</option>';
                        } else {
                            $valorPadrao = $options->getValorPadrao();
                        }
                    }
                }

                if (isset($valorAtributos[$atributoDinamico->getCodAtributo()])) {
                    if (!(($tipo == 3) || ($tipo == 4))) {
                        $valorPadrao = $valorAtributos[$atributoDinamico->getCodAtributo()];
                    }
                }

                switch ($tipo) {
                    case 1:
                        $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoNumero" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoNumero">
                                    ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <input value="' . $valorPadrao . '" ' . $required . ' type="number" id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoNumero" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoNumero]" class="campo-sonata form-control">
                            </div>
                            ' . $help . '
                        </div>';
                        break;
                    case 2:
                        $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoTexto" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoTexto">
                                ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <input value="' . $valorPadrao . '" ' . $required . ' type="text" id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoTexto" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoTexto]" class="campo-sonata form-control">
                            </div>
                            ' . $help . '
                        </div>';
                        break;
                    case 3:
                        $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoLista" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoLista">
                                    ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural">
                                <select class="select2-parameters display-block" ' . $required . ' id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoLista" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoLista]">
                                    ' . $valorPadrao . '
                                </select>
                            </div>
                            ' . $help . '
                            <script type="text/javascript">
                                jQuery(function ($) {
                                    $(\'#' . $prefixFieldId . $codAtributo . '_atributoDinamicoLista\').select2();
                                });
                            </script>
                        </div>';
                        break;
                    case 4:
                        $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoLista" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoListaMultipla">
                                    ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <select class="select2-parameters col s12" ' . $required . '  multiple=true id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoListaMultipla" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoListaMultipla][]">
                                    ' . $valorPadrao . '
                                </select>
                            </div>
                            ' . $help . '
                            <script type="text/javascript">
                                jQuery(function ($) {
                                    $(\'#' . $prefixFieldId . $codAtributo . '_atributoDinamicoListaMultipla\').select2();
                                });
                            </script>
                        </div>';
                        break;
                    case 5:
                        $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoData" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoData">
                                ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <div class="input-group">
                                    <div class="input-group date" id="dp_' . $prefixFieldId . $codAtributo . '_atributoDinamicoData">
                                        <input value="' . $valorPadrao . '" ' . $required . ' type="text" id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoData" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoData]" class="sonata-medium-datecampo-sonata form-control" data-date-format="DD/MM/YYYY"><span class="input-group-addon"><span class="fa-calendar fa"></span></span>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                jQuery(function ($) {
                                    $(\'#dp_' . $prefixFieldId . $codAtributo . '_atributoDinamicoData\').datetimepicker({"pickTime":false,"useCurrent":true,"minDate":"1\/1\/1900","maxDate":null,"showToday":true,"language":"pt-BR","defaultDate":"","disabledDates":[],"enabledDates":[],"icons":{"time":"fa fa-clock-o","date":"fa fa-calendar","up":"fa fa-chevron-up","down":"fa fa-chevron-down"},"useStrict":false,"sideBySide":false,"daysOfWeekDisabled":[],"useSeconds":false});
                                });
                            </script>
                            ' . $help . '
                        </div>';
                        break;
                    case 6:
                        $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoDecimal" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoDecimal">
                                    ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <input value="' . $valorPadrao . '" ' . $required . ' type="number" id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoDecimal" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoDecimal]" class="campo-sonata form-control">
                            </div>
                            ' . $help . '
                        </div>';
                        break;
                    case 7:
                        $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoTextoLongo" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoTextoLongo">
                                    ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <textarea id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoTextoLongo" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoTextoLongo]" class=" form-control" ' . $required . '>' . $valorPadrao . '</textarea>
                            </div>
                            ' . $help . '
                        </div>';
                        break;
                }
            }
        }

        if (empty($return)) {
            $return[] = false;
        }
        $response = new Response();
        $response->setContent(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function consultarCamposAction(Request $request)
    {
        $tabela = $request->get('tabela');
        $fkTabela = $request->get('fkTabela');
        $tabelaPai = $request->get('tabelaPai');
        $codTabelaPai = $request->get('codTabelaPai');
        $fkTabelaPaiCollection = $request->get('fkTabelaPaiCollection');
        $fkTabelaPai = $request->get('fkTabelaPai');

        $codTabela = null;
        if (!empty($request->get('codTabela'))) {
            $codTabela = $request->get('codTabela');
        }

        $prefix = $request->get('prefix');
        $prefixFieldName = is_null($prefix) ? "" : '[' . $prefix . ']';
        $prefixFieldId = is_null($prefix) ? "" : $prefix . '_';

        if ($codTabela) {
            $objTabela = $this->getDoctrine()->getRepository($tabela)->find($codTabela);
            foreach ($objTabela->$fkTabela() as $atributoValor) {
                $atributoTabela = $atributoValor->$fkTabelaPai();
                $valorAtributos[$atributoTabela->getCodAtributo()] = $atributoValor->getValor();
            }
        }

        $return = [];

        $codAtributosDinamicos = $this->getDoctrine()->getRepository($tabelaPai)->findBy($codTabelaPai);
        foreach ($codAtributosDinamicos as $atributosDinamicos) {
            foreach ($atributosDinamicos->$fkTabelaPaiCollection() as $codAtributoDinamico) {
                /** @var AtributoDinamico $atributoDinamico */
                $atributoDinamico = $codAtributoDinamico->getFkAdministracaoAtributoDinamico();
                $isRequired = (!$atributoDinamico->getNaoNulo()) ? true : false;

                if (!$atributoDinamico->getAtivo()) {
                    break;
                }

                $codAtributo = $atributoDinamico->getCodAtributo();
                $required = 'required=true';
                $help = '';
                $valorPadrao = '';
                $nomAtributo = $atributoDinamico->getNomAtributo();

                if ($atributoDinamico->getNaoNulo()) {
                    $required = 'required=false';
                }
                if ($atributoDinamico->getAjuda()) {
                    $help = '<span class="help-block sonata-ba-field-help">' . $atributoDinamico->getAjuda() . '</span>';
                }
                if ($atributoDinamico->getValorPadrao()) {
                    $valorPadrao = $atributoDinamico->getValorPadrao();
                }

                $tipo = $atributoDinamico->getFkAdministracaoTipoAtributo()->getCodTipo();

                if ($tipo == 3) {
                    $valorPadrao = '<option value="">Selecione</option>';
                }

                foreach ($atributoDinamico->getFkAdministracaoAtributoValorPadroes() as $options) {
                    if (!$options->getAtivo()) {
                        break;
                    }
                    if (($tipo == 3) || ($tipo == 4)) {
                        $selected = '';
                        if (isset($valorAtributos)) {
                            if ($options->getCodValor() == $valorAtributos[$atributoDinamico->getCodAtributo()]) {
                                $selected = 'selected';
                            }
                        }
                        $valorPadrao .= '<option ' . $selected . ' value="' . $options->getCodValor() . '">' . $options->getValorPadrao() . '</option>';
                    } else {
                        $valorPadrao = $options->getValorPadrao();
                    }
                }

                if (isset($valorAtributos)) {
                    if (!(($tipo == 3) || ($tipo == 4))) {
                        $valorPadrao = $valorAtributos[$codAtributoDinamico->getCodAtributo()];
                    }
                }

                switch ($tipo) {
                    case 1:
                        $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoNumero" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoNumero">
                                    ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <input value="' . $valorPadrao . '" ' . $required . ' type="number" id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoNumero" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoNumero]" class="campo-sonata form-control">
                            </div>
                            ' . $help . '
                        </div>';
                        break;
                    case 2:
                        $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoTexto" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoTexto">
                                ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <input value="' . $valorPadrao . '" ' . $required . ' type="text" id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoTexto" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoTexto]" class="campo-sonata form-control">
                            </div>
                            ' . $help . '
                        </div>';
                        break;
                    case 3:
                        $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoLista" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoLista">
                                    ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <select class="select2-parameters " id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoLista" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoLista]">
                                    ' . $valorPadrao . '
                                </select>
                            </div>
                            ' . $help . '
                            <script type="text/javascript">
                                jQuery(function ($) {
                                    $(\'#' . $prefixFieldId . $codAtributo . '_atributoDinamicoLista\').select2();
                                });
                            </script>
                        </div>';
                        break;
                    case 4:
                        $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoLista" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoListaMultipla">
                                    ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <select class="select2-parameters col s12" multiple id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoListaMultipla" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoListaMultipla][]">
                                    ' . $valorPadrao . '
                                </select>
                            </div>
                            ' . $help . '
                            <script type="text/javascript">
                                jQuery(function ($) {
                                    $(\'#' . $prefixFieldId . $codAtributo . '_atributoDinamicoListaMultipla\').select2();
                                });
                            </script>
                        </div>';
                        break;
                    case 5:
                        $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoData" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoData">
                                ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <div class="input-group">
                                    <div class="input-group date" id="dp_' . $prefixFieldId . $codAtributo . '_atributoDinamicoData">
                                        <input value="' . $valorPadrao . '" ' . $required . ' type="text" id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoData" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoData]" class="sonata-medium-datecampo-sonata form-control" data-date-format="DD/MM/YYYY"><span class="input-group-addon"><span class="fa-calendar fa"></span></span>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                jQuery(function ($) {
                                    $(\'#dp_' . $prefixFieldId . $codAtributo . '_atributoDinamicoData\').datetimepicker({"pickTime":false,"useCurrent":true,"minDate":"1\/1\/1900","maxDate":null,"showToday":true,"language":"pt-BR","defaultDate":"","disabledDates":[],"enabledDates":[],"icons":{"time":"fa fa-clock-o","date":"fa fa-calendar","up":"fa fa-chevron-up","down":"fa fa-chevron-down"},"useStrict":false,"sideBySide":false,"daysOfWeekDisabled":[],"useSeconds":false});
                                });
                            </script>
                            ' . $help . '
                        </div>';
                        break;
                    case 6:
                        $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoDecimal" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoDecimal">
                                    ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <input value="' . $valorPadrao . '" ' . $required . ' type="number" id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoDecimal" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoDecimal]" class="campo-sonata form-control">
                            </div>
                            ' . $help . '
                        </div>';
                        break;
                    case 7:
                        $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoTextoLongo" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoTextoLongo">
                                    ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <textarea id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoTextoLongo" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoTextoLongo]" class=" form-control" ' . $required . '>' . $valorPadrao . '</textarea>
                            </div>
                            ' . $help . '
                        </div>';
                        break;
                }
            }
        }

        if (empty($return)) {
            $return[] = false;
        }
        $response = new Response();
        $response->setContent(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function consultarCamposPorModuloCadastroEAtributoAction(Request $request)
    {
        $tabela = $request->get('tabela');
        $fkTabela = $request->get('fkTabela');
        $tabelaPai = $request->get('tabelaPai');
        $codTabelaPai = $request->get('codTabelaPai');
        $fkTabelaPaiCollection = $request->get('fkTabelaPaiCollection');
        $fkTabelaPai = $request->get('fkTabelaPai');

        $codTabela = null;
        if (!empty($request->get('codTabela'))) {
            $codTabela = $request->get('codTabela');
        }

        $prefix = $request->get('prefix');
        $prefixFieldName = is_null($prefix) ? "" : '[' . $prefix . ']';
        $prefixFieldId = is_null($prefix) ? "" : $prefix . '_';

        if ($codTabela) {
            $objTabela = $this->getDoctrine()->getRepository($tabela)->find($codTabela);
            foreach ($objTabela->$fkTabela() as $atributoValor) {
                $atributoTabela = $atributoValor->$fkTabelaPai();
                $valorAtributos[$atributoTabela->getCodAtributo()] = $atributoValor->getValor();
            }
        }

        $return = [];

        /** @var AtributoDinamico $atributoDinamico */
        $atributoDinamico = $this->getDoctrine()->getRepository($tabelaPai)->findOneBy($codTabelaPai);

        $isRequired = (!$atributoDinamico->getNaoNulo()) ? true : false;

        $codAtributo = $atributoDinamico->getCodAtributo();
        $required = 'required=true';
        $help = '';
        $valorPadrao = '';
        $nomAtributo = $atributoDinamico->getNomAtributo();

        if ($atributoDinamico->getNaoNulo()) {
            $required = 'required=false';
        }
        if ($atributoDinamico->getAjuda()) {
            $help = '<span class="help-block sonata-ba-field-help">' . $atributoDinamico->getAjuda() . '</span>';
        }
        if ($atributoDinamico->getValorPadrao()) {
            $valorPadrao = $atributoDinamico->getValorPadrao();
        }

        $tipo = $atributoDinamico->getFkAdministracaoTipoAtributo()->getCodTipo();

        if ($tipo == 3) {
            $valorPadrao = '<option value="">Selecione</option>';
        }

        foreach ($atributoDinamico->getFkAdministracaoAtributoValorPadroes() as $options) {
            if (!$options->getAtivo()) {
                break;
            }
            if (($tipo == 3) || ($tipo == 4)) {
                $selected = '';
                if (isset($valorAtributos)) {
                    if ($options->getCodValor() == $valorAtributos[$atributoDinamico->getCodAtributo()]) {
                        $selected = 'selected';
                    }
                }
                $valorPadrao .= '<option ' . $selected . ' value="' . $options->getCodValor() . '">' . $options->getValorPadrao() . '</option>';
            } else {
                $valorPadrao = $options->getValorPadrao();
            }
        }
        
        switch ($tipo) {
            case 1:
                $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoNumero" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoNumero">
                                    ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <input value="' . $valorPadrao . '" ' . $required . ' type="number" id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoNumero" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoNumero]" class="campo-sonata form-control">
                            </div>
                            ' . $help . '
                        </div>';
                break;
            case 2:
                $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoTexto" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoTexto">
                                ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <input value="' . $valorPadrao . '" ' . $required . ' type="text" id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoTexto" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoTexto]" class="campo-sonata form-control">
                            </div>
                            ' . $help . '
                        </div>';
                break;
            case 3:
                $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoLista" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoLista">
                                    ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <select class="select2-parameters " id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoLista" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoLista]">
                                    ' . $valorPadrao . '
                                </select>
                            </div>
                            ' . $help . '
                            <script type="text/javascript">
                                jQuery(function ($) {
                                    $(\'#' . $prefixFieldId . $codAtributo . '_atributoDinamicoLista\').select2();
                                });
                            </script>
                        </div>';
                break;
            case 4:
                $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoLista" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoListaMultipla">
                                    ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <select class="select2-parameters col s12" multiple=true id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoListaMultipla" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoListaMultipla]">
                                    ' . $valorPadrao . '
                                </select>
                            </div>
                            ' . $help . '
                            <script type="text/javascript">
                                jQuery(function ($) {
                                    $(\'#' . $prefixFieldId . $codAtributo . '_atributoDinamicoListaMultipla\').select2();
                                });
                            </script>
                        </div>';
                break;
            case 5:
                $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoData" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoData">
                                ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <div class="input-group">
                                    <div class="input-group date" id="dp_' . $prefixFieldId . $codAtributo . '_atributoDinamicoData">
                                        <input value="' . $valorPadrao . '" ' . $required . ' type="text" id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoData" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoData]" class="sonata-medium-datecampo-sonata form-control" data-date-format="DD/MM/YYYY"><span class="input-group-addon"><span class="fa-calendar fa"></span></span>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                jQuery(function ($) {
                                    $(\'#dp_' . $prefixFieldId . $codAtributo . '_atributoDinamicoData\').datetimepicker({"pickTime":false,"useCurrent":true,"minDate":"1\/1\/1900","maxDate":null,"showToday":true,"language":"pt-BR","defaultDate":"","disabledDates":[],"enabledDates":[],"icons":{"time":"fa fa-clock-o","date":"fa fa-calendar","up":"fa fa-chevron-up","down":"fa fa-chevron-down"},"useStrict":false,"sideBySide":false,"daysOfWeekDisabled":[],"useSeconds":false});
                                });
                            </script>
                            ' . $help . '
                        </div>';
                break;
            case 6:
                $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoDecimal" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoDecimal">
                                    ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <input value="' . $valorPadrao . '" ' . $required . ' type="number" id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoDecimal" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoDecimal]" class="campo-sonata form-control">
                            </div>
                            ' . $help . '
                        </div>';
                break;
            case 7:
                $return[] = '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $prefixFieldId . $codAtributo . '_atributoDinamicoTextoLongo" style="display: block;">
                            <label class=" control-label" for="' . $prefixFieldId . $codAtributo . '_atributoDinamicoTextoLongo">
                                    ' . $nomAtributo . ($isRequired ? ' *' : '') . '
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <textarea id="' . $prefixFieldId . $codAtributo . '_atributoDinamicoTextoLongo" name="atributoDinamico' . $prefixFieldName . '[' . $codAtributo . '][atributoDinamicoTextoLongo]" class=" form-control" ' . $required . '>' . $valorPadrao . '</textarea>
                            </div>
                            ' . $help . '
                        </div>';
                break;
        }

        if (empty($return)) {
            $return[] = false;
        }
        $response = new Response();
        $response->setContent(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
