<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Doctrine\ORM\UnitOfWork;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcemg\ContratoApostila;
use Urbem\CoreBundle\Repository\Tcemg\ContratoApostilaRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\ContratoApostilaFilter;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\ConfiguracaoContratoApostilaType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

final class ConfiguracaoContratoApostila extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoContratoApostila.js',
        ];
    }

    /**
     * Factory method responsible for requests
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoApostila.js
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoApostila.js (button filter)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadContratoApostila()
    {
        /** @var ContratoApostilaRepository $repository */
        $repository = $this->getRepository(ContratoApostila::class);
        $classMetadata = $this->getClassMetadata(ContratoApostila::class);

        $data = $this->getRequest()->query->get($this->getRequest()->get('uniqid'));

        // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Form/ConfiguracaoContratoApostilaFilterType.php
        $this->getForm()->submit($data);
        $formData = $this->processParameters();
        $formData = reset($formData);

        $filter = new ContratoApostilaFilter();
        $filter->setNroContrato($formData['nroContrato']);
        $filter->setDataAssinatura($formData['dataAssinatura']);
        $filter->setCodApostila($formData['codApostila']);
        $filter->setEntidades($formData['entidades']);

        $contratoApostilaList = $repository->getByFilter(
            $filter,
            /* https://datatables.net/manual/server-side */
            (int) $this->getRequest()->get('length', 0),
            (int) $this->getRequest()->get('start', 0)
        );

        $data = [];

        /** @var ContratoApostila $contratoApostila */
        foreach ($contratoApostilaList as $contratoApostila) {
            $rendered = [];

            $dataApostila = $contratoApostila->getDataApostila();
            $dataApostila = true === $dataApostila instanceof \DateTime ? $dataApostila->format('d/m/Y') : '';

            $rendered['entidade'] = (string) $contratoApostila->getFkTcemgContrato()->getFkOrcamentoEntidade();
            $rendered['contrato'] = (string) $contratoApostila->getFkTcemgContrato();
            $rendered['apostila'] = (string) $contratoApostila;
            $rendered['dataApostila'] = $dataApostila;
            $rendered['objeto'] = (string) $contratoApostila->getFkTcemgContrato()->getObjetoContrato();

            // used on $this::getConfiguracaoContratoApostilaFromRequest
            // web/bundles/prestacaocontas/js/Tribunal/MG/ConfiguracaoContratoApostila.js (columnDefs)
            $rendered['key'] = implode(
                self::ID_SEPARATOR,
                $classMetadata->getIdentifierValues($contratoApostila)
            );

            $data[] = $rendered;
        }

        $total = $repository->getTotalByFilter($filter);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoApostila.js (pageLength) */
        return [
            'draw' => (int) $this->getRequest()->get('draw', 0),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ];
    }

    /**
     * Find the ContratoApostila that is informed on request (key parameter)
     *
     * @return object|ContratoApostila
     */
    public function getConfiguracaoContratoApostilaFromRequest()
    {
        $codApostila = null;
        $codContrato = null;
        $codEntidade = null;
        $exercicio = null;

        $data = $this->getRequest()->get('key');
        $data = explode(self::ID_SEPARATOR, $data);
        $data = array_filter($data);

        if (4 === count($data)) {
            list($codApostila, $codContrato, $codEntidade, $exercicio) = $data;
        }

        $contratoApostila = null;

        if (false === empty($codApostila) && false === empty($codContrato) && false === empty($codEntidade) && false === empty($exercicio)) {
            $contratoApostila = $this->getRepository(ContratoApostila::class)
                ->findOneBy([
                    'codApostila' => $codApostila,
                    'codContrato' => $codContrato,
                    'codEntidade' => $codEntidade,
                    'exercicio' => $exercicio,
                ]);
        }

        $contratoApostila = null === $contratoApostila ? new ContratoApostila() : $contratoApostila;

        return $contratoApostila;
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoApostila.js (button new)
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

        $contratoApostila = $this->getConfiguracaoContratoApostilaFromRequest();
        $em = $this->factory->getEntityManager();
        $classMetadata = $this->getClassMetadata(ContratoApostila::class);
        /** @var ContratoApostilaRepository $repository */
        $repository = $em->getRepository(ContratoApostila::class);

        if (UnitOfWork::STATE_MANAGED === $em->getUnitOfWork()->getEntityState($contratoApostila)) {
            $key = implode(self::ID_SEPARATOR, $classMetadata->getIdentifierValues($contratoApostila));
        }

        $form = $this->getFormFactory()
            ->create(
                ConfiguracaoContratoApostilaType::class,
                $contratoApostila,
                [
                    'csrf_protection' => false
                ]
            );

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->handleRequest($this->getRequest());

            if (true === $form->isValid()) {
                if (null === $contratoApostila->getCodApostila()) {
                    $contratoApostila->setCodApostila($repository->getNextCodApostila());
                }

                /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/LSManterApostilaContrato.php:84 */
                if (3 === $contratoApostila->getCodAlteracao()) {
                    $contratoApostila->setValorApostila(0);
                }

                if (null === $key) {
                    $message = 'Apostila de Contrato inserida com sucesso!';

                } else {
                    $message = 'Apostila de Contrato alterada com sucesso!';
                }

                $success = true;

                $em->persist($contratoApostila);
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
                "PrestacaoContasBundle::Tribunal/MG/Configuracao/ContratoApostila/form.html.twig",
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoApostila.js (button remove)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionRemoveConfiguracaoContratoApostila(TwigEngine $templating)
    {
        $contratoApostila = $this->getConfiguracaoContratoApostilaFromRequest();
        $em = $this->factory->getEntityManager();
        $em->remove($contratoApostila);
        $em->flush();

        return [
            'message' => 'Apostila de Contrato excluída com sucesso!'
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/ContratoApostila/main.html.twig");

        return $formMapper;
    }
}