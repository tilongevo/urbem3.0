<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Concurso\Edital;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\EditalModel;
use Urbem\CoreBundle\Repository\Patrimonio\Licitacao\EditalRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class AtaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_processo_licitatorio_ata_encerramento';
    protected $baseRoutePattern = 'patrimonial/licitacao/processo-licitatorio/ata-encerramento';

    protected $includeJs = [
        '/patrimonial/javascripts/licitacao/ata-encerramento.js',
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numAta', null, ['label' => 'label.ata.numAta'])
            ->add('exercicioAta', null, ['label' => 'exercicio'])
            ->add('numEdital', null, ['label' => 'label.ata.numEdital'])
            ->add('exercicio', null, ['label' => 'label.ata.exercicioEdital'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('numAta', null, ['label' => 'label.ata.numAta'])
            ->add('exercicioAta', null, ['label' => 'exercicio'])
            ->add('fkLicitacaoEdital', null, [
                'label' => 'label.ata.numEdital',
            ])
            ->add('timestamp', 'date', [
                'label' => 'label.ata.dataAta',
                'format' => 'd/m/Y'
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'edit' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig']
                ]
            ])
        ;
    }

    /**
     * @param Licitacao\Ata $ata
     */
    public function validate(ErrorElement $errorElement, $ata)
    {
        if ($ata->getFkLicitacaoPublicacaoAtas()->count() == 0) {
            $message = $this->trans('ata.errors.publicacao_required', [], 'validators');
            $errorElement->with('fkLicitacaoPublicacaoAtas')->addViolation($message)->end();
        }

        $form = $this->getForm();
        $horaAta = explode(':', $form->get('horaAta')->getData());
        if (((int) $horaAta[0]) > 23 or ((int) $horaAta[1]) > 60) {
            $message = $this->trans('invalid_time', [], 'validators');
            $errorElement->with('horaAta')->addViolation($message)->end();
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /**
         * Auxilia na execuçao das Models
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $editalModel = new EditalModel($entityManager);
        if (!$editalModel->isConfigsSugestaoDescricaoParaAta($this->getExercicio())) {
            $message = $this->trans('ata.errors.missingConfig', [], 'validators');
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', $message);
            $this->redirectByRoute('urbem_patrimonial_licitacao_processo_licitatorio_ata_encerramento_list');
            return false;
        }
        /** @var Licitacao\Ata $ata */
        $ata = $this->getObject($id);
        $ata = $ata ? $ata : new Licitacao\Ata();
        $horaAta = $ata->getTimestamp()->format('H:i');

        $results = $editalModel->getEditaisDiposniveisParaAtaEncerramento($id);

        $choices = [];
        foreach ($results as $res) {
            $key = "{$res['num_edital']}/{$res['exercicio']}";
            $value = "{$res['num_edital']}~{$res['exercicio']}";
            $choices[$key] = $value;
        }

        $formMapperOptions = [];
        $formMapperOptions['numAta'] = [
            'attr' => ['class' => 'is-filled '],
            'label' => 'label.ata.numAta',
            'required' => true
        ];
        $formMapperOptions['dataAta'] = [
            'attr' => ['class' => 'is-filled '],
            'format' => 'dd/MM/yyyy',
            'label' => 'label.ata.dataAta',
            'mapped' => false,
            'required' => true,
            'data' => $ata->getTimestamp(),
            'widget' => 'single_text',
        ];
        $formMapperOptions['horaAta'] = [
            'attr' => ['class' => 'horacampo-sonata is-filled '],
            'label' => 'label.ata.horaAta',
            'data' => $horaAta,
            'mapped' => false,
        ];
        $formMapperOptions['dtValidadeAta'] = [
            'attr' => ['class' => 'is-filled '],
            'format' => 'dd/MM/yyyy',
            'label' => 'label.ata.dtValidadeAta',
            'required' => true,
            'widget' => 'single_text'
        ];
        $formMapperOptions['tipoAdesao'] = [
            'attr' => ['class' => 'select2-parameters is-filled '],
            'choice_label' => 'descricao',
            'label' => 'label.ata.tipoAdesao',
            'required' => true,
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('tipoAdesao')
                    ->orderBy('tipoAdesao.codigo', 'ASC');
            }
        ];
        $formMapperOptions['numEdital'] = [
            'attr' => ['class' => 'select2-parameters is-filled '],
            'choices' => $choices,
            'choice_attr' => function ($entidade, $key, $index) use ($ata) {
                if ($index == $ata->getNumEdital()) {
                    return ['selected' => 'selected'];
                } else {
                    return ['selected' => false];
                }
            },
            'label' => 'label.ata.numEdital',
            'placeholder' => 'Selecione',
            'required' => true
        ];
        $formMapperOptions['descricao'] = [
            'attr' => [
                'class' => 'is-filled ',
                'style' => 'margin: 0px -294.875px 0px 0px; width: 573px; height: 258px;'
            ],
            'label' => 'label.ata.descricao',
            'required' => true
        ];

        $formMapper
            ->with('label.ata.dadosAta')
                ->add('numAta', null, $formMapperOptions['numAta'])
                ->add('dataAta', 'sonata_type_date_picker', $formMapperOptions['dataAta'])
                ->add('horaAta', 'text', $formMapperOptions['horaAta'])
                ->add('dtValidadeAta', 'sonata_type_date_picker', $formMapperOptions['dtValidadeAta'])
                ->add('fkLicitacaoTipoAdesaoAta', null, $formMapperOptions['tipoAdesao'])
                ->add('numEdital', 'choice', $formMapperOptions['numEdital'])
                ->add('descricao', null, $formMapperOptions['descricao'])
            ->end()
            ->with('label.ata.publicacao.dadosPublicacao')
                ->add('fkLicitacaoPublicacaoAtas', 'sonata_type_collection', [
                    'label' => false,
                ], [
                    'admin_code' => 'patrimonial.admin.publicacao_ata',
                    'edit' => 'inline',
                    'inline' => 'table'
                ])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb(['id' => $id]);

        $showMapper
            ->add('numAta', null, ['label' => 'label.ata.numAta'])
            ->add('exercicioAta', null, ['label' => 'label.ata.exercicioAta'])
            ->add('timestamp', null, ['label' => 'label.ata.dataAta'])
            ->add('descricao', null, ['label' => 'label.ata.descricao'])
            ->add('dtValidadeAta', null, ['label' => 'label.ata.dtValidadeAta'])
        ;
    }

    /**
     * @param Licitacao\Ata $ata
     */
    final private function getAndSetEditalToAta(Licitacao\Ata $ata)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        list($numEdital, $exercicio) = explode('~', $ata->getNumEdital());

        $edital = $entityManager->getRepository(Licitacao\Edital::class)
            ->find([
                'numEdital' => $numEdital,
                'exercicio' => $exercicio
            ]);

        $ata->setNumEdital($edital->getNumEdital());
        $ata->setExercicio($edital->getExercicio());
    }

    /**
     * @param Licitacao\Ata $ata
     */
    final private function joinAndSetTimestampInAta(Licitacao\Ata $ata)
    {
        $form = $this->getForm();

        /** @var \DateTime $timestamp */
        $timestamp = $form->get('dataAta')->getData();
        $horaAta = explode(':', $form->get('horaAta')->getData());

        $timestamp->setTime($horaAta[0], $horaAta[1]);

        $ata->setTimestamp($timestamp);
    }

    /**
     * @param Licitacao\Ata $ata
     */
    public function prePersist($ata)
    {
        /* @TODO: Move to repo */
        $ataId = $this->getDoctrine()
            ->getConnection()
            ->executeQuery('Select nextval(\'licitacao.ata_seq\')')
            ->fetchColumn();
        $ata->setId($ataId);
        /* ---- */
        $em = $this->modelManager->getEntityManager(Licitacao\Ata::class);
        $em->persist($ata);

        /** @var Licitacao\PublicacaoAta $pa */
        foreach ($ata->getFkLicitacaoPublicacaoAtas() as $pa) {
            $pa->setAtaId($ata->getId());
        }

        $this->joinAndSetTimestampInAta($ata);
        $this->getAndSetEditalToAta($ata);
        $ata->setExercicioAta($this->getExercicio());
    }

    /**
     * @param Licitacao\Ata $ata
     */
    public function preUpdate($ata)
    {
        /** @var Licitacao\PublicacaoAta $pa */
        foreach ($ata->getFkLicitacaoPublicacaoAtas() as $pa) {
            $pa->setAtaId($ata->getId());
        }
        $this->joinAndSetTimestampInAta($ata);
        $this->getAndSetEditalToAta($ata);
    }
}
