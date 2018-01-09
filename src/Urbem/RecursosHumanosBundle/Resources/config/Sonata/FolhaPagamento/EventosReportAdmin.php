<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class EventosReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_relatorios_eventos';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/relatorios/eventos';

    public function prePersist($object)
    {
        exit("Formulário legado");
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        $formMapper
            ->with("Parâmetros para Emissão do Relatório")
                ->add(
                    "codigoInicial",
                    "number"
                )
                ->add(
                    "codigoFinal",
                    "number"
                )
                ->add(
                    "natureza",
                    'choice',
                    [
                        'multiple' => true,
                        'choices' => array(
                            'Proventos' => 'P',
                            'Descontos' => 'D',
                            'Informativo' => 'I',
                            'Base' => 'B',
                        )
                    ]
                )
                ->add(
                    "tipo",
                    'choice',
                    [
                        'multiple' => true,
                        'choices' => array(
                            'Fixo' => 'F',
                            'Variável' => 'V'
                        )
                    ]
                )
                ->add(
                    "fixado",
                    'choice',
                    [
                        'multiple' => true,
                        'choices' => array(
                            'Valor' => 'V',
                            'Quantidade' => 'Q'
                        )
                    ]
                )
                ->add(
                    "caracteristicas",
                    'choice',
                    [
                        'choices' => array(
                            'Salário' => '1',
                            'Férias' => '2',
                            '13o Salário' => '3',
                            'Rescisao' => '4',
                        ),
                        'multiple' => false,
                        'label' => 'Característica',
                    ]
                )
                ->add(
                    "sequenciaCalculo",
                    'choice',
                    [
                        'choices' => array(
                            'Eventos que não dependem de outro evento para o cálculo' => '1',
                            'Sequencia 2' => '4',
                            'Sequencia 3' => '5',
                            'Sequencia 4' => '6',
                            'Sequencia 5' => '7',
                            'Sequencia 6' => '20',
                            'Sequencia 10' => '21',
                            'Sequencia 800' => '8',
                            'Sequencia 800' => '8',
                            'Sequencia 900' => '17',
                            'Sequencia 910' => '19',
                            'Sequencia 950' => '18',
                            'Bases de Previdência' => '2',
                            'Sequencia 1001 - salario familia rpps' => '9',
                            'Descontos de Previdência' => '16',
                            'Sequencia 1200 - Base Deduções IRRF s/pensao' => '10',
                            'Sequencia 1260 - Base descontos Pensão Judicial' => '15',
                            'Sequencia 1300 - Base Pensão' => '12',
                            'Sequencia 1350 - Base deduçõe IRRF c/pensao' => '13',
                            'Sequencia 1400 - Desc IRRF c/pensao' => '14',
                            'Descontos de Previdência' => '3'
                        ),
                        'multiple' => false,
                        'label' => 'Sequência de Cálculo',
                    ]
                )
            ->end()
            ->with("Função/Especialidade")
                ->add(
                    "regime",
                    'entity',
                    array(
                        'class' => 'CoreBundle:SwCgmPessoaFisica',
                        'choice_label' => 'numcgm.nomCgm',
                        'label' => 'Regime',
                        'multiple' => false,
                        'required' => false
                    )
                )
                ->add(
                    "subdivisao",
                    'entity',
                    array(
                        'class' => 'CoreBundle:SwCgmPessoaFisica',
                        'choice_label' => 'numcgm.nomCgm',
                        'label' => 'Subdivisão',
                        'multiple' => false,
                        'required' => false
                    )
                )
                ->add(
                    "funcao",
                    'entity',
                    array(
                        'class' => 'CoreBundle:SwCgmPessoaFisica',
                        'choice_label' => 'numcgm.nomCgm',
                        'label' => 'Função',
                        'multiple' => false,
                        'required' => false
                    )
                )
                ->add(
                    "especialidade",
                    'entity',
                    array(
                        'class' => 'CoreBundle:SwCgmPessoaFisica',
                        'choice_label' => 'numcgm.nomCgm',
                        'label' => 'Especialidade',
                        'multiple' => false,
                        'required' => false
                    )
                )
                ->add(
                    "apresentarFuncaoEspecial",
                    "checkbox",
                    [
                        'required' => false
                    ]
                )
                ->add(
                    "competencia",
                    'date',
                    array(
                        'label' => 'Competência',
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array(
                            'data-provide' => 'datepicker',
                            'class' => 'datepicker '
                        ),
                        'format' => 'MM/dd/yyyy',
                    )
                )
                ->add(
                    "ordenacao",
                    "choice",
                    [
                        'choices' => [
                            'Códigos do evento' => 'codigo',
                            'Descrição do evento' => 'descricao',
                        ],
                        'multiple' => false,
                        'label' => 'Ordenação dos eventos',
                    ]
                )
            ->end()
        ;
    }
}
