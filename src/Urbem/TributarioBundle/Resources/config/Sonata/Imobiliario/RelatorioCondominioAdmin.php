<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Imobiliario\Condominio;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Administracao\Modulo;

class RelatorioCondominioAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_relatorio_condominio';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/relatorios/condominio';
    protected $legendButtonSave = array('icon' => 'description', 'text' => 'Gerar Relatório');

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

        $fieldOptions['condominio'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => Condominio::class,
            'choice_label' => function (Condominio $condominio) {
                return "{$condominio->getCodCondominio()} {$condominio->getNomCondominio()}";
            },
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->orderBy('o.codCondominio', 'ASC');
                return $qb;
            },
            'label'       => 'label.imobiliarioRelatorios.condominio.condominioDe',
            'mapped'      => false,
            'required'    => false,
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['nome'] = [
            'label' => 'label.imobiliarioRelatorios.condominio.nome',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['atributosLote'] = [
            'choices'       => $atributoModel->getAtributosDinamicosPorModuloQuery(Modulo::MODULO_CADASTRO_IMOBILIARIO, Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO)->getQuery()->getResult(),
            'choice_value' => function (AtributoDinamico $atributos) {
                if (!$atributos) {
                    return;
                }
                return sprintf('%s', $atributos->getCodAtributo());
            },
            'choice_label' => function (AtributoDinamico $atributoDinamico) {
                return "{$atributoDinamico->getNomAtributo()}";
            },
            'label'       => ' ',
            'mapped'      => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'multiple'    => true,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $fieldOptions['atributosImovel'] = [
            'choices'       => $atributoModel->getAtributosDinamicosPorModuloQuery(Modulo::MODULO_CADASTRO_IMOBILIARIO, Cadastro::CADASTRO_TRIBUTARIO_IMOVEL)->getQuery()->getResult(),
            'choice_value' => function (AtributoDinamico $atributos) {
                if (!$atributos) {
                      return;
                }
                   return sprintf('%s', $atributos->getCodAtributo());
            },
            'choice_label' => function (AtributoDinamico $atributoDinamico) {
                return "{$atributoDinamico->getNomAtributo()}";
            },
            'label'       => ' ',
            'mapped'      => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'multiple'    => true,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $formMapper
            ->with('label.imobiliarioRelatorios.condominio.titulo')
                ->add('nome', 'text', $fieldOptions['nome'])
                ->add('condominioDe', 'entity', $fieldOptions['condominio'])
                ->add('condominioAte', 'entity', array_merge($fieldOptions['condominio'], ['label' => 'label.imobiliarioRelatorios.condominio.condominioAte']))
            ->end()
            ->with('label.imobiliarioRelatorios.condominio.atributos')
                ->add('atributosLote', 'choice', $fieldOptions['atributosLote'])
                ->add('atributosImovel', 'choice', $fieldOptions['atributosImovel'])
            ->end()
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {

        $condominioDe = $this->getFormField($this->getForm(), 'condominioDe');
        $condominioDe = $condominioDe ? $condominioDe->getCodCondominio() : '';

        $condominioAte = $this->getFormField($this->getForm(), 'condominioAte');
        $condominioAte = $condominioAte ? $condominioAte->getCodCondominio() : '';

        $atributosLote = $this->getFormField($this->getForm(), 'atributosLote');
        $atributosLote = $this::getCodAtributo($atributosLote);

        $atributosImovel = $this->getFormField($this->getForm(), 'atributosImovel');
        $atributosImovel = $this::getCodAtributo($atributosImovel);

        $params = [
            'condominioDe' => $condominioDe,
            'condominioAte' => $condominioAte,
            'nome' => $this->getFormField($this->getForm(), 'nome'),
            'atributosLote' => $atributosLote,
            'atributosImovel' => $atributosImovel,
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

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $lote = $this->getForm()->get('atributosLote')->getData();
        $imovel = $this->getForm()->get('atributosImovel')->getData();

        $qtdAtributos=  sizeof($lote) + sizeof($imovel);

        if ($qtdAtributos > 4) {
            $mensagem = $this->getTranslator()->trans('label.imobiliarioRelatorios.condominio.mensagemErro');
            $errorElement->with('valor')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
        }
    }

    /**
     * @param mixed $object
     * @return string|void
     */
    public function toString($object)
    {
        return $object instanceof RelatorioCondominioAdmin
            ? $object->getCodAtributo()
            : $this->getTranslator()->trans('label.imobiliarioRelatorios.condominio.titulo');
    }
}
