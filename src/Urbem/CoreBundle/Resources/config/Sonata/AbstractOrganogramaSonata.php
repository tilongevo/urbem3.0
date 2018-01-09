<?php

namespace Urbem\CoreBundle\Resources\config\Sonata;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Administracao\Orgao;
use Urbem\CoreBundle\Entity\Organograma\Organograma;
use Urbem\CoreBundle\Entity\Organograma\OrgaoNivel;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Helper\StringHelper;
use Urbem\CoreBundle\Model\Administracao\UsuarioModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Classe responsável pelo apoio da construção estrutural do organograma e seus níveis
 * Classe passível e evolução, esta é a versão 1.0
 *
 * Class AbstractOrganogramaSonata
 * @package Urbem\CoreBundle\Resources\config\Sonata
 */
class AbstractOrganogramaSonata extends AbstractAdmin
{
    /**
     * @var array $includeJs
     */
    protected $includeJs = [
        '/administrativo/javascripts/organograma/estruturaDinamicaOrganograma.js'
    ];

    /**
     * @var string
     */
    protected $fieldNamePrefixJs = 'organograma-nivel-';

    /**
     * @var string
     */
    protected $fieldNamePrefix = 'nivel_organograma_';

    /**
     * @var array
     */
    protected $orgaosSelecionados = [];

    /**
     * @return array
     */
    protected function getCurrentOrgaoSelected()
    {
        $selected = null;
        foreach ($this->orgaosSelecionados as $fieldName => $value) {
            if (!$value) {
                continue;
            }
            $nivel = StringHelper::clearString($fieldName, '/\D/');
            $selected = [$nivel, $value];
        }

        return $selected;
    }

    /**
     * @return mixed
     */
    protected function getOrgaoSelected()
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        list($codNivel, $codOrgao) = $this->getCurrentOrgaoSelected();

        // Busca órgão
        return $entityManager->getRepository('CoreBundle:Organograma\OrgaoNivel')->findOneBy(
            ['codNivel' => $codNivel, 'codOrgao' => $codOrgao]
        );
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param boolean $exibeOrganogramaAtivo
     *
     * @return \Sonata\AdminBundle\Form\FormMapper $formMapper
     */
    protected function createFormOrganograma(\Sonata\AdminBundle\Form\FormMapper $formMapper, $exibeOrganogramaAtivo)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        // Organograma -> Transformar em componente
        /** @var Organograma $organograma */
        $organograma = $entityManager->getRepository('CoreBundle:Organograma\Organograma')->findOneByAtivo(true);
        $codOrganograma = $organograma->getCodOrganograma();



        if ($exibeOrganogramaAtivo) {
            $formMapper
                ->add(
                    'organogramaAtivo',
                    'text',
                    [
                        'label' => 'label.usuario.organogramaAtivo',
                        'mapped' => false,
                        'required' => false,
                        'disabled' => true,
                        'data' => (new UsuarioModel($entityManager))->getOrganogramAtivo()
                    ]
                );
        }

        $orgaoModel = new OrgaoModel($entityManager);

        // Níveis do organograma
        $onChangeNivelJs = "";
        $disableCombo = "";
        foreach ($organograma->getFkOrganogramaNiveis() as $key => $nivel) {
            $fieldName = $this->fieldNamePrefix . $nivel->getCodNivel();
            $choices = [];

            $selectedValue = null;
            if ('POST' == $this->getRequest()->getMethod()) {
                $selectedValue = $this->getSelectedValue($fieldName);
            }

            // Busca órgãos listados no primeiro nível, geralmente nível 1
            if ($key == 0 || $selectedValue) {
                $orgaos = $orgaoModel->getOrgaoSuperiorByCodNivel($codOrganograma, $key + 1);
                foreach ($orgaos as $orgao) {
                    $choices[
                        $orgao->getCodOrgao() .
                        ' - ' .
                        $orgao->getSiglaOrgao() .
                        ' - ' .
                        $orgao->getFkOrganogramaOrgaoDescricoes()->last()->getDescricao()
                    ] = $orgao->getCodOrgao();
                }
            }

            $formMapper->add(
                $fieldName,
                'choice',
                [
                    'label' => $nivel->getDescricao(),
                    'mapped' => false,
                    'required' => $key == 0 ? true : '',
                    'placeholder' => 'Selecione',
                    'data' => $selectedValue,
                    'choices' => $choices,
                    'attr' => [
                        'class' => "select2-parameters " .
                            "estrutura-organograma-dinamico " .
                            "organograma-{$codOrganograma} " .
                            "{$this->fieldNamePrefixJs}{$nivel->getCodNivel()}"
                    ],
                    'label_attr' => [
                        'class' => $key == 0 ? 'control-label required ' : ''
                    ]
                ]
            );

            //Verifica se tem um nível após o corrente
            $codNivelTo = isset($organograma->getFkOrganogramaNiveis()[$key + 1]) ?
                $organograma->getFkOrganogramaNiveis()[$key + 1]->getCodNivel() :
                null;

            // Desabilita todos os combos
            if ($key > 0) {
                $disableCombo .= "$('select.{$this->fieldNamePrefixJs}{$nivel->getCodNivel()}').select2().enable(false);";
            }

            // onChange de cada combo
            $onChangeNivelJs .= $this->createOnChangeJsBuscaOrganogramaNivel(
                $codOrganograma,
                $nivel->getCodNivel(),
                $codNivelTo
            );
        }

        $this->setScriptDynamicBlock(
            $this->getScriptDynamicBlock() . $disableCombo . $onChangeNivelJs
        );

        return $formMapper;
    }


    /**
     * @param string $fieldName
     * @return mixed|null
     */
    public function getSelectedValue($fieldName)
    {
        if ($this->getRequest()->getMethod() != 'POST') {
            return null;
        }

        $formData = (object) $this->getFormPost();
        $choices = property_exists($formData, $fieldName) ? $this->preSetPostToChoice($fieldName) : [];
        $this->orgaosSelecionados[$fieldName] = is_array($choices) ? current($choices) : $choices;

        return $this->orgaosSelecionados[$fieldName];
    }

    /**
     * @param integer $codOrganograma
     * @param integer $codNivelFrom
     * @param mixed $codNivelTo
     *
     * @return string
     */
    protected function createOnChangeJsBuscaOrganogramaNivel($codOrganograma, $codNivelFrom, $codNivelTo = null)
    {
        if (empty($codNivelTo)) {
            return '';
        }

        return <<<JS
            $("select.{$this->fieldNamePrefixJs}$codNivelFrom").on("change", function() {
                disableAnotherOrganogramaNivel($codNivelFrom);
                
                if ($(this).val()!= "") {
                    montaOrgaoListByOrganogramaNivel($codOrganograma, $(this), $("select.{$this->fieldNamePrefixJs}$codNivelTo"));
                }
        });
JS;
    }

    /**
     * @param \Urbem\CoreBundle\Entity\Organograma\OrgaoNivel $orgaoNivel
     * @return array
     */
    protected function showOrgaoByCurrentOrganograma(OrgaoNivel $orgaoNivel)
    {
        $orgaos = $this->findAllNiveisOrgaoOrganograma($orgaoNivel);
        $orgaoList = [];

        foreach ($orgaos as $orgao) {
            $orgaoList[$orgao->nivel] = sprintf("%s - %s", $orgao->orgao_reduzido, $orgao->descricao);
        }

        return $orgaoList;
    }

    /**
     * @param \Urbem\CoreBundle\Entity\Organograma\OrgaoNivel $orgaoNivel
     * @return mixed
     */
    private function findAllNiveisOrgaoOrganograma(OrgaoNivel $orgaoNivel)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $orgaoRepository = $entityManager->getRepository('CoreBundle:Organograma\Orgao');

        $listSuperiores = $orgaoRepository->getOrgaosSuperiores(
            $orgaoNivel->getCodOrgao(),
            $orgaoNivel->getCodOrganograma(),
            $orgaoNivel->getCodNivel()
        );
        ksort($listSuperiores);

        return $listSuperiores;
    }


    /**
     * @param $form
     * @return array
     */
    public function getFieldFromForm($form)
    {
        $fieldList = [];
        foreach ($form as $fieldName => $filedValue) {
            if (strpos($fieldName, $this->fieldNamePrefix) !== false) {
                $fieldList[] = [
                    'name' => $fieldName,
                    'value' => $filedValue,
                    'key' => str_replace($this->fieldNamePrefix, '', $fieldName),
                ];
            }
        }
        return $fieldList;
    }

    /**
     * @param $form
     * @return array
     */
    public function getListaOrgaosFromForm($form)
    {
        $listaOrgaos = [];
        foreach ($this->getFieldFromForm($form) as $fieldOrgao) {
            $fieldOrgao['orgao'] = $this->getOrgaoNivelByCodOrgao($fieldOrgao['value']);
            if ($fieldOrgao['orgao']) {
                $listaOrgaos[] = $fieldOrgao;
            }
        }
        return $listaOrgaos;
    }

    /**
     * @param OrgaoNivel|array $orgaoNivel
     * return void
     */
    protected function executeScriptLoadData($data)
    {
        $listaOrgaos = [];

        if (is_array($data)) {
            $listaOrgaos = $this->getListaOrgaosFromForm($data);
        }

        if ($data instanceof OrgaoNivel) {
            $listaOrgaos = [['orgao' => $data]];
        }


        $scriptDefaultOrganogramaJs = '';
        foreach ($listaOrgaos as $orgaoNivel) {
            /**
             * @TODO: Esta etapa deixa tudo mais complicado, mas não sei se é necessaria, então a mantive.
             */
            $listSuperiores = $this->findAllNiveisOrgaoOrganograma($orgaoNivel['orgao']);

            foreach ($listSuperiores as $orgao) {
                $scriptDefaultOrganogramaJs .= "window.default_organograma_nivel_{$orgao->nivel} " .
                    "= {$orgao->cod_orgao}; ";
            }

            if ($listaOrgaos[0] == $orgaoNivel) {
                // Inicia ação para selação automática de órgãos
                $primeiroNivel = array_shift($listSuperiores);
                if (!empty($primeiroNivel) && property_exists($primeiroNivel, 'nivel')) {
                    $scriptDefaultOrganogramaJs .= <<<JS
    $(document).ready(function() {
        $('select.{$this->fieldNamePrefixJs}{$primeiroNivel->nivel}').select2('val', {$primeiroNivel->cod_orgao});
        $('select.{$this->fieldNamePrefixJs}{$primeiroNivel->nivel}').trigger('change');
    });
JS;
                }
            }
        }

        // Adiciona no JS da página
        $this->setScriptDynamicBlock(
            $this->getScriptDynamicBlock() . $scriptDefaultOrganogramaJs
        );
    }

    /**
     * @param $codOrgao
     * @return mixed|OrgaoNivel
     * @throws \Exception
     */
    protected function getOrgaoNivelByCodOrgao($codOrgao)
    {
        if (!$codOrgao) {
            return null;
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $organogramaViewRepository = $entityManager->getRepository('CoreBundle:Organograma\VwOrgaoNivelView');

        $orgaoView = $organogramaViewRepository->findOneByCodOrgao($codOrgao);

        $orgaoNivel = $entityManager->getRepository('CoreBundle:Organograma\OrgaoNivel')->findOneBy([
            'codOrgao' => $orgaoView->getCodOrgao(),
            'codNivel' => $orgaoView->getNivel(),
            'codOrganograma' => $orgaoView->getCodOrganograma(),
        ]);

        if (!$orgaoNivel) {
            throw new \Exception(Error::ORGAO_NIVEL_NOT_FOUND);
        }

        return $orgaoNivel;
    }
}
