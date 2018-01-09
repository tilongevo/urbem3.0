<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\ArquivosDocumento;
use Urbem\CoreBundle\Entity\Administracao\ModeloArquivosDocumento;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Economico\Licenca;
use Urbem\CoreBundle\Entity\Economico\LicencaDocumento;
use Urbem\CoreBundle\Entity\Economico\LicencaObservacao;
use Urbem\CoreBundle\Entity\Economico\ProcessoLicenca;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Repository\Economico\LicencaRepository;
use Urbem\TributarioBundle\Resources\config\Sonata\Economico\ProcessoLicencaModel;

/**
 * Class LicencaModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class LicencaModel extends AbstractModel
{
    protected $entityManager;
    /** @var LicencaRepository */
    protected $repository;

    /**
     * LicencaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Licenca::class);
    }

    /**
     * @param $codLicenca
     * @return mixed
     */
    public function getLicenca($codLicenca)
    {
        return $this->repository->findByCodLicenca($codLicenca);
    }

    /**
     * @param $exercicio
     * @return int
     */
    public function getLastLicencaByExercicio($exercicio)
    {
        return $this->repository->getLastLicencaByExercicio($exercicio);
    }

    /**
     * @param $codLicenca
     * @param $exercicio
     * @return mixed
     */
    public function getLicencaByCodLicencaAndExercicio($codLicenca, $exercicio)
    {
        $em = $this->entityManager;

        $licenca = $em->getRepository(Licenca::class)
            ->findOneBy(['codLicenca' => $codLicenca, 'exercicio' => $exercicio]);

        return $licenca;
    }

    /**
     * @param $codLicenca
     * @param $exercicio
     * @param $dtInicio
     * @param $dtTermino
     * @param bool $isUpdate
     * @return mixed|Licenca
     */
    public function saveLicencaDiversa($codLicenca, $exercicio, $dtInicio, $dtTermino, $isUpdate = false)
    {
        $em = $this->entityManager;

        $licencaModel = new LicencaModel($em);
        if (!$isUpdate) {
            $licenca = new Licenca();
            $licenca->setCodLicenca($codLicenca);
            $licenca->setExercicio($exercicio);
            $licenca->setDtInicio($dtInicio);
            if ($dtTermino) {
                $licenca->setDtTermino($dtTermino);
            }
            $licencaModel->save($licenca);

            return $licenca;
        } else {
            $licenca = $this->getLicencaByCodLicencaAndExercicio($codLicenca, $exercicio);
            $licenca->setDtInicio($dtInicio);
            if ($dtTermino) {
                $licenca->setDtTermino($dtTermino);
            }
            $licencaModel->update($licenca);

            return $licenca;
        }
    }

    /**
     * @param $licenca
     * @param $codProcesso
     * @param bool $isUpdate
     */
    public function saveProcessoLicenca($licenca, $codProcesso, $isUpdate = false)
    {
        $em = $this->entityManager;

        list($codProcesso, $execicio) = explode('~', $codProcesso);

        $processo = $em->getRepository(SwProcesso::class)
            ->findOneByCodProcesso($codProcesso);

        $processoLicencaModel = new ProcessoLicencaModel($em);
        if (!$isUpdate) {
            $processoLicenca = new ProcessoLicenca();
            $processoLicenca->setFkEconomicoLicenca($licenca);
            $processoLicenca->setFkSwProcesso($processo);

            return $processoLicencaModel->save($processoLicenca);
        } else {
            $processoLicenca = $em->getRepository(ProcessoLicenca::class)
                ->findOneBy(
                    array(
                        'codLicenca' => $licenca->getCodLicenca(),
                        'exercicio' => $execicio,
                        'codProcesso' => $processo->getCodProcesso()
                    )
                );
            $processoLicenca->setFkSwProcesso($processo);

            return $processoLicencaModel->update($processoLicenca);
        }
    }

    /**
     * @param $observacao
     * @param $licenca
     * @param bool $isUpdate
     */
    public function saveLicencaObservacao($observacao, $licenca, $isUpdate = false)
    {
        $em = $this->entityManager;

        $licencaObservacaoModel = new LicencaObservacaoModel($em);
        if (!$isUpdate) {
            $licencaObservacao = new LicencaObservacao();
            $licencaObservacao->setObservacao($observacao);
            $licencaObservacao->setFkEconomicoLicenca($licenca);

            return $licencaObservacaoModel->save($licencaObservacao);
        } else {
            $licencaObservacao = $em->getRepository(LicencaObservacao::class)
                ->findOneBy(['codLicenca' => $licenca->getCodLicenca(), 'exercicio' => $licenca->getExercicio()]);
            $licencaObservacao->setObservacao($observacao);

            return $licencaObservacaoModel->update($licencaObservacao);
        }
    }

    /**
     * @param $codArquivo
     * @param $tipoDocumento
     * @param $licenca
     * @param bool $isUpdate
     */
    public function saveLicencaDocumento($codArquivo, $tipoDocumento, $licenca, $isUpdate = false)
    {
        $em = $this->entityManager;

        $arquivoDocumento  = $em->getRepository(ArquivosDocumento::class)
            ->findOneByCodArquivo($codArquivo);

        $licencaDocumentoModel = new LicencaDocumentoModel($em);
        if (!$isUpdate) {
            $licencaDocumento = new LicencaDocumento();
            if ($arquivoDocumento) {
                $modeloArquivosDocumento = $em->getRepository(ModeloArquivosDocumento::class)
                    ->findOneBy(['codArquivo' => $arquivoDocumento->getCodArquivo()]);

                ($modeloArquivosDocumento) ? $codDocumento = $modeloArquivosDocumento->getCodDocumento() : $codDocumento = $arquivoDocumento->getCodDocumento();
                $modeloDocumento = $em->getRepository(ModeloDocumento::class)
                        ->findOneBy(['codDocumento' => $codDocumento, 'codTipoDocumento' => $tipoDocumento]);

                $licencaDocumento->setNumAlvara($arquivoDocumento->getCodArquivo());
            }
            $licencaDocumento->setFkAdministracaoModeloDocumento($modeloDocumento);
            $licencaDocumento->setFkEconomicoLicenca($licenca);

            return $licencaDocumentoModel->save($licencaDocumento);
        } else {
            $modeloArquivosDocumento = $em->getRepository(ModeloArquivosDocumento::class)
                ->findOneBy(['codArquivo' => $arquivoDocumento->getCodArquivo()]);
            $modeloDocumento = $em->getRepository(ModeloDocumento::class)
                ->findOneBy(['codDocumento' => $modeloArquivosDocumento->getCodDocumento(), 'codTipoDocumento' => $tipoDocumento]);
            $licencaDocumento->setNumAlvara($arquivoDocumento->getCodArquivo());

            return $licencaDocumentoModel->update($licencaDocumento);
        }
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getLicencaAlvara($params)
    {
        return $this->repository->getLicencaAlvara($params);
    }
}
