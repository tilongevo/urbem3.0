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

class IdentificadorUsoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_identificador_uso';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/destinacao-recursos/identificador-uso';

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

            $identificadorUso = $em->getRepository('CoreBundle:Orcamento\IdentificadorUso')
                ->findOneBy([
                    'codUso' => $object->getCodUso(),
                    'exercicio' => $exercicio
                ]);

            if ($identificadorUso) {
                $error = "IDUSO " . $object->getCodUso() . " em uso!";
                $errorElement->with('codUso')->addViolation($error)->end();
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
            $identificadorUso = new Entity\Orcamento\IdentificadorUso();
            $identificadorUso->setExercicio($ano);
            $identificadorUso->setCodUso($object->getCodUso());
            $identificadorUso->setDescricao($object->getDescricao());
            $em->persist($identificadorUso);
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
                $identificadorUso = $em->getRepository('CoreBundle:Orcamento\IdentificadorUso')
                    ->findOneBy([
                        'codUso' => $object->getCodUso(),
                        'exercicio' => $ano
                    ]);
                if ($identificadorUso) {
                    $identificadorUso->setDescricao($object->getDescricao());
                    $em->persist($identificadorUso);
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
                $identificadorUso = $em->getRepository('CoreBundle:Orcamento\IdentificadorUso')
                    ->findOneBy([
                        'codUso' => $object->getCodUso(),
                        'exercicio' => $ano
                    ]);
                if ($identificadorUso) {
                    $em->remove($identificadorUso);
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
            ->add('codUso', null, ['label' => 'label.identificadorUso.codUso'])
            ->add('descricao', null, ['label' => 'label.descricao'])
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
            ->add('codUso', null, ['label' => 'label.identificadorUso.codUso'])
            ->add('descricao', null, ['label' => 'label.descricao'])
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

        $fieldOptions['codUso'] = [
            'label' => 'label.identificadorUso.codUso',
            'attr' => ['min' => "1", 'max' => "9", 'maxlength' => "1"]
        ];

        if ($this->id($this->getSubject())) {
            $identificadorUso = $this->getSubject();

            $fieldOptions['codUso']['mapped'] = false;
            $fieldOptions['codUso']['disabled'] = true;
            $fieldOptions['codUso']['data'] = $identificadorUso->getCodUso();
        }

        $formMapper
            ->with('label.identificadorUso.dadosIdentificadorUso')
            ->add('codUso', null, $fieldOptions['codUso'])
            ->add('descricao', null, ['label' => 'label.descricao'])
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
            ->with('label.identificadorUso.modulo')
            ->add('codUso', null, ['label' => 'label.identificadorUso.codUso'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->end()
        ;
    }
}
