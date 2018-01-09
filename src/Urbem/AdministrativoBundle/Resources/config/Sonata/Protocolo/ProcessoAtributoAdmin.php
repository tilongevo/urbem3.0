<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Config\Definition\Exception\Exception;
use Urbem\CoreBundle\Entity\SwAssuntoAtributoValor;
use Urbem\CoreBundle\Model\SwAssuntoAtributoModel;
use Urbem\CoreBundle\Model\SwAssuntoAtributoValorModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ProcessoAtributoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_protocolo_processo_atributo';
    protected $baseRoutePattern = 'administrativo/protocolo/processo-atributo';
    protected $exibirBotaoExcluir = false;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('codAssunto')
            ->add('codClassificacao')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('codAssunto')
            ->add('codClassificacao')
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

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwProcesso');
        $processo = $em->getRepository('CoreBundle:SwProcesso')->findOneByCodProcesso($id);

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwAssuntoAtributo');
        $assuntoAtributoModel = new SwAssuntoAtributoModel($em);
        $atributos = $assuntoAtributoModel->getAtributosPorCodAssuntoECodClassificacao($processo->getCodAssunto(), $processo->getCodClassificacao());

        foreach ($atributos as $key => $atributo) {
            switch ($atributo['tipo']) {
                case 'l':
                    $valorPadrao = explode("\r\n", $atributo['valor_padrao']);

                    $choices = array();
                    foreach($valorPadrao as $valor) {
                        $choices[$valor] = $valor;
                    }

                    $formMapper->add(
                        'atributo_' . $atributo['cod_atributo'],
                        'choice',
                        array(
                            'choices' => $choices,
                            'mapped' => false,
                            'label' => $atributo['nom_atributo'],
                            'data' => isset($atributo['valor']) ? $atributo['valor'] : $atributo['valor_padrao'],
                            'required' => $atributo['obrigatorio'],
                            'attr' => array(
                                'class' => 'select2-parameters '
                            )
                        )
                    );
                    break;
                default:
                    $formMapper->add(
                        'atributo_' . $atributo['cod_atributo'],
                        'text',
                        array(
                            'mapped' => false,
                            'label' => $atributo['nom_atributo'],
                            'data' => isset($atributo['valor']) ? $atributo['valor'] : $atributo['valor_padrao'],
                            'required' => $atributo['obrigatorio']
                        )
                    );
                    break;
            }
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('codAssunto')
            ->add('codClassificacao')
        ;
    }

    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwAssuntoAtributoValor');

            $atributoValorList = $em->getRepository('CoreBundle:SwAssuntoAtributoValor')->findByCodProcesso($object->getCodProcesso());
            foreach ($atributoValorList as $atributoValor) {
                $em->remove($atributoValor);
            }

            $childrens = $this->getForm()->all();

            $i = 0;
            foreach ($childrens as $key => $children) {
                $info = explode('_', $key);
                $cod_atributo = $info[1];
                $valor = $children->getViewData();

                $swAssuntoAtributoValorModel = new SwAssuntoAtributoValorModel($em);
                $assuntoAtributoValor = new SwAssuntoAtributoValor();
                $assuntoAtributoValor->setCodAssunto($object->getCodAssunto()->getCodAssunto());
                $assuntoAtributoValor->setCodClassificacao($object->getCodClassificacao()->getCodClassificacao());
                $assuntoAtributoValor->setCodProcesso($object->getCodProcesso());
                $assuntoAtributoValor->setCodAtributo($cod_atributo);
                $assuntoAtributoValor->setExercicio($object->getAnoExercicio());
                $assuntoAtributoValor->setValor($valor);

                $swAssuntoAtributoValorModel->save($assuntoAtributoValor);

                $i++;
            }
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }

        $this->forceRedirect("/administrativo/protocolo/processo/perfil?id=" . $object);
    }
}
