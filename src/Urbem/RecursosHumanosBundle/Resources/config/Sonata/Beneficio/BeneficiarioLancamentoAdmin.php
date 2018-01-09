<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Beneficio;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\CoreBundle;
use Urbem\CoreBundle\Entity\Beneficio\Beneficiario;
use Urbem\CoreBundle\Entity\Beneficio\BeneficiarioLancamento;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Beneficio\BeneficiarioLancamentoModel;
use Urbem\CoreBundle\Model\Beneficio\BeneficiarioModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use ZipArchive;

class BeneficiarioLancamentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_beneficio_beneficiario_importacao_mensal';
    protected $baseRoutePattern = 'recursos-humanos/beneficio/beneficiario/importacao-mensal';

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('download_arquivo', 'download-arquivo');
        $collection->clearExcept(array('create', 'download_arquivo'));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        

        $strArquivo = ($this->getRequest()->get('strArquivo')) ? $this->getRequest()->get('strArquivo') : null;

        if ($strArquivo) {
            $this->redirectByRoute(
                'urbem_recursos_humanos_beneficio_beneficiario_importacao_mensal_download_arquivo',
                ['strArquivo' => $strArquivo]
            );
        }

        $fieldOptions['arquivo'] = [
            'mapped' => false
        ];

        $fieldOptions['codContrato'] = [
            'label' => 'label.gerarAssentamento.inContrato',
            'route' => [
                'name' => 'api-search-swcgm-by-nomcgm-whit-beneficiario-layout'
            ],
            'class' => SwCgm::class,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
        ];

        $formMapper
            ->add('codContrato', 'autocomplete', $fieldOptions['codContrato'])
            ->add('arquivo', 'file', $fieldOptions['arquivo']);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed        $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();
        $file = $form->get('arquivo')->getViewData();
        $handle = @fopen($file, 'r');
        $coluna = fgetcsv($handle, 8096, ";", "\"");

        /** @var BeneficiarioModel $beneficiarioModel */
        $beneficiarioModel = new BeneficiarioModel($em);
        //Valida formato e padroes do arquivo
        $boArquivoValido = $beneficiarioModel->validaArquivoUnimed($coluna);

        if (!$boArquivoValido) {
            $errorElement->with('arquivo')->addViolation('O arquivo está fora dos padrões do Layout Unimed.')->end();
        }
    }

    /**
     * @param BeneficiarioLancamento $object
     */
    public function prePersist($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();
        $cgmFornecedor = $form->get('codContrato')->getData();
        $beneficiarioNaoCadastrado = $beneficiarioCadastrado = [];
        $file = $form->get('arquivo')->getData();

        $handle = @fopen($file, 'r');

        /** @var BeneficiarioModel $beneficiarioModel */
        $beneficiarioModel = new BeneficiarioModel($em);

        /** @var BeneficiarioLancamentoModel $beneficiarioLancamentoModel */
        $beneficiarioLancamentoModel = new BeneficiarioLancamentoModel($em);

        $date = new \DateTime();
        $filename = sprintf('arquivo_%s.zip', $date->format('d_m_Y_h_i_s'));

        $container = $this->getContainer();

        while (!feof($handle)) {
            $coluna = fgetcsv($handle, 8096, ";", "\"");

            if ((!empty($coluna)) && ($coluna[0] != 'ano')) {
                $stCondicao = " WHERE EXTRACT(YEAR FROM periodo_movimentacao.dt_final) = " . $coluna[0] . "   ";
                $stCondicao .= "   AND EXTRACT(MONTH FROM periodo_movimentacao.dt_final) = " . $coluna[1] . ";";

                /** @var PeriodoMovimentacao $rsPeriodo */
                $rsPeriodo = $beneficiarioModel->verificaPeriodoMovimentacao($stCondicao);

                if ($rsPeriodo) {
                    /** @var Beneficiario $rsBeneficioBeneficiario */
                    $rsBeneficioBeneficiario = $em->getRepository(Beneficiario::class)->findOneBy(
                        [
                            'cgmFornecedor' => $cgmFornecedor->getNumCgm(),
                            'codigoUsuario' => $coluna[4],
                            'codModalidade' => $coluna[2],
                            'codTipoConvenio' => $coluna[3],
                            'codPeriodoMovimentacao' => $rsPeriodo['cod_periodo_movimentacao'],
                            'timestampExcluido' => null
                        ]
                    );

                    /** @var BeneficiarioLancamento $rsBeneficioBeneficiarioLancamento */
                    $rsBeneficioBeneficiarioLancamento = $em->getRepository(BeneficiarioLancamento::class)->findOneBy(
                        [
                            'codigoUsuario' => $coluna[4],
                            'codModalidade' => $coluna[2],
                            'codTipoConvenio' => $coluna[3],
                            'codPeriodoMovimentacao' => $rsPeriodo['cod_periodo_movimentacao'],
                        ]
                    );

                    if ($rsBeneficioBeneficiario) {
                        $beneficiario = $beneficiarioModel->buildOneBeneficiarioBasedBaneficiario($rsBeneficioBeneficiario, $coluna[6]);

                        $beneficiarioLancamento = $beneficiarioLancamentoModel->buildOneBeneficiarioLancamentoBasedBaneficiario($beneficiario, $coluna[6]);

                        $em->persist($beneficiario);
                        $em->persist($beneficiarioLancamento);
                        $beneficiarioCadastrado[] = $coluna;
                    } else {
                        $beneficiarioNaoCadastrado[] = $coluna;
                    }
                }
            }
        }

        $em->flush();

        /** @var ZipArchive $zip */
        $zip = new \ZipArchive();
        $opened = $zip->open('/tmp/' . $filename, ZipArchive::OVERWRITE | ZipArchive::CREATE);
        if (count($beneficiarioNaoCadastrado) > 0) {
            $fp = fopen('/tmp/beneficiariosNaoCadastrados.csv', 'w');
            foreach ($beneficiarioNaoCadastrado as $beneficiario) {
                fwrite($fp, implode(";", $beneficiario));
            }
            fclose($fp);

            if ($opened === true) {
                $zip->addFile('/tmp/beneficiariosNaoCadastrados.csv', 'beneficiariosNaoCadastrados.csv');
            }
        }

        if (count($beneficiarioCadastrado) > 0) {
            $fp = fopen("/tmp/beneficiariosCadastrados.csv", "w");

            foreach ($beneficiarioCadastrado as $beneficiario) {
                fwrite($fp, implode(";", $beneficiario));
            }
            fclose($fp);

            if ($opened === true) {
                $zip->addFile('/tmp/beneficiariosCadastrados.csv', 'beneficiariosCadastrados.csv');
                $zip->close();
            }
        }

        $this->redirectToUrl('/recursos-humanos/beneficio/beneficiario/importacao-mensal/create?strArquivo=' . $filename);
    }
}
