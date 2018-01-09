<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;

class EspecificacaoDestinacaoRecursoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_especificacao_destinacao_recurso';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/destinacao-recursos/especificacao-destinacao-recurso';

    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();
        $qb = parent::createQuery($context);
        $qb->where('o.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);
        return $qb;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        if (! $object->getExercicio()) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $exercicio = $this->getExercicio();

            $especificacaoDestinacaoRecurso = $em->getRepository('CoreBundle:Orcamento\EspecificacaoDestinacaoRecurso')
                ->findOneBy([
                    'codEspecificacao' => $object->getCodEspecificacao(),
                    'exercicio' => $exercicio
                ]);

            if ($especificacaoDestinacaoRecurso) {
                $error = "IDUSO " . $object->getCodEspecificacao() . " em uso!";
                $errorElement->with('codEspecificacao')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
            }
        }
    }

    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $this->getExercicio();
        $object->setExercicio($exercicio);

        $orgaoModel = new Model\Orcamento\OrgaoModel($em);
        $ppa = $orgaoModel->getPpaByExercicio($exercicio);
        $anoFinal = $ppa->getAnoFinal();
        for ($ano = (int)$exercicio + 1; $ano <= (int)$anoFinal; $ano++) {
            $especificacaoDestinacaoRecurso = new Entity\Orcamento\EspecificacaoDestinacaoRecurso();
            $especificacaoDestinacaoRecurso->setExercicio($ano);
            $especificacaoDestinacaoRecurso->setCodEspecificacao($object->getCodEspecificacao());
            $especificacaoDestinacaoRecurso->setDescricao($object->getDescricao());
            $especificacaoDestinacaoRecurso->setCodFonte($object->getCodFonte());
            $em->persist($especificacaoDestinacaoRecurso);
        }
        $em->flush();
    }

    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $object->getExercicio();

        $orgaoModel = new Model\Orcamento\OrgaoModel($em);
        $ppa = $orgaoModel->getPpaByExercicio($exercicio);
        $anoInicio = $ppa->getAnoInicio();
        $anoFinal = $ppa->getAnoFinal();
        for ($ano = (int)$anoInicio; $ano <= (int)$anoFinal; $ano++) {
            if ($ano != $exercicio) {
                $especificacaoDestinacaoRecurso = $em->getRepository('CoreBundle:Orcamento\EspecificacaoDestinacaoRecurso')
                    ->findOneBy([
                        'codEspecificacao' => $object->getCodEspecificacao(),
                        'exercicio' => $ano
                    ]);
                if ($especificacaoDestinacaoRecurso) {
                    $especificacaoDestinacaoRecurso->setDescricao($object->getDescricao());
                    $especificacaoDestinacaoRecurso->setCodFonte($object->getCodFonte());
                    $em->persist($especificacaoDestinacaoRecurso);
                }
            }
        }
        $em->flush();
    }

    public function preRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $object->getExercicio();

        $orgaoModel = new Model\Orcamento\OrgaoModel($em);
        $ppa = $orgaoModel->getPpaByExercicio($exercicio);
        $anoInicio = $ppa->getAnoInicio();
        $anoFinal = $ppa->getAnoFinal();
        for ($ano = (int)$anoInicio; $ano <= (int)$anoFinal; $ano++) {
            if ($ano != $exercicio) {
                $especificacaoDestinacaoRecurso = $em->getRepository('CoreBundle:Orcamento\EspecificacaoDestinacaoRecurso')
                    ->findOneBy([
                        'codEspecificacao' => $object->getCodEspecificacao(),
                        'exercicio' => $ano
                    ]);
                if ($especificacaoDestinacaoRecurso) {
                    $em->remove($especificacaoDestinacaoRecurso);
                }
            }
        }
        $em->flush();
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codEspecificacao', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add('codFonte', null, ['label' => 'label.especificacaoDestinacaoRecurso.codFonte'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $identificadorUsoModel = new Model\Orcamento\IdentificadorUsoModel($em);
        $identificadorUsoModel->verificarCRUD($this, 8, 'recurso_destinacao');

        $this->setBreadCrumb();

        $listMapper
            ->add('codEspecificacao', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.especificacaoDestinacaoRecurso.descricao'])
            ->add('codFonte', null, ['label' => 'label.especificacaoDestinacaoRecurso.codFonte'])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $identificadorUsoModel = new Model\Orcamento\IdentificadorUsoModel($em);
        $identificadorUsoModel->verificarCRUD($this, 8, 'recurso_destinacao');

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['codEspecificacao'] = [
            'label' => 'label.codigo',
            'attr' => ['min' => "1", 'max' => "99", 'maxlength' => "2"]
        ];

        if ($this->id($this->getSubject())) {
            $especificacaoDestinacaoRecurso = $this->getSubject();

            $fieldOptions['codEspecificacao']['mapped'] = false;
            $fieldOptions['codEspecificacao']['disabled'] = true;
            $fieldOptions['codEspecificacao']['data'] = $especificacaoDestinacaoRecurso->getCodEspecificacao();
        }

        $formMapper
            ->with('label.especificacaoDestinacaoRecurso.dados')
            ->add('codEspecificacao', null, $fieldOptions['codEspecificacao'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add('codFonte', null, [
                'label' => 'label.especificacaoDestinacaoRecurso.codFonte',
                'attr' => ['class' => 'select2-parameters']
            ])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        
        $showMapper
            ->with('label.especificacaoDestinacaoRecurso.modulo')
            ->add('codEspecificacao', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add('codFonte', null, ['label' => 'label.especificacaoDestinacaoRecurso.codFonte'])
            ->end()
        ;
    }
}
