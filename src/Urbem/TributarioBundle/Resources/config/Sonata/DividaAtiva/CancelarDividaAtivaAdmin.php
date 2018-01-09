<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\DividaAtiva;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Divida\DividaAtiva;
use Urbem\CoreBundle\Entity\Divida\DividaCancelada;
use Urbem\CoreBundle\Entity\Divida\ProcessoCancelamento;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\Divida\EstornarDividaAtivaModel;
use Urbem\CoreBundle\Model\SwAssuntoModel;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CancelarDividaAtivaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_divida_ativa_cancelar_divida_ativa';
    protected $baseRoutePattern = 'tributario/divida-ativa/cancelar-divida-ativa';
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Cancelar'];

    /**
    * @return array
    */
    public function getIncludeJs()
    {
        $includeJs = [];

        if ($this->isCurrentRoute('create')) {
            $includeJs[] = '/core/javascripts/sw-processo.js';
        }

        return $includeJs;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $form = $this->getForm();

        $dividaAtiva = $this->cancelarDividaAtiva();

        $container = $this->getConfigurationPool()->getContainer();
        $successMessage = sprintf(
            $this->getTranslator()->trans('label.dividaAtivaCancelarDividaAtiva.sucesso'),
            $dividaAtiva->getCodInscricao(),
            $dividaAtiva->getExercicio()
        );
        $container->get('session')->getFlashBag()->add('success', $successMessage);

        $redirectUrl = $this->generateObjectUrl('create', $object);
        if ($form->get('emitirTermo')->getData()) {
            $redirectUrl = $this->generateObjectUrl(
                'detalhe',
                $object,
                [
                    'dividaAtiva' => sprintf('%d~%d', $dividaAtiva->getExercicio(), $dividaAtiva->getCodInscricao()),
                ]
            );
        }

        $this->modelManager->getEntityManager($this->getClass())->clear();

        return (new RedirectResponse($redirectUrl, RedirectResponse::HTTP_TEMPORARY_REDIRECT))->send();
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add('detalhe', 'detalhe');

        $routes->clearExcept(['create', 'detalhe']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions = [];
        $fieldOptions['dividaAtiva'] = [
            'class' => DividaAtiva::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join('o.fkDividaDividaCgns', 'divida_cgm');
                $qb->join('divida_cgm.fkSwCgm', 'cgm');

                $qb->andWhere('(o.codInscricao = :codInscricao OR o.exercicio = :exercicio OR LOWER(cgm.nomCgm) LIKE :nomCgm)');
                $qb->setParameter('codInscricao', (int) $term);
                $qb->setParameter('exercicio', (int) $term);
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));

                $qb->andWhere(
                    sprintf(
                        'CONCAT(o.codInscricao, \'~\', o.exercicio) NOT IN (SELECT CONCAT(divida_cancelada.codInscricao, \'~\', divida_cancelada.exercicio) FROM %s divida_cancelada)',
                        DividaCancelada::class
                    )
                );

                $qb->addOrderBy('o.codInscricao', 'ASC');
                $qb->addOrderBy('o.exercicio', 'ASC');

                return $qb;
            },
            'json_choice_label' => function (DividaAtiva $dividaAtiva) {
                return sprintf(
                    '%d/%d - %s',
                    $dividaAtiva->getCodInscricao(),
                    $dividaAtiva->getExercicio(),
                    $dividaAtiva->getFkDividaDividaCgns()->last()->getFkSwCgm()
                );
            },
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaCancelarDividaAtiva.inscricaoAno',
        ];

        $fieldOptions['motivo'] = [
            'mapped' => false,
            'label' => 'label.dividaAtivaCancelarDividaAtiva.motivo',
        ];

        $fieldOptions['fkSwClassificacao'] = [
            'class' => SwClassificacao::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters processo-classificacao',
            ],
            'label' => 'label.dividaAtivaCancelarDividaAtiva.classificacao',
        ];

        $fieldOptions['fkSwAssunto'] = [
            'class' => SwAssunto::class,
            'mapped' => false,
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters processo-assunto',
            ],
            'label' => 'label.dividaAtivaCancelarDividaAtiva.assunto',
        ];

        $fieldOptions['processos'] = [
            'class' => SwProcesso::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.codProcesso = :codProcesso');
                $qb->setParameter('codProcesso', 0);

                return $qb;
            },
            'required' => false,
            'placeholder' => 'Selecione',
            'label' => 'label.dividaAtivaCancelarDividaAtiva.processo',
        ];

        $fieldOptions['emitirTermo'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.dividaAtivaCancelarDividaAtiva.emitirTermo',
        ];

        $formMapper
            ->with('label.dividaAtivaCancelarDividaAtiva.cabecalhoFiltro')
                ->add('dividaAtiva', 'autocomplete', $fieldOptions['dividaAtiva'])
                ->add('motivo', 'textarea', $fieldOptions['motivo'])
                ->add('emitirTermo', 'checkbox', $fieldOptions['emitirTermo'])
            ->end()
            ->with('label.dividaAtivaCancelarDividaAtiva.cabecalhoProcesso')
                ->add('codClassificacao', 'entity', $fieldOptions['fkSwClassificacao'])
                ->add('codAssunto', 'entity', $fieldOptions['fkSwAssunto'])
                ->add('codProcesso', 'entity', $fieldOptions['processos'])
            ->end();

        $processoModel = new SwProcessoModel($em);
        $assuntoModel = new SwAssuntoModel($em);
        $admin = $this;

        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $assuntoModel) {
                $form = $event->getForm();
                $data = $event->getData();

                if (isset($data['codAssunto']) && $data['codAssunto'] != "") {
                    $assuntos = $assuntoModel->findByCodClassificacao($data['codClassificacao']);

                    $dados = array();
                    foreach ($assuntos as $assunto) {
                        $choiceKey = (string) $assunto;
                        $choiceValue = $assuntoModel->getObjectIdentifier($assunto);

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $comAssunto = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codAssunto', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.bem.codAssunto',
                            'mapped' => false,
                        ]);

                    $form->add($comAssunto);
                }
            }
        );

        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $processoModel) {
                $form = $event->getForm();
                $data = $event->getData();

                if (strpos($data['codAssunto'], '~')) {
                    list($codAssunto, $codClassificacao) = explode('~', $data['codAssunto']);
                } else {
                    $codAssunto = $data['codAssunto'];
                    $codClassificacao = $data['codClassificacao'];
                }

                if (isset($data['codProcesso']) && $data['codProcesso'] != "") {
                    $processos = $processoModel->getProcessoByClassificacaoAndAssunto($codClassificacao, $codAssunto);

                    $dados = array();
                    foreach ($processos as $processo) {
                        $processoCompleto = $processo->cod_processo_completo;
                        $processoAssunto = " | " . $processo->nom_assunto;

                        $choiceKey = $processoCompleto . $processoAssunto;
                        $choiceValue = $processo->cod_processo.'~'.$processo->ano_exercicio;

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $comProcesso = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codProcesso', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.bem.procAdministrativo',
                            'mapped' => false,
                        ]);

                    $form->add($comProcesso);
                }
            }
        );
    }

    /**
    * @return DividaAtiva
    */
    public function cancelarDividaAtiva()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();
        $dividaAtiva = $form->get('dividaAtiva')->getData();

        $dividaCancelada = (new DividaCancelada())
            ->setMotivo($form->get('motivo')->getData())
            ->setFkAdministracaoUsuario($this->getCurrentUser())
            ->setFkDividaDividaAtiva($dividaAtiva);

        if ($form->get('codProcesso')->getData()) {
            list($codProcesso, $anoExercicio) = explode('~', $form->get('codProcesso')->getData());
            $processo = $em->getRepository(SwProcesso::class)->findOneBy(['codProcesso' => $codProcesso,'anoExercicio' => $anoExercicio]);
            $processoCancelamento = (new ProcessoCancelamento())
                ->setFkSwProcesso($processo)
                ->setFkDividaDividaCancelada($dividaCancelada);

            $dividaCancelada->setFkDividaProcessoCancelamento($processoCancelamento);
        }

        $dividaAtiva->setFkDividaDividaCancelada($dividaCancelada);

        $em->persist($dividaAtiva);
        $em->flush();

        return $dividaAtiva;
    }

    /**
    * @param DividaAtiva $dividaAtiva
    */
    public function emitirDocumentos(DividaAtiva $dividaAtiva)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $model = new EstornarDividaAtivaModel($em);

        foreach ($dividaAtiva->getFkDividaDividaParcelamentos() as $dividaParcelamento) {
            $model->emitirDocumentos($dividaParcelamento->getFkDividaParcelamento());
        }
    }

    /**
    * @param null|object $object
    * @return string
    */
    public function toString($object)
    {
        $form = $this->getForm();
        $dividaAtiva = $form->get('dividaAtiva')->getData();

        if ($dividaAtiva) {
            return sprintf('%d/%d', $dividaAtiva->getCodInscricao(), $dividaAtiva->getExercicio());
        }

        return '';
    }
}
