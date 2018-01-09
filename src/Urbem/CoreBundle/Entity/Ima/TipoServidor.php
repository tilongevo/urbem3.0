<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * TipoServidor
 */
class TipoServidor
{
    /**
     * PK
     * @var integer
     */
    private $codTipoServidor;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao
     */
    private $fkImaExportacaoTcmBaSubDivisoes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaExportacaoTcmBaSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipoServidor
     *
     * @param integer $codTipoServidor
     * @return TipoServidor
     */
    public function setCodTipoServidor($codTipoServidor)
    {
        $this->codTipoServidor = $codTipoServidor;
        return $this;
    }

    /**
     * Get codTipoServidor
     *
     * @return integer
     */
    public function getCodTipoServidor()
    {
        return $this->codTipoServidor;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoServidor
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add ImaExportacaoTcmBaSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao $fkImaExportacaoTcmBaSubDivisao
     * @return TipoServidor
     */
    public function addFkImaExportacaoTcmBaSubDivisoes(\Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao $fkImaExportacaoTcmBaSubDivisao)
    {
        if (false === $this->fkImaExportacaoTcmBaSubDivisoes->contains($fkImaExportacaoTcmBaSubDivisao)) {
            $fkImaExportacaoTcmBaSubDivisao->setFkImaTipoServidor($this);
            $this->fkImaExportacaoTcmBaSubDivisoes->add($fkImaExportacaoTcmBaSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaExportacaoTcmBaSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao $fkImaExportacaoTcmBaSubDivisao
     */
    public function removeFkImaExportacaoTcmBaSubDivisoes(\Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao $fkImaExportacaoTcmBaSubDivisao)
    {
        $this->fkImaExportacaoTcmBaSubDivisoes->removeElement($fkImaExportacaoTcmBaSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaExportacaoTcmBaSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBaSubDivisao
     */
    public function getFkImaExportacaoTcmBaSubDivisoes()
    {
        return $this->fkImaExportacaoTcmBaSubDivisoes;
    }
}
