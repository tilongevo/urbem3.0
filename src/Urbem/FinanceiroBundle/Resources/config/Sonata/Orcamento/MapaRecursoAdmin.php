<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class MapaRecursoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_relatorio_mapa_recurso';
    protected $baseRoutePattern = 'financeiro/orcamento/relatorios/mapa-recurso';
    protected $layoutDefaultReport = '/bundles/report/gestaoFinanceira/fontes/RPT/orcamento/report/design/balancoPatrimonial.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar Relatório'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $entities = $this->getForm()->get('entidades')->getData();
        $cod_entidades = $this->getCodEntidades($entities);
        $exercicio = $this->getExercicio();
        $data = $this->getForm()->get('posicaoEm')->getData()->format('d/m/Y');
        $fileName = $this->parseNameFile("mapaRecurso");
        
        $params = [
            'cod_entidade' => $cod_entidades,
            'exercicio' => $exercicio,
            'data_final' => $data,
            'cod_recurso_ini' => (integer) $this->getForm()->get('codigoRecursoDe')->getData(),
            'cod_recurso_fim' => (integer) $this->getForm()->get('codigoRecursoAte')->getData(),
            'cod_acao' => '2327',
            'inCodGestao' => Gestao::GESTAO_FINANCEIRA,
            'inCodModulo' => Modulo::MODULO_ORCAMENTO ,
            'inCodRelatorio' => Relatorio::FINANCEIRO_MAPA_RECURSO,
            'term_user' => $this->getCurrentUser()->getUserName()
        ];

        $apiService = $this->getReportService();
        $apiService->setReportNameFile($fileName);
        $apiService->setLayoutDefaultReport($this->layoutDefaultReport);
        $res = $apiService->getReportContent($params);

        $this->parseContentToPdf(
            $res->getBody()->getContents(),
            $fileName
        );
    }

    /**
     * @param $entities
     * @return string
     */
    public function getCodEntidades($entities)
    {
        $cod_Entidades = '';

        foreach ($entities as $entity) {
            $cod_Entidades .= $entity->getCodEntidade().',';
        }

        $cod_Entidades = substr($cod_Entidades, 0, -1);

        return $cod_Entidades;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();

        $formMapper
            ->add(
                'entidades',
                'entity',
                array(
                    'class' => Entidade::class,
                    'label' => 'label.lote.codEntidade',
                    'placeholder' => 'label.selecione',
                    'mapped' => false,
                    'required' => true,
                    'choice_value' => 'codEntidade',
                    'attr' => ['class' => 'select2-parameters'],
                    'query_builder' => function ($em) use ($exercicio) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.exercicio = :exercicio');
                        $qb->setParameter('exercicio', $exercicio);
                        return $qb;
                    },

                    'multiple' => true,
                )
            )
            ->add(
                'posicaoEm',
                'sonata_type_date_picker',
                array(
                    'label' => 'label.mapaRecurso.posicaoEm',
                    'mapped' => false,
                    'required' => true,
                    'format' => 'dd/MM/yyyy',

                )
            )
            ->add(
                'codigoRecursoDe',
                'text',
                array(
                    'label' => 'label.mapaRecurso.codigoRecursoDe',
                    'required' => false,
                    'mapped' => false,
                )
            )
            ->add(
                'codigoRecursoAte',
                'text',
                array(
                    'label' => 'label.mapaRecurso.codigoRecursoAte',
                    'required' => false,
                    'mapped' => false,
                )
            )
            ;
    }
}
