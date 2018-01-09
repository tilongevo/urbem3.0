<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\SwProcessoModel;

/**
 * Class EntradaDoacaoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class EntradaDoacaoAdmin extends EntradaDiversosAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_entrada_doacao';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/entrada-doacao';

    protected $entrada = 'doacao';



    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $admin = $this;

        $this->includeJs = array_merge($this->includeJs, [
            '/patrimonial/javascripts/almoxarifado/entrada-doacao.js'
        ]);

        $fieldOptions['classificacao'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => SwClassificacao::class,
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'query_builder' => function (EntityRepository $entityRepository) {
                return $entityRepository
                    ->createQueryBuilder('sw_classificacao')
                    ->orderBy('sw_classificacao.codClassificacao');
            }
        ];

        $fieldOptions['assunto'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choices' => [], // Will be filled with ajax request
            'class' => SwAssunto::class,
            'disabled' => true,
            'mapped' => false,
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['processo'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => SwProcesso::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) use ($admin) {
                /** @var EntityManager $em */
                $entityManager = $admin->modelManager->getEntityManager(SwProcesso::class);

                /** @var SwAssunto $swAssunto */
                $swAssunto = $admin->modelManager->find(SwAssunto::class, $request->get('cod_assunto'));

                return (new SwProcessoModel($entityManager))
                    ->findProcessosByCgmAssuntoQuery($swAssunto, $request->get('q'));
            },
            'json_choice_label' => function (SwProcesso $swProcesso) {
                $processo = sprintf('%07s_%08s', $swProcesso->getCodProcesso(), $swProcesso->getAnoExercicio());
                $assunto = $swProcesso->getFkSwAssunto()->getNomAssunto();

                return sprintf('%s | %s', $processo, $assunto);
            },
            'req_params' => ['cod_assunto' => 'varJsCodAssunto'],
            'label' => 'label.entradaDoacao.codProcesso',
            'mapped' => false,
            'placeholder' => $this->trans('label.selecione'),
        ];

        $formMapper
            ->with('label.entradaDoacao.dadosProcesso')
                ->add('classificacao', 'entity', $fieldOptions['classificacao'])
                ->add('assunto', 'entity', $fieldOptions['assunto'])
                ->add('processo', 'autocomplete', $fieldOptions['processo'])
            ->end()
        ;

        parent::configureFormFields($formMapper);
    }
}
