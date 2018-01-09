<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoModel;
use Urbem\CoreBundle\Repository\Patrimonio\Frota\ItemRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Frota;

use Urbem\CoreBundle\Model\Patrimonial\Frota\ItemModel;

/**
 * Class ClassificacaoCatalogoItemAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Frota
 */
class ClassificacaoCatalogoItemAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_classificacao_catalogo_item';
    protected $baseRoutePattern = 'patrimonial/frota/classificacao-catalogo-item';
    protected $model = ItemModel::class;
    protected $includeJs = [
        '/patrimonial/javascripts/frota/item.js',
    ];

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->getRequest()->getQueryString()) {
            $id = explode("=", $this->getRequest()->getQueryString());
        }

        $container = $this->getConfigurationPool()->getContainer();

        if ($this->getRequest()->isMethod('GET')) {
            $ids = explode("=", $this->getRequest()->getQueryString());

            if (! is_numeric($ids[1])) {
                $container->get('session')->getFlashBag()->add('error', 'Informe um catálogo válido.');
                $this->forceRedirect('/patrimonial/patrimonio/frota/item/');
            }
            $codCatalogo = $ids[1];
        } else {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codCatalogo = $formData['cod_catalogo'];
        }

        $this->setBreadCrumb($codCatalogo ? ['id' => $codCatalogo] : []);

        $info = array(
            'cod_catalogo' => $codCatalogo,
        );

        $em = $this->modelManager->getEntityManager('CoreBundle:Frota\Item');
        $ItemModel = new ItemModel($em);
        $classificacoes = $ItemModel->getClassificacaoCatalogo($info);

        if (count($classificacoes) == 0) {
            $container->get('session')->getFlashBag()->add('error', 'Catálogo informado não encontrado.');
            $this->forceRedirect('/patrimonial/patrimonio/frota/item/');
        }

        $fieldOptions['classificacao'] = [
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.item.classificacao',
            'placeholder' => 'Selecione',
            'multiple' => false,
            'mapped' => false,
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_catalogo_classificacao_search'],
            'req_params' => [
                'codCatalogo' => $codCatalogo
            ]
        ];

        $fieldOptions['codTipo'] = [
            'class' => Frota\TipoItem::class,
            'choice_label' => 'descricao',
            'label' => 'label.item.codTipo',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'mapped' => false,
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['codCombustivel'] = [
            'class' => Frota\Combustivel::class,
            'choice_label' => 'nomCombustivel',
            'label' => 'label.item.combustivel',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];

        $em = $this->modelManager->getEntityManager(Almoxarifado\Catalogo::class);
        $catalogoModel = new CatalogoModel($em);
        $objCatalogo = $catalogoModel->findOneBy([
            'codCatalogo' => $codCatalogo
        ]);

        $titulo = $this->trans('label.frotaManutencaoItem.classificacaoCatalogo', [], 'messages').' - '.
            $objCatalogo->getDescricao();

        $formMapper
            ->with($titulo)
                ->add(
                    'classificacao',
                    'autocomplete',
                    $fieldOptions['classificacao']
                )
                ->add(
                    'fkFrotaTipoItem',
                    'entity',
                    $fieldOptions['codTipo']
                )
                ->add(
                    'codCombustivel',
                    'entity',
                    $fieldOptions['codCombustivel']
                )
                ->add(
                    "cod_catalogo",
                    'hidden',
                    [
                        'mapped' => false,
                        'data' => $codCatalogo,
                    ]
                )
            ->end()
        ;
    }

    /**
     * @param Frota\Item $object
     * @param Form $form
     * @return mixed
     */
    public function saveRelationships($object, $form)
    {
        list($codClassificacao, $codCatalogo) = explode('~', $form->get('classificacao')->getData());
        $infos = [
            'codClassificacao'  => $codClassificacao,
            'codCatalogo'       => $codCatalogo,
            'codTipo'           => $form->get('fkFrotaTipoItem')->getData()->getCodTipo(),
            'codCombustivel'    => ($form->get('codCombustivel')->getData() ? $form->get('codCombustivel')->getData()->getCodCombustivel() : null)
        ];

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var ItemRepository $itemRepository */
        $itemRepository = $em->getRepository($this->getClass());
        return $itemRepository->processaItens($infos);
    }

    /**
     * @param Frota\Item $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $result = $this->saveRelationships($object, $this->getForm());

            if ($result) {
                $container->get('session')->getFlashBag()->add(
                    'success',
                    "Cadastro por Classificação do Catálogo processado com sucesso!"
                );
            } else {
                $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            }

            $this->forceRedirect('/patrimonial/frota/item/list');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $codCatalogo = explode("=", $this->getRequest()->getQueryString());
            $codCatalogo = $codCatalogo[1];
            $this->forceRedirect("/patrimonial/frota/classificacao-catalogo-item/create?id=".$codCatalogo);
        }
    }
}
