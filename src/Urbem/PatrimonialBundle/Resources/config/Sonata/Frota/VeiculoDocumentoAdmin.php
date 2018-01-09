<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Entity\Administracao\Mes;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Helper;
use Urbem\CoreBundle\Model;

use Urbem\CoreBundle\Entity\Frota;

use Urbem\CoreBundle\Model\Patrimonial\Frota\VeiculoModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\VeiculoDocumentoModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\VeiculoDocumentoEmpenhoModel;

class VeiculoDocumentoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_veiculo_documento';
    protected $baseRoutePattern = 'patrimonial/frota/veiculo-documento';
    protected $includeJs = [
        '/patrimonial/javascripts/frota/veiculoDocumento.js',
    ];

    protected $model = Model\Patrimonial\Frota\VeiculoDocumentoModel::class;

    /**
     * @param Frota\VeiculoDocumento $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/frota/veiculo-documento/create?id={$object->getCodVeiculo()}");
        }
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $form = $this->getForm();
        if (!is_null($object->getFkFrotaDocumento())) {
            $object->setFkFrotaDocumento($object->getFkFrotaDocumento());
        }
        $object->setMes($form->get('mes')->getData()->getCodMes());
    }

    /**
     * @param Frota\VeiculoDocumento $object
     * @param Form $form
     */
    public function saveRelationships($object, $form)
    {
        $exercicio = $this->getExercicio();
        $object->setExercicio($exercicio);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager('CoreBundle:Frota\Veiculo');
        $veiculoModel = new VeiculoModel($em);

        $veiculo = $veiculoModel
            ->getVeiculo($object->getCodVeiculo());

        $object->setFkFrotaVeiculo($veiculo);

        if (is_null($object->getFkFrotaDocumento())) {
            $object->setFkFrotaDocumento($form->get('codDocumento')->getData());
        }

        $em->flush();

        // Setar VeiculoDocumentoEmpenho
        if ($form->get('situacao')->getData()) {
            $em = $this->modelManager->getEntityManager('CoreBundle:Frota\VeiculoDocumentoEmpenho');
            $veiculoDocumentoEmpenhoModel = new VeiculoDocumentoEmpenhoModel($em);

            $object->setFkFrotaVeiculoDocumentoEmpenho($veiculoDocumentoEmpenhoModel
                ->setVeiculoDocumentoEmpenho($object, $form));
        }
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {

        $container = $this->getConfigurationPool()->getContainer();
        try {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager('CoreBundle:Frota\VeiculoDocumentoEmpenho');
            $veiculoDocumentoEmpenho = $em->getRepository('CoreBundle:Frota\VeiculoDocumentoEmpenho')
                ->findOneBy([
                    'codVeiculo' => $object->getCodVeiculo(),
                    'codDocumento' => $object->getCodDocumento(),
                    'exercicio' => $object->getExercicio()
                ]);
            if ($veiculoDocumentoEmpenho) {
                $em->remove($veiculoDocumentoEmpenho);
            }

            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_EDIT_DATA);
            $this->forceRedirect("/patrimonial/frota/veiculo-documento/{$this->getAdminRequestId()}/edit");
        }
    }

    /**
     * @param Frota\VeiculoDocumento $object
     */
    public function postPersist($object)
    {
        $this->redirect($object);
    }

    /**
     * @param Frota\VeiculoDocumento $object
     */
    public function redirect($object)
    {
        $this->forceRedirect("/patrimonial/frota/veiculo/{$this->getObjectKey($object->getFkFrotaVeiculo())}/show");
    }

    /**
     * @param Frota\VeiculoDocumento $object
     */
    public function postUpdate($object)
    {
        $this->redirect($object);
    }

    /**
     * @param Frota\VeiculoDocumento $object
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
            ->add('exercicio')
            ->add('mes');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('exercicio')
            ->add('mes');

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $veiculoDocumentoCodVeiculo = 0;
        $veiculoDocumentoExercicio = '';

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $veiculoDocumentoodDocumento = '';
        $tipo = 'entity';

        $exercicio = $this->getExercicio();

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codVeiculo = $formData['codVeiculo'];
        } else {
            if ($this->getSubject()->getCodVeiculo()) {
                $codVeiculo = $this->getSubject()->getFkFrotaVeiculo()->getCodVeiculo();
            } else {
                $codVeiculo = $this->getRequest()->query->get('id');
            }
        }


        $em = $this->modelManager->getEntityManager('CoreBundle:Frota\Veiculo');
        $veiculoModel = new VeiculoModel($em);

        $veiculo = $veiculoModel
            ->getVeiculo($codVeiculo);

        $route = $this->getRequest()->get('_sonata_name');
        if ($this->baseRouteName . "_edit" == $route) {
            list($veiculoDocumentoCodVeiculo, $veiculoDocumentoodDocumento, $veiculoDocumentoExercicio) =
                explode('~', $id);

            $em = $this->modelManager->getEntityManager('CoreBundle:Frota\VeiculoDocumento');
            $veiculoDocumentoModel = new VeiculoDocumentoModel($em);

            $veiculoDocumento = $veiculoDocumentoModel
                ->getVeiculoDocumento([
                    'codVeiculo' => $veiculoDocumentoCodVeiculo,
                    'codDocumento' => $veiculoDocumentoodDocumento,
                    'exercicio' => $veiculoDocumentoExercicio
                ]);

            $em = $this->modelManager->getEntityManager('CoreBundle:Frota\Veiculo');
            $veiculoModel = new VeiculoModel($em);

            $veiculo = $veiculoModel
                ->getVeiculo($veiculoDocumento->getCodVeiculo());
        }

        $fieldOptions['veiculo'] = [
            'class' => 'CoreBundle:Frota\Veiculo',
            'choice_label' => function (Frota\Veiculo $veiculo) {
                return $veiculo->getCodVeiculo() . ' - ' .
                $veiculo->getPlaca() . ' - ' .
                $veiculo->getFkFrotaMarca()->getNomMarca() . ' - ' .
                $veiculo->getFkFrotaModelo()->getNomModelo();
            },
            'label' => 'label.veiculoCessao.codVeiculo',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'data' => $veiculo,
            'mapped' => false,
            'disabled' => true,
        ];

        $fieldOptions['codVeiculo'] = [
            'data' => $veiculo->getCodVeiculo()
        ];

        $fieldOptions['codDocumento'] = [
            'class' => 'CoreBundle:Frota\Documento',
            'choice_label' => function (Frota\Documento $codDocumento) {
                return $codDocumento->getCodDocumento() . ' - ' .
                $codDocumento->getNomDocumento();
            },
            'label' => 'label.veiculoDocumento.codDocumento',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione',
            'query_builder' => function ($em) use ($codVeiculo, $veiculoDocumentoodDocumento) {
                $em = $this->modelManager->getEntityManager('CoreBundle:Frota\VeiculoDocumento');
                $veiculoDocumentoModel = new VeiculoDocumentoModel($em);
                $exercicio = $this->getExercicio();

                $params = [
                    'codVeiculo' => $codVeiculo,
                    'exercicio' => $exercicio
                ];

                if ($veiculoDocumentoodDocumento) {
                    $params['codDocumento'] = $veiculoDocumentoodDocumento;
                }

                $veiculoDocumento = $veiculoDocumentoModel
                    ->getDocumentosLivres($params);

                return $veiculoDocumento;
            }
        ];

        $fieldOptions['exercicio'] = [
            'label' => 'label.veiculoDocumento.exercicio',
        ];

        $fieldOptions['mes'] = [
            'class' => 'CoreBundle:Administracao\Mes',
            'choice_label' => 'descricao',
            'label' => 'label.veiculoDocumento.mes',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'query_builder' => function (EntityRepository $em) {
                $qb = $em->createQueryBuilder('m');
                $qb->orderBy('m.codMes', 'ASC');
                return $qb;
            },
            'placeholder' => 'label.selecione',
            'choice_value' => 'codMes'
        ];

        $fieldOptions['situacao'] = [
            'label' => 'label.veiculoDocumento.situacao',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['exercicioEmpenho'] = [
            'label' => 'label.veiculoDocumento.exercicioEmpenho',
            'mapped' => false,
        ];

        $fieldOptions['codEntidade'] = [
            'class' => 'CoreBundle:Orcamento\Entidade',
            'choice_label' => function (Entidade $entidade) {
                return $entidade->getCodEntidade() . ' - ' .
                $entidade->getFkSwCgm()->getNomCgm();
            },
            'query_builder' => function (EntityRepository $er) use ($exercicio) {
                return $er
                    ->createQueryBuilder('entidade')
                    ->where('entidade.exercicio = :exercicio')
                    ->setParameter(':exercicio', $exercicio);
            },
            'label' => 'label.veiculoDocumento.codEntidade',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['codEmpenho'] = [
            'label' => 'label.veiculoDocumento.codEmpenho',
            'mapped' => false,
        ];

        if ($this->id($this->getSubject())) {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            // Processa CodDocumento
            $fieldOptions['codDocumento'] = [
                'data' => $this->getSubject()->getFkFrotaDocumento(),
                'label' => 'label.veiculoDocumento.codDocumento',
                'attr' => [
                    'readonly' => 'readonly'
                ]
            ];

            // Processa Mes
            /** @var Mes $mes */
            $mes = $em->getRepository(Mes::class)->findOneBy([
                'codMes' => $this->getSubject()->getMes()
            ]);
            $fieldOptions['exercicio'] = [
                'attr' => [
                    'readonly' => 'readonly'
                ]
            ];

            $fieldOptions['mes']['data'] = $mes;

            // Processa VeiculoDocumentoEmpenho
            $veiculoDocumentoEmpenho = $em->getRepository('CoreBundle:Frota\VeiculoDocumentoEmpenho')->findOneBy([
                'codVeiculo' => $veiculoDocumentoCodVeiculo,
                'codDocumento' => $veiculoDocumentoodDocumento,
                'exercicio' => $veiculoDocumentoExercicio
            ]);

            if (count($veiculoDocumentoEmpenho) > 0) {
                $fieldOptions['situacao']['data'] = true;
                $fieldOptions['exercicioEmpenho']['data'] = $veiculoDocumentoEmpenho->getExercicioEmpenho();
                $fieldOptions['codEmpenho']['data'] = $veiculoDocumentoEmpenho->getCodEmpenho();

                $entidade = $em->getRepository(Entidade::class)->findOneBy([
                    'codEntidade' => $veiculoDocumentoEmpenho->getCodEntidade(),
                    'exercicio' => $veiculoDocumentoExercicio
                ]);

                $fieldOptions['codEntidade']['data'] = $entidade;
            }

            $tipo = 'text';
        }

        $formMapper
            ->add('veiculo', 'entity', $fieldOptions['veiculo'])
            ->add('codVeiculo', 'hidden', $fieldOptions['codVeiculo'])
            ->add('codDocumento', $tipo, $fieldOptions['codDocumento'])
            ->add('exercicio', 'text', $fieldOptions['exercicio'])
            ->add('mes', 'entity', $fieldOptions['mes'])
            ->add('situacao', 'checkbox', $fieldOptions['situacao'])
            ->add('exercicioEmpenho', 'text', $fieldOptions['exercicioEmpenho'])
            ->add('codEntidade', 'entity', $fieldOptions['codEntidade'])
            ->add('codEmpenho', 'integer', $fieldOptions['codEmpenho']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('exercicio')
            ->add('mes');
    }
}
