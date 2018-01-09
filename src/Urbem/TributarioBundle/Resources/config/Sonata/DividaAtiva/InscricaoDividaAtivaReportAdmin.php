<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\DividaAtiva;

use Doctrine\Common\Collections\ArrayCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Monetario\Credito;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Arrecadacao\GrupoCreditoModel;
use Urbem\CoreBundle\Model\Economico\CadastroEconomicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class InscricaoDividaAtivaReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_divida_ativa_relatorio_inscricao_divida_ativa';
    protected $baseRoutePattern = 'tributario/divida-ativa/relatorios/inscricao-divida-ativa';
    protected $legendButtonSave = array('icon' => 'description', 'text' => 'Gerar Relatório');

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
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

        $grupoCreditoModel = new GrupoCreditoModel($em);
        $cadastroEconomicoModel = new CadastroEconomicoModel($em);

        $fieldOptions = array();

        $fieldOptions['periodo'] = [
            'mapped' => false,
            'required' => true,
            'format' => 'dd/MM/yyyy',
            'dp_use_current' => false,
            'label' => 'label.dividaAtivaRelatorios.inscricaoDividaAtiva.periodoDe',
        ];

        $fieldOptions['grupoCredito'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => GrupoCredito::class,
            'data'        => new ArrayCollection($grupoCreditoModel->getGrupoCredito()),
            'choice_label' => function (GrupoCredito $gCredito) {
                return "{$gCredito->getCodGrupo()} - {$gCredito->getAnoExercicio()} - {$gCredito->getDescricao()}";
            },
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->orderBy('o.codGrupo', 'ASC');
                return $qb;
            },
            'label'       => 'label.dividaAtivaRelatorios.inscricaoDividaAtiva.grupoCredito',
            'mapped'      => false,
            'multiple'    => false,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $fieldOptions['credito'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => Credito::class,
            'choice_value' => function ($credito) {
                if (!$credito) {
                    return;
                }
                return sprintf('%d~%d~%d~%d', $credito->getCodCredito(), $credito->getCodNatureza(), $credito->getCodGenero(), $credito->getCodEspecie());
            },
            'choice_label' => function (Credito $credito) {
                return "{$credito->getCodCredito()} - {$credito->getDescricaoCredito()}";
            },
            'label'       => 'label.dividaAtivaRelatorios.inscricaoDividaAtiva.credito',
            'mapped'      => false,
            'multiple'    => false,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $fieldOptions['contribuinte'] = [
            'class' => SwCgm::class,
            'mapped' => false,
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
            'label' => 'label.dividaAtivaRelatorios.inscricaoDividaAtiva.contribuinte',
        ];

        $fieldOptions['inscricaoEconomica'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => CadastroEconomico::class,
            'data'        => new ArrayCollection($cadastroEconomicoModel->findCadastrosEconomico(null)),
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->orderBy('o.inscricaoEconomica', 'ASC');
                return $qb;
            },
            'label'       => 'label.dividaAtivaRelatorios.inscricaoDividaAtiva.de',
            'mapped'      => false,
            'multiple'    => false,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $fieldOptions['inscricaoImobiliaria'] = [
            'attr'        => ['class' => 'select2-parameters '],
            'class'       => Imovel::class,
            'choice_label' => function (Imovel $imovel) {
                return "{$imovel->getLote() } - {$imovel->getLocalizacao()} - {$imovel->getInscricaoMunicipal()}";
            },
            'label'       => 'label.dividaAtivaRelatorios.inscricaoDividaAtiva.de',
            'mapped'      => false,
            'multiple'    => false,
            'placeholder' => 'label.selecione',
            'required'    => false,
        ];

        $formMapper
            ->with('label.dividaAtivaRelatorios.inscricaoDividaAtiva.titulo')
            ->add('periodoDe', 'sonata_type_date_picker', $fieldOptions['periodo'])
            ->add('periodoAte', 'sonata_type_date_picker', array_merge($fieldOptions['periodo'], ['label' => 'label.dividaAtivaRelatorios.inscricaoDividaAtiva.periodoAte']))
            ->end()
            ->with(' ')
            ->add('credito', 'entity', $fieldOptions['credito'])
            ->add('grupoCredito', 'entity', $fieldOptions['grupoCredito'])
            ->add('contribuinte', 'autocomplete', $fieldOptions['contribuinte'])
            ->end()
            ->with('label.dividaAtivaRelatorios.inscricaoDividaAtiva.inscricaoEconomica')
            ->add('inscricaoEconomicaDe', 'entity', $fieldOptions['inscricaoEconomica'])
            ->add('inscricaoEconomicaAte', 'entity', array_merge($fieldOptions['inscricaoEconomica'], ['label' => 'label.dividaAtivaRelatorios.inscricaoDividaAtiva.ate']))
            ->end()
            ->with('label.dividaAtivaRelatorios.inscricaoDividaAtiva.inscricaoImobiliaria')
            ->add('inscricaoImobiliariaDe', 'entity', $fieldOptions['inscricaoImobiliaria'])
            ->add('inscricaoImobiliariaAte', 'entity', array_merge($fieldOptions['inscricaoImobiliaria'], ['label' => 'label.dividaAtivaRelatorios.inscricaoDividaAtiva.ate']))
            ->end()
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $credito = $this->getFormField($this->getForm(), 'credito');
        $grupoCredito = $this->getFormField($this->getForm(), 'grupoCredito');
        $contribuinte = $this->getForm()->get('contribuinte')->getData();
        $inscricaoImobiliariaDe = $this->getFormField($this->getForm(), 'inscricaoImobiliariaDe');
        $inscricaoImobiliariaAte = $this->getFormField($this->getForm(), 'inscricaoImobiliariaAte');
        $inscricaoEconomicaDe = $this->getFormField($this->getForm(), 'inscricaoEconomicaAte');
        $inscricaoEconomicaAte = $this->getFormField($this->getForm(), 'inscricaoEconomicaAte');

        $cod_credito = $credito ? $credito->getCodCredito() : '';
        $cod_especie = $credito ? $credito->getCodEspecie() : '';
        $cod_genero = $credito ? $credito->getCodGenero() : '';
        $cod_natureza = $credito ? $credito->getCodNatureza() : '';

        $cod_grupo = $grupoCredito ? $grupoCredito->getCodGrupo() : '';
        $grupo_ano_exercicio = $grupoCredito ? $grupoCredito->getAnoExercicio() : '';

        $contribuinte = $contribuinte ? $contribuinte->getNumcgm() : '';
        $inscricaoImobiliariaDe = $inscricaoImobiliariaDe ? $inscricaoImobiliariaDe->getInscricaoMunicipal() : '';
        $inscricaoImobiliariaAte = $inscricaoImobiliariaAte ? $inscricaoImobiliariaAte->getInscricaoMunicipal() : '';
        $inscricaoEconomicaDe = $inscricaoEconomicaDe ? $inscricaoEconomicaDe->getInscricaoEconomica() : '';
        $inscricaoEconomicaAte = $inscricaoEconomicaAte ? $inscricaoEconomicaAte->getInscricaoEconomica() : '';

        $params = [
            'periodoDe' => $this->getFormField($this->getForm(), 'periodoDe')->format('d/m/Y'),
            'periodoAte' => $this->getFormField($this->getForm(), 'periodoAte')->format('d/m/Y'),
            'cod_credito' => $cod_credito,
            'cod_especie' => $cod_especie,
            'cod_genero' => $cod_genero,
            'cod_natureza' => $cod_natureza,
            'cod_grupo' => $cod_grupo,
            'grupo_ano_exercicio' => $grupo_ano_exercicio,
            'contribuinte' => $contribuinte,
            'inscricaoEconomicaDe' => $inscricaoEconomicaDe,
            'inscricaoEconomicaAte' => $inscricaoEconomicaAte,
            'inscricaoImobiliariaDe' => $inscricaoImobiliariaDe,
            'inscricaoImobiliariaAte' => $inscricaoImobiliariaAte
        ];

        $this->forceRedirect($this->generateUrl('relatorio', $params));
    }

    /**
     * @param $form
     * @param $fieldName
     * @return string
     */
    public function getFormField($form, $fieldName)
    {
        return ($form->get($fieldName)->getData()) ? $form->get($fieldName)->getData() : '';
    }
}
