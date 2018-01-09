<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use function Aws\filter;
use Doctrine\ORM\UnitOfWork;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Helper\MonthsHelper;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoEntidadeModel;
use Urbem\CoreBundle\Model\Tcemg\ConfiguracaoOrgaoModel;
use Urbem\CoreBundle\Repository\Tcemg\ConfiguracaoDdcRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\DDCFilter;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\ConfiguracaoDDCType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

final class ConfiguracaoDDC extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoDDC.js',
        ];
    }

    /**
     * @return bool
     */
    public function save()
    {
        $em = $this->factory->getEntityManager();
        $em->getConnection()->setNestTransactionsWithSavepoints(true);
        $em->getConnection()->beginTransaction();

        try {
            $em->getConnection()->commit();

            return true;

        } catch (\Exception $e) {
            $this->setErrorMessage($e->getMessage());
            $em->getConnection()->rollBack();

            return false;
        }
    }

    /**
     * Factory method responsible for requests
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoDDC.js
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoDDC.js (button filter)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadDDC()
    {
        /** @var ConfiguracaoDdcRepository $repository */
        $repository = $this->getRepository(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoDdc::class);
        $classMetadata = $this->getClassMetadata(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoDdc::class);

        $data = $this->getRequest()->query->get($this->getRequest()->get('uniqid'));

        // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Form/DDCFilterType.php
        $this->getForm()->submit($data);
        $formData = $this->processParameters();
        $formData = reset($formData);

        $filter = new DDCFilter();
        $filter->setExercicio($formData['exercicio']);
        $filter->setEntidade($formData['entidade']);
        $filter->setMes($formData['mes']);

        $licitacaoList = $repository->getByFilter(
            $filter,
            /* https://datatables.net/manual/server-side */
            (int) $this->getRequest()->get('length', 0),
            (int) $this->getRequest()->get('start', 0)
        );

        $data = [];

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/LSManterConfiguracaoArquivoDDC.php
        /** @var \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoDdc $configuracaoDdc */
        foreach ($licitacaoList as $configuracaoDdc) {
            $rendered = [];

            $rendered['exercicio'] = (string) $configuracaoDdc->getExercicio();
            $rendered['mes'] = MonthsHelper::getMonthName($configuracaoDdc->getMesReferencia());
            $rendered['entidade'] = (string) $configuracaoDdc->getFkOrcamentoEntidade();
            $rendered['lei'] = (string) $configuracaoDdc->getFkNormasNorma();
            $rendered['contrato'] = $configuracaoDdc->getNroContratoDivida();

            $dtAssinatura = $configuracaoDdc->getDtAssinatura();
            $dtAssinatura = true === $dtAssinatura instanceof \DateTime ? $dtAssinatura->format('d/m/Y') : '';

            $rendered['data'] = $dtAssinatura;

            // used on $this::getConfiguracaoDDCFromRequest
            // web/bundles/prestacaocontas/js/Tribunal/MG/ConfiguracaoDDC.js (columnDefs)
            $rendered['key'] = implode(
                self::ID_SEPARATOR,
                $classMetadata->getIdentifierValues($configuracaoDdc)
            );

            $data[] = $rendered;
        }

        $total = $repository->getTotalByFilter($filter);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoDDC.js (pageLength) */
        return [
            'draw' => (int) $this->getRequest()->get('draw', 0),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ];
    }

    /**
     * Find theConfiguracaoDDC that is informed on request (key parameter)
     *
     * @return object|\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoDdc
     */
    public function getConfiguracaoDDCFromRequest()
    {
        $data = $this->getRequest()->get("configuracao_ddc", []);

        $exercicio = null;
        $mesReferencia = null;
        $codEntidade = null;
        $nroContratoDivida = null;

        if (true === empty($data)) {
            $data = $this->getRequest()->get('key');
            $data = explode(self::ID_SEPARATOR, $data);
            $data = array_filter($data);

            if (4 === count($data)) {
                list($exercicio, $mesReferencia, $codEntidade, $nroContratoDivida) = $data;
            }
        }

        $configuracaoDDC = null;

        if (false === empty($exercicio) && false === empty($mesReferencia) && false === empty($codEntidade) && false === empty($nroContratoDivida)) {
            $configuracaoDDC = $this->getRepository(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoDdc::class)
                ->findOneBy([
                    'exercicio' => $exercicio,
                    'mesReferencia' => $mesReferencia,
                    'codEntidade' => $codEntidade,
                    'nroContratoDivida' => $nroContratoDivida,
                ]);
        }

        $configuracaoDDC = null === $configuracaoDDC ? new \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoDdc() : $configuracaoDDC;

        return $configuracaoDDC;
    }

    /**
     * method name is set on js file
     *
     * gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterConfiguracaoArquivoDDC.php
     * gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterConfiguracaoArquivoDDC.php:137
     * gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterConfiguracaoArquivoDDC.php:52
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoDDC.js (button new)
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
        $configuracaoDDC = $this->getConfiguracaoDDCFromRequest();

        $em = $this->factory->getEntityManager();
        $classMetadata = $this->getClassMetadata(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoDdc::class);
        /** @var ConfiguracaoDdcRepository $repository */
        $repository = $em->getRepository(\Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoDdc::class);

        if (UnitOfWork::STATE_MANAGED === $em->getUnitOfWork()->getEntityState($configuracaoDDC)) {
            $key = implode(self::ID_SEPARATOR, $classMetadata->getIdentifierValues($configuracaoDDC));
        }

        $form = $this->getFormFactory()
            ->create(
                ConfiguracaoDDCType::class,
                $configuracaoDDC,
                [
                    'exercicio' => $this->factory->getSession()->getExercicio(),
                    'usuario' => $this->factory->getUser(),
                    'csrf_protection' => false
                ]
            );

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->handleRequest($this->getRequest());

            if (true === $form->isValid()) {
                // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterConfiguracaoArquivoDDC.php 71
                /** @var \Urbem\CoreBundle\Entity\Tcemg\ConfiguracaoDdc $found */
                $found = $repository->findOneBy([
                    'exercicio' => $configuracaoDDC->getExercicio(),
                    'mesReferencia' => $configuracaoDDC->getMesReferencia(),
                    'codEntidade' => $configuracaoDDC->getCodEntidade(),
                    'nroContratoDivida' => $configuracaoDDC->getNroContratoDivida(),
                ]);

                if ($found !== $configuracaoDDC) {
                    $message = sprintf(
                        'Arquivo DDC já foi incluído para o nro de contrato %s no mês %s do exercício de %s',
                        $found->getNroContratoDivida(),
                        $found->getMesReferencia(),
                        $found->getExercicio()
                    );

                } else {
                    $configuracaoOrgaoModel = new ConfiguracaoEntidadeModel($em);

                    if (UnitOfWork::STATE_NEW === $em->getUnitOfWork()->getEntityState($configuracaoDDC)) {
                        $message = 'Arquivo DDC incluído';

                    } else {
                        $message = 'Arquivo DDC alterado';
                    }

                    $configuracao = $configuracaoOrgaoModel->getCurrentConfig(
                        $configuracaoDDC->getFkOrcamentoEntidade()->getExercicio(),
                        $configuracaoDDC->getFkOrcamentoEntidade()->getCodEntidade(),
                        ConfiguracaoEntidade::PARAMETRO_TCE_MG_CODIGO_ORGAO_ENTIDADE_SICOM,
                        Modulo::MODULO_TCE_MG
                    );

                    $configuracaoDDC->setCodOrgao(null);

                    if (null !== $configuracao) {
                        $configuracaoDDC->setCodOrgao($configuracao->getValor());
                    }

                    $em->persist($configuracaoDDC);
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
            'message' => $message,
            'form' => $templating->render(
                "PrestacaoContasBundle::Tribunal/MG/Configuracao/DDC/form.html.twig",
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
     * gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterConfiguracaoArquivoDDC.php:187
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoDDC.js (button remove)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionRemoveConfiguracaoDDC(TwigEngine $templating)
    {
        $configuracaoDDC = $this->getConfiguracaoDDCFromRequest();

        $em = $this->factory->getEntityManager();
        $em->remove($configuracaoDDC);
        $em->flush();

        return [
            'message' => 'Arquivo DDC excluído'
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/DDC/main.html.twig");

        return $formMapper;
    }
}