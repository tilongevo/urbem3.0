<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal\Assentamento;

use Doctrine\ORM\EntityRepository;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculado;
use Urbem\CoreBundle\Entity\Pessoal\AssentamentoVinculadoFuncao;
use Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class AssentamentoVinculadoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_assentamento_vinculado';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/assentamento/vinculado';

    protected $includeJs = array(
        '/recursoshumanos/javascripts/pessoal/assentamento.js',
    );

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codAssentamento')
            ->add('timestamp')
            ->add('condicao')
            ->add('diasIncidencia')
            ->add('diasProtelarAverbar')
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $codCondicao = $timestamp = $codAssentamento = $classificacao = $formula = null;
        $route = $this->getRequest()->get('_sonata_name');
        if (null != $route) {
            if (!$this->getSubject($this->getAdminRequestId())) {
                if ($this->getRequest()->isMethod('GET')) {
                    list($codCondicao, $timestamp, $codAssentamento) = explode("~", $id);
                }
            } else {
                if ($this->getRequest()->isMethod('GET')) {
                    if ($route == 'urbem_recursos_humanos_assentamento_vinculado_create') {
                        list($codCondicao, $timestamp, $codAssentamento) = explode("~", $id);
                    } else {
                        list($codCondicao, $codAssentamento, $codAssentamentoAssentamento, $timestamp, $condicao, $diasI, $diasP) = explode("~", $id);
                    }
                }
            }

            if (!is_null($this->getSubject($this->getAdminRequestId())->getCodCondicao())) {
                /** @var AssentamentoVinculado $assentamentoVinculado */
                $assentamentoVinculado = $this->getSubject();
                $classificacao = $assentamentoVinculado->getFkPessoalAssentamentoAssentamento()->getFkPessoalClassificacaoAssentamento();
                if ($assentamentoVinculado->getFkPessoalAssentamentoVinculadoFuncoes()->first()) {
                    $formula = $assentamentoVinculado->getFkPessoalAssentamentoVinculadoFuncoes()->first()->getFkAdministracaoFuncao();
                }
            }
        }

        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento');
        $condicaoAssentamento = $entityManager
            ->getRepository(CondicaoAssentamento::class)
            ->findOneBy([
                'codCondicao' => $codCondicao,
                'timestamp' => $timestamp,
                'codAssentamento' => $codAssentamento
            ]);

        $fieldOptions = [];

        $fieldOptions['fkPessoalCondicaoAssentamento'] = [
            'class' => CondicaoAssentamento::class,
            'label' => 'label.condicaoAssentamento.assentamento',
            'attr' => ['class' => 'select2-parameters '],
            'required' => true,
            'data' => $condicaoAssentamento
        ];

        $fieldOptions['condicao'] = [
            'choices' => array(
                'label.assentamentoVinculado.protelacao' => 'p',
                'label.assentamentoVinculado.averbacao' => 'a'
            ),
            'data' => 'p',
            'expanded' => false,
            'multiple' => false,
            'label' => 'label.assentamentoVinculado.condicao',
            'attr' => ['class' => 'select2-parameters '],
        ];

        $fieldOptions['codClassificacaoAssentamento'] = [
            'class' => 'CoreBundle:Pessoal\ClassificacaoAssentamento',
            'query_builder' => function (EntityRepository $repository) {
                $qb = $repository->createQueryBuilder('ca')
                    ->join('ca.fkPessoalTipoClassificacao', 'ptc');
                return $qb;
            },
            'placeholder' => 'label.selecione',
            'label' => 'label.classificacaoAssentamento.descricao',
            'attr' => ['class' => 'select2-parameters '],
            'mapped' => false,
            'data' => $classificacao
        ];

        $fieldOptions['fkPessoalAssentamentoAssentamento'] = [
            'class' => 'CoreBundle:Pessoal\AssentamentoAssentamento',
            'placeholder' => 'label.selecione',
            'label' => 'label.condicaoAssentamento.assentamento',
            'attr' => ['class' => 'select2-parameters '],
            'required' => true,
        ];

        $fieldOptions['codAssentamentoVinculadoFuncao'] = [
            'class' => 'CoreBundle:Administracao\Funcao',
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $qb = $repo->createQueryBuilder('f')
                    ->join('f.fkAdministracaoTipoPrimitivo', 'tp')
                    ->where('f.nomFuncao LIKE :nomFuncao')
                    ->setParameter('nomFuncao', "%{$term}%");
                return $qb;
            },
            'label' => 'label.assentamentoVinculado.formula',
            'attr' => ['class' => 'select2-parameters '],
            'mapped' => false,
            'required' => false,
            'data' => $formula
        ];

        $formMapper->with('label.assentamentoVinculado.modulo')
            ->add('fkPessoalCondicaoAssentamento', 'entity', $fieldOptions['fkPessoalCondicaoAssentamento'])
            ->add('condicao', 'choice', $fieldOptions['condicao'])
            ->add('diasIncidencia', null, ['label' => 'label.assentamentoVinculado.diasIncidencia'])
            ->add('codClassificacaoAssentamento', 'entity', $fieldOptions['codClassificacaoAssentamento'])
            ->add('fkPessoalAssentamentoAssentamento', 'entity', $fieldOptions['fkPessoalAssentamentoAssentamento'])
            ->add('diasProtelarAverbar', null, ['label' => 'label.assentamentoVinculado.diasProtelarAverbar'])
            ->add('fkPessoalAssentamentoVinculadoFuncoes', 'autocomplete', $fieldOptions['codAssentamentoVinculadoFuncao'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codAssentamentoVinculado')
            ->add('codAssentamento')
            ->add('timestamp')
            ->add('condicao')
            ->add('diasIncidencia')
            ->add('diasProtelarAverbar');
    }

    /**
     * @param AssentamentoVinculado $assentamentoVinculado
     */
    public function prePersist($assentamentoVinculado)
    {
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento');
        $assentamentoVinculadoFuncaoOriginal = $entityManager
            ->getRepository(AssentamentoVinculadoFuncao::class)
            ->findOneBy([
                'codAssentamento' => $assentamentoVinculado->getCodAssentamento(),
                'codCondicao' => $assentamentoVinculado->getCodCondicao(),
                'timestamp' => $assentamentoVinculado->getTimestamp()
            ]);

        if (null == $assentamentoVinculadoFuncaoOriginal) {
            $form = $this->getForm();
            $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento');
            $vinculadoFuncoes = $form->get('fkPessoalAssentamentoVinculadoFuncoes')->getData();
            if ($vinculadoFuncoes) {
                $assentamentoVinculadoFuncao = new AssentamentoVinculadoFuncao();
                $assentamentoVinculadoFuncao->setFkAdministracaoFuncao($vinculadoFuncoes);
                $assentamentoVinculadoFuncao->setFkPessoalAssentamentoVinculado($assentamentoVinculado);
                $entityManager->persist($assentamentoVinculadoFuncao);
                $entityManager->flush();
                $assentamentoVinculado->addFkPessoalAssentamentoVinculadoFuncoes($assentamentoVinculadoFuncao);
            }
        }
    }

    public function postPersist($assentamentoVinculado)
    {
        $this->forceRedirect("/recursos-humanos/pessoal/assentamento/condicao/{$this->getObjectKey($assentamentoVinculado->getFkPessoalCondicaoAssentamento())}/show");
    }

    /**
     * @param AssentamentoVinculado $assentamentoVinculado
     */
    public function postUpdate($assentamentoVinculado)
    {
        $form = $this->getForm();
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Pessoal\CondicaoAssentamento');
        $vinculadoFuncoes = $form->get('fkPessoalAssentamentoVinculadoFuncoes')->getData();

        $assentamentoVinculadoFuncao = new AssentamentoVinculadoFuncao();
        $assentamentoVinculadoFuncao->setFkAdministracaoFuncao($vinculadoFuncoes);
        $assentamentoVinculadoFuncao->setFkPessoalAssentamentoVinculado($assentamentoVinculado);
        $entityManager->persist($assentamentoVinculadoFuncao);
        $entityManager->flush();
        $assentamentoVinculado->addFkPessoalAssentamentoVinculadoFuncoes($assentamentoVinculadoFuncao);

        $this->forceRedirect("/recursos-humanos/pessoal/assentamento/condicao/{$this->getObjectKey($assentamentoVinculado->getFkPessoalCondicaoAssentamento())}/show");
    }
}
