<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Doctrine\ORM\UnitOfWork;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Empenho\Empenho;
use Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao;
use Urbem\CoreBundle\Entity\Tcemg\NotaFiscal;
use Urbem\CoreBundle\Entity\Tcemg\NotaFiscalEmpenhoLiquidacao;
use Urbem\CoreBundle\Repository\Empenho\NotaLiquidacaoRepository;
use Urbem\CoreBundle\Repository\Tcemg\NotaFiscalRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\NotaFiscalFilter;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\ConfiguracaoNotaFiscalType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

final class ConfiguracaoNotaFiscal extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoNotaFiscal.js',
        ];
    }

    /**
     * Factory method responsible for requests
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoNotaFiscal.js
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoNotaFiscal.js (button filter)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadNotaFiscal()
    {
        /** @var NotaFiscalRepository $repository */
        $repository = $this->getRepository(NotaFiscal::class);
        $classMetadata = $this->getClassMetadata(NotaFiscal::class);

        $data = $this->getRequest()->query->get($this->getRequest()->get('uniqid'));

        // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Form/NotaFiscalFilterType.php
        $this->getForm()->submit($data);
        $formData = $this->processParameters();
        $formData = reset($formData);

        $filter = new NotaFiscalFilter();
        $filter->setNumNota($formData['numNota']);
        $filter->setNumSerie($formData['numSerie']);
        $filter->setDtEmissao($formData['dtEmissao']);
        $filter->setExercicioNota($formData['exercicioNota']);
        $filter->setExercicioEmpenho($formData['exercicioEmpenho']);
        $filter->setEntidade($formData['entidade']);
        $filter->setEmpenho($formData['empenho']);

        $licitacaoList = $repository->getByFilter(
            $filter,
            /* https://datatables.net/manual/server-side */
            (int) $this->getRequest()->get('length', 0),
            (int) $this->getRequest()->get('start', 0)
        );

        $data = [];

        /** @var NotaFiscal $notaFiscal */
        foreach ($licitacaoList as $notaFiscal) {
            $rendered = [];

            $rendered['numero'] = (string) $notaFiscal->getNroNota();
            $rendered['serie'] = (string) $notaFiscal->getNroSerie();
            $rendered['chave'] = (string) $notaFiscal->getChaveAcesso();
            $rendered['valor'] = (string) $notaFiscal->getVlTotalLiquido();

            $dtEmissao = $notaFiscal->getDataEmissao();
            $dtEmissao = true === $dtEmissao instanceof \DateTime ? $dtEmissao->format('d/m/Y') : '';

            $rendered['data'] = $dtEmissao;

            // used on $this::getConfiguracaoNotaFiscalFromRequest
            // web/bundles/prestacaocontas/js/Tribunal/MG/ConfiguracaoNotaFiscal.js (columnDefs)
            $rendered['key'] = implode(
                self::ID_SEPARATOR,
                $classMetadata->getIdentifierValues($notaFiscal)
            );

            $data[] = $rendered;
        }

        $total = $repository->getTotalByFilter($filter);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoNotaFiscal.js (pageLength) */
        return [
            'draw' => (int) $this->getRequest()->get('draw', 0),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ];
    }

    /**
     * Find the NotaFiscal that is informed on request (key parameter)
     *
     * @return object|NotaFiscal
     */
    public function getConfiguracaoNotaFiscalFromRequest()
    {
        $data = $this->getRequest()->get("configuracao_nota_fiscal", []);

        $codNota = null;
        $exercicio = null;
        $codEntidade = null;

        if (true === empty($data)) {
            $data = $this->getRequest()->get('key');
            $data = explode(self::ID_SEPARATOR, $data);
            $data = array_filter($data);

            if (3 === count($data)) {
                list($codNota, $exercicio, $codEntidade) = $data;
            }
        }

        $notaFiscal = null;

        if (false === empty($codNota) && false === empty($exercicio) && false === empty($codEntidade)) {
            $notaFiscal = $this->getRepository(NotaFiscal::class)
                ->findOneBy([
                    'codNota' => $codNota,
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                ]);
        }

        $notaFiscal = null === $notaFiscal ? new NotaFiscal() : $notaFiscal;

        return $notaFiscal;
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoNotaFiscal.js (button new)
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
        $notaFiscal = $this->getConfiguracaoNotaFiscalFromRequest();
        $em = $this->factory->getEntityManager();
        $classMetadata = $this->getClassMetadata(NotaFiscal::class);
        /** @var NotaFiscalRepository $repository */
        $repository = $em->getRepository(NotaFiscal::class);

        if (UnitOfWork::STATE_MANAGED === $em->getUnitOfWork()->getEntityState($notaFiscal)) {
            $key = implode(self::ID_SEPARATOR, $classMetadata->getIdentifierValues($notaFiscal));
        }

        $form = $this->getFormFactory()
            ->create(
                ConfiguracaoNotaFiscalType::class,
                $notaFiscal,
                [
                    'exercicio' => $this->factory->getSession()->getExercicio(),
                    'usuario' => $this->factory->getUser(),
                    'csrf_protection' => false
                ]
            );

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->handleRequest($this->getRequest());

            if (true === $form->isValid()) {
                if (null === $key) {
                    $message = 'Incluir Notas Fiscais concluído com sucesso!';

                } else {
                    $message = 'Alterar Notas Fiscais concluído com sucesso!';
                }

                if (null === $notaFiscal->getCodNota()) {
                    $notaFiscal->setCodNota($repository->getNextCodNota());
                }

                /** @var NotaFiscalEmpenhoLiquidacao $notaLiquidicao */
                foreach ($notaFiscal->getFkTcemgNotaFiscalEmpenhoLiquidacoes() as $notaLiquidicao) {
                    $notaLiquidicao->setCodNota($notaFiscal->getCodNota());
                    $notaLiquidicao->setExercicio($notaFiscal->getExercicio());
                    $notaLiquidicao->setCodEntidade($notaFiscal->getCodEntidade());
                }

                //gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterNotasFiscais.php:112
                $notaFiscal->setVlTotalLiquido($notaFiscal->getVlTotal() - $notaFiscal->getVlDesconto());

                $em->persist($notaFiscal);
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
            'message' => $message,
            'form' => $templating->render(
                "PrestacaoContasBundle::Tribunal/MG/Configuracao/NotaFiscal/form.html.twig",
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
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoNotaFiscal.js (button new)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadNotaLiquidicaoByEmpenho()
    {
        $empenho = $this->getRequest()->get('empenho');

        try {
            if (true === empty($empenho)) {
                throw new \OutOfBoundsException();
            }

            $empenho = explode(self::ID_SEPARATOR, $empenho);
            $classMetadata = $this->getClassMetadata(Empenho::class);
            $empenho = array_combine(
                $classMetadata->getIdentifierFieldNames(),
                $empenho
            );

            $empenho = $this->getRepository(Empenho::class)->find($empenho);

            if (null == $empenho) {
                throw new \OutOfBoundsException();
            }

            /** @var NotaLiquidacaoRepository $notaLiquidacaoRepository */
            $notaLiquidacaoRepository = $this->getRepository(NotaLiquidacao::class);

            $notas = [];

            $classMetadata = $this->getClassMetadata(NotaLiquidacao::class);

            /** @var NotaLiquidacao $notaLiquidacao */
            foreach ($notaLiquidacaoRepository->getByEmpenhoFromMGAsQueryBuilder($empenho)
                         ->getQuery()
                         ->getResult() as $notaLiquidacao) {

                $notas[] = [
                    'value' => implode(self::ID_SEPARATOR, $classMetadata->getIdentifierValues($notaLiquidacao)),
                    'text' => sprintf('%s - %s', $notaLiquidacao->getCodNota(), $notaLiquidacao->getDtLiquidacao()->format('d/m/Y'))
                ];
            }

            return [
                'notas_liquidacao' => $notas
            ];

        } catch (\Exception $e) {
            return [
                'notas_liquidacao' => []
            ];
        }
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoNotaFiscal.js (button remove)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionRemoveConfiguracaoNotaFiscal(TwigEngine $templating)
    {
        $notaFiscal = $this->getConfiguracaoNotaFiscalFromRequest();
        $em = $this->factory->getEntityManager();
        $em->remove($notaFiscal);
        $em->flush();

        return [
            'message' => 'Excluir Notas Fiscais concluído com sucesso!'
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/NotaFiscal/main.html.twig");

        return $formMapper;
    }
}