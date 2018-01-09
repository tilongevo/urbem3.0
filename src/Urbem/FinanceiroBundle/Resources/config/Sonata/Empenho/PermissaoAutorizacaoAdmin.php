<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Doctrine\ORM\EntityRepository;

class PermissaoAutorizacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_configuracao_permissao_autorizacao';
    protected $baseRoutePattern = 'financeiro/empenho/configuracao/permissao-autorizacao';
    protected $includeJs = array(
        '/financeiro/javascripts/empenho/permissao-autorizacao.js'
    );

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'edit', 'create'));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formOptions = array();

        $formOptions['numcgm'] = array(
            'label' => 'label.permissaoAutorizacao.numcgm',
            'class' => 'CoreBundle:Administracao\Usuario',
            'choice_value' => 'numcgm',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'mapped' => false,
        );

        $formOptions['numUnidade'] = array(
            'label' => 'label.permissaoAutorizacao.numUnidade',
            'class' => 'CoreBundle:Orcamento\Unidade',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                ->where("u.exercicio = '" . $this->getExercicio() . "'");
            },
            'choice_label' => function ($unidade) {
                return $unidade->getFkOrcamentoOrgao()->getNomOrgao() . " - " . $unidade->getNomUnidade();
            },
            'choice_value' => function ($unidade) {
                return $this->getObjectKey($unidade);
            },
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'multiple' => true,
            'mapped' => false,
        );

        $formMapper
            ->with('label.permissaoAutorizacao.dadosPermissaoUsuario')
                ->add(
                    'numcgm',
                    'entity',
                    $formOptions['numcgm']
                )
            ->end()
            ->with('label.permissaoAutorizacao.selecioneOrgaosUnidadesUsuarioPermissao')
                ->add(
                    'numUnidade',
                    'entity',
                    $formOptions['numUnidade']
                )
            ->end()
        ;
    }

    public function prePersist($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $permissaoAutorizacao = (new \Urbem\CoreBundle\Model\Empenho\PermissaoAutorizacaoModel($entityManager))
        ->save($this->getForm(), $this->getExercicio());
        if ($permissaoAutorizacao) {
            $this->getRequest()->getSession()->getFlashBag()->add('success', $this->getContainer()->get('translator')->transChoice('label.permissaoAutorizacao.success', 0, ['numcgm' => $this->getForm()->get('numcgm')->getData()->getNumcgm()], 'messages'));
        }
        $this->redirectByRoute($this->baseRouteName . '_create');
    }
}
