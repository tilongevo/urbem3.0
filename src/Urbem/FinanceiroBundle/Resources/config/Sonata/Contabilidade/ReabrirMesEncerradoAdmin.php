<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Contabilidade\EncerramentoMes;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Contabilidade\EncerramentoMesModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ReabrirMesEncerradoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_configuracao_reabrir_mes_encerrado';
    protected $baseRoutePattern = 'financeiro/contabilidade/configuracao/reabrir-mes-encerrado';
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
            $this->forceRedirect("/financeiro/contabilidade/configuracao/reabrir-mes-encerrado/permissao");
        } else {
            $params = [
                'exercicio' => $this->getExercicio()
            ];

            $encerramentoMesModel = new EncerramentoMesModel($em);
            $mesesEncerrados = $encerramentoMesModel->getMesesEncerrados($params);

            $meses = [
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

            $mesesArray = [];
            foreach ($mesesEncerrados as $mesEncerrado) {
                $mesesArray[$meses[$mesEncerrado['mes']]] = $mesEncerrado['mes'];
            }

            $formMapper
                ->add(
                    'mes',
                    ChoiceType::class,
                    [
                        'choices' => $mesesArray,
                        'label' => 'label.mes',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
            ;
        }
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
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $object->setExercicio($this->getExercicio());
        $object->setSituacao(EncerramentoMesModel::TYPE_SITUACAO_ABERTO);
    }

    /**
     * @param mixed $object
     */
    public function postPersist($object)
    {
        $this->forceRedirect("/financeiro/contabilidade/configuracao/reabrir-mes-encerrado/create");
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof EncerramentoMes
            ? $object->getNomSistema()
            : 'Reabrir Mês Encerrado';
    }
}
