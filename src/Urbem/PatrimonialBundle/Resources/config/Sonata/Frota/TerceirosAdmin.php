<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;

use Urbem\CoreBundle\Entity\Frota;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\Organograma;
use Urbem\CoreBundle\Entity\Patrimonio;

use Urbem\CoreBundle\Model\Patrimonial\Frota\TerceirosModel;

/**
 * Class TerceirosAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Frota
 * @extends Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata
 */
class TerceirosAdmin extends AbstractOrganogramaSonata
{
    const NIVEL_UM = 1;
    const NIVEL_DOIS = 2;
    const NIVEL_TRES = 3;
    protected $baseRouteName = 'urbem_patrimonial_frota_veiculo_terceiro';
    protected $baseRoutePattern = 'patrimonial/frota/veiculo-terceiro';
    protected $model = Model\Patrimonial\Frota\TerceirosModel::class;
    protected $includeJs = [
        '/administrativo/javascripts/organograma/estruturaDinamicaOrganograma.js',
        '/patrimonial/javascripts/frota/veiculo.js',
    ];

    /**
     * @param Frota\Terceiros $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $id = $object->getCodVeiculo();
            /** @var ORM\EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            // Set VeiculoPropriedade
            $veiculo = $em
                ->getRepository(Frota\Veiculo::class)
                ->find($object->getCodVeiculo());

            $veiculoPropriedade = new Frota\VeiculoPropriedade();
            $veiculoPropriedade->setFkFrotaVeiculo($veiculo);
            $veiculoPropriedade->setProprio(false);

            $em->persist($veiculoPropriedade);
            $object->setFkFrotaVeiculoPropriedade($veiculoPropriedade);

            // Set Proprietário
            $swCgmModel = new Model\SwCgmModel($em);
            $swCgm = $swCgmModel->findOneByNumcgm($this->getForm()->get('codProprietario')->getData());
            $object->setFkSwCgm($swCgm);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/frota/veiculo-terceiro/create?id={$object->getCodVeiculo()}");
        }
    }

    /**
     * @param Frota\Terceiros $object
     */
    public function postPersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
            $this->redirect($object);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/frota/veiculo-terceiro/create?id={$object->getCodVeiculo()}");
        }
    }

    /**
     * @param Frota\Terceiros $object
     * @param Form $form
     */
    public function saveRelationships($object, $form)
    {
        $id = $object->getCodVeiculo();

        /** @var ORM\EntityManager $em */
        $em = $this->modelManager
            ->getEntityManager($this->getClass());

        // Salva TerceirosHistorico
        $orgaoNivel = $this->getOrgaoSelected();
        if (!empty($orgaoNivel) && $form->get('codLocal')->getData()) {
            $codLocal = $form->get('codLocal')->getData();

            $TerceirosHistoricos = $em
                ->getRepository('CoreBundle:Frota\TerceirosHistorico')
                ->findBy(array('codVeiculo' => $id), array('timestamp' => 'DESC'), 1);

            if ((count($TerceirosHistoricos) > 0 && ($TerceirosHistoricos[0]->getCodOrgao() != $orgaoNivel->getCodOrgao()
                        || $TerceirosHistoricos[0]->getCodLocal() != $codLocal->getCodLocal()))
                || (count($TerceirosHistoricos) == 0)
            ) {
                $TerceirosHistoricoModel = new TerceirosModel($em);
                $TerceirosHistorico = new Frota\TerceirosHistorico();
                $TerceirosHistorico->setFkFrotaTerceiros($object);
                $TerceirosHistorico->setFkOrganogramaOrgao($orgaoNivel->getFkOrganogramaOrgao());
                $TerceirosHistorico->setFkOrganogramaLocal($codLocal);
                $TerceirosHistoricoModel->save($TerceirosHistorico);

                $em->flush();
            }
        }

        // Salva VeiculoTerceirosResponsavel
        if ($form->get('codResponsavel')->getData() && $form->get('dtInicio')->getData()) {
            $codResponsavel = $form->get('codResponsavel')->getData();
            $dtInicio = $form->get('dtInicio')->getData();

            $VeiculoTerceirosResponsavels = $em
                ->getRepository('CoreBundle:Frota\VeiculoTerceirosResponsavel')
                ->findBy(array('codVeiculo' => $id), array('timestamp' => 'DESC'), 1);

            if ((count($VeiculoTerceirosResponsavels) > 0
                    && ($VeiculoTerceirosResponsavels[0]->getNumcgm() != $codResponsavel
                        || $VeiculoTerceirosResponsavels[0]->getDtInicio() != $dtInicio))
                || (count($VeiculoTerceirosResponsavels) == 0)
            ) {
                $swCgmModel = new Model\SwCgmModel($em);
                $swCgm = $swCgmModel->findOneByNumcgm($codResponsavel);

                $VeiculoTerceirosResponsavelModel = new TerceirosModel($em);
                $VeiculoTerceirosResponsavel = new Frota\VeiculoTerceirosResponsavel();
                $VeiculoTerceirosResponsavel->setFkFrotaVeiculo($object->getFkFrotaVeiculoPropriedade()->getFkFrotaVeiculo());
                $VeiculoTerceirosResponsavel->setFkSwCgm($swCgm);
                $VeiculoTerceirosResponsavel->setDtInicio($dtInicio);
                $VeiculoTerceirosResponsavelModel->save($VeiculoTerceirosResponsavel);

                $em->flush();
            }
        }

        // Salva VeiculoUniorcam
        if ($form->get('exercicio')->getData() && $form->get('codEntidade')->getData()
            && $form->get('numOrgao')->getData() && $form->get('numUnidade')->getData()
        ) {
            $exercicio = $form->get('exercicio')->getData();
            $codEntidade = $form->get('codEntidade')->getData();
            $numOrgao = $form->get('numOrgao')->getData();
            $numUnidade = $form->get('numUnidade')->getData();

            $VeiculoUniorcams = $em
                ->getRepository('CoreBundle:Patrimonio\VeiculoUniorcam')
                ->findBy(array('codVeiculo' => $id));

            if ((count($VeiculoUniorcams) > 0
                    && (end($VeiculoUniorcams)->getExercicio() != $exercicio
                        || end($VeiculoUniorcams)->getCodEntidade() != $codEntidade->getCodEntidade()
                        || end($VeiculoUniorcams)->getNumOrgao() != $numOrgao->getNumOrgao()
                        || end($VeiculoUniorcams)->getNumUnidade() != $numUnidade->getNumUnidade()))
                || (count($VeiculoUniorcams) == 0)
            ) {
                $VeiculoUniorcamModel = new TerceirosModel($em);
                $unidadeModel = new Model\Orcamento\UnidadeModel($em);
                $unidade = $unidadeModel->getOneByUnidadeOrgaoExercicio($numUnidade->getNumUnidade(), $numOrgao->getNumOrgao(), $exercicio);

                $VeiculoUniorcam = new Patrimonio\VeiculoUniorcam();
                $VeiculoUniorcam->setFkFrotaVeiculo($object->getFkFrotaVeiculoPropriedade()->getFkFrotaVeiculo());
                $VeiculoUniorcam->setFkOrcamentoEntidade($codEntidade);
                $VeiculoUniorcam->setFkOrcamentoUnidade($unidade);
                $VeiculoUniorcamModel->save($VeiculoUniorcam);

                $em->flush();
            }
        }
    }

    /**
     * @param Frota\Terceiros $object
     */
    public function redirect($object)
    {
        $this->forceRedirect("/patrimonial/frota/veiculo/{$this->getObjectKey($object->getFkFrotaVeiculoPropriedade()->getFkFrotaVeiculo())}/show");
    }

    /**
     * @param Frota\Terceiros $object
     */
    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $id = $object->getCodVeiculo();
            /** @var ORM\EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            $veiculoUniorcam = $em->getRepository(Patrimonio\VeiculoUniorcam::class)->findOneBy([
                'codVeiculo' => $object->getCodVeiculo()
            ]);

            if ($veiculoUniorcam) {
                $em->remove($veiculoUniorcam);
            }

            $terceiros = new Frota\Terceiros();

            // Set VeiculoPropriedade
            $veiculo = $em
                ->getRepository(Frota\Veiculo::class)
                ->find($object->getCodVeiculo());

            $veiculoPropriedade = new Frota\VeiculoPropriedade();
            $veiculoPropriedade->setFkFrotaVeiculo($veiculo);
            $veiculoPropriedade->setProprio(false);

            $em->persist($veiculoPropriedade);
            $terceiros->setFkFrotaVeiculoPropriedade($veiculoPropriedade);

            // Set Proprietário
            if (strpos($this->getForm()->get('codProprietario')->getData(), '-')) {
                $proprietario = explode(' - ', $this->getForm()->get('codProprietario')->getData());
                $proprietario = $proprietario[0];
            } else {
                $proprietario = $this->getForm()->get('codProprietario')->getData();
            }

            $swCgmModel = new Model\SwCgmModel($em);
            $swCgm = $swCgmModel->findOneByNumcgm($proprietario);
            $terceiros->setFkSwCgm($swCgm);

            $em->persist($terceiros);
            $em->flush();

            $this->saveRelationships($terceiros, $this->getForm());
            $this->redirect($terceiros);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_EDIT_DATA);
            $this->forceRedirect("/patrimonial/frota/veiculo-terceiro/{$this->getAdminRequestId()}/edit");
        }
    }

    /**
     * @param Frota\Proprio $object
     * @return null
     */
    public function preRemove($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            // Remove VeiculoPropriedade
            /** @var ORM\EntityManager $em */
            $em = $this->modelManager->getEntityManager(Frota\VeiculoPropriedade::class);
            $veiculoPropriedade = $em->getRepository(Frota\VeiculoPropriedade::class)->findOneBy([
                'codVeiculo' => $object->getCodVeiculo()
            ]);

            if ($veiculoPropriedade) {
                $em->remove($veiculoPropriedade);
            }

            $veiculoUniorcam = $em->getRepository(Patrimonio\VeiculoUniorcam::class)->findOneBy([
                'codVeiculo' => $object->getCodVeiculo()
            ]);

            if ($veiculoUniorcam) {
                $em->remove($veiculoUniorcam);
            }

            $veiculoTerceirosResponsavel = $em->getRepository(Frota\VeiculoTerceirosResponsavel::class)->findOneBy([
                'codVeiculo' => $object->getCodVeiculo()
            ]);

            if ($veiculoTerceirosResponsavel) {
                $em->remove($veiculoTerceirosResponsavel);
            }
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_REMOVE_DATA);
            $this->forceRedirect("/patrimonial/frota/veiculo-proprio/{$object->getCodVeiculo()}~{$object->getTimestamp()}/delete");
        }
    }

    /**
     * @param Frota\Terceiros $object
     */
    public function postRemove($object)
    {
        $this->redirect($object);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codVeiculo')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codVeiculo')
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
        $exercicio = $this->getExercicio();

        $route = $this->getRequest()->get('_sonata_name');
        if (strpos($route, 'edit')) {
            list($codVeiculo, $timestamp) = explode('~', $id);
        } else {
            $codVeiculo = $id;
        }

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codVeiculo = $formData['codVeiculo'];
        }

        /**
         * @var ORM\EntityManager $entityManager
         */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $organogramaModel = new Model\Organograma\OrganogramaModel($entityManager);
        $organoAtivo = $organogramaModel->getOrganogramaVigentePorTimestamp();

        $veiculo = null;
        if (!is_null($route)) {
            /**
             * @var Frota\Veiculo $veiculo
             */
            $veiculo = $entityManager
                ->getRepository(Frota\Veiculo::class)
                ->find($codVeiculo);
        }

        $fieldOptions['veiculo'] = [
            'class' => 'CoreBundle:Frota\Veiculo',
            'choice_label' => function (Frota\Veiculo $veiculo) {
                return $veiculo->getCodVeiculo().' - '.
                    $veiculo->getPlaca().' - '.
                    $veiculo->getFkFrotaMarca()->getNomMarca().' - '.
                    $veiculo->getFkFrotaModelo()->getNomModelo();
            },
            'label' => 'label.veiculoCessao.codVeiculo',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'data' => is_null($veiculo) ? null : $veiculo,
            'mapped' => false,
            'disabled' => true,
        ];

        $fieldOptions['codVeiculo'] = [
            'data' => is_null($veiculo) ? null : $veiculo->getCodVeiculo()
        ];

        $fieldOptions['exercicio'] = [
            'label' => 'label.veiculoTerceiro.exercicio',
            'mapped' => false,
            'required' => false,
            'data' => $this->getExercicio(),
            'attr' => array(
                'readonly' => 'readonly'
            ),
        ];

        $fieldOptions['codEntidade'] = [
            'class' => Orcamento\Entidade::class,
            'choice_label' => function (Orcamento\Entidade $codEntidade) {
                return $codEntidade->getCodEntidade().' - '.
                    $codEntidade->getFkSwCgm()->getNomCgm();
            },
            'label' => 'label.veiculoTerceiro.codEntidade',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'query_builder' => function (ORM\EntityRepository $em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'required' => false,
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['numOrgao'] = [
            'class' => Orcamento\Orgao::class,
            'choice_label' => function (Orcamento\Orgao $numOrgao) {
                return $numOrgao->getNumOrgao().' - '.
                    $numOrgao->getNomOrgao();
            },
            'label' => 'label.veiculoTerceiro.numOrgao',
            'mapped' => false,
            'required' => false,
            'query_builder' => function (ORM\EntityRepository $em) use ($exercicio) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.exercicio = :exercicio');
                $qb->setParameter('exercicio', $exercicio);
                return $qb;
            },
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['numUnidade'] = [
            'class' => Orcamento\Unidade::class,
            'choice_label' => function (Orcamento\Unidade $numUnidade) {
                return $numUnidade->getNumUnidade().' - '.
                    $numUnidade->getNomUnidade();
            },
            'label' => 'label.veiculoTerceiro.numUnidade',
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['codProprietario'] = [
            'label' => 'label.veiculoTerceiro.codProprietario',
            'multiple' => false,
            'mapped' => false,
            'required' => false,
            'route' => ['name' => 'carrega_sw_cgm'],
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['codLocal'] = [
            'class' => Organograma\Local::class,
            'choice_label' => 'descricao',
            'label' => 'label.veiculoTerceiro.codLocal',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['codResponsavel'] = [
            'label' => 'label.veiculoTerceiro.codResponsavel',
            'multiple' => false,
            'mapped' => false,
            'required' => true,
            'route' => ['name' => 'carrega_sw_cgm'],
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['dtInicio'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.veiculoTerceiro.dtInicio',
            'mapped' => false
        ];

        if ($this->id($this->getSubject())) {
            /** @var ORM\EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            // Processa TerceirosHistorico
            $terceirosHistoricos = $em
                ->getRepository('CoreBundle:Frota\TerceirosHistorico')
                ->findBy(array('codVeiculo' => $codVeiculo), array('timestamp' => 'DESC'), 1);
            if (count($terceirosHistoricos) > 0) {
                $terceirosHistoricos = $terceirosHistoricos[0];
                $fieldOptions['codLocal']['data'] = $terceirosHistoricos->getFkOrganogramaLocal();

                // Monta JS com base no órgão cadastrado para este usuário
                $this->executeScriptLoadData(
                    $this->getOrgaoNivelByCodOrgao($terceirosHistoricos->getCodOrgao())
                );
            }

            // Processa VeiculoTerceirosResponsavel
            $VeiculoTerceirosResponsavels = $em
                ->getRepository('CoreBundle:Frota\VeiculoTerceirosResponsavel')
                ->findBy(array('codVeiculo' => $codVeiculo), array('timestamp' => 'DESC'), 1);
            if (count($VeiculoTerceirosResponsavels) > 0) {
                $VeiculoTerceirosResponsavels = $VeiculoTerceirosResponsavels[0];
                $fieldOptions['codResponsavel']['data'] = $VeiculoTerceirosResponsavels->getFkSwCgm();
                $fieldOptions['dtInicio']['data'] = $VeiculoTerceirosResponsavels->getDtInicio();
            }

            // Processa VeiculoUniorcam
            $VeiculoUniorcams = $em
                ->getRepository('CoreBundle:Patrimonio\VeiculoUniorcam')
                ->findBy(array('codVeiculo' => $codVeiculo));
            if (count($VeiculoUniorcams) > 0) {
                $VeiculoUniorcams = end($VeiculoUniorcams);
                $fieldOptions['exercicio']['data'] = $VeiculoUniorcams->getExercicio();
                $fieldOptions['codEntidade']['data'] = $VeiculoUniorcams->getFkOrcamentoEntidade();
                $fieldOptions['numOrgao']['data'] = $VeiculoUniorcams->getFkOrcamentoUnidade()->getFkOrcamentoOrgao();
                $fieldOptions['numUnidade']['data'] = $VeiculoUniorcams->getFkOrcamentoUnidade();
            }

            // Processa Proprietario
            $fieldOptions['codProprietario']['data'] = $this->getSubject()->getFkSwCgm();
        }

        $formMapper
            ->with('label.veiculoTerceiro.dadosVeiculo')
                ->add(
                    'veiculo',
                    'entity',
                    $fieldOptions['veiculo']
                )
                ->add(
                    'codVeiculo',
                    'hidden',
                    $fieldOptions['codVeiculo']
                )
                ->add(
                    'exercicio',
                    'text',
                    $fieldOptions['exercicio']
                )
                ->add(
                    'codEntidade',
                    'entity',
                    $fieldOptions['codEntidade']
                )
                ->add(
                    'numOrgao',
                    'entity',
                    $fieldOptions['numOrgao']
                )
                ->add(
                    'numUnidade',
                    'entity',
                    $fieldOptions['numUnidade']
                )
                ->add(
                    'codProprietario',
                    'autocomplete',
                    $fieldOptions['codProprietario']
                )
        ;

        $this->createFormOrganograma($formMapper, $exibeOrganogramaAtivo = true);

        $formMapper
                ->add(
                    'codLocal',
                    'entity',
                    $fieldOptions['codLocal']
                )
            ->end()
            ->with('label.veiculoTerceiro.dadosResponsavel')
                ->add(
                    'codResponsavel',
                    'autocomplete',
                    $fieldOptions['codResponsavel'],
                    ['admin_code' => 'core.admin.filter.sw_cgm']
                )
                ->add(
                    'dtInicio',
                    'sonata_type_date_picker',
                    $fieldOptions['dtInicio']
                )
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
            ->add('codVeiculo')
        ;
    }
}
