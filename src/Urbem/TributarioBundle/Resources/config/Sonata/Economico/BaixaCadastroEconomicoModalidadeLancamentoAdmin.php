<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use DateTime;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class BaixaCadastroEconomicoModalidadeLancamentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_baixa_modalidade_lancamento_cadastro_economico';
    protected $baseRoutePattern = 'tributario/cadastro-economico/modalidade-lancamento/inscricao-economica/baixa';
    protected $legendButtonSave = ['icon' => 'arrow_downward', 'text' => 'Baixar'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add(
            'baixa',
            sprintf(
                '%s',
                $this->getRouterIdParameter()
            )
        );

        $routes->clearExcept(['baixa', 'edit']);
    }

    /**
     * @param AtividadeModalidadeLancamento|null $object
     */
    public function preUpdate($object)
    {
        foreach ($object->getFkEconomicoAtividadeCadastroEconomicos() as $atividadeCadastroEconomico) {
            if (!$atividadeCadastroEconomico->getFkEconomicoCadastroEconomicoModalidadeLancamentos()->first()) {
                continue;
            }

            $this->populateObject($atividadeCadastroEconomico->getFkEconomicoCadastroEconomicoModalidadeLancamentos());
        }

        return $this->forceRedirect('/tributario/cadastro-economico/modalidade-lancamento/inscricao-economica/list');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $object = $this->getSubject();

        foreach ($object->getFkEconomicoAtividadeCadastroEconomicos() as $atividadeCadastroEconomico) {
            if (!$atividadeCadastroEconomico->getFkEconomicoCadastroEconomicoModalidadeLancamentos()->first()) {
                continue;
            }

            $modalidadeLancamento = $atividadeCadastroEconomico->getFkEconomicoCadastroEconomicoModalidadeLancamentos()->first();

            break;
        }

        $fieldOptions = [];
        $fieldOptions['inscricaoEconomica'] = [
            'mapped' => false,
            'disabled' => true,
            'data' => $atividadeCadastroEconomico->getInscricaoEconomica(),
            'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.inscricaoEconomica',
        ];

        $fieldOptions['nome'] = [
            'mapped' => false,
            'disabled' => true,
            'data' => $this->getCgm($object)->getNomCgm(),
            'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.nome',
        ];

        $fieldOptions['dtInicio'] = [
            'mapped' => false,
            'disabled' => true,
            'data' => $modalidadeLancamento->getDtInicio()->format('d/m/Y'),
            'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.dtInicio',
        ];

        $fieldOptions['dtBaixa'] = [
            'mapped' => false,
            'disabled' => true,
            'data' => $modalidadeLancamento->getDtInicio()->format('d/m/Y'),
            'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.dtBaixa',
        ];

        $fieldOptions['motivoBaixa'] = [
            'mapped' => false,
            'label' => 'label.economicoCadastroEconomicoModalidadeLancamento.motivoBaixa',
        ];

        $formMapper
            ->with('label.economicoCadastroEconomicoModalidadeLancamento.cabecalhoModalidadeLancamento')
                ->add('inscricaoEconomica', 'text', $fieldOptions['inscricaoEconomica'])
                ->add('nome', 'text', $fieldOptions['nome'])
                ->add('dtInicio', 'text', $fieldOptions['dtInicio'])
                ->add('dtBaixa', 'text', $fieldOptions['dtBaixa'])
                ->add('motivoBaixa', 'textarea', $fieldOptions['motivoBaixa'])
            ->end();
    }

    /**
    * @param CadastroEconomico $cadastroEconomico
    * @return Urbem\CoreBundle\Entity\SwCgm
    */
    protected function getCgm(CadastroEconomico $cadastroEconomico)
    {
        if ($empresaFato = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaFato()) {
            return $empresaFato->getFkSwCgmPessoaFisica()->getFkSwCgm();
        }

        if ($autonomo = $cadastroEconomico->getFkEconomicoCadastroEconomicoAutonomo()) {
            return $autonomo->getFkSwCgmPessoaFisica()->getFkSwCgm();
        }

        if ($empresaDireito = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaDireito()) {
            return $empresaDireito->getFkSwCgmPessoaJuridica()->getFkSwCgm();
        }
    }

    /**
    * @param CadastroEconomico $object
    * @param $em
    */
    protected function populateObject($modalidadeLancamentos)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        foreach ($modalidadeLancamentos as $modalidadeLancamento) {
            $modalidadeLancamento->setDtBaixa(new DateTime());
            $modalidadeLancamento->setMotivoBaixa($this->getForm()->get('motivoBaixa')->getData());

            $em->persist($modalidadeLancamento);
        }
    }
}
