<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Licitacao;

class MembroAdicionalAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_patrimonial_licitacao_membro_adicional';
    protected $baseRoutePattern = 'patrimonial/licitacao/membro-adicional';

    protected $exibirBotaoIncluir = false;

    public function validate(ErrorElement $errorElement, $object)
    {

        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());

        list($codLicitacao, $codModalidade, $codEntidade, $execicio) = explode("~", $formData['codHLicitacao']);

        /** @var Licitacao\Licitacao $licitacao */
        $licitacao = $entityManager
            ->getRepository('CoreBundle:Licitacao\Licitacao')
            ->findOneBy(
                [
                    'codLicitacao' => $codLicitacao,
                    'codModalidade' => $codModalidade,
                    'codEntidade' => $codEntidade,
                    'exercicio' => $execicio,
                ]
            );

        if ($object->getNumCgm() != $formData['fkSwCgm']) {
            $mensagem = $this->trans('membroAdicional.errors.alreadyExists', [], 'validators');
            $errorElement->with('fkSwCgm')->addViolation($mensagem)->end();
        }
    }

    /**
     * @param Licitacao\MembroAdicional $object
     */
    public function prePersist($object)
    {
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());
        $codLicitacao = explode("~", $formData['codHLicitacao']);

        $licitacao = $entityManager
            ->getRepository('CoreBundle:Licitacao\Licitacao')
            ->findOneBy(
                [
                    'codLicitacao' => $codLicitacao[0],
                    'codModalidade' => $codLicitacao[1],
                    'codEntidade' => $codLicitacao[2],
                    'exercicio' => $codLicitacao[3],
                ]
            );
        $object->setFkLicitacaoLicitacao($licitacao);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('cargo');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('exercicio')
            ->add('cargo')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $id = $formData['codHLicitacao'];
        }

        $route = $this->getRequest()->get('_sonata_name');
        if ($this->baseRouteName . "_edit" == $route) {
            $entityManager = $this->modelManager
                ->getEntityManager($this->getClass());

            $id = $this->getObjectKey($this->getSubject()->getFkLicitacaoLicitacao());
        }

        $fieldOptions['numcgm'] = [
            'label' => 'label.patrimonial.licitacao.membroAdicional',
            'property' => 'nomCgm',
            'to_string_callback' => function (Entity\SwCgm $fornecedor, $property) {
                return (string) $fornecedor;
            },
        ];

        $formMapper
            ->add('codHLicitacao', 'hidden', ['data' => $id, 'mapped' => false])
            ->add(
                'fkSwCgm',
                'sonata_type_model_autocomplete',
                $fieldOptions['numcgm'],
                ['admin_code' => 'core.admin.filter.sw_cgm']
            )
            ->add('cargo')
            ->add(
                'fkLicitacaoNaturezaCargo',
                'entity',
                [
                    'class' => Licitacao\NaturezaCargo::class,
                    'label' => 'label.patrimonial.licitacao.codNatureza',
                    'choice_label' => function ($naturezaCargo) {
                        return $naturezaCargo->getDescricao();
                    },
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codEntidade')
            ->add('codModalidade')
            ->add('codLicitacao')
            ->add('exercicio')
            ->add('cargo');
    }

    public function postPersist($object)
    {
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());
        $codLicitacao = explode("~", $formData['codHLicitacao']);
        $licitacao = $entityManager
            ->getRepository('CoreBundle:Licitacao\Licitacao')
            ->findOneBy(
                [
                    'codLicitacao' => $codLicitacao[0],
                    'codModalidade' => $codLicitacao[1],
                    'codEntidade' => $codLicitacao[2],
                    'exercicio' => $codLicitacao[3],
                ]
            );

        $message = $this->trans('patrimonial.licitacao.membroAdicional.create', [], 'flashes');
        $this->redirect($licitacao, $message, 'success');
    }

    public function postUpdate($object)
    {
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());
        $codLicitacao = explode("~", $formData['codHLicitacao']);
        $licitacao = $entityManager
            ->getRepository('CoreBundle:Licitacao\Licitacao')
            ->findOneBy(
                [
                    'codLicitacao' => $codLicitacao[0],
                    'codModalidade' => $codLicitacao[1],
                    'codEntidade' => $codLicitacao[2],
                    'exercicio' => $codLicitacao[3],
                ]
            );

        $message = $this->trans('patrimonial.licitacao.membroAdicional.edit', [], 'flashes');
        $this->redirect($licitacao, $message, 'success');
    }

    public function postRemove($object)
    {
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $licitacao = $entityManager
            ->getRepository('CoreBundle:Licitacao\Licitacao')
            ->findOneByCodLicitacao($object->getCodLicitacao());

        $message = $this->trans('patrimonial.licitacao.membroAdicional.delete', [], 'flashes');
        $this->redirect($licitacao, $message, 'success');
    }

    public function redirect($licitacao, $message, $type = 'success')
    {
        $codLicitacao = $this->getObjectKey($licitacao);

        $message = $this->trans($message);
        $container = $this->getConfigurationPool()->getContainer();
        if ($type != 'success') {
            $container->get('session')->getFlashBag()->add($type, $message);
        }

        $this->forceRedirect("/patrimonial/licitacao/licitacao/" . $codLicitacao . "/show");
    }
}
