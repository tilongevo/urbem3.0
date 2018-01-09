<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Arrecadacao\AtributoDesoneracao;
use Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao;
use Urbem\CoreBundle\Entity\Arrecadacao\TipoDesoneracao;
use Urbem\CoreBundle\Entity\Monetario\Credito;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\CoreBundle\Model\Administracao\BibliotecaModel;
use Urbem\CoreBundle\Model\Administracao\CadastroModel;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Arrecadacao\AtributoDesoneracaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class DesoneracaoAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao
 */
class DesoneracaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_desoneracao_definir_desoneracao';
    protected $baseRoutePattern = 'tributario/arrecadacao/desoneracao/definir-desoneracao';
    protected $includeJs = array(
        '/tributario/javascripts/arrecadacao/desoneracao.js'
    );

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codDesoneracao', null, array('label' => 'label.codigo'))
            ->add(
                'fkArrecadacaoTipoDesoneracao',
                'composite_filter',
                [
                    'label' => 'label.definirDesoneracao.tipoDesoneracao'
                ],
                null,
                [
                    'class' => TipoDesoneracao::class
                ]
            )
            ->add(
                'fkMonetarioCredito',
                'composite_filter',
                [
                    'label' => 'label.definirDesoneracao.credito'
                ],
                null,
                [
                    'class' => Credito::class
                ]
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codDesoneracao', null, array('label' => 'label.codigo'))
            ->add('fkArrecadacaoTipoDesoneracao', null, array('label' => 'label.definirDesoneracao.tipoDesoneracao'))
            ->add('fkMonetarioCredito', null, array('label' => 'label.definirDesoneracao.credito'));

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();

        $fieldOptions['fkArrecadacaoTipoDesoneracao'] = array(
            'class' => TipoDesoneracao::class,
            'label' => 'label.definirDesoneracao.tipoDesoneracao',
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $fieldOptions['fkMonetarioCredito'] = array(
            'class' => Credito::class,
            'label' => 'label.definirDesoneracao.credito',
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $fieldOptions['inicio'] = array(
            'label' => 'label.definirDesoneracao.inicio',
            'required' => true,
            'format' => 'dd/MM/yyyy',
        );

        $fieldOptions['termino'] = array(
            'label' => 'label.definirDesoneracao.termino',
            'required' => true,
            'format' => 'dd/MM/yyyy',
        );

        $fieldOptions['expiracao'] = array(
            'label' => 'label.definirDesoneracao.dataExpiracao',
            'required' => true,
            'format' => 'dd/MM/yyyy',
        );

        $fieldOptions['fkNormasNorma'] = array(
            'label' => 'label.monetarioAcrescimo.fundamentacaoLegal',
            'class' => Norma::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $qb = $repo->createQueryBuilder('n')
                    ->where('LOWER(n.nomNorma) LIKE :nomNorma')
                    ->setParameter('nomNorma', "%" . strtolower($term) . "%");
                return $qb;
            },
            'required' => true,
            'mapped' => false,
        );

        $fieldOptions['fkAdministracaoFuncao'] = array(
            'label' => 'label.monetarioAcrescimo.funcao',
            'class' => Funcao::class,
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'query_builder' => function (EntityRepository $repo) {
                $qb = $repo->createQueryBuilder('f')
                    ->where('f.codModulo = :codModulo')
                    ->andWhere('f.codBiblioteca = :codBiblioteca')
                    ->setParameter('codModulo', ConfiguracaoModel::MODULO_TRIBUTARIO_ARRECADACAO)
                    ->setParameter('codBiblioteca', BibliotecaModel::MODULO_ARRECADACAO_FORMULA_DESONERACAO);
                return $qb;
            },
        );

        $fieldOptions['revogavel'] = array(
            'label' => 'label.definirDesoneracao.revogavel',
            'choices' => array(
                'sim' => 1,
                'nao' => 0
            ),
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $fieldOptions['prorrogavel'] = array(
            'label' => 'label.definirDesoneracao.prorrogavel',
            'choices' => array(
                'sim' => 1,
                'nao' => 0
            ),
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $fieldOptions['fkArrecadacaoAtributoDesoneracoes'] = array(
            'label' => 'label.definirDesoneracao.atributos',
            'class' => AtributoDinamico::class,
            'required' => false,
            'mapped' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'query_builder' => function (EntityRepository $repo) {
                $qb = $repo->createQueryBuilder('ad')
                    ->where('ad.codModulo = :codModulo')
                    ->andWhere('ad.codCadastro = :codCadastro')
                    ->setParameter('codModulo', ConfiguracaoModel::MODULO_TRIBUTARIO_ARRECADACAO)
                    ->setParameter('codCadastro', CadastroModel::CADASTRO_DESONERACAO);
                return $qb;
            },
        );

        if ($this->id($this->getSubject())) {
            $em = $this->modelManager->getEntityManager($this->getClass());

            /** @var Desoneracao $desoneracao */
            $desoneracao = $this->getSubject();

            $atributos = array();
            $atributosDesoneracao = $em->getRepository(AtributoDesoneracao::class)
                ->findBy([
                    'codModulo' => ConfiguracaoModel::MODULO_TRIBUTARIO_ARRECADACAO,
                    'codDesoneracao' => $desoneracao->getCodDesoneracao(),
                    'ativo' => true
                ]);
            foreach ($atributosDesoneracao as $atributoDesoneracao) {
                $atributos[] = $atributoDesoneracao->getFkAdministracaoAtributoDinamico();
            }
            $fieldOptions['fkArrecadacaoAtributoDesoneracoes']['data'] = $atributos;

            $fieldOptions['fkArrecadacaoTipoDesoneracao']['disabled'] = 'disabled';
            $fieldOptions['fkMonetarioCredito']['disabled'] = 'disabled';

            $fieldOptions['fkNormasNorma']['data'] = $desoneracao->getFkNormasNorma();
        }

        $formMapper
            ->with('label.definirDesoneracao.dados')
            ->add('fkArrecadacaoTipoDesoneracao', EntityType::class, $fieldOptions['fkArrecadacaoTipoDesoneracao'])
            ->add('fkMonetarioCredito', EntityType::class, $fieldOptions['fkMonetarioCredito'])
            ->add('inicio', DatePickerType::class, $fieldOptions['inicio'])
            ->add('termino', DatePickerType::class, $fieldOptions['termino'])
            ->add('expiracao', DatePickerType::class, $fieldOptions['expiracao'])
            ->add('fkNormasNorma', AutoCompleteType::class, $fieldOptions['fkNormasNorma'])
            ->add('fkAdministracaoFuncao', EntityType::class, $fieldOptions['fkAdministracaoFuncao'])
            ->add('revogavel', ChoiceType::class, $fieldOptions['revogavel'])
            ->add('prorrogavel', ChoiceType::class, $fieldOptions['prorrogavel'])
            ->add('fkArrecadacaoAtributoDesoneracoes', EntityType::class, $fieldOptions['fkArrecadacaoAtributoDesoneracoes'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.definirDesoneracao.dados')
            ->add('codDesoneracao', null, array('label' => 'label.codigo'))
            ->add('fkArrecadacaoTipoDesoneracao', null, array('label' => 'label.definirDesoneracao.tipoDesoneracao'))
            ->add('fkMonetarioCredito', 'string', array('label' => 'label.definirDesoneracao.credito'))
            ->add('inicio', null, array('label' => 'label.definirDesoneracao.inicio'))
            ->add('termino', null, array('label' => 'label.definirDesoneracao.termino'))
            ->add('expiracao', null, array('label' => 'label.definirDesoneracao.dataExpiracao'))
            ->add('fkNormasNorma', 'string', array('label' => 'label.monetarioAcrescimo.fundamentacaoLegal'))
            ->add('fkAdministracaoFuncao', 'string', array('label' => 'label.definirDesoneracao.formulaCalculo'))
            ->add('revogavel', null, array('label' => 'label.definirDesoneracao.revogavel'))
            ->add('prorrogavel', null, array('label' => 'label.definirDesoneracao.prorrogavel'))
            ->add(
                'fkArrecadacaoAtributoDesoneracoes',
                'string',
                array(
                    'label' => 'label.definirDesoneracao.atributos',
                    'template' => 'TributarioBundle::Arrecadacao/Desoneracao/Definir/dadosAtributos.html.twig',
                )
            )
            ->end();
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $norma = $em->getRepository(Norma::class)
            ->findOneBy(['codNorma' => $this->getForm()->get('fkNormasNorma')->getViewData()[0]]);

        if ($norma) {
            $object->setFundamentacaoLegal($norma->getCodNorma());
        }

        $this->saveRelationships($object);
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $norma = $em->getRepository(Norma::class)
            ->findOneBy(['codNorma' => $this->getForm()->get('fkNormasNorma')->getViewData()[0]]);

        if ($norma) {
            $object->setFundamentacaoLegal($norma->getCodNorma());
        }
    }

    /**
     * @param mixed $object
     */
    public function postPersist($object)
    {
        $this->saveRelationships($object);
    }

    /**
     * @param $object
     * @return bool
     */
    private function saveRelationships($object)
    {

        $container = $this->getConfigurationPool()->getContainer();
        $em = $this->modelManager->getEntityManager($this->getClass());

        try {
            $atributoDesoneracaoModel = new AtributoDesoneracaoModel($em);

            $fkArrecadacaoAtributoDesoneracoes = $this->getForm()->get('fkArrecadacaoAtributoDesoneracoes')->getdata();

            $atributoDesoneracaoModel->saveAtributoDesoneracao($object, $fkArrecadacaoAtributoDesoneracoes);

            return true;
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.definirDesoneracao.erro'));
        }
    }

    /**
     * @param mixed $object
     */
    public function preRemove($object)
    {
        if ($this->canRemove($object, ['fkArrecadacaoAtributoDesoneracoes'])) {
            return;
        }

        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add(
            'error',
            $this->getTranslator()->trans(
                'label.definirDesoneracao.erroExcluir',
                array('%desoneracao%' => $object->getCodDesoneracao())
            )
        );

        $this->modelManager->getEntityManager($this->getClass())->clear();

        return $this->forceRedirect($this->generateObjectUrl('list', $object));
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Desoneracao
            ? $object->getCodDesoneracao()
            : $this->getTranslator()->trans('label.definirDesoneracao.modulo');
    }
}
