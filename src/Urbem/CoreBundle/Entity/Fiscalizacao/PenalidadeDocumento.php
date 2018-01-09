<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * PenalidadeDocumento
 */
class PenalidadeDocumento
{
    /**
     * PK
     * @var integer
     */
    private $codPenalidade;

    /**
     * @var integer
     */
    private $codTipoDocumento;

    /**
     * @var integer
     */
    private $codDocumento;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade
     */
    private $fkFiscalizacaoPenalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    private $fkAdministracaoModeloDocumento;


    /**
     * Set codPenalidade
     *
     * @param integer $codPenalidade
     * @return PenalidadeDocumento
     */
    public function setCodPenalidade($codPenalidade)
    {
        $this->codPenalidade = $codPenalidade;
        return $this;
    }

    /**
     * Get codPenalidade
     *
     * @return integer
     */
    public function getCodPenalidade()
    {
        return $this->codPenalidade;
    }

    /**
     * Set codTipoDocumento
     *
     * @param integer $codTipoDocumento
     * @return PenalidadeDocumento
     */
    public function setCodTipoDocumento($codTipoDocumento)
    {
        $this->codTipoDocumento = $codTipoDocumento;
        return $this;
    }

    /**
     * Get codTipoDocumento
     *
     * @return integer
     */
    public function getCodTipoDocumento()
    {
        return $this->codTipoDocumento;
    }

    /**
     * Set codDocumento
     *
     * @param integer $codDocumento
     * @return PenalidadeDocumento
     */
    public function setCodDocumento($codDocumento)
    {
        $this->codDocumento = $codDocumento;
        return $this;
    }

    /**
     * Get codDocumento
     *
     * @return integer
     */
    public function getCodDocumento()
    {
        return $this->codDocumento;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoModeloDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento
     * @return PenalidadeDocumento
     */
    public function setFkAdministracaoModeloDocumento(\Urbem\CoreBundle\Entity\Administracao\ModeloDocumento $fkAdministracaoModeloDocumento)
    {
        $this->codDocumento = $fkAdministracaoModeloDocumento->getCodDocumento();
        $this->codTipoDocumento = $fkAdministracaoModeloDocumento->getCodTipoDocumento();
        $this->fkAdministracaoModeloDocumento = $fkAdministracaoModeloDocumento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoModeloDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\ModeloDocumento
     */
    public function getFkAdministracaoModeloDocumento()
    {
        return $this->fkAdministracaoModeloDocumento;
    }

    /**
     * OneToOne (owning side)
     * Set FiscalizacaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade
     * @return PenalidadeDocumento
     */
    public function setFkFiscalizacaoPenalidade(\Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade)
    {
        $this->codPenalidade = $fkFiscalizacaoPenalidade->getCodPenalidade();
        $this->fkFiscalizacaoPenalidade = $fkFiscalizacaoPenalidade;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFiscalizacaoPenalidade
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade
     */
    public function getFkFiscalizacaoPenalidade()
    {
        return $this->fkFiscalizacaoPenalidade;
    }
}
