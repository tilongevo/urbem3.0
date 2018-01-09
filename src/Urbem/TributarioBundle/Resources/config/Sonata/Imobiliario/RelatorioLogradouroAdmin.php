<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwPais;
use Urbem\CoreBundle\Entity\SwTipoLogradouro;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class RelatorioLogradouroAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_relatorio_logradouro';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/relatorios/logradouros';
    protected $legendButtonSave = array('icon' => 'description', 'text' => 'Gerar Relatório');
    protected $includeJs = array(
        '/tributario/javascripts/imobiliario/relatorio-logradouro.js'
    );

    const NAO_INFORMADO = 0;
    const ORD_COD_LOGRADOURO = 'cod_logradouro';
    const ORD_NOM_LOGRADOURO = 'nom_logradouro';

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

        $fieldOptions['fkSwTipoLogradouro'] = [
            'label' => 'label.imobiliarioRelatorios.logradouros.tipoLogradouro',
            'class' => SwTipoLogradouro::class,
            'placeholder' => 'label.selecione',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->andWhere('o.codTipo != :naoInformado')
                    ->setParameter('naoInformado', self::NAO_INFORMADO)
                    ->orderBy('o.nomTipo', 'ASC');
            },
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['nomLogradouro'] = [
            'label' => 'label.imobiliarioRelatorios.logradouros.nomLogradouro',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['codLogradouroDe'] = [
            'label' => 'label.imobiliarioRelatorios.logradouros.de',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['codLogradouroAte'] = [
            'label' => 'label.imobiliarioRelatorios.logradouros.ate',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['nomBairro'] = [
            'label' => 'label.imobiliarioRelatorios.logradouros.nomBairro',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['codBairroDe'] = [
            'label' => 'label.imobiliarioRelatorios.logradouros.de',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['codBairroAte'] = [
            'label' => 'label.imobiliarioRelatorios.logradouros.ate',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['cepDe'] = [
            'label' => 'label.imobiliarioRelatorios.logradouros.de',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['cepAte'] = [
            'label' => 'label.imobiliarioRelatorios.logradouros.ate',
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['fkSwUf'] = [
            'label' => 'label.imobiliarioRelatorios.logradouros.estado',
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
            'label' => 'label.imobiliarioRelatorios.logradouros.municipio',
            'placeholder' => 'label.selecione',
            'choices' => array(),
            'mapped' => false,
            'required' => false
        ];

        $ordenacoes = [
            self::ORD_COD_LOGRADOURO => 'label.imobiliarioRelatorios.logradouros.codLogradouro',
            self::ORD_NOM_LOGRADOURO => 'label.imobiliarioRelatorios.logradouros.nomLogradouro'
        ];

        $fieldOptions['ordenacao'] = [
            'label' => 'label.imobiliarioRelatorios.logradouros.ordenacao',
            'placeholder' => 'label.selecione',
            'choices' => array_flip($ordenacoes),
            'data' => self::ORD_COD_LOGRADOURO,
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['mostrarHistoricoLogradouro'] = [
            'label' => 'label.imobiliarioRelatorios.logradouros.mostrarHistoricoLogradouro',
            'placeholder' => 'label.selecione',
            'choices' => array_flip([
                true => 'label_type_yes',
                false => 'label_type_no'
            ]),
            'data' => false,
            'expanded' => true,
            'mapped' => false,
            'required' => true,
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            )
        ];

        $fieldOptions['demonstrarNormaLogradouro'] = [
            'label' => 'label.imobiliarioRelatorios.logradouros.demonstrarNormaLogradouro',
            'placeholder' => 'label.selecione',
            'choices' => array_flip([
                true => 'label_type_yes',
                false => 'label_type_no'
            ]),
            'data' => false,
            'expanded' => true,
            'mapped' => false,
            'required' => true,
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            )
        ];

        $formMapper
            ->with('label.imobiliarioRelatorios.logradouros.dados')
            ->add('fkSwTipoLogradouro', 'entity', $fieldOptions['fkSwTipoLogradouro'])
            ->add('fkSwUf', 'entity', $fieldOptions['fkSwUf'])
            ->add('fkSwMunicipio', 'choice', $fieldOptions['fkSwMunicipio'])
            ->add('ordenacao', 'choice', $fieldOptions['ordenacao'])
            ->add('mostrarHistoricoLogradouro', 'choice', $fieldOptions['mostrarHistoricoLogradouro'])
            ->add('demonstrarNormaLogradouro', 'choice', $fieldOptions['demonstrarNormaLogradouro'])
            ->end()
            ->with('label.imobiliarioRelatorios.logradouros.codLogradouro')
            ->add('codLogradouroDe', 'text', $fieldOptions['codLogradouroDe'])
            ->add('codLogradouroAte', 'text', $fieldOptions['codLogradouroAte'])
            ->add('nomLogradouro', 'text', $fieldOptions['nomLogradouro'])
            ->end()
            ->with('label.imobiliarioRelatorios.logradouros.codBairro')
            ->add('codBairroDe', 'text', $fieldOptions['codBairroDe'])
            ->add('codBairroAte', 'text', $fieldOptions['codBairroAte'])
            ->add('nomBairro', 'text', $fieldOptions['nomBairro'])
            ->end()
            ->with('label.imobiliarioRelatorios.logradouros.cep')
            ->add('cepDe', 'text', $fieldOptions['cepDe'])
            ->add('cepAte', 'text', $fieldOptions['cepAte'])
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
                            'label' => 'label.imobiliarioRelatorios.logradouros.municipio',
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
            'codMunicipio' => ($this->getForm()->get('fkSwMunicipio')->getData()) ? $this->getForm()->get('fkSwMunicipio')->getData()->getCodMunicipio() : '',
            'codUf' => ($this->getForm()->get('fkSwUf')->getData()) ? $this->getForm()->get('fkSwUf')->getData()->getCodUf() : '',
            'codTipo' => ($this->getForm()->get('fkSwTipoLogradouro')->getData()) ? $this->getForm()->get('fkSwTipoLogradouro')->getData()->getCodTipo() : '',
            'nomBairro' => $this->getFormField($this->getForm(), 'nomBairro'),
            'nomLogradouro' => $this->getFormField($this->getForm(), 'nomLogradouro'),
            'codLogradouroDe' => $this->getFormField($this->getForm(), 'codLogradouroDe'),
            'codLogradouroAte' => $this->getFormField($this->getForm(), 'codLogradouroAte'),
            'codBairroDe' => $this->getFormField($this->getForm(), 'codBairroDe'),
            'codBairroAte' => $this->getFormField($this->getForm(), 'codBairroAte'),
            'cepDe' => $this->getFormField($this->getForm(), 'cepDe'),
            'cepAte' => $this->getFormField($this->getForm(), 'cepAte'),
            'ordenacao' => $this->getFormField($this->getForm(), 'ordenacao'),
            'demonstrarNormaLogradouro' => $this->getFormField($this->getForm(), 'demonstrarNormaLogradouro')
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
