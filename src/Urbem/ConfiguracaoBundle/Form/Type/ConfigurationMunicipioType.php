<?php

namespace Urbem\ConfiguracaoBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Form\Transform\EntityTransform;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;

class ConfigurationMunicipioType extends ConfigurationAbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            /** @var SwMunicipio $swMunicipio */
            $swMunicipio = $event->getForm()->getData();

            if (false === $swMunicipio instanceof SwMunicipio) {
                return;
            }

            $this->getConfigurationFromFormEvent($event, $event->getForm()->getName())->setValor($swMunicipio->getCodMunicipio());
            $this->getConfigurationFromFormEvent($event, 'nom_municipio')->setValor($swMunicipio->getNomMunicipio());
        });

        /** @var EntityRepository $repo */
        $repo = $this->em->getRepository(SwMunicipio::class);

        $builder->addModelTransformer(
            new CallbackTransformer(
            /* transform */
                function ($codMunicipio) use ($repo, $options) {
                    $uf = $options['module']->getFkAdministracaoConfiguracoes('cod_uf', $options['year'], true)->getValor();

                    /** @var QueryBuilder $qb */
                    $qb = $repo->createQueryBuilder('SwMunicipio');
                    $qb->where('SwMunicipio.codMunicipio = :codMunicipio');
                    $qb->join('SwMunicipio.fkSwUf', 'fkSwUf');
                    $qb->andWhere(sprintf('fkSwUf.%s = :uf', true === is_numeric($uf) ? 'codUf' : 'siglaUf'));

                    $qb->setParameters([
                        'codMunicipio' => $codMunicipio,
                        'uf' => $uf
                    ]);

                    $qb->setMaxResults(1);

                    return $qb->getQuery()->getOneOrNullResult();
                },

                /* reverse */
                function ($swMunicipio) use ($repo) {
                    return (new EntityTransform($repo, $this->em->getClassMetadata(SwMunicipio::class)))->reverseTransform($swMunicipio)->first();
                }
            )
        );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefault('class', SwMunicipio::class);
        $resolver->setDefault('from_mapping', false);
        $resolver->setDefault('json_query_builder', function (EntityRepository $repository, $term, Request $request) use ($resolver) {
            $term = strtolower($term);
            $uf = $request->query->get('cascade_codUf');

            $qb = $repository->createQueryBuilder('SwMunicipio');
            $qb->join('SwMunicipio.fkSwUf', 'fkSwUf');
            $qb->where('LOWER(SwMunicipio.nomMunicipio) LIKE :term');
            $qb->andWhere(sprintf('fkSwUf.%s = :uf', true === is_numeric($uf) ? 'codUf' : 'siglaUf'));
            $qb->setParameters([
                'term' => "%{$term}%",

                /* src/Urbem/CoreBundle/Form/Type/AutoCompleteType.php:78 */
                'uf' => $uf,
            ]);

            return $qb;
        });
    }

    public function getParent()
    {
        return AutoCompleteType::class;
    }
}
