<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Contabilidade\DesdobramentoReceita;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\Receita;
use Urbem\CoreBundle\Entity\Orcamento\Recurso;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class DesdobramentoReceitaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_configuracao_desdobramento_receita';
    protected $baseRoutePattern = 'financeiro/contabilidade/configuracao/desdobramento-receita';
    protected $customHeader = null;
    protected $includeJs = [
        '/financeiro/javascripts/contabilidade/configuracao/desdobramento_receita.js'
    ];
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $this->getExercicio());
        if (!$this->getPersistentParameter('codReceita')) {
            $query->andWhere('1 = 0');
        } else {
            $query->andWhere('o.codReceitaPrincipal = :codReceitaPrincipal');
            $query->setParameter('codReceitaPrincipal', $this->getPersistentParameter('codReceita'));
        }
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDatagrid()->getPager();
        $pager->setCountColumn(array('codReceitaPrincipal'));
    }

    /**
     * @return null|string
     */
    public function getCodReceita()
    {
        if ($this->getPersistentParameter('codReceita')) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $receita = $em->getRepository(Receita::class)
                ->findOneBy(
                    array(
                        'exercicio' => $this->getExercicio(),
                        'codReceita' => $this->getRequest()->get('codReceita')
                    )
                );
            return (string) $receita;
        } else {
            return null;
        }
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'codReceita' => $this->getRequest()->get('codReceita'),
        );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->customHeader = 'FinanceiroBundle:Sonata\Contabilidade\Configuracao\DesdobramentoReceita\CRUD:header.html.twig';

        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codReceitaPrincipal',
                null,
                [
                    'label' => 'label.codigo'
                ]
            )
            ->add(
                'fkOrcamentoReceita.fkOrcamentoContaReceita.codEstrutural',
                null,
                [
                    'admin_code' => 'financeiro.admin.conta_receita',
                    'label' => 'label.receitaPrincipal',
                ]
            )
            ->add(
                'fkOrcamentoReceita.fkOrcamentoContaReceita.descricao',
                null,
                [
                    'admin_code' => 'financeiro.admin.conta_receita',
                    'label' => 'label.nome'
                ]
            )
            ->add(
                'fkOrcamentoReceita.codRecurso',
                null,
                [
                    'label' => 'label.recurso.codRecurso'
                ]
            )
            ->add(
                'fkOrcamentoReceita.fkOrcamentoRecurso.nomRecurso',
                null,
                [
                    'label' => 'label.recurso.nomRecurso'
                ]
            )
            ->add(
                'percentual'
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig')
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager('CoreBundle:Orcamento\Receita');

        $info = null;
        $receita = null;
        $receitasSecundarias = null;
        if ($this->getPersistentParameter('codReceita')) {
            $receitaList = $em->getRepository('CoreBundle:Orcamento\Receita')
                ->getReceitaByExercicioAndCodReceita($this->getExercicio(), $this->getPersistentParameter('codReceita'));
            $info = array_shift($receitaList);
            $receita = ArrayHelper::parseArrayToChoice($receitaList, 'mascara_classificacao', 'cod_receita');
            $receitaListSecundarias = $em->getRepository('CoreBundle:Orcamento\Receita')
                ->getReceitasByExercicio($this->getExercicio());
            $receitasSecundarias = ArrayHelper::parseArrayToChoice($receitaListSecundarias, 'mascara_classificacao', 'cod_receita');
        }

        $fieldOptions = [];
        $fieldOptions['codReceitaPrincipal'] = [
            'label' => 'label.receitaPrincipal',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'disabled' => false,
            'choices' => $receita
        ];

        $fieldOptions['codReceitaSecundaria'] = array(
            'label' => 'label.receitaSecundaria',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione',
            'choices' => $receitasSecundarias
        );

        $fieldOptions['entidade'] = [
            'class' => Entidade::class,
            'choice_label' => function (Entidade $entidade) {
                return $entidade->getCodEntidade() . ' - ' . $entidade->getFkSwCgm()->getNomCgm();
            },
            'label' => 'label.bem.entidade',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'disabled' => true,
            'query_builder' => function ($em) use ($info) {
                $qb = $em->createQueryBuilder('entidade');
                $qb->where('entidade.exercicio = :exercicio');
                $qb->setParameter('exercicio', $this->getExercicio());
                $qb->andWhere('entidade.codEntidade = :codEntidade');
                $qb->setParameter('codEntidade', $info['cod_entidade']);
                return $qb;
            }
        ];

        $fieldOptions['recurso'] = [
            'class' => Recurso::class,
            'choice_label' => function (Recurso $recurso) {
                return $recurso->getCodRecurso() . ' - ' . $recurso->getNomRecurso();
            },
            'label' => 'Recurso',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'disabled' => true,
            'query_builder' => function ($em) use ($info) {
                $qb = $em->createQueryBuilder('rec');
                $qb->where('rec.exercicio = :exercicio');
                $qb->setParameter('exercicio', $this->getExercicio());
                $qb->andWhere('rec.codRecurso = :codRecurso');
                $qb->setParameter('codRecurso', $info['cod_recurso']);
                return $qb;
            }
        ];

        $formMapper
            ->with('label.receita')
            ->add(
                'exercicio',
                'hidden',
                [
                    'data' => $this->getExercicio()
                ]
            )
            ->add(
                'entidade',
                'entity',
                $fieldOptions['entidade']
            )
            ->add(
                'codReceitaPrincipal',
                'choice',
                $fieldOptions['codReceitaPrincipal']
            )
            ->add(
                'recurso',
                'entity',
                $fieldOptions['recurso']
            )
            ->add(
                'percentualText',
                'text',
                [
                    'mapped' => false,
                    'disabled' => true,
                    'label' => 'label.percentual',
                    'data' => $info['percentual']
                ]
            )
            ->end()
            ->add(
                'codReceitaSecundaria',
                'choice',
                $fieldOptions['codReceitaSecundaria']
            )
            ->add(
                'percentual',
                'percent',
                [
                    'label' => 'label.percentual'
                ]
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('exercicio', null, ['label' => 'label.exercicio'])
            ->add('fkOrcamentoReceita1.fkOrcamentoContaReceita.codEstrutural', null, ['label' => 'label.receitaPrincipal'])
            ->add('fkOrcamentoReceita.fkOrcamentoContaReceita.codEstrutural', null, ['label' => 'label.receitaSecundaria'])
            ->add('percentual');
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());

        $em = $this->modelManager->getEntityManager($this->getClass());

        $object->setExercicio($this->getExercicio());

        $object->setPercentual($formData['percentual']);

        $receita = $em->getRepository('CoreBundle:Orcamento\\Receita')
            ->findOneBy([
                'exercicio' => $this->getExercicio(),
                'codReceita' => $formData['codReceitaPrincipal']
            ]);

        $object->setFkOrcamentoReceita1($receita);

        $receita = $em->getRepository('CoreBundle:Orcamento\\Receita')
            ->findOneBy([
                'exercicio' => $this->getExercicio(),
                'codReceita' => $formData['codReceitaSecundaria']
            ]);

        $object->setFkOrcamentoReceita($receita);
    }

    /**
     * @param $object
     */
    public function preValidate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        if ($object->getCodReceitaPrincipal() == $object->getCodReceitaSecundaria()) {
            $mensagem = $this->getTranslator()->trans('label.recurso.validate.receitaPrincipalDif');
            $this->redirect($mensagem);
        }

        $desdobramentoReceita = $em->getRepository('CoreBundle:Contabilidade\DesdobramentoReceita')
            ->findBy([
                'exercicio' => $object->getExercicio(),
                'codReceitaPrincipal' => $object->getCodReceitaPrincipal(),
                'codReceitaSecundaria' => $object->getCodReceitaSecundaria()
            ]);

        if (count($desdobramentoReceita)) {
            $mensagem = $this->getTranslator()->trans('label.recurso.validate.receitaPrincipalDif');
            $this->redirect($mensagem);
        }

        $receita = $em->getRepository('CoreBundle:Orcamento\\Receita')
            ->findOneBy([
                'exercicio' => $this->getExercicio(),
                'codReceita' => $object->getCodReceitaPrincipal()
            ]);

        if (!$receita) {
            $mensagem = $this->getTranslator()->trans('label.recurso.validate.erroReceitaPrincipal');
            $this->redirect($mensagem);
        }

        $receita = $em->getRepository('CoreBundle:Orcamento\\Receita')
            ->findOneBy([
                'exercicio' => $this->getExercicio(),
                'codReceita' => $object->getCodReceitaSecundaria()
            ]);

        if (!$receita) {
            $mensagem = $this->getTranslator()->trans('label.recurso.validate.erroReceitaSecundaria');
            $this->redirect($mensagem);
        }
    }

    /**
     * @param $mensagem
     */
    protected function redirect($mensagem)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add('error', $mensagem);
        (new RedirectResponse($this->request->headers->get('referer')))->send();
    }

    /**
     * @param mixed $object
     * @return int|string
     */
    public function toString($object)
    {
        return $object instanceof DesdobramentoReceita
            ? $object->getCodReceitaPrincipal()
            : 'Desdobramento da Receita';
    }
}
