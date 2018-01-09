<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal\Assentamento;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Pessoal;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Urbem\CoreBundle\Model\Pessoal\Assentamento;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AssentamentoAfastamentoPermanenteAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_assentamento_configuracao_afastamento_permanente';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/assentamento/configuracao/afastamento/permanente';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create', 'edit'));
    }

    /**
    * @param FormMapper $formMapper
    */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
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

        $fieldOptions['codAssentamento'] = ['data' => $codAssentamento];
        $fieldOptions['causaRescisao'] = [
            'class' => Pessoal\CausaRescisao::class,
            'choice_label' => 'descricao',
            'expanded' => true,
            'label' => 'label.assentamento.registros',
            'mapped' => false,
            'multiple' => true,
            'required' => false
        ];
        
        $assentamentoAssentamento = $entityManager->getRepository('CoreBundle:Pessoal\AssentamentoAssentamento')
        ->find($codAssentamento);
        
        $fkPessoalAssentamentoCausaRescisoes = $assentamentoAssentamento->getFkPessoalAssentamentos()
        ->last()->getFkPessoalAssentamentoCausaRescisoes();
        
        if (! $fkPessoalAssentamentoCausaRescisoes->isEmpty()) {
            $fieldOptions['causaRescisao']['data'] = (new Assentamento\AssentamentoAfastamentoTemporarioModel($entityManager))
            ->getCausaRecisaoPermanente($fkPessoalAssentamentoCausaRescisoes);
        }
        
        $formMapper
        ->with('label.assentamento.vinculoCausaRescisao')
        ->add('codAssentamento', 'hidden', $fieldOptions['codAssentamento'])
        ->add('causaRescisao', 'entity', $fieldOptions['causaRescisao'])
        ->end()
        ;
    }

    /**
    * Build a assentamentoCausaRescisao Object
    *
    * @param Pessoal\CausaRescisao $rescisao
    * @return Pessoal\AssentamentoCausaRescisao $assentamentoCausaRescisao
    */
    final private function buildAssentamentoCausaRescisao(Pessoal\CausaRescisao $causaRescisao)
    {
        $assentamentoCausaRescisao = new Pessoal\AssentamentoCausaRescisao();
        $assentamentoCausaRescisao->setCodCausaRescisao($causaRescisao);

        return $assentamentoCausaRescisao;
    }

    /**
     * @param  assentamentoAfastamentoTemporario $object
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
        
        $fkPessoalAssentamentoCausaRescisoes = $fkPessoalAssentamento
        ->getFkPessoalAssentamentoCausaRescisoes();

        if (! $fkPessoalAssentamentoCausaRescisoes->isEmpty()) {
            $fkPessoalAssentamento = (new Assentamento\AssentamentoAssentamentoModel($entityManager))
            ->cloneAssentamento($fkPessoalAssentamento);
        }
        
        $object->setFkPessoalAssentamento($fkPessoalAssentamento);
    }
    
    /**
     * @param  assentamentoAfastamentoTemporario $object
     */
    public function postPersist($object)
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
        
        (new Assentamento\AssentamentoAfastamentoTemporarioModel($entityManager))
        ->create($object, $this->getForm(), $fkPessoalAssentamento);
        
        (new RedirectResponse('/recursos-humanos/pessoal/assentamento/configuracao/' . $this->getForm()->get('codAssentamento')->getData() .'/show'))->send();
    }
    
    /**
     * @param  assentamentoAfastamentoTemporario $object
     */
    public function preUpdate($object)
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
        
        $fkPessoalAssentamentoCausaRescisoes = $fkPessoalAssentamento
        ->getFkPessoalAssentamentoCausaRescisoes();

        if (! $fkPessoalAssentamentoCausaRescisoes->isEmpty()) {
            $fkPessoalAssentamento = (new Assentamento\AssentamentoAssentamentoModel($entityManager))
            ->cloneAssentamento($fkPessoalAssentamento);
        }
        
        $object->setFkPessoalAssentamento($fkPessoalAssentamento);
    }
    
    /**
     * @param  assentamentoAfastamentoTemporario $object
     */
    public function postUpdate($object)
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
        
        (new Assentamento\AssentamentoAfastamentoTemporarioModel($entityManager))
        ->create($object, $this->getForm(), $fkPessoalAssentamento);
        
        (new RedirectResponse('/recursos-humanos/pessoal/assentamento/configuracao/' . $this->getForm()->get('codAssentamento')->getData() .'/show'))->send();
    }
}
