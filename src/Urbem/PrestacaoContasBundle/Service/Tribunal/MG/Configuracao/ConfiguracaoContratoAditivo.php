<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Configuracao;

use Doctrine\ORM\UnitOfWork;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\TwigEngine;
use Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho;
use Urbem\CoreBundle\Entity\Tcemg\Contrato;
use Urbem\CoreBundle\Entity\Tcemg\ContratoAditivo;
use Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoAditivo;
use Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoEmpenho;
use Urbem\CoreBundle\Entity\Tcemg\ContratoAditivoItem;
use Urbem\CoreBundle\Entity\Tcemg\ContratoEmpenho;
use Urbem\CoreBundle\Repository\Tcemg\ContratoAditivoItemRepository;
use Urbem\CoreBundle\Repository\Tcemg\ContratoAditivoRepository;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Filter\ContratoAditivoFilter;
use Urbem\PrestacaoContasBundle\Service\Tribunal\MG\Form\ConfiguracaoContratoAditivoType;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoAbstract;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\ConfiguracaoInterface;
use Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface;

final class ConfiguracaoContratoAditivo extends ConfiguracaoAbstract implements ConfiguracaoInterface
{
    /**
     * @return array
     */
    public function includeJs()
    {
        return [
            '/prestacaocontas/js/Tribunal/MG/ConfiguracaoContratoAditivo.js',
        ];
    }

    /**
     * Factory method responsible for requests
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoAditivo.js
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoAditivo.js (button filter)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadContratoAditivo()
    {
        /** @var ContratoAditivoRepository $repository */
        $repository = $this->getRepository(ContratoAditivo::class);
        $classMetadata = $this->getClassMetadata(ContratoAditivo::class);

        $data = $this->getRequest()->query->get($this->getRequest()->get('uniqid'));

        // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Form/ConfiguracaoContratoAditivoFilterType.php
        $this->getForm()->submit($data);
        $formData = $this->processParameters();
        $formData = reset($formData);

        $filter = new ContratoAditivoFilter();
        $filter->setNroContrato($formData['nroContrato']);
        $filter->setDataAssinatura($formData['dataAssinatura']);
        $filter->setNroAditivo($formData['nroAditivo']);
        $filter->setEntidades($formData['entidades']);

        $contratoAditivoList = $repository->getByFilter(
            $filter,
            /* https://datatables.net/manual/server-side */
            (int) $this->getRequest()->get('length', 0),
            (int) $this->getRequest()->get('start', 0)
        );

        $data = [];

        /** @var ContratoAditivo $contratoAditivo */
        foreach ($contratoAditivoList as $contratoAditivo) {
            $rendered = [];

            $dataAssinatura = $contratoAditivo->getDataAssinatura();
            $dataAssinatura = true === $dataAssinatura instanceof \DateTime ? $dataAssinatura->format('d/m/Y') : '';

            $rendered['entidade'] = (string) $contratoAditivo->getFkTcemgContrato()->getFkOrcamentoEntidade();
            $rendered['contrato'] = (string) $contratoAditivo->getFkTcemgContrato();
            $rendered['aditivo'] = (string) $contratoAditivo;
            $rendered['dataAditivo'] = $dataAssinatura;
            $rendered['objeto'] = (string) $contratoAditivo->getFkTcemgContrato()->getObjetoContrato();

            // used on $this::getConfiguracaoContratoAditivoFromRequest
            // web/bundles/prestacaocontas/js/Tribunal/MG/ConfiguracaoContratoAditivo.js (columnDefs)
            $rendered['key'] = implode(
                self::ID_SEPARATOR,
                $classMetadata->getIdentifierValues($contratoAditivo)
            );

            $data[] = $rendered;
        }

        $total = $repository->getTotalByFilter($filter);

        /* https://datatables.net/manual/server-side */
        /* items per page is set on src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoAditivo.js (pageLength) */
        return [
            'draw' => (int) $this->getRequest()->get('draw', 0),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ];
    }

    /**
     * Find the ContratoAditivo that is informed on request (key parameter)
     *
     * @return object|ContratoAditivo
     */
    public function getConfiguracaoContratoAditivoFromRequest()
    {
        $codContratoAditivo = null;
        $exercicio = null;
        $codEntidade = null;

        $data = $this->getRequest()->get('key');
        $data = explode(self::ID_SEPARATOR, $data);
        $data = array_filter($data);

        if (3 === count($data)) {
            list($codContratoAditivo, $exercicio, $codEntidade) = $data;
        }

        $contratoAditivo = null;

        if (false === empty($codContratoAditivo) && false === empty($exercicio) && false === empty($codEntidade)) {
            $contratoAditivo = $this->getRepository(ContratoAditivo::class)
                ->findOneBy([
                    'codContratoAditivo' => $codContratoAditivo,
                    'codEntidade' => $codEntidade,
                    'exercicio' => $exercicio,
                ]);
        }

        $contratoAditivo = null === $contratoAditivo ? new ContratoAditivo() : $contratoAditivo;

        return $contratoAditivo;
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoAditivo.js (button new)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionLoadDynamicForm(TwigEngine $templating)
    {
        $contratoAditivo = $this->getConfiguracaoContratoAditivoFromRequest();

        $form = $this->getFormFactory()
            ->create(
                ConfiguracaoContratoAditivoType::class,
                $contratoAditivo,
                [
                    'csrf_protection' => false
                ]
            );

        $form->submit($this->getRequest()->query->get('configuracao_contrato_aditivo'));

        $contratoAditivo = $this->createContratoAditivoItem($form->getData());

        $form = $this->getFormFactory()
            ->create(
                ConfiguracaoContratoAditivoType::class,
                $contratoAditivo,
                [
                    'csrf_protection' => false,
                    'show_error' => false
                ]
            );

        $formView = $form->createView();

        return [
            'form' => $templating->render(
                "PrestacaoContasBundle::Tribunal/MG/Configuracao/ContratoAditivo/form_ajax.html.twig",
                [
                    'form' => $formView,
                    'show_error' => false,
                ]
            ),
        ];
    }

    protected function createContratoAditivoItem(ContratoAditivo $contratoAditivo)
    {
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterAditivoContrato.php:132 */
        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:55 */
        /** @var ContratoEmpenho $contratoEmpenho */
        $contrato = $contratoAditivo->getFkTcemgContrato();

        if (null !== $contrato) {
            $this->factory->getEntityManager()->refresh($contrato);
        }

        $contrato = null === $contrato ? new Contrato() : $contrato;
        
        foreach ($contratoAditivo->getFkTcemgContratoAditivoItens() as $contratoAditivoItem) {
            $contratoAditivo->removeFkTcemgContratoAditivoItens($contratoAditivoItem);
        }

        foreach ($contrato->getFkTcemgContratoEmpenhos() as $contratoEmpenho) {
            $empenho = $contratoEmpenho->getFkEmpenhoEmpenho();

            if (null === $empenho) {
                continue;
            }

            $preEmpenho = $empenho->getFkEmpenhoPreEmpenho();

            if (null === $preEmpenho) {
                continue;
            }

            /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterAditivoContrato.php:149 */
            /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:63 */
            /** @var ItemPreEmpenho $itemPreEmpenho */
            foreach ($preEmpenho->getFkEmpenhoItemPreEmpenhos() as $itemPreEmpenho) {

                $contratoAditivoItem = new ContratoAditivoItem();
                $contratoAditivoItem->setFkEmpenhoEmpenho($empenho);
                $contratoAditivoItem->setFkEmpenhoPreEmpenho($preEmpenho);
                $contratoAditivoItem->setFkEmpenhoItemPreEmpenho($itemPreEmpenho);
                $contratoAditivoItem->setQuantidade($itemPreEmpenho->getQuantidade());

                $contratoAditivo->addFkTcemgContratoAditivoItens($contratoAditivoItem);
            }
        }

        return $contratoAditivo;
    }

    /**
     * method name is set on js file
     *
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoAditivo.js (button new)
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
        $contratoAditivo = $this->getConfiguracaoContratoAditivoFromRequest();
        $em = $this->factory->getEntityManager();
        $classMetadata = $this->getClassMetadata(ContratoAditivo::class);
        /** @var ContratoAditivoRepository $repository */
        $repository = $em->getRepository(ContratoAditivo::class);

        if (UnitOfWork::STATE_MANAGED === $em->getUnitOfWork()->getEntityState($contratoAditivo)) {
            $key = implode(self::ID_SEPARATOR, $classMetadata->getIdentifierValues($contratoAditivo));
        }

        foreach ($contratoAditivo->getFkTcemgContratoAditivoItens() as $contratoAditivoItem) {
            $contratoAditivo->removeFkTcemgContratoAditivoItens($contratoAditivoItem);

            $em->remove($contratoAditivo);
        }

        $contratoAditivo = $this->createContratoAditivoItem($contratoAditivo);

        $form = $this->getFormFactory()
            ->create(
                ConfiguracaoContratoAditivoType::class,
                $contratoAditivo,
                [
                    'csrf_protection' => false
                ]
            );

        if ('POST' === $this->getRequest()->getMethod()) {
            $form->handleRequest($this->getRequest());

            if (true === $form->isValid()) {
                $message = [];

                if (0 === count($message)) {
                    if (null === $contratoAditivo->getCodContratoAditivo()) {
                        $contratoAditivo->setCodContratoAditivo($repository->getNextCodContratoAditivo());
                    }

                    $total = 0;

                    /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterAditivoContrato.php:134 */
                    if (4 === $contratoAditivo->getCodTipoAditivo() || 5 === $contratoAditivo->getCodTipoAditivo()) {
                        $total = $contratoAditivo->getValor();
                    }

                    /** @var ContratoAditivoItem $contratoAditivoItem */
                    /* fix */
                    /** @var ContratoAditivoItemRepository $contratoAditivoItemRepo */
                    $contratoAditivoItemRepo = $this->getRepository(ContratoAditivoItem::class);
                    foreach ($contratoAditivo->getFkTcemgContratoAditivoItens() as $contratoAditivoItem) {
                        $contratoAditivoItem->setCodContratoAditivoItem($contratoAditivoItemRepo->getNextCodContratoAditivoItem());
                        $contratoAditivoItem->setFkTcemgContratoAditivo($contratoAditivo);
                    }

                    /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterAditivoContrato.php:138 */
                    if ((9 <= $contratoAditivo->getCodTipoAditivo() && 11 >= $contratoAditivo->getCodTipoAditivo()) || 14 === $contratoAditivo->getCodTipoAditivo()) {
                        /** @var ContratoAditivoItem $item */
                        foreach ($contratoAditivo->getFkTcemgContratoAditivoItens() as $item) {
                            /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterAditivoContrato.php:151 */
                            /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:161 */
                            /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterAditivoContrato.php:79 */
                            $valorUnitario = $item->getFkEmpenhoItemPreEmpenho()->getVlTotal() / $item->getFkEmpenhoItemPreEmpenho()->getQuantidade();

                            /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterAditivoContrato.php:162 */
                            if (ContratoAditivoItem::COD_TIPO_VALOR_ACRESCIMO === $item->getTipoAcrescDecresc()) {
                                $total = $total + ($valorUnitario * $item->getQuantidade());

                            } else {
                                $total = $total - ($valorUnitario * $item->getQuantidade());
                            }
                        }
                    }

                    /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterAditivoContrato.php:182 */
                    switch (true) {
                        case 9 === $contratoAditivo->getCodTipoAditivo():
                            $contratoAditivo->setCodTipoValor(ContratoAditivo::COD_TIPO_VALOR_ACRESCIMO);
                            break;

                        case 10 === $contratoAditivo->getCodTipoAditivo():
                            $contratoAditivo->setCodTipoValor(ContratoAditivo::COD_TIPO_VALOR_DECRESCIMO);
                            break;

                        case (11 === $contratoAditivo->getCodTipoAditivo() || 14 === $contratoAditivo->getCodTipoAditivo()) && 0 < $total:
                            $contratoAditivo->setCodTipoValor(ContratoAditivo::COD_TIPO_VALOR_ACRESCIMO);
                            break;

                        case (11 === $contratoAditivo->getCodTipoAditivo() || 14 === $contratoAditivo->getCodTipoAditivo()) && 0 > $total:
                            $contratoAditivo->setCodTipoValor(ContratoAditivo::COD_TIPO_VALOR_DECRESCIMO);
                            break;

                        /* gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/PRManterAditivoContrato.php:183 */
                        default:
                            $contratoAditivo->setCodTipoValor(3);
                            break;
                    }

                    $contratoAditivo->setValor($total);

                    if (null === $key) {
                        $message = 'Contrato Aditivo inserido com sucesso!';

                    } else {
                        $message = 'Contrato Aditivo alterado com sucesso!';
                    }

                    $success = true;

                    $em->persist($contratoAditivo);
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
                "PrestacaoContasBundle::Tribunal/MG/Configuracao/ContratoAditivo/form.html.twig",
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
     * called from src/Urbem/PrestacaoContasBundle/Resources/public/js/Tribunal/MG/ConfiguracaoContratoAditivo.js (button remove)
     * called from src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
     * called from $this::buildServiceProvider
     *
     * @param TwigEngine $templating
     * @return array
     */
    public function actionRemoveConfiguracaoContratoAditivo(TwigEngine $templating)
    {
        $contratoAditivo = $this->getConfiguracaoContratoAditivoFromRequest();
        $em = $this->factory->getEntityManager();
        $em->remove($contratoAditivo);
        $em->flush();

        return [
            'message' => 'Contrato Aditivo excluído com sucesso!'
        ];
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     */
    public function view(FormMapper $formMapper, TceInterface $objectAdmin)
    {
        $formMapper = parent::view($formMapper, $objectAdmin);

        $this->relatorioConfiguracao->setCustomBodyTemplate("PrestacaoContasBundle::Tribunal/MG/Configuracao/ContratoAditivo/main.html.twig");

        return $formMapper;
    }
}