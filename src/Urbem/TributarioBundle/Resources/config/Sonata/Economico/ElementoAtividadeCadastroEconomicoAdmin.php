<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Exception;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\Elemento;
use Urbem\CoreBundle\Entity\Economico\ElementoAtividade;
use Urbem\CoreBundle\Entity\Economico\ElementoAtivCadEconomico;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ElementoAtividadeCadastroEconomicoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_elemento_atividade_cadastro_economico';
    protected $baseRoutePattern = 'tributario/cadastro-economico/inscricao-economica/definir-elementos';
    protected $includeJs = ['/tributario/javascripts/economico/elemento-atividade-cadastro-economico.js'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add(
            'definir',
            sprintf(
                '%s',
                $this->getRouterIdParameter()
            )
        );

        $routes->clearExcept(['edit', 'definir']);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->populateObject($object);
        $this->saveObject($object, 'label.ElementoAtividadeCadastroEconomicoAdmin.msgSucesso');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $cadastroEconomico = $this->getSubject() ?: new CadastroEconomico();

        $fieldOptions = [];
        $fieldOptions['atividades'] = [
            'mapped' => false,
            'choices' => $cadastroEconomico->getFkEconomicoAtividadeCadastroEconomicos(),
            'choice_value' => 'codAtividade',
            'choice_label' => function (AtividadeCadastroEconomico $atividadeCadastroEconomico) {
                return sprintf(
                    '%s - %s',
                    $atividadeCadastroEconomico->getFkEconomicoAtividade()->getCodEstrutural(),
                    $atividadeCadastroEconomico->getFkEconomicoAtividade()->getNomAtividade()
                );
            },
            'required' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters js-select-atividade '
            ],
            'label' => 'label.ElementoAtividadeCadastroEconomicoAdmin.atividade',
        ];

        $fieldOptions['elementos'] = [
            'class' => Elemento::class,
            'mapped' => false,
            'required' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters js-select-elemento '
            ],
            'label' => 'label.ElementoAtividadeCadastroEconomicoAdmin.elemento',
        ];

        $fieldOptions['incluirElementoAtividade'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/ElementoAtividadeCadastroEconomico/incluir_elemento_atividade.html.twig',
            'data' => [],
        ];

        $fieldOptions['listaElementoAtividade'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/ElementoAtividadeCadastroEconomico/lista_elemento_atividade.html.twig',
            'data' => [
                'itens' => $cadastroEconomico->getFkEconomicoAtividadeCadastroEconomicos(),
            ],
        ];

        $formMapper
            ->with('label.ElementoAtividadeCadastroEconomicoAdmin.cabecalhoCadastroEconomico')
                ->add(
                    'inscricaoEconomica',
                    null,
                    [
                        'disabled' => true,
                        'data' => $cadastroEconomico->getInscricaoEconomica(),
                        'attr' => [
                            'class' => 'js-inscricao-economica ',
                        ],
                        'label' => 'label.economicoCadastroEconomico.codInscricao',
                    ]
                )
                ->add(
                    'fkSwCgm',
                    'text',
                    [
                        'mapped' => false,
                        'disabled' => true,
                        'data' => $this->getCgm($cadastroEconomico),
                        'label' => 'label.economicoBaixaCadastroEconomico.cgm',
                    ]
                )
            ->end()
            ->with('label.ElementoAtividadeCadastroEconomicoAdmin.cabecalhoElementoAtividade')
                ->add('atividades', 'choice', $fieldOptions['atividades'])
                ->add('elementos', 'entity', $fieldOptions['elementos'])
                ->add('incluirElementoAtividade', 'customField', $fieldOptions['incluirElementoAtividade'])
            ->end()
            ->with('label.ElementoAtividadeCadastroEconomicoAdmin.cabecalhoListaElementoAtividade')
                ->add('listaElementoAtividade', 'customField', $fieldOptions['listaElementoAtividade'])
            ->end();
    }

    /**
    * @param CadastroEconomico $cadastroEconomico
    * @return Urbem\CoreBundle\Entity\SwCgm
    */
    protected function getCgm(CadastroEconomico $cadastroEconomico)
    {
        if ($empresaFato = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaFato()) {
            return $empresaFato->getFkSwCgmPessoaFisica()->getFkSwCgm();
        }

        if ($autonomo = $cadastroEconomico->getFkEconomicoCadastroEconomicoAutonomo()) {
            return $autonomo->getFkSwCgmPessoaFisica()->getFkSwCgm();
        }

        if ($empresaDireito = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaDireito()) {
            return $empresaDireito->getFkSwCgmPessoaJuridica()->getFkSwCgm();
        }
    }

    /**
    * @param CadastroEconomico $object
    */
    protected function populateObject(CadastroEconomico $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        foreach ($object->getFkEconomicoAtividadeCadastroEconomicos() as $atividadeCadastroEconomico) {
            foreach ($atividadeCadastroEconomico->getFkEconomicoElementoAtivCadEconomicos() as $elementoAtividadeCadastroEconomico) {
                $atividadeCadastroEconomico->removeFkEconomicoElementoAtivCadEconomicos($elementoAtividadeCadastroEconomico);
            }
        }

        $em->persist($object);
        $em->flush();

        foreach ((array) $this->getRequest()->get('elementoAtividade') as $atividade) {
            $atividadeCadastroEconomico = $em->getRepository(AtividadeCadastroEconomico::class)->findOneBy(['inscricaoEconomica' => $object->getInscricaoEconomica(), 'codAtividade' => $atividade['codAtividade']]);
            $elemento = $em->getRepository(Elemento::class)->find($atividade['codElemento']);
            if (!$atividadeCadastroEconomico || !$elemento) {
                continue;
            }

            $elementoAtividade = $em->getRepository(ElementoAtividade::class)->findOneBy(['codElemento' => $atividade['codElemento'], 'codAtividade' => $atividade['codAtividade']]);
            if (!$elementoAtividade) {
                $elementoAtividade = new ElementoAtividade();
                $elementoAtividade->setFkEconomicoElemento($elemento);
                $elementoAtividade->setFkEconomicoAtividade($atividadeCadastroEconomico->getFkEconomicoAtividade());
                $em->persist($elementoAtividade);
                $em->flush();
            }

            $elementoAtividadeCadastroEconomico = new ElementoAtivCadEconomico();
            $elementoAtividadeCadastroEconomico->setFkEconomicoElementoAtividade($elementoAtividade);
            $elementoAtividadeCadastroEconomico->setFkEconomicoAtividadeCadastroEconomico($atividadeCadastroEconomico);
            $elementoAtividadeCadastroEconomico->setOcorrenciaElemento(1);
            $elementoAtividadeCadastroEconomico->setOcorrenciaAtividade($atividadeCadastroEconomico->getOcorrenciaAtividade());

            $atividadeCadastroEconomico->addFkEconomicoElementoAtivCadEconomicos($elementoAtividadeCadastroEconomico);
        }
    }

    /**
    * @param CadastroEconomico $object
    * @param string $label
    */
    protected function saveObject(CadastroEconomico $object, $label = '')
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
                    $this->getTranslator()->trans($label)
                );
        } catch (Exception $e) {
            $em->getConnection()->rollBack();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
        } finally {
            $this->forceRedirect('/tributario/cadastro-economico/inscricao-economica/empresa-direito/list');
        }
    }
}
