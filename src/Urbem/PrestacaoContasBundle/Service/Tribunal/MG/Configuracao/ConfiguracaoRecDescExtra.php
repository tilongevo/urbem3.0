<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Doctrine\Common\Proxy\Exception\OutOfBoundsException;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;
use Urbem\CoreBundle\Entity\Tcemg\BalanceteExtmmaa;
use Urbem\CoreBundle\Repository\Tcemg\BalanceteExtmmaaRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\RecDescExtraFilter;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\ConfiguracaoRecDescExtraType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

final class ConfiguracaoRecDescExtra extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoRecDescExtra.js'
        ];
    }

    /**
     * Find the BalanceteExtmmaa that is informed on request (key parameter)
     *
     * @return object|BalanceteExtmmaa
     * @throws \Exception
     */
    private function getBalanceteExtmmaaFromRequest()
    {
        $classMetadata = $this->getClassMetadata(BalanceteExtmmaa::class);
        $repository = $this->getRepository(BalanceteExtmmaa::class);

        try {
            $id = array_combine(
                $classMetadata->getIdentifierFieldNames(),
                explode(
                    self::ID_SEPARATOR,
                    $this->getRequest()->get('key')
                )
            );

            $balanceteExtmmaa = $repository->find($id);

            if (null === $balanceteExtmmaa) {
                throw new \OutOfBoundsException();
            }

        } catch (\Exception $e) {
            throw new \Exception(sprintf('Balancete "%s" não encontrado', $this->getRequest()->get('key')));
        }

        return $balanceteExtmmaa;
    }

    /**
     * Factory method responsible for requests
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoRecDescExtra.js
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
     * gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterExt.php:283
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadSubTipo(TwigEngine $templating)
    {
        $inTipoLancamento = $this->getRequest()->get('inTipoLancamento');

        $subTipos = ConfiguracaoRecDescExtraType::getSubTipos($inTipoLancamento);

        if (0 < count($subTipos)) {
            foreach ($subTipos as $name => $value) {
                $subTipos[$value] = [
                    'value' => $value,
                    'text' => $name
                ];

                unset($subTipos[$name]);
            }

            $subTipos[0] = [
                'value' => '',
                'text' => 'Selecione'
            ];
        }

        return [
            'subTipos' => $subTipos
        ];
    }

    /**
     * gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterExt.php:229
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadBalanceteExtmmaa()
    {
        /** @var BalanceteExtmmaaRepository $repository */
        $repository = $this->getRepository(BalanceteExtmmaa::class);
        $classMetadata = $this->getClassMetadata(BalanceteExtmmaa::class);

        // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Form/ConfiguracaoRecDescExtraType.php
        $filter = new RecDescExtraFilter();
        $filter->setCategoria($this->getRequest()->get('inCategoria'));
        $filter->setTipoLancamento($this->getRequest()->get('inTipoLancamento'));
        $filter->setSubTipoLancamento($this->getRequest()->get('inSubTipo'));
        $filter->setExercicio($this->factory->getSession()->getExercicio());

        $balanceteExtmmaaList = $repository->getByFilter(
            $filter,
            /* https://datatables.net/manual/server-side */
            (int) $this->getRequest()->get('length', 0),
            (int) $this->getRequest()->get('start', 0)
        );

        $data = [];
        /** @var BalanceteExtmmaa $balanceteExtmmaa */
        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterExt.php:57
        foreach ($balanceteExtmmaaList as $balanceteExtmmaa) {
            $data[] = [
                'codigo' => $balanceteExtmmaa->getCodPlano(),
                'codigoEstrutural' => $balanceteExtmmaa->getFkContabilidadePlanoAnalitica()->getFkContabilidadePlanoConta()->getCodEstrutural(),
                'descricao' => $balanceteExtmmaa->getFkContabilidadePlanoAnalitica()->getFkContabilidadePlanoConta()->getNomConta(),
                'key' => implode(
                    self::ID_SEPARATOR,
                    $classMetadata->getIdentifierValues($balanceteExtmmaa)
                )
            ];
        }

        $total = $repository->getTotalByFilter($filter);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoRecDescExtra.js */
        return [
            'draw' => (int) $this->getRequest()->get('draw', 0),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ];
    }


    /**
     * gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterExt.php:220
     * gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterExt.php:59
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionDeleteBalanceteExtmmaa(TwigEngine $templating)
    {
        $balanceteExtmmaa = $this->getBalanceteExtmmaaFromRequest();

        $em = $this->factory->getEntityManager();
        $em->remove($balanceteExtmmaa);
        $em->flush();

        return [
            'message' => 'Registro deletado'
        ];
    }

    /**
     * gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterExt.php:123
     * gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterExt.php:55
     *
     * @return array
     */
    public function actionSaveBalanceteExtmmaa()
    {
        $formFactory = $this->getFormFactory();

        $form = $formFactory->create(
            ConfiguracaoRecDescExtraType::class,
            null,
            ['csrf_protection' => true]
        );

        $data = $this->getRequest();
        $data = $data->get($this->getRequest()->get('uniqid'));
        $data = reset($data);

        unset($data['_token']);

        $form->submit($data);

        $inCategoria = (int) $form->get('inCategoria')->getData();
        $inTipoLancamento = (int) $form->get('inTipoLancamento')->getData();
        $inSubTipo = (int) $form->get('inSubTipo')->getData();

        /** @var PlanoConta $inCodConta */
        $inCodConta = $form->get('inCodConta')->getData();

        if (true === empty($inCodConta)) {
            throw new OutOfBoundsException('Conta inválida');
        }

        $inCodConta = array_combine(
            $this->getClassMetadata(PlanoConta::class)->getIdentifierFieldNames(),
            explode(
                self::ID_SEPARATOR,
                $inCodConta
            )
        );

        $inCodConta = $this->getRepository(PlanoConta::class)->find($inCodConta);

        if (null === $inCodConta) {
            throw new OutOfBoundsException('Conta inválida');
        }

        if (true === empty($inTipoLancamento)) {
            throw new OutOfBoundsException('Preencha o tipo do lançamento!');
        }

        if (true === in_array($inTipoLancamento, [1, 4]) && true === empty($inSubTipo)) {
            throw new OutOfBoundsException('Preencha o subtipo do lançamento!');
        }

        /** @var BalanceteExtmmaaRepository $repository */
        $repository = $this->getRepository(BalanceteExtmmaa::class);

        /** @var BalanceteExtmmaa $balanceteExtmmaa */
        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterExt.php:158
        $balanceteExtmmaa = $repository->findOneBy(['fkContabilidadePlanoAnalitica' => $inCodConta->getFkContabilidadePlanoAnalitica()]);

        if (null !== $balanceteExtmmaa) {
            $tipoLancamentos = ConfiguracaoRecDescExtraType::getTiposLancamentos();
            $tipoLancamentos = array_combine(array_values($tipoLancamentos), array_keys($tipoLancamentos));

            $tipoLancamento = $balanceteExtmmaa->getTipoLancamento();

            if (false === empty($tipoLancamentos[$balanceteExtmmaa->getTipoLancamento()])) {
                $tipoLancamento = $tipoLancamentos[$balanceteExtmmaa->getTipoLancamento()];
            }

            throw new OutOfBoundsException(sprintf('Esta conta já consta na lista do tipo %s', $tipoLancamento));
        }

        $inSubTipo = $repository->getSubTipoLancamento($inCodConta, $inSubTipo, $inTipoLancamento, $inCategoria);

        if (null === $inSubTipo) {
            return ['message' => 'Balancete não pode ser salvo (já existe)'];
        }

        $balanceteExtmmaa = new BalanceteExtmmaa();
        $balanceteExtmmaa->setCategoria($inCategoria);
        $balanceteExtmmaa->setTipoLancamento($inTipoLancamento);
        $balanceteExtmmaa->setSubTipoLancamento($inSubTipo);
        $balanceteExtmmaa->setFkContabilidadePlanoAnalitica($inCodConta->getFkContabilidadePlanoAnalitica());

        $em = $this->factory->getEntityManager();

        $em->persist($balanceteExtmmaa);
        $em->flush($balanceteExtmmaa);

        return ['message' => 'Balancete Salvo'];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/RecDescExtra/main.html.twig");

        return $formMapper;
    }
}