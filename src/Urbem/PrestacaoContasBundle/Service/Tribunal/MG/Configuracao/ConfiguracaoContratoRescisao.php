<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Doctrine\ORM\UnitOfWork;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcemg\ContratoRescisao;
use Urbem\CoreBundle\Repository\Tcemg\ContratoRescisaoRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\ContratoRescisaoFilter;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\ConfiguracaoContratoRescisaoType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

final class ConfiguracaoContratoRescisao extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoContratoRescisao.js',
        ];
    }

    /**
     * Factory method responsible for requests
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoRescisao.js
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoRescisao.js (button filter)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadContratoRescisao()
    {
        /** @var ContratoRescisaoRepository $repository */
        $repository = $this->getRepository(ContratoRescisao::class);
        $classMetadata = $this->getClassMetadata(ContratoRescisao::class);

        $data = $this->getRequest()->query->get($this->getRequest()->get('uniqid'));

        // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Form/ConfiguracaoContratoRescisaoFilterType.php
        $this->getForm()->submit($data);
        $formData = $this->processParameters();
        $formData = reset($formData);

        $filter = new ContratoRescisaoFilter();
        $filter->setNroContrato($formData['nroContrato']);
        $filter->setDataPublicacao($formData['dataPublicacao']);
        $filter->setPeriodicidade($formData['periodicidade']);
        $filter->setObjetoContrato($formData['objetoContrato']);
        $filter->setDataRescisao($formData['dataRescisao']);

        $contratoRescisaoList = $repository->getByFilter(
            $filter,
            /* https://datatables.net/manual/server-side */
            (int) $this->getRequest()->get('length', 0),
            (int) $this->getRequest()->get('start', 0)
        );

        $data = [];

        /** @var ContratoRescisao $contratoRescisao */
        foreach ($contratoRescisaoList as $contratoRescisao) {
            $rendered = [];

            $dataInicio = $contratoRescisao->getFkTcemgContrato()->getDataInicio();
            $dataInicio = true === $dataInicio instanceof \DateTime ? $dataInicio->format('d/m/Y') : '';

            $dataFinal = $contratoRescisao->getFkTcemgContrato()->getDataFinal();
            $dataFinal = true === $dataFinal instanceof \DateTime ? $dataFinal->format('d/m/Y') : '';

            $dataRescisao = $contratoRescisao->getDataRescisao();
            $dataRescisao = true === $dataRescisao instanceof \DateTime ? $dataRescisao->format('d/m/Y') : '';

            $rendered['entidade'] = (string) $contratoRescisao->getFkTcemgContrato()->getFkOrcamentoEntidade();
            $rendered['contrato'] = (string) $contratoRescisao->getFkTcemgContrato();
            $rendered['dataInicio'] = $dataInicio;
            $rendered['dataFinal'] = $dataFinal;
            $rendered['valorContrato'] = $contratoRescisao->getFkTcemgContrato()->getVlContrato();
            $rendered['objeto'] = (string) $contratoRescisao->getFkTcemgContrato()->getObjetoContrato();
            $rendered['dataRescisao'] = $dataRescisao;
            $rendered['valorRescisao'] = $contratoRescisao->getValorRescisao();

            // used on $this::getConfiguracaoContratoRescisaoFromRequest
            // web/bundles/prestacaocontas/js/Tribunal/MG/ConfiguracaoContratoRescisao.js (columnDefs)
            $rendered['key'] = implode(
                self::ID_SEPARATOR,
                $classMetadata->getIdentifierValues($contratoRescisao)
            );

            $data[] = $rendered;
        }

        $total = $repository->getTotalByFilter($filter);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoRescisao.js (pageLength) */
        return [
            'draw' => (int) $this->getRequest()->get('draw', 0),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ];
    }

    /**
     * Find the ContratoRescisao that is informed on request (key parameter)
     *
     * @return object|ContratoRescisao
     */
    public function getConfiguracaoContratoRescisaoFromRequest()
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

        $contratoRescisao = null;

        if (false === empty($codContrato) && false === empty($codEntidade) && false === empty($exercicio)) {
            $contratoRescisao = $this->getRepository(ContratoRescisao::class)
                ->findOneBy([
                    'codContrato' => $codContrato,
                    'codEntidade' => $codEntidade,
                    'exercicio' => $exercicio,
                ]);
        }

        $contratoRescisao = null === $contratoRescisao ? new ContratoRescisao() : $contratoRescisao;

        return $contratoRescisao;
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoRescisao.js (button new)
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

        $contratoRescisao = $this->getConfiguracaoContratoRescisaoFromRequest();
        $em = $this->factory->getEntityManager();
        $classMetadata = $this->getClassMetadata(ContratoRescisao::class);

        if (UnitOfWork::STATE_MANAGED === $em->getUnitOfWork()->getEntityState($contratoRescisao)) {
            $key = implode(self::ID_SEPARATOR, $classMetadata->getIdentifierValues($contratoRescisao));
        }

        $form = $this->getFormFactory()
            ->create(
                ConfiguracaoContratoRescisaoType::class,
                $contratoRescisao,
                [
                    'csrf_protection' => false
                ]
            );

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->handleRequest($this->getRequest());

            if (true === $form->isValid()) {
                if (null === $key) {
                    $message = 'Rescisão de Contrato inserida com sucesso!';

                } else {
                    $message = 'Rescisão de Contrato alterada com sucesso!';
                }

                $success = true;

                $em->persist($contratoRescisao);
                $em->flush();
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
                "PrestacaoContasBundle::Tribunal/MG/Configuracao/ContratoRescisao/form.html.twig",
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoRescisao.js (button remove)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionRemoveConfiguracaoContratoRescisao(TwigEngine $templating)
    {
        $contratoRescisao = $this->getConfiguracaoContratoRescisaoFromRequest();
        $em = $this->factory->getEntityManager();
        $em->remove($contratoRescisao);
        $em->flush();

        return [
            'message' => 'Rescisao de Contrato excluída com sucesso!'
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/ContratoRescisao/main.html.twig");

        return $formMapper;
    }
}