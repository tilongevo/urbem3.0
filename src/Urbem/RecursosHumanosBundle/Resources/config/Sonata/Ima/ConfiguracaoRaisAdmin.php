<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Folhapagamento;
use Urbem\CoreBundle\Entity\Ima;

class ConfiguracaoRaisAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_ima_rais';

    protected $baseRoutePattern = 'recursos-humanos/ima/rais';

    protected $model = null;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio', null, ['label' => 'label.configuracaoRais.exercicio'])
            ->add('numcgm', null, [
                'label' => 'label.configuracaoRais.responsavel'
            ], 'entity', [
                'class' => Entity\SwCgmPessoaFisica::class,
                'choice_label' => function ($numcgm) {
                    return $numcgm->getNumcgm()->getNomCgm();
                },
                'attr' => array(
                    'class' => 'select2-parameters '
                )
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codExercicio', null, array('label' => 'Id'))
            ->add('exercicio', null, array('label' => 'label.configuracaoRais.exercicio'))
            ->add('numcgm', null, array(
                'label' => 'label.configuracaoRais.responsavel',
                'associated_property' => function ($numcgm) {
                    return $numcgm->getNumcgm()->getNomCgm();
                }
            ))
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['eventoComposicaoRemuneracao'] = [
            'class' => Folhapagamento\Evento::class,
            'choice_label' => 'descricao',
            'label' => 'label.configuracaoRais.composicao',
            'mapped' => false,
            'multiple' => true,
            'query_builder' => function ($eventoComposicaoRemuneracao) {
                $qb = $eventoComposicaoRemuneracao->createQueryBuilder('e');
                $qb->where($qb->expr()->orX(
                    $qb->expr()->eq('e.natureza', '?1'),
                    $qb->expr()->eq('e.natureza', '?2'),
                    $qb->expr()->eq('e.natureza', '?3')
                ))
                ->setParameter(1, 'P')
                ->setParameter(2, 'D')
                ->setParameter(3, 'B');

                return $qb;
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $fieldOptions['eventoHorasExtras'] = [
            'class' => Folhapagamento\Evento::class,
            'choice_label' => 'descricao',
            'label' => 'label.configuracaoRais.horaExtra',
            'mapped' => false,
            'multiple' => true,
            'query_builder' => function ($eventoComposicaoRemuneracao) {
                $qb = $eventoComposicaoRemuneracao->createQueryBuilder('e');
                $qb->where($qb->expr()->orX(
                    $qb->expr()->eq('e.natureza', '?1'),
                    $qb->expr()->eq('e.natureza', '?2'),
                    $qb->expr()->eq('e.natureza', '?3')
                ))
                ->setParameter(1, 'P')
                ->setParameter(2, 'D')
                ->setParameter(3, 'B');

                return $qb;
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $fieldOptions['ceiVinculado'] = [
            'label' => 'label.configuracaoRais.ceiVinculado',
            'required' => false
        ];

        $fieldOptions['exercicio'] = [
            'label' => 'label.configuracaoRais.exercicio'
        ];

        if ($this->id($this->getSubject())) {
            $em = $this->modelManager->getEntityManager($this->getClass());


            /*
            *   CNPJ Possui CEI Vinculado
            */
            $configRais = $em->getRepository($this->getClass())->findOneByCodExercicio($id);
            $fieldOptions['ceiVinculado']['data'] = $configRais->isCeiVinculado();
            $fieldOptions['exercicio']['data'] = $configRais->getExercicio();
            $fieldOptions['exercicio']['mapped'] = false;

            /*
            *   Composição da Remuneração Rais
            */

            $eventoComposicaoRemuneracoes = $em->getRepository('CoreBundle:Ima\EventoComposicaoRemuneracao')->findByCodExercicio($id);
            if (count($eventoComposicaoRemuneracoes) > 0) {
                $fieldOptions['eventoComposicaoRemuneracao']['choice_attr'] = function ($evento, $key, $index) use ($eventoComposicaoRemuneracoes) {
                    foreach ($eventoComposicaoRemuneracoes as $eventoComposicaoRemuneracao) {
                        if ($eventoComposicaoRemuneracao->getCodEvento() == $evento) {
                            return ['selected' => 'selected'];
                        }
                    }

                    return ['selected' => false];
                };
            }

            /*
            *   Eventos Horas Extras
            */

            $eventoHorasExtras = $em->getRepository('CoreBundle:Ima\EventoHorasExtras')->findByCodExercicio($id);
            if (count($eventoHorasExtras) > 0) {
                $fieldOptions['eventoHorasExtras']['choice_attr'] = function ($evento, $key, $index) use ($eventoHorasExtras) {
                    foreach ($eventoHorasExtras as $eventoHorasExtra) {
                        if ($eventoHorasExtra->getCodEvento() == $evento) {
                            return ['selected' => 'selected'];
                        }
                    }

                    return ['selected' => false];
                };
            }
        }

        $formMapper
            ->with('label.configuracaoRais.modulo')
                ->add('exercicio', null, $fieldOptions['exercicio'])
            ->end()
            ->with('label.configuracaoRais.infoResponsavel')
                ->add('numcgm', 'entity', array(
                    'class' => Entity\SwCgmPessoaFisica::class,
                    'choice_label' => function ($numcgm) {
                        return $numcgm->getNumcgm()->getNomCgm();
                    },
                    'label' => 'label.configuracaoRais.responsavel',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ))
                ->add('tipoInscricao', 'hidden', array(
                    'required' => false,
                    'mapped' => false
                ))
                ->add(
                    'telefone',
                    'text',
                    [
                        'label' => 'label.telefone',
                        'attr' => [
                                'readonly' => true
                            ],
                        'required' => false
                    ]
                )
                ->add(
                    'email',
                    'text',
                    [
                        'label' => 'email',
                        'attr' => [
                                'readonly' => true
                            ],
                        'required' => false
                    ]
                )
            ->end()
            ->with('label.configuracaoRais.infoEstabelecimento')
                ->add('naturezaJuridica', null, ['label' => 'label.configuracaoRais.naturezaJuridica'])
                ->add('codMunicipio', null, ['label' => 'label.configuracaoRais.codMunicipio'])
                ->add('dtBaseCategoria', null, ['label' => 'label.configuracaoRais.dtBaseCategoria'])
                ->add('ceiVinculado', 'checkbox', $fieldOptions['ceiVinculado'])
                ->add('numeroCei', null, ['label' => 'label.configuracaoRais.numeroCei'])
                ->add('prefixo', null, ['label' => 'label.configuracaoRais.prefixo'])
                ->add('codTipoControlePonto', 'entity', array(
                    'class' => Ima\TipoControlePonto::class,
                    'choice_label' => function ($codTipoControlePonto) {
                        return $codTipoControlePonto->getDescricao();
                    },
                    'label' => 'label.configuracaoRais.tipoControlePonto',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ))
            ->end()
            ->with('label.configuracaoRais.infoRendimento')
                ->add('eventoComposicaoRemuneracao', 'entity', $fieldOptions['eventoComposicaoRemuneracao'])
                ->add('eventoHorasExtras', 'entity', $fieldOptions['eventoHorasExtras'])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('exercicio', null, array('label' => 'label.configuracaoRais.exercicio'))
            ->add('numcgm', null, array(
                'label' => 'label.configuracaoRais.responsavel',
                'associated_property' => function ($numcgm) {
                    return $numcgm->getNumcgm()->getNomCgm();
                }
            ))
            ->add('telefone', null, ['label' => 'label.telefone'])
            ->add('email', null, ['label' => 'label.telefone'])
            ->add('naturezaJuridica', null, ['label' => 'label.configuracaoRais.naturezaJuridica'])
            ->add('codMunicipio', null, ['label' => 'label.configuracaoRais.codMunicipio'])
            ->add('dtBaseCategoria', null, ['label' => 'label.configuracaoRais.dtBaseCategoria'])
            ->add('ceiVinculado', null, [
                'label' => 'label.configuracaoRais.ceiVinculado'
            ])
        ;

        $em = $this->modelManager->getEntityManager($this->getClass());
        $configRais = $em->getRepository($this->getClass())->findOneByCodExercicio($this->getAdminRequestId());
        if ($configRais->isCeiVinculado()) {
            $showMapper
                ->add('numeroCei', null, ['label' => 'label.configuracaoRais.numeroCei'])
                ->add('prefixo', null, ['label' => 'label.configuracaoRais.prefixo'])
            ;
        }

        $showMapper
            ->add('codTipoControlePonto', null, array(
                'associated_property' => function ($codTipoControlePonto) {
                    return $codTipoControlePonto->getDescricao();
                },
                'label' => 'label.configuracaoRais.tipoControlePonto'
            ))
            ->add('eventoComposicaoRemuneracaoCollection', null, [
                'associated_property' => function ($eventoComposicaoRemuneracaoCollection) {
                    return $eventoComposicaoRemuneracaoCollection->getCodEvento()->getDescricao();
                },
                'label' => 'label.configuracaoRais.horaExtra',
            ])
            ->add('eventoHorasExtrasCollection', null, [
                'associated_property' => function ($eventoHorasExtrasCollection) {
                    return $eventoHorasExtrasCollection->getCodEvento()->getDescricao();
                },
                'label' => 'label.configuracaoRais.horaExtra',
            ])
        ;
    }

    private function saveRelationships($object, $form)
    {
        # Adiciona eventoComposicaoRemuneracao a Collection em ConfiguracaoRais
        $eventosCR = $form->get('eventoComposicaoRemuneracao')->getData();

        foreach ($eventosCR as $evento) {
            $eventoComposicaoRemuneracao = new Ima\EventoComposicaoRemuneracao();
            $eventoComposicaoRemuneracao->setCodEvento($evento);

            $object->addEventoComposicaoRemuneracaoCollection($eventoComposicaoRemuneracao);
        }

        # Adiciona eventoComposicaoRemuneracao a Collection em ConfiguracaoRais
        $eventosHE = $form->get('eventoHorasExtras')->getData();

        foreach ($eventosHE as $evento) {
            $eventoHorasExtras = new Ima\EventoHorasExtras();
            $eventoHorasExtras->setCodEvento($evento);

            $object->addEventoHorasExtrasCollection($eventoHorasExtras);
        }
    }

    public function prePersist($object)
    {
        $this->saveRelationships($object, $this->getForm());
    }

    public function preUpdate($object)
    {
        $id = $this->getAdminRequestId();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $configRais = $em->getRepository($this->getClass())->findOneByCodExercicio($id);

        $eventosCR = $em->getRepository('CoreBundle:Ima\EventoComposicaoRemuneracao')
            ->findByCodExercicio($id);

        foreach ($eventosCR as $evento) {
            $em->remove($evento);
        }

        $eventosHE = $em->getRepository('CoreBundle:Ima\eventoHorasExtras')
            ->findByCodExercicio($id);

        foreach ($eventosHE as $evento) {
            $em->remove($evento);
        }

        $em->flush();

        $this->saveRelationships($object, $this->getForm());
    }
}
