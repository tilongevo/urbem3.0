<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Config\Definition\Exception\Exception;
use Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Administracao\CadastroModel;
use Urbem\CoreBundle\Model\Administracao\ModuloModel;
use Urbem\CoreBundle\Model\Pessoal\AtributoContratoServidorValorModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class RHServidorAtributoDinamicoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_servidor_atributo';

    protected $baseRoutePattern = 'recursos-humanos/pessoal/servidor/atributo';

    const MODULO_PESSOAL = 'Pessoal';

    const CADASTRO_SERVIDOR = 'Cadastro de servidor';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('codAtributo')
            ->add('naoNulo')
            ->add('nomAtributo')
            ->add('valorPadrao')
            ->add('ajuda')
            ->add('mascara')
            ->add('ativo')
            ->add('interno')
            ->add('indexavel')
            ->add('codAtributoAnterior')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('codAtributo')
            ->add('naoNulo')
            ->add('nomAtributo')
            ->add('valorPadrao')
            ->add('ajuda')
            ->add('mascara')
            ->add('ativo')
            ->add('interno')
            ->add('indexavel')
            ->add('codAtributoAnterior')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if ($this->getRequest()->isMethod('GET')) {
            $cod_contrato = $this->getAdminRequestId();
        } else {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $cod_contrato = $formData['codContrato'];
        }

        $info = array (
            'cod_modulo' => self::MODULO_PESSOAL,
            'cod_cadastro' => self::CADASTRO_SERVIDOR,
            'cod_contrato' => $cod_contrato
        );

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\AtributoDinamico');
        $atributoDinamicoModel = new AtributoDinamicoModel($em);
        $atributos = $atributoDinamicoModel->getAtributosDinamicosPorModuloeCadastroeContrato($info);

        if (empty($atributos)) {
            $atributos = $atributoDinamicoModel->getAtributosDinamicosPorModuloeCadastro($info);
        }

        $formMapper->add(
            'codContrato',
            'hidden',
            [
                'mapped' => true,
                'required' => false,
                'data' => $cod_contrato
            ]
        );

        foreach ($atributos as $key => $atributo) {
            if ($atributo['nom_tipo'] == 'Data') {
                $formMapper
                    ->add(
                        "atributo_" . $atributo['cod_atributo'],
                        'sonata_type_date_picker',
                        [
                            'mapped' => false,
                            'dp_default_date' => isset($atributo['valor']) ? $atributo['valor'] : null,
                            'format' => 'dd/MM/yyyy',
                            'label' => $atributo['nom_atributo'],
                            'required' => $atributo['nao_nulo']
                        ]
                    );
            } else {
                $formMapper->add(
                    "atributo_" . $atributo['cod_atributo'],
                    'text',
                    [
                        'mapped' => false,
                        'label' => $atributo['nom_atributo'],
                        'data' => isset($atributo['valor']) ? $atributo['valor'] : null,
                        'required' => $atributo['nao_nulo']
                    ]
                );
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
            ->add('codAtributo')
            ->add('naoNulo')
            ->add('nomAtributo')
            ->add('valorPadrao')
            ->add('ajuda')
            ->add('mascara')
            ->add('ativo')
            ->add('interno')
            ->add('indexavel')
            ->add('codAtributoAnterior')
        ;
    }

    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Pessoal\AtributoContratoServidorValor');
            $contratoServidorModel = new ContratoServidorModel($em);
            $contratoServidor = $contratoServidorModel->findOneByCodContrato($object->getCodContrato());

            $childrens = $this->getForm()->all();

            $em_c = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Cadastro');
            $cadastroModel = new CadastroModel($em_c);
            $codCadastro = $cadastroModel->findOneBynomCadastro(self::CADASTRO_SERVIDOR);

            $em_m = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Modulo');
            $moduloModel = new ModuloModel($em_m);
            $codModulo = $moduloModel->findOneBynomModulo(self::MODULO_PESSOAL);

            $i = 0;
            foreach ($childrens as $key => $children) {
                if ($i == 0) {
                    $i++;
                    continue;
                }

                $info = explode('_', $key);
                $cod_atributo = $info[1];
                $valor = $children->getViewData();

                $atributoContratoServidorValorModel = new AtributoContratoServidorValorModel($em);
                $atributoContratoServidorValor = new AtributoContratoServidorValor();
                $atributoContratoServidorValor->setCodModulo($codModulo->getCodModulo());
                $atributoContratoServidorValor->setCodCadastro($codCadastro->getCodCadastro());
                $atributoContratoServidorValor->setCodAtributo($cod_atributo);
                $atributoContratoServidorValor->setValor($valor);
                $atributoContratoServidorValor->setCodContrato($contratoServidor);


                $atributoContratoServidorValorModel->save($atributoContratoServidorValor);

                $i++;
            }
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }

        $this->forceRedirect();
    }
}
