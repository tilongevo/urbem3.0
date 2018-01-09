<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Normas;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Normas\AtributoTipoNorma;
use Urbem\CoreBundle\Entity\Normas\TipoNorma;
use Urbem\CoreBundle\Model\Normas\AtributoTipoNormaModel;
use Urbem\CoreBundle\Model\Normas\TipoNormaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TipoNormaAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Normas
 */
class TipoNormaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_normas_tipo_norma';
    protected $baseRoutePattern = 'administrativo/normas/tipo-norma';
    protected $model = TipoNormaModel::class;

    const MODULO = 'Normas';
    const CADASTRO = 'Tipo Norma';
    const COD_MODULO = 15;
    const COD_CADASTRO = 1;

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('nomTipoNorma', null, ['label' => 'label.tipoNorma.nomTipoNorma']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper->add('nomTipoNorma', null, ['label' => 'label.tipoNorma.nomTipoNorma']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var TipoNorma $tipoNorma */
        $tipoNorma = $this->getSubject();

        $lengthConstraint = new Assert\Length([
            'max'        => 40,
            'maxMessage' => $this->trans('default.errors.lengthExceeded', ['%number%' => 40], 'validators')
        ]);

        $fieldOptions = [];
        $fieldOptions['nomTipoNorma'] = [
            'constraints' => [$lengthConstraint],
            'label'       => 'label.tipoNorma.nomTipoNorma'
        ];

        $fieldOptions['atributoDinamico'] = [
            'label'         => 'label.tipoNorma.codAtributoTipoNorma',
            'class'         => AtributoDinamico::class,
            'choice_label'  => 'nomAtributo',
            'choice_value'  => 'codAtributo',
            'multiple'      => true,
            'required'      => false,
            'mapped'        => false,
            'attr'          => ['class' => 'select2-parameters '],
            'query_builder' => function (EntityRepository $repository) {
                return $repository
                    ->createQueryBuilder('a')
                    ->where('a.codModulo = :codModulo')
                    ->andWhere('a.codCadastro = :codCadastro')
                    ->andWhere('a.ativo = true')
                    ->setParameters([
                        'codModulo'   => self::COD_MODULO,
                        'codCadastro' => self::COD_CADASTRO
                    ])
                    ->orderBy('a.nomAtributo', 'ASC');
            }
        ];

        if ($this->id($tipoNorma)) {
            $selectedAtributosDinamicos = [];
            $atributoTipoNormas = $tipoNorma->getFkNormasAtributoTipoNormas();

            /** @var AtributoTipoNorma $atributoTipoNorma */
            foreach ($atributoTipoNormas as $atributoTipoNorma) {
                $selectedAtributosDinamicos[] = $atributoTipoNorma->getFkAdministracaoAtributoDinamico();
            }

            $fieldOptions['atributoDinamico']['data'] = $selectedAtributosDinamicos;
        }

        $formMapper
            ->with('label.tipoNorma.dadosTipoNorma')
                ->add('nomTipoNorma', null, $fieldOptions['nomTipoNorma'])
                ->add('atributoDinamico', 'entity', $fieldOptions['atributoDinamico'])
            ->end();
    }

    /**
     * @param ErrorElement $errorElement
     * @param TipoNorma    $tipoNorma
     */
    public function validate(ErrorElement $errorElement, $tipoNorma)
    {
        $form = $this->getForm();

        $atributosTipoNorma = $tipoNorma->getFkNormasAtributoTipoNormas();

        /** @var array $atributosDinamicos */
        $atributosDinamicos = $form->get('atributoDinamico')->getData();

        /**
         * Percorre o ArrayCollection de AtributoTipoNorma.
         *
         * @var AtributoTipoNorma $atributoTipoNorma
         */
        foreach ($atributosTipoNorma as $atributoTipoNorma) {
            $atributoDinamico = $atributoTipoNorma->getFkAdministracaoAtributoDinamico();

            /**
             * Verifica se o AtributoDinamico de AtributoTipoNorma não está dentro do array de
             *  AtributoDinamico do Form e, se sim, verifica se o objeto AtributoTipoNorma contém um
             *  ArrayCollection de AtributoNormaValor não vazio.
             * Caso as duas condições sejam atendidas, significa que o objeto AtributoDinamico não pode ser removido,
             *  por ja estar sendo usado em mais partes do sistema.
             */
            if (!in_array($atributoDinamico, $atributosDinamicos)
                && !$atributoTipoNorma->getFkNormasAtributoNormaValores()->isEmpty()) {
                $message = $this->trans('tipoNorma.errors.removeAtributoTipoNormaNotValid', [
                    '%atributo%' => $atributoDinamico->getNomAtributo()
                ], 'validators');

                $errorElement->with('atributoDinamico')->addViolation($message)->end();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->with('label.tipoNorma.modulo')
                ->add('nomTipoNorma', null, ['label' => 'label.tipoNorma.nomTipoNorma'])
                ->add('fkNormasAtributoTipoNormas', null, ['label' => 'label.tipoNorma.codAtributoTipoNorma'])
            ->end()
        ;
    }

    /**
     * @param TipoNorma $tipoNorma
     */
    public function prePersist($tipoNorma)
    {
        /** @var Cadastro $cadastro */
        $cadastro = $this->getModelManager()->findOneBy(Cadastro::class, [
            'codModulo'   => self::COD_MODULO,
            'codCadastro' => self::COD_CADASTRO,
        ]);

        $tipoNorma->setFkAdministracaoCadastro($cadastro);
    }

    /**
     * @param TipoNorma $tipoNorma
     */
    public function postPersist($tipoNorma)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $form = $this->getForm();
        $atributosDinamicos =  $form->get('atributoDinamico')->getData();

        $atributoTipoNormaModel = new AtributoTipoNormaModel($entityManager);

        /** @var AtributoDinamico $atributoDinamico */
        foreach ($atributosDinamicos as $atributoDinamico) {
            $atributoTipoNormaModel->buildOneUsingAtributoDinamicoAndTipoNorma($atributoDinamico, $tipoNorma);
        }
    }

    /**
     * @param TipoNorma $tipoNorma
     */
    public function preUpdate($tipoNorma)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $atributoTipoNormaModel = new AtributoTipoNormaModel($entityManager);

        /** @var array $atributosDinamicos */
        $atributosDinamicos = $this->getForm()->get('atributoDinamico')->getData();
        $atributosTipoNorma = $tipoNorma->getFkNormasAtributoTipoNormas();

        /** @var AtributoTipoNorma $atributoTipoNorma */
        foreach ($atributosTipoNorma as $atributoTipoNorma) {
            $atributoDinamico = $atributoTipoNorma->getFkAdministracaoAtributoDinamico();

            /**
             * Verifica se o objeto AtributoDinamico de AtributoTipoNorma NÃO está no
             *  array de AtributoDinamico enviado pelo Form.
             * Caso essa condição seja atendida, significa
             *  que o AtributoTipoNorma foi removido\desvinculado do objeto TipoNorma.
             */
            if (!in_array($atributoDinamico, $atributosDinamicos)
                && $atributoTipoNorma->getFkNormasAtributoNormaValores()->isEmpty()) {
                $tipoNorma->removeFkNormasAtributoTipoNormas($atributoTipoNorma);
                $atributoTipoNormaModel->remove($atributoTipoNorma);
            }

            /**
             * Verifica se o objeto AtributoDinamico de AtributoTipoNorma ESTÁ no
             *  array de AtributoDinamico enviado pelo Form.
             * Caso essa condição seja atendida, significa que o AtributoTipoNorma
             *  precisa ser removido do array de AtributoDinamico enviado pelo Form,
             *  para que não haja conflitos no cadastro dos mesmos posteriormente.
             */
            if (in_array($atributoDinamico, $atributosDinamicos)) {
                $atributosDinamicosIndex = array_search($atributoDinamico, $atributosDinamicos);
                unset($atributosDinamicos[$atributosDinamicosIndex]);
            }
        }

        /** @var AtributoDinamico $atributoDinamico */
        foreach ($atributosDinamicos as $atributoDinamico) {
            $atributoTipoNormaModel->buildOneUsingAtributoDinamicoAndTipoNorma($atributoDinamico, $tipoNorma);
        }
    }
}
