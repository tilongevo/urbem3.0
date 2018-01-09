<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Exception;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito;
use Urbem\CoreBundle\Entity\Economico\EmpresaDireitoNaturezaJuridica;
use Urbem\CoreBundle\Entity\Economico\NaturezaJuridica;
use Urbem\CoreBundle\Entity\Economico\ProcessoEmpDireitoNatJuridica;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class EmpresaDireitoNaturezaJuridicaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_empresa_direito_natureza_juridica';
    protected $baseRoutePattern = 'tributario/cadastro-economico/inscricao-economica/alterar-natureza-juridica';
    protected $includeJs = ['/tributario/javascripts/economico/empresa-direito-natureza-juridica.js'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add(
            'alterar',
            sprintf(
                '%s',
                $this->getRouterIdParameter()
            )
        );

        $routes->clearExcept(['edit', 'alterar']);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->populateObject($object);
        $this->saveObject($object, 'label.EmpresaDireitoNaturezaJuridicaAdmin.msgSucesso');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $cadastroEconomico = $this->getSubject() ?: new CadastroEconomico();
        $empresaDireito = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaDireito();

        if ($id) {
            $empresaDireitoNaturezaJuridica = $empresaDireito->getFkEconomicoEmpresaDireitoNaturezaJuridicas()->last();
            $naturezaJuridica = $empresaDireitoNaturezaJuridica->getFkEconomicoNaturezaJuridica();
        }

        $fieldOptions = [];
        $fieldOptions['naturezaJuridicaAtual'] = [
            'mapped' => false,
            'disabled' => true,
            'required' => false,
            'data' => !empty($naturezaJuridica) ? $naturezaJuridica : '',
            'label' => 'label.EmpresaDireitoNaturezaJuridicaAdmin.naturezaJuridicaAtual',
        ];

        $fieldOptions['fkEconomicoNaturezaJuridica'] = [
            'class' => NaturezaJuridica::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->where('LOWER(o.nomNatureza) LIKE :nomNatureza')
                    ->setParameter('nomNatureza', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('o.nomNatureza', 'ASC');

                return $qb;
            },
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.economicoCadastroEconomicoEmpresaDireito.naturezaJuridica',
        ];

        $fieldOptions['fkSwClassificacao'] = array(
            'class' => SwClassificacao::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters js-select-processo-classificacao'
            ),
            'label' => 'label.economicoCadastroEconomico.processoClassificacao',
        );

        $fieldOptions['fkSwAssunto'] = array(
            'class' => SwAssunto::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->orderBy('o.codAssunto', 'ASC');
            },
            'choice_value' => 'codAssunto',
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters js-select-processo-assunto'
            ),
            'label' => 'label.economicoCadastroEconomico.processoAssunto',
        );

        $fieldOptions['fkSwProcesso'] = [
            'class' => SwProcesso::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');
                $qb->innerJoin('o.fkAdministracaoUsuario', 'u');
                $qb->innerJoin('u.fkSwCgm', 'cgm');
                if ($request->get('codClassificacao') != '') {
                    $qb->andWhere('o.codClassificacao = :codClassificacao');
                    $qb->setParameter('codClassificacao', (int) $request->get('codClassificacao'));
                }
                if ($request->get('codAssunto') != '') {
                    $qb->andWhere('o.codAssunto = :codAssunto');
                    $qb->setParameter('codAssunto', (int) $request->get('codAssunto'));
                }
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->eq('o.codProcesso', ':codProcesso'),
                    $qb->expr()->eq('cgm.numcgm', ':numCgm'),
                    $qb->expr()->like('LOWER(cgm.nomCgm)', $qb->expr()->literal('%' . strtolower($term) . '%'))
                ));
                $qb->setParameter('numCgm', (int) $term);
                $qb->setParameter('codProcesso', (int) $term);
                $qb->orderBy('o.codProcesso', 'ASC');
                return $qb;
            },
            'required' => false,
            'req_params' => [
                'inscricaoEconomica' => 'varJsInscricaoEconomica',
                'codClassificacao' => 'varJsCodClassificacao',
                'codAssunto' => 'varJsCodAssunto',
            ],
            'attr' => [
                'class' => 'select2-parameters js-processo',
            ],
            'label' => 'label.economicoCadastroEconomico.processo',
        ];

        if (!empty($empresaDireitoNaturezaJuridica)
            && $empresaDireitoNaturezaJuridica->getFkEconomicoProcessoEmpDireitoNatJuridicas()->last()) {
            $processoEmpresaDireitoNaturezaJuridica = $empresaDireitoNaturezaJuridica->getFkEconomicoProcessoEmpDireitoNatJuridicas()->last();
            $processo = $processoEmpresaDireitoNaturezaJuridica->getFkSwProcesso();
            $fieldOptions['fkSwClassificacao']['data'] = $processo->getFkSwAssunto()->getFkSwClassificacao();
            $fieldOptions['fkSwAssunto']['data'] = $processo->getFkSwAssunto();
            $fieldOptions['fkSwProcesso']['data'] = $processo;
        }

        $formMapper
            ->with('label.EmpresaDireitoNaturezaJuridicaAdmin.cabecalhoCadastroEconomico')
                ->add('naturezaJuridicaAtual', 'text', $fieldOptions['naturezaJuridicaAtual'])
                ->add('fkEconomicoNaturezaJuridica', 'autocomplete', $fieldOptions['fkEconomicoNaturezaJuridica'])
            ->end()
            ->with('label.EmpresaDireitoNaturezaJuridicaAdmin.cabecalhoProcesso')
                ->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao'])
                ->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto'])
                ->add(
                    'fkSwProcesso',
                    'autocomplete',
                    $fieldOptions['fkSwProcesso'],
                    [
                        'admin_code' => 'administrativo.admin.processo'
                    ]
                )
            ->end();
    }

    /**
    * @param CadastroEconomico $object
    */
    protected function populateObject(CadastroEconomico $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $cadastroEconomico = $this->getSubject() ?: new CadastroEconomico();
        $empresaDireito = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaDireito() ?: new CadastroEconomicoEmpresaDireito();

        $empresaDireitoNaturezaJuridica = new EmpresaDireitoNaturezaJuridica();
        $empresaDireitoNaturezaJuridica->setFkEconomicoCadastroEconomicoEmpresaDireito($empresaDireito);
        $empresaDireitoNaturezaJuridica->setFkEconomicoNaturezaJuridica($this->getForm()->get('fkEconomicoNaturezaJuridica')->getData());

        $processo = $this->getForm()->get('fkSwProcesso')->getData();
        if ($processo) {
            $processoEmpresaDireitoNaturezaJuridica = new ProcessoEmpDireitoNatJuridica();
            $processoEmpresaDireitoNaturezaJuridica->setFkEconomicoEmpresaDireitoNaturezaJuridica($empresaDireitoNaturezaJuridica);
            $processoEmpresaDireitoNaturezaJuridica->setFkSwProcesso($processo);

            $empresaDireitoNaturezaJuridica->addFkEconomicoProcessoEmpDireitoNatJuridicas($processoEmpresaDireitoNaturezaJuridica);
        }

        $empresaDireito->addFkEconomicoEmpresaDireitoNaturezaJuridicas($empresaDireitoNaturezaJuridica);

        $cadastroEconomico->setFkEconomicoCadastroEconomicoEmpresaDireito($empresaDireito);
    }

    /**
    * @param CadastroEconomico $object
    * @param string $label
    */
    protected function saveObject(CadastroEconomico $object, $label = '')
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();
        $em->getConnection()->beginTransaction();

        try {
            $em->persist($object);
            $em->flush();
            $em->getConnection()->commit();

            $container->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->getTranslator()->trans($label)
                );
        } catch (Exception $e) {
            $em->getConnection()->rollBack();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
        } finally {
            $this->forceRedirect('/tributario/cadastro-economico/inscricao-economica/empresa-direito/list');
        }
    }
}
