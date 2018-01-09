<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\SwAndamentoPadrao;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Model\Organograma\OrgaoModel;

class SwAndamentoPadraoAdmin extends AbstractOrganogramaSonata
{
    protected $baseRouteName = 'urbem_administrativo_protocolo_tramite_processo';

    protected $baseRoutePattern = 'administrativo/protocolo/tramite-processo';

    protected $includeJs = array(
        '/administrativo/javascripts/administracao/estruturaDinamicaOrganograma.js',
        '/administrativo/javascripts/administracao/swAndamentoPadrao.js'
    );

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'ordem',
    );

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_assunto', 'consultar-assunto', array(), array(), array(), '', array(), array('POST'));
    }

    public function postRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $removeOrdem = $object->getOrdem();
        $parameters = [
            'codClassificacao' => $object->getFkSwAssunto()->getFkSwClassificacao()->getCodClassificacao(),
            'codAssunto' => $object->getFkSwAssunto()->getCodAssunto()
        ];
        $swAndamentoPadroes = $em->getRepository('CoreBundle:SwAndamentoPadrao')->findBy($parameters, array('ordem' => 'ASC'));
        foreach ($swAndamentoPadroes as $swAndamentoPadrao) {
            if ($swAndamentoPadrao->getOrdem() > $removeOrdem) {
                $newOrdem = $swAndamentoPadrao->getOrdem() - 1;
                $swAndamentoPadrao->setOrdem($newOrdem);
                $em->persist($swAndamentoPadrao);
                $em->flush();
            }
        }
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        if ($object->getNumDia() < 0) {
            $error = "O número de dias não pode ser negativo";
            $this->validarAdmin($errorElement, $error, 'numDia');
        }
    }

    public function validarAdmin(ErrorElement $errorElement, $error, $campo)
    {
        $errorElement->with($campo)->addViolation($error)->end();
        $this->getRequest()->getSession()->getFlashBag()->add("error", $error);
    }

    public function preUpdate($swAndamentoPadrao)
    {
        /**
         * @var SwAndamentoPadrao $swAndamentoPadrao
         */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formData = (object) $this->getFormPost();
        $orgao = $this->getOrgaoSelected();

        $ordem = $formData->ordem;

        if ($swAndamentoPadrao->getOrdem() != $ordem) {
            $parameters = [
                'codClassificacao' => $swAndamentoPadrao->getFkSwAssunto()->getFkSwClassificacao()->getCodClassificacao(),
                'codAssunto' => $swAndamentoPadrao->getFkSwAssunto()->getCodAssunto(),
                'ordem' => $ordem
            ];
            $swAndamentoPadraoEdit = $em->getRepository('CoreBundle:SwAndamentoPadrao')->findOneBy($parameters);
            $swAndamentoPadraoEdit->setOrdem($swAndamentoPadrao->getOrdem());
            $em->persist($swAndamentoPadraoEdit);
            $em->flush();
            $swAndamentoPadrao->setOrdem($ordem);
        }

        // orgao
        $swAndamentoPadrao->setFkOrganogramaOrgao($orgao->getFkOrganogramaOrgao());

        // Assunto
        $swAssunto = $em->getRepository('CoreBundle:SwAssunto')
            ->findOneBy([
                'codAssunto' => $formData->fakeAssunto,
                'codClassificacao' => $formData->fkSwClassificacao
            ]);
        $swAndamentoPadrao->setFkSwAssunto($swAssunto);
    }

    public function prePersist($swAndamentoPadrao)
    {
        /**
         * @var SwAndamentoPadrao $swAndamentoPadrao
         */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formData = (object) $this->getFormPost();
        $orgao = $this->getOrgaoSelected();

        // orgao
        $swAndamentoPadrao->setFkOrganogramaOrgao($orgao->getFkOrganogramaOrgao());

        // Assunto
        $swAssunto = $em->getRepository('CoreBundle:SwAssunto')
            ->findOneBy([
                'codAssunto' => $formData->codAssunto,
                'codClassificacao' => $formData->fkSwClassificacao
            ]);
        $swAndamentoPadrao->setFkSwAssunto($swAssunto);

        /**
         * @todo: Identificar de onde vem o número de passagens, nãoo existe campo de entrada e essa informaçõo também não é apresentada para o usuário
         */
        $swAndamentoPadrao->setNumPassagens(1);

        $ordem = 1;
        $andamentoPadrao = $em->getRepository('CoreBundle:SwAndamentoPadrao')->findOneBy(
            [
                'codAssunto' => $formData->codAssunto,
                'codClassificacao' => $formData->fkSwClassificacao
            ],
            [
                'ordem' => 'DESC'
            ]
        );
        if (!empty($andamentoPadrao)) {
            $ordem = $andamentoPadrao->getOrdem() + 1;
        }
        // Ordem
        $swAndamentoPadrao->setOrdem($ordem);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codClassificacao',
                'doctrine_orm_callback',
                [
                    'label' => 'label.tramiteProcesso.codClassificacao',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'entity',
                [
                    'class' => 'CoreBundle:SwClassificacao',
                    'choice_label' => 'nomClassificacao',
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('c');
                        $qb->orderBy('c.nomClassificacao', 'ASC');
                        return $qb;
                    }
                ]
            )
            ->add(
                'codAssunto',
                'doctrine_orm_callback',
                [
                    'label' => 'label.tramiteProcesso.codAssunto',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'entity',
                [
                    'class' => 'CoreBundle:SwAssunto',
                    'choice_label' => 'nomAssunto',
                    'choice_value' => 'codAssunto',
                    'attr' => [
                        'required' => true
                    ]
                ]
            )
        ;
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        if (!count($value['value'])) {
            return;
        }

        if ($filter['codClassificacao']['value'] != "" && $filter['codAssunto']['value'] != "") {
            $queryBuilder->resetDQLPart('join');
            $queryBuilder->join("{$alias}.fkSwAssunto", "a");
            $queryBuilder->andWhere("a.codClassificacao = :codClassificacao");
            $queryBuilder->andWhere("a.codAssunto = :codAssunto");
            $queryBuilder->setParameters([
                'codClassificacao' => $filter['codClassificacao']['value'],
                'codAssunto' => $filter['codAssunto']['value']
            ]);
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('ordem')
            ->add('fkOrganogramaOrgao.codigoComposto', null, ['label' => 'label.codigo'])
            ->add('codOrgao.descricao', null, ['label' => 'label.descricao'])
            ->add('numDia', null, ['label' => 'label.tramiteProcesso.numDia'])
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

        $em = $this->modelManager->getEntityManager($this->getClass());

        $orgao = null;
        $fkSwClassificacao = null;
        $fkSwAssunto = null;
        $disable = false;
        if ($this->id($this->getSubject())) {
            $swAndamentoPadrao = $this->getSubject();

            $disable = true;
            $fkSwClassificacao = $swAndamentoPadrao->getFkSwAssunto()->getFkSwClassificacao();
            $fkSwAssunto = $swAndamentoPadrao->getFkSwAssunto();

            $parameters = [
                'codClassificacao' => $swAndamentoPadrao->getCodClassificacao(),
                'codAssunto' => $swAndamentoPadrao->getCodAssunto()
            ];

            $swAndamentoPadraoAll = $em->getRepository('CoreBundle:SwAndamentoPadrao')->findBy($parameters, array('ordem' => 'ASC'));
            foreach ($swAndamentoPadraoAll as $swAP) {
                $ordem[$swAP->getOrdem()] = $swAP->getOrdem();
            }

            $fieldOptions['formInfo']['data'] = 1;
            $fieldOptions['codAssunto']['data'] = $swAndamentoPadrao->getCodAssunto();

            // Monta JS com base no orgao cadastrado para este tramite
            $this->executeScriptLoadData(
                $this->getOrgaoNivelByCodOrgao($this->getSubject()->getCodOrgao())
            );

            // Adiciona codigo do assunto ao JS
            $this->setScriptDynamicBlock(
                $this->getScriptDynamicBlock() . "window.tramite_processo_assunto_selecionado = {$swAndamentoPadrao->getCodAssunto()};"
            );
        }

        $formMapper->with('Assuntos de processo');
        $formMapper->add(
            'fkSwClassificacao',
            'entity',
            [
                'class' => 'CoreBundle:SwClassificacao',
                'label' => 'label.tramiteProcesso.codClassificacao',
                'choice_label' => 'nomClassificacao',
                'placeholder' => 'label.selecione',
                'required' => true,
                'mapped' => false,
                'disabled' => $disable,
                'data' => $fkSwClassificacao,
                'attr' => ['class' => 'select2-parameters '],
                'query_builder' => function ($em) {
                    $qb = $em->createQueryBuilder('c');
                    $qb->orderBy('c.nomClassificacao', 'ASC');
                    return $qb;
                }
            ]
        );
        $formMapper->add(
            'fakeAssunto',
            'choice',
            [
                'label' => 'label.tramiteProcesso.codAssunto',
                'placeholder' => 'label.selecione',
                'required' => true,
                'mapped' => false,
                'disabled' => $disable,
                'data' => $fkSwAssunto,
                'attr' => ['class' => 'select2-parameters '],
                'choices' => $this->preSetPostToChoice("fakeAssunto", []),
            ]
        );
        $formMapper->add(
            'codAssunto',
            'hidden',
            [
                'mapped' => false,
            ]
        );
        $formMapper->end();

        $formMapper->with("label.tramiteProcesso.dadosTramite");
        // Monta Organograma
        $this->createFormOrganograma($formMapper, $exibeOrganogramaAtivo = false);

        $formMapper->add(
            'descricao',
            null,
            [
                'label' => 'label.descricao'
            ]
        );
        $formMapper->add(
            'numDia',
            null,
            [
                'label' => 'label.tramiteProcesso.numDia',
                'attr' => ['min'=>'0']
            ]
        );

        if (isset($ordem)) {
            $formMapper->add('ordem', 'choice', [
                'choices' => $ordem,
                'data' => $swAndamentoPadrao->getOrdem(),
                'mapped' => false,
                'required' => true,
                'attr' => ['class' => 'select2-parameters ']
            ]);
        }

        $formMapper->add(
            'formInfo',
            'hidden',
            [
                'mapped' => false,
                'data' => 0
            ]
        );
        $formMapper->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        // Lista de orgaos de acordo com escolha e seu ni­vel
        $orgaoList = $this->showOrgaoByCurrentOrganograma(
            $this->getSubject()->getFkOrganogramaOrgao()->getFkOrganogramaOrgaoNiveis()->last()
        );

        $showMapper
            ->with('label.tramiteProcesso.modulo')
            ->add(
                'fkSwAssunto.fkSwClassificacao.nomClassificacao',
                null,
                [
                    'label' => 'label.tramiteProcesso.codClassificacao'
                ]
            )
            ->add(
                'fkSwAssunto.nomAssunto',
                null,
                [
                    'label' => 'label.tramiteProcesso.codAssunto'
                ]
            )
            ->add('ordem')
            ->add(
                'codOrgao',
                'string',
                [
                    'label' => 'Dados para trâmite',
                    'template' => 'AdministrativoBundle:Administracao/Usuario:organograma.html.twig',
                    'data' => $orgaoList
                ]
            )
            ->add(
                'codOrgao.descricao',
                null,
                [
                    'label' => 'label.descricao'
                ]
            )
            ->add(
                'numDia',
                null,
                [
                    'label' => 'label.tramiteProcesso.numDia'
                ]
            )
            ->end()
        ;
    }
}
