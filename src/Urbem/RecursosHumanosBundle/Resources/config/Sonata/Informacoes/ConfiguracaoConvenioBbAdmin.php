<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Informacoes;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\Form\Form;

use Urbem\CoreBundle\Entity\Ima;
use Urbem\CoreBundle\Entity\Monetario;
use Urbem\CoreBundle\Entity\Organograma;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class ConfiguracaoConvenioBbAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_informacoes_configuracao_banco_brasil';
    protected $baseRoutePattern = 'recursos-humanos/informacoes/configuracao/banco-brasil';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codConvenioBanco', null, [
                'label' => 'label.besc.codConvenioBanco'
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codConvenio', null, [
                'label' => 'label.besc.codConvenio'
            ])
            ->add('codConvenioBanco', null, [
                'label' => 'label.besc.codConvenioBanco'
            ])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $fieldOptions = [];
        $fieldOptions['vigencia'] = [
            'format' => 'dd/MM/yyyy',
            'mapped' => false
        ];
        $fieldOptions['codBanco'] = [
            'attr' => ['class' => 'select2-parameters '],
            'class' => Monetario\Banco::class,
            'choice_label' => 'nomBanco',
            'label' => 'label.banco',
            'placeholder' => 'label.selecione'
        ];

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!is_null($id)) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $configConvenioBb = $em->getRepository('CoreBundle:Ima\ConfiguracaoBbConta')
                ->findByCodConvenio($id);

            $fieldOptions['vigencia']['data'] = $configConvenioBb[0]->getVigencia();
        }

        $formMapper
            ->with('label.bb.bancoBrasil')
                ->add('codConvenioBanco', 'text', [
                    'label' => 'label.besc.codConvenioBanco'
                ])
                ->add('vigencia', 'sonata_type_date_picker', $fieldOptions['vigencia'], [
                    'label' => 'Vigência'
                ])
                ->add('codBanco', 'entity', $fieldOptions['codBanco'])
            ->end()
            ->with('label.besc.contasConvenio')
                ->add('configuracaoBbContaCollection', 'sonata_type_collection', [
                    'by_reference' => false,
                    'label' => false,
                ], [
                    'cascade_validation' => true,
                    'edit' => 'inline',
                    'inline' => 'table',
                    'delete' => true,
                ])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->with('label.bb.bancoBrasil')
            ->add('codConvenio', null, [
                'label' => 'label.besc.codConvenio'
            ])
            ->add('codConvenioBanco', null, [
                'label' => 'label.besc.codConvenioBanco'
            ])
        ;
    }

    final private function deleteConfigBbConta(Form $configBbContaForm)
    {
        $configBbConta = $configBbContaForm->getData();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $this->deleteAllConfiguracoesBbOrgaoLocal($configBbConta);

        $em->remove($configBbConta);
        $em->flush();
    }

    final private function deleteAllConfiguracoesBbOrgaoLocal(Ima\ConfiguracaoBbConta $configBbConta)
    {
        $criteria = [
            'codConvenio' => $configBbConta->getCodConvenio(),
            'codContaCorrente' => $configBbConta->getCodContaCorrente(),
            'codBanco' => $configBbConta->getCodBanco(),
            'codAgencia' => $configBbConta->getCodAgencia(),
            'timestamp' => $configBbConta->getTimestamp()
        ];

        $em = $this->modelManager->getEntityManager($this->getClass());
        $configBbOrgao = $em->getRepository('CoreBundle:Ima\ConfiguracaoBbOrgao')
            ->findBy($criteria);

        $configBbLocal = $em->getRepository('CoreBundle:Ima\ConfiguracaoBbLocal')
            ->findBy($criteria);

        foreach (array_merge($configBbOrgao, $configBbLocal) as $configBb) {
            $em->remove($configBb);
        }

        $em->flush();
    }

    final private function buildConfiguracaoBbConta(Form $form, Ima\ConfiguracaoConvenioBb $configuracaoConvenioBb)
    {
        $configBbContaFormCollection = $form->get('configuracaoBbContaCollection');

        foreach ($configBbContaFormCollection as $configBbContaForm) {
            if ($configBbContaForm->get('_delete')->getData()) {
                $this->deleteConfigBbConta($configBbContaForm);
            } else {
                $configuracaoBbConta = $configBbContaForm->getData();
                $configuracaoBbConta->setVigencia($form->get('vigencia')->getData());
                $configuracaoBbConta->setCodBanco($form->get('codBanco')->getData());

                $configuracaoConvenioBb->addConfiguracaoBbContaCollection($configuracaoBbConta);

                $this->deleteAllConfiguracoesBbOrgaoLocal($configuracaoBbConta);

                $this->buildConfiguracaoBbOrgao($configBbContaForm, $configuracaoBbConta);
                $this->buildConfiguracaoBbLocal($configBbContaForm, $configuracaoBbConta);
            }
        }
    }

    final private function buildConfiguracaoBbOrgao(Form $configBbContaForm, Ima\ConfiguracaoBbConta $configuracaoBbConta)
    {
        foreach ($configBbContaForm->get('orgao')->getData() as $orgao) {
            $configuracaoBbOrgao = new Ima\ConfiguracaoBbOrgao();
            $configuracaoBbOrgao->fillLikeConfiguracaoBbConta($configuracaoBbConta);
            $configuracaoBbOrgao->setCodOrgao($orgao);

            $configuracaoBbConta->getCodConvenio()->addConfiguracaoBbOrgaoCollection($configuracaoBbOrgao);
        }
    }

    final private function buildConfiguracaoBbLocal(Form $configBbContaForm, Ima\ConfiguracaoBbConta $configuracaoBbConta)
    {
        foreach ($configBbContaForm->get('local')->getData() as $local) {
            $configuracaoBbLocal = new Ima\ConfiguracaoBbLocal();
            $configuracaoBbLocal->fillLikeConfiguracaoBbConta($configuracaoBbConta);
            $configuracaoBbLocal->setCodLocal($local);

            $configuracaoBbConta->getCodConvenio()->addConfiguracaoBbLocalCollection($configuracaoBbLocal);
        }
    }

    public function prePersist($configuracaoConvenioBb)
    {
        $this->buildConfiguracaoBbConta($this->getForm(), $configuracaoConvenioBb);
    }

    public function preUpdate($configuracaoConvenioBb)
    {
        $this->buildConfiguracaoBbConta($this->getForm(), $configuracaoConvenioBb);
    }
}
