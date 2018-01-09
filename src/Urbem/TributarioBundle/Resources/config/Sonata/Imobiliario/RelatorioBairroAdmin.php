<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwPais;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class RelatorioBairroAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_relatorio_bairro';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/relatorios/bairros';
    protected $legendButtonSave = array('icon' => 'description', 'text' => 'Gerar Relatório');
    protected $includeJs = array(
        '/tributario/javascripts/imobiliario/relatorio-bairro.js'
    );

    const NAO_INFORMADO = 0;
    const ORD_CODIGO = 'codigo';
    const ORD_ESTADO = 'uf';
    const ORD_MUNICIPIO = 'municipio';
    const ORD_BAIRRO = 'bairro';

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
        $collection->add('relatorio', 'relatorio');
        $collection->add('consultar_municipio', 'municipio');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();

        $fieldOptions['nomBairro'] = [
            'label' => 'label.imobiliarioRelatorios.bairros.nomBairro',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['codBairroDe'] = [
            'label' => 'label.imobiliarioRelatorios.bairros.bairroDe',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['codBairroAte'] = [
            'label' => 'label.imobiliarioRelatorios.bairros.bairroAte',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['fkSwUf'] = [
            'label' => 'label.imobiliarioRelatorios.bairros.estado',
            'class' => SwUf::class,
            'choice_label' => 'nomUf',
            'placeholder' => 'label.selecione',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->andWhere('o.codUf != :naoInformado')
                    ->andWhere('o.codPais = :codBrasil')
                    ->setParameter('naoInformado', self::NAO_INFORMADO)
                    ->setParameter('codBrasil', SwPais::COD_BRASIL)
                    ->orderBy('o.nomUf', 'ASC');
            },
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['fkSwMunicipio'] = [
            'label' => 'label.imobiliarioRelatorios.bairros.municipio',
            'placeholder' => 'label.selecione',
            'choices' => array(),
            'mapped' => false,
            'required' => false
        ];

        $ordenacoes = [
            self::ORD_CODIGO => 'label.imobiliarioRelatorios.bairros.codigo',
            self::ORD_ESTADO => 'label.imobiliarioRelatorios.bairros.estado',
            self::ORD_MUNICIPIO => 'label.imobiliarioRelatorios.bairros.municipio',
            self::ORD_BAIRRO => 'label.imobiliarioRelatorios.bairros.bairro'
        ];

        $fieldOptions['ordenacao'] = [
            'label' => 'label.imobiliarioRelatorios.bairros.ordenacao',
            'placeholder' => 'label.selecione',
            'choices' => array_flip($ordenacoes),
            'data' => self::ORD_CODIGO,
            'mapped' => false,
            'required' => true
        ];

        $formMapper
            ->with('label.imobiliarioRelatorios.bairros.titulo')
                ->add('nomBairro', 'text', $fieldOptions['nomBairro'])
                ->add('codBairroDe', 'number', $fieldOptions['codBairroDe'])
                ->add('codBairroAte', 'number', $fieldOptions['codBairroAte'])
            ->end()
            ->with(' ')
                ->add('fkSwUf', 'entity', $fieldOptions['fkSwUf'])
                ->add('fkSwMunicipio', 'choice', $fieldOptions['fkSwMunicipio'])
                ->add('ordenacao', 'choice', $fieldOptions['ordenacao'])
            ->end()
        ;

        $admin = $this;

        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);

                if ($form->has('fkSwMunicipio')) {
                    $form->remove('fkSwMunicipio');
                }

                if (isset($data['fkSwUf'])) {
                    $fkSwMunicipio = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'fkSwMunicipio',
                        'entity',
                        null,
                        array(
                            'class' => SwMunicipio::class,
                            'label' => 'label.imobiliarioRelatorios.bairros.municipio',
                            'choice_value' => 'codMunicipio',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'query_builder' => function (EntityRepository $er) use ($data) {
                                return $er->createQueryBuilder('o')
                                    ->where('o.codUf = :codUf')
                                    ->setParameter('codUf', (int) $data['fkSwUf']);
                            },
                            'placeholder' => 'label.selecione'
                        )
                    );
                    $form->add($fkSwMunicipio);
                }
            }
        );
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $params = [
            'nomBairro' => $this->getFormField($this->getForm(), 'nomBairro'),
            'codBairroDe' => $this->getFormField($this->getForm(), 'codBairroDe'),
            'codBairroAte' => $this->getFormField($this->getForm(), 'codBairroAte'),
            'codUf' => ($this->getForm()->get('fkSwUf')->getData()) ? $this->getForm()->get('fkSwUf')->getData()->getCodUf() : '',
            'codMunicipio' => ($this->getForm()->get('fkSwMunicipio')->getData()) ? $this->getForm()->get('fkSwMunicipio')->getData()->getCodMunicipio() : '',
            'ordenacao' => $this->getFormField($this->getForm(), 'ordenacao'),
        ];

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
