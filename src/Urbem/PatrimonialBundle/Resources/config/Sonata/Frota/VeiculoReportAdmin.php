<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Gestao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Relatorio;
use Urbem\CoreBundle\Entity\Frota\Veiculo;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Helper\ReportHelper;
use Urbem\CoreBundle\Model\Patrimonial\Frota\VeiculoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class VeiculoReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_relatorios_veiculo';
    protected $baseRoutePattern = 'patrimonial/frota/relatorios/veiculo';
    protected $layoutDefaultReport = '/bundles/report/gestaoPatrimonial/fontes/RPT/frota/report/design/relatorioVeiculo.rptdesign';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar relatório'];

    const COD_ACAO = '154';
    const PLACA = 1;
    const COD_VEICULO = 2;
    const TODOS = 1;
    const SIM = 2;
    const NAO = 3;

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $fileName = $this->parseNameFile("veiculo");

        $veiculo = $this->getFormField($this->getForm(), 'veiculo');
        $placa = $this->getFormField($this->getForm(), 'placa');
        $prefixo = $this->getFormField($this->getForm(), 'prefixo');
        $ordenacao = $this->getFormField($this->getForm(), 'ordenacao');
        $entidades = $this->getFormField($this->getForm(), 'entidades');
        $veiculosBaixados = $this->getFormField($this->getForm(), 'veiculosBaixados');

        $params = [
            'term_user' => $this->getCurrentUser()->getUserName(),
            'exercicio' => $this->getExercicio(),
            'cod_acao' => self::COD_ACAO,
            'inCodGestao' => Gestao::GESTAO_PATRIMONIAL,
            'inCodModulo' => Modulo::MODULO_FROTA,
            'inCodRelatorio' => Relatorio::PATRIMONIAL_VEICULO,
            'stPlaca' => $placa,
            'stPrefixo' => $prefixo,
            'inCodVeiculo' => $veiculo ? (string) $veiculo->getCodVeiculo() : '',
            'ordenacao' => (string) $ordenacao,
            'baixado' => (string) $veiculosBaixados,
            'inCodEntidade' => ReportHelper::getCodEntidades($entidades)
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
     * @param $form
     * @param $fieldName
     * @return string
     */
    public function getFormField($form, $fieldName)
    {
        return ($form->get($fieldName)->getData()) ? $form->get($fieldName)->getData() : '';
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();
        $exercicio = $this->getExercicio();
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();

        $fieldOptions['veiculo'] = [
            'attr' => ['class' => 'select2-parameters catalogo-item '],
            'class' => Veiculo::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' =>
                function (EntityRepository $repo, $term, Request $request) use ($em) {
                    $queryBuilder = (new VeiculoModel($em))->getVeiculosNaoBaixadosQuery();
                    $alias = $queryBuilder->getRootAlias();
                    $term = $request->get('q');

                    return $queryBuilder
                        // Exemplo: 130 - IWZ - / CHEVROLET / SPIN MT LTZ
                        ->andWhere("LOWER(CONCAT({$alias}.codVeiculo, ' - ' , {$alias}.placa, ' / ', fkFrotaMarca.nomMarca, ' / ', fkFrotaModelo.nomModelo)) LIKE LOWER(:term)")
                        ->setParameter('term', "%{$term}%");
                },
            'label' => 'label.saidaDiversas.veiculo',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['placa'] = [
            'label' => 'label.veiculo.placa',
            'required' => false,
            'mapped' => false,
            'attr' => [
                'maxlength' => 7,
                'data-mask' => 'SSS0000'
            ]
        ];

        $fieldOptions['prefixo'] = [
            'label' => 'label.veiculo.prefixo',
            'required' => false,
            'mapped' => false,
            'attr' => [
                'maxlength' => 15
            ]
        ];

        $fieldOptions['entidades'] = [
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
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom ']
        ];

        $ordenacao = [
            self::PLACA => 'label.patrimonial.frota.relatorios.veiculo.placa',
            self::COD_VEICULO => 'label.patrimonial.frota.relatorios.veiculo.codigo'
        ];

        $fieldOptions['ordenacao'] = [
            'required' => true,
            'mapped' => false,
            'choices' => array_flip($ordenacao),
            'label' => 'Ordenação',
            'attr' => [
                'class' => 'select2-parameters '
            ],
        ];

        $veiculoBaixados = [
            self::TODOS => 'label.patrimonial.frota.relatorios.veiculo.todos',
            self::SIM => 'label_type_yes',
            self::NAO => 'label_type_no'
        ];

        $fieldOptions['veiculosBaixados'] = [
            'required' => true,
            'mapped' => false,
            'choices' => array_flip($veiculoBaixados),
            'label' => 'Veículos Baixados',
            'attr' => [
                'class' => 'select2-parameters '
            ],
        ];

        $formMapper
            ->add('veiculo', 'autocomplete', $fieldOptions['veiculo'])
            ->add('placa', 'text', $fieldOptions['placa'])
            ->add('prefixo', 'text', $fieldOptions['prefixo'])
            ->add('ordenacao', 'choice', $fieldOptions['ordenacao'])
            ->add('entidades', 'entity', $fieldOptions['entidades'])
            ->add('veiculosBaixados', 'choice', $fieldOptions['veiculosBaixados']);
    }
}
