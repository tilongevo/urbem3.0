<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model\Patrimonial;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Patrimonio;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class LancamentoDepreciacaoAdmin extends AbstractSonataAdmin
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

    protected $baseRouteName = 'urbem_patrimonial_patrimonio_lancamento_depreciacao';

    protected $baseRoutePattern = 'patrimonial/patrimonio/lancamento-depreciacao';


    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formMapper
            ->add(
                'entidade',
                'entity',
                [
                    'label' => 'label.entidade',
                    'attr' => [
                        'class' => 'select2-parameters'
                    ],
                    'class' => Entidade::class,
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
        ;
    }



    /**
     * @param ErrorElement $errorElement
     * @param Entity\Contabilidade\LancamentoDepreciacao $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager(Patrimonio\Depreciacao::class);
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $exercicioCompetencia = $formData['exercicio'] . $formData['competencia'];
        $exercicioCompetenciaFormatado = "{$formData['competencia']}/{$formData['exercicio']}";

        $object->setFkPatrimonioDepreciacao((new Patrimonio\Depreciacao())->setCompetencia($exercicioCompetencia));
        try {
            $lancamentoDepreciacao = $em->getRepository(Entity\Contabilidade\LancamentoDepreciacao::class)
                ->createQueryBuilder('l')
                ->join('l.fkPatrimonioDepreciacao', 'd')
                ->andWhere('l.timestamp = ( ' .
                    'SELECT MAX(l2.timestamp) ' .
                    'FROM Urbem\CoreBundle\Entity\Contabilidade\LancamentoDepreciacao l2 ' .
                    'WHERE d.competencia  = :competencia ' .
                    'AND l2.codEntidade = :entidade ' .
                    'AND l2.exercicio    = :exercicio ' .
                    ')')
                ->andWhere('l.exercicio = :exercicio')
                ->setParameter('competencia', $exercicioCompetencia)
                ->setParameter('exercicio', $formData['exercicio'])
                ->setParameter('entidade', $formData['entidade'])
                ->getQuery()
                ->getSingleResult()
            ;
        } catch (NoResultException $e) {
            $lancamentoDepreciacao = null;
        }

        $depreciacao = count($em->getRepository(Patrimonio\Depreciacao::class)->getDepreciacao(
            $formData['exercicio'],
            $exercicioCompetencia
        ));
        $maxLancamentoDepreciacao = $em->getRepository(Entity\Contabilidade\LancamentoDepreciacao::class)
            ->createQueryBuilder('l')
            ->join('l.fkPatrimonioDepreciacao', 'd')
            ->select('MAX(d.competencia)')
            ->andWhere('l.timestamp = ( ' .
                'SELECT MAX(l2.timestamp) ' .
                'FROM Urbem\CoreBundle\Entity\Contabilidade\LancamentoDepreciacao l2' .
                ')')
            ->andWhere('l.exercicio = :exercicio')
            ->setParameter('exercicio', $formData['exercicio'])
            ->getQuery()
            ->getSingleScalarResult()
        ;
        $qb = $em->getRepository(Patrimonio\DepreciacaoAnulada::class)->createQueryBuilder('d');
        $minCompetenciaDepreciada = $em->getRepository(Patrimonio\Depreciacao::class)
            ->createQueryBuilder('d')
            ->select('MIN(d.competencia)')
            ->andWhere($qb->expr()->not($qb->expr()->exists(
                'Select 1 From  Urbem\CoreBundle\Entity\Patrimonio\DepreciacaoAnulada d2 ' .
                'Where d.codBem = d2.codBem ' .
                'And d.codDepreciacao = d2.codDepreciacao ' .
                'And d.timestamp = d2.timestamp'
            )))
            ->andWhere('d.competencia like :exercicio')
            ->setParameter('exercicio', $formData['exercicio'] . '%')
            ->getQuery()
            ->getSingleScalarResult()
        ;

        try {
            $maxLancamentoDepreciacao = $em->getRepository(Entity\Contabilidade\LancamentoDepreciacao::class)
                ->createQueryBuilder('l')
                ->join('l.fkPatrimonioDepreciacao', 'd')
                ->select('Max(d.competencia) competencia, l.estorno estorno')
                ->andWhere('l.timestamp = :timestamp')
                ->andWhere('l.exercicio = :exercicio')
                ->groupBy('l.estorno')
                ->setParameter('exercicio', $formData['exercicio'])
                ->setParameter(
                    'timestamp',
                    $em->getRepository(Entity\Contabilidade\LancamentoDepreciacao::class)
                        ->createQueryBuilder('l')
                        ->select('max(l.timestamp)')
                        ->getQuery()
                        ->getSingleScalarResult()
                )
                ->getQuery()
                ->getSingleResult()
            ;
        } catch (NoResultException $e) {
            $maxLancamentoDepreciacao = null;
        }

        // Verifica se a competência selecionada
        if ($maxLancamentoDepreciacao &&
            $maxLancamentoDepreciacao->estorno &&
            $maxLancamentoDepreciacao->competencia &&
            $maxLancamentoDepreciacao->competencia != $exercicioCompetencia
        ) {
            $errorElement->addViolation($this->trans('bem.lancamentoDepreciacao.errors.competenciaEstornada', [
                '%comp%' => $maxLancamentoDepreciacao->competencia
            ], 'validators'));
            return;
        }
        /*
         * Verifica se é a primeira vez que ocorre a ação. Tem que existir uma depreciação para esta competencia,
         * e nenhum lançamento ainda efetuado
         */
        if ($minCompetenciaDepreciada &&
            !$maxLancamentoDepreciacao &&
            $minCompetenciaDepreciada != $exercicioCompetencia
        ) {
            $errorElement->addViolation($this->trans('bem.lancamentoDepreciacao.errors.competenciaDeveSer', [
                '%comp%' => $minCompetenciaDepreciada
            ], 'validators'));
            return;
        }
        // Verifica se não existe nenhuma depreciação no sistema, só pode efetuar lançamentos se existir depreciação.
        if ($maxLancamentoDepreciacao && (
            $exercicioCompetencia < $maxLancamentoDepreciacao ||
            $exercicioCompetencia > $maxLancamentoDepreciacao + 1
            )
        ) {
            /* @TODO: 2014? */
            $proximoExercicioCompetenciaFormatado = $maxLancamentoDepreciacao != '201412' ?
                substr(($maxLancamentoDepreciacao + 1), 4, 6) . '/' . substr($maxLancamentoDepreciacao, 0, 4) :
                substr($maxLancamentoDepreciacao, 4, 6) . '/' . substr($maxLancamentoDepreciacao, 0, 4)
            ;
            $errorElement->addViolation($this->trans('bem.lancamentoDepreciacao.errors.competenciaDeveSer', [
                '%comp%' => $proximoExercicioCompetenciaFormatado
            ], 'validators'));
            return;
        }
        // Verifica se não existe nenhuma depreciação no sistema, só pode efetuar lançamentos se existir depreciação.
        if ($depreciacao == 0) {
            $errorElement->addViolation($this->trans('bem.lancamentoDepreciacao.errors.competenciaSemDepreciacao', [
                '%comp%' => $exercicioCompetenciaFormatado
            ], 'validators'));
            return;
        }
        // Verifica se já foi feito lançamento competencia na selecionada, e que não foi estornado.
        if ($lancamentoDepreciacao && !$lancamentoDepreciacao->estorno) {
            $errorElement->addViolation($this->trans('bem.lancamentoDepreciacao.errors.jaLancada', [
                '%comp%' => $exercicioCompetenciaFormatado
            ], 'validators'));
            return;
        }
    }


    /**
     * @param Patrimonio\Depreciacao $depreciacao
     */
    public function prePersist($depreciacao)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager(Patrimonio\Depreciacao::class);
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $exercicioCompetencia = $formData['exercicio'] . $formData['competencia'];
        $exercicioCompetenciaFormatado = "{$formData['competencia']}/{$formData['exercicio']}";

        try {
            $em->getRepository(Entity\Contabilidade\LancamentoDepreciacao::class)->executaLancamentoDepreciacao(
                $formData['exercicio'],
                $exercicioCompetencia,
                $formData['entidade'],
                962,
                'D',
                $exercicioCompetenciaFormatado,
                'false'
            );
            $this->getFlashBag()->add('success', $this->trans('bem.depreciacao.depreciacaoLancada', [
                '%comp%' => $exercicioCompetenciaFormatado
            ], 'validators'));
        } catch (\Exception $exception) {
            $this->getFlashBag()->add('error', $exception->getMessage());
        }
        $this->forceRedirect('/patrimonial/patrimonio/lancamento-depreciacao/create');
    }
}
