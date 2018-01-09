<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Patrimonio\Bem;
use Urbem\CoreBundle\Entity\Patrimonio\SituacaoBem;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\InventarioHistoricoBem;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\InventarioHistoricoBemModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Patrimonio;

// use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\InventarioHistoricoBemAdminModel;

class InventarioHistoricoBemAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_patrimonio_inventario_historico_bem';
    protected $baseRoutePattern = 'patrimonial/patrimonio/inventario-historico-bem';

    protected $includeJs = [
        '/patrimonial/javascripts/patrimonio/inventario-historico-bem.js',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('get_item_info', 'get-item-info/');
        $collection->add('get_item_inventario_historico_bem', 'get-item-inventario-historico-bem/');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var Request $request */
        $request = $this->request;

        $inventarioObjectKey = $request->get('inventario');

        if (!$request->isMethod('GET')) {
            $formData = $request->request->get($this->getUniqid());
            $inventarioObjectKey = $formData['inventario'];
        }

        $fieldOptions['inventario'] = [
            'data' => $inventarioObjectKey,
            'mapped' => false
        ];

        list($exercicio, $idInventario) = explode('~', $inventarioObjectKey);

        $fieldOptions['exercicio'] = [
            'data' => $exercicio,
            'mapped' => false
        ];

        $fieldOptions['idInventario'] = [
            'data' => $idInventario,
            'mapped' => false
        ];

        // De
        $fieldOptions['codBem'] = [
            'class' => Bem::class,
            'choice_label' => function (Bem $bem) {
                return $bem->getCodBem() . ' - ' . $bem->getDescricao();
            },
            'label' => 'label.inventarioHistoricoBem.codBem',
            'attr' => ['class' => 'select2-parameters '],
            'placeholder' => $this->trans('label.selecione'),
        ];

        $fieldOptions['codOrgaoDe'] = [
            'label' => 'label.inventarioHistoricoBem.codOrgaoDe',
            'attr' => ['readonly' => 'readonly'],
            'mapped' => false
        ];

        $fieldOptions['codLocalDe'] = [
            'label' => 'label.inventarioHistoricoBem.codLocalDe',
            'attr' => ['readonly' => 'readonly'],
            'mapped' => false
        ];

        // Para
        $em = $this->modelManager->getEntityManager($this->getClass());
        $organogramaModel = new OrganogramaModel($em);
        $organoAtivo = $organogramaModel->getOrganogramaVigentePorTimestamp();
        $orgOrgao = $organogramaModel->listarOrgaosRelacionadosDescricaoComponente($organoAtivo['cod_organograma']);

        $orgOgaosChoices = array();

        foreach ($orgOrgao as $org) {
            $choiceKey = $org['orgao'] . ' - ' . $org['descricao'] ;
            $choiceValue = $org['cod_orgao'];

            $orgOgaosChoices[$choiceKey] = $choiceValue;
        }

        $fieldOptions['codOrgao'] = [
            'label' => 'label.inventarioHistoricoBem.codOrgao',
            'mapped' => false,
            'choices' => $orgOgaosChoices,
            'attr' => ['class' => 'select2-parameters '],
            'placeholder' => $this->trans('label.selecione'),
        ];

        $fieldOptions['codLocal'] = [
            'class' => Local::class,
            'query_builder' => function (EntityRepository $entityRepository) {
                $qb = $entityRepository->createQueryBuilder('o');
                $qb->orderBy('o.descricao');
                return $qb;
            },
            'choice_label' => function (Local $local) {
                return $local->getCodLocal() . ' - ' . $local->getDescricao();
            },
            'label' => 'label.inventarioHistoricoBem.codLocal',
            'attr' => ['class' => 'select2-parameters '],
            'placeholder' => $this->trans('label.selecione'),
        ];

        $fieldOptions['codSituacao'] = [
            'class' => SituacaoBem::class,
            'choice_label' => function (SituacaoBem $situacaoBem) {
                return $situacaoBem->getCodSituacao() . ' - ' . $situacaoBem->getNomSituacao();
            },
            'label' => 'label.inventarioHistoricoBem.codSituacao',
            'attr' => ['class' => 'select2-parameters '],
            'placeholder' => $this->trans('label.selecione'),
        ];

        $fieldOptions['codBem'] = [
            'label' => 'Bem',
            'multiple' => false,
            'mapped' => false,
            'required' => false,
            'route' => ['name' => 'patrimonio_carrega_bem']
        ];

        $formMapper
            ->with('label.inventarioHistoricoBem.dadosBem')
            ->add('inventario', 'hidden', $fieldOptions['inventario'])
            ->add('exercicio', 'hidden', $fieldOptions['exercicio'])
            ->add('idInventario', 'hidden', $fieldOptions['idInventario'])
            ->add('codBem', 'autocomplete', $fieldOptions['codBem'], ['admin_code' => 'app.admin.patrimonial.bem'])
            ->add('codOrgaoDe', 'text', $fieldOptions['codOrgaoDe'])
            ->add('codLocalDe', 'text', $fieldOptions['codLocalDe'])
            ->end()
            ->with('label.inventarioHistoricoBem.moverBem')
            ->add('codOrgao', 'choice', $fieldOptions['codOrgao'])
            ->add('codLocal', 'entity', $fieldOptions['codLocal'])
            ->add('codSituacao', 'entity', $fieldOptions['codSituacao'])
            ->add('descricao', 'textarea', [
                'label' => 'label.inventarioHistoricoBem.descricao'
            ])
            ->end();
    }

    /**
     * @param Patrimonio\InventarioHistoricoBem $object
     * @param Form $form
     */
    public function saveRelationships($object, $form)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $codOrgao = $form->get('codOrgao')->getData();
        $inventarioKey = $form->get('inventario')->getData();
        list($exercicio, $idInventario) = explode('~', $inventarioKey);

        $bem = $em->getRepository('CoreBundle:Patrimonio\Bem')
            ->findOneBy([
                'codBem' => $form->get('codBem')->getData()
            ]);

        $orgao = $em->getRepository('CoreBundle:Organograma\Orgao')
            ->findOneBy([
                'codOrgao' => $codOrgao
            ]);

        $inventario = $em->getRepository('CoreBundle:Patrimonio\Inventario')
            ->findOneBy([
                'idInventario' => $idInventario,
                'exercicio' => $exercicio
            ]);

        $inventarioHistoricoBemModel = new InventarioHistoricoBemModel($em);
        $inventarioHistoricoBemModel->findOrCreateInventarioHistoricoBem($object, $bem, $orgao, $inventario);
    }

    /**
     * @param Patrimonio\InventarioHistoricoBem $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());
            $form = $this->getForm();
            $inventarioKey = $form->get('inventario')->getData();
            list($exercicio, $idInventario) = explode('~', $inventarioKey);

            $inventario = $em->getRepository('CoreBundle:Patrimonio\Inventario')
                ->findOneBy([
                    'idInventario' => $idInventario,
                    'exercicio' => $exercicio
                ]);

            $this->redirect($inventario, $this->trans('patrimonial.inventarioHistoricoBem.success', [], 'flashes'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/patrimonio/inventario-historico-bem/create?idInventario={$object->getIdInventario()}&exercicio={$object->getExercicio()}");
        }
    }

    /**
     * @param Patrimonio\InventarioHistoricoBem $object
     * @param $message
     */
    public function redirect($object, $message)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add('success', $message);

        $this->forceRedirect("/patrimonial/patrimonio/inventario/" . $object->getExercicio() . "~" . $object->getIdInventario() . "/show");
    }
}
