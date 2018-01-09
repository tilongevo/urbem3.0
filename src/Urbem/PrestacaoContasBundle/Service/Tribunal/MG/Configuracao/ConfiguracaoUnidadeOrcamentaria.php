<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcemg\Uniorcam;
use Urbem\CoreBundle\Repository\Tcemg\UniorcamRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\ConfiguracaoUnidadeOrcamentariaAtualType;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\ConfiguracaoUnidadeOrcamentariaConversaoType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

final class ConfiguracaoUnidadeOrcamentaria extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoUnidadeOrcamentaria.js'
        ];
    }

    /**
     * Find the Uniorcam that is informed on request (key parameter)
     *
     * @return object|Uniorcam
     * @throws \Exception
     */
    private function getUniorcamFromRequest()
    {
        $classMetadata = $this->getClassMetadata(Uniorcam::class);
        $repository = $this->getRepository(Uniorcam::class);

        try {
            $id = array_combine(
                $classMetadata->getIdentifierFieldNames(),
                explode(
                    self::ID_SEPARATOR,
                    $this->getRequest()->get('key')
                )
            );

            $uniorcam = $repository->find($id);

            // gestaoFinanceira/fontes/PHP/exportacao/classes/negocio/RExportacaoTCEMGUniOrcam.class.php:137
            if (null === $uniorcam) {
                $uniorcam = new Uniorcam();

                foreach ($id as $setter => $value) {
                    $setter = sprintf('set%s', ucfirst($setter));

                    call_user_func_array([$uniorcam, $setter], $value);
                }
            }

        } catch (\Exception $e) {
            throw new \Exception(sprintf('Unidade Orçamentária "%s" não encontrada', $this->getRequest()->get('key')));
        }

        return $uniorcam;
    }

    /**
     * method name is set on js file (endpoints)
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoUnidadeOrcamentaria.js (Save button)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     */
    public function actionSaveUnidadeOrcamentariaAtual()
    {
        $formFactory = $this->getFormFactory();

        $uniorcam = $this->getUniorcamFromRequest();

        $form = $formFactory->create(
            ConfiguracaoUnidadeOrcamentariaAtualType::class,
            $uniorcam,
            ['csrf_protection' => false]
        );

        $form->handleRequest($this->getRequest());

        if (false === $form->isValid()) {
            $message = $this->getFormErrorAsMessage($form);

            throw new \InvalidArgumentException($message);
        }

        /* see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterConfiguracaoUnidadeOrcamentaria.php:72 */
        $uniorcam->setExercicio($this->factory->getSession()->getExercicio());

        $em = $this->factory->getEntityManager();

        $em->persist($uniorcam);
        $em->flush($uniorcam);

        return ['message' => 'Unidade Orçamentária (Atual) Salva'];
    }

    /**
     * method name is set on js file (endpoints)
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoUnidadeOrcamentaria.js (Save button)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     */
    public function actionSaveUnidadeOrcamentariaConversao()
    {
        $formFactory = $this->getFormFactory();

        $uniorcam = $this->getUniorcamFromRequest();

        $form = $formFactory->create(
            ConfiguracaoUnidadeOrcamentariaConversaoType::class,
            $uniorcam,
            ['csrf_protection' => false]
        );

        $form->handleRequest($this->getRequest());

        if (false === $form->isValid()) {
            $message = $this->getFormErrorAsMessage($form);

            throw new \InvalidArgumentException($message);
        }

        $em = $this->factory->getEntityManager();

        $em->persist($uniorcam);
        $em->flush($uniorcam);

        return ['message' => 'Unidade Orçamentária (Conversão) Salva'];
    }

    /**
     * Factory method responsible for requests
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoUnidadeOrcamentaria.js
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     *
     * @param TwigEngine|null $templating
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        $action = (string) $this->getRequest()->get('action');
        $action = sprintf('action%s', ucfirst($action));

        if (false === method_exists($this, $action)) {
            return [
                'response' => false,
                'message' => sprintf('action %s not found', $action)
            ];
        }

        try {
            return [
                'response' => true,
                // action* methods must always return an array
            ] + call_user_func_array([$this, $action], [$templating]);

        } catch (\Exception $e) {
            return [
                'response' => false,
                'message' => 'Erro ao salvar Unidade Orçamentária'
            ];
        }
    }

    /**
     * method name is set on js file (DataTable::ajax)
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoUnidadeOrcamentaria.js (DataTable)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * Each field on ConfiguracaoUnidadeOrcamentariaAtualType::class is a item rendered on response
     *
     * @param TwigEngine $templating
     * @return array
     */
    protected function actionLoadUnidadeOrcamentariaAtual(TwigEngine $templating)
    {
        /** @var UniorcamRepository $repository */
        $repository = $this->getRepository(Uniorcam::class);
        $classMetadata = $this->getClassMetadata(Uniorcam::class);

        $exercicio = $this->factory->getSession()->getExercicio();

        $uniorcamList = $repository->getAtualByExercicio(
            $exercicio,
            /* https://datatables.net/manual/server-side */
            (int) $this->getRequest()->get('length', 0),
            (int) $this->getRequest()->get('start', 0)
        );

        $formFactory = $this->getFormFactory();

        $data = [];
        $id = 0;

        /** @var Uniorcam $uniorcam */
        foreach ($uniorcamList as $uniorcam) {
            $form = $formFactory->create(ConfiguracaoUnidadeOrcamentariaAtualType::class, $uniorcam);
            $view = $form->createView();

            $rendered = [];

            foreach ([
                'fkOrcamentoOrgao',
                'fkOrcamentoUnidade',
                'identificador',
                'fkSwCgm',
             ] as $field) {
                $rendered[$field] = $templating->render(
                    'PrestacaoContasBundle::Tribunal/MG/Configuracao/UnidadeOrcamentaria/form.html.twig',
                    [
                        'form' => $view,
                        'field' => $field,
                        // sequential ID (avoid conflict)
                        'id' => sprintf('UnidadeOrcamentariaAtual_%s_%s', $field, $id)
                    ]
                );

                $id++;
            }

            // used on $this::getUniorcamFromRequest
            // web/bundles/prestacaocontas/js/Tribunal/MG/ConfiguracaoUnidadeOrcamentaria.js (columnDefs)
            $rendered['key'] = implode(
                self::ID_SEPARATOR,
                $classMetadata->getIdentifierValues($uniorcam)
            );

            $data[] = $rendered;
        }

        $total = $repository->getTotalAtualByExercicio($exercicio);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoUnidadeOrcamentaria.js (pageLength) */
        return [
            'draw' => (int) $this->getRequest()->get('draw', 0),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ];
    }

    /**
     * method name is set on js file (DataTable::ajax)
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoUnidadeOrcamentaria.js (DataTable)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * Each field on ConfiguracaoUnidadeOrcamentariaConversaoType::class is a item rendered on response
     *
     * @param TwigEngine $templating
     * @return array
     */
    protected function actionLoadUnidadeOrcamentariaConversao(TwigEngine $templating)
    {
        /** @var UniorcamRepository $repository */
        $repository = $this->getRepository(Uniorcam::class);
        $classMetadata = $this->getClassMetadata(Uniorcam::class);

        $exercicio = $this->factory->getSession()->getExercicio();

        $uniorcamList = $repository->getConversaoByExercicio(
            $exercicio,
            /* https://datatables.net/manual/server-side */
            (int) $this->getRequest()->get('length', 0),
            (int) $this->getRequest()->get('start', 0)
        );

        $formFactory = $this->getFormFactory();

        $data = [];
        $id = 0;

        /** @var Uniorcam $uniorcam */
        foreach ($uniorcamList as $uniorcam) {
            $form = $formFactory->create(ConfiguracaoUnidadeOrcamentariaConversaoType::class, $uniorcam);
            $view = $form->createView();

            $rendered = [];

            foreach ([
                'exercicio',
                'num_orgao',
                'num_unidade',
                'identificador',
                'fkSwCgm',
                'fkOrcamentoOrgaoAtual',
                'fkOrcamentoUnidadeAtual'
             ] as $field) {
                $rendered[$field] = $templating->render(
                    'PrestacaoContasBundle::Tribunal/MG/Configuracao/UnidadeOrcamentaria/form.html.twig',
                    [
                        'form' => $view,
                        'field' => $field,
                        // sequential ID (avoid conflict)
                        'id' => sprintf('UnidadeOrcamentariaConversao_%s_%s', $field, $id)
                    ]
                );

                // used on $this::getUniorcamFromRequest
                // web/bundles/prestacaocontas/js/Tribunal/MG/ConfiguracaoUnidadeOrcamentaria.js (columnDefs)
                $rendered['key'] = implode(
                    self::ID_SEPARATOR,
                    $classMetadata->getIdentifierValues($uniorcam)
                );

                $id++;
            }

            $data[] = $rendered;
        }

        $total = $repository->getTotalConversaoByExercicio($exercicio);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoUnidadeOrcamentaria.js (pageLength) */
        return [
            'draw' => (int) $this->getRequest()->get('draw', 0),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/UnidadeOrcamentaria/main.html.twig");

        return $formMapper;
    }
}