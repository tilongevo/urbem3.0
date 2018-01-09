<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Exception;
use Urbem\CoreBundle\Exception\Error;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model\Patrimonial\Frota\ItemModel;

/**
 * Class ManutencaoItemAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Frota
 */
class ManutencaoItemAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_manutencao_item';
    protected $baseRoutePattern = 'patrimonial/frota/manutencao-item';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();

        $codManutencao = $this->getRequest()->get('codManutencao');
        $exercicio = $this->getRequest()->get('exercicio');

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codManutencao = $formData['codManutencao'];
            $exercicio = $formData['exercicio'];
        } else {
            if ($this->getSubject()->getCodManutencao()) {
                $codManutencao = $this->getSubject()->getCodManutencao();
                $exercicio = $this->getSubject()->getExercicio();
            } else {
                $codManutencao = $this->getRequest()->query->get('codManutencao');
                $exercicio = $this->getRequest()->query->get('exercicio');
            }
        }

        $fieldOptions['codItem'] = [
            'route' => ['name' => 'carrega_frota_item'],
            'label' => 'label.frotaManutencaoItem.codItem',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'req_params' => [
                'tipoManutencaoAutorizacao' => true
            ],
            'placeholder' => 'Selecione',
            'mapped' => false
        ];

        if ($this->getSubject()->getFkFrotaItem()) {
            $fieldOptions['codItem']['data'] = $this->getSubject()->getFkFrotaItem()->getFkAlmoxarifadoCatalogoItem();
        }

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
                'fkFrotaItem',
                'autocomplete',
                $fieldOptions['codItem'],
                [ 'admin_code' => 'patrimonial.admin.item' ]
            )
            ->add(
                'quantidade',
                'number',
                [
                    'label' => 'label.frotaManutencaoItem.quantidade',
                    'attr' => [
                        'class' => 'quantity '
                    ]
                ]
            )
            ->add(
                'valor',
                'number',
                [
                    'label' => 'label.frotaManutencaoItem.vlTotal',
                    'attr' => [
                        'class' => 'money '
                    ]
                ]
            )
        ;
    }

    /**
     * Função para Persistência/Manutenção de Dados
     *
     * @param  Entity\Frota\ManutencaoItem $object
     * @param  Form $form
     */
    public function saveRelationships($object, $form)
    {
        $exercicio = $this->getExercicio();

        // Setar fkFrotaManutencao
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager('CoreBundle:Frota\Manutencao');
        $manutencao = $em->getRepository('CoreBundle:Frota\Manutencao')->findOneBy([
            'codManutencao' => $form->get('codManutencao')->getData(),
            'exercicio' => $form->get('exercicio')->getData()
        ]);

        $object->setFkFrotaManutencao($manutencao);

        if (strstr($form->get('fkFrotaItem')->getData(), '-')) {
            $codItem = explode(' - ', $form->get('fkFrotaItem')->getData());
            $codItem = $codItem[0];
        } else {
            $codItem = $form->get('fkFrotaItem')->getData();
        }

        $item = $em
            ->getRepository(Entity\Frota\Item::class)
            ->find($codItem);
        $object->setFkFrotaItem($item);
    }

    /**
     * @param Entity\Frota\ManutencaoItem $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect('/patrimonial/frota/manutencao-item/create');
        }
    }

    /**
     * @param Entity\Frota\ManutencaoItem $object
     */
    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect(
                "/patrimonial/frota/manutencao-item/{$this->getObjectKey($object)}/edit"
            );
        }
    }

    /**
     * @param Entity\Frota\ManutencaoItem $object
     */
    public function redirect($object)
    {
        $this->forceRedirect(
            "/patrimonial/frota/manutencao/{$this->getObjectKey($object->getFkFrotaManutencao())}/show"
        );
    }

    /**
     * @param Entity\Frota\ManutencaoItem $object
     */
    public function postPersist($object)
    {
        $this->redirect($object);
    }

    /**
     * @param Entity\Frota\ManutencaoItem $object
     */
    public function postUpdate($object)
    {
        $this->redirect($object);
    }

    /**
     * @param Entity\Frota\ManutencaoItem $object
     */
    public function postRemove($object)
    {
        $this->redirect($object);
    }
}
