<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class ConvenioAditivosPublicacaoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class ConvenioAditivosPublicacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_convenio_aditivos_publicacao';
    protected $baseRoutePattern = 'patrimonial/licitacao/convenio/aditivos-publicacao';

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create', 'edit']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $formMapperOptions = [];

        $formMapperOptions['numcgm'] = [
            'callback' => function ($admin, $property, $value) use ($entityManager) {
                $datagrid = $admin->getDatagrid();
                $query = $datagrid->getQuery();

                $query
                    ->leftjoin(SwCgmPessoaFisica::class, 'cgm', 'WITH', "cgm.numcgm = {$query->getRootAlias()}.numcgm")
                    ->leftjoin(SwCgmPessoaJuridica::class, 'cgmJuridica', 'WITH', "cgmJuridica.numcgm = {$query->getRootAlias()}.numcgm")
                    ->join(VeiculosPublicidade::class, 'veiculo', 'WITH', "veiculo.numcgm = {$query->getRootAlias()}.numcgm")
                    ->andWhere("LOWER({$query->getRootAlias()}.nomCgm) LIKE :nomCgm")
                    ->setParameter('nomCgm', '%'.strtolower($value).'%')
                ;

                $datagrid->setValue($property, null, $value);
            },
            'container_css_class' => 'select2-v4-parameters ',
            'label' => 'label.convenioAdmin.publicacoes.numcgm',
            'property' => 'fkSwCgm.nomCgm',
        ];

        $now = new \DateTime();
        $formMapperOptions['dtPublicacao'] = [
            'dp_default_date' => $now->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'label' => 'label.convenioAdmin.publicacoes.dtPublicacao',
            'required' => true,
        ];

        $formMapperOptions['numPublicacao']['label'] = 'label.convenioAdmin.publicacoes.numPublicacao';
        $formMapperOptions['observacao']['label'] = 'label.convenioAdmin.publicacoes.observacao';
        $formMapperOptions['observacao']['required'] = 'true';

        $formMapper
            ->add('fkSwCgm', 'sonata_type_model_autocomplete', $formMapperOptions['numcgm'], ['admin_code' => 'core.admin.filter.sw_cgm'])
            ->add('dtPublicacao', 'datepkpicker', $formMapperOptions['dtPublicacao'])
            ->add('numPublicacao', null, $formMapperOptions['numPublicacao'])
            ->add('observacao', null, $formMapperOptions['observacao'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicioConvenio')
            ->add('numConvenio')
            ->add('numAditivo')
            ->add('dtPublicacao')
            ->add('numcgm')
            ->add('exercicio')
            ->add('observacao')
            ->add('numPublicacao')
        ;
    }
}
