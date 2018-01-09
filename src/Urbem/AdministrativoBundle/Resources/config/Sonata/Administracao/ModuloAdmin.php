<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Model\Administracao\UsuarioModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Doctrine\ORM;

class ModuloAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'administracao_sistema_responsavel_modulo';
    protected $baseRoutePattern = 'administrativo/administracao/responsavel-modulo';
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoIncluir = false;
    protected $usuario = [];

    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'codGestao.nomGestao'
    );

    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->remove('bacth');
        $routeCollection->remove('export');
        $routeCollection->remove('delete');
        $routeCollection->remove('show');
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $modulos = $this->getDoctrine()->getRepository(Modulo::class);
        $todosOsModulos = $modulos->getAllModulos();

        $modulos = [0];
        if (!empty($todosOsModulos)) {
            $modulos = array_column(ArrayHelper::parseCollectionToArray($todosOsModulos), 'cod_modulo');
        }
        $query->join('Urbem\CoreBundle\Entity\Administracao\Gestao', 'g', 'WITH', 'o.codGestao = g.codGestao');
        $query->where(sprintf('o.codModulo IN (%s)', implode(",", $modulos)));

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

        $datagridMapper
            ->add(
                'nomModulo',
                null,
                [
                    'label' => 'label.administracao.nomModulo'
                ]
            );
    }

    public function getUsuarioByNumcgm($codResponsavel, $fieldSearch = null)
    {
        if (array_key_exists($codResponsavel, $this->usuario)) {
            return !empty($fieldSearch) ? $this->usuario[$codResponsavel]->$fieldSearch : $this->usuario[$codResponsavel];
        }

        $em = $this->modelManager->getEntityManager($this->getClass());
        $usuarioModel = new UsuarioModel($em);
        $usuario =  $usuarioModel->getUsuarioByNumcgm($codResponsavel);

        $this->usuario[$usuario->numcgm] = $usuario;

        return !empty($fieldSearch) ? $usuario->$fieldSearch : $usuario;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codGestao.nomGestao',
                null,
                [
                    'label' => 'Gestão'
                ]
            )
            ->add(
                'nomModulo',
                null,
                [
                    'label' => 'label.administracao.nomModulo'
                ]
            )
            ->add(
                'username',
                'customField',
                [
                    'label' => 'label.administracao.username',
                    'mapped' => false,
                    'template' => 'AdministrativoBundle:Administracao\Usuario:nomeResponsavelModulo.html.twig',
                ]
            )
            ->add(
                'setor',
                'customField',
                [
                    'label' => 'label.administracao.nomSetor',
                    'mapped' => false,
                    'template' => 'AdministrativoBundle:Administracao\Usuario:nomeSetorUsuario.html.twig',
                ]
            )
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

        $em = $this->modelManager->getEntityManager($this->getClass());
        $modulo = $em->getRepository('CoreBundle:Administracao\Modulo')->findOneByCodModulo($id);


        $usuario = null;
        $selected = false;
        if ($id) {
            $codResponsavel = $modulo->getCodResponsavel();
            $usuario = $em->getRepository('CoreBundle:Administracao\Usuario')->findOneByNumcgm($codResponsavel);
            $selected = true;
        }

        $fieldOptions['codResponsavel'] = [
            'label' => 'label.responsavel',
            'class' => 'CoreBundle:Administracao\Usuario',
            'choice_label' => 'username',
            'attr' => [
                'data-sonata-select2' => 'false',
                'selected' => $selected,
            ],
            'data' => $usuario,
        ];

        $formMapper
            ->add('nomModulo', 'text', ['label' => 'label.administracao.nomModulo', 'attr' => [
                'readonly' => 'readyonly',
            ] ])
            ->add('codResponsavel', 'entity', $fieldOptions['codResponsavel']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add(
                'nomModulo',
                null,
                [
                    'label' => 'label.administracao.nomModulo'
                ]
            )
            ->add(
                'nomDiretorio',
                null,
                [
                    'label' => 'label.administracao.nomDiretorio'
                ]
            )
            ->add(
                'username',
                'customField',
                [
                    'label' => 'label.administracao.username',
                    'mapped' => false,
                    'template' => 'AdministrativoBundle:Administracao\Usuario:nomeResponsavelModuloShow.html.twig',
                ]
            )
            ->add(
                'setor',
                'customField',
                [
                    'label' => 'label.administracao.nomSetor',
                    'mapped' => false,
                    'template' => 'AdministrativoBundle:Administracao\Usuario:nomeSetorUsuarioShow.html.twig',
                ]
            )
            ->add('ativo')
        ;
    }

    public function preUpdate($object)
    {
        $object->setCodResponsavel($object->getCodResponsavel()->getNumcgm());
    }
}
