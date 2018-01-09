<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Model;

class OrgaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_orgao';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/orgao-orcamentario';
    protected $model = Model\Orcamento\OrgaoModel::class;
    protected $includeJs = array(
        '/financeiro/javascripts/validate/input-number-validate.js'
    );
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'numOrgao'
    );

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('edit');
        $collection->remove('show');
    }

    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $exercicio);
        return $query;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $this->getRequest()->getSession()->getFlashBag()->clear();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $exercicio = $this->getExercicio();

        $orgaoModel = new Model\Orcamento\OrgaoModel($em);
        $orgaos = $orgaoModel->getOrgaosByNumOrgao($this->getForm()->get('numOrgao')->getData());
        $ppa = $orgaoModel->getPpaByExercicio($exercicio);

        if (count($orgaos)) {
            $mensagem = $this->getTranslator()->trans('label.orgaoOrcamentario.erroOrgaoExistente');
            $errorElement->with('numOrgao')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }

        if (!$ppa) {
            $mensagem = $this->getTranslator()->trans('label.orgaoOrcamentario.erroPpaInexistente');
            $errorElement->with('numOrgao')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $mensagem);
        }
    }

    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $exercicio = $this->getExercicio();
        $object->setExercicio($exercicio);
        $object->setNumOrgao($this->getForm()->get('numOrgao')->getData());

        $swCgm = $em->getRepository(SwCgm::class)->find($this->getForm()->get('fkSwCgm')->getData());
        $object->setFkSwCgm($swCgm);
    }

    public function postPersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $orgaoModel = new Model\Orcamento\OrgaoModel($em);
        $ppa = $orgaoModel->getPpaByExercicio($object->getExercicio());

        $inicio = (int) $object->getExercicio() + 1;
        $fim = (int) $ppa->getAnoFinal();

        for ($i = $inicio; $i <= $fim; $i++) {
            $new = new Orgao();
            $new->setNumOrgao($object->getNumOrgao());
            $new->setExercicio((string) $i);
            $new->setNomOrgao($object->getNomOrgao());
            $new->setFkSwCgm($object->getFkSwCgm());
            $em->persist($new);
            $em->flush();
        }
    }

    /**
     * @param mixed $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function preRemove($object)
    {
        $entityManager = $this->modelManager->getEntityManager(Unidade::class);
        $unidades = $entityManager->getRepository(Unidade::class)
            ->findByNumOrgao($object->getNumOrgao());

        $isRemoveSuccess = true;
        if (count($unidades) > 0) {
            $isRemoveSuccess = false;
        }

        $container = $this->getConfigurationPool()->getContainer();
        if (!$isRemoveSuccess) {
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }

    public function postRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $orgaoModel = new Model\Orcamento\OrgaoModel($em);
        $ppa = $orgaoModel->getPpaByExercicio($object->getExercicio());

        $inicio = (int) $ppa->getAnoInicio();
        $fim = (int) $ppa->getAnoFinal();

        $orgaoRepository = $em->getRepository('CoreBundle:Orcamento\Orgao');

        for ($i = $inicio; $i <= $fim; $i++) {
            if ($orgao = $orgaoRepository->findOneBy([ 'numOrgao' => $object->getNumOrgao(), 'exercicio' => (string) $i])) {
                $em->remove($orgao);
                $em->flush();
            }
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDatagrid()->getPager();
        $pager->setCountColumn(array('numOrgao'));

        $datagridMapper
            ->add('numOrgao', null, ['label' => 'label.orgaoOrcamentario.numOrgao'])
            ->add('nomOrgao', null, ['label' => 'label.orgaoOrcamentario.nomOrgao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('numOrgao', null, ['label' => 'label.orgaoOrcamentario.numOrgao'])
            ->add('nomOrgao', null, ['label' => 'label.orgaoOrcamentario.nomOrgao'])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $em = $this->modelManager->getEntityManager($this->getClass());
        $orgaoModel = new Model\Orcamento\OrgaoModel($em);
        $value = $orgaoModel->getCurrentNumber();

        $formMapper
            ->with('label.orgaoOrcamentario.dadosOrgao')
                ->add('numOrgao', null, [
                    'label' => 'label.orgaoOrcamentario.numOrgao',
                    'mapped' => false,
                    'attr' => ['min' => 1, 'max' => 99,
                        'class' => 'validateNumber '
                    ],
                    'data' => $value
                ])
                ->add('nomOrgao', null, [
                    'label' => 'label.orgaoOrcamentario.nomOrgao',
                ])
                ->add('fkSwCgm', 'autocomplete', [
                    'label' => 'label.unidadeOrcamentaria.responsavel',
                    'mapped' => false,
                    'required' => true,
                    'route' => ['name' => 'urbem_financeiro_tesouraria_conciliacao_autocomplete_sw_cgm_pessoa_fisica']
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
            ->add('numOrgao', null, ['label' => 'label.orgaoOrcamentario.numOrgao'])
            ->add('nomOrgao', null, ['label' => 'label.orgaoOrcamentario.nomOrgao'])
        ;
    }
}
