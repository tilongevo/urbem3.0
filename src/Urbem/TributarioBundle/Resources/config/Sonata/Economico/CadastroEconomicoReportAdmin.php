<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class CadastroEconomicoReportAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Economico
 */
class CadastroEconomicoReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_relatorio_cadastro_economico';
    protected $baseRoutePattern = 'tributario/cadastro-economico/relatorios/cadastro-economico';
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

        $fieldOptions['inscricaoEconomicaDe'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => CadastroEconomico::class,
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->orderBy('o.inscricaoEconomica', 'ASC');
                return $qb;
            },
            'label' => 'label.cadastroEconomicoReport.inscricaoEconomicaDe',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['inscricaoEconomicaAte'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => CadastroEconomico::class,
            'label' => 'label.cadastroEconomicoReport.inscricaoEconomicaAte',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['atividadeDe'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.cadastroEconomicoReport.atividadeDe',
        ];

        $fieldOptions['atividadeAte'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.cadastroEconomicoReport.atividadeAte',
        ];

        $fieldOptions['codigoLogradouroDe'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.cadastroEconomicoReport.codigoLogradouroDe',
        ];

        $fieldOptions['codigoLogradouroAte'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.cadastroEconomicoReport.codigoLogradouroAte',
        ];

        $fieldOptions['numeroLicencaDe'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.cadastroEconomicoReport.numeroLicencaDe',
        ];

        $fieldOptions['numeroLicencaAte'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.cadastroEconomicoReport.numeroLicencaAte',
        ];

        $fieldOptions['socio'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'required' => false,
            'label' => 'label.cadastroEconomicoReport.socio',
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
            'attr' => [
                'class' => 'select2-parameters',
            ],
        ];

        $fieldOptions['tipoInscricao'] = [
            'label' => 'label.cadastroEconomicoReport.tipoInscricao',
            'choices' => array(
                'label.cadastroEconomicoReport.fato' => 'fato',
                'label.cadastroEconomicoReport.direito' => 'direito',
                'label.cadastroEconomicoReport.autonomo' => 'autonomo'
            ),
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['dtInicio'] = [
            'label' => 'label.cadastroEconomicoReport.dtInicio',
            'format' => 'dd/MM/yyyy',
            'dp_use_current' => false,
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['tipoRelatorio'] = [
            'label' => 'label.cadastroEconomicoReport.tipoRelatorio',
            'choices' => array(
                'label.cadastroEconomicoReport.sintetico' => 'sintetico',
                'label.cadastroEconomicoReport.analitico' => 'analitico'
            ),
            'mapped' => false,
            'required' => true,
        ];

        $fieldOptions['situacao'] = [
            'label' => 'label.cadastroEconomicoReport.situacao',
            'choices' => array(
                'label.cadastroEconomicoReport.ativos' => 'Ativo',
                'label.cadastroEconomicoReport.baixados' => 'Baixado',
                'label.cadastroEconomicoReport.todos' => 'Todos'
            ),
            'mapped' => false,
            'required' => true,
        ];

        $formMapper
            ->add('inscricaoEconomicaDe', EntityType::class, $fieldOptions['inscricaoEconomicaDe'])
            ->add('inscricaoEconomicaAte', EntityType::class, $fieldOptions['inscricaoEconomicaAte'])
            ->add('atividadeDe', TextType::class, $fieldOptions['atividadeDe'])
            ->add('atividadeAte', TextType::class, $fieldOptions['atividadeAte'])
            ->add('codigoLogradouroDe', NumberType::class, $fieldOptions['codigoLogradouroDe'])
            ->add('codigoLogradouroAte', NumberType::class, $fieldOptions['codigoLogradouroAte'])
            ->add('numeroLicencaDe', NumberType::class, $fieldOptions['numeroLicencaDe'])
            ->add('numeroLicencaAte', NumberType::class, $fieldOptions['numeroLicencaAte'])
            ->add('socio', AutoCompleteType::class, $fieldOptions['socio'])
            ->add('tipoInscricao', ChoiceType::class, $fieldOptions['tipoInscricao'])
            ->add('dtInicio', 'sonata_type_date_picker', $fieldOptions['dtInicio'])
            ->add('tipoRelatorio', ChoiceType::class, $fieldOptions['tipoRelatorio'])
            ->add('situacao', ChoiceType::class, $fieldOptions['situacao'])
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $params = [
            'inscricaoEconomicaDe' => (!is_null($this->getForm()->get('inscricaoEconomicaDe')->getData()) ? $this->getForm()->get('inscricaoEconomicaDe')->getData()->getInscricaoEconomica() : null),
            'inscricaoEconomicaAte' => (!is_null($this->getForm()->get('inscricaoEconomicaAte')->getData()) ? $this->getForm()->get('inscricaoEconomicaAte')->getData()->getInscricaoEconomica() : null),
            'atividadeDe' => $this->getForm()->get('atividadeDe')->getData(),
            'atividadeAte' => $this->getForm()->get('atividadeAte')->getData(),
            'codigoLogradouroDe' => $this->getForm()->get('codigoLogradouroDe')->getData(),
            'codigoLogradouroAte' => $this->getForm()->get('codigoLogradouroAte')->getData(),
            'numeroLicencaDe' => $this->getForm()->get('numeroLicencaDe')->getData(),
            'numeroLicencaAte' => $this->getForm()->get('numeroLicencaAte')->getData(),
            'socio' => (!is_null($this->getForm()->get('socio')->getData()) ? $this->getForm()->get('socio')->getData()->getNumcgm() : null),
            'tipoInscricao' => $this->getForm()->get('tipoInscricao')->getData(),
            'dtInicio' => (!is_null($this->getForm()->get('dtInicio')->getData()) ? $this->getForm()->get('dtInicio')->getData()->format('d/m/Y'): null),
            'tipoRelatorio' => $this->getForm()->get('tipoRelatorio')->getData(),
            'situacao' => $this->getForm()->get('situacao')->getData(),
        ];

        $this->forceRedirect($this->generateUrl('relatorio', $params));
    }
}
