<?php

namespace Urbem\CoreBundle\Model\Divida;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Divida\EmissaoDocumento;
use Urbem\CoreBundle\Entity\Divida\Parcelamento;
use Urbem\CoreBundle\Repository\Tributario\DividaAtiva\EstornarDividaAtivaRepository;

/**
 * Class EstornarDividaAtivaModel
 * @package Urbem\CoreBundle\Model\Divida
 */
class EstornarDividaAtivaModel extends AbstractModel
{
    protected $em;
    protected $repository;

    /**
     * EstornarDividaAtivaModel constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = new EstornarDividaAtivaRepository($this->em);
    }

    /**
    * @param Parcelamento $parcelamento
    */
    public function emitirDocumentos(Parcelamento $parcelamento)
    {
        foreach ($parcelamento->getFkDividaDocumentos() as $documento) {
            $ultimoEmissaoDocumento = $this->em->getRepository(EmissaoDocumento::class)->findOneBy([], ['numDocumento' => 'DESC']);

            $emissaoDocumentoAnterior = $em->getRepository(EmissaoDocumento::class)->findOneBy(
                [
                    'numParcelamento' => $documento->getNumParcelamento(),
                    'codTipoDocumento' => $documento->getCodTipoDocumento(),
                    'codDocumento' => $documento->getCodDocumento(),
                    'exercicio' => $parcelamento->getExercicio(),
                ],
                [
                    'numEmissao' => 'DESC',
                ]
            );

            $numEmissao = $emissaoDocumentoAnterior ? $emissaoDocumentoAnterior->getNumEmissao() : 0;
            $numDocumento = $ultimoEmissaoDocumento ? $ultimoEmissaoDocumento->getNumDocumento() + 1 : 1;
            if ($emissaoDocumentoAnterior) {
                $numDocumento = $emissaoDocumentoAnterior->getNumDocumento();
            }

            $emissaoDocumento = (new EmissaoDocumento())
                ->setFkAdministracaoUsuario($parcelamento->getNumcgmUsuario())
                ->setExercicio($parcelamento->getExercicio())
                ->setNumDocumento($numDocumento)
                ->setNumEmissao(++$numEmissao)
                ->setFkDividaDocumento($documento);

            $documento->addFkDividaEmissaoDocumentos($emissaoDocumento);
            $this->em->persist($documento);
        }

        $this->em->flush();
    }
}
