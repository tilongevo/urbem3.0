<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM\EntityManager;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\SwCopiaDigital;
use Urbem\CoreBundle\Entity\SwDocumentoProcesso;

/**
 * Class SwCopiaDigitalModel
 *
 * @package Urbem\CoreBundle\Model
 */
class SwCopiaDigitalModel extends AbstractModel implements InterfaceModel
{
    /** @var \Doctrine\ORM\EntityRepository|\Urbem\CoreBundle\Repository\SwCopiaDigitalRepository  */
    protected $repository;

    const FILE_NAME_PATTERN = 'COD_COPIA_NOM_DOCUMENTO_COD_PROCESSO_ANO_EXERCICIO_NOME_ORIGINAL_DO_ARQUIVO';

    /**
     * InterfaceModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(SwCopiaDigital::class);
    }

    /**
     * @param object $object
     *
     * @return boolean
     */
    public function canRemove($object)
    {
        return false;
    }

    /**
     * @param SwCopiaDigital $swCopiaDigital
     *
     * @return mixed|string
     */
    public function generateFileName(SwCopiaDigital $swCopiaDigital)
    {
        $swDocumentoProcesso = $swCopiaDigital->getFkSwDocumentoProcesso();
        $swDocumento = $swDocumentoProcesso->getFkSwDocumento();

        $fileName = self::FILE_NAME_PATTERN;
        $fileName = str_replace('COD_COPIA', $swCopiaDigital->getCodCopia(), $fileName);
        $fileName = str_replace('NOM_DOCUMENTO', $swDocumento->getNomDocumento(), $fileName);
        $fileName = str_replace('COD_PROCESSO', $swCopiaDigital->getCodProcesso(), $fileName);
        $fileName = str_replace('ANO_EXERCICIO', $swDocumentoProcesso->getExercicio(), $fileName);
        $fileName = str_replace('NOME_ORIGINAL_DO_ARQUIVO', $swCopiaDigital->getAnexo(), $fileName);

        return $fileName;
    }

    /**
     * @param SwDocumentoProcesso $swDocumentoProcesso
     * @param boolean             $image
     * @param string              $anexo
     *
     * @return SwCopiaDigital
     */
    public function buildOne(SwDocumentoProcesso $swDocumentoProcesso, $image, $anexo)
    {
        $codCopia = $this->repository->nextCodCopia($swDocumentoProcesso->getExercicio());

        $swCopiaDigital = new SwCopiaDigital();
        $swCopiaDigital
            ->setCodCopia($codCopia)
            ->setFkSwDocumentoProcesso($swDocumentoProcesso)
            ->setImagem($image)
            ->setAnexo($anexo);

        return $swCopiaDigital;
    }
}
