<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao;
use Urbem\CoreBundle\Entity\Arrecadacao\MotivoDevolucao;
use Urbem\CoreBundle\Model\Arrecadacao\CarneDevolucaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CarneDevolucaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_carne_devolucao';
    protected $baseRoutePattern = 'tributario/arrecadacao/carne-devolucao';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['numeracao'] = array(
            'label' => 'label.arrecadacaoCarneDevolucao.numeracao',
            'required' => true,
            'attr' => array(
                'class' => 'numeric '
            )
        );

        $fieldOptions['fkArrecadacaoMotivoDevolucao'] = array(
            'label' => 'label.arrecadacaoCarneDevolucao.motivo',
            'class' => MotivoDevolucao::class,
            'mapped' => true,
            'required' => true,
            'placeholder' => 'Selecione',
            'choice_label' => function (MotivoDevolucao $motivoDevolucao) {
                return sprintf('%d - %s', $motivoDevolucao->getCodMotivo(), $motivoDevolucao->getDescricao());
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $formMapper
            ->with('label.arrecadacaoCarneDevolucao.dados')
            ->add('numeracao', null, $fieldOptions['numeracao'])
            ->add('fkArrecadacaoMotivoDevolucao', 'entity', $fieldOptions['fkArrecadacaoMotivoDevolucao']);
    }

    /**
     * @param mixed $carneDevolucao
     * @throws \Exception
     */
    public function prePersist($carneDevolucao)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            $carneDevolucao->setCodMotivo($this->getForm()->get('fkArrecadacaoMotivoDevolucao')->getData()->getCodMotivo());
            $carneDevolucao->setDtDevolucao(new \DateTime());

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.arrecadacaoCarneDevolucao.msgSucesso'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            throw $e;
        }
        (new RedirectResponse($this->request->headers->get('referer')))->send();
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {

        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $dadosConvenio = (new CarneDevolucaoModel($entityManager))
            ->getConvenio($object);

        $dadosConvenio = array_shift($dadosConvenio);

        if (count($dadosConvenio)) {
            $object->setCodConvenio($dadosConvenio->cod_convenio);
        } else {
            $message = $this->getTranslator()->trans('Valor inválido. (Numeração:' . $object->getNumeracao() . ')');
            $errorElement->with('numeracao')->addViolation($message)->end();
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof CarneDevolucao
            ? $object->getNumeracao()
            : $this->getTranslator()->trans('label.arrecadacaoCarneDevolucao.modulo');
    }
}
