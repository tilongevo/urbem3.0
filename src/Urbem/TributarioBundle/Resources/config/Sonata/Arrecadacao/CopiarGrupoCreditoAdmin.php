<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Exception;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CopiarGrupoCreditoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_copiar_grupo_credito';
    protected $baseRoutePattern = 'tributario/arrecadacao/grupo-credito/copiar';
    protected $includeJs = ['/tributario/javascripts/arrecadacao/copiar-grupo-credito.js'];
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Copiar'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->clearExcept(['create']);
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $grupoCreditos = [];
        if ($grupoCredito = $this->getForm()->get('grupoCredito')->getData()) {
            $grupoCreditos[] = $grupoCredito;
        }

        if (!$grupoCreditos) {
            $grupoCreditos = $em->getRepository(GrupoCredito::class)->findByAnoExercicio($this->getForm()->get('exercicioOrigem')->getData());
        }

        foreach ($grupoCreditos as $grupoCredito) {
            $object = new GrupoCredito();
            $this->populateObject($object, $grupoCredito);
            $this->saveObject($object);
        }

        $this->forceRedirect('/tributario/arrecadacao/grupo-credito/copiar/create');
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        if (!$form->get('grupoCredito')->getData()) {
            return;
        }

        $grupoCredito = $em->getRepository(GrupoCredito::class)
            ->findOneBy(
                [
                    'codGrupo' => $form->get('grupoCredito')->getData()->getCodGrupo(),
                    'anoExercicio' => $form->get('exercicioDestino')->getData(),
                ]
            );

        if (!$grupoCredito) {
            return;
        }

        $error = $this->getTranslator()->trans('label.arrecadacaoCopiarGrupoCredito.erro');
        $errorElement->with('grupoCredito')->addViolation($error)->end();
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $qb = $em->getRepository(GrupoCredito::class)->createQueryBuilder('o');
        $exercicios = array_column($qb->select('o.anoExercicio')->groupBy('o.anoExercicio')->orderBy('o.anoExercicio', 'DESC')->getQuery()->getResult(), 'anoExercicio');

        $fieldOptions = [];
        $fieldOptions['exercicioOrigem'] = [
            'choices' => array_combine($exercicios, $exercicios),
            'mapped' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters js-select-exercicio-origem '
            ],
            'label' => 'label.arrecadacaoCopiarGrupoCredito.exercicioOrigem'
        ];

        $fieldOptions['grupoCredito'] = [
            'class' => GrupoCredito::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                if ($request->get('exercicioOrigem')) {
                    $qb->andWhere('o.anoExercicio = :anoExercicio');
                    $qb->setParameter('anoExercicio', $request->get('exercicioOrigem'));
                }

                $qb->andWhere('LOWER(o.descricao) LIKE :descricao');
                $qb->setParameter('descricao', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('o.descricao', 'ASC');

                return $qb;
            },
            'required' => false,
            'placeholder' => 'Todos',
            'req_params' => [
                'exercicioOrigem' => 'varJsExercicioOrigem',
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.arrecadacaoCopiarGrupoCredito.grupo',
        ];

        $fieldOptions['exercicioDestino'] = [
            'mapped' => false,
            'label' => 'label.arrecadacaoCopiarGrupoCredito.exercicioDestino'
        ];

        $formMapper
            ->with('label.arrecadacaoCopiarGrupoCredito.cabecalhoFiltro')
                ->add('exercicioOrigem', 'choice', $fieldOptions['exercicioOrigem'])
                ->add(
                    'grupoCredito',
                    'autocomplete',
                    $fieldOptions['grupoCredito'],
                    [
                        'admin_code' => 'tributario.admin.grupo_creditos'
                    ]
                )
                ->add('exercicioDestino', 'number', $fieldOptions['exercicioDestino'])
            ->end();
    }

    /**
    * @param CadastroEconomico $object
    */
    protected function populateObject($object, $grupoCredito)
    {
        $form = $this->getForm();

        $object->setCodGrupo($grupoCredito->getCodGrupo());
        $object->setAnoExercicio($form->get('exercicioDestino')->getData());
        $object->setCodModulo($grupoCredito->getCodModulo());
        $object->setDescricao($grupoCredito->getDescricao());

        $regraDesoneracao = $grupoCredito->getFkArrecadacaoRegraDesoneracaoGrupo();
        if ($regraDesoneracao) {
            $regraDesoneracao = clone $regraDesoneracao;
            $regraDesoneracao->setFkArrecadacaoGrupoCredito($object);

            $object->setFkArrecadacaoRegraDesoneracaoGrupo($regraDesoneracao);
        }

        foreach ($grupoCredito->getFkArrecadacaoCreditoGrupos() as $creditoGrupo) {
            $creditoGrupo = clone $creditoGrupo;
            $creditoGrupo->setFkArrecadacaoGrupoCredito($object);

            $object->addFkArrecadacaoCreditoGrupos($creditoGrupo);
        }
    }

    /**
    * @param CadastroEconomico $object
    * @param string $label
    */
    protected function saveObject($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();
        $em->getConnection()->beginTransaction();

        try {
            $em->persist($object);
            $em->flush();
            $em->getConnection()->commit();

            $container->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->getTranslator()->trans('label.arrecadacaoCopiarGrupoCredito.sucesso')
                );
        } catch (Exception $e) {
            $em->getConnection()->rollBack();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.arrecadacaoCopiarGrupoCredito.erro'));
        }
    }
}
