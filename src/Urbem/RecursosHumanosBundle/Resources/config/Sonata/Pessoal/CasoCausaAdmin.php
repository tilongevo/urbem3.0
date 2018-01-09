<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Pessoal\CasoCausa;
use Urbem\CoreBundle\Entity\Pessoal\CasoCausaSubDivisao;
use Urbem\CoreBundle\Entity\Pessoal\CausaRescisao;
use Urbem\CoreBundle\Entity\Pessoal\PeriodoCaso;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Model\Pessoal\CasoCausaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class CasoCausaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_caso_causa';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/causa-rescisao/caso-causa';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create','edit','delete']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $entityManager = $this->getEntityManager();

        $fieldOptions = [];

        $fieldOptions['codCausaRescisao'] = [
            'mapped' => false,
            'data' => $this->getRequest()->get('codigoCausaRescisao')
        ];

        $fieldOptions['descricao'] = [
            'label' => 'label.casocausa.descricao'
        ];

        $fieldOptions['fkPessoalPeriodoCaso'] = [
            'label' => 'label.casocausa.codPeriodo',
            'class' => PeriodoCaso::class,
            'choice_label' => function ($periodoCaso) {
                return $periodoCaso->getCodPeriodo()
                . " - "
                . $periodoCaso->getDescricao();
            },
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'required' => true
        ];

        $fieldOptions['codSubDivisao'] = [
            'mapped' => false,
            'label' => 'label.casocausa.codSubDivisao',
            'multiple' => true,
            'class' => SubDivisao::class,
            'choice_label' => function ($subDivisao) {
                return $subDivisao->getCodSubDivisao()
                . " - "
                . $subDivisao->getDescricao();
            },
            'attr' => [
                'class' => 'select2-parameters '
            ],
        ];

        $fieldOptions['pagaAvisoPrevio'] = [
            'label' => 'label.casocausa.pagarAvisoPrevio'
        ];

        $fieldOptions['pagaFeriasVencida'] = [
            'label' => 'label.casocausa.vencidas'
        ];

        $fieldOptions['pagaFeriasProporcional'] = [
            'label' => 'label.casocausa.proporcionais'
        ];

        $fieldOptions['codSaqueFgts'] = [
            'label' => 'label.casocausa.codSaqueFgts'
        ];

        $fieldOptions['multaFgts'] = [
            'label' => 'label.casocausa.multaFgts',
            'attr' => [
                'class' => 'percent ',
                'maxlength' => 6,
            ],
            'scale' => 2,
            'type' => 'integer'
        ];

        $fieldOptions['percContSocial'] = [
            'label' => 'label.casocausa.percContSocial',
            'attr' => [
                'class' => 'percent ',
                'maxlength' => 6,
            ],
            'scale' => 2,
            'type' => 'integer'
        ];

        $fieldOptions['incFgtsFerias'] = [
            'label' => 'label.casocausa.ferias'
        ];

        $fieldOptions['incFgts13'] = [
            'label' => 'label.casocausa.decimoTerceiro'
        ];

        $fieldOptions['incFgtsAvisoPrevio'] = [
            'label' => 'label.casocausa.avisoPrevio'
        ];

        $fieldOptions['incIrrfFerias'] = [
            'label' => 'label.casocausa.ferias'
        ];

        $fieldOptions['incIrrf13'] = [
            'label' => 'label.casocausa.decimoTerceiro'
        ];

        $fieldOptions['incIrrfAvisoPrevio'] = [
            'label' => 'label.casocausa.avisoPrevio'
        ];

        $fieldOptions['incPrevFerias'] = [
            'label' => 'label.casocausa.ferias'
        ];

        $fieldOptions['incPrev13'] = [
            'label' => 'label.casocausa.decimoTerceiro'
        ];

        $fieldOptions['incPrevAvisoPrevio'] = [
            'label' => 'label.casocausa.avisoPrevio'
        ];

        $fieldOptions['indenArt479'] = [
            'label' => 'label.casocausa.indenizacaoArtigo479CLT'
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['codSubDivisao']['data'] = (new CasoCausaModel($entityManager))
            ->getSubDivisoes($this->getSubject());
        }

        $formMapper
            ->with('label.casocausa.casoCausaRescisao')
                ->add(
                    'codCausaRescisao',
                    'hidden',
                    $fieldOptions['codCausaRescisao']
                )
                ->add(
                    'descricao',
                    null,
                    $fieldOptions['descricao']
                )
                ->add(
                    'fkPessoalPeriodoCaso',
                    null,
                    $fieldOptions['fkPessoalPeriodoCaso']
                )
                ->add(
                    'codSubDivisao',
                    'entity',
                    $fieldOptions['codSubDivisao']
                )
                ->add(
                    'pagaAvisoPrevio',
                    null,
                    $fieldOptions['pagaAvisoPrevio']
                )
            ->end()
            ->with('label.casocausa.pagarFerias')
                ->add(
                    'pagaFeriasVencida',
                    null,
                    $fieldOptions['pagaFeriasVencida']
                )
                ->add(
                    'pagaFeriasProporcional',
                    null,
                    $fieldOptions['pagaFeriasProporcional']
                )
                ->add(
                    'codSaqueFgts',
                    null,
                    $fieldOptions['codSaqueFgts']
                )
                ->add(
                    'multaFgts',
                    'percent',
                    $fieldOptions['multaFgts']
                )
                ->add(
                    'percContSocial',
                    'percent',
                    $fieldOptions['percContSocial']
                )
            ->end()
            ->with('label.casocausa.incidenciaFGTS')
                ->add(
                    'incFgtsFerias',
                    null,
                    $fieldOptions['incFgtsFerias']
                )
                ->add(
                    'incFgts13',
                    null,
                    $fieldOptions['incFgts13']
                )
                ->add(
                    'incFgtsAvisoPrevio',
                    null,
                    $fieldOptions['incFgtsAvisoPrevio']
                )
            ->end()
            ->with('label.casocausa.incidenciaIRRF')
                ->add(
                    'incIrrfFerias',
                    null,
                    $fieldOptions['incIrrfFerias']
                )
                ->add(
                    'incIrrf13',
                    null,
                    $fieldOptions['incIrrf13']
                )
                ->add(
                    'incIrrfAvisoPrevio',
                    null,
                    $fieldOptions['incIrrfAvisoPrevio']
                )
            ->end()
            ->with('label.casocausa.incidenciaPrevidencia')
                ->add(
                    'incPrevFerias',
                    null,
                    $fieldOptions['incPrevFerias']
                )
                ->add(
                    'incPrev13',
                    null,
                    $fieldOptions['incPrev13']
                )
                ->add(
                    'incPrevAvisoPrevio',
                    null,
                    $fieldOptions['incPrevAvisoPrevio']
                )
                ->add(
                    'indenArt479',
                    null,
                    $fieldOptions['indenArt479']
                )
            ->end()
        ;
    }

    /**
     * @param CasoCausa $casoCausa
     */
    public function prePersist($casoCausa)
    {
        $entityManager = $this->getEntityManager();

        $codCasoCausa = $entityManager->getRepository(CasoCausa::class)
        ->getNextCodCasoCausa();

        $fkPessoalCausaRescisao = $this->getModelManager()
        ->find(CausaRescisao::class, $this->getForm()->get('codCausaRescisao')->getData());

        $casoCausa->setCodCasoCausa($codCasoCausa);
        $casoCausa->setFkPessoalCausaRescisao($fkPessoalCausaRescisao);

        foreach ($this->getForm()->get('codSubDivisao')->getData() as $codSubDivisao) {
            $casoCausaSubDivisao = new CasoCausaSubDivisao();
            $casoCausaSubDivisao->setFkPessoalSubDivisao($codSubDivisao);
            $casoCausaSubDivisao->setFkPessoalCasoCausa($casoCausa);

            $casoCausa->addFkPessoalCasoCausaSubDivisoes($casoCausaSubDivisao);
        }
    }

    /**
     * @param CasoCausa $casoCausa
     */
    public function postPersist($casoCausa)
    {
        $this->forceRedirect("/recursos-humanos/pessoal/causa-rescisao/{$casoCausa->getCodCausaRescisao()}/show");
    }

    /**
     * @param CasoCausa $casoCausa
     */
    public function preUpdate($casoCausa)
    {
        foreach ($casoCausa->getFkPessoalCasoCausaSubDivisoes() as $casoCausaSubDivisao) {
            $casoCausa->removeFkPessoalCasoCausaSubDivisoes($casoCausaSubDivisao);
        }
    }

    /**
     * @param CasoCausa $casoCausa
     */
    public function postUpdate($casoCausa)
    {
        $entityManager = $this->getEntityManager();

        foreach ($this->getForm()->get('codSubDivisao')->getData() as $codSubDivisao) {
            $casoCausaSubDivisao = new CasoCausaSubDivisao();
            $casoCausaSubDivisao->setFkPessoalSubDivisao($codSubDivisao);
            $casoCausaSubDivisao->setFkPessoalCasoCausa($casoCausa);

            $entityManager->persist($casoCausaSubDivisao);
        }

        $entityManager->flush();

        $this->forceRedirect("/recursos-humanos/pessoal/causa-rescisao/{$casoCausa->getCodCausaRescisao()}/show");
    }

    /**
     * @param CasoCausa $casoCausa
     */
    public function postRemove($casoCausa)
    {
        $this->forceRedirect("/recursos-humanos/pessoal/causa-rescisao/{$casoCausa->getCodCausaRescisao()}/show");
    }
}
