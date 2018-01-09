<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Contabilidade\EncerramentoMes;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Contabilidade\EncerramentoMesModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class EncerramentoMesAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_configuracao_encerrar_mes';
    protected $baseRoutePattern = 'financeiro/contabilidade/configuracao/encerrar-mes';
    protected $exibirBotaoIncluir = false;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
        $collection->add('permissao', 'permissao', array(), array(), array(), '', array(), array('GET'));
    }

    /**
     * @return bool
     */
    public function validaUtilizacaoRotina()
    {
        $em = $this->modelManager->getEntityManager(Configuracao::class);

        $validaConfiguracao = $em->getRepository(Configuracao::class)
            ->findOneBy([
                'codModulo' => ConfiguracaoModel::MODULO_FINANCEIRO_CONTABILIDADE,
                'parametro' => ConfiguracaoModel::PARAM_UTILIZAR_ENCERRAMENTO_MES,
                'exercicio' => $this->getExercicio()
            ]);

        if (is_null($validaConfiguracao)) {
            return false;
        }

        return $validaConfiguracao->getValor();
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager(EncerramentoMes::class);

        //valida a utilização da rotina de encerramento do mês contábil
        $valida = $this->validaUtilizacaoRotina();

        if (!$valida || $valida == "false") {
            $message = $this->trans('financeiro.encerrarMes.desabilitado', [], 'flashes');
            $container = $this->getConfigurationPool()->getContainer();

            $container->get('session')->getFlashBag()->add('error', $message);

            $this->forceRedirect("/financeiro/contabilidade/configuracao/encerrar-mes/permissao");
        } else {
            $params = [
                'exercicio' => $this->getExercicio()
            ];

            $meses = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

            $encerramentoMesModel = new EncerramentoMesModel($em);
            $mesesReabertos = $encerramentoMesModel->getMesesReabertos($params);

            $mesesReabertosArray = [];
            foreach ($mesesReabertos as $mes) {
                if ($mes['count'] % 2 == 0) {
                    array_push($mesesReabertosArray, $mes['mes']);
                }
            }

            $mesesEncerrados = $em->getRepository(EncerramentoMes::class)
                ->findBy([
                    'exercicio' => $this->getExercicio(),
                    'situacao' => EncerramentoMesModel::TYPE_SITUACAO_FECHADO
                ], ['exercicio' => 'ASC']);

            $mesesArray = $meses;
            foreach ($mesesEncerrados as $mesEncerrado) {
                unset($mesesArray[$mesEncerrado->getMes() - 1]);
            }

            foreach ($mesesReabertosArray as $mesReaberto) {
                $mesesArray[$mesReaberto - 1] = $mesReaberto;
            }

            ksort($mesesArray);

            $mesesChoice = [
                1 => "Janeiro",
                2 => "Fevereiro",
                3 => "Março",
                4 => "Abril",
                5 => "Maio",
                6 => "Junho",
                7 => "Julho",
                8 => "Agosto",
                9 => "Setembro",
                10 => "Outubro",
                11 => "Novembro",
                12 => "Dezembro"
            ];

            $select = [];
            foreach ($mesesArray as $mes) {
                $select[$mesesChoice[$mes]] = $mes;
            }

            $formMapper
                ->add(
                    'mes',
                    ChoiceType::class,
                    [
                        'choices' => $select,
                        'label' => 'label.mes',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                );
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $object->setExercicio($this->getExercicio());
        $object->setSituacao(EncerramentoMesModel::TYPE_SITUACAO_FECHADO);
    }

    /**
     * @param mixed $object
     */
    public function postPersist($object)
    {
        $this->forceRedirect("/financeiro/contabilidade/configuracao/encerrar-mes/create");
    }

    /**
     * @param mixed $object
     * @return int|string
     */
    public function toString($object)
    {
        return $object instanceof EncerramentoMes
            ? $object->getMes()
            : 'Encerramento do Mês';
    }
}
