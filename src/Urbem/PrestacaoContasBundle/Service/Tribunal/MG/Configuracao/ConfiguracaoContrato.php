<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Doctrine\ORM\UnitOfWork;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcemg\Contrato;
use Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo;
use Urbem\CoreBundle\Entity\Tcemg\ContratoEmpenho;
use Urbem\CoreBundle\Entity\Tcemg\ContratoFornecedor;
use Urbem\CoreBundle\Repository\Tcemg\ContratoRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\ContratoFilter;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\ConfiguracaoContratoType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

final class ConfiguracaoContrato extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoContrato.js',
        ];
    }

    /**
     * Factory method responsible for requests
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContrato.js
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
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContrato.js (button filter)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadContrato()
    {
        /** @var ContratoRepository $repository */
        $repository = $this->getRepository(Contrato::class);
        $classMetadata = $this->getClassMetadata(Contrato::class);

        $data = $this->getRequest()->query->get($this->getRequest()->get('uniqid'));

        // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Form/ConfiguracaoContratoFilterType.php
        $this->getForm()->submit($data);
        $formData = $this->processParameters();
        $formData = reset($formData);

        $filter = new ContratoFilter();
        $filter->setNroContrato($formData['nroContrato']);
        $filter->setDataPublicacao($formData['dataPublicacao']);
        $filter->setPeriodicidade($formData['periodicidade']);
        $filter->setObjetoContrato($formData['objetoContrato']);

        $contratoList = $repository->getByFilter(
            $filter,
            /* https://datatables.net/manual/server-side */
            (int) $this->getRequest()->get('length', 0),
            (int) $this->getRequest()->get('start', 0)
        );

        $data = [];

        /** @var Contrato $contrato */
        foreach ($contratoList as $contrato) {
            $rendered = [];

            $dataInicio = $contrato->getDataInicio();
            $dataInicio = true === $dataInicio instanceof \DateTime ? $dataInicio->format('d/m/Y') : '';

            $dataFim = $contrato->getDataFinal();
            $dataFim = true === $dataFim instanceof \DateTime ? $dataFim->format('d/m/Y') : '';

            $rendered['entidade'] = (string) $contrato->getFkOrcamentoEntidade();
            $rendered['contrato'] = (string) $contrato;
            $rendered['dataInicio'] = $dataInicio;
            $rendered['dataFim'] = $dataFim;
            $rendered['valor'] = (string) $contrato->getVlContrato();
            $rendered['objeto'] = (string) $contrato->getObjetoContrato();

            // used on $this::getConfiguracaoContratoFromRequest
            // web/bundles/prestacaocontas/js/Tribunal/MG/ConfiguracaoContrato.js (columnDefs)
            $rendered['key'] = implode(
                self::ID_SEPARATOR,
                $classMetadata->getIdentifierValues($contrato)
            );

            $data[] = $rendered;
        }

        $total = $repository->getTotalByFilter($filter);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContrato.js (pageLength) */
        return [
            'draw' => (int) $this->getRequest()->get('draw', 0),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ];
    }

    /**
     * Find the Contrato that is informed on request (key parameter)
     *
     * @return object|Contrato
     */
    public function getConfiguracaoContratoFromRequest()
    {
        $codContrato = null;
        $codEntidade = null;
        $exercicio = null;

        $data = $this->getRequest()->get('key');
        $data = explode(self::ID_SEPARATOR, $data);
        $data = array_filter($data);

        if (3 === count($data)) {
            list($codContrato, $codEntidade, $exercicio) = $data;
        }

        $contrato = null;

        if (false === empty($codContrato) && false === empty($codEntidade) && false === empty($exercicio)) {
            $contrato = $this->getRepository(Contrato::class)
                ->findOneBy([
                    'codContrato' => $codContrato,
                    'codEntidade' => $codEntidade,
                    'exercicio' => $exercicio,
                ]);
        }

        $contrato = null === $contrato ? new Contrato() : $contrato;

        return $contrato;
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContrato.js (button new)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadDynamicForm(TwigEngine $templating)
    {
        $contrato = $this->getConfiguracaoContratoFromRequest();

        $form = $this->getFormFactory()
            ->create(
                ConfiguracaoContratoType::class,
                $contrato,
                [
                    'exercicio' => $this->factory->getSession()->getExercicio(),
                    'usuario' => $this->factory->getUser(),
                    'csrf_protection' => false
                ]
            );

        $form->submit($this->getRequest()->query->get('configuracao_contrato'));

        $form = $this->getFormFactory()
            ->create(
                ConfiguracaoContratoType::class,
                $form->getData(),
                [
                    'exercicio' => $this->factory->getSession()->getExercicio(),
                    'usuario' => $this->factory->getUser(),
                    'csrf_protection' => false
                ]
            );

        $formView = $form->createView();

        return [
            'contrato_modalidade' => $templating->render(
                "PrestacaoContasBundle::Tribunal/MG/Configuracao/Contrato/form_ajax_contrato_modalidade.html.twig",
                [
                    'form' => $formView,
                    'show_error' => false,
                ]
            ),

            'contrato_objeto' => $templating->render(
                "PrestacaoContasBundle::Tribunal/MG/Configuracao/Contrato/form_ajax_contrato_objeto.html.twig",
                [
                    'form' => $formView,
                    'show_error' => false,
                ]
            ),

            'unidade' => $templating->render(
                "PrestacaoContasBundle::Tribunal/MG/Configuracao/Contrato/form_ajax_unidade.html.twig",
                [
                    'form' => $formView,
                    'show_error' => false,
                ]
            ),
        ];
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContrato.js (button new)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadForm(TwigEngine $templating)
    {
        $message = null;
        $key = null;
        $success = false;
        $contrato = $this->getConfiguracaoContratoFromRequest();
        $em = $this->factory->getEntityManager();
        $classMetadata = $this->getClassMetadata(Contrato::class);
        /** @var ContratoRepository $repository */
        $repository = $em->getRepository(Contrato::class);

        if (UnitOfWork::STATE_MANAGED === $em->getUnitOfWork()->getEntityState($contrato)) {
            $key = implode(self::ID_SEPARATOR, $classMetadata->getIdentifierValues($contrato));
        }

        $form = $this->getFormFactory()
            ->create(
                ConfiguracaoContratoType::class,
                $contrato,
                [
                    'exercicio' => $this->factory->getSession()->getExercicio(),
                    'usuario' => $this->factory->getUser(),
                    'csrf_protection' => false
                ]
            );

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->handleRequest($this->getRequest());

            if (true === $form->isValid()) {
                $message = [];

                if (0 === count($message)) {
                    if (null === $contrato->getCodContrato()) {
                        $contrato->setCodContrato($repository->getNextCodContrato());
                    }

                    if (null === $key) {
                        $message = 'Contrato inserido com sucesso!';

                    } else {
                        $message = 'Contrato alterado com sucesso!';
                    }

                    $success = true;

                    /** @var ContratoEmpenho $contratoEmpenho */
                    foreach ($contrato->getFkTcemgContratoEmpenhos() as $contratoEmpenho) {
                        $contratoEmpenho->setFkTcemgContrato($contrato);
                    }

                    /** @var ContratoFornecedor $contratoFornecedor */
                    foreach ($contrato->getFkTcemgContratoFornecedores() as $contratoFornecedor) {
                        $contratoFornecedor->setFkTcemgContrato($contrato);
                    }

                    /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterContrato.php:253 */
                    $contrato->setNumcgmContratante($contrato->getFkOrcamentoEntidade()->getNumcgm());

                    $em->persist($contrato);
                    $em->flush();
                }
            }
        }

        $formView = $form->createView();

        $this->relatorioConfiguracao
            ->getConfigurationPool()
            ->getContainer()
            ->get('twig')
            ->getExtension(FormExtension::class)
            ->renderer
            ->setTheme($formView, $this->relatorioConfiguracao->getFormTheme());

        return [
            'success' => $success,
            'message' => $message,
            'form' => $templating->render(
                "PrestacaoContasBundle::Tribunal/MG/Configuracao/Contrato/form.html.twig",
                [
                    'form' => $formView,
                    'key' => $key,
                ]
            )
        ];
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContrato.js (button remove)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionRemoveConfiguracaoContrato(TwigEngine $templating)
    {
        $contrato = $this->getConfiguracaoContratoFromRequest();
        $em = $this->factory->getEntityManager();
        $em->remove($contrato);
        $em->flush();

        return [
            'message' => 'Contrato excluído com sucesso!'
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/Contrato/main.html.twig");

        return $formMapper;
    }
}