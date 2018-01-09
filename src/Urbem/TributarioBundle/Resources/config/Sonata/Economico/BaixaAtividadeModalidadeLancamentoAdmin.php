<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use DateTime;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class BaixaAtividadeModalidadeLancamentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_baixa_modalidade_lancamento_atividade';
    protected $baseRoutePattern = 'tributario/cadastro-economico/modalidade-lancamento/atividade/baixa';
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
        $object->setDtBaixa(new DateTime());
    }

    /**
     * @param AtividadeModalidadeLancamento|null $object
     */
    public function postUpdate($object)
    {
        return $this->forceRedirect('/tributario/cadastro-economico/modalidade-lancamento/atividade/list');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $object = $this->getSubject();

        $fieldOptions = [];
        $fieldOptions['codEstrutural'] = [
            'mapped' => false,
            'disabled' => true,
            'data' => $object->getFkEconomicoAtividade()->getCodEstrutural(),
            'label' => 'label.economicoAtividadeModalidadeLancamento.codigo',
        ];

        $fieldOptions['nomAtividade'] = [
            'mapped' => false,
            'disabled' => true,
            'data' => $object->getFkEconomicoAtividade()->getNomAtividade(),
            'label' => 'label.economicoAtividadeModalidadeLancamento.atividade',
        ];

        $fieldOptions['nomModalidade'] = [
            'mapped' => false,
            'disabled' => true,
            'data' => $object->getFkEconomicoModalidadeLancamento()->getNomModalidade(),
            'label' => 'label.economicoAtividadeModalidadeLancamento.modalidade',
        ];

        $fieldOptions['dtInicio'] = [
            'mapped' => false,
            'disabled' => true,
            'data' => $object->getDtInicio()->format('d/m/Y'),
            'label' => 'label.economicoAtividadeModalidadeLancamento.dtInicio',
        ];

        $fieldOptions['dtBaixa'] = [
            'mapped' => false,
            'disabled' => true,
            'data' => $object->getDtInicio()->format('d/m/Y'),
            'label' => 'label.economicoAtividadeModalidadeLancamento.dtBaixa',
        ];

        $fieldOptions['motivoBaixa'] = [
            'label' => 'label.economicoAtividadeModalidadeLancamento.motivoBaixa',
        ];

        $formMapper
            ->with('label.economicoAtividadeModalidadeLancamento.cabecalhoModalidadeLancamento')
                ->add('codEstrutural', 'text', $fieldOptions['codEstrutural'])
                ->add('nomAtividade', 'text', $fieldOptions['nomAtividade'])
                ->add('nomModalidade', 'text', $fieldOptions['nomModalidade'])
                ->add('dtInicio', 'text', $fieldOptions['dtInicio'])
                ->add('dtBaixa', 'text', $fieldOptions['dtBaixa'])
                ->add('motivoBaixa', 'textarea', $fieldOptions['motivoBaixa'])
            ->end();
    }
}
