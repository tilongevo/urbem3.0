<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Cgm;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Repository\SwBairroRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class SwBairroLogradouroAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Cgm
 */
class SwBairroLogradouroAdmin extends AbstractSonataAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('fkSwBairro', 'autocomplete', [
                'attr' => ['class' => 'select2-parameters fkSwBairro '],
                'class' => SwBairro::class,
                'label' => 'label.swLogradouro.bairro',
                'json_choice_label' => function (SwBairro $swBairro) {
                    return $swBairro->getNomBairro();
                },
                'json_from_admin_code' => $this->code,
                'json_query_builder' =>
                    function (SwBairroRepository $repository, $term, Request $request) {
                        list($codMunicipio, $codUf) =
                            explode(ModelManager::ID_SEPARATOR, $request->get('fkSwMunicipio'));

                        $queryBuilder = $repository->createQueryBuilder('b');

                        return $queryBuilder
                            ->join('b.fkSwMunicipio', 'm')
                            ->where('m.codMunicipio = :cod_municipio')
                            ->andWhere('m.codUf = :cod_uf')
                            ->andWhere(
                                $queryBuilder->expr()->like(
                                    $queryBuilder->expr()->lower('b.nomBairro'),
                                    $queryBuilder->expr()->lower(':term')
                                )
                            )
                            ->setParameters([
                                'cod_municipio' => $codMunicipio,
                                'cod_uf' => $codUf,
                                'term' => "%{$term}%"
                            ]);
                    },
                'placeholder' => $this->trans('label.selecione'),
                'req_params' => [
                    'fkSwMunicipio' => 'varJsFkSwMunicipio'
                ], 'required' => true
            ]);
    }
}
