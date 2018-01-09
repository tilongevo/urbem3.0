<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Entity\Administracao;
use Urbem\CoreBundle\Model\Administracao\FuncaoModel;

class FuncaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_administracao_gerador_calculo_funcao';
    protected $baseRoutePattern = 'administrativo/administracao/gerador-calculo/funcao';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_biblioteca', 'consultar-biblioteca/' . $this->getRouterIdParameter());
        $collection->add('duplicar', 'duplicar/' . $this->getRouterIdParameter());
        $collection->add('consultar_funcao_padrao', 'consultar-funcao-padrao');
    }

    public function preUpdate($object)
    {
        $modulo = $object->getCodModulo();
        $biblioteca = $object->getCodBiblioteca();
        $comentario = $this->getForm()->get('comentario')->getData();
        if ($comentario == null) {
            $comentario = '';
        }
        $corpoPl = $this->getForm()->get('corpoPl')->getData();

        $funcaosExterna = $object->getCodFuncaoExterna();
        $create = true;
        foreach ($funcaosExterna as $funcaoExterna) {
            $funcaoExterna->setComentario($comentario);
            $funcaoExterna->setCorpoPl($corpoPl);
            $create = false;
        }

        if ($create) {
            $funcaoExterna = new Administracao\FuncaoExterna();
            $funcaoExterna->setCodModulo($modulo->getCodModulo());
            $funcaoExterna->setCodBiblioteca($biblioteca->getCodBiblioteca());
            $funcaoExterna->setCodFuncao($object);
            $funcaoExterna->setComentario($comentario);
            $funcaoExterna->setCorpoPl($corpoPl);
            $object->addCodFuncaoExterna($funcaoExterna);
        }

        $executarPl = 'CREATE OR REPLACE ';
        $executarPl .= str_replace('\\', '', $corpoPl);

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Funcao');
        $funcaoModel = new FuncaoModel($em);
        $executaFuncaoPL = $funcaoModel->executaFuncaoPL($executarPl);
        if (!$executaFuncaoPL) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', 'Não foi possível criar a função!');
            $this->forceRedirect('/administrativo/administracao/gerador-calculo/funcao/' . $object->getCodFuncao() . '/edit');
        }

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\AtributoFuncao');
        $atributosCollection = (new \Urbem\CoreBundle\Model\Administracao\AtributoFuncaoModel($em))->getByCodFuncao($object->getCodFuncao());
        foreach ($atributosCollection as $atributo) {
            $em->remove($atributo);
        }

        $repositoryVariavel = $this->getDoctrine()->getRepository(Administracao\Variavel::class);
        $lastVariavel = $repositoryVariavel->findOneBy(
            [
                'codFuncao' => $object->getCodFuncao(),
                'codModulo' => $object->getCodModulo()->getCodModulo(),
                'codBiblioteca' => $object->getCodBiblioteca()->getCodBiblioteca()
            ],
            ['codVariavel' => 'DESC']
        );

        $codVariavel = 1;
        if (!empty($lastVariavel)) {
            $codVariavel = $lastVariavel->getCodVariavel();
        }
        $repositoryTipoPrimitivo = $this->getDoctrine()->getRepository(Administracao\TipoPrimitivo::class);
        foreach ($object->getCodVariavel() as $key => $item) {
            if (empty($item->getCodVariavel())) {
                $item->setFkCodTipo($repositoryTipoPrimitivo->find($item->getCodTipo()));
                $item->setCodVariavel(++$codVariavel);
                $item->setCodFuncao($object->getCodFuncao());
                $item->setFkFuncao($object);
                $item->setCodModulo($object->getCodModulo()->getCodModulo());
                $item->setCodBiblioteca($object->getCodBiblioteca()->getCodBiblioteca());
                $item->setCodFuncao($object->getCodFuncao());
            }
        }
    }

    public function prePersist($object)
    {
        $modulo = $object->getCodBiblioteca()->getCodModulo();
        $biblioteca = $object->getCodBiblioteca();
        $object->setCodModulo($modulo);

        $comentario = $this->getForm()->get('comentario')->getData();
        if ($comentario == null) {
            $comentario = '';
        }
        $corpoPl = $this->getForm()->get('corpoPl')->getData();

        $funcaoExterna = new Administracao\FuncaoExterna();
        $funcaoExterna->setCodModulo($modulo->getCodModulo());
        $funcaoExterna->setCodBiblioteca($biblioteca->getCodBiblioteca());
        $funcaoExterna->setCodFuncao($object);
        $funcaoExterna->setComentario($comentario);
        $funcaoExterna->setCorpoPl($corpoPl);
        $object->addCodFuncaoExterna($funcaoExterna);

        $executarPl = 'CREATE OR REPLACE ';
        $executarPl .= str_replace('\\', '', $corpoPl);

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Funcao');
        $funcaoModel = new FuncaoModel($em);
        $executaFuncaoPL = $funcaoModel->executaFuncaoPL($executarPl);
        if (!$executaFuncaoPL) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', 'Não foi possível criar a função!');
            $this->forceRedirect('/administrativo/administracao/gerador-calculo/funcao/create');
        }

        $repositoryFuncao = $this->getDoctrine()->getRepository(Administracao\Funcao::class);
        $lastFuncao = $repositoryFuncao->findOneBy([], ['codFuncao' => 'DESC']);

        $object->setCodFuncao($lastFuncao->getCodFuncao()+1);

        $repositoryVariavel = $this->getDoctrine()->getRepository(Administracao\Variavel::class);
        $lastVariavel = $repositoryVariavel->findOneBy(
            [
                'codFuncao' => $object->getCodFuncao(),
                'codModulo' => $object->getCodModulo()->getCodModulo(),
                'codBiblioteca' => $object->getCodBiblioteca()->getCodBiblioteca()
            ],
            ['codVariavel' => 'DESC']
        );

        $codVariavel = 1;
        if (!empty($lastVariavel)) {
            $codVariavel = $lastVariavel->getCodVariavel();
        }

        $repositoryTipoPrimitivo = $this->getDoctrine()->getRepository(Administracao\TipoPrimitivo::class);
        foreach ($object->getCodVariavel() as $key => $item) {
            $item->setFkCodTipo($repositoryTipoPrimitivo->find($item->getCodTipo()));
            $item->setCodVariavel($codVariavel++);
            $item->setFkFuncao($object);
            $item->setCodModulo($object->getCodModulo()->getCodModulo());
            $item->setCodBiblioteca($object->getCodBiblioteca()->getCodBiblioteca());
            $item->setCodFuncao($object->getCodFuncao());
        }
    }

    public function postPersist($object)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\AtributoFuncao');
        $atributoFuncaoModel = (new \Urbem\CoreBundle\Model\Administracao\AtributoFuncaoModel($em));

        $atributosCollection = $this->getForm()->get('grupoAtributos')->getData();
        foreach ($atributosCollection as $atributo) {
            $atributoFuncao = (new \Urbem\CoreBundle\Entity\Administracao\AtributoFuncao($em));
            $atributoFuncao->setCodModulo($object->getCodModulo()->getCodModulo());
            $atributoFuncao->setCodBiblioteca($object->getCodBiblioteca()->getCodBiblioteca());
            $atributoFuncao->setCodFuncao($object->getCodFuncao());
            $atributoFuncao->setCodCadastro($atributo->getCodCadastro()->getCodCadastro());
            $atributoFuncao->setCodAtributo($atributo->getCodAtributo());

            $atributoFuncaoModel->save($atributoFuncao);
        }
    }

    public function postUpdate($object)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\AtributoFuncao');
        $atributoFuncaoModel = (new \Urbem\CoreBundle\Model\Administracao\AtributoFuncaoModel($em));

        $atributosCollection = $this->getForm()->get('grupoAtributos')->getData();
        foreach ($atributosCollection as $atributo) {
            $atributoFuncao = (new \Urbem\CoreBundle\Entity\Administracao\AtributoFuncao($em));
            $atributoFuncao->setCodModulo($object->getCodModulo()->getCodModulo());
            $atributoFuncao->setCodBiblioteca($object->getCodBiblioteca()->getCodBiblioteca());
            $atributoFuncao->setCodFuncao($object->getCodFuncao());
            $atributoFuncao->setCodCadastro($atributo->getCodCadastro()->getCodCadastro());
            $atributoFuncao->setCodAtributo($atributo->getCodAtributo());

            $atributoFuncaoModel->save($atributoFuncao);
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nomFuncao', null, ['label' => 'label.funcao.nomFuncao'])
            ->add('codModulo', null, ['label' => 'label.funcao.codModulo'], 'entity', [
                'class' => 'CoreBundle:Administracao\Modulo',
                'choice_label' => 'nomModulo',
                'query_builder' => function ($em) {
                    $qb = $em->createQueryBuilder('m');
                    $qb->orderBy('m.nomModulo', 'ASC');
                    return $qb;
                }
            ])
            ->add('codBiblioteca', null, ['label' => 'label.funcao.codBiblioteca'], 'entity', [
                'class' => 'CoreBundle:Administracao\Biblioteca',
                'choice_label' => 'nomBiblioteca',
                'query_builder' => function ($em) {
                    $qb = $em->createQueryBuilder('b');
                    $qb->where('b.codModulo != 0');
                    $qb->orderBy('b.codModulo', 'ASC');
                    return $qb;
                }
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codFuncao', null, ['label' => 'label.codigo'])
            ->add('nomFuncao', null, ['label' => 'label.funcao.nomFuncao'])
            ->add('codTipoRetorno.nomTipo', null, ['label' => 'label.funcao.codTipoRetorno'])

        ;

        $this->addActionGrid($listMapper);
    }

    protected function addActionGrid($listMapper)
    {
        $listMapper->add('_action', 'actions', array(
            'actions' => array(
                'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                'duplicar' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_duplicar_funcao.html.twig')
            )
        ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        $fieldOptions['codBiblioteca'] = [
            'label' => 'label.funcao.codBiblioteca',
            'class' => 'CoreBundle:Administracao\Biblioteca',
            'choice_label' => 'nomBiblioteca',
            'placeholder' => 'label.selecione',
            'attr' => ['class' => 'select2-parameters '],
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('b');
                $qb->where('b.codModulo != 0');
                $qb->orderBy('b.codModulo', 'ASC');
                return $qb;
            }
        ];

        $fieldOptions['nomFuncao'] = [
            'label' => 'label.funcao.nomFuncao'
        ];

        $fieldOptions['codTipoRetorno'] = [
            'label' => 'label.funcao.codTipoRetorno',
            'class' => 'CoreBundle:Administracao\TipoPrimitivo',
            'choice_label' => 'nomTipo',
            'placeholder' => 'label.selecione',
            'attr' => ['class' => 'select2-parameters '],
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('t');
                $qb->orderBy('t.nomTipo', 'ASC');
                return $qb;
            }
        ];

        $fieldOptions['comentario'] = [
            'label' => 'label.funcao.comentario',
            'required' => false,
            'mapped' => false
        ];

        $fieldOptions['corpoPl'] = [
            'label' => 'label.funcao.corpoPl',
            'required' => true,
            'mapped' => false
        ];

        $fieldOptions['grupoAtributos'] = array(
            'class' => 'CoreBundle:Administracao\AtributoDinamico',
            'choice_label' => 'nomAtributo',
            'label' => 'label.funcao.atributos',
            'mapped' => false,
            'multiple' => true,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        if ($this->id($this->getSubject())) {
            $em = $this->modelManager->getEntityManager($this->getClass());

            list($codModulo, $codBiblioteca, $codFuncao) = explode('~', $id);
            $funcao = $em->getRepository('CoreBundle:Administracao\Funcao')->findOneBy(['codModulo' => $codModulo, 'codBiblioteca' => $codBiblioteca, 'codFuncao' => $codFuncao]);

            $fieldOptions['codBiblioteca']['mapped'] = false;
            $fieldOptions['codBiblioteca']['disabled'] = true;
            $fieldOptions['codBiblioteca']['data'] = $funcao->getCodBiblioteca();

            $fieldOptions['nomFuncao']['mapped'] = false;
            $fieldOptions['nomFuncao']['disabled'] = true;
            $fieldOptions['nomFuncao']['data'] = $funcao->getNomFuncao();

            $fieldOptions['codTipoRetorno']['mapped'] = false;
            $fieldOptions['codTipoRetorno']['disabled'] = true;
            $fieldOptions['codTipoRetorno']['data'] = $funcao->getCodTipoRetorno();

            $funcaoExterna = $em->getRepository('CoreBundle:Administracao\FuncaoExterna')->findOneByCodFuncao($codFuncao);
            if ($funcaoExterna) {
                $fieldOptions['comentario']['data'] = $funcaoExterna->getComentario();
                $fieldOptions['corpoPl']['data'] = $funcaoExterna->getCorpoPl();
            }

            $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\AtributoFuncao');
            $atributosCollection = (new \Urbem\CoreBundle\Model\Administracao\AtributoFuncaoModel($em))->getByCodFuncao($codFuncao);
            $fieldOptions['grupoAtributos']['choice_attr'] = function ($entidade, $key, $index) use ($atributosCollection) {
                foreach ($atributosCollection as $atributo) {
                    if ($entidade->getCodAtributo() == $atributo->getCodAtributo()) {
                        return ['selected' => 'selected'];
                    }
                }
                return ['selected' => false];
            };
        }

        $fieldOptions['codVariavel'] = [
            'by_reference' => false,
            'label' => false
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['canAddNivel']['data'] = false;
            $fieldOptions['codVariavel']['type_options'] = [
                'delete' => false,
                'delete_options' => [
                    'type' => 'hidden'
                ],
            ];
        }

        $formMapper
            ->tab('label.funcao.assinatura')
                ->with('label.funcao.dadosFuncao')
                    ->add('codBiblioteca', 'entity', $fieldOptions['codBiblioteca'])
                    ->add('nomFuncao', 'text', $fieldOptions['nomFuncao'])
                    ->add('codTipoRetorno', 'entity', $fieldOptions['codTipoRetorno'])
                    ->add('comentario', 'textarea', $fieldOptions['comentario'])
                ->end()
            ->end()
            ->tab('label.funcao.corpo')
                ->with('label.funcao.corpoFuncao')
                    ->add('corpoPl', 'textarea', $fieldOptions['corpoPl'])
                ->end()
            ->end()
            ->tab('label.funcao.variavel')
                ->with('label.funcao.dadosVariavel')
                    ->add('fkAdministracaoVariaveis', 'sonata_type_collection', $fieldOptions['codVariavel'], [
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable'  => 'position'
                    ])
                ->end()
            ->end()
            ->tab('label.funcao.gerarFuncaoAcesso')
                ->with('label.funcao.atributos')
                    ->add('grupoAtributos', 'entity', $fieldOptions['grupoAtributos'])
                ->end()
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->with('label.funcao.modulo')
            ->add('codFuncao', null, ['label' => 'label.codigo'])
            ->add('fkAdministracaoBiblioteca.fkAdministracaoModulo.nomModulo', null, ['label' => 'label.funcao.codModulo'])
            ->add('fkAdministracaoBiblioteca.nomBiblioteca', null, ['label' => 'label.funcao.codBiblioteca'])
            ->add('nomFuncao', null, ['label' => 'label.funcao.nomFuncao'])
            ->add('fkAdministracaoTipoPrimitivo.nomTipo', null, ['label' => 'label.funcao.codTipoRetorno'])
            ->end();
        ;
    }
}
