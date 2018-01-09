<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\NumberType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Urbem\CoreBundle\Entity\Arrecadacao\TipoSuspensao;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class TipoSuspensaoAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao
 */
class TipoSuspensaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_tipo_suspensao';
    protected $baseRoutePattern = 'tributario/arrecadacao/tipo-suspensao';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codTipoSuspensao', null, array('label' => 'label.codigo'))
            ->add('descricao', null, array('label' => 'label.descricao'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codTipoSuspensao', null, array('label' => 'label.codigo'))
            ->add('descricao', null, array('label' => 'label.descricao'))
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();

        $fieldOptions['codTipoSuspensao'] = array(
            'label' => 'label.codigo',
        );

        $fieldOptions['descricao'] = array(
            'label' => 'label.descricao',
        );

        $fieldOptions['emitir'] = array(
            'label' => 'label.tipoSuspensao.emitirDocumentos',
            'mapped' => false,
            'expanded' => true,
            'choices' => array(
                'sim' => 1,
                'nao' => 0
            ),
            'data' => 0,
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            )
        );

        if ($this->id($this->getSubject())) {
            $fieldOptions['codTipoSuspensao']['disabled'] = true;
        }

        $formMapper
            ->with('label.tipoSuspensao.dados')
            ->add('codTipoSuspensao', TextType::class, $fieldOptions['codTipoSuspensao'])
            ->add('descricao', TextType::class, $fieldOptions['descricao'])
            ->add('emitir', ChoiceType::class, $fieldOptions['emitir'])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.tipoSuspensao.dados')
            ->add('codTipoSuspensao', null, array('label' => 'label.codigo'))
            ->add('descricao', null, array('label' => 'label.descricao'))
            ->add('emitir', null, array('label' => 'label.tipoSuspensao.emitirDocumentos'))
            ->end()
        ;
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof TipoSuspensao
            ? $object->getDescricao()
            : $this->getTranslator()->trans('label.tipoSuspensao.modulo');
    }
}
