<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal\Assentamento;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Pessoal;
use Urbem\CoreBundle\Model\Pessoal\Assentamento;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class AssentamentoAfastamentoTemporarioAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_assentamento_configuracao_afastamento_temporario';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/assentamento/configuracao/afastamento/temporario';
    
    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create', 'edit'));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->getRequest()->isMethod('GET')) {
            $codAssentamento = $this->getAdminRequestId();
        } else {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codAssentamento = $formData['codAssentamento'];
        }
        
        if ($this->id($this->getSubject())) {
            $codAssentamento = explode("~", $codAssentamento);
            $codAssentamento = $codAssentamento[0];
        }
        
        $this->setBreadCrumb($codAssentamento ? ['id' => $codAssentamento] : []);
        
        $fieldOptions = array();
        
        $fieldOptions['codAssentamento'] = [
            'data' => $codAssentamento
        ];
        
        $fieldOptions['movSefipSaida'] = [
            'class' => Pessoal\MovSefipSaida::class,
            'choice_label' => function ($sefip) {
                $descricao = $sefip->getFkPessoalSefip()->getDescricao();
                $numSefip =  $sefip->getFkPessoalSefip()->getNumSefip();
                return "{$numSefip} - {$descricao}";
            },
            'placeholder' => 'label.selecione',
            'label' => 'label.assentamento.movSefipSaida',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];
        
        $fieldOptions['raisAfastamento'] = [
            'class' => Pessoal\RaisAfastamento::class,
            'choice_label' => function ($rais) {
                $descricao = $rais->getDescricao();
                $codigo = $rais->getCodRais();

                return "{$codigo} - {$descricao}";
            },
            'label' => 'label.assentamento.raisAfastamento',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];
        
        $fieldOptions['qtdeDias'] = [
            'label' => 'label.assentamento.qtdeDias',
            'mapped' => false,
        ];
        
        $fieldOptions['inicioIntervalo'] = [
            'label' => 'label.assentamento.inicioIntervalo',
            'mapped' => false,
            'required' => false
        ];
        
        $fieldOptions['fimIntervalo'] = [
            'label' => 'label.assentamento.fimIntervalo',
            'mapped' => false,
            'required' => false
        ];
        
        $fieldOptions['desconto'] = [
            'label' => 'label.assentamento.desconto',
            'mapped' => false,
            'required' => false
        ];
        
        if ($this->id($this->getSubject())) {
            if ($this->getSubject()->getFkPessoalAssentamentoMovSefipSaida()) {
                $fieldOptions['movSefipSaida']['data'] = $this->getSubject()
                ->getFkPessoalAssentamentoMovSefipSaida()->getFkPessoalMovSefipSaida();
            }
            
            if ($this->getSubject()->getFkPessoalAssentamentoRaisAfastamento()) {
                $fieldOptions['raisAfastamento']['data'] = $this->getSubject()
                ->getFkPessoalAssentamentoRaisAfastamento()->getFkPessoalRaisAfastamento();
            }
            
            if ($this->getSubject()->getFkPessoalAssentamentoAfastamentoTemporarioDuracao()) {
                $fieldOptions['qtdeDias']['data'] = $this->getSubject()
                ->getFkPessoalAssentamentoAfastamentoTemporarioDuracao()->getDia();
            }
        }
        
        $formMapper
            ->with('label.assentamento.codigoMovimentacaoSefip')
                ->add(
                    'codAssentamento',
                    'hidden',
                    $fieldOptions['codAssentamento']
                )
                ->add(
                    'movSefipSaida',
                    'entity',
                    $fieldOptions['movSefipSaida']
                )
                ->add(
                    'raisAfastamento',
                    'entity',
                    $fieldOptions['raisAfastamento']
                )
            ->end()
            ->with('label.assentamento.periodoDuracaoAfastamento')
                ->add(
                    'qtdeDias',
                    'number',
                    $fieldOptions['qtdeDias']
                )
            ->end()
            ->with('label.assentamento.intervaloDiasProporcaoSalario')
                ->add(
                    'inicioIntervalo',
                    'number',
                    $fieldOptions['inicioIntervalo']
                )
                ->add(
                    'fimIntervalo',
                    'number',
                    $fieldOptions['fimIntervalo']
                )
                ->add(
                    'desconto',
                    'percent',
                    $fieldOptions['desconto']
                )
            ->end()
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
        $fkPessoalAssentamento = $entityManager->getRepository("CoreBundle:Pessoal\Assentamento")
        ->findOneBy(
            array(
                'codAssentamento' => $this->getForm()->get('codAssentamento')->getData()
            ),
            array(
                'timestamp' => 'DESC'
            )
        );

        $object->setFkPessoalAssentamento($fkPessoalAssentamento);
    }
    
    /**
     * {@inheritdoc}
     */
    public function postPersist($object)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
        (new Assentamento\AssentamentoAfastamentoTemporarioModel($entityManager))
        ->createAssentamentoAfastamentoTemporario($this->getForm());

        (new RedirectResponse('/recursos-humanos/pessoal/assentamento/configuracao/' . $this->getForm()->get('codAssentamento')->getData() .'/show'))->send();
    }
    
    /**
     * {@inheritdoc}
     */
    public function preUpdate($object)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
        $entityManager
        ->getRepository("CoreBundle:Pessoal\AssentamentoAfastamentoTemporario")
        ->removeChild(
            array(
                'cod_assentamento' => $this->getForm()->get('codAssentamento')->getData()
            )
        );
        
        $fkPessoalAssentamento = $entityManager->getRepository("CoreBundle:Pessoal\Assentamento")
        ->findOneBy(
            array(
                'codAssentamento' => $this->getForm()->get('codAssentamento')->getData()
            ),
            array(
                'timestamp' => 'DESC'
            )
        );
        
        if ($fkPessoalAssentamento->getFkPessoalAssentamentoAfastamentoTemporario()) {
            $fkPessoalAssentamento = (new Assentamento\AssentamentoAssentamentoModel($entityManager))
            ->cloneAssentamento($fkPessoalAssentamento);
        }
        
        $object->setFkPessoalAssentamento($fkPessoalAssentamento);
    }
    
    /**
     * {@inheritdoc}
     */
    public function postUpdate($object)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
        (new Assentamento\AssentamentoAfastamentoTemporarioModel($entityManager))
        ->createAssentamentoAfastamentoTemporario($this->getForm());

        (new RedirectResponse('/recursos-humanos/pessoal/assentamento/configuracao/' . $this->getForm()->get('codAssentamento')->getData() .'/show'))->send();
    }
}
