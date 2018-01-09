<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Configuracao;

use Doctrine\ORM\UnitOfWork;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcepr\CadastroSecretario;
use Urbem\CoreBundle\Repository\Tcepr\CadastroSecretarioRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Filter\CadastroSecretarioFilter;
use Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Form\BaixaCadastroSecretarioType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

final class ConfiguracaoBaixaCadastroSecretario extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/PR/BaixaCadastroSecretario.js',
        ];
    }

    /**
     * Factory method responsible for requests
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/PR/BaixaCadastroSecretario.js
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     *
     * @param TwigEngine|null $templating
     * @return array
     */
    public function buildServiceProvider(TwigEngine $templating = null)
    {
        return $this->doAction($templating);
    }

    /**
     * Find the CadastroSecretario that is informed on request (key parameter)
     *
     * @return object|CadastroSecretario
     */
    public function getCadastroSecretarioFromRequest()
    {
        $numCadastro = null;
        $codOrgao = null;
        $exercicio = null;
        $numcgm = null;

        $data = $this->getRequest()->get('key');
        $data = explode(self::ID_SEPARATOR, $data);
        $data = array_filter($data);

        if (4 === count($data)) {
            list($numCadastro, $codOrgao, $exercicio, $numcgm) = $data;
        }

        $cadastroSecretario = null;

        if (false === empty($numCadastro) &&
            false === empty($codOrgao) &&
            false === empty($exercicio) &&
            false === empty($numcgm)) {
            $cadastroSecretario = $this->getRepository(CadastroSecretario::class)
                ->findOneBy([
                    'numCadastro' => $numCadastro,
                    'codOrgao' => $codOrgao,
                    'exercicio' => $exercicio,
                    'numcgm' => $numcgm,
                ]);
        }

        $cadastroSecretario = null === $cadastroSecretario ? new CadastroSecretario() : $cadastroSecretario;

        return $cadastroSecretario;
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/BaixaCadastroSecretario.js (button new)
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
        $cadastroSecretario = $this->getCadastroSecretarioFromRequest();
        $em = $this->factory->getEntityManager();
        $classMetadata = $this->getClassMetadata(CadastroSecretario::class);
        /** @var CadastroSecretarioRepository $repository */
        $repository = $em->getRepository(CadastroSecretario::class);

        if (UnitOfWork::STATE_MANAGED === $em->getUnitOfWork()->getEntityState($cadastroSecretario)) {
            $key = implode(self::ID_SEPARATOR, $classMetadata->getIdentifierValues($cadastroSecretario));
        }

        $form = $this->getFormFactory()
            ->create(
                BaixaCadastroSecretarioType::class,
                $cadastroSecretario,
                [
                    'csrf_protection' => false
                ]
            );

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->handleRequest($this->getRequest());

            if (true === $form->isValid()) {
                $message = [];

                if (null === $cadastroSecretario->getNumCadastro()) {
                    $message[] = 'Cadastro de Secretário não encontrado';
                }

                if (0 === count($message)) {
                    $message = 'Baixa de Secretário inserida com sucesso!';

                    $success = true;

                    $em->persist($cadastroSecretario);
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
                "PrestacaoContasBundle::Tribunal/PR/Configuracao/BaixaCadastroSecretario/form.html.twig",
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoBaixaSecretario.js (button new)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadCadastroSecretario()
    {
        /** @var CadastroSecretarioRepository $repository */
        $repository = $this->getRepository(CadastroSecretario::class);
        $classMetadata = $this->getClassMetadata(CadastroSecretario::class);

        $data = $this->getRequest()->query->get($this->getRequest()->get('uniqid'));

        // src/Urbem/PrestacaoContasBundle/Service/Tribunal/PR/Form/CadastroSecretarioFilterType.php
        $this->getForm()->submit($data);
        $formData = $this->processParameters();
        $formData = reset($formData);

        $filter = new CadastroSecretarioFilter();
        $filter->setNumCadastro($formData['numCadastro']);

        $cadastroSecretarioList = $repository->getByFilter(
            $filter,
            /* https://datatables.net/manual/server-side */
            (int) $this->getRequest()->get('length', 0),
            (int) $this->getRequest()->get('start', 0)
        );

        $data = [];

        /** @var CadastroSecretario $cadastroSecretario */
        foreach ($cadastroSecretarioList as $cadastroSecretario) {
            $rendered = [];

            $dataInicio = $cadastroSecretario->getDtInicioVinculo();
            $dataInicio = true === $dataInicio instanceof \DateTime ? $dataInicio->format('d/m/Y') : '-';

            $dataBaixa = $cadastroSecretario->getDtBaixa();
            $dataBaixa = true === $dataBaixa instanceof \DateTime ? $dataBaixa->format('d/m/Y') : '-';

            $rendered['numCadastro'] = (string) $cadastroSecretario;
            $rendered['orgao'] = (string) $cadastroSecretario->getFkOrganogramaOrgao();
            $rendered['secretario'] = (string) $cadastroSecretario->getFkSwCgmPessoaFisica();
            $rendered['dataInicio'] = $dataInicio;
            $rendered['dataBaixa'] = $dataBaixa;

            // used on $this::getConfiguracaoConvenioFromRequest
            // web/bundles/prestacaocontas/js/Tribunal/PR/BaixaSecretario.js (columnDefs)
            $rendered['key'] = implode(
                self::ID_SEPARATOR,
                $classMetadata->getIdentifierValues($cadastroSecretario)
            );

            $data[] = $rendered;
        }

        $total = $repository->getTotalByFilter($filter);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/PR/BaixaCadastroSecretario.js (pageLength) */
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

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/PR/Configuracao/BaixaCadastroSecretario/main.html.twig");

        return $formMapper;
    }
}