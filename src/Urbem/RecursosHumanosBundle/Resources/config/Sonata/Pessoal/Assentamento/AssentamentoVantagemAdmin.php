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

class AssentamentoVantagemAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_assentamento_configuracao_afastamento_vantagem';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/assentamento/configuracao/afastamento/vantagem';
    
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

        $fieldOptions['codAssentamento'] = [
            'data' => $codAssentamento,
            'mapped' => false
        ];
        $fieldOptions['dtInicial'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.dtInicial'
        ];
        $fieldOptions['dtFinal'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.dtFinal',
            'required' => false
        ];
        $fieldOptions['quantMeses'] = [
            'label' => 'label.assentamento.quantMeses',
            'mapped' => false,
            'required' => true
        ];
        $fieldOptions['percentualCorrecao'] = [
            'label' => 'label.assentamento.percentualCorrecao',
            'mapped' => false,
            'required' => true
        ];

        if ($this->id($this->getSubject())) {
            if (! $this->getSubject()->getFkPessoalAssentamentoFaixaCorrecoes()->isEmpty()) {
                $fieldOptions['quantMeses']['data'] = $this->getSubject()->getFkPessoalAssentamentoFaixaCorrecoes()
                ->last()->getQuantMeses();
                $fieldOptions['percentualCorrecao']['data'] = $this->getSubject()->getFkPessoalAssentamentoFaixaCorrecoes()
                ->last()->getPercentualCorrecao();
            }
        }

        $formMapper
        ->with('label.assentamento.dadosVantagem')
            ->add(
                'codAssentamento',
                'hidden',
                $fieldOptions['codAssentamento']
            )
            ->add(
                'dtInicial',
                'sonata_type_date_picker',
                $fieldOptions['dtInicial']
            )
            ->add(
                'dtFinal',
                'sonata_type_date_picker',
                $fieldOptions['dtFinal']
            )
        ->end()
            ->with('label.assentamento.definicaoCorrecoes')
            ->add(
                'quantMeses',
                'number',
                $fieldOptions['quantMeses']
            )
            ->add(
                'percentualCorrecao',
                'percent',
                $fieldOptions['percentualCorrecao']
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
        
        (new Assentamento\AssentamentoVantagemModel($entityManager))
        ->createAssentamentoFaixaCorrecao($object, $this->getForm());
        
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
        ->getRepository("CoreBundle:Pessoal\AssentamentoVantagem")
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
        
        if ($fkPessoalAssentamento->getFkPessoalAssentamentoVantagem()) {
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
        
        (new Assentamento\AssentamentoVantagemModel($entityManager))
        ->createAssentamentoFaixaCorrecao($this->getForm());
        
        (new RedirectResponse('/recursos-humanos/pessoal/assentamento/configuracao/' . $this->getForm()->get('codAssentamento')->getData() .'/show'))->send();
    }
}
