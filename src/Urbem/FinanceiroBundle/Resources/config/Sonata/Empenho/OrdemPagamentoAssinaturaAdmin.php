<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Administracao\AssinaturaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class OrdemPagamentoAssinaturaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_ordem_pagamento_assinatura';
    protected $baseRoutePattern = 'financeiro/empenho/ordem-pagamento/assinatura';

    const PAPEL_VISTO = 1;
    const PAPEL_OPERADOR_DESPESA = 2;
    const PAPEL_TESOUREIRO = 3;

    public function getLinkPerfil($object)
    {
        return sprintf(
            '/financeiro/empenho/ordem-pagamento/%s/perfil',
            implode('~', $this->getDoctrine()->getClassMetadata('CoreBundle:Empenho\OrdemPagamento')->getIdentifierValues($object))
        );
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'delete':
                return 'FinanceiroBundle:Empenho\OrdemPagamento:delete.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'codOrdem' => $this->getRequest()->get('codOrdem'),
            'exercicio' => $this->getRequest()->get('exercicio'),
            'codEntidade' => $this->getRequest()->get('codEntidade')
        );
    }

    public function toString($object)
    {
        return $object->getFkSwCgm()->getNomCgm();
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codOrdem')
            ->add('exercicio')
            ->add('codEntidade')
            ->add('numAssinatura')
            ->add('cargo')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codOrdem')
            ->add('exercicio')
            ->add('codEntidade')
            ->add('numAssinatura')
            ->add('cargo')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->getRequest()->getSession()->getFlashBag()->clear();
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();
        $em = $this->modelManager->getEntityManager($this->getClass());
        $model = new AssinaturaModel($em);
        $lastTimestamp = $model->getLastTimestamp();
        $codEntidade = $this->getPersistentParameter('codEntidade');

        $fieldOptions = array();

        $fieldOptions['codOrdem'] = array(
            'data' => $this->getPersistentParameter('codOrdem'),
            'mapped' => false
        );

        $fieldOptions['exercicio'] = array(
            'data' => $this->getPersistentParameter('exercicio'),
            'mapped' => false
        );

        $fieldOptions['codEntidade'] = array(
            'data' => $this->getPersistentParameter('codEntidade'),
            'mapped' => false
        );

        $formMapper
            ->with('label.ordemPagamento.assinaturas')
            ->add('codOrdem', 'hidden', $fieldOptions['codOrdem'])
            ->add('exercicio', 'hidden', $fieldOptions['exercicio'])
            ->add('codEntidade', 'hidden', $fieldOptions['codEntidade'])
            ->add('fkSwCgm', null, [
                'label' => 'label.ordemPagamento.nome',
                'choice_label' => function ($cgm) {
                    $pessoaFisica = $cgm->getFkSwCgmPessoaFisica();
                    $assinatura = $pessoaFisica->getFkAdministracaoAssinaturas()->last();
                    $label = $cgm->getNomCgm();
                    $label .= ' | ' . $assinatura->getCargo();
                    return $label;
                },
                'placeholder' => 'label.selecione',
                'required' => true,
                'attr' => ['class' => 'select2-parameters'],
                'query_builder' => function ($em) use ($exercicio, $lastTimestamp, $codEntidade) {
                    $qb = $em->createQueryBuilder('o');
                    $qb->innerJoin('CoreBundle:Administracao\Assinatura', 'a', 'WITH', 'o.numcgm = a.numcgm');
                    $qb->andWhere('a.exercicio = :exercicio');
                    $qb->andWhere('a.timestamp = :timestamp');
                    $qb->andWhere('a.codEntidade = :codEntidade');
                    $qb->setParameters([
                        'exercicio' => $exercicio,
                        'codEntidade' => $codEntidade,
                        'timestamp' => (string) $lastTimestamp
                    ]);
                    $qb->orderBy('o.nomCgm', 'ASC');
                    return $qb;
                }
            ])
            ->add('papel', 'choice', [
                'label' => 'label.ordemPagamento.papel',
                'placeholder' => 'label.selecione',
                'required' => true,
                'mapped' => false,
                'choices' => [
                    'label.ordemPagamento.visto' => self::PAPEL_VISTO,
                    'label.ordemPagamento.operadorDespesa' => self::PAPEL_OPERADOR_DESPESA,
                    'label.ordemPagamento.tesoureiro' => self::PAPEL_TESOUREIRO
                ],
                'attr' => array(
                    'class' => 'select2-parameters '
                )
            ])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codOrdem')
            ->add('exercicio')
            ->add('codEntidade')
            ->add('numAssinatura')
            ->add('cargo')
        ;
    }

    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $parameters = array(
            'codOrdem' => $this->getForm()->get('codOrdem')->getData(),
            'exercicio' => $this->getForm()->get('exercicio')->getData(),
            'codEntidade' => $this->getForm()->get('codEntidade')->getData()
        );

        $ordemPagamento = $em->getRepository('CoreBundle:Empenho\OrdemPagamento')
            ->findOneBy($parameters);
        $object->setFkEmpenhoOrdemPagamento($ordemPagamento);

        $cargo = $object
            ->getFkSwCgm()
            ->getFkSwCgmPessoaFisica()
            ->getFkAdministracaoAssinaturas()
            ->last()
            ->getCargo();
        $object->setCargo($cargo);

        $numAssinatura = $this->getForm()->get('papel')->getData();
        $object->setNumAssinatura($numAssinatura);
    }

    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        $this->getRequest()->getSession()->getFlashBag()->clear();
        $em = $this->modelManager->getEntityManager($this->getClass());

        $codOrdem = $this->getForm()->get('codOrdem')->getData();
        $exercicio = $this->getForm()->get('exercicio')->getData();
        $codEntidade = $this->getForm()->get('codEntidade')->getData();

        $ordemPagamento = $em->getRepository('CoreBundle:Empenho\OrdemPagamento')
            ->findOneBy([
                'codOrdem' => $codOrdem,
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade
            ]);

        $assinantes = array();
        $papeis = array();

        $assinaturas = $ordemPagamento->getFkEmpenhoOrdemPagamentoAssinaturas();
        foreach ($assinaturas as $assinatura) {
            $assinantes[] = $assinatura->getFkSwCgm();
            $papeis[] = $assinatura->getNumAssinatura();
        }

        if (in_array($object->getFkSwCgm(), $assinantes)) {
            $mensagem = $this->getTranslator()->trans('label.ordemPagamento.erroCgmEmUso');
            $errorElement->with('fkSwCgm')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }

        $numAssinatura = $this->getForm()->get('papel')->getData();
        if (in_array($numAssinatura, $papeis)) {
            $mensagem = $this->getTranslator()->trans('label.ordemPagamento.erroPapelEmUso');
            $errorElement->with('papel')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }
    }

    public function postPersist($object)
    {
        $id = implode('~', $this->getPersistentParameters());
        $url = sprintf('/financeiro/empenho/ordem-pagamento/%s/perfil', $id);
        $this->getRequest()->getSession()->getFlashBag()->clear();
        $this->forceRedirect($url);
    }

    public function postRemove($object)
    {
        $url = sprintf(
            '/financeiro/empenho/ordem-pagamento/%s~%s~%s/perfil',
            $object->getCodOrdem(),
            $object->getExercicio(),
            $object->getCodEntidade()
        );
        $this->getRequest()->getSession()->getFlashBag()->clear();
        $this->forceRedirect($url);
    }
}
