<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Doctrine\ORM\UnitOfWork;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcemg\Convenio;
use Urbem\CoreBundle\Entity\Tcemg\ConvenioAditivo;
use Urbem\CoreBundle\Entity\Tcemg\ConvenioEmpenho;
use Urbem\CoreBundle\Entity\Tcemg\ConvenioParticipante;
use Urbem\CoreBundle\Repository\Tcemg\ConvenioRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\ConvenioFilter;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\ConfiguracaoConvenioType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

final class ConfiguracaoConvenio extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoConvenio.js',
        ];
    }

    /**
     * Factory method responsible for requests
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoConvenio.js
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoConvenio.js (button filter)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadConvenio()
    {
        /** @var ConvenioRepository $repository */
        $repository = $this->getRepository(Convenio::class);
        $classMetadata = $this->getClassMetadata(Convenio::class);

        $data = $this->getRequest()->query->get($this->getRequest()->get('uniqid'));

        // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Form/ConvenioFilterType.php
        $this->getForm()->submit($data);
        $formData = $this->processParameters();
        $formData = reset($formData);

        $filter = new ConvenioFilter();
        $filter->setExercicio($formData['exercicio']);
        $filter->setEntidade($formData['entidade']);
        $filter->setPeriodicidade($formData['periodicidade']);
        $filter->setNumConvenio($formData['numConvenio']);

        $licitacaoList = $repository->getByFilter(
            $filter,
            /* https://datatables.net/manual/server-side */
            (int) $this->getRequest()->get('length', 0),
            (int) $this->getRequest()->get('start', 0)
        );

        $data = [];

        /** @var Convenio $convenio */
        foreach ($licitacaoList as $convenio) {
            $rendered = [];

            $rendered['codigo'] = (string) $convenio->getCodConvenio();
            $rendered['entidade'] = (string) $convenio->getFkOrcamentoEntidade();
            $rendered['objeto'] = (string) $convenio->getFkComprasObjeto();
            $rendered['valor'] = (string) $convenio->getVlConvenio();

            // used on $this::getConfiguracaoConvenioFromRequest
            // web/bundles/prestacaocontas/js/Tribunal/MG/ConfiguracaoConvenio.js (columnDefs)
            $rendered['key'] = implode(
                self::ID_SEPARATOR,
                $classMetadata->getIdentifierValues($convenio)
            );

            $data[] = $rendered;
        }

        $total = $repository->getTotalByFilter($filter);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoConvenio.js (pageLength) */
        return [
            'draw' => (int) $this->getRequest()->get('draw', 0),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ];
    }

    /**
     * Find the Convenio that is informed on request (key parameter)
     *
     * @return object|Convenio
     */
    public function getConfiguracaoConvenioFromRequest()
    {
        $data = $this->getRequest()->get("configuracao_convenio", []);

        $codConvenio = null;
        $codEntidade = null;
        $exercicio = null;

        if (true === empty($data)) {
            $data = $this->getRequest()->get('key');
            $data = explode(self::ID_SEPARATOR, $data);
            $data = array_filter($data);

            if (3 === count($data)) {
                list($codConvenio, $codEntidade, $exercicio) = $data;
            }
        }

        $convenio = null;

        if (false === empty($codConvenio) && false === empty($codEntidade) && false === empty($exercicio)) {
            $convenio = $this->getRepository(Convenio::class)
                ->findOneBy([
                    'codConvenio' => $codConvenio,
                    'codEntidade' => $codEntidade,
                    'exercicio' => $exercicio,
                ]);
        }

        $convenio = null === $convenio ? new Convenio() : $convenio;

        return $convenio;
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoConvenio.js (button new)
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
        $convenio = $this->getConfiguracaoConvenioFromRequest();
        $em = $this->factory->getEntityManager();
        $classMetadata = $this->getClassMetadata(Convenio::class);
        /** @var ConvenioRepository $repository */
        $repository = $em->getRepository(Convenio::class);

        if (UnitOfWork::STATE_MANAGED === $em->getUnitOfWork()->getEntityState($convenio)) {
            $key = implode(self::ID_SEPARATOR, $classMetadata->getIdentifierValues($convenio));
        }

        $form = $this->getFormFactory()
            ->create(
                ConfiguracaoConvenioType::class,
                $convenio,
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

                if (0 === $convenio->getFkTcemgConvenioParticipantes()->count()) {
                    $message[] = 'Deve haver ao menos 1 Participante';
                }

                if (0 === $convenio->getFkTcemgConvenioEmpenhos()->count()) {
                    $message[] = 'Deve haver ao menos 1 Empenho';
                }

                $totalParticipantes = 0;

                /** @var ConvenioParticipante $participante */
                foreach ($convenio->getFkTcemgConvenioParticipantes() as $participante) {
                    $totalParticipantes+= $participante->getVlConcedido();
                }

                if ((float) $convenio->getVlConvenio() != (float) $totalParticipantes) {
                    $message[] = 'A soma do Valor de Participações deve ser igual a 100% do Valor do Convênio.';
                }

                if (0 === count($message)) {
                    if (null === $convenio->getCodConvenio()) {
                        $convenio->setCodConvenio($repository->getNextCodConvenio());
                    }

                    /** @var ConvenioEmpenho $empenho */
                    foreach ($convenio->getFkTcemgConvenioEmpenhos() as $empenho) {
                        $empenho->setFkTcemgConvenio($convenio);
                    }

                    foreach ($convenio->getFkTcemgConvenioParticipantes() as $participante) {
                        $participante->setFkTcemgConvenio($convenio);
                    }

                    /** @var ConvenioAditivo $aditivo */
                    foreach ($convenio->getFkTcemgConvenioAditivos() as $aditivo) {
                        $aditivo->setFkTcemgConvenio($convenio);
                    }

                    if (null === $key) {
                        $message = 'Convênio inserido com sucesso!';

                    } else {
                        $message = 'Convênio alterado com sucesso!';
                    }

                    $success = true;

                    $em->persist($convenio);
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
                "PrestacaoContasBundle::Tribunal/MG/Configuracao/Convenio/form.html.twig",
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoConvenio.js (button remove)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionRemoveConfiguracaoConvenio(TwigEngine $templating)
    {
        $convenio = $this->getConfiguracaoConvenioFromRequest();
        $em = $this->factory->getEntityManager();
        $em->remove($convenio);
        $em->flush();

        return [
            'message' => 'Convênio excluído com sucesso!'
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/Convenio/main.html.twig");

        return $formMapper;
    }
}