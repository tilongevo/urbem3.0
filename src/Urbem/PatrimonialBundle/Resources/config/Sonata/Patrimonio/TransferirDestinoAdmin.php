<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Patrimonio\Bem;
use Urbem\CoreBundle\Entity\Patrimonio\BemResponsavel;
use Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem;
use Urbem\CoreBundle\Entity\Patrimonio\SituacaoBem;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata;

class TransferirDestinoAdmin extends AbstractOrganogramaSonata
{

    protected $baseRouteName = 'urbem_patrimonial_patrimonio_bem_transferir_destino';

    protected $baseRoutePattern = 'patrimonial/patrimonio/bem/transferir-destino';

    protected $includeJs = [
        '/administrativo/javascripts/organograma/estruturaDinamicaOrganograma.js',
        '/core/javascripts/sw-processo.js',

    ];

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $this->getExercicio();


        if (!$this->id($this->getSubject()) && 'POST' == $this->getRequest()->getMethod()) {
            $this->executeScriptLoadData($this->getRequest()->request->get($this->getUniqid()));
        }

        $formMapper
            ->with('Local de Destino')
            ->add(
                'origem',
                'hidden',
                [
                    'mapped' => false,
                    'data' => serialize($this->getRequest()->query->all()),
                ]
            )
        ;
        $this->createFormOrganograma($formMapper, true);
        $formMapper
            ->add(
                'local_destino',
                'entity',
                [
                    'class' => Local::class,
                    'choice_label' => 'descricao',
                    'label' => 'label.bem.local',
                    'mapped' => false,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                    'placeholder' => 'label.selecione'
                ]
            )
            ->add(
                'descricao',
                'text',
                [
                    'mapped' => false,
                    'label' =>  'label.bem.descricao',
                ]
            )
            ->add(
                'responsavel_destino',
                'autocomplete',
                [
                    'label' => 'label.bem.responsavel',
                    'multiple' => false,
                    'mapped' => false,
                    'required' => true,
                    'route' => ['name' => 'carrega_sw_cgm'],
                    'placeholder' => 'Selecione'
                ]
            )
            ->add(
                'termo',
                'choice',
                [
                    'choices' => [
                        'sim' => 'true',
                        'nao' => 'false'
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'mapped' => false,
                    'label' => 'label.bem.termo',
                    'label_attr' => [
                        'class' => 'checkbox-sonata'
                    ],
                    'attr' => [
                        'class' => 'checkbox-sonata'
                    ]
                ]
            )
            ->add(
                'demonstrar',
                'choice',
                [
                    'choices' => [
                        'sim' => 'true',
                        'nao' => 'false'
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'mapped' => false,
                    'label' => 'label.bem.demonstrar',
                    'label_attr' => [
                        'class' => 'checkbox-sonata'
                    ],
                    'attr' => [
                        'class' => 'checkbox-sonata'
                    ]
                ]
            )
            ->end()
        ;
    }

    public function prePersist($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $origem = unserialize($formData['origem']);
        $doc = $this->getDoctrine();

        $organogramaOrigem = $this->getFieldFromForm($origem);
        $orgaoOrigem = end($organogramaOrigem)['value'];

        $organogramaDestino = $this->getFieldFromForm($formData);
        $orgaoDestino = end($organogramaDestino)['value'];

        foreach ($origem['codBem'] as $codBem) {
            $bem = $doc->getRepository(Bem::class)->find($codBem);
            if ($orgaoOrigem != $orgaoDestino ||
                $origem['local_origem'] != $formData['local_destino']
            ) {
                $historico = new HistoricoBem();
                $historico->setCodBem($codBem);
                $historico->setCodOrgao($orgaoDestino);
                $historico->setDescricao($formData['descricao']);
                $historico->setCodLocal($formData['local_destino']);
                $historico->setCodSituacao(
                    $doc->getRepository(HistoricoBem::class)->findOneBy([
                            'codBem' => $codBem
                        ])->getCodSituacao()
                );
                $doc->persist($historico);
            }

            if ($origem['responsavel'] != $formData['responsavel_destino']) {
                /** @var BemResponsavel $responsavel */
                $responsavel = $bem->getFkPatrimonioBemResponsaveis()->last();
                if ($responsavel) {
                    $responsavel->setDtFim(new \DateTime());
                    $doc->persist($responsavel);
                }
                $responsavelNovo = new BemResponsavel();
                $responsavelNovo->setCodBem($codBem);
                $responsavelNovo->setNumcgm($formData['responsavel_destino']);
                $bem->addFkPatrimonioBemResponsaveis($responsavelNovo);
                $doc->persist($responsavelNovo);
                $doc->persist($bem);
            }
        }

        $this->getDoctrine()->flush();
        $this->getFlashBag()->add('success', 'Transferencia criada com sucesso!');
        $this->forceRedirect('/patrimonial/patrimonio/bem/transferir/create');
    }
}
