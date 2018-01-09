<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\Tcemg\Resplic;
use Urbem\CoreBundle\Repository\Patrimonio\Licitacao\LicitacaoRepository;
use Urbem\PrestacaoContasBundle\Form\Type\SwCGMType;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\ResponsavelLicitacaoFilter;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\ResplicType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

final class ConfiguracaoResponsavelLicitacao extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoResponsavelLicitacao.js'
        ];
    }

    /**
     * Find the Licitacao that is informed on request (key parameter)
     *
     * @return object|Licitacao
     * @throws \Exception
     */
    private function getLicitacaoFromRequest()
    {
        $classMetadata = $this->getClassMetadata(Licitacao::class);
        $repository = $this->getRepository(Licitacao::class);

        try {
            $id = array_combine(
                $classMetadata->getIdentifierFieldNames(),
                explode(
                    self::ID_SEPARATOR,
                    $this->getRequest()->get('key')
                )
            );

            $licitacao = $repository->find($id);

            if (null === $licitacao) {
                throw new \Exception();
            }

        } catch (\Exception $e) {
            throw new \Exception(sprintf('Licitação "%s" não encontrada', $this->getRequest()->get('key')));
        }

        return $licitacao;
    }

    /**
     * Find the Licitacao that is informed on request (key parameter)
     *
     * @return object|Licitacao
     * @throws \Exception
     */
    private function getResplicFromRequest()
    {
        try {
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Form/ResplicType.php
            // vendor/symfony/symfony/src/Symfony/Component/Form/AbstractType.php::getBlockPrefix return class name
            $request = $this->getRequest()->get('resplic', []);

            if (true === empty($request['exercicio'])) {
                throw new \OutOfBoundsException();
            }

            if (true === empty($request['codEntidade'])) {
                throw new \OutOfBoundsException();
            }

            if (true === empty($request['codModalidade'])) {
                throw new \OutOfBoundsException();
            }

            if (true === empty($request['codLicitacao'])) {
                throw new \OutOfBoundsException();
            }

            $id = [
                'exercicio' => $request['exercicio'],
                'codEntidade' => $request['codEntidade'],
                'codModalidade' => $request['codModalidade'],
                'codLicitacao' => $request['codLicitacao'],
            ];

            $resplic = $this->getRepository(Resplic::class)->find($id);

            // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterResponsavelLicitacao.php:107
            // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterResponsavelLicitacao.php:124
            if (null === $resplic) {
                $resplic = new Resplic();

                foreach ($id as $setter => $value) {
                    $setter = sprintf('set%s', ucfirst($setter));

                    call_user_func_array([$resplic, $setter], $value);
                }
            }

        } catch (\Exception $e) {
            throw new \Exception('Erro ao recuperar responsáveis pela Licitação');
        }

        return $resplic;
    }

    /**
     * Factory method responsible for requests
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoResponsavelLicitacao.js
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
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * method name is set on js file (DataTable::ajax)
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoResponsavelLicitacao.js (DataTable save row)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    protected function actionSaveResplic(TwigEngine $templating)
    {
        $resplic = $this->getResplicFromRequest();

        $form = $this->getFormFactory()->create(
            ResplicType::class,
            $resplic,
            ['csrf_protection' => false]
        );

        $form->handleRequest($this->getRequest());

        if (false === $form->isValid()) {
            $message = $this->getFormErrorAsMessage($form);

            throw new \InvalidArgumentException($message);
        }

        $em = $this->factory->getEntityManager();

        $em->persist($resplic);
        $em->flush($resplic);

        return ['message' => 'Responsáveis Salvos'];
    }

    /**
     * method name is set on js file (DataTable::ajax)
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoResponsavelLicitacao.js (DataTable expand row)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    protected function actionLoadForm(TwigEngine $templating)
    {
        $licitacao = $this->getLicitacaoFromRequest();

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterResponsavelLicitacao.php:65
        $resplic = $this->getRepository(Resplic::class)->findOneBy(['fkLicitacaoLicitacao' => $licitacao]);

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterResponsavelLicitacao.php:107
        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterResponsavelLicitacao.php:124
        $resplic = null === $resplic ? new Resplic() : $resplic;

        $form = $this->getFormFactory()->create(
            ResplicType::class,
            $resplic,
            ['csrf_protection' => false]
        );

        return [
            'form' => $templating->render(
                'PrestacaoContasBundle::Tribunal/MG/Configuracao/ResponsavelLicitacao/form.html.twig',
                [
                    'form' => $form->createView()
                ]
            )
        ];
    }

    /**
     * method name is set on js file (DataTable::ajax)
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoResponsavelLicitacao.js (DataTable)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    protected function actionLoad(TwigEngine $templating)
    {
        /** @var LicitacaoRepository $repository */
        $repository = $this->getRepository(Licitacao::class);
        $classMetadata = $this->getClassMetadata(Licitacao::class);

        $data = $this->getRequest()->query->get($this->getRequest()->get('uniqid'));

        $this->getForm()->submit($data);
        $formData = $this->processParameters();

        $filter = new ResponsavelLicitacaoFilter();
        $filter->setExercicio($formData['exercicio']);
        $filter->setModalidade($formData['modalidade']);
        $filter->setEntidades($formData['entidades']);
        $filter->setLicitacao($formData['licitacao']);
        $filter->setSwProcesso($formData['processo']);
        $filter->setMapa($formData['mapa_compras']);
        $filter->setPeriodicidade($formData['periodicidade']);
        $filter->setTipoLicitacao($formData['tipo_licitacao']);
        $filter->setCriterioJulgamento($formData['criterio_julgamento']);
        $filter->setTipoObjeto($formData['tipo_objeto']);
        $filter->setObjeto($formData['objeto']);

        $licitacaoList = $repository->getByFilter(
            $filter,
            /* https://datatables.net/manual/server-side */
            (int) $this->getRequest()->get('length', 0),
            (int) $this->getRequest()->get('start', 0)
        );

        $data = [];

        /** @var Licitacao $licitacao */
        foreach ($licitacaoList as $licitacao) {
            $rendered = [];

            $rendered['licitacao'] = (string) $licitacao;
            $rendered['entidade'] = (string) $licitacao->getFkOrcamentoEntidade();
            $rendered['processo'] = (string) $licitacao->getFkSwProcesso();
            $rendered['modalidade'] = (string) $licitacao->getFkComprasModalidade();

            // used on $this::getLicitacaoFromRequest
            // web/bundles/prestacaocontas/js/Tribunal/MG/ConfiguracaoResponsavelLicitacao.js (columnDefs)
            $rendered['key'] = implode(
                self::ID_SEPARATOR,
                $classMetadata->getIdentifierValues($licitacao)
            );

            $data[] = $rendered;
        }

        $total = $repository->getTotalByFilter($filter);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoResponsavelLicitacao.js (pageLength) */
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

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/ResponsavelLicitacao/main.html.twig");

        return $formMapper;
    }
}