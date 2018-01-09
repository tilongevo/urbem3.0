<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Patrimonio\Bem;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Model\Patrimonial;
use Urbem\CoreBundle\Repository\Orcamento\DespesaRepository;
use Urbem\CoreBundle\Repository\Patrimonio\DepreciacaoRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Patrimonio;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\Organograma;

use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\BemModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel as ConfigModel;

class DepreciacaoAutomaticaAdmin extends AbstractOrganogramaSonata
{

    const MONTH = [
        'Janeiro' =>    '01',
        'Fevereiro' =>  '02',
        'Março' =>      '03',
        'Abril' =>      '04',
        'Maio' =>       '05',
        'Junho' =>      '06',
        'Julho' =>      '07',
        'Agosto' =>     '08',
        'Setembro' =>   '09',
        'Outubro' =>    '10',
        'Novembro' =>   '11',
        'Dezembro' =>   '12',
    ];

    protected $baseRouteName = 'urbem_patrimonial_patrimonio_depreciacao_automatica';

    protected $baseRoutePattern = 'patrimonial/patrimonio/depreciacao-automatica';


    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formMapper
            ->with('label.depreciacao.depreciacao')
            ->add(
                'anulacao',
                'choice',
                [
                    'label' => 'label.depreciacao.anulacao',
                    'attr' => [
                        'class' => 'select2-parameters'
                    ],
                    'choices' => [
                        'Não' => 0,
                        'Sim' => 1,
                    ],
                    'mapped' => false,

                ]
            )
            ->add(
                'competencia',
                'choice',
                [
                    'label' => 'label.depreciacao.competencia',
                    'attr' => [
                        'class' => 'select2-parameters'
                    ],
                    'mapped' => false,
                    'choices' => self::MONTH
                ]
            )
            ->add(
                'exercicio',
                'text',
                [
                    'label' => 'label.depreciacao.exercicio',
                    'mapped' => false,
                    'data' => $this->getExercicio()
                ]
            )
            ->add(
                'motivo',
                'textarea',
                [
                    'label' => 'label.depreciacao.motivo',
                    'mapped' => false,
                ]
            )
        ;
    }



    /**
     * @param ErrorElement $errorElement
     * @param Patrimonio\Depreciacao $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager(Patrimonio\Depreciacao::class);
        $formData = $this->getRequest()->request->get($this->getUniqid());

        $config = new Model\Administracao\ConfiguracaoModel($em);
        $entidade = $config->getConfiguracao('cod_entidade_prefeitura', '8', true, $formData['exercicio']);

        $exercicioCompetencia = $formData['exercicio'] . $formData['competencia'];
        $hasDepreciacao = $em->getRepository(Patrimonio\Depreciacao::class)
            ->createQueryBuilder('d')
            ->andWhere('d.competencia = :competencia')
            ->setParameter('competencia', $exercicioCompetencia)
            ->getQuery()
            ->getResult()
        ;
        $lancamentoDepreciacaoMaxTimestamp = $em->getRepository(Entity\Contabilidade\LancamentoDepreciacao::class)
            ->createQueryBuilder('l')
            ->select('MAX(l.timestamp)')
            ->join('l.fkPatrimonioDepreciacao', 'd')
            ->andWhere('d.competencia = :competencia')
            ->andWhere('l.codEntidade = :codEntidade')
            ->andWhere('l.exercicio = :exercicio')
            ->setParameter('competencia', $exercicioCompetencia)
            ->setParameter('codEntidade', $entidade)
            ->setParameter('exercicio', $formData['exercicio'])
            ->getQuery()
            ->getSingleScalarResult()
        ;
        $lancamentoDepreciacao = $em->getRepository(Entity\Contabilidade\LancamentoDepreciacao::class)
            ->createQueryBuilder('l')
            ->andWhere('l.timestamp = :timestamp')
            ->andWhere('l.exercicio = :exercicio')
            ->setParameter('timestamp', $lancamentoDepreciacaoMaxTimestamp)
            ->setParameter('exercicio', $formData['exercicio'])
            ->getQuery()
            ->getResult()
        ;
        $maxDepreciacaoAnulada = $em->getRepository(Patrimonio\DepreciacaoAnulada::class)
            ->createQueryBuilder('a')
            ->select('MAX(a.codDepreciacao)')
            ->join('a.fkPatrimonioDepreciacao', 'd')
            ->andWhere('d.competencia = :competencia')
            ->setParameter('competencia', $exercicioCompetencia)
            ->getQuery()
            ->getSingleScalarResult()
        ;
        $maxDepreciacao = $em->getRepository(Patrimonio\Depreciacao::class)
            ->createQueryBuilder('d')
            ->select('MAX(d.codDepreciacao)')
            ->andWhere('d.competencia = :competencia')
            ->setParameter('competencia', $exercicioCompetencia)
            ->getQuery()
            ->getSingleScalarResult()
        ;
        $qb = $em->getRepository(Patrimonio\DepreciacaoAnulada::class)->createQueryBuilder('d');
        $maxCompetenciaDepreciada = $em->getRepository(Patrimonio\Depreciacao::class)
            ->createQueryBuilder('d')
            ->select('Max(d.competencia)')
            ->andWhere($qb->expr()->not($qb->expr()->exists(
                'Select 1 From  Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoAnulada d2 ' .
                'Where d.codBem = d2.codBem ' .
                'And d.codDepreciacao = d2.codDepreciacao ' .
                'And d.timestamp = d2.timestamp'
            )))
            ->getQuery()
            ->getSingleScalarResult()
        ;

        /* @TODO Data com potencial para out off bounds ex.: 201200 (mês: 00! ano: 2012) */
        $exercicioCompetenciaAnterior = ($formData['exercicio'] . $formData['competencia']) - 1;
        $maxDepreciacaoAnuladaAnterior = $em->getRepository(Patrimonio\DepreciacaoAnulada::class)
            ->createQueryBuilder('a')
            ->select('MAX(a.codDepreciacao)')
            ->join('a.fkPatrimonioDepreciacao', 'd')
            ->andWhere('d.competencia = :competencia')
            ->setParameter('competencia', $exercicioCompetenciaAnterior)
            ->getQuery()
            ->getSingleScalarResult()
        ;
        $maxDepreciacaoAnterior = $em->getRepository(Patrimonio\Depreciacao::class)
            ->createQueryBuilder('d')
            ->select('MAX(d.codDepreciacao)')
            ->andWhere('d.competencia = :competencia')
            ->setParameter('competencia', $exercicioCompetenciaAnterior)
            ->getQuery()
            ->getSingleScalarResult()
        ;

        $bensNaCompetencia = count($em->getRepository(Bem::class)->montaRecuperaRelacionamento(
            $formData['exercicio'],
            $exercicioCompetencia,
            $exercicioCompetencia
        ));

        $exercicioCompetenciaFormatado = "{$formData['competencia']}/{$formData['exercicio']}";
        $exercicioCompetenciaProximoFormatado = ($maxCompetenciaDepreciada != "{$formData['exercicio']}12") ?
            substr(($maxCompetenciaDepreciada + 1), 4, 6) . "/" . substr($maxCompetenciaDepreciada, 0, 4) :
            substr($maxCompetenciaDepreciada, 4, 6) . "/" . substr($maxCompetenciaDepreciada, 0, 4)
        ;

        $configs = [
            'valor_minimo_depreciacao',
            'competencia_depreciacao',
//            'substituir_depreciacao'
        ];
        $configModel = new ConfigModel($em);


        $object->setCompetencia($exercicioCompetenciaFormatado);
        if ($formData['anulacao']) {
            if (!$hasDepreciacao) {
                $errorElement->addViolation($this->trans('bem.depreciacao.errors.naoExistemBensDepreciados', [
                    '%comp%' => $exercicioCompetenciaFormatado
                ], 'validators'));
                return;
            }
            if ($lancamentoDepreciacao && $lancamentoDepreciacao[0]->getEstorno == 'f') {
                $errorElement->addViolation($this->trans('bem.depreciacao.errors.competenciaComLancamento', [
                    '%comp%' => $exercicioCompetenciaFormatado
                ], 'validators'));
                return;
            }
            if ($maxDepreciacaoAnulada && $maxDepreciacaoAnulada == $maxDepreciacao) {
                $errorElement->addViolation($this->trans('bem.depreciacao.errors.jaAnulado', [
                    '%comp%' => $exercicioCompetenciaFormatado
                ], 'validators'));
                return;
            }
            if ($maxCompetenciaDepreciada != null && $maxCompetenciaDepreciada < $exercicioCompetencia) {
                $errorElement->addViolation($this->trans('bem.depreciacao.errors.anularUltimaCompetencia', [
                    '%comp%' => $exercicioCompetenciaFormatado
                ], 'validators'));
                return;
            }
        } else {
            foreach ($configs as $config) {
                $result = $configModel->pegaConfiguracao(
                    $config,
                    ConfigModel::MODULO_PATRIMONAL_PATRIMONIO,
                    $formData['exercicio']
                );
                if (!isset($result[0])) {
                    continue;
                }
                if ($result[0]['valor'] == '') {
                    $errorElement->addViolation($this->trans('bem.depreciacao.errors.semConfiguracaoNoExercicio', [
                        '%exercicio%' => $formData['exercicio']
                    ], 'validators'));
                    return;
                }
            }

            if ($maxDepreciacaoAnuladaAnterior != null && $maxDepreciacaoAnuladaAnterior == $maxDepreciacaoAnterior) {
                $errorElement->addViolation($this->trans('bem.depreciacao.errors.competenciaComAnulacao', [
                    '%comp%' => $maxDepreciacaoAnterior
                ], 'validators'));
                return;
            }
            if ($maxDepreciacaoAnulada != $maxDepreciacao) {
                $errorElement->addViolation($this->trans('bem.depreciacao.errors.jaDepreciado', [
                    '%comp%' => $exercicioCompetenciaFormatado
                ], 'validators'));
                return;
            }
            if ($maxCompetenciaDepreciada != null && $exercicioCompetencia < $maxCompetenciaDepreciada) {
                $errorElement->addViolation($this->trans('bem.depreciacao.errors.naoPodeSerMenorQue', [
                    '%comp%' => $exercicioCompetenciaProximoFormatado
                ], 'validators'));
                return;
            }
            if ($maxCompetenciaDepreciada != null && $exercicioCompetencia > ($maxCompetenciaDepreciada + 1)) {
                $errorElement->addViolation($this->trans('bem.depreciacao.errors.naoPodeSerMaiorQue', [
                    '%comp%' => $exercicioCompetenciaProximoFormatado
                ], 'validators'));
            }
            /** @TODO: Mudar para getDataInicioCompetencia seria mais elegante? */
            if ($formData['competencia'] != self::MONTH['Janeiro']) {
                for ($i = 1; $i < $formData['competencia']; $i++) {
                    $competenciaI = str_pad($i, 2, 0, STR_PAD_LEFT);
                    $bens = count($em->getRepository(Bem::class)->montaRecuperaRelacionamento(
                        $formData['exercicio'],
                        $exercicioCompetencia,
                        $formData['exercicio'] . $competenciaI
                    ));
                    $depreciacoes = $bens;
                    if ($bens > 0) {
                        $depreciacoes = count(
                            $em->getRepository(Patrimonio\Depreciacao::class)->getDepreciacao(
                                $formData['exercicio'],
                                $formData['exercicio'] . $competenciaI
                            )
                        );
                    }
                    if ($bens <> $depreciacoes) {
                        $errorElement->addViolation($this->trans('bem.depreciacao.errors.deveIniciarEm', [
                            '%comp%' => "$i/{$formData['exercicio']}"
                        ], 'validators'));
                        break;
                    }
                }
            }
            if ($bensNaCompetencia <= 0) {
                $errorElement->addViolation($this->trans('bem.depreciacao.errors.naoHaBens', [
                    '%comp%' => $exercicioCompetenciaFormatado
                ], 'validators'));
            }
            $reavaliacoes = count($em->getRepository(Patrimonio\Depreciacao::class)->getReavaliacao(
                $formData['exercicio'],
                $exercicioCompetencia,
                $formData['motivo']
            ));
            if ($reavaliacoes > 0) {
                $errorElement->addViolation($this->trans('bem.depreciacao.errors.bensNaoReavaliados', [
                    '%comp%' => $exercicioCompetenciaFormatado
                ], 'validators'));
            }
        }
    }


    /**
     * @param Bem $bem
     */
    public function prePersist($bem)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager(Patrimonio\Depreciacao::class);
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $exercicioCompetencia = $formData['exercicio'] . $formData['competencia'];
        $exercicioCompetenciaFormatado = "{$formData['competencia']}/{$formData['exercicio']}";

        if ($formData['anulacao']) {
            try {
                $em->getRepository(Patrimonio\Depreciacao::class)->executaDepreciacaoAnulada(
                    $exercicioCompetencia,
                    $formData['motivo']
                );
                $this->getFlashBag()->add('success', $this->trans('bem.depreciacao.bensAnulados', [
                    '%comp%' => $exercicioCompetenciaFormatado
                ], 'validators'));
            } catch (\Exception $exception) {
                $this->getFlashBag()->add('error', $exception->getMessage());
            }
        } else {
            try {
                $em->getRepository(Patrimonio\Depreciacao::class)->executaDepreciacao(
                    $formData['exercicio'],
                    $exercicioCompetencia,
                    $formData['motivo']
                );
                $this->getFlashBag()->add('success', $this->trans('bem.depreciacao.bensDepreciados', [
                    '%comp%' => $exercicioCompetenciaFormatado
                ], 'validators'));
            } catch (\Exception $exception) {
                $this->getFlashBag()->add('error', $exception->getMessage());
            }
        }
        $this->forceRedirect('/patrimonial/patrimonio/depreciacao-automatica/create');
    }
}
