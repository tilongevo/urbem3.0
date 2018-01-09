<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\FeriasEvento;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Model\Folhapagamento\FeriasEventoModel;

class FeriasEventoAdmin extends AbstractAdmin
{
    /** @var string */
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_configurar_ferias';
    /** @var string */
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configurar-ferias';
    /** @var bool */
    protected $exibirBotaoIncluir = false;

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->clearExcept(['edit', 'create']);
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();

        $fields = $entityManager->getRepository("CoreBundle:Folhapagamento\TipoEventoFerias")
        ->findAll();

        $fieldOptions = [];

        foreach ($fields as $field) {
            $fieldName = 'stInner_Cod_' . $field->getCodTipo();

            $fieldOptions[$fieldName] = [
                'class' => Evento::class,
                'json_from_admin_code' => $this->code,
                'json_query_builder' => function (EntityRepository $repo, $term, Request $request) use ($entityManager) {
                    return (new FeriasEventoModel($entityManager))
                    ->getEventosByNaturezaQuery($request);
                },
                'req_params' => [
                    'natureza' => $field->getNatureza()
                ],
                'label' => $field->getDescricao(),
                'mapped' => false
            ];

            $feriasEvento = $entityManager->getRepository("CoreBundle:Folhapagamento\FeriasEvento")
            ->findOneEventoByCodTipo([
                'codTipo' => $field->getCodTipo()
            ]);

            if ($feriasEvento) {
                $fieldOptions[$fieldName]['data'] = $feriasEvento->getFkFolhapagamentoEvento();
            }

            $formMapper
                ->add(
                    $fieldName,
                    'autocomplete',
                    $fieldOptions[$fieldName]
                )
            ;
        }
    }
}
