<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class RelatorioServicosAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_relatorio_servicos';
    protected $baseRoutePattern = 'tributario/cadastro-economico/relatorios/servico';
    protected $layoutDefaultReport = '';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];
    protected $includeJs = array('');

    const ORD_CODIGO = 'codigo';
    const ORD_DESCRICAO = 'descricao';

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
        $collection->add('relatorio', 'relatorio');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();

        $ordenacoes = [
            self::ORD_CODIGO => 'label.economicoRelatorios.servicos.codigo',
            self::ORD_DESCRICAO => 'label.economicoRelatorios.servicos.descricao'
        ];

        $fieldOptions['nomeServico'] = [
            'label' => 'label.economicoRelatorios.servicos.nomeServico',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['ordenacao'] = [
            'label' => 'label.economicoRelatorios.servicos.ordenacao',
            'placeholder' => false,
            'choices' => array_flip($ordenacoes),
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['servicoDe'] = [
            'label' => 'label.economicoRelatorios.servicos.de',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['servicoAte'] = [
            'label' => 'label.economicoRelatorios.servicos.ate',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['vigenciaDe'] = [
            'label' => 'label.economicoRelatorios.servicos.de',
            'mapped' => false,
            'required' => false,
            'format' => 'dd/MM/yyyy',
            'dp_use_current' => false,
        ];

        $fieldOptions['vigenciaAte'] = [
            'label' => 'label.economicoRelatorios.servicos.ate',
            'mapped' => false,
            'required' => false,
            'format' => 'dd/MM/yyyy',
            'dp_use_current' => false,
        ];

        $formMapper
            ->with('label.economicoRelatorios.servicos.titulo')
                ->add('nomeServico', 'text', $fieldOptions['nomeServico'])
                ->add('ordenacao', 'choice', $fieldOptions['ordenacao'])
            ->end()
            ->with('label.economicoRelatorios.servicos.servico')
                ->add('servicoDe', 'number', $fieldOptions['servicoDe'])
                ->add('servicoAte', 'number', $fieldOptions['servicoAte'])
            ->end()
            ->with('label.economicoRelatorios.servicos.vigencia')
                ->add('vigenciaDe', 'sonata_type_date_picker', $fieldOptions['vigenciaDe'])
                ->add('vigenciaAte', 'sonata_type_date_picker', $fieldOptions['vigenciaAte'])
            ->end()
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $dataDe = $this->getFormField($this->getForm(), 'vigenciaDe');
        $dataAte = $this->getFormField($this->getForm(), 'vigenciaAte');

        $params = [
            'nomeServico' => $this->getFormField($this->getForm(), 'nomeServico'),
            'ordenacao' => $this->getFormField($this->getForm(), 'ordenacao'),
            'servicoDe' => (String) $this->getFormField($this->getForm(), 'servicoDe'),
            'servicoAte' => (String) $this->getFormField($this->getForm(), 'servicoAte'),
            'vigenciaDe' => $dataDe ? $dataDe->format('Y-m-d') : '',
            'vigenciaAte' => $dataAte ? $dataAte->format('Y-m-d') : '',
        ];

        $this->forceRedirect($this->generateUrl('relatorio', $params));
    }

    /**
     * @param $form
     * @param $fieldName
     * @return string
     */
    public function getFormField($form, $fieldName)
    {
        return ($form->get($fieldName)->getData()) ? $form->get($fieldName)->getData() : '';
    }
}
