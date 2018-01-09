<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Urbem\CoreBundle\Entity\Licitacao\AnulacaoImpugnacaoEdital;
use Urbem\CoreBundle\Entity\Licitacao\Edital;
use Urbem\CoreBundle\Entity\Licitacao\EditalImpugnado;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Model;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EditalImpugnadoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_edital_impugnado';
    protected $baseRoutePattern = 'patrimonial/licitacao/edital-impugnado';

    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;

    protected $includeJs = [
        '/patrimonial/javascripts/licitacao/edital-impugnado.js',
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'get_processo_by_classificacao_and_assunto',
            'get-processo-by-classificacao-and-assunto/'
        );

        $collection->add(
            'get_assunto_by_classificacao',
            'get-assunto-by-classificacao/'
        );
    }

    public function prePersist($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $em = $this->getModelManager()->getEntityManager($this->getClass());

        $edital = $em
            ->getRepository(Edital::class)
            ->findOneBy([
                'numEdital' => $formData['codEdital'],
                'exercicio' => $formData['hexercicio']
            ]);

        foreach($formData['swProcessoEscolhido'] as $processo){
            $proc = $em
                ->getRepository(SwProcesso::class)
                ->findOneBy([
                    'codProcesso' => $processo,
                ]);

            $anular = $em
                ->getRepository(AnulacaoImpugnacaoEdital::class)
                ->findOneBy([
                    'codProcesso' => $proc->getCodProcesso(),
                    'numEdital' => $edital
                ]);

            if(count($anular) > 0){
                $em->remove($anular);
                $em->flush();
            }

            $editalImpugnado = new EditalImpugnado();
            $editalImpugnado->setCodProcesso($proc);
            $editalImpugnado->setNumEdital($edital);
            $editalImpugnado->setExercicioProcesso($proc->getAnoExercicio());
            $em->persist($editalImpugnado);
        }
        $em->flush();

        $edital = $formData['codEdital']."~".$formData['hexercicio'];

        $message = $this->trans('patrimonial.licitacao.edital.impugnado.create', [], 'flashes');
        $this->redirect($edital, $message, 'success');
    }

    public function postPersist($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $edital = $formData['codEdital']."~".$formData['hexercicio'];

        $message = $this->trans('patrimonial.licitacao.edital.impugnado.create', [], 'flashes');
        $this->redirect($edital, $message, 'success');
    }

    public function postUpdate($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $edital = $formData['codEdital']."~".$formData['hexercicio'];
        $message = $this->trans('patrimonial.licitacao.edital.impugnado.edit', [], 'flashes');
        $this->redirect($edital, $message, 'success');
    }

    public function postRemove($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $edital = $formData['codEdital']."~".$formData['hexercicio'];
        $message = $this->trans('patrimonial.licitacao.edital.impugnado.delete', [], 'flashes');
        $this->redirect($edital, $message, 'success');
    }

    public function redirect($edital, $message, $type = 'success')
    {
        $message = $this->trans($message);
        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add($type, $message);

        $this->forceRedirect("/patrimonial/licitacao/edital/perfil?id=" . $edital);
    }



    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicioProcesso')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('exercicioProcesso')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $ids = explode('~', $this->getAdminRequestId());

        $id = $ids[0];

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $id = $formData['codEdital'];
            $exercicio = $formData['hexercicio'];
        }else{
            $id = $ids[0];
            $exercicio = $ids[1];
        }

        $fieldOptions['swClassificacao'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'class' => SwClassificacao::class,
            'choice_label' => 'nomClassificacao',
            'label' => 'Classificação',
            'mapped' => false,
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['swAssunto'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'label' => 'Assunto',
        ];

        $fieldOptions['swProcesso'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'label' => 'Processo',
        ];

        $fieldOptions['swProcessoEscolhido'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
            'label' => 'Processo Escolhido',
            'multiple' => true,
            'expanded' => false,
        ];

        $formMapper
            ->add(
                'codEdital',
                'hidden',
                ['data' => $id, 'mapped' => false]
            )
            ->add(
                'hexercicio',
                'hidden',
                ['data' => $exercicio, 'mapped' => false]
            )
            ->add(
                'swClassificacao',
                'entity',
                $fieldOptions['swClassificacao']
            )
            ->add('swAssunto', 'choice', $fieldOptions['swAssunto'])
            ->add('swProcesso', 'choice', $fieldOptions['swProcesso'])
            ->add('swProcessoEscolhido', 'choice', $fieldOptions['swProcessoEscolhido'])
        ;

        $em = $this->getModelManager()->getEntityManager($this->getClass());
        $swModel = new SwProcessoModel($em);

        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $swModel, $em) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);

                if (isset($data['swClassificacao']) && $data['swClassificacao'] != "") {
                    $assuntos = $em
                        ->getRepository(SwAssunto::class)
                        ->findBy([
                            'codClassificacao' => $data['swClassificacao'],
                        ]);

                    $dados = array();
                    foreach ($assuntos as $assunto) {
                        $dados[$assunto->getCodAssunto() . '-' .$assunto->getNomAssunto()] = $assunto->getCodAssunto();
                    }

                    $coAssuntos = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'swAssunto',
                        'choice',
                        null,
                        array(
                            'choices' => $dados,
                            'label' => 'Assunto',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'attr' => [
                                'class' => 'select2-parameters '
                            ]
                        )
                    );

                    $form->add($coAssuntos);
                }

                if (isset($data['swAssunto']) && $data['swAssunto'] != "") {
                    $comissaoMembros = $swModel->getProcessoByClassificacaoAndAssunto($data['swClassificacao'], $data['swAssunto']);

                    $dados = array();
                    foreach ($comissaoMembros as $membro) {
                        $key = $membro->cod_processo_completo;
                        $dados[$key] = $membro->cod_processo;
                    }

                    $comMembros = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'swProcesso',
                        'choice',
                        null,
                        array(
                            'choices' => $dados,
                            'label' => 'Processo',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'attr' => [
                                'class' => 'select2-parameters '
                            ]
                        )
                    );

                    $form->add($comMembros);
                }

                if (isset($data['swProcesso']) && $data['swProcesso'] != "") {
                    $processos = $em
                        ->getRepository(SwProcesso::class)
                        ->findBy([
                            'codProcesso' => $data['swProcessoEscolhido'],
                        ]);

                    $dados = array();
                    foreach ($processos as $processo) {
                        $dados[$processo->getCodProcesso() . '/' .$processo->getAnoExercicio()] = $processo->getCodProcesso();
                    }

                    $comMembros = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'swProcessoEscolhido',
                        'choice',
                        null,
                        array(
                            'choices' => $dados,
                            'label' => 'Processo Escolhido',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'attr' => [
                                'class' => 'select2-parameters '
                            ],
                            'multiple' => true,
                            'expanded' => false
                        )
                    );

                    $form->add($comMembros);
                }
            }
        );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicioProcesso')
        ;
    }
}
