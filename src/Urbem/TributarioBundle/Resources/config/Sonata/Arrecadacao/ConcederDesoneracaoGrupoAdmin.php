<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Arrecadacao\DesoneracaoModel;
use Urbem\CoreBundle\Model\Monetario\AcrescimoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class ConcederDesoneracaoGrupoAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao
 */
class ConcederDesoneracaoGrupoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_desoneracao_conceder_desoneracao_grupo';
    protected $baseRoutePattern = 'tributario/arrecadacao/desoneracao/conceder-desoneracao-grupo';

    const VINCULAR_INSCRICAO_ECONOMICA = 'IE';
    const VINCULAR_INSCRICAO_IMOBILIARIA = 'II';

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

        $fieldOptions['fkArrecadacaoDesoneracao'] = array(
            'class' => Desoneracao::class,
            'label' => 'label.concederDesoneracao.desoneracao',
            'required' => true,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $fieldOptions['funcao'] = array(
            'label' => 'label.concederDesoneracao.regraConcessao',
            'class' => Funcao::class,
            'required' => true,
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'choice_value' => function (Funcao $funcao = null) {
                if (null === $funcao) {
                    return false;
                }
                return sprintf('%s.%s.%s', $funcao->getCodModulo(), $funcao->getCodBiblioteca(), $funcao->getCodFuncao());
            },
            'query_builder' => function (EntityRepository $repo) {
                $qb = $repo->createQueryBuilder('f')
                    ->where('f.codModulo = :codModulo')
                    ->andWhere('f.codBiblioteca = :codBiblioteca')
                    ->setParameter('codModulo', ConfiguracaoModel::MODULO_TRIBUTARIO_ARRECADACAO)
                    ->setParameter('codBiblioteca', AcrescimoModel::BIBLIOTECA_ORIGEM);
                return $qb;
            },
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $fieldOptions['vincularDesoneracao'] = array(
            'label' => 'label.concederDesoneracao.vincularDesoneracao',
            'mapped' => false,
            'choices' => array(
                'label.concederDesoneracao.inscricaoImobiliaria' => $this::VINCULAR_INSCRICAO_IMOBILIARIA,
                'label.concederDesoneracao.inscricaoEconomica' => $this::VINCULAR_INSCRICAO_ECONOMICA
            ),
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione'
        );

        $formMapper
            ->with('label.concederDesoneracao.dados')
            ->add('fkArrecadacaoDesoneracao', EntityType::class, $fieldOptions['fkArrecadacaoDesoneracao'])
            ->add('funcao', EntityType::class, $fieldOptions['funcao'])
            ->add('vincularDesoneracao', ChoiceType::class, $fieldOptions['vincularDesoneracao'])
            ->end()
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();

        try {
            $fkArrecadacaoDesoneracao = $this->getForm()->get('fkArrecadacaoDesoneracao')->getdata();
            $funcao = $this->getForm()->get('funcao')->getdata();
            $vincularDesoneracao = $this->getForm()->get('vincularDesoneracao')->getdata();

            if (!empty($fkArrecadacaoDesoneracao) && !empty($funcao) && !empty($vincularDesoneracao)) {
                $params = array(
                    'codDesoneracao' => $fkArrecadacaoDesoneracao->getCodDesoneracao(),
                    'nomeFuncao' => $funcao->getNomFuncao(),
                    'tipoVinculo' => $vincularDesoneracao,
                );

                try {
                    $desoneracaoModel = new DesoneracaoModel($em);
                    $total = $desoneracaoModel->concederDesoneracaoGrupo($params);
                    $total = array_shift($total);

                    $container->get('session')->getFlashBag()->add(
                        'success',
                        $this->getTranslator()->trans(
                            'label.concederDesoneracao.sucessoGrupo',
                            array('%total%' => $total->fn_conceder_desoneracao_grupo)
                        )
                    );
                } catch (UniqueConstraintViolationException $e) {
                    $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.concederDesoneracao.erroGrupo'));
                }
            }
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
        }

        $this->forceRedirect("/tributario/arrecadacao/desoneracao/conceder-desoneracao-grupo/create");
    }
}
