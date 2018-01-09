<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Entity\Frota\Manutencao;
use Urbem\CoreBundle\Entity\Frota\ManutencaoAnulacao;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Exception\Error;

class ManutencaoAnulacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_manutencao_anulacao';
    protected $baseRoutePattern = 'patrimonial/frota/manutencao-anulacao';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $codManutencao = $this->getRequest()->get('codManutencao');
        $exercicio = $this->getRequest()->get('exercicio');

        $formMapper
            ->add(
                'codManutencao',
                'hidden',
                [
                    'data' => $codManutencao
                ]
            )
            ->add(
                'exercicio',
                'hidden',
                [
                    'data' => $exercicio
                ]
            )
            ->add(
                'observacao',
                'textarea',
                [
                    'label' => 'label.frotaManutencaoAnulacao.observacoes'
                ]
            )
        ;
    }
    /**
     * Função para Persistência/Manutenção de Dados
     *
     * @param  ManutencaoAnulacao $object
     * @param  Form $form
     */
    public function saveRelationships($object, $form)
    {
        // Setar fkFrotaManutencaoManutencaoAnulacao
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager('CoreBundle:Frota\Manutencao');
        $manutencao = $em->getRepository('CoreBundle:Frota\Manutencao')->findOneBy([
            'codManutencao' => $form->get('codManutencao')->getData(),
            'exercicio' => $form->get('exercicio')->getData()
        ]);

        $object->setFkFrotaManutencao($manutencao);
    }

    /**
     * @param ManutencaoAnulacao $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
//            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
//            $this->forceRedirect('/patrimonial/frota/manutencao-anulacao/create');
            throw $e;
        }
    }

    /**
     * @param ManutencaoAnulacao $object
     */
    public function redirect($object)
    {
        $this->forceRedirect(
            "/patrimonial/frota/manutencao/list"
        );
    }

    /**
     * @param ManutencaoAnulacao $object
     */
    public function postPersist($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        // Remove Efetivacao
        foreach ($object->getFkFrotaManutencao()->getFkFrotaEfetivacoes() as $efetivacao) {
            $em->remove($efetivacao);
        }
        $em->flush();

        $this->redirect($object);
    }
}
