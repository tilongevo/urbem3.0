<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Cse\GrauParentesco;
use Urbem\CoreBundle\Entity\Folhapagamento\VinculoIrrf;
use Urbem\CoreBundle\Entity\Pessoal\Cid;
use Urbem\CoreBundle\Entity\Pessoal\Dependente;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Model\Pessoal\DependenteModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;

class DependenteAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_servidor_dependente';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/dependente';
    protected $includeJs = [
        '/recursoshumanos/javascripts/pessoal/dependente/form--dependente.js'
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->clearExcept(['create','edit','delete','list'])
            ->add('altera_flag_documentos', 'altera-flag-documentos');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $dependente = $this->getSubject();
        $pessoaFisica = isset($dependente) ? $dependente->getFkSwCgmPessoaFisica() : null;

        $dtNascimento = null;
        $sexo = null;

        $fieldOptions['servidor'] = [
            'mapped' => false,
            'data' => $id
        ];

        $fieldOptions['fkCseGrauParentesco'] = [
            'class' => GrauParentesco::class,
            'choice_label' => function ($grauParentesco) {
                return $grauParentesco->getCodGrau() . " - " . $grauParentesco->getNomGrau();
            },
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('g')
                    ->orderBy('g.nomGrau', 'ASC');
            },
            'label' => 'label.servidordependente.codGrau',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['fkSwCgmPessoaFisica'] = [
            'class' => SwCgmPessoaFisica::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->getSwCgmPessoaFisicaQueryBuilder($term);
            },
            'label' => 'label.servidordependente.cgmDependente',
        ];

        if (!is_null($pessoaFisica)) {
            $dtNascimento = $pessoaFisica->getDtNascimento() ? $pessoaFisica->getDtNascimento() : null;
            $dtNascimentoDisabled = $pessoaFisica->getDtNascimento() ? true : false;
            $sexo = $pessoaFisica->getSexo() ? $pessoaFisica->getSexo() : 'Não informado';

            switch ($sexo) {
                case 'f':
                    $sexo = 'Feminino';
                    break;
                case 'm':
                    $sexo = 'Masculino';
                    break;
                default:
                    $sexo = 'Não informado';
                    break;
            }
        } else {
            $dtNascimentoDisabled = false;
        }

        $fieldOptions['dtNascimento'] = [
            'mapped' => false,
            'label' => 'label.servidor.datanascimento',
            'required' => true,
            'attr' => [
                'placeholder' => 'Não Informado'

            ],
            'disabled'=> $dtNascimentoDisabled,
            'format' => 'dd/MM/yyyy',
            'data' => $dtNascimento
        ];

        $fieldOptions['dependenteSexo'] = [
            'mapped' => false,
            'label' => 'label.servidor.sexo',
            'required' => false,
            'attr' => [
                'readonly' => 'readonly',
            ],
            'data' => $sexo
        ];

        $fieldOptions['dependenteSalFamilia'] = [
            'choices' => [
                'sim' => true,
                'nao' => false
            ],
            'expanded' => true,
            'multiple' => false,
            'label' => 'label.servidordependente.dependenteSalFamilia',
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr'       => ['class' => 'checkbox-sonata '],
        ];

        $fieldOptions['dependenteInvalido'] = [
            'label' => 'label.servidordependente.dependenteInvalido',
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr'       => ['class' => 'checkbox-sonata '],
        ];

        $fieldOptions['fkFolhapagamentoVinculoIrrf'] = [
            'class' => VinculoIrrf::class,
            'choice_label' => 'descricao',
            'placeholder' => 'label.selecione',
            'label' => 'label.servidordependente.dependenteIr',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['codCid'] = [
            'label' => 'label.servidor.cid',
            'minimum_input_length' => 1,
            'class' => Cid::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->createQueryBuilder('c')
                    ->where('LOWER(c.sigla) LIKE :term')
                    ->orWhere('LOWER(c.descricao) LIKE :term')
                    ->setParameter('term', "%" . strtolower($term) . "%");
            },
            'json_choice_label' => function ($entity) {
                $sigla = $entity instanceof Cid ? $entity->getSigla() : $entity['sigla'];
                $descricao = $entity instanceof Cid ? $entity->getDescricao() : $entity['descricao'];
                return sprintf('%s - %s', $sigla, $descricao);
            },
            'label' => 'label.servidor.cid',
            'mapped' => false,
        ];

        $fieldOptions['dtInicioSalFamilia'] = [
            'label' => 'label.servidordependente.dtInicioSalFamilia',
            'format' => 'dd/MM/yyyy'
        ];

        $fieldOptions['carteiraVacinacao'] = [
            'label' => 'label.servidordependente.carteiraVacinacao',
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr'       => ['class' => 'checkbox-sonata '],
        ];

        $fieldOptions['comprovanteMatricula'] = [
            'label' => 'label.servidordependente.comprovanteMatricula',
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr'       => ['class' => 'checkbox-sonata '],
        ];

        $fieldOptions['dependentePrev'] = [
            'choices' => [
                'sim' => true,
                'nao' => false
            ],
            'expanded' => true,
            'multiple' => false,
            'label' => 'label.servidordependente.dependentePrev',
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr'       => ['class' => 'checkbox-sonata '],
        ];

        if ($this->id($this->getSubject())) {
            $codCid = $this->getSubject()->getFkPessoalDependenteCids();

            if (! $codCid->isEmpty()) {
                $fieldOptions['codCid']['data'] = $this->getSubject()->getFkPessoalDependenteCids()->last()->getFkPessoalCid();
            }
        }

        $formMapper
            ->with('label.servidordependente.dependente')
                ->add(
                    'servidor',
                    'hidden',
                    $fieldOptions['servidor']
                )
                ->add(
                    'fkCseGrauParentesco',
                    'entity',
                    $fieldOptions['fkCseGrauParentesco']
                )
                ->add(
                    'fkSwCgmPessoaFisica',
                    'autocomplete',
                    $fieldOptions['fkSwCgmPessoaFisica'],
                    [
                        'admin_code' => 'administrativo.admin.sw_cgm_pessoa_fisica',
                    ]
                )
                ->add(
                    'dtNascimento',
                    'sonata_type_date_picker',
                    $fieldOptions['dtNascimento']
                )
                ->add(
                    'dependenteSexo',
                    'text',
                    $fieldOptions['dependenteSexo']
                )
                ->add(
                    'dependenteSalFamilia',
                    'choice',
                    $fieldOptions['dependenteSalFamilia']
                )
                ->add(
                    'dependenteInvalido',
                    null,
                    $fieldOptions['dependenteInvalido']
                )
                ->add(
                    'codCid',
                    'autocomplete',
                    $fieldOptions['codCid']
                )
                ->add(
                    'fkFolhapagamentoVinculoIrrf',
                    'entity',
                    $fieldOptions['fkFolhapagamentoVinculoIrrf']
                )
                ->add(
                    'dtInicioSalFamilia',
                    'sonata_type_date_picker',
                    $fieldOptions['dtInicioSalFamilia']
                )
                ->add(
                    'carteiraVacinacao',
                    null,
                    $fieldOptions['carteiraVacinacao']
                )
                ->add(
                    'comprovanteMatricula',
                    null,
                    $fieldOptions['comprovanteMatricula']
                )
                ->add(
                    'dependentePrev',
                    'choice',
                    $fieldOptions['dependentePrev']
                )
            ->end();
    }

    public function redirect(Servidor $servidor)
    {
        $servidor = $servidor->getCodServidor();
        $this->forceRedirect('/recursos-humanos/pessoal/servidor/' . $servidor .'/show');
    }

    /**
     * @param Dependente $dependente
     */
    public function prePersist($dependente)
    {
        if (is_null($dependente->getFkSwCgmPessoaFisica()->getDtNascimento())) {
            $dependente->getFkSwCgmPessoaFisica()->setDtNascimento($this->getForm()->get('dtNascimento')->getData());
        }
    }

    /**
     * @param Dependente $dependente
     */
    public function postPersist($dependente)
    {
        $entityManager = $this->getEntityManager();
        $repository = $entityManager->getRepository(Servidor::class);
        $codServidor = $this->getForm()->get('servidor')->getData();

        $fkPessoalServidor = $repository->findOneByCodServidor($codServidor);

        $dependenteModel = new DependenteModel($this->getEntityManager());
        $dependenteModel->buildDependente($dependente, $this->getForm());

        $this->redirect($fkPessoalServidor);
    }

    /**
     * @param Dependente $dependente
     */
    public function preUpdate($dependente)
    {
        if (is_null($dependente->getFkSwCgmPessoaFisica()->getDtNascimento())) {
            $dependente->getFkSwCgmPessoaFisica()->setDtNascimento($this->getForm()->get('dtNascimento')->getData());
        }
    }

    /**
     * @param Dependente $dependente
     */
    public function postUpdate($dependente)
    {
        $dependenteModel = new DependenteModel($this->getEntityManager());
        $dependenteModel->save($dependente);

        $this->redirect($dependente->getFkPessoalServidorDependentes()->last()->getFkPessoalServidor());
    }

    /**
     * @param Dependente $dependente
     */
    public function postRemove($dependente)
    {
        $this->redirect($dependente->getFkPessoalServidorDependentes()->last()->getFkPessoalServidor());
    }

    public function toString($dependente)
    {
        return $dependente->getfkSwCgmPessoaFisica()->getFkSwCgm()->getNomCgm();
    }
}
