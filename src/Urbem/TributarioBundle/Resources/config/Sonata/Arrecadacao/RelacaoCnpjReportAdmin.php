<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Validator\Constraints\Date;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class RelacaoCnpjReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_relatorio_relacao_cnpj';
    protected $baseRoutePattern = 'tributario/arrecadacao/relatorios/relacao-cnpj';
    protected $legendButtonSave = ['icon' => 'receipt', 'text' => 'Gerar'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
        $collection->add('relatorio', 'relatorio');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formMapper
            ->with('label.arrecadacao.relatorios.relacaoCnjp.titulo')
                ->add('data', 'hidden', array( 'mapped'=> false, 'data' => (new \DateTime())->format('YmdHis') ))
            ->end()
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $params = array(
            'data' => $this->getFormField($this->getForm(), 'data')
        );

        $this->forceRedirect($this->generateUrl('relatorio', $params));
    }

    /**
     * @param $form
     * @param $fieldName
     * @return string
     */
    public function getFormField($form, $fieldName)
    {
        return ($form->get($fieldName)->getData()) ? $form->get($fieldName)->getData() : '';
    }
}
