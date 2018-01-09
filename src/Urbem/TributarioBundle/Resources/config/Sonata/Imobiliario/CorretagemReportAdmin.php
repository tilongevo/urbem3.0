<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class CorretagemReportAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario
 */
class CorretagemReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_relatorio_corretagem';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/relatorios/corretagem';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];

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

        $fieldOptions['tipoCorretagem'] = [
            'label' => 'label.corretagemReport.tipoCorretagem',
            'choices' => array(
                'label.corretagemReport.imobiliaria' => 'imobiliaria',
                'label.corretagemReport.corretor' => 'corretor',
                'label.corretagemReport.todos' => 'todos'
            ),
            'mapped' => false,
            'required' => true,
        ];

        $fieldOptions['nome'] = [
            'label' => 'label.nome',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['cgmDe'] = [
            'label' => 'label.corretagemReport.cgmDe',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['cgmAte'] = [
            'label' => 'label.corretagemReport.cgmAte',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['ordenacao'] = [
            'label' => 'label.corretagemReport.ordenacao',
            'choices' => array(
                'label.cgm' => 'cgm',
                'label.corretagemReport.responsavel' => 'resp'
            ),
            'mapped' => false,
            'required' => true,
        ];

        $formMapper
            ->add('tipoCorretagem', ChoiceType::class, $fieldOptions['tipoCorretagem'])
            ->add('nome', TextType::class, $fieldOptions['nome'])
            ->add('cgmDe', NumberType::class, $fieldOptions['cgmDe'])
            ->add('cgmAte', NumberType::class, $fieldOptions['cgmAte'])
            ->add('ordenacao', ChoiceType::class, $fieldOptions['ordenacao'])
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $params = [
            'tipoCorretagem' => $this->getForm()->get('tipoCorretagem')->getData(),
            'nome' => $this->getForm()->get('nome')->getData(),
            'cgmDe' => $this->getForm()->get('cgmDe')->getData(),
            'cgmAte' => $this->getForm()->get('cgmAte')->getData(),
            'ordenacao' => $this->getForm()->get('ordenacao')->getData(),
        ];

        $this->forceRedirect($this->generateUrl('relatorio', $params));
    }
}
