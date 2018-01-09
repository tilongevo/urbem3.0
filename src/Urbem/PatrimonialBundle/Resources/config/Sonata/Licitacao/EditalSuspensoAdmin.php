<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Licitacao\Edital;
use Urbem\CoreBundle\Entity\Licitacao\EditalSuspenso;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class EditalSuspensoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_edital_suspenso';
    protected $baseRoutePattern = 'patrimonial/licitacao/edital-suspenso';

    /**
     * @param EditalSuspenso $editalSuspenso
     */
    public function prePersist($editalSuspenso)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $edital = $entityManager
            ->getRepository(Edital::class)
            ->findOneBy([
                'numEdital' => $formData['numHEdital'],
                'exercicio' => $formData['hexercicio']
            ]);


        $editalSuspenso->setFkLicitacaoEdital($edital);
    }

    /**
     * @param EditalSuspenso $editalSuspenso
     */
    public function postPersist($editalSuspenso)
    {
        $this->redirect($editalSuspenso);
    }

    /**
     * @param EditalSuspenso $editalSuspenso
     */
    public function postRemove($editalSuspenso)
    {
        $this->redirect($editalSuspenso);
    }

    /**
     * @param EditalSuspenso $editalSuspenso
     */
    public function redirect($editalSuspenso)
    {
        $this->forceRedirect("/patrimonial/licitacao/edital/{$this->getObjectKey($editalSuspenso->getFkLicitacaoEdital())}/show");
    }


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('dtSuspensao')
            ->add('justificativa')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('exercicio')
            ->add('dtSuspensao')
            ->add('justificativa')
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
        $ids = explode("~", $this->getAdminRequestId());
        $this->setBreadCrumb($ids ? ['id' => $ids] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $id = $formData['numHEdital'];
            $exercicio = $formData['hexercicio'];
        } else {
            $id = $ids[0];
            $exercicio = $ids[1];
        }

        $now = new \DateTime();

        $defaultDate = [
            'widget' => 'single_text',
            'dp_default_date' =>  $now->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'required' => true
        ];

        /**
         * @var EntityManager $entityManager
         */
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Licitacao\Licitacao');
        /** @var Edital $edital */
        $edital = $entityManager
            ->getRepository(Edital::class)
            ->findOneBy([
                'numEdital' => $id,
                'exercicio' => $exercicio
            ]);
        /** @var SwProcesso $processo */
        $processo = $edital->getFkLicitacaoLicitacao()->getFkSwProcesso();

        $fieldOptions = [];
        $fieldOptions['dtSuspensao'] = $defaultDate;
        $fieldOptions['exercicio'] = [
            'label' => 'label.patrimonial.licitacao.edital.exercicio',
            'data' => $exercicio,
            'attr' => [
                'readonly' => 'readonly'
                ]
        ];

        $fieldOptions['dtSuspensao'] = [
            'label' => 'label.patrimonial.licitacao.edital.dtSuspensao',
        ];

        $formMapper
            ->add('hexercicio', 'hidden', ['data' => $exercicio, 'mapped' => false])
            ->add('numHEdital', 'hidden', ['data' => $id, 'mapped' => false])
            ->add(
                'edital',
                'text',
                [
                    'data' => $id . '/' . $exercicio,
                    'mapped' => false,
                    'attr' => [
                        'disabled' => 'true'
                    ],
                ]
            )
            ->add('dtSuspensao', 'sonata_type_date_picker', $fieldOptions['dtSuspensao'])
            ->add(
                'codLicitacao',
                'text',
                [
                    'label' => 'label.patrimonial.licitacao.codLicitacao',
                    'data' => $edital->getFkLicitacaoLicitacao(),
                    'mapped' => false,
                    'attr' => [
                        'disabled' => 'true'
                    ],
                ]
            )
            ->add(
                'exercicio',
                'text',
                [
                    'label' => 'label.patrimonial.licitacao.edital.exercicio',
                    'data' => $edital->getExercicioLicitacao(),
                    'mapped' => false,
                    'attr' => [
                        'disabled' => 'true'
                    ],
                ]
            )
            ->add(
                'codEntidade',
                'text',
                [
                    'label' => 'label.comprasDireta.codEntidade',
                    'data' => $edital->getFkLicitacaoLicitacao()->getFkOrcamentoEntidade(),
                    'mapped' => false,
                    'attr' => [
                        'disabled' => 'true'
                    ],
                ]
            )
            ->add(
                'codModalidade',
                'text',
                [
                    'label' => 'label.comprasDireta.codModalidade',
                    'data' => $edital->getFkLicitacaoLicitacao()->getFkComprasModalidade(),
                    'mapped' => false,
                    'attr' => [
                        'disabled' => 'true'
                    ],
                ]
            )
            ->add(
                'processo',
                'text',
                [
                    'label' => 'label.comprasDireta.codProcesso',
                    'data' => $processo->getCodProcesso() . '/' . $edital->getExercicio(),
                    'mapped' => false,
                    'attr' => [
                        'disabled' => 'true'
                    ],
                ]
            )
            ->add('justificativa')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('numEdital')
            ->add('exercicio')
            ->add('dtSuspensao')
            ->add('justificativa')
        ;
    }
}
