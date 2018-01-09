<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Monetario\Credito;
use Urbem\CoreBundle\Model\Administracao\BibliotecaModel;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Arrecadacao\ParametroCalculoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class DefinirParametrosAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao
 */
class DefinirParametrosAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_calculo_definir_parametros';
    protected $baseRoutePattern = 'tributario/arrecadacao/calculo/definir-parametros';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();

        $fieldOptions['fkMonetarioCredito'] = array(
            'class' => Credito::class,
            'label' => 'label.definirDesoneracao.credito',
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $fieldOptions['fkAdministracaoFuncao'] = array(
            'label' => 'label.calculoDefinirParametros.formulaCalculo',
            'class' => Funcao::class,
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'query_builder' => function (EntityRepository $repo) {
                $qb = $repo->createQueryBuilder('f')
                    ->where('f.codModulo = :codModulo')
                    ->andWhere('f.codBiblioteca = :codBiblioteca')
                    ->setParameter('codModulo', ConfiguracaoModel::MODULO_TRIBUTARIO_ARRECADACAO)
                    ->setParameter('codBiblioteca', BibliotecaModel::MODULO_ARRECADACAO_FORMULA_DESONERACAO);
                return $qb;
            },
        );

        $fieldOptions['valorCorrespondente'] = array(
            'label' => 'label.calculoDefinirParametros.valorCorrespondente',
            'choices' => array(
                'label.calculoDefinirParametros.venalPredial' => 'venal_predial',
                'label.calculoDefinirParametros.venalTerreno' => 'venal_terreno',
            ),
            'placeholder' => 'label.selecione',
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $formMapper
            ->with('label.calculoDefinirParametros.dados')
                ->add('fkMonetarioCredito', EntityType::class, $fieldOptions['fkMonetarioCredito'])
                ->add('fkAdministracaoFuncao', EntityType::class, $fieldOptions['fkAdministracaoFuncao'])
                ->add('valorCorrespondente', ChoiceType::class, $fieldOptions['valorCorrespondente'])
            ->end()
        ;
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            // set ocorrencia credito
            $em = $this->modelManager->getEntityManager($this->getClass());
            $parametroCalculoModel = new ParametroCalculoModel($em);

            $params = array(
                'cod_credito' => $object->getCodCredito(),
                'cod_especie' => $object->getCodEspecie(),
                'cod_natureza' => $object->getCodNatureza(),
                'cod_genero' => $object->getCodGenero()
            );

            $codTabela = $parametroCalculoModel->getNextVal($params);

            $object->setOcorrenciaCredito($codTabela);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            throw $e;
        }

        $this->forceRedirect("/tributario/arrecadacao/calculo/definir-parametros/create");
    }
}
