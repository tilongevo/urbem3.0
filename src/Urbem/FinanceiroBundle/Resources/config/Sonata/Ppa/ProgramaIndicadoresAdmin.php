<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ProgramaIndicadoresAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_plano_plurianual_programa_indicadores';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/programa-indicadores';
    protected $exibirBotaoVoltarNoList = true;

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->andWhere(
            $query->expr()->eq($query->getRootAliases()[0] . '.codPrograma', ':codPrograma')
        );
        $query->setParameter('codPrograma', $this->getRequest()->get('programa'));
        return $query;
    }

    public function getPersistentParameters()
    {
        if (! $this->getRequest()) {
            return array();
        }

        return array(
            'programa'  => $this->getRequest()->get('programa'),
        );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'descricao',
                null,
                array(
                    'label' => 'label.programas.descricao',
                )
            )
            ->add(
                'fkAdministracaoUnidadeMedida.nomUnidade',
                null,
                array(
                    'label' => 'label.programas.codUnidade',
                )
            )
            ->add(
                'indiceRecente',
                'decimal',
                array(
                    'label' => 'label.programas.indiceRecente',
                    'attributes' => array(
                        'fraction_digits' => 2
                    ),
                )
            )
            ->add(
                'dtIndiceRecente',
                null,
                array(
                    'label' => 'label.programas.dtIndiceRecente',
                )
            )
            ->add(
                'indiceDesejado',
                'decimal',
                array(
                    'label' => 'label.programas.indiceDesejado',
                    'attributes' => array(
                        'fraction_digits' => 2
                    ),
                )
            )
            ->add(
                'fonte',
                null,
                array(
                    'label' => 'label.programas.fonte',
                )
            )
            ->add(
                'fkPpaPeriodicidade.nomPeriodicidade',
                null,
                array(
                    'label' => 'label.programas.codPeriodicidade',
                )
            )
            ->add(
                'baseGeografica',
                null,
                array(
                    'label' => 'label.programas.baseGeografica',
                )
            )
            ->add(
                'formaCalculo',
                null,
                array(
                    'label' => 'label.programas.formaCalculo',
                )
            )
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

        $formOptions = array();

        $formOptions['descricao'] = array(
            'label' => 'label.programas.descricao',
        );

        $formOptions['fkAdministracaoUnidadeMedida'] = array(
            'label' => 'label.programas.codUnidade',
            'class' => 'CoreBundle:Administracao\UnidadeMedida',
            'choice_label' => 'nomUnidade',
            'attr' => array(
                'class' => 'select2-parameters'
            )
        );

        $formOptions['indiceRecente'] = array(
            'label' => 'label.programas.indiceRecente',
            'attr' => array(
                'class' => 'mask-monetaria '
            )
        );
        $formOptions['dtIndiceRecente'] = array(
            'label' => 'label.programas.dtIndiceRecente',
            'format' => 'dd/MM/yyyy',
        );
        $formOptions['indiceDesejado'] = array(
            'label' => 'label.programas.indiceDesejado',
            'attr' => array(
                'class' => 'mask-monetaria '
            )
        );
        $formOptions['fonte'] = array(
            'label' => 'label.programas.fonte',
        );
        $formOptions['fkPpaPeriodicidade'] = array(
            'label' => 'label.programas.codPeriodicidade',
            'class' => 'CoreBundle:Ppa\Periodicidade',
            'choice_label' => 'nomPeriodicidade',
            'attr' => array(
                'class' => 'select2-parameters'
            )
        );
        $formOptions['baseGeografica'] = array(
            'label' => 'label.programas.baseGeografica',
        );
        $formOptions['formaCalculo'] = array(
            'label' => 'label.programas.formaCalculo',
        );

        $formMapper
            ->with('label.programas.indicadores')
                ->add(
                    'descricao',
                    'text',
                    $formOptions['descricao']
                )
                ->add(
                    'fkAdministracaoUnidadeMedida',
                    'entity',
                    $formOptions['fkAdministracaoUnidadeMedida']
                )
                ->add(
                    'indiceRecente',
                    'text',
                    $formOptions['indiceRecente']
                )
                ->add(
                    'dtIndiceRecente',
                    'sonata_type_date_picker',
                    $formOptions['dtIndiceRecente']
                )
                ->add(
                    'indiceDesejado',
                    'text',
                    $formOptions['indiceDesejado']
                )
                ->add(
                    'fonte',
                    'text',
                    $formOptions['fonte']
                )
                ->add(
                    'fkPpaPeriodicidade',
                    'entity',
                    $formOptions['fkPpaPeriodicidade']
                )
                ->add(
                    'baseGeografica',
                    'text',
                    $formOptions['baseGeografica']
                )
                ->add(
                    'formaCalculo',
                    'text',
                    $formOptions['formaCalculo']
                )
            ->end()
        ;
    }

    public function prePersist($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $programa = $entityManager->getRepository('CoreBundle:Ppa\Programa')
        ->findOneByCodPrograma($this->getRequest()->query->get('programa'));
        
        $codIndicador = (new \Urbem\CoreBundle\Model\Ppa\ProgramaModel($entityManager))
        ->getProximoIndicador();

        $object->setFkPpaProgramaDados($programa->getFkPpaProgramaDados()->last());
        $object->setCodIndicador($codIndicador);
    }

    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ))
        ;
    }
}
