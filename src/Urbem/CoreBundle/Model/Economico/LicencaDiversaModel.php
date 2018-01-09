<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Economico\AtributoElemento;
use Urbem\CoreBundle\Entity\Economico\AtributoElemLicenDiversaValor;
use Urbem\CoreBundle\Entity\Economico\ElementoLicencaDiversa;
use Urbem\CoreBundle\Entity\Economico\ElementoTipoLicencaDiversa;
use Urbem\CoreBundle\Entity\Economico\EmissaoDocumento;
use Urbem\CoreBundle\Entity\Economico\Licenca;
use Urbem\CoreBundle\Entity\Economico\LicencaAtividade;
use Urbem\CoreBundle\Entity\Economico\LicencaDiversa;
use Urbem\CoreBundle\Entity\Economico\LicencaDocumento;
use Urbem\CoreBundle\Entity\Economico\LicencaEspecial;
use Urbem\TributarioBundle\Resources\config\Sonata\Economico\EmissaoDocumentoModel;

/**
 * Class LicencaDiversaModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class LicencaDiversaModel extends AbstractModel
{
    protected $entityManager;
    protected $repository;

    const OCORRENCIA = 1;

    /**
     * LicencaDiversaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(LicencaDiversa::class);
    }

    /**
     * @param $inscricaoEconomica
     * @return mixed
     */
    public function getOcorrenciaLicencaByInscricaoEconomica($inscricaoEconomica)
    {
        $repository = $this->entityManager->getRepository(LicencaAtividade::class);
        return $repository->getOcorrenciaLicencaByInscricaoEconomica($inscricaoEconomica);
    }

    /**
     * @param $inscricaoEconomica
     * @return mixed
     */
    public function getSwCgmByInscricaoEconomica($inscricaoEconomica)
    {
        $repository = $this->entityManager->getRepository(LicencaEspecial::class);
        return $repository->getSwCgmByInscricaoEconomica($inscricaoEconomica);
    }

    /**
     * @return null|object
     */
    public function getAtributoDinamico()
    {
        $em = $this->entityManager;

        $atributoDinamico = $em->getRepository(AtributoDinamico::class)
            ->findOneBy(
                array(
                    'codModulo' => Modulo::MODULO_CADASTRO_ECONOMICO,
                    'codCadastro' => Cadastro::CADASTRO_TIPO_LICENCA_DIVERSA
                )
            );

        return $atributoDinamico;
    }

    /**
     * @param $licencaDiversa
     */
    public function emissaoDocumento($licencaDiversa)
    {
        $em = $this->entityManager;

        $licenca = $em->getRepository(Licenca::class)
            ->findOneBy(['codLicenca' => $licencaDiversa->getCodLicenca(), 'exercicio' => $licencaDiversa->getExercicio()]);

        $emissaoDocumentoModel = new EmissaoDocumentoModel($em);
        $numEmissao = $emissaoDocumentoModel
            ->getNumEmissao($licencaDiversa->getCodLicenca());

        $licencaDocumento = $em->getRepository(LicencaDocumento::class)
            ->findOneBy(['codLicenca' => $licencaDiversa->getCodLicenca()]);
        $modeloDocumento = $em->getRepository(ModeloDocumento::class)
            ->findOneBy(
                array(
                    'codDocumento' => $licencaDocumento->getCodDocumento(),
                    'codTipoDocumento' => $licencaDocumento->getCodTipoDocumento()
                )
            );

        $emissaoDocumento = new EmissaoDocumento();
        $emissaoDocumento->setFkEconomicoLicenca($licenca);
        $emissaoDocumento->setNumEmissao($numEmissao);
        $emissaoDocumento->setFkAdministracaoModeloDocumento($modeloDocumento);
        $emissaoDocumento->setNumcgmDiretor($licencaDiversa->getNumcgm());
        $emissaoDocumento->setNumcgmUsuario($licencaDiversa->getNumcgm());
        $emissaoDocumento->setDtEmissao(new \DateTime('now'));

        return $emissaoDocumentoModel->save($emissaoDocumento);
    }

    /**
     * @param $licencaDiversa
     * @param $elemento
     */
    public function saveElementoLicencaDiversaValor($licencaDiversa, $elemento)
    {
        $em = $this->entityManager;

        $elementoLicencaDiversa = new ElementoLicencaDiversa();
        $elementoLicencaDiversa->setOcorrencia(self::OCORRENCIA);
        $elementoLicencaDiversa->setFkEconomicoLicencaDiversa($licencaDiversa);

        $elementoTipoLicencaDiversa = $em->getRepository(ElementoTipoLicencaDiversa::class)
            ->findOneByCodTipo($licencaDiversa->getCodTipo());
        if ($elementoTipoLicencaDiversa) {
            $elementoLicencaDiversa->setFkEconomicoElementoTipoLicencaDiversa($elementoTipoLicencaDiversa);
        }
        if ($elemento) {
            $atributoElemento = new AtributoElemento();
            $atributoElemento->setFkEconomicoElemento($elemento);
            $atributoDinamico = $this->getAtributoDinamico();
            if ($atributoDinamico) {
                $atributoElemento->setFkAdministracaoAtributoDinamico($atributoDinamico);
                $atributoElementoLicencaDiversValor = new AtributoElemLicenDiversaValor();
                $ocorrencia = ($elementoLicencaDiversa) ? $elementoLicencaDiversa->getOcorrencia() : null;
                $atributoElementoLicencaDiversValor->setOcorrencia($ocorrencia);
                $atributoElementoLicencaDiversValor->setFkEconomicoAtributoElemento($atributoElemento);
                $atributoElementoLicencaDiversValor->setFkEconomicoElementoLicencaDiversa($elementoLicencaDiversa);
                $atributoElementoLicencaDiversValorModel = new AtributoElemLicenDiversaValorModel($em);
                $atributoElementoLicencaDiversValorModel->save($atributoElementoLicencaDiversValor);
            }
        }
    }
}
