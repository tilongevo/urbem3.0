<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ContrapartidaResponsavelAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_contrapartida_responsavel';
    protected $baseRoutePattern = 'financeiro/empenho/contrapartida/responsavel';

    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $exercicio);
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();
        $datagridMapper
            ->add(
                'fkEmpenhoResponsavelAdiantamentos.fkSwCgm',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.responsavel'
                ],
                'sonata_type_model_autocomplete',
                [
                    'property' => 'nomCgm',
                    'to_string_callback' => function (SwCgm $pessoa, $property) {
                        return (string) $pessoa;
                    }
                ]
            )
            ->add(
                'fkContabilidadePlanoAnalitica',
                'composite_filter',
                [
                    'label' => 'label.contrapartida.contrapartidaContabil'
                ],
                null,
                [
                    'class' => 'CoreBundle:Contabilidade\PlanoAnalitica',
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('pa');
                        $qb->innerJoin('CoreBundle:Contabilidade\PlanoConta', 'pc', 'WITH', 'pc.codConta = pa.codConta and pc.exercicio = pa.exercicio');
                        $qb->andWhere('pc.exercicio = :exercicio');
                        $qb->andWhere($qb->expr()->like('pc.codEstrutural', ':codEstrutural'));
                        $qb->setParameters([
                            'exercicio' => $exercicio,
                            'codEstrutural' => '8.9.%'
                        ]);
                        $qb->orderBy('pc.codEstrutural', 'ASC');
                        return $qb;
                    }
                ],
                ['admin_code' => 'financeiro.admin.conciliar_conta']
            )
            ->add(
                'fkEmpenhoResponsavelAdiantamentos.fkContabilidadePlanoAnalitica',
                'composite_filter',
                [
                    'label' => 'label.contrapartida.contaContrapartida'
                ],
                null,
                [
                    'class' => 'CoreBundle:Contabilidade\PlanoAnalitica',
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('pa');
                        $qb->innerJoin('CoreBundle:Contabilidade\PlanoConta', 'pc', 'WITH', 'pc.codConta = pa.codConta and pc.exercicio = pa.exercicio');
                        $qb->andWhere('pc.exercicio = :exercicio');
                        $qb->andWhere($qb->expr()->like('pc.codEstrutural', ':codEstrutural'));
                        $qb->setParameters([
                            'exercicio' => $exercicio,
                            'codEstrutural' => '7.1.1.1.%'
                        ]);
                        $qb->orderBy('pc.codEstrutural', 'ASC');
                        return $qb;
                    }
                ],
                ['admin_code' => 'financeiro.admin.conciliar_conta']
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'fkContabilidadePlanoAnalitica',
                'text',
                [
                    'label' => 'label.contrapartida.contrapartidaContabil',
                    'admin_code' => 'financeiro.admin.conciliar_conta'
                ]
            )
            ->add('prazo', null, ['label' => 'label.contrapartida.prazo'])
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

        $fieldOptions = [];

        $fieldOptions['fkContabilidadePlanoAnalitica'] = [
            'label' => 'label.contrapartida.contrapartidaContabil',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'required' => true,
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'query_builder' => function ($em) use ($exercicio) {
                $qb = $em->createQueryBuilder('pa');
                $qb->innerJoin('CoreBundle:Contabilidade\PlanoConta', 'pc', 'WITH', 'pc.codConta = pa.codConta and pc.exercicio = pa.exercicio');
                $qb->andWhere('pc.exercicio = :exercicio');
                $qb->andWhere($qb->expr()->like('pc.codEstrutural', ':codEstrutural'));
                $qb->setParameters([
                    'exercicio' => $exercicio,
                    'codEstrutural' => '8.9.%'
                ]);
                $qb->orderBy('pc.codEstrutural', 'ASC');
                return $qb;
            }
        ];

        $fieldOptions['prazo'] = [
            'label' => 'label.contrapartida.prazo',
            'attr' => ['min' => 1, 'max' => 999]
        ];

        if ($this->getSubject()->getExercicio() != null) {
            $fieldOptions['fkContabilidadePlanoAnalitica']['disabled'] = true;
            $fieldOptions['fkContabilidadePlanoAnalitica']['data'] = $this->getSubject()->getFkContabilidadePlanoAnalitica();

            $fieldOptions['prazo']['mapped'] = false;
            $fieldOptions['prazo']['disabled'] = true;
            $fieldOptions['prazo']['data'] = $this->getSubject()->getPrazo();
        }

        $formMapper
            ->with('label.contrapartida.dadoCadastroContrapartida')
                ->add('fkContabilidadePlanoAnalitica', null, $fieldOptions['fkContabilidadePlanoAnalitica'], ['admin_code' => 'financeiro.admin.conciliar_conta'])
                ->add('prazo', null, $fieldOptions['prazo'])
            ->end()
            ->with('label.contrapartida.dadoResponsaveisAdiantamentos')
            ->add(
                'fkEmpenhoResponsavelAdiantamentos',
                'sonata_type_collection',
                [
                    'by_reference' => true,
                    'label' => false
                ],
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                )
            )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('fkContabilidadePlanoAnalitica', 'text', ['label' => 'label.contrapartida.contrapartidaContabil'])
            ->add('prazo', null, ['label' => 'label.contrapartida.prazo'])
            ->add('fkEmpenhoResponsavelAdiantamentos', null, ['label' => 'label.contrapartida.responsaveisAdiantamentos'])
        ;
    }

    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        $this->getRequest()->getSession()->getFlashBag()->clear();

        $responsaveis = $object->getFkEmpenhoResponsavelAdiantamentos()->count();
        if ((!$responsaveis) && ($object->getPrazo())) {
            $mensagem = $this->getTranslator()->trans('label.contrapartida.erroResponsaveis');
            $errorElement->with('contaContrapartida')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        } else {
            $erroCgm = $erroPlano = false;
            $numcgm = $numcgmErro = $plano = $planoErro = '';
            foreach ($object->getFkEmpenhoResponsavelAdiantamentos() as $responsavelAdiantamento) {
                if ($responsavelAdiantamento->getNumcgm()) {
                    if ($responsavelAdiantamento->getNumcgm() == $numcgm) {
                        $erroCgm = true;
                        $numcgmErro = $responsavelAdiantamento->getNumcgm();
                    }
                    $numcgm = $responsavelAdiantamento->getNumcgm();
                }

                if ($responsavelAdiantamento->getFkContabilidadePlanoAnalitica()) {
                    if ($responsavelAdiantamento->getFkContabilidadePlanoAnalitica()->getCodPlano() == $plano) {
                        $erroPlano = true;
                        $planoErro = $responsavelAdiantamento->getFkContabilidadePlanoAnalitica()->getCodPlano();
                    }
                    $plano = $responsavelAdiantamento->getFkContabilidadePlanoAnalitica()->getCodPlano();
                }
            }
            if ($erroCgm) {
                $mensagem = $this->getTranslator()->trans('label.contrapartida.erroSwCgm', array('%numcgm%', $numcgmErro));
                $errorElement->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }
            if ($erroPlano) {
                $mensagem = $this->getTranslator()->trans('label.contrapartida.erroPlanoAnalitica', array('%codPlano%', $planoErro));
                $errorElement->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
            }
        }

        if (!$this->id($this->getSubject())) {
            $exercicio = $this->getExercicio();
            $contaContrapartida = $this->getForm()->get('fkContabilidadePlanoAnalitica')->getData();
            if ($contaContrapartida) {
                $em = $this->modelManager->getEntityManager($this->getClass());
                $contrapartida = $em->getRepository('CoreBundle:Empenho\ContrapartidaResponsavel')
                    ->findOneBy([
                        'exercicio' => $exercicio,
                        'contaContrapartida' => $contaContrapartida->getCodPlano(),
                    ]);

                if ($contrapartida != null) {
                    $mensagem = $this->getTranslator()->trans('label.contrapartida.erroContrapartida');
                    $errorElement->with('fkContabilidadePlanoAnalitica')->addViolation($mensagem)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
                }
            }
        }
    }

    public function prePersist($object)
    {
        $object->setFkContabilidadePlanoAnalitica($this->getForm()->get('fkContabilidadePlanoAnalitica')->getData());

        $responsaveisAdiantamento = $object->getFkEmpenhoResponsavelAdiantamentos();
        foreach ($responsaveisAdiantamento as $responsavelAdiantamento) {
            $responsavelAdiantamento->setFkEmpenhoContrapartidaResponsavel($object);
        }
    }

    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $atuais = $em->getRepository('CoreBundle:Empenho\ResponsavelAdiantamento')
            ->findBy([
                'exercicio' => $object->getExercicio(),
                'contaContrapartida' => $object->getContaContrapartida()
            ]);

        foreach ($atuais as $atual) {
            $remover[$atual->getContaLancamento()] = $atual;
        }

        $responsaveisAdiantamento = $object->getFkEmpenhoResponsavelAdiantamentos();
        foreach ($responsaveisAdiantamento as $responsavelAdiantamento) {
            if ($responsavelAdiantamento->getFkEmpenhoContrapartidaResponsavel() == null) {
                $responsavelAdiantamento->setFkEmpenhoContrapartidaResponsavel($object);
            }

            if (in_array($responsavelAdiantamento, $remover)) {
                unset($remover[$responsavelAdiantamento->getContaLancamento()]);
            }
        }

        foreach ($remover as $responsavelAdiantamento) {
            $em->remove($responsavelAdiantamento);
        }
        $em->flush();
    }
}
