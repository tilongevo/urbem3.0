<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DatagridBundle\ProxyQuery\ProxyQueryInterface;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class GrupoUsuarioAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao
 */
class GrupoUsuarioAdmin extends AbstractSonataAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $fieldOptions = [];
        $fieldOptions['fkAdministracaoUsuario'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'callback'    => function (AbstractSonataAdmin $admin, $property, $value) {
                $datagrid = $admin->getDatagrid();

                /** @var QueryBuilder|ProxyQueryInterface $query */
                $query = $datagrid->getQuery();
                $rootAlias = $query->getRootAlias();

                $query
                    ->join("{$rootAlias}.fkSwCgm", "fkSwCgm")
                    ->andWhere(
                        $query->expr()->like(
                            $query->expr()->lower("fkSwCgm.nomCgm"),
                            $query->expr()->lower(":nomCgm")
                        )
                    )
                    ->setParameter("nomCgm", "%{$value}%")
                ;

                $datagrid->setValue($property, null, $value);
            },
            'class'       => Usuario::class,
            'label'       => 'Usuário',
            'placeholder' => $this->trans('label.selecione'),
            'property'    => 'nomCgm',
        ];

        $formMapper
            ->add('fkAdministracaoUsuario', 'sonata_type_model_autocomplete', $fieldOptions['fkAdministracaoUsuario'], [
                'admin_code' => 'administrativo.admin.usuario'
            ])
        ;
    }
}
