<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * CarneDevolucao
 */
class CarneDevolucao
{
    /**
     * PK
     * @var string
     */
    private $numeracao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * @var integer
     */
    private $codMotivo;

    /**
     * @var \DateTime
     */
    private $dtDevolucao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    private $fkArrecadacaoCarne;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\MotivoDevolucao
     */
    private $fkArrecadacaoMotivoDevolucao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set numeracao
     *
     * @param string $numeracao
     * @return CarneDevolucao
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
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return CarneDevolucao
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return CarneDevolucao
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
     * Set codMotivo
     *
     * @param integer $codMotivo
     * @return CarneDevolucao
     */
    public function setCodMotivo($codMotivo)
    {
        $this->codMotivo = $codMotivo;
        return $this;
    }

    /**
     * Get codMotivo
     *
     * @return integer
     */
    public function getCodMotivo()
    {
        return $this->codMotivo;
    }

    /**
     * Set dtDevolucao
     *
     * @param \DateTime $dtDevolucao
     * @return CarneDevolucao
     */
    public function setDtDevolucao(\DateTime $dtDevolucao)
    {
        $this->dtDevolucao = $dtDevolucao;
        return $this;
    }

    /**
     * Get dtDevolucao
     *
     * @return \DateTime
     */
    public function getDtDevolucao()
    {
        return $this->dtDevolucao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne
     * @return CarneDevolucao
     */
    public function setFkArrecadacaoCarne(\Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne)
    {
        $this->numeracao = $fkArrecadacaoCarne->getNumeracao();
        $this->codConvenio = $fkArrecadacaoCarne->getCodConvenio();
        $this->fkArrecadacaoCarne = $fkArrecadacaoCarne;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoCarne
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    public function getFkArrecadacaoCarne()
    {
        return $this->fkArrecadacaoCarne;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoMotivoDevolucao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\MotivoDevolucao $fkArrecadacaoMotivoDevolucao
     * @return CarneDevolucao
     */
    public function setFkArrecadacaoMotivoDevolucao(\Urbem\CoreBundle\Entity\Arrecadacao\MotivoDevolucao $fkArrecadacaoMotivoDevolucao)
    {
        $this->codMotivo = $fkArrecadacaoMotivoDevolucao->getCodMotivo();
        $this->fkArrecadacaoMotivoDevolucao = $fkArrecadacaoMotivoDevolucao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoMotivoDevolucao
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\MotivoDevolucao
     */
    public function getFkArrecadacaoMotivoDevolucao()
    {
        return $this->fkArrecadacaoMotivoDevolucao;
    }
}
