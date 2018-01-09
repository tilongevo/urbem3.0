<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal\Assentamento;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Entity\Pessoal;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MovSefipSaidaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_assentamento_movsefipsaida';

    protected $baseRoutePattern = 'recursos-humanos/pessoal/assentamento/movsefipsaida';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ;
    }

    /**
     * Redireciona para a página show do Seifp
     *
     * @param Pessoal\MovSefipSaidaCategoria $movSefipSaida
     * @param string $message
     */
    protected function redirect(Pessoal\MovSefipSaidaCategoria $movSefipSaida)
    {
        $sefipSaida = $movSefipSaida->getFkPessoalMovSefipSaida();
        $urlId = $this->getObjectKey($sefipSaida);
        $this->forceRedirect("/recursos-humanos/pessoal/assentamento/sefip/{$urlId}/show");
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
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
        $codSefipSaidaUrl = (int) $this->getRequest()->get('codigoSefip');
        $codSefipSaidaobj = '';

        $em = $this->modelManager->getEntityManager($this->getClass());

        if ($codSefipSaidaUrl) {
            $codSefipObj = $em->getRepository('CoreBundle:Pessoal\MovSefipSaida')->findOneByCodSefipSaida($codSefipSaidaUrl);
            $codSefipSaidaobj = $codSefipObj->getCodSefipSaida();
        }

        if ($id) {
            $codArrVal = array_values(explode('~', $id));
            $codSefipSaidaobj = array_shift($codArrVal);
        }

        $formMapper
            ->add(
                'indicativo',
                'choice',
                [
                    'choices' => [
                        'Nulo' => null,
                        'sim' => 'S',
                        'nao' => 'N',
                        'Complementar' => 'C',
                    ],
                    'expanded' => false,
                    'multiple' => false,
                    'placeholder' => 'label.selecione',
                    'label' => 'label.indicativo',
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                ]
            )
            ->add('codSefipSaida', 'hidden', [
                'data' => $codSefipSaidaobj,
                'mapped' => false,
            ])
            ->add(
                'fkPessoalCategoria',
                'entity',
                [
                    'class' => 'CoreBundle:Pessoal\Categoria',
                    'choice_label' => 'descricao',
                    'label' => 'label.categoriaSefip',
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'data-sonata-select2' => false,
                        'class' => 'select2-parameters '
                    ]

                ]
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        $codMovSefipSaida = $this->getForm()->get('codSefipSaida')->getData();
        $em = $this->modelManager->getEntityManager($this->getClass());

        if ($codMovSefipSaida) {
            $codSefipObj = $em->getRepository('CoreBundle:Pessoal\MovSefipSaida')->findOneByCodSefipSaida($codMovSefipSaida);
            $object->setFkPessoalMovSefipSaida($codSefipObj);
        }
    }

    /**
     * @param $mensagem
     */
    protected function movimentacaoExists($mensagem)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add('error', $mensagem);
        (new RedirectResponse($this->request->headers->get('referer')))->send();
    }

    /**
     * {@inheritdoc}
     */
    public function preValidate($object)
    {
        $codMovSefipSaida = $this->getForm()->get('codSefipSaida')->getData();
        $em = $this->modelManager->getEntityManager($this->getClass());

        if ($object->getCodSefipSaida() === null) {
            $checkSefipCategoria = $em->getRepository('CoreBundle:Pessoal\MovSefipSaidaCategoria')
                ->findOneBy(
                    ['codSefipSaida' => $codMovSefipSaida,
                        'codCategoria' => $object->getCodCategoria()
                    ]
                );

            if ($checkSefipCategoria !== null) {
                $message = $this->trans('rh.pessoal.assentamento.sefip.existMovimentacao', [], 'flashes');
                $this->movimentacaoExists($message);
            }
        }
    }

    /**
     * @param mixed $object
     */
    public function postPersist($object)
    {
        $this->redirect($object);
    }

    /**
     * @param mixed $object
     */
    public function postUpdate($object)
    {
        $this->redirect($object);
    }

    /**
     * @param mixed $object
     */
    public function postRemove($object)
    {
        $this->redirect($object);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
        ;
    }
}
