<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * ImovelCalculo
 */
class ImovelCalculo
{
    /**
     * PK
     * @var integer
     */
    private $codCalculo;

    /**
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    private $fkArrecadacaoCalculo;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal
     */
    private $fkArrecadacaoImovelVVenal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCalculo
     *
     * @param integer $codCalculo
     * @return ImovelCalculo
     */
    public function setCodCalculo($codCalculo)
    {
        $this->codCalculo = $codCalculo;
        return $this;
    }

    /**
     * Get codCalculo
     *
     * @return integer
     */
    public function getCodCalculo()
    {
        return $this->codCalculo;
    }

    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return ImovelCalculo
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return ImovelCalculo
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
     * ManyToOne (inverse side)
     * Set fkArrecadacaoImovelVVenal
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal $fkArrecadacaoImovelVVenal
     * @return ImovelCalculo
     */
    public function setFkArrecadacaoImovelVVenal(\Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal $fkArrecadacaoImovelVVenal)
    {
        $this->inscricaoMunicipal = $fkArrecadacaoImovelVVenal->getInscricaoMunicipal();
        $this->timestamp = $fkArrecadacaoImovelVVenal->getTimestamp();
        $this->fkArrecadacaoImovelVVenal = $fkArrecadacaoImovelVVenal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoImovelVVenal
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal
     */
    public function getFkArrecadacaoImovelVVenal()
    {
        return $this->fkArrecadacaoImovelVVenal;
    }

    /**
     * OneToOne (owning side)
     * Set ArrecadacaoCalculo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo
     * @return ImovelCalculo
     */
    public function setFkArrecadacaoCalculo(\Urbem\CoreBundle\Entity\Arrecadacao\Calculo $fkArrecadacaoCalculo)
    {
        $this->codCalculo = $fkArrecadacaoCalculo->getCodCalculo();
        $this->fkArrecadacaoCalculo = $fkArrecadacaoCalculo;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoCalculo
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Calculo
     */
    public function getFkArrecadacaoCalculo()
    {
        return $this->fkArrecadacaoCalculo;
    }
}
