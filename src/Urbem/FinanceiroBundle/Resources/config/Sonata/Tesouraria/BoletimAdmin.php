<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Tesouraria;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Tesouraria\Boletim;
use Urbem\CoreBundle\Entity\Tesouraria\SaldoTesouraria;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Model\Tesouraria\Boletim\BoletimModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class BoletimAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_tesouraria_abrir_boletim';
    protected $baseRoutePattern = 'financeiro/tesouraria/boletim/abrir-boletim';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Abrir boletim'];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('profile', '{codBoletim}/{codEntidade}/{exercicio}/profile', array('_controller' => 'FinanceiroBundle:Tesouraria/Boletim:profile'));
    }
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => "DESC",
        '_sort_by' => 'dtBoletim'
    ];
    public function validate(ErrorElement $errorElement, $object)
    {
        $repository = $this->getDoctrine()->getRepository(Boletim::class);
        $date = $object->getDtBoletim();
        $codEntidade = $this->getForm()->get('codEntidade')->getData();

        $configuracao = $this->getDoctrine()->getRepository(Configuracao::class);
        $stVirada = $configuracao->findOneBy(['parametro' => 'virada_GF', 'codModulo' => Modulo::MODULO_EMPENHO, 'exercicio' => $this->getExercicio()]);

        //Se Já foi efetuado o encerramento do exercício
        if (strtolower($stVirada->getValor()) == 't' or $stVirada->getValor() == 1) {
            $this->validateDtBoletim($errorElement, $this->getContainer()->get('translator')->transChoice('label.tesouraria.boletim.validacoes.exercicioEncerrado', 0, [], 'messages'));
        }

        //validar se a data esta dentro do exercicio
        if ($this->getExercicio() != $date->format('Y')) {
            $this->validateDtBoletim(
                $errorElement,
                $this->getContainer()->get('translator')->transChoice('label.tesouraria.boletim.validacoes.dataExercicioAtual', 0, [], 'messages').$this->getExercicio()
            );
        }

        //se existe um boletim para a data
        if ($repository->findOneBy(['dtBoletim' => $date, 'codEntidade' => $codEntidade, 'exercicio' => $this->getExercicio()])) {
            $this->validateDtBoletim(
                $errorElement,
                $this->getContainer()->get('translator')->transChoice('label.tesouraria.boletim.validacoes.dataDuplicada', 0, [], 'messages').' '.$date->format('d/m/Y')
            );
        }

        //A data do boletim deve ser posterior à do ultimo existente
        $last = $repository->findOneBy(['codEntidade' => $codEntidade, 'exercicio' => $this->getExercicio()], ['dtBoletim' => 'DESC','codBoletim' => 'DESC']);
        if (!empty($last)) {
            if ($date <= $last->getDtBoletim()) {
                $this->validateDtBoletim(
                    $errorElement,
                    $this->getContainer()->get('translator')->transChoice('label.tesouraria.boletim.validacoes.dataPosteriorUltima', 0, [], 'messages')
                );
            }
        }

        //a data tem que estar no intervalo entre a ultima e a data de hoje
        if ($date > new \DateTime()) {
            $this->validateDtBoletim(
                $errorElement,
                $this->getContainer()->get('translator')->transChoice('label.tesouraria.boletim.validacoes.dataFutura', 0, [], 'messages')
            );
        }

        //verifica se o usuario esta cadastrado no terminal
        $terminal = $this->getTerminal();
        if (empty($terminal)) {
            $this->validateDtBoletim(
                $errorElement,
                $this->getContainer()->get('translator')->transChoice('label.tesouraria.boletim.validacoes.terminalHabilidato', 0, [], 'messages')
            );
        }
    }

    public function prePersist($object)
    {
        $object->setCodEntidade($this->getForm()->get('codEntidade')->getData());
        $terminal = $this->getTerminal();

        $model = new BoletimModel($this->getDoctrine());
        try {
            $boletim = $model->dadosBoletim($object, $this->getExercicio(), $terminal, $this->getCurrentUser()->getId());
            $boletim = $model->aberturaBoletim($boletim);
            $model->save($boletim);
            $this->getRequest()->getSession()->getFlashBag()->add(
                "success",
                $this->getContainer()->get('translator')->transChoice('label.tesouraria.boletim.validacoes.boletimCreateSucesso', 0, [], 'messages')
            );
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        $this->redirectByRoute($this->baseRouteName . '_list');
    }

    /**
     * @param ErrorElement $errorElement
     * @param $error
     */
    public function validateDtBoletim(ErrorElement $errorElement, $error)
    {
        $errorElement->with('dtBoletim')->addViolation($error)->end();
        $this->getRequest()->getSession()->getFlashBag()->add("error", $error);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codBoletim', null, ['label' => 'label.tesouraria.boletim.codBoletim'])
            ->add('exercicio', null, ['label' => 'exercicio'])
            ->add(
                'dtBoletim',
                null,
                array(
                    'label' => 'label.tesouraria.boletim.dtBoletim',
                ),
                'sonata_type_date_picker',
                array(
                    'format' => 'dd/MM/yyyy',
                )
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codBoletim', null, ['label' => 'label.tesouraria.boletim.codBoletim'])
            ->add('exercicio', null, ['label' => 'exercicio'])
            ->add('dtBoletim', null, ['label' => 'label.tesouraria.boletim.dtBoletim'])
            ->add('status', 'string', ['template' => 'FinanceiroBundle:Tesouraria/Boletim:status.html.twig'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'FinanceiroBundle:Tesouraria/Boletim:list__action_profile.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $repository = $this->getDoctrine()->getRepository(SaldoTesouraria::class);
        $entidades =  ArrayHelper::parseArrayToChoice($repository->getEntidadesValidas($this->getCurrentUser()->getId(), $this->getExercicio()), 'nom_cgm', 'cod_entidade');

        $repository = $this->getDoctrine()->getRepository($this->getClass());
        $lastBoletim = $repository->findOneBy(['codEntidade' => $this->getEntidade()->getCodEntidade(), 'exercicio' => $this->getExercicio()], ['dtBoletim' => 'DESC','codBoletim' => 'DESC']);

        $formMapper
            ->add(
                'codEntidade',
                'choice',
                [
                    'required' => true,
                    'choices' => $entidades,
                    'label' => 'label.entidades',
                    'placeholder' => 'label.selecione',
                    'mapped' => false,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            );
        if (!empty($lastBoletim)) {
            $formMapper
                ->add(
                    'dtUltimoBoletim',
                    'text',
                    [
                        'mapped' => false,
                        'disabled' => true,
                        'label' => 'label.tesouraria.boletim.dataUltimoBoletim',
                        'data' => $lastBoletim->getDtBoletim()->format('d/m/Y')
                    ]
                )
                ->add(
                    'numeroBoletim',
                    'text',
                    [
                        'mapped' => false,
                        'disabled' => true,
                        'label' => 'label.tesouraria.boletim.numeroDoBoletim',
                        'data' => $lastBoletim->getCodBoletim() + 1
                    ]
                );
        }

        $formMapper
            ->add(
                'dtBoletim',
                'sonata_type_date_picker',
                [
                    'label' => 'label.tesouraria.boletim.dataBoletim',
                    'format' => 'dd/MM/yyyy'
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codBoletim')
            ->add('exercicio')
            ->add('codTerminal')
            ->add('timestampTerminal')
            ->add('cgmUsuario')
            ->add('timestampUsuario')
            ->add('dtBoletim')
        ;
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $entidade = $this->getEntidade();
        $qb = parent::createQuery($context);
        $qb->where('o.codEntidade = :codEntidade');
        $qb->setParameter('codEntidade', $entidade->getCodEntidade());
        return $qb;
    }

    /**
     * @return mixed
     */
    private function getTerminal()
    {
        $repository = $this->getDoctrine()->getRepository(Boletim::class);
        $params = [$this->getCurrentUser()->getId(), null];
        $terminal = $repository->findTerminalUsuario($params);
        return $terminal;
    }
}
