<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Model\Administracao\AgenciaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Monetario;

/**
 * Class FornecedorContaAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Compras
 */
class FornecedorContaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_fornecedor_conta';
    protected $baseRoutePattern = 'patrimonial/compras/fornecedor/conta';

    protected $includeJs = [
        '/patrimonial/javascripts/compras/fornecedor-conta.js',
    ];

    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->remove('batch');
        $routeCollection->remove('show');
        $routeCollection->remove('export');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /**
         * Auxilia na execuÃ§ao das Models
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $route = $this->getRequest()->get('_sonata_name');
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $cgmFornecedor = $formData['cgmFornecedor'];
        } else {
            $cgmFornecedor = $this->request->get('cgm_fornecedor');
        }

        /**
         * @var Compras\Fornecedor $fornecedor
         */
        $fornecedor = !is_null($route) ? $entityManager->getRepository(Compras\Fornecedor::class)->find($cgmFornecedor) : null;

        $fieldOptions = [];
        $fieldOptions['fornecedor'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'class' => Compras\Fornecedor::class,
            'choice_label' => 'fkSwCgm.nomCgm',
            'disabled' => true,
            'data' => $fornecedor,
            'label' => 'label.fornecedor.cgmFornecedor',
            'mapped' => false
        ];
        $fieldOptions['cgmFornecedor'] = [
            'data' => is_null($fornecedor) ? $cgmFornecedor : $fornecedor->getFkSwCgm()->getNumcgm()
        ];

        $fieldOptions['codBanco'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'class' => Monetario\Banco::class,
            'choice_label' => function (Monetario\Banco $banco) {
                return "{$banco->getnumBanco()} - {$banco->getnomBanco()}";
            },
            'choice_value' => 'codBanco',
            'mapped' => false,
            'label' => 'label.fornecedor.codBanco',
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['codAgencia'] = [
            'attr' => [
                'class' => 'select2-parameters ',
                'data-related-from' => '_codBanco'
            ],
            'class' => Monetario\Agencia::class,
            'choice_label' => function (Monetario\Agencia $agencia) {
                return "{$agencia->getNumAgencia()} - {$agencia->getNomAgencia()}";
            },
            'choice_value' => 'codAgencia',
            'label' => 'label.fornecedor.codAgencia',
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['numConta'] = [
            'attr' => [
                'class' => 'select2-parameters ',
                'data-related-from' => '_codAgencia'
            ],
            'class' => Monetario\ContaCorrente::class,
            'choice_label' => 'numContaCorrente',
            'choice_value' => 'numContaCorrente',
            'label' => 'label.fornecedor.numConta',
            'placeholder' => 'label.selecione'
        ];
        $route = $this->getRequest()->get('_sonata_name');
        if ($this->baseRouteName . "_edit" == $route) {
            $entityManager = $this->modelManager->getEntityManager($this->getClass());
            list($numConta, $codBanco, $codAgencia, $cgmFornecedor) = explode('~', $id);

            /**
             * @var Compras\FornecedorConta $fornecedorConta
             */
            $fornecedorConta = $entityManager
                ->getRepository(Compras\FornecedorConta::class)
                ->findOneBy([
                    'numConta' => $numConta,
                    'codAgencia' => $codAgencia,
                    'codBanco' => $codBanco,
                    'cgmFornecedor' => $cgmFornecedor
                ]);

            $fieldOptions['cgmFornecedor']['data'] = $fornecedorConta->getFkComprasFornecedor()->getCgmFornecedor();
            $fieldOptions['codBanco']['data'] = $fornecedorConta->getFkMonetarioAgencia()->getFkMonetarioBanco();
            $fieldOptions['codAgencia']['data'] = $fornecedorConta->getFkMonetarioAgencia();

            $contaCorrenteSelected = $entityManager
                ->getRepository(Monetario\ContaCorrente::class)
                ->findOneBy(['numContaCorrente' => $fornecedorConta->getNumConta()]);


            $fieldOptions['numConta']['choice_attr'] = function (Monetario\ContaCorrente $contaCorrente, $key, $index) use ($contaCorrenteSelected) {
                if ($contaCorrente->getNumContaCorrente() == $contaCorrenteSelected->getNumContaCorrente()) {
                    return ['selected' => 'selected'];
                }

                return ['selected' => false];
            };
        }

        $formMapper
            ->with('label.fornecedor.contas')
            ->add('fornecedor', 'entity', $fieldOptions['fornecedor'])
            ->add('cgmFornecedor', 'hidden', $fieldOptions['cgmFornecedor'])
            ->add('codBanco', 'entity', $fieldOptions['codBanco'])
            ->add('codAgencia', 'entity', $fieldOptions['codAgencia'])
            ->add('numConta', 'entity', $fieldOptions['numConta'])
            ->end();
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        /**
         * Auxilia na execuÃ§ao das Models
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();
        $formData = $this->getRequest()->request->get($this->getUniqid());

        // Consulta duplicidade no registro para conta do mesmo fornecedor
        $fornecedorContaCadastrado = $entityManager
            ->getRepository(Compras\FornecedorConta::class)
            ->findOneBy(['numConta' => $formData['numConta'], 'cgmFornecedor' => $formData['cgmFornecedor']]);

        // Acontecendo a duplicidade...
        if (!is_null($fornecedorContaCadastrado)) {
            $message = $this->trans('fornecedor.contas.conta_cadastrada', [], 'validators');
            $errorElement->with('numConta')->addViolation($message)->end();
        }
    }

    /**
     * @param Compras\FornecedorConta $fornecedorConta
     */
    public function makeRelationships(Compras\FornecedorConta $fornecedorConta)
    {
        /**
         * Auxilia na execuÃ§ao das Models
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $fornecedor = $entityManager
            ->getRepository(Compras\Fornecedor::class)
            ->find($fornecedorConta->getCgmFornecedor());

        $form = $this->getForm();
        /** @var Monetario\Banco $banco */
        $banco = $form->get('codBanco')->getData();
        /** @var Monetario\Agencia $agencia */
        $agencia = $form->get('codAgencia')->getData();
        /** @var Monetario\ContaCorrente $conta */
        $conta = $form->get('numConta')->getData();

        $agenciaBanco = $entityManager
            ->getRepository(Monetario\Agencia::class)
            ->findOneBy(['codBanco' => $banco->getCodBanco(), 'codAgencia' => $agencia->getCodAgencia()]);

        $fornecedorConta->setNumConta($conta->getNumContaCorrente());
        $fornecedorConta->setFkComprasFornecedor($fornecedor);
        $fornecedorConta->setFkMonetarioAgencia($agenciaBanco);
    }

    /**
     * @param Compras\FornecedorConta $fornecedorConta
     */
    public function prePersist($fornecedorConta)
    {
        $this->makeRelationships($fornecedorConta);
    }

    /**
     * @param Compras\FornecedorConta $fornecedorConta
     */
    public function preUpdate($fornecedorConta)
    {
        $this->makeRelationships($fornecedorConta);
    }

    /**
     * @param Compras\Fornecedor $fornecedor
     * @param $message
     */
    public function redirect(Compras\Fornecedor $fornecedor)
    {
        $cgm = $fornecedor->getFkSwCgm()->getNumcgm();
        $this->forceRedirect("/patrimonial/compras/fornecedor/" . $cgm . "/show");
    }

    /**
     * @param Compras\FornecedorConta $fornecedorConta
     */
    public function postPersist($fornecedorConta)
    {
        $this->redirect($fornecedorConta->getFkComprasFornecedor());
    }

    /**
     * @param Compras\FornecedorConta $fornecedorConta
     */
    public function postUpdate($fornecedorConta)
    {
        $this->redirect($fornecedorConta->getFkComprasFornecedor());
    }

    /**
     * @param Compras\FornecedorConta $fornecedorConta
     */
    public function postRemove($fornecedorConta)
    {
        $this->redirect($fornecedorConta->getFkComprasFornecedor());
    }
}
