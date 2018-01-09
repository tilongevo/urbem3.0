<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Entity\Arrecadacao\TipoPagamento;

class TipoBaixaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_tipo_baixa';
    protected $baseRoutePattern = 'tributario/arrecadacao/tipo-baixa';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codTipo', null, array('label' => 'label.arrecadacaoTipoBaixa.codTipo'))
            ->add('nomTipo', null, array('label' => 'label.arrecadacaoTipoBaixa.nomTipo'))
            ->add('nomResumido', null, array('label' => 'label.arrecadacaoTipoBaixa.nomResumido'));
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codTipo', null, array('label' => 'label.arrecadacaoTipoBaixa.codTipo'))
            ->add('nomTipo', null, array('label' => 'label.arrecadacaoTipoBaixa.nomTipo'))
            ->add('nomResumido', null, array('label' => 'label.arrecadacaoTipoBaixa.nomResumido'));

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $tipoBaixa = $this->getSubject();

        $choices = array(
            1 => 'label.arrecadacaoTipoBaixa.pagamento',
            0 => 'label.arrecadacaoTipoBaixa.cancelamento'
        );

        $fieldOptions['pagamento'] = array(
            'choices' => array_flip($choices),
            'label' => 'label.arrecadacaoTipoBaixa.utilizacao',
            'attr' => array( 'class' => 'select2-parameters ')
        );

        if ($this->id($this->getSubject())) {
            $fieldOptions['pagamento']['data'] = ($tipoBaixa->getPagamento()) ? $tipoBaixa->getPagamento() : 0;
        }
        
        $formMapper
            ->with('label.arrecadacaoTipoBaixa.dados')
            ->add('nomTipo', null, array('label' => 'label.arrecadacaoTipoBaixa.nomTipo'))
            ->add('nomResumido', null, array('label' => 'label.arrecadacaoTipoBaixa.nomResumido'))
            ->add('pagamento', ChoiceType::class, $fieldOptions['pagamento']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.arrecadacaoTipoBaixa.dados')
            ->add('codTipo', null, array('label' => 'label.arrecadacaoTipoBaixa.codTipo'))
            ->add('nomTipo', null, array('label' => 'label.arrecadacaoTipoBaixa.nomTipo'))
            ->add('nomResumido', null, array('label' => 'label.arrecadacaoTipoBaixa.nomResumido'));
    }

    /**
     * @param TipoBaixa $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof TipoPagamento
            ? $object->getNomTipo()
            : $this->getTranslator()->trans('label.tipoSuspensao.modulo');
    }
}
