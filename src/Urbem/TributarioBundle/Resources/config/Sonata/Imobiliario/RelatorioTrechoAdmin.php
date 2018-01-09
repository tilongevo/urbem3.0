<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoTrechoValor;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Administracao\Modulo;

class RelatorioTrechoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_relatorio_trecho';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/relatorios/trechos';
    protected $legendButtonSave = array('icon' => 'description', 'text' => 'Gerar Relatório');
    protected $includeJs = ['/tributario/javascripts/imobiliario/report-trechos.js'];

    const ANALITICO = 'analitico';
    const SINTETICO = 'sintetico';
    const ORDENACAO_CODIGO_LOGRADOURO = 'codLogradouro';
    const ORDENACAO_NOME_LOGRADOURO = 'nomLogradouro';

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
        $collection->add('relatorio', 'relatorio');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->getEntityManager();
        $atributoModel = new AtributoDinamicoModel($em);

        $fieldOptions = array();

        $fieldOptions['codLogradouro'] = [
            'label' => 'label.imobiliarioRelatorios.trechos.codigoLogradouroDe',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['sequencia'] = [
            'label' => 'label.imobiliarioRelatorios.trechos.sequenciaDe',
            'mapped' => false,
            'required' => false
        ];

        $tipoRelatorio = [
            self::ANALITICO => 'label.imobiliarioRelatorios.trechos.analitico',
            self::SINTETICO => 'label.imobiliarioRelatorios.trechos.sintetico',
        ];

        $fieldOptions['tipoRelatorio'] = [
            'label' => 'label.imobiliarioRelatorios.trechos.tipoRelatorio',
            'placeholder' => 'label.selecione',
            'choices' => array_flip($tipoRelatorio),
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['atributos'] = [
            'choices'       => $atributoModel->getAtributosDinamicosPorModuloQuery(Modulo::MODULO_CADASTRO_IMOBILIARIO, Cadastro::CADASTRO_TRIBUTARIO_TRECHO)->getQuery()->getResult(),
            'choice_value' => function (AtributoDinamico $atributos) {
                if (!$atributos) {
                      return;
                }
                   return sprintf('%s', $atributos->getCodAtributo());
            },
            'choice_label' => function (AtributoDinamico $atributoDinamico) {
                return "{$atributoDinamico->getNomAtributo()}";
            },
            'label'       => 'label.imobiliarioRelatorios.trechos.atributos',
            'mapped'      => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'multiple'    => true,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $ordenacoes = [
            self::ORDENACAO_CODIGO_LOGRADOURO => 'label.imobiliarioRelatorios.trechos.codLogradouro',
            self::ORDENACAO_NOME_LOGRADOURO => 'label.imobiliarioRelatorios.trechos.nomeLogradouro'
        ];

        $fieldOptions['ordenacao'] = [
            'label' => 'label.imobiliarioRelatorios.trechos.ordenacao',
            'placeholder' => 'label.selecione',
            'choices' => array_flip($ordenacoes),
            'data' => self::ORDENACAO_CODIGO_LOGRADOURO,
            'mapped' => false,
            'required' => true
        ];

        $formMapper
            ->with('label.imobiliarioRelatorios.trechos.titulo')
                ->add('codLogradouroDe', 'number', $fieldOptions['codLogradouro'])
                ->add('codLogradouroAte', 'number', array_merge($fieldOptions['codLogradouro'], ['label' => 'label.imobiliarioRelatorios.trechos.codigoLogradouroAte']))
                ->add('sequenciaDe', 'text', $fieldOptions['sequencia'])
                ->add('sequenciaAte', 'text', array_merge($fieldOptions['sequencia'], ['label' => 'label.imobiliarioRelatorios.trechos.sequenciaAte']))
            ->end()
            ->with(' ')
                ->add('tipoRelatorio', 'choice', $fieldOptions['tipoRelatorio'])
                ->add('atributos', 'choice', $fieldOptions['atributos'])
                ->add('ordenacao', 'choice', $fieldOptions['ordenacao'])
            ->end()
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $atributos = $this->getFormField($this->getForm(), 'atributos');
        $exercicio = $this->getExercicio();
        $em = $this->getEntityManager();

        $params = [
            'codLogradouroDe' => $this->getFormField($this->getForm(), 'codLogradouroDe'),
            'codLogradouroAte' => $this->getFormField($this->getForm(), 'codLogradouroAte'),
            'sequenciaDe' => $this->getFormField($this->getForm(), 'sequenciaDe'),
            'sequenciaAte' => $this->getFormField($this->getForm(), 'sequenciaAte'),
            'tipoRelatorio' => $this->getFormField($this->getForm(), 'tipoRelatorio'),
            'atributoValores' => $atributos ? $this::getCodAtributo($atributos) : '',
            'ordenacao' => $this->getFormField($this->getForm(), 'ordenacao'),
            'exercicio' => $exercicio,
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

    /**
     * @param $atributos
     * @return string|void
     */
    private function getCodAtributo($atributos)
    {
        if (!$atributos) {
            return;
        }

        $codAtributo= "";
        foreach ($atributos as $atributo) {
            $codAtributo .= $atributo->getCodAtributo().', ';
        }

        return substr($codAtributo, 0, -2);
    }
}
