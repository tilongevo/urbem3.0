<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Config\Definition\Exception\Exception;
use Urbem\CoreBundle\Entity\Administracao\Acao;
use Urbem\CoreBundle\Entity\Protocolo\AssuntoAcao;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwAssuntoAtributo;
use Urbem\CoreBundle\Entity\SwDocumentoAssunto;
use Urbem\CoreBundle\Model\Administracao\RotaModel;
use Urbem\CoreBundle\Model\Protocolo\AssuntoAcaoModel;
use Urbem\CoreBundle\Model\SwAssuntoAtributoModel;
use Urbem\CoreBundle\Model\SwDocumentoAssuntoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model;

class AssuntoProtocoloAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_protocolo_assunto_processo';
    protected $baseRoutePattern = 'administrativo/protocolo/assunto-processo';
    protected $model = Model\SwAssuntoModel::class;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('nomAssunto', null, ['label' => 'label.descricao']);
        $datagridMapper->add('fkSwClassificacao', null,
            [
                'label' => 'label.classificacao',
                'placeholder' => 'label.selecione',
                'attr' => ['class' => 'select2-parameters '],
                'field_type' => 'entity',
                'field_options' => [
                    'query_builder' => function (EntityRepository $repo) {
                        return $repo->createQueryBuilder('c')->orderBy('c.codClassificacao', 'ASC');
                    }
                ]
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
            ->add('nomAssunto', 'text', ['label' => 'label.descricao', 'sortable' => false])
            ->add('fkSwClassificacao', null, ['label' => 'label.descricao', 'sortable' => false])
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

        $codAssunto = "";
        $codClassificacao = "";
        if (!empty($id)) {
            $ids = explode('~', $id);
            list($codAssunto, $codClassificacao) = $ids;
        }
        $em = $this->modelManager->getEntityManager($this->getClass());

//        documento assunto
        $fieldOptions['documento'] = [
            'mapped' => false,
            'required' => false,
            'class' => 'CoreBundle:SwDocumento',
            'choice_label' => 'nom_documento',
            'label' => 'label.documentos',
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione'
        ];

        $params = [
            'codAssunto' => $codAssunto,
            'codClassificacao' => $codClassificacao
        ];

        if ($id && count($params)) {
            $documentosAssunto = $this->getSubject()->getFkSwDocumentoAssuntos();
            $fieldOptions['documento']['choice_attr'] = function ($documentos, $key, $index) use ($documentosAssunto) {
                foreach ($documentosAssunto as $documento) {
                    if ($documento->getCodDocumento() == $documentos->getCodDocumento()) {
                        return ['selected' => 'selected'];
                    }
                }
                return ['selected' => false];
            };
        }

//        atributo protocolo
        $fieldOptions['atributo'] = [
            'mapped' => false,
            'required' => false,
            'class' => 'CoreBundle:SwAtributoProtocolo',
            'choice_label' => 'nom_atributo',
            'label' => 'label.atributos',
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        if ($id && count($params)) {
            $assuntosAtributo = $this->getSubject()->getFkSwAssuntoAtributos();
            $fieldOptions['atributo']['choice_attr'] = function ($atributos, $key, $index) use ($assuntosAtributo) {
                foreach ($assuntosAtributo as $atributo) {
                    if ($atributo->getCodAtributo() == $atributos->getCodAtributo()) {
                        return ['selected' => 'selected'];
                    }
                }
                return ['selected' => false];
            };
        }

        $acoesList = [];
        if ($id && count($params)) {
            $assuntoAcoes = $this->getSubject()->getFkProtocoloAssuntoAcoes();
            foreach ($assuntoAcoes as $acao) {
                $acoesList[] = $acao->getCodAcao();
            }
        }

        $arr = [];
        $acoes = $this->getAllRoutesAvailable();
        foreach ($acoes as $acao) {
            $arr[$acao->getNomAcao()] = $acao->getCodAcao();
        }

//         aÃ§ao
        $fieldOptions['acao'] = [
            'mapped' => false,
            'required' => false,
            'choices' => $arr,
            'label' => 'Action',
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'data' => $acoesList
        ];

        $formMapper
            ->with('label.assuntoProcesso.modulo')
            ->add(
                'fkSwClassificacao',
                'entity',
                [
                    'class' => 'CoreBundle:SwClassificacao',
                    'choice_label' => 'nomClassificacao',
                    'label' => 'label.classificacao',
                    'attr' => [
                        'class' => 'select2-parameters ',
                    ],
                    'placeholder' => 'label.selecione',
                ]
            )
            ->add(
                'nomAssunto',
                null,
                [
                    'label' => 'label.descricao'
                ]
            )
            ->add('confidencial')
            ->end()
            ->with('label.assuntoProcesso.documentos')
            ->add(
                'documento',
                'entity',
                $fieldOptions['documento']
            )
            ->end()
            ->with('label.assuntoProcesso.atributos')
            ->add(
                'atributo',
                'entity',
                $fieldOptions['atributo']
            )
            ->end()
            ->with('label.assuntoProcesso.acoes')
            ->add(
                'acao',
                'choice',
                $fieldOptions['acao']
            )
            ->end()
        ;
    }

    protected function getAllRoutesAvailable()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        // Pesquisa acoes cadastradas para o novo Urbem, sempre que adicionado nova ROTA replicar a Migration Version20161219162228.php ou passar para abstract
        return $em->getRepository("CoreBundle:Administracao\\Acao")->findByParametro(Acao::PARAMETER_ROUTE_DEFAULT, ['ordem' => 'ASC', 'nomAcao' => 'ASC']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->with('label.assuntoProcesso.modulo')
            ->add('codAssunto', 'number', ['label' => 'label.codigo'])
            ->add('nomAssunto', 'text', ['label' => 'label.descricao'])
            ->add('fkSwClassificacao.nomClassificacao', 'text', ['label' => 'label.classificacao'])
            ->add('confidencial')
            ->add('fkSwDocumentoAssuntos', null, ['label' => 'label.assuntoProcesso.documentos'])
            ->add('fkSwAssuntoAtributos', null, ['label' => 'label.assuntoProcesso.atributos'])
            ->add('fkProtocoloAssuntoAcoes', null, ['label' => 'label.assuntoProcesso.acoes'])
            ->end()
        ;
    }

    private function saveRelationships($swAssunto)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formData = (object) $this->getFormPost();

        // Pesquisa documento
        if (property_exists($formData, 'documento')) {
            $swDocumentoRepository = $em->getRepository("CoreBundle:SwDocumento");
            foreach ($formData->documento as $codDocumento) {
                $documento = $swDocumentoRepository->findOneByCodDocumento($codDocumento);
                if ($documento) {
                    $swDocumentoAssunto = new SwDocumentoAssunto();
                    $swDocumentoAssunto->setFkSwDocumento($documento);
                    $swDocumentoAssunto->setFkSwAssunto($swAssunto);

                    $swAssunto->addFkSwDocumentoAssuntos($swDocumentoAssunto);
                }
            }
        }

        // Pesquisa Atributos
        if (property_exists($formData, 'atributo')) {
            $swAtributoProtocoloRepository = $em->getRepository("CoreBundle:SwAtributoProtocolo");
            foreach ($formData->atributo as $codAtributo) {
                $atributo = $swAtributoProtocoloRepository->findOneByCodAtributo($codAtributo);
                if ($atributo) {
                    $swAssuntoAtributo = new SwAssuntoAtributo();
                    $swAssuntoAtributo->setFkSwAtributoProtocolo($atributo);
                    $swAssuntoAtributo->setFkSwAssunto($swAssunto);

                    $swAssunto->addFkSwAssuntoAtributos($swAssuntoAtributo);
                }
            }
        }

        // Pesquisa AÃ§Ã£o
        if (property_exists($formData, 'acao')) {
            $acaoRepository = $em->getRepository("CoreBundle:Administracao\\Acao");
            foreach ($formData->acao as $codAcao) {
                $acao = $acaoRepository->findOneByCodAcao($codAcao);
                if ($acao) {
                    $assuntoAcao = new AssuntoAcao();
                    $assuntoAcao->setFkAdministracaoAcao($acao);
                    $assuntoAcao->setFkSwAssunto($swAssunto);

                    $swAssunto->addFkProtocoloAssuntoAcoes($assuntoAcao);
                }
            }
        }
    }

    public function preUpdate($swAssunto)
    {
        /**
         * @var SwAssunto $swAssunto
         */

        $em = $this->modelManager->getEntityManager($this->getClass());

        // Remover os array collections Documento Assuntos
        foreach ($swAssunto->getFkSwDocumentoAssuntos() as $fkSwDocumentoAssunto) {
            $swAssunto->removeFkSwDocumentoAssuntos($fkSwDocumentoAssunto);
        }

        // Remover os array collections Assunto Atributos
        foreach ($swAssunto->getFkSwAssuntoAtributos() as $fkSwAssuntoAtributos) {
            $swAssunto->removeFkSwAssuntoAtributos($fkSwAssuntoAtributos);
        }

        // Remover os array collections Assunto Acao
        foreach ($swAssunto->getFkProtocoloAssuntoAcoes() as $fkProtocoloAssuntoAcoes) {
            $swAssunto->removeFkProtocoloAssuntoAcoes($fkProtocoloAssuntoAcoes);
        }

        $em->flush();

        // Objetos relacionados
        $this->saveRelationships($swAssunto);
    }

    public function prePersist($swAssunto)
    {
        /**
         * @var SwAssunto $swAssunto
         */

        $em = $this->modelManager->getEntityManager($this->getClass());

        $swAssuntoModel = new Model\SwAssuntoModel($em);
        $codAssunto = $swAssuntoModel->getNextCodigo($swAssunto->getFkSwClassificacao()->getCodClassificacao());

        $swAssunto->setCodAssunto($codAssunto);

        // Objetos relacionados
        $this->saveRelationships($swAssunto);
    }

    public function toString($object)
    {
        return $object instanceof SwAssunto
            ? $object->getNomAssunto()
            : 'Assunto de Processo';
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $assunto = $em->getRepository($this->getClass())
            ->findOneBy([
                'nomAssunto' => $object->getNomAssunto(),
                'codClassificacao' => $object->getFkSwClassificacao()->getCodClassificacao()
            ]);

        if ($assunto && $object->getCodAssunto() != $assunto->getCodAssunto()) {
            $error = "Descrição " . $object->getNomAssunto() . " em uso!";
            $errorElement->with('nomAssunto')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }
    }
}
