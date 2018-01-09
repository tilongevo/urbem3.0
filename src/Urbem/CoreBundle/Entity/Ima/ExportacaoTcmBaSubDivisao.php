<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ExportacaoTcmBaSubDivisao
 */
class ExportacaoTcmBaSubDivisao
{
    /**
     * PK
     * @var integer
     */
    private $codSubDivisao;

    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var integer
     */
    private $codTipoServidor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    private $fkPessoalSubDivisao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBa
     */
    private $fkImaExportacaoTcmBa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ima\TipoServidor
     */
    private $fkImaTipoServidor;


    /**
     * Set codSubDivisao
     *
     * @param integer $codSubDivisao
     * @return ExportacaoTcmBaSubDivisao
     */
    public function setCodSubDivisao($codSubDivisao)
    {
        $this->codSubDivisao = $codSubDivisao;
        return $this;
    }

    /**
     * Get codSubDivisao
     *
     * @return integer
     */
    public function getCodSubDivisao()
    {
        return $this->codSubDivisao;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ExportacaoTcmBaSubDivisao
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set codTipoServidor
     *
     * @param integer $codTipoServidor
     * @return ExportacaoTcmBaSubDivisao
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
     * ManyToOne (inverse side)
     * Set fkPessoalSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao
     * @return ExportacaoTcmBaSubDivisao
     */
    public function setFkPessoalSubDivisao(\Urbem\CoreBundle\Entity\Pessoal\SubDivisao $fkPessoalSubDivisao)
    {
        $this->codSubDivisao = $fkPessoalSubDivisao->getCodSubDivisao();
        $this->fkPessoalSubDivisao = $fkPessoalSubDivisao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalSubDivisao
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\SubDivisao
     */
    public function getFkPessoalSubDivisao()
    {
        return $this->fkPessoalSubDivisao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaExportacaoTcmBa
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBa $fkImaExportacaoTcmBa
     * @return ExportacaoTcmBaSubDivisao
     */
    public function setFkImaExportacaoTcmBa(\Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBa $fkImaExportacaoTcmBa)
    {
        $this->codConfiguracao = $fkImaExportacaoTcmBa->getCodConfiguracao();
        $this->fkImaExportacaoTcmBa = $fkImaExportacaoTcmBa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaExportacaoTcmBa
     *
     * @return \Urbem\CoreBundle\Entity\Ima\ExportacaoTcmBa
     */
    public function getFkImaExportacaoTcmBa()
    {
        return $this->fkImaExportacaoTcmBa;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImaTipoServidor
     *
     * @param \Urbem\CoreBundle\Entity\Ima\TipoServidor $fkImaTipoServidor
     * @return ExportacaoTcmBaSubDivisao
     */
    public function setFkImaTipoServidor(\Urbem\CoreBundle\Entity\Ima\TipoServidor $fkImaTipoServidor)
    {
        $this->codTipoServidor = $fkImaTipoServidor->getCodTipoServidor();
        $this->fkImaTipoServidor = $fkImaTipoServidor;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImaTipoServidor
     *
     * @return \Urbem\CoreBundle\Entity\Ima\TipoServidor
     */
    public function getFkImaTipoServidor()
    {
        return $this->fkImaTipoServidor;
    }
}
