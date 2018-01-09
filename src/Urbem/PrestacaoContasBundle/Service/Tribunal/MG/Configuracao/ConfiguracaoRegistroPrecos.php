<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Doctrine\ORM\UnitOfWork;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Tcemg\RegistroPrecos;
use Urbem\CoreBundle\Repository\Tcemg\RegistroPrecosRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\RegistroPrecosFilter;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\ConfiguracaoRegistroPrecosFilterType;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\RegistroPrecos\RegistroPrecosType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

final class ConfiguracaoRegistroPrecos extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoRegistroPrecos.js',
        ];
    }

    /**
     * Factory method responsible for requests
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoRegistroPrecos.js
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
//            $x = call_user_func_array([$this, $action], [$templating]);
//
//            echo $x['form'];
//            exit;
            return [
                'response' => true,
                // action* methods must always return an array
            ] + call_user_func_array([$this, $action], [$templating]);

        } catch (\Exception $e) {
            dump($e);
            exit;
            return [
                'response' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoRegistroPrecos.js (button filter)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadRegistroPrecos()
    {
        /** @var RegistroPrecosRepository $repository */
        $repository = $this->getRepository(RegistroPrecos::class);
        $classMetadata = $this->getClassMetadata(RegistroPrecos::class);

        $data = $this->getRequest()->query->get($this->getRequest()->get('uniqid'));

        // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Form/ConfiguracaoRegistroPrecosFilterType.php
        $this->getForm()->submit($data);
        $formData = $this->processParameters();
        $formData = reset($formData);

        $filter = new RegistroPrecosFilter();
        $filter->setEntidade($formData['entidade']);
        $filter->setEmpenho($formData['empenho']);
        $filter->setLicitacao($formData['licitacao']);
        $filter->setModalidade($formData['modalidade']);
        $filter->setNumeroRegistroPrecos($formData['numeroRegistroPrecos']);

        $registroPrecosList = $repository->getByFilter(
            $filter,
            /* https://datatables.net/manual/server-side */
            (int) $this->getRequest()->get('length', 0),
            (int) $this->getRequest()->get('start', 0)
        );

        $data = [];

        /** @var RegistroPrecos $registroPrecos */
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/classes/mapeamento/TTCEMGRegistroPrecos.class.php:89 */
        foreach ($registroPrecosList as $registroPrecos) {
            $rendered = [];

            $dataAberturaRegistroPrecos = $registroPrecos->getDataAberturaRegistroPrecos();
            $dataAberturaRegistroPrecos = true === $dataAberturaRegistroPrecos instanceof \DateTime ? $dataAberturaRegistroPrecos->format('d/m/Y') : '';

            $rendered['registroPrecos'] = (string) $registroPrecos;
            $rendered['dataAberturaRegistroPrecos'] = $dataAberturaRegistroPrecos;
            $rendered['codigoProcessoLicitacao'] = sprintf(
                '%015d/%s',
                (int) $registroPrecos->getNumeroProcessoLicitacao(),
                $registroPrecos->getExercicioLicitacao()
            );
            $rendered['tipoRegPrecos'] = true === $registroPrecos->getInterno() ? 'Interno' : 'Externo';
            $rendered['modalidade'] = 1 === (int) $registroPrecos->getCodigoModalidadeLicitacao() ? 'Concorrência' : 'Pregão';
            $rendered['numeroModalidade'] = $registroPrecos->getNumeroModalidade();
            $rendered['cgmGerenciador'] = (string) $registroPrecos->getFkSwCgmPessoaFisica();

            // used on $this::getConfiguracaoRegistroPrecosFromRequest
            // web/bundles/prestacaocontas/js/Tribunal/MG/ConfiguracaoRegistroPrecos.js (columnDefs)
            $rendered['key'] = implode(
                self::ID_SEPARATOR,
                $classMetadata->getIdentifierValues($registroPrecos)
            );

            $data[] = $rendered;
        }

        $total = $repository->getTotalByFilter($filter);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoRegistroPrecos.js (pageLength) */
        return [
            'draw' => (int) $this->getRequest()->get('draw', 0),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ];
    }

    /**
     * Find the RegistroPrecos that is informed on request (key parameter)
     *
     * @return object|RegistroPrecos
     */
    public function getConfiguracaoRegistroPrecosFromRequest()
    {
        $codEntidade = null;
        $numeroRegistroPrecos = null;
        $exercicio = null;
        $numcgmGerenciador = null;
        $interno = null;

        $data = $this->getRequest()->get('key');
        $data = explode(self::ID_SEPARATOR, $data);
        $data = array_filter($data);

        if (5 === count($data)) {
            list($codEntidade, $numeroRegistroPrecos, $exercicio, $numcgmGerenciador, $interno) = $data;
        }

        $registroPrecos = null;

        if (false === empty($codEntidade) && false === empty($numeroRegistroPrecos) && false === empty($exercicio)
            && false === empty($numcgmGerenciador) && false === empty($interno)) {
            $registroPrecos = $this->getRepository(RegistroPrecos::class)
                ->findOneBy([
                    'codEntidade' => $codEntidade,
                    'numeroRegistroPrecos' => $numeroRegistroPrecos,
                    'exercicio' => $exercicio,
                    'numcgmGerenciador' => $numcgmGerenciador,
                    'interno' => $interno,
                ]);
        }

        $registroPrecos = null === $registroPrecos ? new RegistroPrecos() : $registroPrecos;

        return $registroPrecos;
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoRegistroPrecos.js (button new)
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

        $registroPrecos = $this->getConfiguracaoRegistroPrecosFromRequest();
        $em = $this->factory->getEntityManager();
        $classMetadata = $this->getClassMetadata(RegistroPrecos::class);

        if (UnitOfWork::STATE_MANAGED === $em->getUnitOfWork()->getEntityState($registroPrecos)) {
            $key = implode(self::ID_SEPARATOR, $classMetadata->getIdentifierValues($registroPrecos));
        }

        $form = $this->getFormFactory()
            ->create(
                RegistroPrecosType::class,
                $registroPrecos,
                [
                    'csrf_protection' => false,
                    'exercicio' => $this->factory->getSession()->getExercicio(),
                    'usuario' => $this->factory->getUser(),
                ]
            );

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->handleRequest($this->getRequest());

            if (true === $form->isValid()) {
                if (null === $key) {
                    $message = 'Registro de Preços inserido com sucesso!';

                } else {
                    $message = 'Registro de Preços alterado com sucesso!';
                }

                $success = true;

                $em->persist($registroPrecos);
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
                "PrestacaoContasBundle::Tribunal/MG/Configuracao/RegistroPrecos/form.html.twig",
                [
                    'exercicio' => $this->factory->getSession()->getExercicio(),
                    'form' => $formView,
                    'key' => $key,
                ]
            )
        ];
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoRegistroPrecos.js (button remove)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionRemoveConfiguracaoRegistroPrecos(TwigEngine $templating)
    {
        $registroPrecos = $this->getConfiguracaoRegistroPrecosFromRequest();
        $em = $this->factory->getEntityManager();
        $em->remove($registroPrecos);
        $em->flush();

        return [
            'message' => 'Registro de Preços excluído com sucesso!'
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/RegistroPrecos/main.html.twig");

        return $formMapper;
    }
}