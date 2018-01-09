<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Orcamento\ClassificacaoReceita;
use Urbem\CoreBundle\Entity\Orcamento\ContaReceita;
use Urbem\CoreBundle\Entity\Orcamento\PosicaoReceita;
use Urbem\CoreBundle\Entity\Orcamento\TipoContaReceita;
use Urbem\CoreBundle\Helper\MascaraHelper;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ContaReceitaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_classificacao_economica_classificacao_receita';
    protected $baseRoutePattern = 'financeiro/orcamento/classificacao-economica/classificacao-receita';
    protected $grupo = [1, 2, 7, 8];
    protected $includeJs = array(
        '/financeiro/javascripts/orcamento/classificacaoeconomica/classificacao_receita.js',
    );
    const TIPO_RECEITA = 'Receita';
    const LIKE_COD_ESTRUTURAL = 9;
    const COD_MODULO_MASK = 8;
    const PARAMETRO_RECEITA = 'mascara_classificacao_receita';


    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $filter = $this->getRequest()->query->get('filter');

        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $this->getExercicio());

        if (!empty($filter['codEstrutural']['value'])) {
            $query->andWhere(
                $query->expr()->like('o.codEstrutural', ':codEstrutural')
            );
            $query->setParameter("codEstrutural", $filter['codEstrutural']['value'] . '%');
        }

        return $query;
    }
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDatagrid()->getPager();
        $pager->setCountColumn(array('codConta'));

        $datagridMapper
            ->add('codEstrutural', null, ['label' => 'label.codigo', 'sortable' => false])
            ->add('descricao', null, ['label' => 'label.descricao', 'sortable' => false]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codEstrutural', null, ['label' => 'label.codigo', 'sortable' => false])
            ->add('descricao', null, ['label' => 'label.descricao', 'sortable' => false]);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['codEstrutural'] = [
            'label' => 'label.codigo'
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['codEstrutural'] = [
                'label' => 'label.codigoEstrutural',
                'disabled' => true,
            ];
        }

        // Máscara de Classificação da Receita
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Orcamento\ContaReceita');
        $tipoContaReceita = $this->getTipoReceita();

        $posicaoReceitaRepository = $em->getRepository('CoreBundle:Orcamento\PosicaoReceita');
        $posicaoReceitas = $posicaoReceitaRepository->findBy(
            array('exercicio' => $this->getExercicio(), 'codTipo' => $tipoContaReceita),
            array('codPosicao' => 'ASC')
        );

        if (empty($posicaoReceitas)) {
            $configuracaoModel = new ConfiguracaoModel($this->getDoctrine());
            $parametrosReceita = [
                'cod_modulo' => self::COD_MODULO_MASK,
                'exercicio' => $this->getExercicio(),
                'parametro' => self::PARAMETRO_RECEITA
            ];
            $mascaraClassificacaoReceitaValor = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($parametrosReceita);
            $collection = new ArrayCollection();
            if (!empty($mascaraClassificacaoReceitaValor)) {
                $explode = explode('.', $mascaraClassificacaoReceitaValor['valor']);
                foreach ($explode as $value) {
                    $class = new PosicaoReceita();
                    $class->setMascara($value);
                    $collection->add($class);
                }
            }
            $posicaoReceitas = $collection;
        }
        $mascara = MascaraHelper::parseMascara($posicaoReceitas);

        $formMapper
            ->add(
                'id',
                'hidden',
                [
                    'data' => $id,
                    'mapped' => false
                ]
            )
            ->add(
                'mascara',
                'hidden',
                [
                    'data' => $mascara,
                    'mapped' => false
                ]
            )
            ->add(
                'codTipo',
                'hidden',
                [
                    'mapped' => false,
                    'data' => $tipoContaReceita->getCodTipo()
                ]
            )
            ->add(
                'codEstrutural',
                'text',
                $fieldOptions['codEstrutural']
            )
            ->add('descricao', 'text', ['label' => 'label.descricao'])
            ->add(
                'fkNormasNorma',
                'autocomplete',
                array(
                    'label' => 'label.baseLegal',
                    'class' => Norma::class,
                    'json_from_admin_code' => $this->code,
                    'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                        $qb = $repo->createQueryBuilder('n')
                            ->where('LOWER(n.nomNorma) LIKE :nomNorma')
                            ->andWhere('n.exercicio = :exercicio')
                            ->setParameter('nomNorma', "%" . strtolower($term) . "%")
                            ->setParameter('exercicio', $this->getExercicio())
                        ;
                        return $qb;
                    },
                    'required' => true,
                )
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codEstrutural', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add('fkNormasNorma.nomNorma', null, ['label' => 'label.orgao.codNorma']);
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        if ($this->id($this->getSubject())) {
            return true;
        }

        // Informe apenas classificações dos grupos 1,2,7 e 8.
        $codEstrutural = explode('.', $object->getCodEstrutural());

        list($first) = $codEstrutural;
        if (!in_array($first, $this->grupo)) {
            $this->valida(
                $errorElement,
                $this->getContainer()->get('translator')->transChoice('label.contaReceita.message.apenasClassificacoesGrupos', 0, ['codGrupos' => substr_replace(implode(',', $this->grupo), ' e ', 5, strlen(','))], 'messages')
            );
        }

        $codEstrutural = $object->getCodEstrutural();

        /**
         * Validação 1: Verifica se existe uma Classificacao pai para a Classificacao de Receita informada
         * (validação urbem antigo)
         */
        $arClassificacao    = explode(".", $codEstrutural);
        $inCount            = count($arClassificacao)-1;
        $stVerificaClassReceita = null;

        for ($inPosicao = $inCount; $inPosicao >= 0; $inPosicao--) {
            if ($arClassificacao[$inPosicao] != 0) {
                $inTamPos = strlen($arClassificacao[$inPosicao]);
                $arClassificacao[$inPosicao] = str_pad('0', $inTamPos, 0, STR_PAD_LEFT);
                break;
            }
        }

        //remonta a Classificacao de Receita, colocanco '0' na ultima casa com valor
        for ($inPosicaoNew = 0; $inPosicaoNew < $inCount; $inPosicaoNew++) {
            $stVerificaClassReceita .= $arClassificacao[$inPosicaoNew].".";
        }
        $codEstruturalPai = substr($stVerificaClassReceita, 0, strlen($stVerificaClassReceita) - 1);
        $verifica = $this->getDoctrine()->getRepository(ContaReceita::class)->findClassificacaoPorExercicio($this->getExercicio(), $codEstruturalPai, self::LIKE_COD_ESTRUTURAL);

        if (!empty($verifica)) {
            /**
             * Validação 2: Verifica se a Classificação informada já não foi inserida
             * (validação urbem antigo)
             */
            $contaReceita = $this->getDoctrine()->getRepository(ContaReceita::class)->findClassificacaoPorExercicio($this->getExercicio(), $codEstrutural);
            if (!empty($contaReceita)) {
                $this->valida(
                    $errorElement,
                    $this->getContainer()->get('translator')->transChoice('label.contaReceita.message.registroDuplicado', 0, ['codEstrutural' => $codEstrutural], 'messages')
                );
            }
        } else {
            $this->valida(
                $errorElement,
                $this->getContainer()->get('translator')->transChoice('label.contaReceita.message.classificaocaoReceitaInvalida', 0, ['codEstrutural' => $codEstrutural], 'messages')
            );
        }
    }

    public function valida(ErrorElement $errorElement, $error)
    {
        $errorElement->addViolation($error)->end();
        $this->getRequest()->getSession()->getFlashBag()->add("error", $error);
    }

    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $tipoReceita = $this->getTipoReceita();
        try {
            $maxCodConta = $entityManager->getRepository('CoreBundle:Orcamento\ContaReceita')->getMaxCodConta();
            $maxCodConta = array_shift($maxCodConta);
            $object->setCodConta($maxCodConta['max'] + 1);

            $object->setExercicio($this->getExercicio());
            $codigos = explode('.', $object->getCodEstrutural());
            $i = 1;
            foreach ($codigos as $codigo) {
                $posicao = $entityManager->getRepository('CoreBundle:Orcamento\PosicaoReceita')
                    ->findOneBy([
                        'exercicio' => $this->getExercicio(),
                        'codPosicao' => $i,
                        'codTipo' => $tipoReceita->getCodTipo()
                    ]);

                $classificacaoReceita = new ClassificacaoReceita();
                $classificacaoReceita->setCodClassificacao($codigo);
                $classificacaoReceita->setExercicio($this->getExercicio());
                $classificacaoReceita->setFkOrcamentoContaReceita($object);
                $classificacaoReceita->setCodConta($object->getCodConta());
                $classificacaoReceita->setCodPosicao($posicao);
                $classificacaoReceita->setCodTipo($tipoReceita->getCodTipo());
                $classificacaoReceita->setFkOrcamentoPosicaoReceita($posicao);

                $entityManager->persist($classificacaoReceita);

                $i++;
            }
            $entityManager->flush();
        } catch (Exception $e) {
            $entityManager->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', 'Erro ao salvar classificação de receita.');
            throw $e;
        }
    }

    public function preRemove($object)
    {
        if (!empty($object->getFkOrcamentoClassificacaoReceitas())) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            $this->getDoctrine()->clear();
            $this->redirectToUrl($this->request->headers->get('referer'));
        } else {
            $entityManager = $this->modelManager->getEntityManager($this->getClass());
            $classificacaoReceita = $entityManager->getRepository('CoreBundle:Orcamento\ClassificacaoReceita')
                ->findBy(['exercicio' => $this->getExercicio(), 'codConta' => $object->getCodConta()]);

            foreach ($classificacaoReceita as $classificacao) {
                $entityManager->remove($classificacao);
            }
            $entityManager->flush();
        }
    }

    public function toString($object)
    {
        return $object instanceof ContaReceita
            ? $object->getDescricao()
            : 'Classificação da Receita';
    }

    /**
     * @return mixed
     */
    protected function getTipoReceita()
    {
        return  $this->getDoctrine()->getRepository(TipoContaReceita::class)->findOneByDescricao(self::TIPO_RECEITA);
    }
}
