<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Ima\ConsignacaoBanrisulLiquido;
use Urbem\CoreBundle\Entity\Ima\ConsignacaoBanrisulRemuneracao;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Ima\ConsignacaoBanrisulLiquidoModel;
use Urbem\CoreBundle\Model\Ima\ConsignacaoBanrisulRemuneracaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConsignacaoBanrisulRemuneracaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_informacoes_configuracao_consignacao_banrisul';
    protected $baseRoutePattern = 'recursos-humanos/informacoes/configuracao/consignacao/banrisul';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $eventos = $eventosLiquido = [];

        /** @var ConsignacaoBanrisulRemuneracao $remuneracoes */
        $remuneracoes = $em->getRepository(ConsignacaoBanrisulRemuneracao::class)->findAll();

        if (!empty($remuneracoes)) {
            /** @var ConsignacaoBanrisulRemuneracao $remuneracao */
            foreach ($remuneracoes as $remuneracao) {
                $eventos[] = $remuneracao->getFkFolhapagamentoEvento();
            }
        }

        /** @var ConsignacaoBanrisulLiquido $liquidos */
        $liquidos = $em->getRepository(ConsignacaoBanrisulLiquido::class)->findAll();

        if (!empty($liquidos)) {
            /** @var ConsignacaoBanrisulLiquido $liquido */
            foreach ($liquidos as $liquido) {
                $eventosLiquido[] = $liquido->getFkFolhapagamentoEvento();
            }
        }

        $fieldOptions['codEventoRemuneracao'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Evento::class,
            'label' => 'Evento',
            'mapped' => false,
            'multiple' => true,
            'placeholder' => $this->trans('label.selecione'),
            'required' => true,
            'query_builder' => function (EntityRepository $repo) {
                $queryBuilder = $repo->createQueryBuilder("evento");
                return $queryBuilder
                    ->where(
                        $queryBuilder->expr()->In("evento.natureza", ['P', 'B'])
                    )->orderBy('evento.descricao');
            },
            'data' => $eventos
        ];

        $fieldOptions['codEventoLiquido'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Evento::class,
            'label' => 'Evento',
            'mapped' => false,
            'multiple' => true,
            'placeholder' => $this->trans('label.selecione'),
            'required' => true,
            'query_builder' => function (EntityRepository $repo) {
                $queryBuilder = $repo->createQueryBuilder("evento");
                return $queryBuilder
                    ->where(
                        $queryBuilder->expr()->In("evento.natureza", ['D'])
                    )->orderBy('evento.descricao');
            },
            'data' => $eventosLiquido
        ];

        $formMapper
            ->with('Base de Remuneração')
            ->add('codEventoRemuneracao', 'entity', $fieldOptions['codEventoRemuneracao'])
            ->end()
            ->with('Base do Liquido')
            ->add('codEventoLiquido', 'entity', $fieldOptions['codEventoLiquido'])
            ->end();
    }

    /**
     * @param ConsignacaoBanrisulRemuneracao $consignacao
     */
    public function prePersist($consignacao)
    {

        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var EventoModel $eventoModel */
        $eventoModel = new EventoModel($em);
        $container = $this->getConfigurationPool()->getContainer();
        try {
            /** @var ConsignacaoBanrisulLiquidoModel $consignacaoBanrisulLiquidoModel */
            $consignacaoBanrisulLiquidoModel = new ConsignacaoBanrisulLiquidoModel($em);
            $consignacaoBanrisulLiquidoModel->removeConsignacaoBanrisulLiquido();

            /** @var ConsignacaoBanrisulRemuneracaoModel $consignacaoBanrisulRemuneracaoModel */
            $consignacaoBanrisulRemuneracaoModel = new ConsignacaoBanrisulRemuneracaoModel($em);
            $consignacaoBanrisulRemuneracaoModel->removeConsignacaoBanrisulRemuneracao();

            foreach ($formData['codEventoRemuneracao'] as $eventoRemuneracao) {
                $evento = $eventoModel->getEventoByCodEvento($eventoRemuneracao);
                $consignacaoBanrisulRemuneracaoModel->createConsignacaoBanrisulRemuneracao($evento);
            }

            foreach ($formData['codEventoLiquido'] as $eventoLiquido) {
                $evento = $eventoModel->getEventoByCodEvento($eventoLiquido);
                $consignacaoBanrisulLiquidoModel->createConsignacaoBanrisulLiquido($evento);
            }

            $container->get('session')->getFlashBag()->add('success', $this->trans('flash_create_success'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
        }

        $this->redirectByRoute('urbem_recursos_humanos_informacoes_configuracao_consignacao_banrisul_create');
    }
}
