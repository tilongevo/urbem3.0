<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Estagio;

use Doctrine\ORM\EntityManager;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Estagio\Curso;
use Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsino;
use Urbem\CoreBundle\Entity\Estagio\CursoInstituicaoEnsinoMes;
use Urbem\CoreBundle\Entity\Estagio\Grau;
use Urbem\CoreBundle\Model\Estagio\CursoInstituicaoEnsinoMesModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Estagio;
use Urbem\CoreBundle\Entity\Administracao;
use Urbem\RecursosHumanosBundle\Form\Estagio\InstituicaoEnsinoType;

class CursoInstituicaoEnsinoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_estagio_curso_instituicao_ensino';
    protected $baseRoutePattern = 'recursos-humanos/estagio/curso-instituicao-ensino';
    protected $exibirBotaoExcluir = false;

    protected $includeJs = [
        '/recursoshumanos/javascripts/estagio/cursoInstituicaoEnsino.js',
    ];

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $numCgm = $this->getRequest()->get('id');

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $numCgm = $formData['numCgm'];
        } else {
            $numCgm = $numCgm;
        }

        /** @var CursoInstituicaoEnsino $cursosInstituicaoEnsino */
        $cursosInstituicaoEnsino = $this->getSubject();

        $fieldOptions = [];

        /** @var Grau $grau */
        $grau = $entityManager->getRepository(Estagio\Grau::class)->findAll();

        $arrGru = [];
        /** @var Estagio\Grau $gr */
        foreach ($grau as $gr) {
            $arrGru[(string) $gr] = $gr->getCodGrau();
        }

        $fieldOptions['codMes'] = [
            'class' => Administracao\Mes::class,
            'choice_label' => function ($codMes) {
                return $codMes->getDescricao();
            },
            'label' => 'label.periodoAvaliacao',
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['curso'] = [
            'label' => 'label.estagio.curso',
            'mapped' => false,
            'choices' => isset($dados['curso']) ? $dados['curso']['key_val'] : null,
            'data' => isset($dados['curso']) ? $dados['curso']['val'] : null
        ];

        $fieldOptions['grauCurso'] = [
            'label' => 'label.estagio.grau_curso',
            'mapped' => false,
            'choices' => $arrGru,
            'data' => isset($dados['grau']) ? $dados['grau']['val'] : null
        ];

        if (!is_null($cursosInstituicaoEnsino->getCodCurso())) {
            $dadoGrau = [(string) $cursosInstituicaoEnsino->getFkEstagioCurso()->getFkEstagioGrau() => $cursosInstituicaoEnsino->getFkEstagioCurso()->getFkEstagioGrau()->getCodGrau()];
            $dadoCurso = [(string) $cursosInstituicaoEnsino->getFkEstagioCurso() => $cursosInstituicaoEnsino->getFkEstagioCurso()->getCodCurso()];

            $fieldOptions['curso']['data'] = $cursosInstituicaoEnsino->getFkEstagioCurso();
            $fieldOptions['curso']['attr'] = [
                'disabled' => 'disabled'
            ];

            $fieldOptions['grauCurso']['attr'] = [
                'disabled' => 'disabled'
            ];

            $fieldOptions['grauCurso']['choices'] = $dadoGrau;
            $fieldOptions['curso']['choices'] = $dadoCurso;
        } else {
            $fieldOptions['curso']['placeholder'] = 'label.selecione';
            $fieldOptions['grauCurso']['placeholder'] = 'label.selecione';
        }

        $formMapper
            ->with('label.estagio.cursoAreaConhecimento')
            ->add('numCgm', 'hidden', ['mapped' => false, 'data' => $numCgm])
            ->add('grauCurso', 'choice', $fieldOptions['grauCurso'])
            ->add('curso', 'choice', $fieldOptions['curso'])
            ->add('fkEstagioCursoInstituicaoEnsinoMes', 'entity', $fieldOptions['codMes'])
            ->add('vlBolsa', 'number', [
                'label' => 'label.vlBolsa',
                'attr' => [
                    'class' => 'money '
                ]
            ])
        ->end();

        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $entityManager) {
                $form = $event->getForm();
                $data = $event->getData();

                $codGrau = (isset($data['grauCurso'])) ? $data['grauCurso'] : '';

                if (isset($codGrau) && $codGrau != "") {
                    $dados = [];
                    $cursos = $entityManager->getRepository(Estagio\Curso::class)->findBy(
                        [
                            'codGrau' => $codGrau
                        ]
                    );

                    /** @var Estagio\Curso $curso */
                    foreach ($cursos as $curso) {
                        $choiceKey = (string) $curso->getCodCurso() . " - " . $curso->getNomCurso();
                        $choiceValue = $curso->getCodCurso();

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $curso = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('curso', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.estagio.curso',
                            'mapped' => false,
                        ]);

                    $form->add($curso);
                }
            }
        );
    }

    /**
     * @param CursoInstituicaoEnsino $cursoInstituicaoEnsino
     */
    public function prePersist($cursoInstituicaoEnsino)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();

        /** @var Estagio\InstituicaoEnsino $instituicaoEnsino */
        $instituicaoEnsino = $entityManager->getRepository(Estagio\InstituicaoEnsino::class)
            ->findOneBy(['numcgm' => $form->get('numCgm')->getData()]);

        /** @var Curso $curso */
        $curso = $entityManager->getRepository(Curso::class)->findOneBy(['codCurso' => $form->get('curso')->getData()]);

        $cursoInstituicaoEnsino->setFkEstagioInstituicaoEnsino($instituicaoEnsino);
        $cursoInstituicaoEnsino->setFkEstagioCurso($curso);
    }

    /**
     * @param CursoInstituicaoEnsino $cursoInstituicaoEnsino
     */
    public function postPersist($cursoInstituicaoEnsino)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();

        /** @var Administracao\Mes $fkEstagioCursoInstituicaoEnsinoMes */
        $fkEstagioCursoInstituicaoEnsinoMes = $form->get('fkEstagioCursoInstituicaoEnsinoMes')->getData();

        /** @var CursoInstituicaoEnsinoMesModel $cursoInstituicaoEnsinoModel */
        $cursoInstituicaoEnsinoModel = new CursoInstituicaoEnsinoMesModel($entityManager);
        $cursoInstituicaoEnsinoMes = $cursoInstituicaoEnsinoModel->buildOneBasedCursoInstituicaoEnsino(
            $cursoInstituicaoEnsino,
            $fkEstagioCursoInstituicaoEnsinoMes
        );

        $cursoInstituicaoEnsino->setFkEstagioCursoInstituicaoEnsinoMes($cursoInstituicaoEnsinoMes);

        $this->redirectByRoute('urbem_recursos_humanos_estagio_instituicao_ensino_show', ['id' => $this->getObjectKey($cursoInstituicaoEnsino->getFkEstagioInstituicaoEnsino())]);
    }

    /**
     * @param CursoInstituicaoEnsino $cursoInstituicaoEnsino
     */
    public function preUpdate($cursoInstituicaoEnsino)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();

        /** @var Administracao\Mes $fkEstagioCursoInstituicaoEnsinoMes */
        $fkEstagioCursoInstituicaoEnsinoMes = $form->get('fkEstagioCursoInstituicaoEnsinoMes')->getData();

        /** @var CursoInstituicaoEnsinoMesModel $cursoInstituicaoEnsinoModel */
        $cursoInstituicaoEnsinoModel = new CursoInstituicaoEnsinoMesModel($entityManager);

        /** @var CursoInstituicaoEnsinoMes $cursoInstituicaoEnsinoMes */
        $cursoInstituicaoEnsinoMes = $cursoInstituicaoEnsino->getFkEstagioCursoInstituicaoEnsinoMes();

        $cursoInstituicaoEnsinoMes->setFkAdministracaoMes($fkEstagioCursoInstituicaoEnsinoMes);
    }

    /**
     * @param CursoInstituicaoEnsino $cursoInstituicaoEnsino
     */
    public function postUpdate($cursoInstituicaoEnsino)
    {
        $this->redirectByRoute('urbem_recursos_humanos_estagio_instituicao_ensino_show', ['id' => $this->getObjectKey($cursoInstituicaoEnsino->getFkEstagioInstituicaoEnsino())]);
    }

    /**
     * @param CursoInstituicaoEnsino $cursoInstituicaoEnsino
     */
    public function postRemove($cursoInstituicaoEnsino)
    {
        $this->redirectByRoute('urbem_recursos_humanos_estagio_instituicao_ensino_show', ['id' => $this->getObjectKey($cursoInstituicaoEnsino->getFkEstagioInstituicaoEnsino())]);
    }

    /**
     * @param ErrorElement $errorElement
     * @param CursoInstituicaoEnsino        $cursoInstituicaoEnsino
     */
    public function validate(ErrorElement $errorElement, $cursoInstituicaoEnsino)
    {
        /** @var EntityManager $em */
        $em = $this->getModelManager()->getEntityManager($this->getClass());

        $form = $this->getForm();

        $routeName = $this->baseRouteName . '_edit';
        $route = $this->getRequest()->get('_sonata_name');

        if ($route != $routeName) {
            $codCurso = $form->get('curso')->getData();
            $numCgm = $form->get('numCgm')->getData();

            /** @var CursoInstituicaoEnsino $cursoInstituicaoEnsinoObject */
            $cursoInstituicaoEnsinoObject = $em->getRepository(CursoInstituicaoEnsino::class)->findOneBy(
                [
                    'codCurso' => $codCurso,
                    'numcgm' => $numCgm
                ]
            );

            if (is_object($cursoInstituicaoEnsinoObject)) {
                $message = $this->trans('rh.estagio.cursoInstituicaoEnsino.errors.cursoJaCadastradoParaInstituicao', [], 'validators');
                $errorElement->with('curso')->addViolation($message)->end();
            }
        }
    }
}
