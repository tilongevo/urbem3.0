<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Bridge\Doctrine\Form\ChoiceList\IdReader;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica;
use Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica;
use Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoDepreciacao;
use Urbem\CoreBundle\Helper\CustomIdReader;
use Urbem\CoreBundle\Model\Contabilidade\PlanoAnaliticaModel;
use Urbem\CoreBundle\Model\Contabilidade\PlanoContaModel;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\GrupoModel;
use Urbem\CoreBundle\Repository\Contabilidade\PlanoAnaliticaRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class GrupoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_patrimonio_grupo';

    protected $baseRoutePattern = 'patrimonial/patrimonio/grupo';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nomGrupo', null, ['label' => 'label.patrimonial.grupo.nomGrupo'])
            ->add('fkPatrimonioNatureza', 'doctrine_orm_choice', ['label' => 'label.natureza.modulo'], 'entity', [
                'class' => 'CoreBundle:Patrimonio\Natureza'
            ]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('nomGrupo', 'text', [
                'label' => 'label.patrimonial.grupo.nomGrupo',
                'sortable' => false
            ])
            ->add('fkPatrimonioNatureza', 'entity', [
                'class' => 'CoreBundle:Patrimonio\Natureza',
                'label' => 'label.natureza.modulo',
                'sortable' => false
            ])
            ->add('depreciacao', 'text', [
                'label' => 'label.patrimonio.grupo.depreciacao',
                'sortable' => false
            ]);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();

        $grupo = $contaContabilBem = $contaTransferencia = $contaDoacao = null;
        $contaPerdaInvoluntaria = $contaAlienacaoGanho = $contaAlienacaoPerda = $contaDepreciacao = null;

        if (null !== $id) {
            /** @var  $grupo \Urbem\CoreBundle\Entity\Patrimonio\Grupo */
            $grupo = $this->modelManager->find($this->getClass(), $id);

            $exercicio = $this->getSubject()->getFkPatrimonioGrupoPlanoAnaliticas()->last()->getExercicio();

            $grupoPlanoAnalitica = $grupo->getFkPatrimonioGrupoPlanoAnaliticas($exercicio);
            $grupoPlanoDepreciacao = $grupo->getFkPatrimonioGrupoPlanoDepreciacoes($exercicio);

            if (1 === $grupoPlanoAnalitica->count()) {
                /** @var  $grupoPlanoAnalitica \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoAnalitica */
                $grupoPlanoAnalitica = $grupoPlanoAnalitica->first();

                $contaContabilBem = $grupoPlanoAnalitica->getFkContabilidadePlanoAnalitica1();
                $contaDoacao = $grupoPlanoAnalitica->getFkContabilidadePlanoAnalitica2();
                $contaPerdaInvoluntaria = $grupoPlanoAnalitica->getFkContabilidadePlanoAnalitica3();
                $contaTransferencia = $grupoPlanoAnalitica->getFkContabilidadePlanoAnalitica4();
                $contaAlienacaoGanho = $grupoPlanoAnalitica->getFkContabilidadePlanoAnalitica();
                $contaAlienacaoPerda = $grupoPlanoAnalitica->getFkContabilidadePlanoAnalitica5();
            }

            if (1 === $grupoPlanoDepreciacao->count()) {
                /** @var  $grupoPlanoDepreciacao \Urbem\CoreBundle\Entity\Patrimonio\GrupoPlanoDepreciacao */
                $grupoPlanoDepreciacao = $grupoPlanoDepreciacao->first();

                $contaDepreciacao = $grupoPlanoDepreciacao->getFkContabilidadePlanoAnalitica();
            }
        }

        $choiceValue = function (PlanoAnalitica $planoAnalitica = null) {
            return $planoAnalitica ? sprintf('%s-%s', $planoAnalitica->getCodPlano(), $planoAnalitica->getExercicio()) : null;
        };

        $fieldOptions['contaPadrao'] = [
            'route' => ['name' => 'carrega_plano_analitica'],
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'Selecione',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['contaContabil'] = $fieldOptions['contaPadrao'];
        $fieldOptions['contaContabil']['label'] = 'label.patrimonio.grupo.plano.analitica.contaContabilBem';
        $fieldOptions['contaContabil']['req_params']['codEstrutural'] = '1.2.3';
        $fieldOptions['contaContabil']['required'] = true;

        $fieldOptions['contaDoacao'] = $fieldOptions['contaPadrao'];
        $fieldOptions['contaDoacao']['label'] = 'label.patrimonio.grupo.plano.analitica.contaDoacao';
        $fieldOptions['contaDoacao']['req_params']['codEstrutural'] = '3';

        $fieldOptions['contaPerdaInvoluntaria'] = $fieldOptions['contaPadrao'];
        $fieldOptions['contaPerdaInvoluntaria']['label'] = 'label.patrimonio.grupo.plano.analitica.contaPerdaInvoluntaria';
        $fieldOptions['contaPerdaInvoluntaria']['req_params']['codEstrutural'] = '3';

        $fieldOptions['contaTransferencia'] = $fieldOptions['contaPadrao'];
        $fieldOptions['contaTransferencia']['label'] = 'label.patrimonio.grupo.plano.analitica.contaTransferencia';
        $fieldOptions['contaTransferencia']['req_params']['codEstrutural'] = '3';

        $fieldOptions['contaAlienacaoGanho'] = $fieldOptions['contaPadrao'];
        $fieldOptions['contaAlienacaoGanho']['label'] = 'label.patrimonio.grupo.plano.analitica.contaAlienacaoGanho';
        $fieldOptions['contaAlienacaoGanho']['req_params']['codEstrutural'] = '4.6.2.2.1';

        $fieldOptions['contaAlienacaoPerda'] = $fieldOptions['contaPadrao'];
        $fieldOptions['contaAlienacaoPerda']['label'] = 'label.patrimonio.grupo.plano.analitica.contaAlienacaoPerda';
        $fieldOptions['contaAlienacaoPerda']['req_params']['codEstrutural'] = '3.6.2.2.1';

        $fieldOptions['contaDepreciacao'] = $fieldOptions['contaPadrao'];
        $fieldOptions['contaDepreciacao']['label'] = 'label.patrimonio.grupo.plano.analitica.contaDepreciacao';
        $fieldOptions['contaDepreciacao']['req_params']['codEstrutural'] = '1.2.3.8.1';

        if ($this->id($this->getSubject())) {
            $valor = $this->getSubject()->getFkPatrimonioGrupoPlanoAnaliticas()
                ->last()
                ->getFkContabilidadePlanoAnalitica();
            $fieldOptions['contaAlienacaoGanho']['data'] = isset($valor) ? $valor : null;

            $valor1 = $this->getSubject()->getFkPatrimonioGrupoPlanoAnaliticas()
                ->last()
                ->getFkContabilidadePlanoAnalitica1();
            $fieldOptions['contaContabil']['data'] = isset($valor1) ? $valor1 : null;

            $valor2 = $this->getSubject()->getFkPatrimonioGrupoPlanoAnaliticas()
                ->last()
                ->getFkContabilidadePlanoAnalitica2();
            $fieldOptions['contaDoacao']['data'] = isset($valor2) ? $valor2 : null;

            $valor3 = $this->getSubject()->getFkPatrimonioGrupoPlanoAnaliticas()
                ->last()
                ->getFkContabilidadePlanoAnalitica3();
            $fieldOptions['contaPerdaInvoluntaria']['data'] = isset($valor3) ? $valor3 : null;

            $valor4 = $this->getSubject()->getFkPatrimonioGrupoPlanoAnaliticas()
                ->last()
                ->getFkContabilidadePlanoAnalitica4();
            $fieldOptions['contaTransferencia']['data'] = isset($valor4) ? $valor4 : null;

            $valor5 = $this->getSubject()->getFkPatrimonioGrupoPlanoAnaliticas()
                ->last()
                ->getFkContabilidadePlanoAnalitica5();
            $fieldOptions['contaAlienacaoPerda']['data'] = isset($valor5) ? $valor5 : null;

            $valorDepreciacao = $this->getSubject()->getFkPatrimonioGrupoPlanoDepreciacoes()->last();

            $fieldOptions['contaDepreciacao']['data'] = ($valorDepreciacao) ? $valorDepreciacao->getFkContabilidadePlanoAnalitica() : null;
        }

        $formMapper
            ->add('exercicio', 'number', [
                'label' => 'exercicio',
                'data' => $exercicio,
                'disabled' => true,
                'mapped' => false
            ])
            ->add('fkPatrimonioNatureza', 'entity', [
                'class' => 'CoreBundle:Patrimonio\Natureza',
                'label' => 'label.natureza.modulo',
                'placeholder' => 'label.selecione',
                'disabled' => null !== $id,
                'attr' => array(
                    'class' => 'select2-parameters '
                ),
            ])
            ->add('nomGrupo', 'text', [
                'label' => 'label.grupo.nomGrupo'
            ])
            ->add('depreciacao', 'text', [
                'label' => 'label.patrimonio.grupo.depreciacao',
                'attr' => [
                    'class' => 'money ',
                    'maxlength' => 6
                ]
            ])
            ->end()
            ->with('Contas')
            // Conta Contábil do Bem
            ->add('contaContabilBem', 'autocomplete', $fieldOptions['contaContabil'])
            // Conta de VPD para Baixa por Doação
            ->add('contaDoacao', 'autocomplete', $fieldOptions['contaDoacao'])
            // Conta de VPD para Baixa por Perda Involuntária
            ->add('contaPerdaInvoluntaria', 'autocomplete', $fieldOptions['contaPerdaInvoluntaria'])
            // Conta de VPD para Baixa por Transferência
            ->add('contaTransferencia', 'autocomplete', $fieldOptions['contaTransferencia'])
            // Conta de VPA para Alienação (Ganho)
            ->add('contaAlienacaoGanho', 'autocomplete', $fieldOptions['contaAlienacaoGanho'])
            // Conta de VPD para Alienação (Perda)
            ->add('contaAlienacaoPerda', 'autocomplete', $fieldOptions['contaAlienacaoPerda'])
            // Conta Contábil de Depreciação Acumulada
            ->add('contaDepreciacao', 'autocomplete', $fieldOptions['contaDepreciacao'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $this->data['fkPatrimonioGrupoPlanoAnaliticas'] = $this->getSubject()->getFkPatrimonioGrupoPlanoAnaliticas();
        $this->data['fkPatrimonioGrupoPlanoDepreciacoes'] = $this->getSubject()->getFkPatrimonioGrupoPlanoDepreciacoes();
        $showMapper
            ->add('nomGrupo', null, [
                'label' => 'label.patrimonial.grupo.nomGrupo',
            ])
            ->add('fkPatrimonioNatureza', null, [
                'label' => 'label.natureza.modulo',
            ])
            ->add('depreciacao', null, [
                'label' => 'label.patrimonial.grupo.depreciacao'
            ])
            ->add('fkPatrimonioGrupoPlanoAnaliticas', 'entity', [
                'label' => 'label.patrimonio.grupo.plano.analitica.contas',
                'template' => 'PatrimonialBundle:Patrimonial\Grupo:grupoPlanoAnaliticas.html.twig'
            ])
        ;
    }

    public function makeRelationships($object, $form)
    {
        $exercicio = $this->getExercicio();

        $grupoPlanoAnalitica = $object->getFkPatrimonioGrupoPlanoAnaliticas($exercicio);
        $grupoPlanoDepreciacao = $object->getFkPatrimonioGrupoPlanoDepreciacoes($exercicio);

        if (0 === $grupoPlanoAnalitica->count()) {
            $grupoPlanoAnalitica = new GrupoPlanoAnalitica();
            $grupoPlanoAnalitica->setExercicio($exercicio);
            $grupoPlanoAnalitica->setFkPatrimonioGrupo($object);
        } else {
            $grupoPlanoAnalitica = $grupoPlanoAnalitica->first();
        }

        if (0 === $grupoPlanoDepreciacao->count()) {
            $grupoPlanoDepreciacao = new GrupoPlanoDepreciacao();
            $grupoPlanoDepreciacao->setExercicio($exercicio);
            $grupoPlanoDepreciacao->setFkPatrimonioGrupo($object);
        } else {
            $grupoPlanoDepreciacao = $grupoPlanoDepreciacao->first();
        }

        $em = $this->modelManager->getEntityManager('CoreBundle:Patrimonio\Grupo');

        $plano = $form->get('contaContabilBem')->getData();
        $grupoPlanoBem = $this->retornaGrupoPlanoBem($plano, $em);
        $grupoPlanoAnalitica->setFkContabilidadePlanoAnalitica1($grupoPlanoBem);

        if ("" !== $form->get('contaDoacao')->getData()) {
            $plano = $form->get('contaDoacao')->getData();
            $grupoPlanoDoacao = $this->retornaGrupoPlanoBem($plano, $em);
            $grupoPlanoAnalitica->setFkContabilidadePlanoAnalitica2($grupoPlanoDoacao);
        }

        if ("" !== $form->get('contaPerdaInvoluntaria')->getData()) {
            $plano = $form->get('contaPerdaInvoluntaria')->getData();
            $grupoPlanoPerdaInvoluntaria = $this->retornaGrupoPlanoBem($plano, $em);
            $grupoPlanoAnalitica->setFkContabilidadePlanoAnalitica3($grupoPlanoPerdaInvoluntaria);
        }

        if ("" !== $form->get('contaTransferencia')->getData()) {
            $plano = $form->get('contaTransferencia')->getData();
            $grupoPlanoContaTransferencia = $this->retornaGrupoPlanoBem($plano, $em);
            $grupoPlanoAnalitica->setFkContabilidadePlanoAnalitica4($grupoPlanoContaTransferencia);
        }

        if ("" !== $form->get('contaAlienacaoGanho')->getData()) {
            $plano = $form->get('contaAlienacaoGanho')->getData();
            $grupoPlanoAlienacaoGanho = $this->retornaGrupoPlanoBem($plano, $em);
            $grupoPlanoAnalitica->setFkContabilidadePlanoAnalitica($grupoPlanoAlienacaoGanho);
        }

        if ("" !== $form->get('contaAlienacaoPerda')->getData()) {
            $plano = $form->get('contaAlienacaoPerda')->getData();
            $grupoPlanoAlienacaoPerda = $this->retornaGrupoPlanoBem($plano, $em);
            $grupoPlanoAnalitica->setFkContabilidadePlanoAnalitica5($grupoPlanoAlienacaoPerda);
        }

        if ("" !== $form->get('contaDepreciacao')->getData()) {
            $plano = $form->get('contaDepreciacao')->getData();
            $grupoPlanoContaDepreciacao = $this->retornaGrupoPlanoBem($plano, $em);
            $grupoPlanoDepreciacao->setFkContabilidadePlanoAnalitica($grupoPlanoContaDepreciacao);
        }

        if (null !== $grupoPlanoAnalitica->getCodPlano()) {
            $object->addFkPatrimonioGrupoPlanoAnaliticas($grupoPlanoAnalitica);
        }
        if (null !== $grupoPlanoDepreciacao->getCodPlano()) {
            $object->addFkPatrimonioGrupoPlanoDepreciacoes($grupoPlanoDepreciacao);
        }
    }

    public function prePersist($object)
    {
        /** @var $object \Urbem\CoreBundle\Entity\Patrimonio\Grupo */

        $form = $this->getForm();

        $em = $this->modelManager->getEntityManager('CoreBundle:Patrimonio\Grupo');

        $grupoModel = new GrupoModel($em);
        $codGrupo = $grupoModel->getProximoCodGrupo($form->get('fkPatrimonioNatureza')->getData()->getCodNatureza());

        $object->setCodGrupo($codGrupo);

        $this->makeRelationships($object, $form);
    }

    public function preUpdate($object)
    {
        $form = $this->getForm();
        $this->makeRelationships($object, $form);
    }

    /**
     * @param $plano
     * @param $em
     * @return null|PlanoAnalitica
     */
    public function retornaGrupoPlanoBem($plano, $em)
    {
        $search = strpos($plano, '~');
        $search = ($search === false) ? "/" : "~";

        list($codPlano, $exercicioPlano) = explode($search, $plano);

        if ($search == "/") {
            $exercicioPlano = substr($exercicioPlano, 0, 4);
        }

        $params = ['codPlano' => $codPlano, 'exercicio' => $exercicioPlano];

        $grupoPlanoAnaliticaModel = new PlanoAnaliticaModel($em);
        $grupoPlanoBem = $grupoPlanoAnaliticaModel->getPlanoAnalitica($params);
        return $grupoPlanoBem;
    }
}
