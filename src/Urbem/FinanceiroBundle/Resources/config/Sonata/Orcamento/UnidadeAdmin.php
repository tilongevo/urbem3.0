<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Model;

class UnidadeAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_unidade';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/unidade-orcamentaria';
    protected $model = Model\Orcamento\UnidadeModel::class;
    protected $customHeader = null;
    protected $includeJs = array(
        '/financeiro/javascripts/validate/input-number-validate.js',
        '/financeiro/javascripts/ppa/unidadeSw.js'
    );

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'numOrgao' => $this->getRequest()->get('numOrgao'),
        );
    }

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'FinanceiroBundle:Orcamento\Unidade:list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @return null|string
     */
    public function getNomOrgao()
    {
        if ($this->getPersistentParameter('numOrgao')) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $orgao = $em->getRepository(Orgao::class)
                ->findOneBy(
                    array(
                        'exercicio' => $this->getExercicio(),
                        'numOrgao' => $this->getRequest()->get('numOrgao')
                    )
                );
            return (string) $orgao;
        } else {
            return null;
        }
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $this->getExercicio());
        if (!$this->getPersistentParameter('numOrgao')) {
            $query->andWhere('1 = 0');
        } else {
            $query->andWhere('o.numOrgao = :numOrgao');
            $query->setParameter('numOrgao', $this->getPersistentParameter('numOrgao'));
        }
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDatagrid()->getPager();
        $pager->setCountColumn(array('numUnidade'));
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->customHeader = 'FinanceiroBundle:Sonata\Orcamento\Unidade\CRUD:header.html.twig';

        $this->setBreadCrumb();

        $listMapper
            ->add('getCodigoComposto', null, ['label' => 'label.unidadeOrcamentaria.numero'])
            ->add('nomUnidade', null, ['label' => 'label.unidadeOrcamentaria.nomUnidade'])
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
        $lastUnidade = $em->getRepository(Unidade::class)
            ->findOneBy(
                array(
                    'exercicio' => $this->getExercicio(),
                    'numOrgao' => $this->getPersistentParameter('numOrgao')
                ),
                array(
                    'numUnidade' => 'DESC'
                )
            );

        $fieldOptions = [];

        $fieldOptions['numUnidade'] = [
            'label' => 'label.unidadeOrcamentaria.numUnidade',
            'attr' => ['min' => 1, 'max' => 99,
                'class' => 'validateNumber '
            ],
            'data' => ($lastUnidade) ? $lastUnidade->getNumUnidade() + 1 : 1,
            'mapped' => false,
        ];

        $fieldOptions['fkSwCgm'] = [
            'label' => 'label.unidadeOrcamentaria.responsavel',
            'mapped' => false,
            'required' => true,
            'route' => ['name' => 'urbem_financeiro_tesouraria_conciliacao_autocomplete_sw_cgm_pessoa_fisica']
        ];

        if ($this->id($this->getSubject())) {
            $unidade = $this->getSubject();

            $fieldOptions['numUnidade']['disabled'] = true;
            $fieldOptions['numUnidade']['data'] = $unidade->getNumUnidade();

            $fieldOptions['fkOrcamentoOrgao']['disabled'] = true;
            $fieldOptions['fkOrcamentoOrgao']['data'] = $unidade->getFkOrcamentoOrgao();

            $fieldOptions['fkSwCgm']['data'] = $unidade->getFkSwCgm();
        }

        $formMapper
            ->with($this->getNomOrgao())
                ->add('numUnidade', null, $fieldOptions['numUnidade'])
                ->add('nomUnidade', null, ['label' => 'label.unidadeOrcamentaria.nomUnidade'])
                ->add('fkSwCgm', 'autocomplete', $fieldOptions['fkSwCgm'])
            ->end()
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $unidadeModel = new Model\Orcamento\UnidadeModel($em);
        $unidades = $unidadeModel->getUnidadesByNumUnidadeNumOrgao(
            $this->getForm()->get('numUnidade')->getData(),
            $this->getPersistentParameter('numOrgao'),
            $this->getExercicio()
        );

        if ((count($unidades)) && (!$this->adminRequestId)) {
            $mensagem = $this->getTranslator()->trans('label.unidadeOrcamentaria.erroUnidadeExistente');
            $errorElement->with('numUnidade')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->with('label.unidadeOrcamentaria.modulo')
                ->add('getCodigoComposto', 'text', ['label' => 'label.unidadeOrcamentaria.numUnidade'])
                ->add('nomUnidade', 'text', ['label' => 'label.unidadeOrcamentaria.nomUnidade'])
                ->add('fkSwCgm', 'text', ['label' => 'label.unidadeOrcamentaria.responsavel'])
                ->add('fkOrcamentoOrgao.nomOrgao', 'text', ['label' => 'label.unidadeOrcamentaria.numOrgao'])
            ->end()
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $object->setNumUnidade($this->getForm()->get('numUnidade')->getData());

        $orgao = $em->getRepository(Orgao::class)
            ->findOneBy(
                array(
                    'exercicio' => $this->getExercicio(),
                    'numOrgao' => $this->getPersistentParameter('numOrgao')
                )
            );
        $object->setFkOrcamentoOrgao($orgao);

        $swCgm = $em->getRepository(SwCgm::class)->find($this->getForm()->get('fkSwCgm')->getData());
        $object->setFkSwCgm($swCgm);
    }

    /**
     * @param mixed $object
     */
    public function postPersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $orgaoModel = new Model\Orcamento\OrgaoModel($em);
        $ppa = $orgaoModel->getPpaByExercicio($object->getExercicio());

        $inicio = (int) $object->getExercicio() + 1;
        $fim = (int) $ppa->getAnoFinal();

        $orgaoRepository = $em->getRepository(Orgao::class);

        for ($i = $inicio; $i <= $fim; $i++) {
            if ($orgao = $orgaoRepository->findOneBy([ 'numOrgao' => $object->getFkOrcamentoOrgao()->getNumOrgao(), 'exercicio' => (string) $i])) {
                $new = new Unidade();
                $new->setNumUnidade($object->getNumUnidade());
                $new->setNomUnidade($object->getNomUnidade());
                $new->setFkOrcamentoOrgao($orgao);
                $new->setFkSwCgm($object->getFkSwCgm());

                $em->persist($new);
                $em->flush();
            }
        }
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $unidadeModel = new Model\Orcamento\UnidadeModel($em);
        $unidades = $unidadeModel->getUnidadesByNumUnidadeNumOrgao(
            $object->getNumUnidade(),
            $object->getFkOrcamentoOrgao()->getNumOrgao(),
            $object->getExercicio()
        );

        foreach ($unidades as $unidade) {
            if ($unidade->getExercicio() != $object->getExercicio()) {
                $unidade->setNomUnidade($object->getNomUnidade());
                $unidade->setFkSwCgm($object->getFkSwCgm());
                $em->persist($unidade);
                $em->flush();
            }
        }
    }

    /**
     * @param mixed $object
     */
    public function preRemove($object)
    {
        if (!$object->getFkOrcamentoDespesas()->isEmpty()) {
            $this->getConfigurationPool()->getContainer()->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);

            $this->getDoctrine()->clear();
            $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }

    /**
     * @param mixed $object
     */
    public function postRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $unidadeModel = new Model\Orcamento\UnidadeModel($em);
        $unidades = $unidadeModel->getUnidadesByNumUnidadeNumOrgao(
            $object->getNumUnidade(),
            $object->getFkOrcamentoOrgao()->getNumOrgao(),
            $object->getExercicio()
        );

        foreach ($unidades as $unidade) {
            if ($unidade->getExercicio() != $object->getExercicio()) {
                $em->remove($unidade);
                $em->flush();
            }
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getNumUnidade())
            ? (string) $object
            : $this->getTranslator()->trans('label.unidadeOrcamentaria.modulo');
    }
}
