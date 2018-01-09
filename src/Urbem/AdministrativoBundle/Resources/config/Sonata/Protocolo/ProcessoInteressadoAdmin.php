<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\SwProcessoInteressado;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ProcessoInteressadoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_protocolo_processo_interessado';
    protected $baseRoutePattern = 'administrativo/protocolo/processo-interessado';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('anoExercicio')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('anoExercicio')
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? array('id' => $id) : array());

        $codProcesso = null;
        $anoExercicio = null;
        if (!empty($id)) {
            list($codProcesso, $anoExercicio) = explode('~', $id);
        }

        $fieldOptions['fkSwCgm'] = [
            'attr'                 => ['class' => 'select2-parameters '],
            'class'                => SwCgm::class,
            'label'                => 'label.cgm',
            'json_from_admin_code' => $this->code,
            'json_query_builder'   =>
                function (EntityRepository $repository, $term, Request $request) use ($entityManager) {
                    $swCgmQueryBuilder = (new SwCgmModel($entityManager))->findLikeQuery(['nomCgm'], $term);

                    return $swCgmQueryBuilder;
                },
            'placeholder'          => $this->trans('label.selecione'),
            'required'             => true,

        ];

        $formMapper
            ->add('fkSwCgm', 'autocomplete', $fieldOptions['fkSwCgm'], [
                'admin_code' => 'core.admin.filter.sw_cgm'
            ])
        ;

        $formMapper
            ->add('anoExercicio', 'hidden', ['data' => $anoExercicio])
            ->add('codProcesso', 'hidden', ['data' => $codProcesso])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('anoExercicio')
        ;
    }

    public function preUpdate($object)
    {
        $entityManager = $this->modelManager->getEntityManager('CoreBundle:SwProcessoInteressado');
        $processo = $entityManager->getRepository('CoreBundle:SwProcesso')->find($object->getCodProcesso());

        $object->setCodProcesso($processo);
        $object->setAnoExercicio($processo->getAnoExercicio());
    }

    public function redirect(SwProcessoInteressado $processo)
    {
        $codProcesso = $processo->getCodProcesso();
        $anoExercicio = $processo->getAnoExercicio();

        $this->forceRedirect("/administrativo/protocolo/processo/perfil?id={$codProcesso}~{$anoExercicio}");
    }

    public function prePersist($object)
    {
        $processo = $this->getDoctrine()->getRepository(SwProcesso::class)->findOneBy(['codProcesso' => $object->getCodProcesso(), 'anoExercicio' => $object->getAnoExercicio()]);
        $object->setFkSwProcesso($processo);
    }

    public function postPersist($object)
    {
        $this->redirect($object);
    }

    public function postUpdate($object)
    {
        $this->redirect($object);
    }

    public function postRemove($object)
    {
        $this->redirect($object);
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $entityManager = $this->modelManager->getEntityManager('CoreBundle:SwProcessoInteressado');
        $swProcessoInteressado = $entityManager->getRepository('CoreBundle:SwProcessoInteressado')
            ->findOneBy([
                'codProcesso' => $object->getCodProcesso(),
                'numcgm' => $object->getNumCgm(),
            ]);

        if (is_null($swProcessoInteressado)) {
            return true;
        }

        $mensagem = "Interessado já cadastrado para este processo";
        $errorElement->with('numcgm')->addViolation($mensagem)->end();
        $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);

        return false;
    }
}
