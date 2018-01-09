<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CentroCustoModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CentroCustoPermissaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class CentroCustoPermissaoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class CentroCustoPermissaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_centro_custo_permissao';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/centro-custo/permissao';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['edit', 'create']);

        $collection->add('search', 'search');
        $collection->add('create', 'definir');
        $collection->add('edit', '{id}/definir');
    }

    /**
     * @param ErrorElement $errorElement
     * @param Almoxarifado\CentroCustoPermissao $centroCustoPermissao
     */
    public function validate(ErrorElement $errorElement, $centroCustoPermissao)
    {

        /** @var ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        /** @var SwCgm $swCgm */
        $swCgm = $form->get('fkSwCgm')->getData();

        $centroCustoModel = new CentroCustoModel($entityManager);
        $centroCustos = $centroCustoModel->findCentroCustoByResponsavel($swCgm);

        /** @var ArrayCollection $centroCustosToSave */
        $centroCustosToSave = $form->get('centroCustos')->getData();

        /** @var Almoxarifado\CentroCusto $centroCusto */
        foreach ($centroCustos as $centroCusto) {
            if (false == $centroCustosToSave->contains($centroCusto)) {
                $message = $this->trans('centroCustoPermissao.erroExcluirPermissao', ['%centroCusto%'=>$centroCusto], 'messages');
                $errorElement->addViolation($message)->end();
            }
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $objectId = $this->getAdminRequestId();

        /** @var Almoxarifado\CentroCustoPermissao|null $centroCustoPermissao */
        $centroCustoPermissao = $this->getSubject();

        /** @var ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $this->setBreadCrumb($objectId ? ['id' => $objectId] : []);
        $this->setIncludeJs(['/patrimonial/javascripts/almoxarifado/centro-custo-permissao.js']);

        $fieldOptions = [];
        $fieldOptions['fkSwCgm'] = [
            'label' => 'label.cgm',
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (ORM\EntityRepository $repository, $term, Request $request) {
                $queryBuilder = $repository->createQueryBuilder('swCgm');
                $queryBuilder
                    ->join('swCgm.fkAdministracaoUsuario', 'usuarios');
                if (!is_numeric($term)) {
                    $queryBuilder->where(
                        $queryBuilder->expr()->like(
                            $queryBuilder->expr()->lower('swCgm.nomCgm'),
                            $queryBuilder->expr()->lower(':term')
                        )
                    )
                        ->setParameter('term', '%'.$term.'%');
                } else {
                    $term = (int) $term;
                    $queryBuilder
                        ->where('swCgm.numcgm = :term')
                        ->setParameter('term', $term);
                }

                $queryBuilder->orderBy('swCgm.nomCgm');
                return $queryBuilder;
            }
        ];

        $fieldOptions['responsavel'] = [
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata']
        ];

        $fieldOptions['centroCustos'] = [
            'attr' => ['class' => 'select2-parameters centro-custo '],
            'class' => Almoxarifado\CentroCusto::class,
            'label' => 'label.patrimonial.almoxarifado.centrodecusto.centrosDeCustos',
            'multiple' => true,
            'mapped' => false,
            'help' => '<div class="spinner-load-hide spinner-load "><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>'
        ];

        $withContainerOptions = [];
        $withContainerOptions['centroCustos'] = [
            'class' => 'hidden centro-custo-container'
        ];

        if (!is_null($centroCustoPermissao) && !is_null($centroCustoPermissao->getCodCentro())) {
            $withContainerOptions['centroCustos']['class'] = '';

            list($codCentro, $numcgm) = explode('~', $objectId);

            $centroCustosPermissoes = $entityManager
                ->getRepository(Almoxarifado\CentroCustoPermissao::class)
                ->findBy(['numcgm' => $numcgm]);

            $fieldOptions['centroCustos']['choice_attr'] =
                function (Almoxarifado\CentroCusto $centroCusto, $key, $index) use ($centroCustosPermissoes) {
                    /** @var Almoxarifado\CentroCustoPermissao $centroCustoPermissao */
                    foreach ($centroCustosPermissoes as $centroCustoPermissao) {
                        if ($centroCustoPermissao->getCodCentro() == $centroCusto->getCodCentro()) {
                            return [
                                'selected' => 'selected',
                            ];
                        }
                    }

                    return ['selected' => false];
                };
        }

        $formMapper
            ->with('Dados Para Permissão')
            ->add('fkSwCgm', 'autocomplete', $fieldOptions['fkSwCgm'], ['admin_code' => 'core.admin.filter.sw_cgm'])
            ->end()
            ->with('Centros de Custos', $withContainerOptions['centroCustos'])
            ->add('centroCustos', 'entity', $fieldOptions['centroCustos'])
            ->end();
    }

    public function savePermissoes()
    {
        /** @var ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        /** @var SwCgm $swCgm */
        $swCgm = $form->get('fkSwCgm')->getData();

        $centroCustoPermissaoModel = new CentroCustoPermissaoModel($entityManager);

        /** @var Almoxarifado\CentroCusto $centroCusto */
        foreach ($form->get('centroCustos')->getData() as $centroCusto) {
            $centroCustoPermissao = $centroCustoPermissaoModel->findByCentroCusto($centroCusto, $swCgm);
            $centroCustoPermissaoModel->createOrUpdateWithCentroCusto($centroCusto, $swCgm, $centroCustoPermissao);
        }

        $this->redirect();
    }

    public function updatePermissoes()
    {
        /** @var ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        /** @var SwCgm $swCgm */
        $swCgm = $form->get('fkSwCgm')->getData();

        /** @var ArrayCollection $centroCustosToSave */
        $centroCustosToUpdate = $form->get('centroCustos')->getData();

        $centroCustoModel = new CentroCustoModel($entityManager);
        $centroCustoPermissaoModel = new CentroCustoPermissaoModel($entityManager);

        $centroCustos = $centroCustoModel->findCentroCustoPermissaoByCgm($swCgm);

        /** @var Almoxarifado\CentroCusto $centroCusto */
        foreach ($centroCustos as $centroCusto) {
            if (false == $centroCustosToUpdate->contains($centroCusto)) {
                $centroCustoPermissaoModel
                    ->removeCentroCustoPermissao($swCgm->getNumcgm(), $centroCusto->getCodCentro());
            }
        }

        $this->savePermissoes();
    }

    /**
     * @param Almoxarifado\CentroCustoPermissao $centroCustoPermissao
     */
    public function prePersist($centroCustoPermissao)
    {
        $this->updatePermissoes();
    }

    /**
     * @param Almoxarifado\CentroCustoPermissao $centroCustoPermissao
     */
    public function preUpdate($centroCustoPermissao)
    {
        $this->updatePermissoes();
    }

    public function redirect()
    {
        $container = $this->getConfigurationPool()->getContainer();
        $message = $this->trans('patrimonial.almoxarifado.dotacao_permissao.edit', [], 'flashes');

        $container->get('session')
            ->getFlashBag()
            ->add('success', $message);

        $this->redirectByRoute('urbem_patrimonial_almoxarifado_centro_custo_list');
    }
}
