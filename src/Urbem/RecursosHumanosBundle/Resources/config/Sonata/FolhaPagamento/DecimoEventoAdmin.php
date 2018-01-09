<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\DecimoEvento;

class DecimoEventoAdmin extends AbstractAdmin
{

    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_configuracao_calculo_13_salario';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configuracao/calculo-13-salario';


    public function createQuery($context = 'list')
    {
        $qb2 = $this->getModelManager()->getEntityManager($this->getClass())->createQueryBuilder();
        $qb2->select('MAX(d.timestamp)')
            ->from('CoreBundle:Folhapagamento\DecimoEvento', 'd');

        $query = parent::createQuery($context);
        $query->andWhere(
            $query->expr()->in($query->getRootAliases()[0] . '.timestamp', $qb2->getDql())
        );
        return $query;
    }


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

        $this->setBreadCrumb();
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codEvento.codEvento')
            ->add('codEvento')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $ano = $this->getExercicio();

        $em = $this->modelManager->getEntityManager('CoreBundle:Folhapagamento\DecimoEvento');
        $qb = $em->createQueryBuilder();
        $qb->select('d')
            ->from(DecimoEvento::class, 'd')
            ->orderBy('d.timestamp', 'desc')
            ->setMaxResults(1);
        $tipos = $qb->getQuery()->getOneOrNullResult();

        $configuracaoAdiantamento13Salario = $em->getRepository('CoreBundle:Administracao\Configuracao')->findOneBy(['parametro' => 'adiantamento_13_salario', 'codModulo' => '27', 'exercicio' => $ano]);
        $configuracaoMesCalculoDecimo = $em->getRepository('CoreBundle:Administracao\Configuracao')->findOneBy(['parametro' => 'mes_calculo_decimo', 'codModulo' => '27', 'exercicio' => $ano]);


        $saldo = '11';
        $adiantamento = 'true';
        $decimoEvento = '';

        if (!is_null($configuracaoMesCalculoDecimo)) {
            $saldo = $configuracaoMesCalculoDecimo->getValor();
        }

        if (!is_null($configuracaoAdiantamento13Salario)) {
            $adiantamento = $configuracaoAdiantamento13Salario->getValor();
        }

        if (!is_null($tipos)) {
            $decimoEvento = $tipos->getCodEvento();
        }

        $formMapper
            ->with('Eventos')
            ->add(
                'codEvento',
                null,
                [
                    'label' => 'Evento',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'data' => $decimoEvento
                ]
            )
            ->add(
                'adiantamento',
                'choice',
                [
                    'choices' => [
                        'Sim'  => 'true',
                        'Não' => 'false',
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'Gera Adiant. de 13º Salário no mês de aniversário',
                    'mapped' => false,
                    'data' => $adiantamento,
                    'label_attr' => array(
                        'class' => 'checkbox-sonata'
                    ),
                    'attr' => array(
                        'class' => 'checkbox-sonata'
                    )
                ]
            )
            ->end()
            ->with('Competência de Pagamento')
            ->add(
                'saldo',
                'choice',
                [
                    'choices' => [
                        'Novembro'  => '11',
                        'Dezembro' => '12',
                    ],
                    'expanded' => true,
                    'multiple' => false,
                    'label' => 'Saldo de 13º Salário',
                    'mapped' => false,
                    'data' => $saldo,
                    'label_attr' => array(
                        'class' => 'checkbox-sonata'
                    ),
                    'attr' => array(
                        'class' => 'checkbox-sonata'
                    )
                ]
            )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codEvento')
        ;
    }

    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $object->setCodTipo($em->getReference('CoreBundle:Folhapagamento\TipoEventoDecimo', 1));

        $adiantamento = $this->getForm()->get('adiantamento')->getData();
        $saldo        = $this->getForm()->get('saldo')->getData();
        $ano          = $this->getExercicio();
        $modulo       = $em->getRepository('CoreBundle:Administracao\Modulo')->findOneBy(['codModulo' => '27']);

        $configuracaoAdiantamento13Salario = $em->getRepository('CoreBundle:Administracao\Configuracao')->findOneBy(['parametro' => 'adiantamento_13_salario', 'codModulo' => '27', 'exercicio' => $ano]);

        if ($configuracaoAdiantamento13Salario == null) {
            $configuracaoAdiantamento13Salario = new Configuracao();
        }

        $configuracaoAdiantamento13Salario->setParametro('adiantamento_13_salario');
        $configuracaoAdiantamento13Salario->setCodModulo($modulo);
        $configuracaoAdiantamento13Salario->setValor($adiantamento);
        $configuracaoAdiantamento13Salario->setExercicio($ano);

        $em->persist($configuracaoAdiantamento13Salario);
        $em->flush();


        $configuracaoMesCalculoDecimo = $em->getRepository('CoreBundle:Administracao\Configuracao')->findOneBy(['parametro' => 'mes_calculo_decimo', 'codModulo' => '27', 'exercicio' => $ano]);

        if ($configuracaoMesCalculoDecimo == null) {
            $configuracaoMesCalculoDecimo = new Configuracao();
        }

        $configuracaoMesCalculoDecimo->setParametro('mes_calculo_decimo');
        $configuracaoMesCalculoDecimo->setCodModulo($modulo);
        $configuracaoMesCalculoDecimo->setValor($saldo);
        $configuracaoMesCalculoDecimo->setExercicio($ano);

        $em->persist($configuracaoMesCalculoDecimo);
        $em->flush();
    }
}
