<?php

namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicenca;
use Urbem\CoreBundle\Entity\Imobiliario\TipoLicenca;
use Urbem\CoreBundle\Entity\Imobiliario\TipoLicencaDocumento;

class TipoLicencaDocumentoModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository;

    /**
     * NivelModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(TipoLicencaDocumento::class);
    }

    /**
     * @return array
     */
    public function recuperarModelosDocumento()
    {
        $qb = $this->entityManager->getRepository(ModeloDocumento::class)->createQueryBuilder('o');
        $qb->where('o.codDocumento != :codDocumento');
        $qb->setParameter('codDocumento', 0);
        $qb->orderBy('o.nomeDocumento');
        $rlt = $qb->getQuery()->getResult();

        $modelosDocumentos = array();

        /** @var ModeloDocumento $modeloDocumento */
        foreach ($rlt as $modeloDocumento) {
            $modelosDocumentos[sprintf('%s~%s', $modeloDocumento->getCodDocumento(), $modeloDocumento->getCodTipoDocumento())] = (string) $modeloDocumento;
        }

        return $modelosDocumentos;
    }

    /**
     * @param TipoLicenca $tipoLicenca
     * @param $modelosDocumento
     * @param $atributosDinamicos
     * @return bool|\Exception
     */
    public function salvarTipoLicencaDocumento(TipoLicenca $tipoLicenca, $modelosDocumento, $atributosDinamicos)
    {
        try {
            /** @var ORM\EntityManager $em */
            $em = $this->entityManager;

            if ($tipoLicenca->getFkImobiliarioTipoLicencaDocumentos()->count()) {
                /** @var TipoLicencaDocumento $tipoLicencaDocumento */
                foreach ($tipoLicenca->getFkImobiliarioTipoLicencaDocumentos() as $tipoLicencaDocumento) {
                    if (!in_array($this->getObjectIdentifier($tipoLicencaDocumento->getFkAdministracaoModeloDocumento()), $modelosDocumento)) {
                        $tipoLicenca->getFkImobiliarioTipoLicencaDocumentos()->removeElement($tipoLicencaDocumento);
                    } else {
                        $key = array_search($this->getObjectIdentifier($tipoLicencaDocumento->getFkAdministracaoModeloDocumento()), $modelosDocumento);
                        unset($modelosDocumento[$key]);
                    }
                }
            }

            foreach ($modelosDocumento as $params) {
                list($codDocumento, $codTipoDocumento) = explode('~', $params);

                /** @var ModeloDocumento $modeloDocumento */
                $modeloDocumento = $em->getRepository(ModeloDocumento::class)->findOneBy(
                    array(
                        'codDocumento' => $codDocumento,
                        'codTipoDocumento' => $codTipoDocumento
                    )
                );

                $tipoLicencaDocumento = new TipoLicencaDocumento();
                $tipoLicencaDocumento->setFkAdministracaoModeloDocumento($modeloDocumento);
                $tipoLicenca->addFkImobiliarioTipoLicencaDocumentos($tipoLicencaDocumento);
            }

            if ($tipoLicenca->getFkImobiliarioAtributoTipoLicencas()->count()) {
                /** @var AtributoTipoLicenca $atributoTipoLicenca */
                foreach ($tipoLicenca->getFkImobiliarioAtributoTipoLicencas() as $atributoTipoLicenca) {
                    if (!in_array($atributoTipoLicenca->getFkAdministracaoAtributoDinamico(), $atributosDinamicos)) {
                        $tipoLicenca->getFkImobiliarioAtributoTipoLicencas()->removeElement($atributoTipoLicenca);
                    } else {
                        $key = array_search($atributoTipoLicenca->getFkAdministracaoAtributoDinamico(), $atributosDinamicos);
                        unset($atributosDinamicos[$key]);
                    }
                }
            }

            /** @var AtributoDinamico $atributoDinamico */
            foreach ($atributosDinamicos as $atributoDinamico) {
                $atributoTipoLicenca = new AtributoTipoLicenca();
                $atributoTipoLicenca->setAtivo(true);
                $atributoTipoLicenca->setFkAdministracaoAtributoDinamico($atributoDinamico);
                $tipoLicenca->addFkImobiliarioAtributoTipoLicencas($atributoTipoLicenca);
            }

            $em->persist($tipoLicenca);
            $em->flush();
            return true;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
