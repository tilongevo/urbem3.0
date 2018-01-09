<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Configuracao;

use Doctrine\ORM\UnitOfWork;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcepr\SecretariaOrgao;
use Urbem\CoreBundle\Repository\Tcepr\SecretariaOrgaoRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Filter\SecretariaOrgaoFilter;
use Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Form\SecretariaOrgaoType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

final class ConfiguracaoSecretariaOrgao extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/PR/SecretariaOrgao.js',
        ];
    }

    /**
     * Factory method responsible for requests
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/PR/SecretariaOrgao.js
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
     * Find the SecretariaOrgao that is informed on request (key parameter)
     *
     * @return object|SecretariaOrgao
     */
    public function getSecretariaOrgaoFromRequest()
    {
        $codOrgao = null;
        $exercicio = null;
        $idSecretariaTce = null;

        $data = $this->getRequest()->get('key');
        $data = explode(self::ID_SEPARATOR, $data);
        $data = array_filter($data);

        if (3 === count($data)) {
            list($codOrgao, $exercicio, $idSecretariaTce) = $data;
        }

        $secretariaOrgao = null;

        if (false === empty($codOrgao) &&
            false === empty($exercicio) &&
            false === empty($idSecretariaTce)) {
            $secretariaOrgao = $this->getRepository(SecretariaOrgao::class)
                ->findOneBy([
                    'codOrgao' => $codOrgao,
                    'exercicio' => $exercicio,
                    'idSecretariaTce' => $idSecretariaTce,
                ]);
        }

        $secretariaOrgao = null === $secretariaOrgao ? new SecretariaOrgao() : $secretariaOrgao;

        return $secretariaOrgao;
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoSecretariaOrgao.js (button new)
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
        $secretariaOrgao = $this->getSecretariaOrgaoFromRequest();
        $em = $this->factory->getEntityManager();
        $classMetadata = $this->getClassMetadata(SecretariaOrgao::class);
        /** @var SecretariaOrgaoRepository $repository */
        $repository = $em->getRepository(SecretariaOrgao::class);

        if (UnitOfWork::STATE_MANAGED === $em->getUnitOfWork()->getEntityState($secretariaOrgao)) {
            $key = implode(self::ID_SEPARATOR, $classMetadata->getIdentifierValues($secretariaOrgao));
        }

        $form = $this->getFormFactory()
            ->create(
                SecretariaOrgaoType::class,
                $secretariaOrgao,
                [
                    'csrf_protection' => false
                ]
            );

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->handleRequest($this->getRequest());

            if (true === $form->isValid()) {
                if (null === $secretariaOrgao->getDtCadastro()) {
                    $secretariaOrgao->setDtCadastro(new \DateTime());
                    $secretariaOrgao->setExercicio($this->factory->getSession()->getExercicio());
                }

                $message = 'Secretaria Orgão inserida com sucesso!';

                $success = true;

                $em->persist($secretariaOrgao);
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
                "PrestacaoContasBundle::Tribunal/PR/Configuracao/SecretariaOrgao/form.html.twig",
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoSecretariaOrgao.js (button new)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadSecretariaOrgao()
    {
        /** @var SecretariaOrgaoRepository $repository */
        $repository = $this->getRepository(SecretariaOrgao::class);
        $classMetadata = $this->getClassMetadata(SecretariaOrgao::class);

        $data = $this->getRequest()->query->get($this->getRequest()->get('uniqid'));

        // src/Urbem/PrestacaoContasBundle/Service/Tribunal/PR/Form/SecretariaOrgaoFilterType.php
        $this->getForm()->submit($data);
        $formData = $this->processParameters();
        $formData = reset($formData);

        $filter = new SecretariaOrgaoFilter();
        $filter->setIdSecretariaTce($formData['idSecretariaTce']);

        $secretariaOrgaoList = $repository->getByFilter(
            $filter,
            /* https://datatables.net/manual/server-side */
            (int) $this->getRequest()->get('length', 0),
            (int) $this->getRequest()->get('start', 0)
        );

        $data = [];

        /** @var SecretariaOrgao $secretariaOrgao */
        foreach ($secretariaOrgaoList as $secretariaOrgao) {
            $rendered = [];

            $rendered['orgao'] = (string) $secretariaOrgao->getFkOrganogramaOrgao();
            $rendered['idSecretariaTce'] = (string) $secretariaOrgao->getIdSecretariaTce();

            // used on $this::getConfiguracaoConvenioFromRequest
            // web/bundles/prestacaocontas/js/Tribunal/PR/SecretariaOrgao.js (columnDefs)
            $rendered['key'] = implode(
                self::ID_SEPARATOR,
                $classMetadata->getIdentifierValues($secretariaOrgao)
            );

            $data[] = $rendered;
        }

        $total = $repository->getTotalByFilter($filter);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/PR/SecretariaOrgao.js (pageLength) */
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/PR/SecretariaOrgao.js (button remove)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionRemoveConfiguracaoSecretariaOrgao(TwigEngine $templating)
    {
        $secretaria = $this->getSecretariaOrgaoFromRequest();
        $em = $this->factory->getEntityManager();
        $em->remove($secretaria);
        $em->flush();

        return [
            'message' => 'Secretaria Orgão excluída com sucesso!'
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/PR/Configuracao/SecretariaOrgao/main.html.twig");

        return $formMapper;
    }
}