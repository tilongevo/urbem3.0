<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Cse\Profissao;
use Urbem\CoreBundle\Entity\Economico\AliquotaAtividade;
use Urbem\CoreBundle\Entity\Economico\Atividade;
use Urbem\CoreBundle\Entity\Economico\AtividadeProfissao;
use Urbem\CoreBundle\Entity\Economico\Elemento;
use Urbem\CoreBundle\Entity\Economico\ElementoAtividade;
use Urbem\CoreBundle\Entity\Economico\NivelAtividade;
use Urbem\CoreBundle\Entity\Economico\NivelServicoValor;
use Urbem\CoreBundle\Entity\Economico\Servico;
use Urbem\CoreBundle\Entity\Economico\ServicoAtividade;
use Urbem\CoreBundle\Entity\Economico\VigenciaServico;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class AtividadeAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_atividade_economica';
    protected $baseRoutePattern = 'tributario/cadastro-economico/atividade-economica';
    protected $includeJs = ['/tributario/javascripts/economico/atividade.js'];

    /**
     * @param AtividadeModalidadeLancamento|null $object
     */
    public function prePersist($object)
    {
        $this->populateObject($object);
    }

    /**
     * @param AtividadeModalidadeLancamento|null $object
     */
    public function preUpdate($object)
    {
        $this->populateObject($object);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        if ($object->getCodAtividade()) {
            return;
        }

        $atividade = $em->getRepository(Atividade::class)
            ->findOneBy(
                [
                    'codNivel' => $this->getForm()->get('fkEconomicoNivelAtividade')->getData()->getCodNivel(),
                    'codEstrutural' => $this->getForm()->get('codEstrutural')->getData(),
                ]
            );

        if ($atividade) {
            $error = $this->getTranslator()->trans('label.economicoAtividade.erroCodigo');
            $errorElement->with('codEstrutural')->addViolation($error)->end();

            return;
        }

        $atividade = $em->getRepository(Atividade::class)
            ->findOneBy(
                [
                    'codNivel' => $this->getForm()->get('fkEconomicoNivelAtividade')->getData()->getCodNivel(),
                    'nomAtividade' => $this->getForm()->get('nomAtividade')->getData(),
                ]
            );

        if ($atividade) {
            $error = $this->getTranslator()->trans('label.economicoAtividade.erroNome');
            $errorElement->with('nomAtividade')->addViolation($error)->end();

            return;
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkEconomicoNivelAtividade',
                'doctrine_orm_callback',
                [
                    'label' => 'label.economicoAtividade.codNivel',
                    'callback' => function ($queryBuilder, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }

                        $filter = $this->getDataGrid()->getValues();

                        $queryBuilder
                            ->where('o.codNivel = :codNivel')
                            ->setParameter('codNivel', $filter['fkEconomicoNivelAtividade']['value']);
                    }
                ],
                'entity',
                [
                    'class' => NivelAtividade::class,
                    'choice_value' => 'codNivel',
                    'attr' => [
                        'class' => 'select2-parameters',
                    ],
                ]
            )
            ->add('codEstrutural', null, ['label' => 'label.economicoAtividade.codEstrutural'])
            ->add('nomAtividade', null, ['label' => 'label.economicoAtividade.nomAtividade']);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codEstrutural', null, ['label' => 'label.economicoAtividade.codEstrutural'])
            ->add('fkEconomicoNivelAtividade', null, ['label' => 'label.economicoAtividade.codNivel'])
            ->add('nomAtividade', null, ['label' => 'label.economicoAtividade.nomAtividade']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $atividade = $this->getSubject() ?: new Atividade();

        $fieldOptions = [];
        $fieldOptions['codAtividade'] = [
            'required' => false,
        ];

        $fieldOptions['fkEconomicoNivelAtividade'] = [
            'class' => NivelAtividade::class,
            'choice_value' => 'codNivel',
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.economicoAtividade.codNivel',
        ];

        $fieldOptions['atividade'] = [
            'class' => Atividade::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $codNivel = (int) $request->get('codNivel');
                $qb->andWhere('o.codNivel = :codNivel');
                $qb->setParameter('codNivel', --$codNivel);

                $qb->andWhere('(LOWER(o.codEstrutural) LIKE :term OR LOWER(o.nomAtividade) LIKE :term)');
                $qb->setParameter('term', sprintf('%%%s%%', $term));

                $qb->addOrderBy('o.codEstrutural', 'ASC');
                $qb->addOrderBy('o.nomAtividade', 'ASC');

                return $qb;
            },
            'json_choice_label' => function (Atividade $atividade) {
                return (string) sprintf('%s - %s', $atividade->getCodEstrutural(), $atividade->getNomAtividade());
            },
            'req_params' => [
                'codNivel' => 'varJsCodNivel',
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.economicoAtividade.atividade',
        ];

        $fieldOptions['atividadeSuperior'] = [
            'mapped' => false,
            'disabled' => true,
            'label' => 'label.economicoAtividade.nivelSuperior'
        ];

        $fieldOptions['codEstrutural'] = [
            'label' => 'label.economicoAtividade.codEstrutural'
        ];

        $fieldOptions['nomAtividade'] = [
            'label' => 'label.economicoAtividade.nomAtividade'
        ];

        $fieldOptions['aliquota'] = [
            'mapped' => false,
            'required' => true,
            'attr' => [
                'class' => 'js-aliquota '
            ],
            'label' => 'label.economicoAtividade.aliquota',
        ];

        $fieldOptions['profissao'] = [
            'class' => Profissao::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');

                $qb->orderBy('o.nomProfissao', 'ASC');

                return $qb;
            },
            'choice_label' => 'nomProfissao',
            'multiple' => true,
            'required' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.economicoAtividade.responsaveis',
        ];

        $fieldOptions['elemento'] = [
            'class' => Elemento::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');

                $qb->orderBy('o.nomElemento', 'ASC');

                return $qb;
            },
            'choice_label' => 'nomElemento',
            'multiple' => true,
            'required' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.economicoAtividade.elementos',
        ];

        $fieldOptions['vigenciaServico'] = [
            'class' => VigenciaServico::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');

                $qb->orderBy('o.dtInicio', 'ASC');

                return $qb;
            },
            'choice_label' => function (VigenciaServico $vigenciaServico) {
                return (string) $vigenciaServico->getDtInicio()->format('d/m/Y');
            },
            'required' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.economicoAtividade.vigenciaServico',
        ];

        $fieldOptions['servico'] = [
            'class' => Servico::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join('o.fkEconomicoNivelServicoValores', 'nsv');

                $qb->andWhere('nsv.codVigencia = :codVigenciaServico');
                $qb->setParameter(':codVigenciaServico', (int) $request->get('codVigenciaServico'));

                $qb->andWhere(sprintf('nsv.codNivel IN (SELECT MAX(nsvv.codNivel) FROM %s nsvv GROUP BY nsvv.codNivel)', NivelServicoValor::class));

                $qb->andWhere('(LOWER(o.codEstrutural) LIKE :term OR LOWER(o.nomServico) LIKE :term)');
                $qb->setParameter('term', sprintf('%%%s%%', $term));

                $qb->addOrderBy('o.codEstrutural', 'ASC');
                $qb->addOrderBy('o.nomServico', 'ASC');

                return $qb;
            },
            'json_choice_label' => function (Servico $servico) {
                return (string) sprintf('%s - %s', $servico->getCodEstrutural(), $servico->getNomServico());
            },
            'required' => false,
            'req_params' => [
                'codVigenciaServico' => 'varJsCodVigenciaServico',
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.economicoAtividade.servico',
        ];

        $fieldOptions['incluirServico'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/Atividade/incluir_servico.html.twig',
            'data' => [],
        ];

        $fieldOptions['listaServicos'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/Atividade/lista_servicos.html.twig',
            'data' => [
                'servicoAtividades' => $atividade->getFkEconomicoServicoAtividades(),
            ],
        ];

        $fieldOptions['ultimoCodNivel'] = [
            'mapped' => false,
            'required' => false,
            'data' => $this->getUltimoNivel()->getCodNivel(),
        ];

        $fieldOptions['mascaras'] = [
            'mapped' => false,
            'required' => false,
            'data' => json_encode($this->getMascaras()),
        ];

        if ($atividade->getCodAtividade()) {
            $fieldOptions['fkEconomicoNivelAtividade']['disabled'] = true;

            $fieldOptions['codEstrutural']['disabled'] = true;
            $fieldOptions['codEstrutural']['data'] = sprintf('%s - %s', $atividade->getCodEstrutural(), $atividade->getNomAtividade());

            $atividadeSuperior = $this->getAtividadeSuperior($atividade) ?: new Atividade();
            $fieldOptions['atividadeSuperior']['data'] = sprintf('%s - %s', $atividadeSuperior->getCodEstrutural(), $atividadeSuperior->getNomAtividade());

            $aliquota = $atividade->getFkEconomicoAliquotaAtividades()->last();
            $fieldOptions['aliquota']['data'] = $aliquota ? str_replace('.', ',', $aliquota->getValor()) : null;

            $profissoes = [];
            foreach ($atividade->getFkEconomicoAtividadeProfissoes() as $atividadeProfissao) {
                $profissoes[] = $atividadeProfissao->getFkCseProfissao();
            }

            $fieldOptions['profissao']['data'] = $profissoes;

            $elementos = [];
            foreach ($atividade->getFkEconomicoElementoAtividades() as $elementoAtividade) {
                $elementos[] = $elementoAtividade->getFkEconomicoElemento();
            }

            $fieldOptions['elemento']['data'] = $elementos;
        }

        $formMapper
            ->with('label.economicoAtividade.cabecalhoDadosNivel')
                ->add('codAtividade', 'hidden', $fieldOptions['codAtividade'])
                ->add('fkEconomicoNivelAtividade', 'entity', $fieldOptions['fkEconomicoNivelAtividade'])
                ->add('atividade', 'autocomplete', $fieldOptions['atividade'])
                ->add('atividadeSuperior', 'text', $fieldOptions['atividadeSuperior'])
                ->add('codEstrutural', null, $fieldOptions['codEstrutural'])
                ->add('nomAtividade', null, $fieldOptions['nomAtividade'])
                ->add('aliquota', 'text', $fieldOptions['aliquota'])
            ->end()
            ->with('label.economicoAtividade.cabecalhoResponsaveisTecnicos')
                ->add('profissao', 'entity', $fieldOptions['profissao'])
            ->end()
            ->with('label.economicoAtividade.cabecalhoElementosBaseCalculo')
                ->add('elemento', 'entity', $fieldOptions['elemento'])
            ->end()
            ->with('label.economicoAtividade.cabecalhoServicos')
                ->add('vigenciaServico', 'entity', $fieldOptions['vigenciaServico'])
                ->add('servico', 'autocomplete', $fieldOptions['servico'])
                ->add('incluirServico', 'customField', $fieldOptions['incluirServico'])
            ->end()
            ->with('label.economicoAtividade.cabecalhoListaServicos')
                ->add('listaServicos', 'customField', $fieldOptions['listaServicos'])
                ->add('ultimoCodNivel', 'hidden', $fieldOptions['ultimoCodNivel'])
                ->add('mascaras', 'hidden', $fieldOptions['mascaras'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('fkEconomicoNivelAtividade', null, ['label' => 'label.economicoAtividade.codNivel'])
            ->add('codEstrutural', null, ['label' => 'label.economicoAtividade.codEstrutural'])
            ->add('nomAtividade', null, ['label' => 'label.economicoAtividade.nomAtividade']);
    }

    /**
     * @return NivelAtividade
     */
    protected function getUltimoNivel()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        return $em->getRepository(NivelAtividade::class)->findOneBy([], ['codNivel' => 'DESC']) ?: new NivelAtividade();
    }

    /**
     * @param Atividade $atividade
     * @return Atividade|null
     */
    protected function getAtividadeSuperior(Atividade $atividade)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        if ($atividade->getCodNivel() == 1) {
            return;
        }

        $qb = $em->getRepository(Atividade::class)->createQueryBuilder('o');

        $atividadeCodEstrutural = explode('.', $atividade->getCodEstrutural());

        $codEstrutural = [];
        foreach ((array) $em->getRepository(NivelAtividade::class)->findBy([], ['codNivel' => 'ASC']) as $nivelAtividade) {
            if ($nivelAtividade->getCodNivel() >= $atividade->getCodNivel()) {
                $codEstrutural[] = str_repeat('0', strlen($nivelAtividade->getMascara()));

                continue;
            }

            $codEstrutural[] = array_shift($atividadeCodEstrutural);
        }

        $qb->andWhere('o.codEstrutural = :codEstrutural');
        $qb->setParameter('codEstrutural', implode('.', $codEstrutural));

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @return array
     */
    protected function getMascaras()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(NivelAtividade::class)->createQueryBuilder('o');

        $qb->select('o.codNivel, o.mascara');

        $results = $qb->getQuery()->getScalarResult();

        return array_combine(array_column($results, 'codNivel'), array_column($results, 'mascara'));
    }

    /**
    * @param Atividade $object
    */
    protected function populateObject(Atividade $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $request = $this->getRequest();

        $form = $this->getForm();

        foreach ($object->getFkEconomicoAtividadeProfissoes() as $atividadeProfissao) {
            $object->removeFkEconomicoAtividadeProfissoes($atividadeProfissao);
        }

        foreach ($object->getFkEconomicoElementoAtividades() as $elementoAtividade) {
            $object->removeFkEconomicoElementoAtividades($elementoAtividade);
        }

        foreach ($object->getFkEconomicoServicoAtividades() as $servicoAtividade) {
            $object->removeFkEconomicoServicoAtividades($servicoAtividade);
        }

        $em->persist($object);
        $em->flush();

        if ($object->getCodNivel() != $this->getUltimoNivel()->getCodNivel()) {
            return;
        }

        $aliquota = str_replace(',', '.', str_replace('.', '', $form->get('aliquota')->getData()));
        $aliquotaAtividade = new AliquotaAtividade();
        $aliquotaAtividade->setValor($aliquota);
        $aliquotaAtividade->setFkEconomicoAtividade($object);
        $object->addFkEconomicoAliquotaAtividades($aliquotaAtividade);

        foreach ($form->get('profissao')->getData() as $profissao) {
            $atividadeProfissao = new AtividadeProfissao();
            $atividadeProfissao->setFkCseProfissao($profissao);
            $atividadeProfissao->setFkEconomicoAtividade($object);
            $object->addFkEconomicoAtividadeProfissoes($atividadeProfissao);
        }

        foreach ($form->get('elemento')->getData() as $elemento) {
            $elementoAtividade = new ElementoAtividade();
            $elementoAtividade->setFkEconomicoElemento($elemento);
            $elementoAtividade->setFkEconomicoAtividade($object);
            $object->addFkEconomicoElementoAtividades($elementoAtividade);
        }

        foreach ((array) $request->get('servicos') as $servico) {
            $servico = $em->getRepository(Servico::class)->findOneByCodServico($servico['codServico']);
            $servicoAtividade = new ServicoAtividade();
            $servicoAtividade->setFkEconomicoServico($servico);
            $servicoAtividade->setFkEconomicoAtividade($object);
            $object->addFkEconomicoServicoAtividades($servicoAtividade);
        }
    }
}
