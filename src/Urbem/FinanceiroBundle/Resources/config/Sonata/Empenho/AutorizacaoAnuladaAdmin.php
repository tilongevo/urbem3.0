<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Urbem\CoreBundle\Entity\Empenho\AutorizacaoEmpenho;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenho;
use Urbem\CoreBundle\Entity\Orcamento\ReservaSaldosAnulada;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class AutorizacaoAnuladaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_anular_autorizacao';
    protected $baseRoutePattern = 'financeiro/empenho/anular-autorizacao';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'edit', 'create'));
        $collection->add('reemitir_anulacao_autorizacao', 'reemitir-anulacao-autorizacao');
    }

    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'codPreEmpenho' => $this->getRequest()->get('codPreEmpenho'),
            'exercicio'  => $this->getRequest()->get('exercicio'),
        );
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $formOptions = array();

        $formOptions['codPreEmpenho'] = array(
            'data' => $this->getRequest()->query->get('codPreEmpenho'),
            'mapped' => false,
        );

        $formOptions['exercicio'] = array(
            'data' => $this->getRequest()->query->get('exercicio'),
            'mapped' => false,
        );

        $params = array();
        $preEmpenho = $entityManager->getRepository("CoreBundle:Empenho\PreEmpenho")
        ->findOneBy(
            array(
                'codPreEmpenho' => $this->getRequest()->query->get('codPreEmpenho'),
                'exercicio' => $this->getRequest()->query->get('exercicio'),
            )
        );

        if ($preEmpenho) {
            $autorizacaoEmpenho = $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last();
            if (!empty($autorizacaoEmpenho)) {
                $params = array(
                    "%codAutorizacao%" => $autorizacaoEmpenho->getCodAutorizacao(),
                    "%exercicio%" => $autorizacaoEmpenho->getExercicio()
                );
            }
        }

        $formMapper
            ->with($this->getTranslator()->trans('label.anularAutorizacao.anularAutorizacao', $params))
                ->add(
                    'codPreEmpenho',
                    'hidden',
                    $formOptions['codPreEmpenho']
                )
                ->add(
                    'exercicio',
                    'hidden',
                    $formOptions['exercicio']
                )
                ->add('motivo')
            ->end()
        ;
    }

    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $ultimoMesEncerrado = $entityManager->getRepository("CoreBundle:Contabilidade\EncerramentoMes")
        ->getUltimoMesEncerrado($this->getExercicio());
        
        if ($ultimoMesEncerrado) {
            $dtAutorizacao = date("m", mktime(0, 0, 0, date("m"), date("d"), $this->getExercicio()));
            
            if ($ultimoMesEncerrado->mes >= (int) $dtAutorizacao) {
                $error = "Mês da Autorização encerrado!";
                $errorElement->with('motivo')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
            }
        }
    }

    public function prePersist($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /** @var PreEmpenho $preEmpenho */
        $preEmpenho = $entityManager->getRepository("CoreBundle:Empenho\PreEmpenho")
        ->findOneBy(
            array(
                'codPreEmpenho' => $this->getForm()->get('codPreEmpenho')->getData(),
                'exercicio' => $this->getForm()->get('exercicio')->getData(),
            )
        );

        $autorizacaoEmpenho = $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last();
        $object->setFkEmpenhoAutorizacaoEmpenho($autorizacaoEmpenho);
        $object->setDtAnulacao(new DateTimeMicrosecondPK());

        /** @var AutorizacaoEmpenho $autorizacaoEmpenho */
        $autorizacaoEmpenho = $preEmpenho->getFkEmpenhoAutorizacaoEmpenhos()->last();

        if ($autorizacaoEmpenho->getFkEmpenhoAutorizacaoReserva()) {
            $reservaSaldosAnulada = new ReservaSaldosAnulada();
            $reservaSaldosAnulada->setMotivoAnulacao(sprintf('%s - Autorização de Empenho: %d/%s', $object->getMotivo(), $autorizacaoEmpenho->getCodAutorizacao(), $autorizacaoEmpenho->getExercicio()));
            $autorizacaoEmpenho->getFkEmpenhoAutorizacaoReserva()->getFkOrcamentoReservaSaldos()->setFkOrcamentoReservaSaldosAnulada($reservaSaldosAnulada);
        }

        $object->setMotivo(sprintf('%s - Autorização de Empenho: %d/%s', $object->getMotivo(), $autorizacaoEmpenho->getCodAutorizacao(), $autorizacaoEmpenho->getExercicio()));
    }

    public function postPersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add("success", $this->getContainer()->get('translator')->transChoice('label.preEmpenho.autorizacaoAnuladaSucesso', 0, [], 'messages'));
        $this->forceRedirect('/financeiro/empenho/autorizacao/' . $this->getObjectKey($object->getFkEmpenhoAutorizacaoEmpenho()->getFkEmpenhoPreEmpenho()) . '/show');
    }
}
