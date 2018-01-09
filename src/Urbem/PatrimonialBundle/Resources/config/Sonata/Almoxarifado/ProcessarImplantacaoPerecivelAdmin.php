<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoPerecivel;
use Urbem\CoreBundle\Entity\Almoxarifado\Perecivel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ProcessarImplantacaoPerecivelAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_processar_implantacao_perecivel';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/processar-implantacao-perecivel';


    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('edit');
    }


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->forceRedirect('/patrimonial/almoxarifado/processar-implantacao/create');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->forceRedirect('/patrimonial/almoxarifado/processar-implantacao/create');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $this->setBreadCrumb();
        $formMapper
            ->add(
                'idLancamentoMaterial',
                'hidden',
                [
                    'data' => $this->getRequest()->query->get('id'),
                    'mapped' => false,
                ]
            )
            ->add(
                'lote',
                'text',
                [
                    'mapped' => false,
                    'label' => 'label.patrimonial.almoxarifado.implantacao.lote',
                ]
            )
            ->add(
                'dtFabricacao',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'mapped' => false,
                    'label' => 'label.patrimonial.almoxarifado.implantacao.dtFabricacao',
                ]
            )
            ->add(
                'dtValidade',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'mapped' => false,
                    'label' => 'label.patrimonial.almoxarifado.implantacao.dtValidade',
                ]
            )
            ->add(
                'quantidade',
                'integer',
                [

                    'mapped' => false,
                    'label' => 'label.patrimonial.almoxarifado.implantacao.quantidade',
                ]
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->forceRedirect('/patrimonial/almoxarifado/processar-implantacao/create');
    }

    public function validate(ErrorElement $errorElement, $lancamentoPerecivel)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $fabricacao = \DateTime::createFromFormat('d/m/Y', $formData['dtFabricacao']);
        $validade = \DateTime::createFromFormat('d/m/Y', $formData['dtValidade']);

        if ($validade < $fabricacao) {
            $message = $this->trans(
                'processar_implantacao.errors.validade_menor_fabricacao',
                [],
                'validators'
            );
            $errorElement->with('dtValidade')->addViolation($message)->end();
        }
    }

    /**
     * @param LancamentoPerecivel $object
     */
    public function prePersist($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager
            ->getEntityManager('Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial');
        $lm = $this->getLancamentoMaterial($em, $object);
        $formData = $this->getRequest()->request->get($this->getUniqid());

        $perecivel = new Perecivel();
        $perecivel
            ->setLote($formData['lote'])
            ->setCodItem($lm->getCodItem())
            ->setCodMarca($lm->getCodMarca())
            ->setCodAlmoxarifado($lm->getCodAlmoxarifado())
            ->setCodCentro($lm->getCodCentro())
            ->setDtFabricacao(\DateTime::createFromFormat('d/m/Y', $formData['dtFabricacao']))
            ->setDtValidade(\DateTime::createFromFormat('d/m/Y', $formData['dtValidade']));

        $perecivelExist = $em
            ->getRepository('CoreBundle:Almoxarifado\Perecivel')
            ->findOneBy([
                'lote' => $perecivel->getLote(),
                'codItem' => $perecivel->getCodItem(),
                'codMarca' => $perecivel->getCodMarca(),
                'codAlmoxarifado' => $perecivel->getCodAlmoxarifado(),
                'codCentro' => $perecivel->getCodCentro(),
            ]);
        if ($perecivelExist) {
            $perecivel = $perecivelExist;
        } else {
            $em->persist($perecivel);
        }

        $lancamentoMaterial = clone $lm;
        $lancamentoMaterial->setCodLancamento(
            $em
                ->getRepository('CoreBundle:Almoxarifado\LancamentoMaterial')
                ->getNextCodLancamento()
        );
        $quantidade  = $lancamentoMaterial->getQuantidade() + $formData['quantidade'];
        $lancamentoMaterial->setQuantidade($quantidade);
        $em->persist($lancamentoMaterial);

        $object->setFkAlmoxarifadoPerecivel($perecivel)
            ->setCodLancamento($lancamentoMaterial->getCodLancamento());
    }

    /**
     * @param LancamentoPerecivel $object
     */
    public function postRemove($object)
    {
        $this->forceRedirect('/patrimonial/almoxarifado/processar-implantacao/' . $this->getObjectKey($object) . '/show');
    }


    /**
     * @param LancamentoPerecivel $object
     */
    public function postPersist($object)
    {
        $this->forceRedirect('/patrimonial/almoxarifado/processar-implantacao/' . $this->getObjectKey($object) . '/show');
    }

    /**
     * @param LancamentoPerecivel $lp
     * @return array
     */
    public function getIdLancamentoMaterial(LancamentoPerecivel $lp)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        if (isset($formData['idLancamentoMaterial'])) {
            return $formData['idLancamentoMaterial'];
        }

        $lote = $lp->getFkAlmoxarifadoPerecivel();
        $id = $lp->getCodLancamento()
            . '~' . $lote->getCodItem()
            . '~' . $lote->getCodMarca()
            . '~' . $lote->getCodAlmoxarifado()
            . '~' . $lote->getCodCentro();

        return $id;
    }

    /**
     * @param EntityManager $em
     * @param LancamentoPerecivel $object
     * @return null|LancamentoMaterial
     */
    public function getLancamentoMaterial(EntityManager $em, LancamentoPerecivel $object)
    {
        $id = array_combine([
            'codLancamento',
            'codItem',
            'codMarca',
            'codAlmoxarifado',
            'codCentro',
        ], explode('~', $this->getIdLancamentoMaterial($object)));

        return $em
            ->getRepository('CoreBundle:Almoxarifado\LancamentoMaterial')
            ->find($id);
    }
}
