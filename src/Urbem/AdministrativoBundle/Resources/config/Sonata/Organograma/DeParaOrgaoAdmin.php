<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Organograma;

use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Entity\Organograma\VwOrgaoNivelView;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class DeParaOrgaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_administrativo_organograma_de_para_orgao';

    protected $baseRoutePattern = 'administrativo/organograma/configurar-migracao-organograma/config';

    protected $exibirBotaoIncluir = false;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->remove('show');
        $collection->remove('delete');
    }

    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                $this->forceRedirect('/administrativo/organograma/configurar-migracao-organograma/create');
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getObject($id)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();

        // Organograma atual
        $object = $this->searchOrganogramaAtual($id);

        if (!$object) {
            $container->get('session')->getFlashBag()->add('error', 'É necessário ter no mínimo um órgão no novo organograma');
            $this->forceRedirect('/administrativo/organograma/configurar-migracao-organograma/create');
        }

        return $object;
    }

    protected function searchOrganogramaAtual($id)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        // Organograma atual
        $object = $em->getRepository(VwOrgaoNivelView::class);
        if ($this->request->getMethod() == 'POST') {
            return $object->findOneByCodOrgao($id);
        }

        return $object->findOneByCodOrganograma($id);
    }

    public function getDescricao($codOrgao)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();

        /** @var Orgao $orgao */
        $orgao = $modelManager->find(Orgao::class, $codOrgao);

        return $orgao->getFkOrganogramaOrgaoDescricoes()->current()->getDescricao();
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        // Mantém redirecionamento para a home
        $this->setUrlReferer('/administrativo/organograma/configurar-migracao-organograma/create');

        $organogramaRepository = $em->getRepository('CoreBundle:Organograma\Organograma');
        $orgaoRepository = $em->getRepository('CoreBundle:Organograma\Orgao');
        $organogramaViewRepository = $em->getRepository('CoreBundle:Organograma\VwOrgaoNivelView');

        // Organograma atual
        $organogramaAtual = $organogramaRepository->findOneByAtivo(true);

        if ($this->request->getMethod() == 'POST') {
            $codOrganograma = $this->searchOrganogramaAtual($id)->getCodOrganograma();
        } else {
            $codOrganograma = $id;
        }

        // Organograma novo
        $organogramaNovo = $organogramaRepository->findOneByCodOrganograma($codOrganograma);

        // Órgãos do organograma atual
        $orgaosOrganogramaAtual = $orgaoRepository->findOrgaosDePara(
            ["n.cod_organograma = {$organogramaAtual->getCodOrganograma()}"],
            "ORDER BY orgao ASC"
        );

        // Órgãos do organograma novo
        $orgaosOrganogramaNovo = $organogramaViewRepository->findBy(
            ['codOrganograma' => $organogramaNovo->getCodOrganograma()],
            ['orgao' => 'ASC']
        );

        $formMapper
            ->with('label.deParaOrgao.modulo')
            ->add(
                'formDePara',
                'customField',
                [
                    'label' => false,
                    'mapped' => false,
                    'template' => 'AdministrativoBundle:Organograma/DeParaOrgao:formDePara.html.twig',
                    'data' => [
                        'organogramaAtual' => $organogramaAtual,
                        'organogramaNovo' => $organogramaNovo,
                        'listOrgaosOrganogramaAtual' => $orgaosOrganogramaAtual,
                        'listOrgaosOrganogramaNovo' => $orgaosOrganogramaNovo,
                    ]
                ]
            )
            ->end()
        ;
    }

    public function preUpdate($object)
    {
        $orgaosDePara = $this->request->request->get("orgao_de_para");
        $em = $this->modelManager->getEntityManager($this->getClass());
        $deParaOrgaoRepository = $em->getRepository('CoreBundle:Organograma\DeParaOrgao');
        $orgaoRepository = $em->getRepository('CoreBundle:Organograma\Orgao');

        foreach ($orgaosDePara as $dePara) {
            list($codOrganograma, $codOrgaoFrom, $codOrgaoTo) = explode("~", $dePara);

            $itemDePara = $deParaOrgaoRepository->findOneBy(
                ['codOrganograma' => $codOrganograma, 'codOrgao' => $codOrgaoFrom]
            );

            $newOrgao = $orgaoRepository->findOneByCodOrgao($codOrgaoTo);
            if ($itemDePara) {
                $itemDePara->setFkOrganogramaOrgao1($newOrgao);
            }

            $em->merge($itemDePara);
        }

        $em->flush();
        // Após salvar envia novamente para página de edição usando o código do organograma
        $this->forceRedirect(sprintf('/administrativo/organograma/configurar-migracao-organograma/config/%s/edit', $object->getCodOrganograma()));
    }
}
