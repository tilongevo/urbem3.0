<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconRespTecnico;
use Urbem\CoreBundle\Entity\Economico\Responsavel;
use Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CadastroEconRespTecnicoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_cadastro_economico_responsavel_tecnico';
    protected $baseRoutePattern = 'tributario/cadastro-economico/inscricao-economica/definir-responsaveis';
    protected $includeJs = ['/tributario/javascripts/economico/cadastro-economico-responsavel-tecnico.js'];

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

        $routes->add(
            'get',
            sprintf(
                'get/%s',
                $this->getRouterIdParameter()
            )
        );

        $routes->clearExcept(['edit', 'definir', 'get']);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->populateObject($object);
        $this->saveObject($object, 'label.economicoCadastroEconRespTecnico.msgSucesso');
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $responsaveis = $this->getRequest()->get('responsaveis');
        if (!empty($responsaveis)) {
            return;
        }

        $error = $this->getTranslator()->trans('label.economicoCadastroEconRespTecnico.erro');
        $errorElement->with('fkEconomicoResponsavelTecnico')->addViolation($error)->end();
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
        $fieldOptions['fkEconomicoResponsavelTecnico'] = [
            'class' => ResponsavelTecnico::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $fkSwCgm = sprintf('%s.fkSwCgm', $qb->getRootAlias());
                $qb->join($fkSwCgm, 'cgm')
                    ->andWhere('LOWER(cgm.nomCgm) LIKE :nomCgm')
                    ->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('cgm.nomCgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.economicoCadastroEconomico.reponsavel',
        ];

        $fieldOptions['incluirResponsavel'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomicoResponsavelTecnico/incluir_responsavel.html.twig',
            'data' => [],
        ];

        $responsaveisTecnicos = [];
        foreach ($cadastroEconomico->getFkEconomicoCadastroEconRespTecnicos() as $responsavelTecnico) {
            $responsaveisTecnicos[] = $em->getRepository(ResponsavelTecnico::class)->findOneByNumcgm($responsavelTecnico->getNumCgm());
        }

        $fieldOptions['listaResponsaveis'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/CadastroEconomicoResponsavelTecnico/lista_responsaveis.html.twig',
            'data' => [
                'itens' => $responsaveisTecnicos,
            ],
        ];

        $formMapper
            ->with('label.economicoCadastroEconRespTecnico.cabecalhoCadastroEconomico')
                ->add(
                    'fkSwCgm',
                    'text',
                    [
                        'mapped' => false,
                        'disabled' => true,
                        'required' => false,
                        'data' => $this->getCgm($cadastroEconomico),
                        'label' => 'label.economicoCadastroEconRespTecnico.cgm',
                    ]
                )
                ->add(
                    'inscricaoEconomica',
                    null,
                    [
                        'disabled' => true,
                        'required' => false,
                        'data' => $cadastroEconomico->getInscricaoEconomica(),
                        'label' => 'label.economicoCadastroEconRespTecnico.codInscricaoEconomica',
                    ]
                )
            ->end()
            ->with('label.economicoCadastroEconRespTecnico.cabecalhoResponsaveisTecnicos')
                ->add(
                    'fkEconomicoResponsavelTecnico',
                    'autocomplete',
                    $fieldOptions['fkEconomicoResponsavelTecnico'],
                    [
                        'admin_code' => 'tributario.admin.responsavel_tecnico'
                    ]
                )
                ->add('incluirResponsavel', 'customField', $fieldOptions['incluirResponsavel'])
                ->add('listaResponsaveis', 'customField', $fieldOptions['listaResponsaveis'])
                ->add(
                    'redirectDefinicaoElementos',
                    'checkbox',
                    [
                        'mapped' => false,
                        'required' => false,
                        'label' => 'label.economicoCadastroEconRespTecnico.redirectDefinicaoElementos',
                    ]
                )
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

        foreach ($object->getFkEconomicoCadastroEconRespTecnicos() as $respTecnico) {
            $object->removeFkEconomicoCadastroEconRespTecnicos($respTecnico);
        }

        foreach ((array) $this->getRequest()->get('responsaveis') as $responsavel) {
            $cadastroEconRespTecnico = new CadastroEconRespTecnico();

            $responsavel = $em->getRepository(Responsavel::class)->findOneByNumcgm($responsavel['numcgm']);
            $cadastroEconRespTecnico->setFkEconomicoResponsavel($responsavel);

            $cadastroEconRespTecnico->setFkEconomicoCadastroEconomico($object);

            $object->addFkEconomicoCadastroEconRespTecnicos($cadastroEconRespTecnico);
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
            if ($object->getFkEconomicoCadastroEconomicoEmpresaFato()) {
                $this->forceRedirect('/tributario/cadastro-economico/inscricao-economica/empresa-fato/list');
            }

            if ($object->getFkEconomicoCadastroEconomicoAutonomo()) {
                $this->forceRedirect('/tributario/cadastro-economico/inscricao-economica/autonomo/list');
            }

            if ($object->getFkEconomicoCadastroEconomicoEmpresaDireito()) {
                $this->forceRedirect('/tributario/cadastro-economico/inscricao-economica/empresa-direito/list');
            }
        }
    }
}
