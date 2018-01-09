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

class ConfiguracaoConvenioBanrisulAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_informacoes_configuracao_banrisul';
    protected $baseRoutePattern = 'recursos-humanos/informacoes/configuracao/banrisul';

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
            $configConvenioBanrisul = $em->getRepository('CoreBundle:Ima\ConfiguracaoBanrisulConta')
                ->findByCodConvenio($id);

            $fieldOptions['vigencia']['data'] = $configConvenioBanrisul[0]->getVigencia();
        }

        $formMapper
            ->with('label.banrisul.banrisul')
                ->add('codConvenioBanco', 'text', [
                    'label' => 'label.besc.codConvenioBanco'
                ])
                ->add('vigencia', 'sonata_type_date_picker', $fieldOptions['vigencia'], [
                    'label' => 'Vigência'
                ])
                ->add('codBanco', 'entity', $fieldOptions['codBanco'])
            ->end()
            ->with('label.besc.contasConvenio')
                ->add('configuracaoBanrisulContaCollection', 'sonata_type_collection', [
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
            ->with('label.banrisul.banrisul')
            ->add('codConvenio', null, [
                'label' => 'label.besc.codConvenio'
            ])
            ->add('codConvenioBanco', null, [
                'label' => 'label.besc.codConvenioBanco'
            ])
        ;
    }

    final private function deleteConfigBanrisulConta(Form $configBanrisulContaForm)
    {
        $configBanrisulConta = $configBanrisulContaForm->getData();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $this->deleteAllConfiguracoesBanrisulOrgaoLocal($configBanrisulConta);

        $em->remove($configBanrisulConta);
        $em->flush();
    }

    final private function deleteAllConfiguracoesBanrisulOrgaoLocal(Ima\ConfiguracaoBanrisulConta $configBanrisulConta)
    {
        $criteria = [
            'codConvenio' => $configBanrisulConta->getCodConvenio(),
            'codContaCorrente' => $configBanrisulConta->getCodContaCorrente(),
            'codBanco' => $configBanrisulConta->getCodBanco(),
            'codAgencia' => $configBanrisulConta->getCodAgencia(),
            'timestamp' => $configBanrisulConta->getTimestamp()
        ];

        $em = $this->modelManager->getEntityManager($this->getClass());
        $configBanrisulOrgao = $em->getRepository('CoreBundle:Ima\ConfiguracaoBanrisulOrgao')
            ->findBy($criteria);

        $configBanrisulLocal = $em->getRepository('CoreBundle:Ima\ConfiguracaoBanrisulLocal')
            ->findBy($criteria);

        foreach (array_merge($configBanrisulOrgao, $configBanrisulLocal) as $configBanrisul) {
            $em->remove($configBanrisul);
        }

        $em->flush();
    }

    final private function buildConfiguracaoBanrisulConta(Form $form, Ima\ConfiguracaoConvenioBanrisul $configuracaoConvenioBanrisul)
    {
        $configBanrisulContaFormCollection = $form->get('configuracaoBanrisulContaCollection');

        foreach ($configBanrisulContaFormCollection as $configBanrisulContaForm) {
            if ($configBanrisulContaForm->get('_delete')->getData()) {
                $this->deleteConfigBanrisulConta($configBanrisulContaForm);
            } else {
                $configuracaoBanrisulConta = $configBanrisulContaForm->getData();
                $configuracaoBanrisulConta->setVigencia($form->get('vigencia')->getData());
                $configuracaoBanrisulConta->setCodBanco($form->get('codBanco')->getData());

                $configuracaoConvenioBanrisul->addConfiguracaoBanrisulContaCollection($configuracaoBanrisulConta);

                $this->deleteAllConfiguracoesBanrisulOrgaoLocal($configuracaoBanrisulConta);

                $this->buildConfiguracaoBanrisulOrgao($configBanrisulContaForm, $configuracaoBanrisulConta);
                $this->buildConfiguracaoBanrisulLocal($configBanrisulContaForm, $configuracaoBanrisulConta);
            }
        }
    }

    final private function buildConfiguracaoBanrisulOrgao(Form $configBanrisulContaForm, Ima\ConfiguracaoBanrisulConta $configuracaoBanrisulConta)
    {
        foreach ($configBanrisulContaForm->get('orgao')->getData() as $orgao) {
            $configuracaoBanrisulOrgao = new Ima\ConfiguracaoBanrisulOrgao();
            $configuracaoBanrisulOrgao->fillLikeConfiguracaoBanrisulConta($configuracaoBanrisulConta);
            $configuracaoBanrisulOrgao->setCodOrgao($orgao);

            $configuracaoBanrisulConta->getCodConvenio()->addConfiguracaoBanrisulOrgaoCollection($configuracaoBanrisulOrgao);
        }
    }

    final private function buildConfiguracaoBanrisulLocal(Form $configBanrisulContaForm, Ima\ConfiguracaoBanrisulConta $configuracaoBanrisulConta)
    {
        foreach ($configBanrisulContaForm->get('local')->getData() as $local) {
            $configuracaoBanrisulLocal = new Ima\ConfiguracaoBanrisulLocal();
            $configuracaoBanrisulLocal->fillLikeConfiguracaoBanrisulConta($configuracaoBanrisulConta);
            $configuracaoBanrisulLocal->setCodLocal($local);

            $configuracaoBanrisulConta->getCodConvenio()->addConfiguracaoBanrisulLocalCollection($configuracaoBanrisulLocal);
        }
    }

    public function prePersist($configuracaoConvenioBanrisul)
    {
        $this->buildConfiguracaoBanrisulConta($this->getForm(), $configuracaoConvenioBanrisul);
    }

    public function preUpdate($configuracaoConvenioBanrisul)
    {
        $this->buildConfiguracaoBanrisulConta($this->getForm(), $configuracaoConvenioBanrisul);
    }
}
