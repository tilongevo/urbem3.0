<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityRepository;

use Symfony\Component\HttpFoundation\Request;

use Sonata\AdminBundle\Form\FormMapper;

use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class PublicacaoRescisaoConvenioAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class PublicacaoRescisaoConvenioAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $fieldOptions = [];
        $fieldOptions['fkSwCgm'] = [
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repository, $term, Request $request) {
                $queryBuilder = $repository->createQueryBuilder('swCgm');
                $queryBuilder
                    ->join('swCgm.fkLicitacaoVeiculosPublicidade', 'fkLicitacaoVeiculosPublicidade')
                    ->where(
                        $queryBuilder->expr()->like(
                            $queryBuilder->expr()->lower('swCgm.nomCgm'),
                            $queryBuilder->expr()->lower(':term')
                        )
                    )
                    ->setParameter('term', '%'.$term.'%')
                    ->orderBy('swCgm.nomCgm')
                ;

                return $queryBuilder;
            },
            'label' => 'label.convenioAdmin.rescisaoConvenio.publicacaoRescisaoConvenio.veiculoPublicacao'
        ];

        $fieldOptions['dtPublicacao'] = [
            'dp_default_date' => (new \DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'label' => 'label.convenioAdmin.rescisaoConvenio.publicacaoRescisaoConvenio.dtPublicacao',
            'required' => true,
        ];

        $fieldOptions['observacao'] = [
            'label' => 'label.convenioAdmin.rescisaoConvenio.publicacaoRescisaoConvenio.observacao',
            'required' => true
        ];

        $fieldOptions['numPublicacao'] = [
            'label' => 'label.convenioAdmin.rescisaoConvenio.publicacaoRescisaoConvenio.numPublicacao',
            'required' => false,
            'attr' => [
                'class' => 'numeric '
            ]
        ];

        $formMapper
            ->add('fkSwCgm', 'autocomplete', $fieldOptions['fkSwCgm'])
            ->add('dtPublicacao', 'datepkpicker', $fieldOptions['dtPublicacao'])
            ->add('observacao', 'text', $fieldOptions['observacao'])
            ->add('numPublicacao', 'number', $fieldOptions['numPublicacao'])
        ;
    }
}
