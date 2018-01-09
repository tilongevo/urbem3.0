<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class PublicacaoAtaAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $formMapperOptions = [];
        $formMapperOptions['fkLicitacaoVeiculosPublicidade'] = [
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.ata.publicacao.numcgm',
            'required' => true,
            'property' => 'fkSwCgm.nomCgm',
            'placeholder' => 'Selecione',
            'multiple' => false,
            'callback' => function ($admin, $property, $value) use ($entityManager) {
                $datagrid = $admin->getDatagrid();
                $query =  $datagrid->getQuery();
                $alias = $query->getRootAlias();
                $query
                    ->join(SwCgm::class, 'cgm', 'WITH', "cgm.numcgm = $alias.numcgm")
                    ->andWhere('LOWER(cgm.nomCgm) LIKE :nomCgm')
                    ->setParameter('nomCgm', '%'.strtolower($value).'%')
                ;
                $datagrid->setValue($property, null, $value);
            },
            'to_string_callback' => function (VeiculosPublicidade $veiculosPublicidade, $property) {
                return strtoupper($veiculosPublicidade->getFkSwCgm()->getNomCgm());
            }
        ];
        $formMapperOptions['dtPublicacao'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.ata.publicacao.dtPublicacao',
            'required' => true,
            'widget' => 'single_text'
        ];
        $formMapperOptions['numPublicacao'] = [
            'label' => 'label.ata.publicacao.numPublicacao',
        ];
        $formMapperOptions['observacao'] = [
            'label' => 'label.ata.publicacao.observacao',
        ];

        $formMapper
            ->add('fkLicitacaoVeiculosPublicidade', 'sonata_type_model_autocomplete', $formMapperOptions['fkLicitacaoVeiculosPublicidade'], ['admin_code' => 'core.admin.veiculos_publicidade'])
            ->add('dtPublicacao', 'sonata_type_date_picker', $formMapperOptions['dtPublicacao'])
            ->add('numPublicacao', null, $formMapperOptions['numPublicacao'])
            ->add('observacao', 'textarea', $formMapperOptions['observacao']);
    }
}
