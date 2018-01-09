<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Doctrine\Common\Collections\ArrayCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Entity\Economico\Atividade;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Monetario\Credito;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\CoreBundle\Model\Economico\CadastroEconomicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class PeriodicoArrecadacaoReportAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao
 */
class PeriodicoArrecadacaoReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_relatorio_periodico_arrecadacao';
    protected $baseRoutePattern = 'tributario/arrecadacao/relatorios/periodico-arrecadacao';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
        $collection->add('relatorio', 'relatorio');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->getEntityManager();

        $cadastroEconomicoModel = new CadastroEconomicoModel($em);

        $fieldOptions['dtInicio'] = [
            'label' => 'label.periodicoArrecadacaoReport.dtInicio',
            'format' => 'dd/MM/yyyy',
            'dp_use_current' => false,
            'mapped' => false,
            'required' => true,
        ];

        $fieldOptions['dtFinal'] = [
            'label' => 'label.periodicoArrecadacaoReport.dtFinal',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'required' => true,
        ];

        $fieldOptions['creditoInicial'] = [
            'class' => Credito::class,
            'label' => 'label.periodicoArrecadacaoReport.creditoInicial',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['creditoFinal'] = [
            'class' => Credito::class,
            'label' => 'label.periodicoArrecadacaoReport.creditoFinal',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['grupoCreditoInicial'] = [
            'class' => GrupoCredito::class,
            'label' => 'label.periodicoArrecadacaoReport.grupoCreditoInicial',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['grupoCreditoFinal'] = [
            'class' => GrupoCredito::class,
            'label' => 'label.periodicoArrecadacaoReport.grupoCreditoFinal',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['inscricaoImobiliariaInicial'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => Imovel::class,
            'choice_label' => function (Imovel $imovel) {
                return "{$imovel->getLote() } - {$imovel->getLocalizacao()} - {$imovel->getInscricaoMunicipal()}";
            },
            'label' => 'label.periodicoArrecadacaoReport.inscricaoImobiliariaInicial',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['inscricaoImobiliariaFinal'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => Imovel::class,
            'choice_label' => function (Imovel $imovel) {
                return "{$imovel->getLote() } - {$imovel->getLocalizacao()} - {$imovel->getInscricaoMunicipal()}";
            },
            'label' => 'label.periodicoArrecadacaoReport.inscricaoImobiliariaFinal',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['inscricaoEconomicaInicial'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => CadastroEconomico::class,
            'data'        => new ArrayCollection($cadastroEconomicoModel->findCadastrosEconomico(null)),
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->orderBy('o.inscricaoEconomica', 'ASC');
                return $qb;
            },
            'label' => 'label.periodicoArrecadacaoReport.inscricaoEconomicaInicial',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['inscricaoEconomicaFinal'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => CadastroEconomico::class,
            'data'        => new ArrayCollection($cadastroEconomicoModel->findCadastrosEconomico(null)),
            'label' => 'label.periodicoArrecadacaoReport.inscricaoEconomicaFinal',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['contribuinteInicial'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'label' => 'label.periodicoArrecadacaoReport.contribuinteInicial',
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');
                $qb->andWhere('(o.numcgm = :numcgm OR LOWER(o.nomCgm) LIKE :nomCgm)');
                $qb->andWhere('o.numcgm <> 0');
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));
                $qb->orderBy('o.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters',
            ],
        ];

        $fieldOptions['contribuinteFinal'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'label' => 'label.periodicoArrecadacaoReport.contribuinteFinal',
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');
                $qb->andWhere('(o.numcgm = :numcgm OR LOWER(o.nomCgm) LIKE :nomCgm)');
                $qb->andWhere('o.numcgm <> 0');
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));
                $qb->orderBy('o.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters',
            ],
        ];

        $fieldOptions['atividadeEconomicaInicial'] = [
            'class' => Atividade::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');
                $qb->andWhere('(o.codEstrutural LIKE :term OR LOWER(o.nomAtividade) LIKE LOWER(:term))');
                $qb->setParameter('term', sprintf('%%%s%%', $term));
                $qb->orderBy('o.codEstrutural', 'ASC');

                return $qb;
            },
            'json_choice_value' => function (Atividade $atividade) {
                return $atividade->getCodAtividade();
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.periodicoArrecadacaoReport.atividadeEconomicaInicial',
        ];

        $fieldOptions['atividadeEconomicaFinal'] = [
            'class' => Atividade::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');
                $qb->andWhere('(o.codEstrutural LIKE :term OR LOWER(o.nomAtividade) LIKE LOWER(:term))');
                $qb->setParameter('term', sprintf('%%%s%%', $term));
                $qb->orderBy('o.codEstrutural', 'ASC');

                return $qb;
            },
            'json_choice_value' => function (Atividade $atividade) {
                return $atividade->getCodAtividade();
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.periodicoArrecadacaoReport.atividadeEconomicaFinal',
        ];

        $fieldOptions['tipoRelatorio'] = [
            'label' => 'label.periodicoArrecadacaoReport.tipoRelatorio',
            'choices' => array(
                'label.periodicoArrecadacaoReport.sintetico' => 'sintetico',
                'label.periodicoArrecadacaoReport.analitico' => 'analitico'
            ),
            'mapped' => false,
            'required' => true,
        ];

        $formMapper
            ->add('dtInicio', 'sonata_type_date_picker', $fieldOptions['dtInicio'])
            ->add('dtFinal', 'sonata_type_date_picker', $fieldOptions['dtFinal'])
            ->add('creditoInicial', EntityType::class, $fieldOptions['creditoInicial'])
            ->add('creditoFinal', EntityType::class, $fieldOptions['creditoFinal'])
            ->add('grupoCreditoInicial', EntityType::class, $fieldOptions['grupoCreditoInicial'])
            ->add('grupoCreditoFinal', EntityType::class, $fieldOptions['grupoCreditoFinal'])
            ->add('inscricaoImobiliariaInicial', EntityType::class, $fieldOptions['inscricaoImobiliariaInicial'])
            ->add('inscricaoImobiliariaFinal', EntityType::class, $fieldOptions['inscricaoImobiliariaFinal'])
            ->add('inscricaoEconomicaInicial', EntityType::class, $fieldOptions['inscricaoEconomicaInicial'])
            ->add('inscricaoEconomicaFinal', EntityType::class, $fieldOptions['inscricaoEconomicaFinal'])
            ->add('contribuinteInicial', AutoCompleteType::class, $fieldOptions['contribuinteInicial'])
            ->add('contribuinteFinal', AutoCompleteType::class, $fieldOptions['contribuinteFinal'])
            ->add('atividadeEconomicaInicial', AutoCompleteType::class, $fieldOptions['atividadeEconomicaInicial'])
            ->add('atividadeEconomicaFinal', AutoCompleteType::class, $fieldOptions['atividadeEconomicaFinal'])
            ->add('tipoRelatorio', ChoiceType::class, $fieldOptions['tipoRelatorio'])
        ;
    }

    /**
     * @param $object
     * @return string
     */
    private function parseObject($object)
    {
        if ($object instanceof Credito) {
            return sprintf('%s.%s.%s.%s', $object->getCodCredito(), $object->getCodEspecie(), $object->getCodGenero(), $object->getCodNatureza());
        } elseif ($object instanceof GrupoCredito) {
            return sprintf('%s/%s', $object->getCodGrupo(), $object->getAnoExercicio());
        }
        return '';
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $params = array(
            'dtInicio' => $this->getForm()->get('dtInicio')->getData()->format('Y-m-d'),
            'dtFinal' => $this->getForm()->get('dtFinal')->getData()->format('Y-m-d'),
            'creditoInicial' => $this->parseObject($this->getForm()->get('creditoInicial')->getData()),
            'creditoFinal' => $this->parseObject($this->getForm()->get('creditoFinal')->getData()),
            'grupoCreditoInicial' => $this->parseObject($this->getForm()->get('grupoCreditoInicial')->getData()),
            'grupoCreditoFinal' => $this->parseObject($this->getForm()->get('grupoCreditoFinal')->getData()),
            'inscricaoImobiliariaInicial' => (!is_null($this->getForm()->get('inscricaoImobiliariaInicial')->getData()) ? $this->getForm()->get('inscricaoImobiliariaInicial')->getData()->getInscricaoMunicipal() : null),
            'inscricaoImobiliariaFinal' => (!is_null($this->getForm()->get('inscricaoImobiliariaFinal')->getData()) ? $this->getForm()->get('inscricaoImobiliariaFinal')->getData()->getInscricaoMunicipal() : null),
            'inscricaoEconomicaInicial' => (!is_null($this->getForm()->get('inscricaoEconomicaInicial')->getData()) ? $this->getForm()->get('inscricaoEconomicaInicial')->getData()->getInscricaoEconomica() : null),
            'inscricaoEconomicaFinal' => (!is_null($this->getForm()->get('inscricaoEconomicaFinal')->getData()) ? $this->getForm()->get('inscricaoEconomicaFinal')->getData()->getInscricaoEconomica() : null),
            'contribuinteInicial' => (!is_null($this->getForm()->get('contribuinteInicial')->getData()) ? $this->getForm()->get('contribuinteInicial')->getData()->getNumcgm() : null),
            'contribuinteFinal' => (!is_null($this->getForm()->get('contribuinteFinal')->getData()) ? $this->getForm()->get('contribuinteFinal')->getData()->getNumcgm() : null),
            'atividadeEconomicaInicial' => (!is_null($this->getForm()->get('atividadeEconomicaInicial')->getData()) ? $this->getForm()->get('atividadeEconomicaInicial')->getData()->getCodEstrutural() : null),
            'atividadeEconomicaFinal' => (!is_null($this->getForm()->get('atividadeEconomicaFinal')->getData()) ? $this->getForm()->get('atividadeEconomicaFinal')->getData()->getCodEstrutural() : null),
            'tipoRelatorio' => $this->getForm()->get('tipoRelatorio')->getData()
        );

        $this->forceRedirect($this->generateUrl('relatorio', $params));
    }
}
