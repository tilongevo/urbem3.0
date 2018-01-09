<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Entity\Arrecadacao\Permissao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class PermissaoAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao
 */
class PermissaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_grupo_credito_definir_permissao';
    protected $baseRoutePattern = 'tributario/arrecadacao/grupo-credito/definir-permissao';

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();
        $fieldOptions['fkAdministracaoUsuario'] = [
            'class' => Usuario::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $qb = $repo->createQueryBuilder('o');
                $qb->join(SwCgm::class, 'swcgm', 'WITH', 'o.numcgm = swcgm.numcgm');
                $qb->where($qb->expr()->orX(
                    $qb->expr()->like('LOWER(swcgm.nomCgm)', ':nomCgm'),
                    $qb->expr()->eq('o.numcgm', ':numcgm')
                ));
                $qb->setParameters([
                    'nomCgm' => sprintf('%%%s%%', strtolower($term)),
                    'numcgm' => ((int) $term) ? $term: null
                ]);
                return $qb;
            },
            'label' => 'label.cgm',
            'required' => true,
            'mapped' => false,
        ];

        $fieldOptions['creditosGrupo'] = array(
            'class' => GrupoCredito::class,
            'label' => 'label.grupoCreditoPermissao.grupoCreditos',
            'mapped' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'select2-parameters'
            ],
        );

        $formMapper
            ->with('label.grupoCreditoPermissao.dados')
                ->add('fkAdministracaoUsuario', 'autocomplete', $fieldOptions['fkAdministracaoUsuario'], ['admin_code' => 'administrativo.admin.usuario'])
            ->end()
            ->with('label.grupoCreditoPermissao.grupoCreditos')
                ->add('creditosGrupo', 'entity', $fieldOptions['creditosGrupo'])
            ->end()
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager(GrupoCredito::class);
        $container = $this->getConfigurationPool()->getContainer();

        try {
            $usuario = $this->getForm()->get('fkAdministracaoUsuario')->getdata();
            $creditosGrupo = $this->getForm()->get('creditosGrupo')->getdata();

            $permissoes = $em->getRepository(Permissao::class)
                ->findBy([
                    'numcgm' => $usuario->getNumcgm()
                ]);

            foreach ($permissoes as $permissao) {
                $em->remove($permissao);
            }

            $em->flush();

            foreach ($creditosGrupo as $creditoGrupo) {
                $permissao = new Permissao();
                $permissao->setFkArrecadacaoGrupoCredito($creditoGrupo);
                $permissao->setFkAdministracaoUsuario($usuario);
                $em->persist($permissao);
            }

            $em->flush();

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.grupoCreditoPermissao.sucesso'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
        }
        $this->forceRedirect("/tributario/arrecadacao/grupo-credito/definir-permissao/create");
    }
}
