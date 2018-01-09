<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Configuracao;

use Doctrine\ORM\UnitOfWork;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcepr\ResponsavelModulo;
use Urbem\CoreBundle\Repository\Tcepr\ResponsavelModuloRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Filter\ResponsavelModuloFilter;
use Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Form\ResponsavelModuloType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

final class ConfiguracaoResponsavelModulo extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/PR/ResponsavelModulo.js',
        ];
    }

    /**
     * Factory method responsible for requests
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/PR/ResponsavelModulo.js
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
     * Find the ResponsavelModulo that is informed on request (key parameter)
     *
     * @return object|ResponsavelModulo
     */
    public function getResponsavelModuloFromRequest()
    {
        $codResponsavel = null;

        $data = $this->getRequest()->get('key');
        $data = explode(self::ID_SEPARATOR, $data);
        $data = array_filter($data);

        if (1 === count($data)) {
            list($codResponsavel) = $data;
        }

        $responsavelModulo = null;

        if (false === empty($codResponsavel)) {
            $responsavelModulo = $this->getRepository(ResponsavelModulo::class)
                ->findOneBy([
                    'codResponsavel' => $codResponsavel,
                ]);
        }

        $responsavelModulo = null === $responsavelModulo ? new ResponsavelModulo() : $responsavelModulo;

        return $responsavelModulo;
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoResponsavelModulo.js (button new)
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
        $responsavelModulo = $this->getResponsavelModuloFromRequest();
        $em = $this->factory->getEntityManager();
        $classMetadata = $this->getClassMetadata(ResponsavelModulo::class);
        /** @var ResponsavelModuloRepository $repository */
        $repository = $em->getRepository(ResponsavelModulo::class);

        if (UnitOfWork::STATE_MANAGED === $em->getUnitOfWork()->getEntityState($responsavelModulo)) {
            $key = implode(self::ID_SEPARATOR, $classMetadata->getIdentifierValues($responsavelModulo));
        }

        $form = $this->getFormFactory()
            ->create(
                ResponsavelModuloType::class,
                $responsavelModulo,
                [
                    'csrf_protection' => false
                ]
            );

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->handleRequest($this->getRequest());

            if (true === $form->isValid()) {
                $message = [];

                if (0 === count($message)) {
                    if (null === $responsavelModulo->getNumCadastro()) {
                        $responsavelModulo->setCodResponsavel($repository->getNextCodResponsavel());
                    }

                    if (null === $key) {
                        $message = 'Responsávelo Módulo inserido com sucesso!';

                    } else {
                        $message = 'Responsávelo Módulo alterado com sucesso!';
                    }

                    $success = true;

                    $em->persist($responsavelModulo);
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
                "PrestacaoContasBundle::Tribunal/PR/Configuracao/ResponsavelModulo/form.html.twig",
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoResponsavelModulo.js (button new)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadResponsavelModulo()
    {
        /** @var ResponsavelModuloRepository $repository */
        $repository = $this->getRepository(ResponsavelModulo::class);
        $classMetadata = $this->getClassMetadata(ResponsavelModulo::class);

        $data = $this->getRequest()->query->get($this->getRequest()->get('uniqid'));

        // src/Urbem/PrestacaoContasBundle/Service/Tribunal/PR/Form/ResponsavelModuloFilterType.php
        $this->getForm()->submit($data);
        $formData = $this->processParameters();
        $formData = reset($formData);

        $filter = new ResponsavelModuloFilter();
        $filter->setFkTceprTipoModulo($formData['fkTceprTipoModulo']);

        $responsavelModuloList = $repository->getByFilter(
            $filter,
            /* https://datatables.net/manual/server-side */
            (int) $this->getRequest()->get('length', 0),
            (int) $this->getRequest()->get('start', 0)
        );

        $data = [];

        /** @var ResponsavelModulo $responsavelModulo */
        foreach ($responsavelModuloList as $responsavelModulo) {
            $rendered = [];

            $dataInicio = $responsavelModulo->getDtInicioVinculo();
            $dataInicio = true === $dataInicio instanceof \DateTime ? $dataInicio->format('d/m/Y') : '-';

            $dataBaixa = $responsavelModulo->getDtBaixa();
            $dataBaixa = true === $dataBaixa instanceof \DateTime ? $dataBaixa->format('d/m/Y') : '-';

            $rendered['fkTceprTipoModulo'] = (string) $responsavelModulo->getFkTceprTipoModulo();
            $rendered['fkTceprTipoResponsavelModulo'] = (string) $responsavelModulo->getFkTceprTipoResponsavelModulo();
            $rendered['fkSwCgm'] = (string) $responsavelModulo->getFkSwCgm();
            $rendered['dataInicio'] = $dataInicio;
            $rendered['dataBaixa'] = $dataBaixa;

            // web/bundles/prestacaocontas/js/Tribunal/PR/ResponsavelModulo.js (columnDefs)
            $rendered['key'] = implode(
                self::ID_SEPARATOR,
                $classMetadata->getIdentifierValues($responsavelModulo)
            );

            $data[] = $rendered;
        }

        $total = $repository->getTotalByFilter($filter);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/PR/ResponsavelModulo.js (pageLength) */
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/PR/ResponsavelModulo.js (button remove)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionRemoveConfiguracaoResponsavelModulo(TwigEngine $templating)
    {
        $cadastro = $this->getResponsavelModuloFromRequest();
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

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/PR/Configuracao/ResponsavelModulo/main.html.twig");

        return $formMapper;
    }
}