<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Model\Imobiliario\CadastroImobiliarioConfiguracaoModel;

class ConfiguracaoController extends BaseController
{
    const PARAMETRO_CODIGO_LOCALIZACAO = 'codigo_localizacao';
    const PARAMETRO_MASCARA_LOTE = 'mascara_lote';
    const PARAMETRO_NUMERO_INSCRICAO = 'numero_inscricao';
    const PARAMETRO_MASCARA_INSCRICAO = 'mascara_inscricao';
    const PARAMETRO_ORDEM_ENTREGA = 'ordem_entrega';
    const PARAMETRO_NAVEGACAO_AUTOMATICA = 'navegacao_automatica';
    const PARAMETRO_VALOR_MD = 'valor_md';
    const PARAMETRO_ALIQUOTAS = 'aliquotas';
    const PARAMETRO_ATRIB_LOTE_URBANO = 'atrib_lote_urbano';
    const PARAMETRO_ATRIB_LOTE_RURAL = 'atrib_lote_rural';
    const PARAMETRO_ATRIB_IMOVEL = 'atrib_imovel';
    const PARAMETRO_ATRIB_EDIFICACAO = 'atrib_edificacao';

    const ORDEM_ENTREGA_VALORES_PADRAO = [
        1 => 'label.configuracaoImobiliaria.enderecoProprietario',
        2 => 'label.configuracaoImobiliaria.enderecoPromitente',
        3 => 'label.configuracaoImobiliaria.enderecoImovel',
        4 => 'label.configuracaoImobiliaria.enderecoEntregaImovel'
    ];

    const OPCOES = array(
        1 => 'label.configuracaoImobiliaria.trecho',
        2 => 'label.configuracaoImobiliaria.faceQuadra',
        3 => 'label.configuracaoImobiliaria.bairro',
        4 => 'label.configuracaoImobiliaria.localizacao',
        5 => 'label.configuracaoImobiliaria.tipoEdificacao'
    );

    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Imobiliario/Configuracao/home.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function alterarAction(Request $request)
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getEntityManager();
        $model = new CadastroImobiliarioConfiguracaoModel($em);

        $ordemEntrada = $model
            ->recuperaConfiguracaoOrdemEntrada(
                self::PARAMETRO_ORDEM_ENTREGA,
                Modulo::MODULO_CADASTRO_IMOBILIARIO,
                $this->getExercicio(),
                $this->get('translator')
            );

        $form = $this->createFormBuilder([])
            ->add(
                'codigo_localizacao',
                ChoiceType::class,
                array(
                    'label' => 'label.configuracaoImobiliaria.codigoLocalizacao',
                    'required' => true,
                    'expanded' => false,
                    'choices' => array(
                        'label.configuracaoImobiliaria.automatico' => 'true',
                        'label.configuracaoImobiliaria.manual' => 'false',
                    ),
                    'data' => $model
                        ->recuperaConfiguracaoTexto(
                            self::PARAMETRO_CODIGO_LOCALIZACAO,
                            Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            $this->getExercicio()
                        )
                )
            )
            ->add(
                'mascara_lote',
                TextType::class,
                array(
                    'label' => 'label.configuracaoImobiliaria.mascaraLote',
                    'required' => true,
                    'data' => $model
                        ->recuperaConfiguracaoTexto(
                            self::PARAMETRO_MASCARA_LOTE,
                            Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            $this->getExercicio()
                        )
                )
            )
            ->add(
                'numero_inscricao',
                ChoiceType::class,
                array(
                    'label' => 'label.configuracaoImobiliaria.numeroInscricao',
                    'required' => true,
                    'expanded' => false,
                    'choices' => array(
                        'label.configuracaoImobiliaria.automatico' => 'true',
                        'label.configuracaoImobiliaria.manual' => 'false',
                    ),
                    'data' => $model
                        ->recuperaConfiguracaoTexto(
                            self::PARAMETRO_NUMERO_INSCRICAO,
                            Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            $this->getExercicio()
                        )
                )
            )
            ->add(
                'mascara_inscricao',
                TextType::class,
                array(
                    'label' => 'label.configuracaoImobiliaria.mascaraInscricao',
                    'required' => true,
                    'data' => $model
                        ->recuperaConfiguracaoTexto(
                            self::PARAMETRO_MASCARA_INSCRICAO,
                            Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            $this->getExercicio()
                        )
                )
            )
            ->add(
                'ordem_entrega',
                ChoiceType::class,
                array(
                    'label' => 'label.configuracaoImobiliaria.ordemEntrega',
                    'required' => true,
                    'multiple' => true,
                    'disabled' => true,
                    'choices' => $ordemEntrada,
                    'data' => $ordemEntrada
                )
            )
            ->add(
                'navegacao_automatica',
                ChoiceType::class,
                array(
                    'label' => 'label.configuracaoImobiliaria.navegacaoAutomatica',
                    'required' => true,
                    'expanded' => false,
                    'choices' => array(
                        'label.configuracaoImobiliaria.ativo' => 'ativo',
                        'label.configuracaoImobiliaria.inativo' => 'inativo',
                    ),
                    'data' => $model
                        ->recuperaConfiguracaoTexto(
                            self::PARAMETRO_NAVEGACAO_AUTOMATICA,
                            Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            $this->getExercicio()
                        )
                )
            )
            ->add(
                'valor_md',
                ChoiceType::class,
                array(
                    'label' => 'label.configuracaoImobiliaria.valorMD',
                    'required' => false,
                    'multiple' => true,
                    'choices' => array_flip(self::OPCOES),
                    'data' => array_flip(
                        $model->recuperaConfiguracaoChaveValor(
                            self::PARAMETRO_VALOR_MD,
                            Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            $this->getExercicio()
                        )
                    )
                )
            )
            ->add(
                'aliquotas',
                ChoiceType::class,
                array(
                    'label' => 'label.configuracaoImobiliaria.aliquotas',
                    'required' => false,
                    'multiple' => true,
                    'choices' => array_flip(self::OPCOES),
                    'data' => array_flip(
                        $model->recuperaConfiguracaoChaveValor(
                            self::PARAMETRO_ALIQUOTAS,
                            Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            $this->getExercicio()
                        )
                    )
                )
            )
            ->add(
                'atrib_lote_urbano',
                ChoiceType::class,
                array(
                    'label' => 'label.configuracaoImobiliaria.atribLoteUrbano',
                    'required' => false,
                    'multiple' => true,
                    'choices' => array_flip(
                        $model
                            ->recuperaAtributoDinamico(
                                Modulo::MODULO_CADASTRO_IMOBILIARIO,
                                Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO
                            )
                    ),
                    'data' => array_flip(
                        $model->recuperaConfiguracaoIds(
                            self::PARAMETRO_ATRIB_LOTE_URBANO,
                            Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO,
                            $this->getExercicio()
                        )
                    )
                )
            )
            ->add(
                'atrib_lote_rural',
                ChoiceType::class,
                array(
                    'label' => 'label.configuracaoImobiliaria.atribLoteRural',
                    'required' => false,
                    'multiple' => true,
                    'choices' => array_flip(
                        $model
                            ->recuperaAtributoDinamico(
                                Modulo::MODULO_CADASTRO_IMOBILIARIO,
                                Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL
                            )
                    ),
                    'data' => array_flip(
                        $model->recuperaConfiguracaoIds(
                            self::PARAMETRO_ATRIB_LOTE_RURAL,
                            Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL,
                            $this->getExercicio()
                        )
                    )
                )
            )
            ->add(
                'atrib_imovel',
                ChoiceType::class,
                array(
                    'label' => 'label.configuracaoImobiliaria.atribImovel',
                    'required' => false,
                    'multiple' => true,
                    'choices' => array_flip(
                        $model
                            ->recuperaAtributoDinamico(
                                Modulo::MODULO_CADASTRO_IMOBILIARIO,
                                Cadastro::CADASTRO_TRIBUTARIO_IMOVEL
                            )
                    ),
                    'data' => array_flip(
                        $model->recuperaConfiguracaoIds(
                            self::PARAMETRO_ATRIB_IMOVEL,
                            Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            Cadastro::CADASTRO_TRIBUTARIO_IMOVEL,
                            $this->getExercicio()
                        )
                    )
                )
            )
            ->add(
                'atrib_edificacao',
                ChoiceType::class,
                array(
                    'label' => 'label.configuracaoImobiliaria.atribEdificacao',
                    'required' => false,
                    'multiple' => true,
                    'choices' => array_flip(
                        $model
                            ->recuperaAtributoDinamico(
                                Modulo::MODULO_CADASTRO_IMOBILIARIO,
                                Cadastro::CADASTRO_TRIBUTARIO_TIPO_EDIFICACAO
                            )
                    ),
                    'data' => array_flip(
                        $model->recuperaConfiguracaoIds(
                            self::PARAMETRO_ATRIB_EDIFICACAO,
                            Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            Cadastro::CADASTRO_TRIBUTARIO_TIPO_EDIFICACAO,
                            $this->getExercicio()
                        )
                    )
                )
            )
            ->setAction($this->generateUrl('tributario_imobiliario_configuracao_alterar'))
            ->getForm();

        $form->handleRequest($request);

        $retorno = ['form' => $form->createView()];
        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $request = $request->request->get('form');
            $retorno = $model
                ->salvarConfiguracao(
                    Modulo::MODULO_CADASTRO_IMOBILIARIO,
                    $request,
                    $this->getExercicio(),
                    $this->get('translator')
                );

            $container = $this->container;
            if ($retorno === true) {
                $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.configuracaoImobiliaria.msgSucesso'));
                return $this->redirect($this->generateUrl('tributario_imobiliario_configuracao_alterar'));
            } else {
                $container->get('session')->getFlashBag()->add('error', 'contactSupport');
                $container->get('session')->getFlashBag()->add('error', $retorno->getMessage());
                return $this->redirect($this->generateUrl('tributario_imobiliario_configuracao_alterar'));
            }
        } else {
            return $this->render(
                'TributarioBundle::Imobiliario/Configuracao/configuracao.html.twig',
                $retorno
            );
        }
    }
}
