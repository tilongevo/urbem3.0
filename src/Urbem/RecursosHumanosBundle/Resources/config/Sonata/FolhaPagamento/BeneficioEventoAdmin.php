<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoBeneficioFornecedor;
use Sonata\AdminBundle\Route\RouteCollection;

class BeneficioEventoAdmin extends AbstractAdmin
{
    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->clearExcept(['create']);
        ;
    }
    
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        
        $eventoModel = new EventoModel($entityManager);
        $eventoEntity = $eventoModel->getEventoPensaoFuncaoPadrao();
        
        $fieldOptions['cgmFornecedor'] = [
            'class' => LayoutFornecedor::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->createQueryBuilder('o')
                    ->innerJoin('CoreBundle:Compras\Fornecedor', 'cf', 'WITH', 'cf.cgmFornecedor = o.cgmFornecedor')
                    ->innerJoin('CoreBundle:SwCgm', 'swcgm', 'WITH', 'swcgm.numcgm = cf.cgmFornecedor')
                    ->where('LOWER(swcgm.nomCgm) LIKE :nomCgm')
                    ->setParameter('nomCgm', "%" . strtolower($term) ."%");
                ;
            },
            'json_choice_label' => function (LayoutFornecedor $layoutFornecedor) {
                $swCgm = $layoutFornecedor->getFkComprasFornecedor()->getFkSwCgm();
                
                return $swCgm->getNumcgm() . " - " . $swCgm->getNomCgm();
            },
            'label' => 'label.configuracaoBeneficio.cgmFornecedor',
            'mapped' => false,
        ];
        
        $fieldOptions['fkFolhapagamentoEvento'] = [
            'class' => Evento::class,
            'choice_label' => function ($evento) {
                return $evento->getCodigo() . ' - ' . $evento->getDescricao();
            },
            'label' => 'label.configuracaoBeneficio.fkFolhapagamentoEvento',
            'query_builder' => $eventoEntity,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];
        
        $fieldOptions['textoComplementar'] = [
            'label' => 'label.configuracaoBeneficio.textoComplementar',
            'mapped' => false,
            'disabled' => true,
        ];
        
        if ($this->id($this->getSubject())) {
            $cgmFornecedor = $this->modelManager->findOneBy(
                ConfiguracaoBeneficioFornecedor::class,
                [
                    'timestamp' => $this->getSubject()->getTimestamp()->format("Y-m-d H:i:s.u"),
                    'codConfiguracao' => $this->getSubject()->getCodConfiguracao()
                ]
            );
            
            if ($cgmFornecedor) {
                $fieldOptions['cgmFornecedor']['data'] = $cgmFornecedor->getFkBeneficioLayoutFornecedor();
            }
            
            $fieldOptions['textoComplementar']['data'] = $this->getSubject()->getFkFolhapagamentoEvento()
            ->getFkFolhapagamentoEventoEventos()->last()->getObservacao();
        }
        
        $formMapper
            ->add(
                'cgmFornecedor',
                'autocomplete',
                $fieldOptions['cgmFornecedor']
            )
            ->add(
                'fkFolhapagamentoEvento',
                'entity',
                $fieldOptions['fkFolhapagamentoEvento']
            )
            ->add(
                'textoComplementar',
                'text',
                $fieldOptions['textoComplementar']
            )
        ;
    }
}
