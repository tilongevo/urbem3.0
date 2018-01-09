<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Organograma;

use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Model\Organograma\DeParaOrgaoModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class MigracaoOrganogramaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_administrativo_migracao_organograma';

    protected $baseRoutePattern = 'administrativo/organograma/migracao-organograma';

    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Processar'];

    protected $exibirBotaoEditar = false;

    protected $exibirBotaoExcluir = false;

    /**
     * @return string
     */
    public function getOrganogramaAtual()
    {
        return $this->organogramaAtual;
    }

    /**
     * @param string $organogramaAtual
     */
    public function setOrganogramaAtual($organogramaAtual)
    {
        $this->organogramaAtual = $organogramaAtual;
    }

    /**
     * @return string
     */
    public function getOrganogramaNovo()
    {
        return $this->organogramaNovo;
    }

    /**
     * @param string $organogramaNovo
     */
    public function setOrganogramaNovo($organogramaNovo)
    {
        $this->organogramaNovo = $organogramaNovo;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $em = $this->modelManager->getEntityManager($this->getClass());

        $organogramaModel = new OrganogramaModel($em);
        $this->checkCanMigracaoOrganograma($organogramaModel);

        // Organograma atual
        $organogramaAtual = $em->getRepository('CoreBundle:Organograma\Organograma')->findOneByAtivo(true);
        $implantacaoAtual = (!empty($organogramaAtual->getImplantacao())) ? $organogramaAtual->getImplantacao()->format("d/m/Y") : null;
        $this->setOrganogramaAtual($implantacaoAtual);

        // Organograma novo
        $deParaOrgaoModel = new DeParaOrgaoModel($em);
        $organogramaNovo = $deParaOrgaoModel->verificaMigracaoAtual();
        $implantacaoNovo = (!empty($organogramaNovo)) ? $organogramaNovo->getImplantacao()->format('d/m/Y') : null;
        $this->setOrganogramaNovo($implantacaoNovo);

        $formMapper
            ->with("Processar Migração do Organograma")
            ->add(
                'dadosOrganograma',
                'customField',
                [
                    'label' => false,
                    'mapped' => false,
                    'template' => 'AdministrativoBundle::Organograma/migracao_organograma.html.twig',
                    'data' => []
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
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $em = $this->modelManager->getEntityManager($this->getClass());

        $organogramaModel = new OrganogramaModel($em);

        $organograma = $this->getSubject();
        $orgaosNivel = $organogramaModel->getOrganogramaByCodOrganograma($organograma->getCodOrganograma());

        // Mantém redirecionamento para a home
        $this->setUrlReferer('/administrativo/');

        $showMapper
            ->with('Organograma Ativo')
            ->add('getTipoNorma', null, ['label' => 'label.organograma.codTipoNorma'])
            ->add('getNorma', null, ['label' => 'label.organograma.codNorma'])
            ->add('permissaoHierarquica', null, ['label' => 'label.organograma.permissaoHierarquica'])
            ->add('organograma', null, [
                'label' => $organograma,
                'mapped' => false,
                'template' => 'CoreBundle:Sonata/CRUD:show_custom_html.html.twig',
                'data' => $orgaosNivel
            ])
            ->end()
        ;
    }

    protected function checkCanMigracaoOrganograma(OrganogramaModel $organogramaModel)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $deParaOrgaoRepository = $em->getRepository('CoreBundle:Organograma\DeParaOrgao');
        $deParaOrgaoModel = new DeParaOrgaoModel($em);
        $organogramaNovo = $deParaOrgaoModel->verificaMigracaoAtual();
        $OrgaoDeParaIsNotNull = $deParaOrgaoRepository->findOneByCodOrgaoNew(null);

        if (!$organogramaModel->canMigracaoOrganograma() || empty($organogramaNovo) || $OrgaoDeParaIsNotNull) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', Error::INVALID_CONFIGURATION_MIGRATION_ORGANOGRAMA);

            $this->exibirBotaoSalvar = false;

            return false;
        }

        return true;
    }

    public function prePersist($organograma)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();

        $organogramaModel = new OrganogramaModel($em);

        // Confirma se processo não foi executado por alguém
        if (!$this->checkCanMigracaoOrganograma($organogramaModel)) {
            return $this->forceRedirect('/administrativo/organograma/migracao-organograma/create');
        }

        // Organograma novo
        $deParaOrgaoModel = new DeParaOrgaoModel($em);
        $organogramaNovo = $deParaOrgaoModel->verificaMigracaoAtual();

        // Usuário atual
        $currentUser = $container->get('security.token_storage')->getToken()->getUser();

        if (empty($organogramaNovo)) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_MIGRATION_NOT_FOUND);
            return $this->forceRedirect('/administrativo/organograma/migracao-organograma/create');
        } elseif ($organogramaModel->executeMigrationOrganograma($organogramaNovo, $currentUser, $this->getExercicio())) {
            $container->get('session')->getFlashBag()->add('success', 'O Processo de migração foi realizado com sucesso');
            return $this->forceRedirect(sprintf('/administrativo/organograma/migracao-organograma/%s/show', $organogramaNovo->getCodOrganograma()));
        }

        $container->get('session')->getFlashBag()->add('error', Error::ERROR_MIGRATION_ORGANOGRAMA);
        return $this->forceRedirect('/administrativo/organograma/migracao-organograma/create');
    }
}
