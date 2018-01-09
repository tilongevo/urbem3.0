<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class EmpenhoAssinaturaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_empenho_assinatura';
    protected $baseRoutePattern = 'financeiro/empenho/empenho-assinatura';
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('edit', 'create', 'delete', 'list'));
    }
    
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'empenho' => $this->getRequest()->get('empenho'),
            'codPreEmpenho' => $this->getRequest()->get('codPreEmpenho'),
            'exercicio'  => $this->getRequest()->get('exercicio'),
        );
    }
    
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);
        
        if ($this->id($this->getSubject())) {
            $empenho = $entityManager->getRepository('CoreBundle:Empenho\Empenho')
            ->findOneBy(
                array(
                    'codEmpenho' => $this->getSubject()->getCodEmpenho(),
                    'exercicio' => $this->getSubject()->getExercicio()
                )
            );
            
            if ($empenho) {
                $codEntidade = $empenho->getCodEntidade();
            } else {
                $codEntidade = $this->getSubject()->getCodEntidade();
            }
            
            $assinantesList = (new \Urbem\CoreBundle\Model\Empenho\EmpenhoAssinaturaModel($entityManager))
            ->getCgmAssinatura($this->getSubject()->getExercicio(), $codEntidade);
        } else {
            $empenho = $entityManager->getRepository('CoreBundle:Empenho\Empenho')
            ->findOneBy(
                array(
                    'codEmpenho' => $this->getRequest()->query->get('empenho'),
                    'exercicio' => $this->getRequest()->query->get('exercicio')
                )
            );
            
            if ($empenho) {
                $codEntidade = $empenho->getCodEntidade();
            } else {
                $codEntidade = $this->getForm()->get('codEntidade')->getData();
            }
            
            $assinantesList = (new \Urbem\CoreBundle\Model\Empenho\EmpenhoAssinaturaModel($entityManager))
            ->getCgmAssinatura($this->getRequest()->query->get('exercicio'), $codEntidade);
        }
        
        
        
        $formOptions = array();
        
        $formOptions['exercicio'] = array(
            'mapped' => false,
            'data' => $this->getRequest()->query->get('exercicio')
        );
        
        $formOptions['codEmpenho'] = array(
            'mapped' => false,
            'data' => $this->getRequest()->query->get('empenho')
        );
        $formOptions['codEntidade'] = array(
            'mapped' => false,
            'data' => $empenho->getCodEntidade()
        );
        
        $formOptions['numcgm'] = array(
            'label' => 'label.empenhoAssinatura.numcgm',
            'choices' => $assinantesList,
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'placeholder' => 'label.selecione',
        );
        
        if ($this->id($this->getSubject())) {
            $formOptions['exercicio']['data'] = $this->getSubject()->getExercicio();
            $formOptions['codEmpenho']['data'] = $this->getSubject()->getCodEmpenho();
            $formOptions['codEntidade']['data'] = $this->getSubject()->getCodEntidade();
        }
                
        $formMapper
            ->with('label.empenhoAssinatura.incluir')
                ->add(
                    'exercicio',
                    'hidden',
                    $formOptions['exercicio']
                )
                ->add(
                    'codEmpenho',
                    'hidden',
                    $formOptions['codEmpenho']
                )
                ->add(
                    'codEntidade',
                    'hidden',
                    $formOptions['codEntidade']
                )
                ->add(
                    'numcgm',
                    'choice',
                    $formOptions['numcgm']
                )
            ->end()
        ;
    }
    
    public function prePersist($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $numAssinatura = $entityManager->getRepository("CoreBundle:Empenho\EmpenhoAssinatura")
        ->getProximoNumAssinatura($this->getForm()->get('exercicio')->getData());
        
        $swCgm = $entityManager->getRepository("CoreBundle:SwCgm")
        ->findOneByNumcgm($this->getForm()->get('numcgm')->getData());
        
        $fkEmpenhoEmpenho = $entityManager->getRepository("CoreBundle:Empenho\Empenho")
        ->findOneBy(
            array(
                'codEmpenho' => $this->getForm()->get('codEmpenho')->getData(),
                'exercicio' => $this->getForm()->get('exercicio')->getData()
            )
        );
        
        $cargo = $entityManager->getRepository("CoreBundle:Empenho\EmpenhoAssinatura")
        ->getCgmAssinaturaPorCgm(
            $this->getForm()->get('exercicio')->getData(),
            $this->getForm()->get('codEntidade')->getData(),
            $this->getForm()->get('numcgm')->getData()
        );
        
        $object->setNumAssinatura($numAssinatura);
        $object->setCargo($cargo->cargo);
        $object->setFkEmpenhoEmpenho($fkEmpenhoEmpenho);
        $object->setFkSwCgm($swCgm);
    }
    
    public function postPersist($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $empenho = $entityManager->getRepository('CoreBundle:Empenho\Empenho')
        ->findOneBy(
            array(
                'codEmpenho' => $object->getCodEmpenho(),
                'exercicio' => $object->getExercicio()
            )
        );
        
        $codPreEmpenhoComposite = $object->getExercicio() . "~" . $empenho->getCodPreEmpenho();
        
        $this->forceRedirect('/financeiro/empenho/emitir-empenho-complementar/' . $codPreEmpenhoComposite . '/show');
        exit;
    }
    
    public function preUpdate($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        
        $swCgm = $entityManager->getRepository("CoreBundle:SwCgm")
        ->findOneByNumcgm($this->getForm()->get('numcgm')->getData());
        
        $fkEmpenhoEmpenho = $entityManager->getRepository("CoreBundle:Empenho\Empenho")
        ->findOneBy(
            array(
                'codEmpenho' => $this->getForm()->get('codEmpenho')->getData(),
                'exercicio' => $this->getForm()->get('exercicio')->getData()
            )
        );
        
        $cargo = $entityManager->getRepository("CoreBundle:Empenho\EmpenhoAssinatura")
        ->getCgmAssinaturaPorCgm(
            $this->getForm()->get('exercicio')->getData(),
            $this->getForm()->get('codEntidade')->getData(),
            $this->getForm()->get('numcgm')->getData()
        );
        
        $object->setCargo($cargo->cargo);
        $object->setFkEmpenhoEmpenho($fkEmpenhoEmpenho);
        $object->setFkSwCgm($swCgm);
    }
    
    public function postUpdate($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $empenho = $entityManager->getRepository('CoreBundle:Empenho\Empenho')
        ->findOneBy(
            array(
                'codEmpenho' => $object->getCodEmpenho(),
                'exercicio' => $object->getExercicio()
            )
        );
        
        $codPreEmpenhoComposite = $object->getExercicio() . "~" . $empenho->getCodPreEmpenho();
        
        $this->forceRedirect('/financeiro/empenho/emitir-empenho-complementar/' . $codPreEmpenhoComposite . '/show');
        exit;
    }
    
    public function postRemove($object)
    {
        $codPreEmpenhoComposite = $this->getRequest()->query->get('exercicio') . "~" . $this->getRequest()->query->get('codPreEmpenho');
        
        $this->forceRedirect('/financeiro/empenho/emitir-empenho-complementar/' . $codPreEmpenhoComposite . '/show');
        exit;
    }
    
    public function toString($object)
    {
        return $object->getNumAssinatura();
    }
}
