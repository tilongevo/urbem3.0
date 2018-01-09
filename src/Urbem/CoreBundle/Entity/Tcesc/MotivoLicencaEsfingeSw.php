<?php
 
namespace Urbem\CoreBundle\Entity\Tcesc;

/**
 * MotivoLicencaEsfingeSw
 */
class MotivoLicencaEsfingeSw
{
    /**
     * PK
     * @var integer
     */
    private $codMotivoLicencaEsfinge;

    /**
     * PK
     * @var integer
     */
    private $codAssentamento;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfinge
     */
    private $fkTcescMotivoLicencaEsfinge;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    private $fkPessoalAssentamentoAssentamento;


    /**
     * Set codMotivoLicencaEsfinge
     *
     * @param integer $codMotivoLicencaEsfinge
     * @return MotivoLicencaEsfingeSw
     */
    public function setCodMotivoLicencaEsfinge($codMotivoLicencaEsfinge)
    {
        $this->codMotivoLicencaEsfinge = $codMotivoLicencaEsfinge;
        return $this;
    }

    /**
     * Get codMotivoLicencaEsfinge
     *
     * @return integer
     */
    public function getCodMotivoLicencaEsfinge()
    {
        return $this->codMotivoLicencaEsfinge;
    }

    /**
     * Set codAssentamento
     *
     * @param integer $codAssentamento
     * @return MotivoLicencaEsfingeSw
     */
    public function setCodAssentamento($codAssentamento)
    {
        $this->codAssentamento = $codAssentamento;
        return $this;
    }

    /**
     * Get codAssentamento
     *
     * @return integer
     */
    public function getCodAssentamento()
    {
        return $this->codAssentamento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcescMotivoLicencaEsfinge
     *
     * @param \Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfinge $fkTcescMotivoLicencaEsfinge
     * @return MotivoLicencaEsfingeSw
     */
    public function setFkTcescMotivoLicencaEsfinge(\Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfinge $fkTcescMotivoLicencaEsfinge)
    {
        $this->codMotivoLicencaEsfinge = $fkTcescMotivoLicencaEsfinge->getCodMotivoLicencaEsfinge();
        $this->fkTcescMotivoLicencaEsfinge = $fkTcescMotivoLicencaEsfinge;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcescMotivoLicencaEsfinge
     *
     * @return \Urbem\CoreBundle\Entity\Tcesc\MotivoLicencaEsfinge
     */
    public function getFkTcescMotivoLicencaEsfinge()
    {
        return $this->fkTcescMotivoLicencaEsfinge;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalAssentamentoAssentamento
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento
     * @return MotivoLicencaEsfingeSw
     */
    public function setFkPessoalAssentamentoAssentamento(\Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento $fkPessoalAssentamentoAssentamento)
    {
        $this->codAssentamento = $fkPessoalAssentamentoAssentamento->getCodAssentamento();
        $this->fkPessoalAssentamentoAssentamento = $fkPessoalAssentamentoAssentamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalAssentamentoAssentamento
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\AssentamentoAssentamento
     */
    public function getFkPessoalAssentamentoAssentamento()
    {
        return $this->fkPessoalAssentamentoAssentamento;
    }
}
