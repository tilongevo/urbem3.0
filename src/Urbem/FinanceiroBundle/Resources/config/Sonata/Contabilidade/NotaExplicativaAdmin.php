<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Urbem\CoreBundle\Entity\Administracao\Rota;
use Urbem\CoreBundle\Entity\Contabilidade\NotaExplicativa;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class NotaExplicativaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_configuracao_nota_explicativa';
    protected $baseRoutePattern = 'financeiro/contabilidade/configuracao/nota-explicativa';

    /**
     * @param $notaExplicativa
     * @return mixed
     */
    public function getRotaDescricao($notaExplicativa)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $repository = $em->getRepository('CoreBundle:Administracao\Rota');

        if (!is_null($notaExplicativa->getCodAcao())) {
            $rota = $repository->findOneByDescricaoRota($notaExplicativa->getFkContabilidadeNotaExplicativaRota()->getDescricaoRota());
        } else {
            $rota = $repository->findOneByRelatorio(true);
        }
        return $rota;
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof NotaExplicativa
            ? $object->getNotaExplicativa()
            : 'Nota Explicativa';
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'nomRota',
                'doctrine_orm_callback',
                [
                    'label' => 'label.notaExplicativa.nomRota',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'entity',
                [
                    'class' => 'CoreBundle:Administracao\Rota',
                    'choice_label' => 'traducao_rota',
                    'choice_value' => 'descricao_rota',
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.relatorio = true');
                        $qb->orderBy('o.traducaoRota', 'ASC');
                        return $qb;
                    }
                ]
            )
        ;
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        if (!count($value['value'])) {
            return;
        }

        if ($filter['nomRota']['value'] != "") {
            $queryBuilder->andWhere("{$alias}.nomRota = :nomRota");
            $queryBuilder->setParameter('nomRota', $filter['nomRota']['value']);
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'nomRota',
                'customField',
                [
                    'label' => 'label.notaExplicativa.nomRota',
                    'mapped' => false,
                    'template' => 'FinanceiroBundle:Contabilidade\NotaExplicativa:nomRota.html.twig'
                ]
            )
            ->add('dtInicial', 'date', [
                'label' => 'label.notaExplicativa.dtInicial',
                'format' => 'd/m/Y'
            ])
            ->add('dtFinal', 'date', [
                'label' => 'label.notaExplicativa.dtFinal',
                'format' => 'd/m/Y'
            ])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldsOptions = array();

        $fieldsOptions['nomRota'] = [
            'label' => 'label.notaExplicativa.nomRota',
            'class' => 'CoreBundle:Administracao\Rota',
            'choice_label' => 'traducao_rota',
            'choice_value' => 'cod_rota',
            'placeholder' => 'label.selecione',
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.relatorio = true');
                $qb->orderBy('o.traducaoRota', 'ASC');
                return $qb;
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $rotaDescricao = $this->getRotaDescricao(new NotaExplicativa());
        if (!$rotaDescricao) {
            $fieldsOptions['nomRota']['mapped'] = false;
            $fieldsOptions['nomRota']['disabled'] = true;
        }
        $infoEditDate = null;
        if (!is_null($id)) {
            $infoEditDate = explode("~", $id);
        }

        $fieldsOptions['dtInicial'] = [
            'label' => 'label.notaExplicativa.dtInicial',
            'format' => 'dd/MM/yyyy',
            'data' => (!is_null($id)) ? (new \DateTime($infoEditDate[1])) : null,
            'mapped' => false
        ];

        $fieldsOptions['dtFinal'] = [
            'label' => 'label.notaExplicativa.dtFinal',
            'format' => 'dd/MM/yyyy',
            'data' => (!is_null($id)) ? (new \DateTime($infoEditDate[2])) : null,
            'mapped' => false
        ];

        $formMapper
            ->with('label.notaExplicativa.dados')
            ->add(
                'fkContabilidadeNotaExplicativaRota',
                'entity',
                $fieldsOptions['nomRota']
            )
            ->add(
                'dtInicial',
                'sonata_type_date_picker',
                $fieldsOptions['dtInicial']
            )
            ->add(
                'dtFinal',
                'sonata_type_date_picker',
                $fieldsOptions['dtFinal']
            )
            ->add(
                'notaExplicativa',
                null,
                [
                'label' => 'label.notaExplicativa.modulo'
                ]
            )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $nomRota = $this->getRotaDescricao($this->getSubject());

        $showMapper
            ->with('label.notaExplicativa.modulo')
            ->add('rota', null, [
                'label' => 'label.notaExplicativa.nomRota',
                'mapped' => false,
                'template' => 'CoreBundle:Sonata/CRUD:show_custom_html.html.twig',
                'data' => $nomRota->getTraducaoRota()
            ])
            ->add('dtInicial', 'date', [
                'label' => 'label.notaExplicativa.dtInicial',
                'format' => 'd/m/Y'
            ])
            ->add('dtFinal', 'date', [
                'label' => 'label.notaExplicativa.dtFinal',
                'format' => 'd/m/Y'
            ])
            ->add('notaExplicativa', null, [
                'label' => 'label.notaExplicativa.modulo'
            ])
            ->end()
        ;
    }

    /**
     * @param $object
     * @return mixed
     */
    public function getFormDateValidate($object)
    {
        try {
            $dtInicial = $this->getForm()->get('dtInicial')->getData();
            $dtFinal = $this->getForm()->get('dtFinal')->getData();
            $object->setDtInicial(new DatePK($dtInicial->format('Y-m-d')));
            $object->setDtFinal(new DatePK($dtFinal->format('Y-m-d')));

            return $object;
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Exception\Error::ERROR_PERSIST_DATA);
            $this->forceRedirect(
                "/financeiro/contabilidade/nota-explicativa/create"
            );
        }
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $object = $this->getFormDateValidate($object);
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $object = $this->getFormDateValidate($object);
    }

    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        $this->getRequest()->getSession()->getFlashBag()->clear();

        if ($object->getNotaExplicativa()) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $notaExplicativa = $em->getRepository('CoreBundle:Contabilidade\NotaExplicativa')
                ->findOneBy([
                    'notaExplicativa' => $object->getNotaExplicativa(),
                    'dtInicial' => $this->getForm()->get('dtInicial')->getData(),
                    'dtFinal' => $this->getForm()->get('dtFinal')->getData(),
                ]);
            if ($notaExplicativa) {
                $errorElement->with('anexo')->addViolation($this->getTranslator()->trans('label.notaExplicativa.validacao.notaExistente'))->end();
            }
        }
        if ($this->getForm()->get('dtInicial')->getData() > $this->getForm()->get('dtFinal')->getData()) {
            $errorElement->with('anexo')->addViolation($this->getTranslator()->trans('label.notaExplicativa.validacao.dataInicialMenor'))->end();
        }
    }
}
