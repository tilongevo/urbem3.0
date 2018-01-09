<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Tesouraria\SaldoTesouraria;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class SaldoTesourariaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_configuracao_implantar_saldo_inicial';
    protected $baseRoutePattern = 'financeiro/tesouraria/configuracao/implantar-saldo-inicial';
    protected $includeJs = ['/financeiro/javascripts/tesouraria/saldoTesouraria/saldoTesouraria.js'];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('contas_por_entidade', 'contas-por-entidade/');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $repository = $entityManager->getRepository('CoreBundle:Tesouraria\SaldoTesouraria');
        $contas = ArrayHelper::parseArrayToChoice($repository->findAllContasPorEntidade(null, $this->getExercicio()), 'nom_conta', 'cod_plano');

        $fieldOptions = array();

        $fieldOptions['fkOrcamentoEntidade'] = array(
            'class' => Entidade::class,
            'choice_value' => 'codEntidade',
            'label' => 'label.saldoTesouraria.entidade',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->where('o.exercicio = :exercicio')
                    ->setParameter('exercicio', $this->getExercicio())
                    ->orderBy('o.sequencia', 'ASC');
            }
        );

        $fieldOptions['codPlano'] = array(
            'mapped' => false,
            'required' => true,
            'choices' => $contas,
            'choice_value' => function ($value) {
                return $value;
            },
            'label' => 'label.saldoTesouraria.conta',
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['vlSaldo'] = array(
            'mapped' => false,
            'currency' => 'BRL',
            'required' => true,
            'label'=>'label.saldoTesouraria.valor'
        );

        $formMapper
            ->with('label.saldoTesouraria.dados')
            ->add('fkOrcamentoEntidade', 'entity', $fieldOptions['fkOrcamentoEntidade'])
            ->add('codPlano', 'choice', $fieldOptions['codPlano'])
            ->add('vlSaldo', 'money', $fieldOptions['vlSaldo'])
            ->add('exercicio', 'hidden', ['data' => $this->getExercicio()])
            ->end()
        ;
    }

    public function prePersist($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());

        $entity = $this->getDoctrine()
            ->getRepository(SaldoTesouraria::class)
            ->findOneBy(
                [
                    'codPlano' => $formData['codPlano'],
                    'exercicio' => $formData['exercicio']
                ]
            );

        $entity->setVlSaldo((float) $formData['vlSaldo']);

        if (!empty($entity)) {
            $this->getDoctrine()->persist($entity);
            $this->getDoctrine()->flush($entity);
            $this->redirectCreate();
        } else {
            $object->setExercicio($this->getExercicio());
        }
    }

    public function postPersist($object)
    {
        $this->redirectCreate();
    }

    public function redirectCreate()
    {
        $message = $this->trans('financeiro.implantarSaldo.create', [], 'flashes');
        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add('success', $message);
        $this->forceRedirect("/financeiro/tesouraria/configuracao/implantar-saldo-inicial/create");
    }

    public function toString($object)
    {
        return ($object->getCodPlano())
            ? (string) $object
            : $this->getTranslator()->trans('label.saldoTesouraria.modulo');
    }
}
