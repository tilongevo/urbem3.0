<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Entity\Compras;

use Urbem\CoreBundle\Model\Patrimonial\Compras\OrdemAnulacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\OrdemItemAnulacaoModel;

class OrdemAnulacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_ordem_anulacao';

    protected $baseRoutePattern = 'patrimonial/compras/ordem-anulacao';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $exercicio = $formData['exercicio'];
            $codEntidade = $formData['codEntidade'];
            $codOrdem = $formData['codOrdem'];
            $tipo = $formData['tipo'];
        } else {
            list($exercicio, $codEntidade, $codOrdem, $tipo) = explode('~', $id);
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $paramsOrdem = [];
        $paramsOrdem['exercicio'] = $exercicio;
        $paramsOrdem['codEntidade'] = $codEntidade;
        $paramsOrdem['codOrdem'] = $codOrdem;
        $paramsOrdem['tipo'] = $tipo;
        $ordem = $entityManager
            ->getRepository(Compras\Ordem::class)
            ->findOneBy($paramsOrdem);

        $fieldOptions['ordem'] = [
            'class' => 'CoreBundle:Compras\Ordem',
            'choice_label' => function (Compras\Ordem $ordem) {
                return $ordem->getCodOrdem().'/'.
                    $ordem->getExercicio();
            },
            'label' => 'label.ordemAnulacao.codOrdem',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'data' => $ordem,
            'mapped' => false,
            'disabled' => true,
            'required' => false
        ];

        $fieldOptions['codOrdem'] = [
            'data' => $ordem->getCodOrdem()
        ];

        $fieldOptions['codEntidade'] = [
            'data' => $ordem->getCodEntidade()
        ];

        $fieldOptions['exercicio'] = [
            'data' => $ordem->getExercicio()
        ];

        $fieldOptions['tipo'] = [
            'data' => $ordem->getTipo()
        ];

        $fieldOptions['codEmpenho'] = [
            'data' => $ordem->getCodEmpenho(),
            'mapped' => false,
        ];

        $fieldOptions['numcgmEntrega'] = [
            'data' => $ordem->getNumcgmEntrega(),
            'mapped' => false,
        ];

        $fieldOptions['dtOrdem'] = [
            'data' => $ordem->getTimestamp()->format('d/m/Y'),
            'label' => 'label.ordemAnulacao.dtOrdem',
            'mapped' => false,
            'disabled' => true,
            'required' => false
        ];

        $fieldOptions['entidade'] = [
            'data' => $ordem->getCodEntidade().' - '.
                $ordem->getFkEmpenhoEmpenho()->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm(),
            'label' => 'label.ordemAnulacao.codEmpenho',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
            'mapped' => false,
        ];

        $fieldOptions['empenho'] = [
            'data' => $ordem->getFkEmpenhoEmpenho()->getCodEmpenho().'/'.
                $ordem->getFkEmpenhoEmpenho()->getExercicio(),
            'label' => 'label.ordemAnulacao.codEmpenho',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
            'mapped' => false,
        ];

        $fieldOptions['numcgmEntregaString'] = [
            'data' => ($ordem->getFkSwCgm() ?
                $ordem->getFkSwCgm()->getNumcgm().' - '.
                    $ordem->getFkSwCgm()->getNomCgm() :
                '-'),
            'label' => 'label.ordemAnulacao.numcgmEntrega',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
            'mapped' => false,
        ];

        $fieldOptions['motivo'] = [
            'label' => 'label.ordemAnulacao.motivo',
        ];

        $formMapper
            ->with('label.ordemAnulacao.ordemCompra')
                ->add(
                    'ordem',
                    'entity',
                    $fieldOptions['ordem']
                )
                ->add(
                    'codOrdem',
                    'hidden',
                    $fieldOptions['codOrdem']
                )
                ->add(
                    'codEntidade',
                    'hidden',
                    $fieldOptions['codEntidade']
                )
                ->add(
                    'exercicio',
                    'hidden',
                    $fieldOptions['exercicio']
                )
                ->add(
                    'tipo',
                    'hidden',
                    $fieldOptions['tipo']
                )
                ->add(
                    'codEmpenho',
                    'hidden',
                    $fieldOptions['codEmpenho']
                )
                ->add(
                    'numcgmEntrega',
                    'hidden',
                    $fieldOptions['numcgmEntrega']
                )
                ->add(
                    'dtOrdem',
                    'text',
                    $fieldOptions['dtOrdem']
                )
                ->add(
                    'entidade',
                    'text',
                    $fieldOptions['entidade']
                )
                ->add(
                    'empenho',
                    'text',
                    $fieldOptions['empenho']
                )
                ->add(
                    'numcgmEntregaString',
                    'text',
                    $fieldOptions['numcgmEntregaString']
                )
                ->add(
                    'motivo',
                    'text',
                    $fieldOptions['motivo']
                )
            ->end()
            ->with('label.ordemAnulacao.itens');

        $ordemItens = $entityManager
            ->getRepository(Compras\OrdemItem::class)
            ->findBy($paramsOrdem);

        foreach ($ordemItens as $ordemItem) {
            /** @var Compras\OrdemItem $ordemItem */
            $formMapper
                ->add(
                    'codItem_'.$ordemItem->getCodItem(),
                    'text',
                    [
                        'data' => $ordemItem->getCodItem().' - '.$ordemItem->getFkEmpenhoItemPreEmpenho()->getNomItem(),
                        'label' => 'label.ordemAnulacao.codItem',
                        'mapped' => false,
                        'disabled' => true,
                        'required' => false
                    ]
                )
            ;
        }

        $formMapper
            ->end()
        ;
    }

    /**
     * @param Compras\OrdemAnulacao $object
     * @param Form $form
     */
    public function saveRelationships($object, $form)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        # Persiste OrdemAnulacao
        $OrdemAnulacaoModel = new OrdemAnulacaoModel($em);
        $object = $OrdemAnulacaoModel->persistOrdemAnulacao($object);

        # Persiste OrdemItemAnulacao
        $OrdemItemAnulacaoModel = new OrdemItemAnulacaoModel($em);
        $OrdemItemAnulacaoModel->persistOrdemItemAnulacao($object);
    }

    /**
     * @param Compras\OrdemAnulacao $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/compras/ordem-anulacao/create?id=".$this->getAdminRequestId());
        }
    }

    /**
     * @param Compras\OrdemAnulacao $object
     * @param $message
     */
    public function redirect($object, $message)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add('success', $message);

        $this->forceRedirect("/patrimonial/compras/ordem/list");
    }

    /**
     * @param Compras\OrdemAnulacao $object
     */
    public function postPersist($object)
    {
        $this->redirect($object, 'Ordem de Compra anulada com sucesso.');
    }
}
