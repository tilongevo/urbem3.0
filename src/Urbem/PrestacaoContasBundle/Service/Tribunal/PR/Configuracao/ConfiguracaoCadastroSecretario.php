<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Configuracao;

use Doctrine\ORM\UnitOfWork;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcepr\CadastroSecretario;
use Urbem\CoreBundle\Repository\Tcepr\CadastroSecretarioRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Filter\CadastroSecretarioFilter;
use Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Form\CadastroSecretarioType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

final class ConfiguracaoCadastroSecretario extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/PR/CadastroSecretario.js',
        ];
    }

    /**
     * Factory method responsible for requests
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/PR/CadastroSecretario.js
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoCadastroSecretario.js (button new)
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
                CadastroSecretarioType::class,
                $cadastroSecretario,
                [
                    'csrf_protection' => false
                ]
            );

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->handleRequest($this->getRequest());

            if (true === $form->isValid()) {
                $message = [];

                if (0 === count($message)) {
                    if (null === $cadastroSecretario->getNumCadastro()) {
                        $cadastroSecretario->setNumCadastro($repository->getNextNumCadastro());
                        $cadastroSecretario->setExercicio($this->factory->getSession()->getExercicio());
                    }

                    if (null === $key) {
                        $message = 'Cadastro Secretário inserido com sucesso!';

                    } else {
                        $message = 'Cadastro Secretário alterado com sucesso!';
                    }

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
                "PrestacaoContasBundle::Tribunal/PR/Configuracao/CadastroSecretario/form.html.twig",
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoCadastroSecretario.js (button new)
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
            // web/bundles/prestacaocontas/js/Tribunal/PR/CadastroSecretario.js (columnDefs)
            $rendered['key'] = implode(
                self::ID_SEPARATOR,
                $classMetadata->getIdentifierValues($cadastroSecretario)
            );

            $data[] = $rendered;
        }

        $total = $repository->getTotalByFilter($filter);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/PR/CadastroSecretario.js (pageLength) */
        return [
            'draw' => (int) $this->getRequest()->get('draw', 0),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ];
    }


    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/PR/CadastroSecretario.js (button remove)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionRemoveConfiguracaoCadastroSecretario(TwigEngine $templating)
    {
        $cadastro = $this->getCadastroSecretarioFromRequest();
        $em = $this->factory->getEntityManager();
        $em->remove($cadastro);
        $em->flush();

        return [
            'message' => 'Cadastro de Secretário excluído com sucesso!'
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/PR/Configuracao/CadastroSecretario/main.html.twig");

        return $formMapper;
    }
}