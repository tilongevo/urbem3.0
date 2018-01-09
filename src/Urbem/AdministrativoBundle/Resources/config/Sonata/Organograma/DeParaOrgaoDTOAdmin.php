<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Organograma;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;

class DeParaOrgaoDTOAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_administrativo_organograma_de_para_orgao_dto';

    protected $baseRoutePattern = 'administrativo/organograma/configurar-migracao-organograma';

    protected $botaoCustomizado = 'Nova Migração';

    protected $includeJs = array(
        '/administrativo/javascripts/organograma/configurar-migracao-organograma.js'
    );

    /**
     * @return string
     */
    public function getBotaoCustomizado()
    {
        return $this->botaoCustomizado;
    }

    /**
     * @param string $botaoCustomizado
     */
    public function setBotaoCustomizado($botaoCustomizado)
    {
        $this->botaoCustomizado = $botaoCustomizado;
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'edit':
                return 'AdministrativoBundle:Organograma\DeParaOrgao:edit_form.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();

        // Organograma atual
        $organogramaAtual = $em->getRepository('CoreBundle:Organograma\Organograma')->findOneByAtivo(true);

        // Novo Organograma
        $organogramaNovo = $object->getCodOrganograma();

        // Se tiver um organograma em processo de migração, o formulário não enviará dados, portanto, precisamos recuperar tal informação
        if (!$organogramaNovo) {
            $deParaOrgaoModel = new Model\Organograma\DeParaOrgaoModel($em);
            $organogramaNovo = $deParaOrgaoModel->verificaMigracaoAtual();
        }

        // Se novo organograma não tiver órgão, veta processo
        $orgaosNovoOrganograma = $em->getRepository('CoreBundle:Organograma\VwOrgaoNivelView')->findByCodOrganograma($organogramaNovo->getCodOrganograma());

        if (!count($orgaosNovoOrganograma)) {
            $container->get('session')->getFlashBag()->add('error', 'É necessário ter no mínimo um órgão no novo organograma');
            $this->forceRedirect('/administrativo/organograma/configurar-migracao-organograma/create');
        }

        $deParaModel = new Model\Organograma\DeParaOrgaoModel($em);
        if (!$deParaModel->copiarOrgaosParaNovoOrganograma($organogramaAtual, $organogramaNovo)) {
            $container->get('session')->getFlashBag()->add('error', 'Falha ao processar migração do organograma');
            $this->forceRedirect('/administrativo/organograma/configurar-migracao-organograma/create');
        }

        $this->forceRedirect(sprintf('/administrativo/organograma/configurar-migracao-organograma/config/%s/edit', $organogramaNovo->getCodOrganograma()));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setUrlReferer($this->request->headers->get('referer'));

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $em = $this->modelManager->getEntityManager($this->getClass());
        $deParaOrgaoModel = new Model\Organograma\DeParaOrgaoModel($em);

        $organogramaNovo = $deParaOrgaoModel->verificaMigracaoAtual();

        // Mantém redirecionamento para a home
        $this->setUrlReferer('/administrativo/');

        /**
         * Verificar se já existe uma migração em andamento
         */
        if ($organogramaNovo) {
            $this->setBotaoCustomizado('Continuar Migração');
        }

        $organogramaAtual = $em->getRepository('CoreBundle:Organograma\Organograma')->findOneByAtivo(true);
        $dtAtual = $organogramaAtual->getImplantacao()->format('Y-m-d');

        $formMapper
            ->with('label.deParaOrgao.modulo')
            ->add('codOrganogramaAtual', 'entity', [
                'class' => 'CoreBundle:Organograma\Organograma',
                'label' => 'label.deParaOrgao.organogramaAtual',
                'required' => true,
                'mapped' => false,
                'disabled' => true,
                'query_builder' => function ($em) {
                    $qb = $em->createQueryBuilder('o');
                    $qb->where('o.ativo = :ativo');
                    $qb->setParameter('ativo', true);
                    return $qb;
                }
            ])
            ->add(
                'codOrganograma',
                null,
                [
                    'label' => 'label.deParaOrgao.organogramaNovo',
                    'placeholder' => 'label.selecione',
                    'required' => true,
                    'disabled' => ($organogramaNovo) ? true : false,
                    'mapped' => ($organogramaNovo) ? false : true,
                    'data' => $organogramaNovo,
                    'query_builder' => function ($em) use ($dtAtual) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.ativo = :ativo');
                        $qb->andWhere('o.implantacao > :dtAtual');
                        $qb->setParameters([
                            'ativo' => false,
                            'dtAtual' => $dtAtual
                        ]);
                        return $qb;
                    }
                ],
                [
                    'admin_code' => 'administrativo.admin.de_para_orgao_dto'
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
        $showMapper
            ->add('codDeParaOrgao')
        ;
    }
}
