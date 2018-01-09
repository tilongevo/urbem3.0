<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Config\Definition\Exception\Exception;
use Urbem\CoreBundle\Entity\Folhapagamento\PensaoEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\PensaoFuncaoPadrao;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PensaoEventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PensaoFuncaoPadraoModel;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;

class PensaoFuncaoPadraoAdmin extends AbstractAdmin
{
    /** @var string */
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_pensao_funcao_padrao';
    /** @var string */
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/pensao-funcao-padrao';
    /** @var bool */
    protected $exibirBotaoIncluir = false;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->clearExcept(array('list', 'edit'));
        ;
    }
    
    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        
        $query = parent::createQuery($context);
        
        $pensaoFuncaoPadrao = $entityManager->createQueryBuilder();
        $pensaoFuncaoPadrao->from('CoreBundle:Folhapagamento\PensaoFuncaoPadrao', 'pfp');
        $pensaoFuncaoPadrao->innerJoin('pfp.fkFolhapagamentoPensaoEventos', 'pe');
        $pensaoFuncaoPadrao->select('MAX(pfp.timestamp) AS timestamp');
        
        $query->andWhere($query->expr()->in('o.timestamp', $pensaoFuncaoPadrao->getDql()));
        
        return $query;
    }
    
    /**
     * Retorna a descrição da Pensao Evento
     * @param  \Urbem\CoreBundle\Entity\Folhapagamento\PensaoFuncaoPadrao $object
     * @return string
     */
    public function getDescricaoPensaoEvento($object)
    {
        $evento = $object->getFkFolhapagamentoPensaoEventos()->last();
        
        return $evento->getFkFolhapagamentoEvento()->getCodigo()
        . " - " . $evento->getFkFolhapagamentoEvento()->getDescricao()
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'descricaoFuncao',
                'text',
                [
                    'label' => 'label.calculoPensaoAlimenticia.descricaoFuncao',
                ],
                [
                    'sortable' => false
                ]
            )
            ->add(
                'descricaoPensaoEvento',
                'text',
                [
                    'label' => 'label.calculoPensaoAlimenticia.descricaoPensaoEvento',
                    'template' => 'RecursosHumanosBundle::Sonata/Pessoal/PensaoFuncaoPadrao/list_descricaoPensaoEvento_field.html.twig'
                ],
                [
                    'sortable' => false
                ]
            )
        ;
            
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\Evento');

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $eventoModel = new EventoModel($em);
        $eventoEntity = $eventoModel->getEventoPensaoFuncaoPadrao();
        
        $fieldOptions['codConfiguracaoPensao'] = [
            'class' => Evento::class,
            'choice_label' => function ($evento) {
                return $evento->getCodigo() . ' - ' . $evento->getDescricao();
            },
            'label' => 'label.calculoPensaoAlimenticia.descricaoPensaoEvento',
            'query_builder' => $eventoEntity,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];
        
        $fieldOptions['fkAdministracaoFuncao'] = [
            'class' => Funcao::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->createQueryBuilder('o')
                            ->where('o.nomFuncao LIKE :nomFuncao')
                            ->setParameter('nomFuncao', "%{$term}%")
                ;
            },
            'label' => 'label.funcao.modulo',
        ];
        
        if ($this->id($this->getSubject())) {
            $fieldOptions['codConfiguracaoPensao']['data'] = $this->getSubject()
            ->getFkFolhapagamentoPensaoEventos()->last()->getFkFolhapagamentoEvento();
        }

        $formMapper
            ->add(
                'codConfiguracaoPensao',
                'entity',
                $fieldOptions['codConfiguracaoPensao']
            )
            ->add(
                'fkAdministracaoFuncao',
                'autocomplete',
                $fieldOptions['fkAdministracaoFuncao']
            )
        ;
    }
}
