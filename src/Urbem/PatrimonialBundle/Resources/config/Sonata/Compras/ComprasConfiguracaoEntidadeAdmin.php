<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoEntidadeModel;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Administracao\ModuloModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class ComprasConfiguracaoEntidadeAdmin extends AbstractAdmin
{

    protected $baseRouteName = 'urbem_patrimonial_compras_configuracao_entidade';

    protected $customMessageDelete = 'Você tem certeza que deseja remover o responsável pelo %object% selecionado?';

    protected $baseRoutePattern = 'patrimonial/compras/configuracao-entidade';

    protected $exibirBotaoIncluir = false;

    protected $urlReferer = false;

    protected $exibirBotaoEditar = false;

    protected $exibirBotaoExcluir = false;

    protected $customBodyTemplate = '';


    /**
     * @param ConfiguracaoEntidade $configuracaoEntidade
     */
    public function prePersist($configuracaoEntidade)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');
        $moduloModel = new ModuloModel($em);
        $modulo = $moduloModel->findOneByCodModulo($configuracaoEntidade->getCodModulo());
        $configuracaoEntidade->setFkAdministracaoModulo($modulo);
        $configuracaoEntidade->setValor($configuracaoEntidade->getValor()->getNumCgm());
    }

    /**
     * @param ConfiguracaoEntidade $configuracaoEntidade
     */
    public function postRemove($configuracaoEntidade)
    {
        $this->forceRedirect("/patrimonial/compras/configuracao/{$configuracaoEntidade->getExercicio()}~{$configuracaoEntidade->getCodModulo()}~homologacao_automatica/show");
    }

    /**
     * @param ConfiguracaoEntidade $configuracaoEntidade
     */
    public function postPersist($configuracaoEntidade)
    {
        $this->forceRedirect("/patrimonial/compras/configuracao/{$configuracaoEntidade->getExercicio()}~{$configuracaoEntidade->getCodModulo()}~homologacao_automatica/show");
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $container = $this->getConfigurationPool()->getContainer();
        if ($this->getRequest()->isMethod('GET')) {
            $codModulo = $this->getRequest()->get('codModulo', false);
            $exercicio = $this->getRequest()->get('exercicio', false);
        } else {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codModulo = $formData['codModulo'];
            $exercicio = $formData['exercicio'];
        }

        $this->setBreadCrumb($codModulo ? ['id' => $codModulo] : []);

        $info = array(
            'codModulo' => $codModulo,
            'exercicio' => ($exercicio) ? $exercicio : $this->getExercicio(),
        );

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');
        $configuracaoModel = new ConfiguracaoEntidadeModel($em);
        $responsaveis = $configuracaoModel->getResponsaveis($info);

        $entidades = array();
        foreach ($responsaveis as $responsavel) {
            $entidades[] = $responsavel->getCodEntidade();
        }

        $entidades = empty($entidades) ? 0 : $entidades;

        $fieldOptions['codEntidade'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.comprasDireta.codEntidade',
            'placeholder' => 'label.selecione',
            'required' => true,
            'class' => Entidade::class,
            'query_builder' => function (EntityRepository $entityManager) use ($exercicio, $entidades) {
                $qb = $entityManager->createQueryBuilder('entidade');
                $qb->andWhere($qb->expr()->notIn("{$qb->getRootAliases()[0]}.codEntidade", $entidades));
                $result = $qb->andWhere('entidade.exercicio = :exercicio')
                    ->setParameter(':exercicio', $exercicio);

                return $result;
            }
        ];

        $fieldOptions['fkSwCgm'] = [
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->createQueryBuilder('o')
                    ->where('o.nomCgm LIKE :nomCgm')
                    ->setParameter('nomCgm', "%{$term}%");
            },
            'label' => 'label.cgm',
        ];

        $formMapper
            ->add('exercicio', null, ['data' => $exercicio, 'attr' => ['readonly' => 'readonly']])
            ->add('fkOrcamentoEntidade', null, $fieldOptions['codEntidade'], [
                'admin_code' => 'financeiro.admin.entidade'
            ])
            ->add('codModulo', 'hidden', ['data' => $codModulo])
            ->add('parametro', 'hidden', ['data' => 'responsavel'])
            ->add('valor', 'autocomplete', $fieldOptions['fkSwCgm'], ['admin_code' => 'core.admin.filter.sw_cgm'])
        ;
    }

    /**
     * @param ConfiguracaoEntidade $object
     * @return mixed
     */
    public function toString($object)
    {
        return $object->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicio')
            ->add('codEntidade')
            ->add('codModulo')
            ->add('parametro')
            ->add('valor')
        ;
    }
}
