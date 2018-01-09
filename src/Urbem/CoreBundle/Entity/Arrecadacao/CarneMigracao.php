<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * CarneMigracao
 */
class CarneMigracao
{
    /**
     * PK
     * @var string
     */
    private $numeracao;

    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * @var string
     */
    private $prefixo;

    /**
     * @var string
     */
    private $numeracaoMigracao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    private $fkArrecadacaoCarne;


    /**
     * Set numeracao
     *
     * @param string $numeracao
     * @return CarneMigracao
     */
    public function setNumeracao($numeracao)
    {
        $this->numeracao = $numeracao;
        return $this;
    }

    /**
     * Get numeracao
     *
     * @return string
     */
    public function getNumeracao()
    {
        return $this->numeracao;
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return CarneMigracao
     */
    public function setCodConvenio($codConvenio)
    {
        $this->codConvenio = $codConvenio;
        return $this;
    }

    /**
     * Get codConvenio
     *
     * @return integer
     */
    public function getCodConvenio()
    {
        return $this->codConvenio;
    }

    /**
     * Set prefixo
     *
     * @param string $prefixo
     * @return CarneMigracao
     */
    public function setPrefixo($prefixo = null)
    {
        $this->prefixo = $prefixo;
        return $this;
    }

    /**
     * Get prefixo
     *
     * @return string
     */
    public function getPrefixo()
    {
        return $this->prefixo;
    }

    /**
     * Set numeracaoMigracao
     *
     * @param string $numeracaoMigracao
     * @return CarneMigracao
     */
    public function setNumeracaoMigracao($numeracaoMigracao)
    {
        $this->numeracaoMigracao = $numeracaoMigracao;
        return $this;
    }

    /**
     * Get numeracaoMigracao
     *
     * @return string
     */
    public function getNumeracaoMigracao()
    {
        return $this->numeracaoMigracao;
    }

    /**
     * OneToOne (owning side)
     * Set ArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne
     * @return CarneMigracao
     */
    public function setFkArrecadacaoCarne(\Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne)
    {
        $this->numeracao = $fkArrecadacaoCarne->getNumeracao();
        $this->codConvenio = $fkArrecadacaoCarne->getCodConvenio();
        $this->fkArrecadacaoCarne = $fkArrecadacaoCarne;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoCarne
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    public function getFkArrecadacaoCarne()
    {
        return $this->fkArrecadacaoCarne;
    }
}
