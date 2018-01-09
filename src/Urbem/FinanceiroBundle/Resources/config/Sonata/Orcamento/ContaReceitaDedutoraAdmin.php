<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Orcamento\ClassificacaoReceita;
use Urbem\CoreBundle\Entity\Orcamento\ContaReceita;
use Urbem\CoreBundle\Entity\Orcamento\PosicaoReceita;
use Urbem\CoreBundle\Entity\Orcamento\TipoContaReceita;
use Urbem\CoreBundle\Helper\MascaraHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model;

/**
 * Class ContaReceitaDedutoraAdmin
 * @package Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento
 */
class ContaReceitaDedutoraAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_classificacao_economica_classificacao_receita_dedutora';
    protected $baseRoutePattern = 'financeiro/orcamento/classificacao-economica/classificacao-receita-dedutora';
    protected $includeJs = array(
        '/financeiro/javascripts/orcamento/classificacaoeconomica/classificacao_receita.js',
    );
    const TIPO_RECEITA = 'Dedutora';
    const COD_MODULO_MASK = 8;
    const PARAMETRO_RECEITA_DEDUTORA = 'mascara_classificacao_receita_dedutora';

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $this->getExercicio());

        $query->andWhere($query->expr()->like('o.codEstrutural', $query->expr()->literal('9%')));

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codConta', null, ['label' => 'label.codigo', 'sortable' => false])
            ->add('descricao', null, ['label' => 'label.descricao', 'sortable' => false]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codEstrutural', null, ['label' => 'label.codigoEstrutural', 'sortable' => false])
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
                'label' => 'label.codigo',
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
            $configuracaoModel = new Model\Administracao\ConfiguracaoModel($this->getDoctrine());
            $parametrosReceitaDedutora = [
                'cod_modulo' => self::COD_MODULO_MASK,
                'exercicio' => $this->getExercicio(),
                'parametro' => self::PARAMETRO_RECEITA_DEDUTORA
            ];
            $mascaraClassificacaoReceitaValor = $configuracaoModel->getAtributosDinamicosPorModuloeExercicioParametro($parametrosReceitaDedutora);
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

    /**
     * @param $object
     * @return bool
     */
    public function preValidate($object)
    {
        if ($this->id($this->getSubject())) {
            return true;
        }

        $container = $this->getConfigurationPool()->getContainer();

        $codEstrutural = explode('.', $object->getCodEstrutural());
        list($first) = $codEstrutural;
        if ($first != '9') {
            $container->get('session')->getFlashBag()->add('warning', 'Informe apenas classificações do grupo 9.');
            (new RedirectResponse($this->request->headers->get('referer')))->send();
        }

        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $exercicio = $this->getExercicio();
        $codEstrutural = $object->getCodEstrutural();

        /**
         * Validação 1: Verifica se existe uma Classificacao pai para a Classificacao de Receita informada
         * (validação urbem antigo)
         */
        $codEstruturalPai = MascaraHelper::parseMascaraClassificacaoPai($codEstrutural);

        $verifica = $entityManager->getRepository('CoreBundle:Orcamento\ContaReceita')
            ->verificaClassificacao($exercicio, $codEstruturalPai);

        if ($verifica) {
            /**
             * Validação 2: Verifica se a Classificação informada já não foi inserida
             * (validação urbem antigo)
             */
            $contaReceita = $entityManager->getRepository('CoreBundle:Orcamento\ContaReceita')
                ->getContaReceita($exercicio, $codEstrutural);

            if ($contaReceita) {
                $mensagem = sprintf("Registro Duplicado - %s!", $codEstrutural);

                $container->get('session')->getFlashBag()->add('error', $mensagem);

                (new RedirectResponse($this->request->headers->get('referer')))->send();
            }
        }
    }

    /**
     * @param mixed $object
     */
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

    /**
     * @param mixed $object
     */
    public function preRemove($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $classificacaoReceita = $entityManager->getRepository('CoreBundle:Orcamento\ClassificacaoReceita')
            ->findBy(['exercicio' => $this->getExercicio(), 'codConta' => $object->getCodConta()]);

        foreach ($classificacaoReceita as $classificacao) {
            $entityManager->remove($classificacao);
        }
        $entityManager->flush();
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof ContaReceita
            ? $object->getDescricao()
            : 'Conta Receita Dedutora';
    }

    /**
     * @return mixed
     */
    protected function getTipoReceita()
    {
        return  $this->getDoctrine()->getRepository(TipoContaReceita::class)->findOneByDescricao(self::TIPO_RECEITA);
    }
}
