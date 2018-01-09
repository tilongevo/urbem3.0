<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * RetencaoServico
 */
class RetencaoServico
{
    /**
     * PK
     * @var integer
     */
    private $codNota;

    /**
     * PK
     * @var integer
     */
    private $numServico;

    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * PK
     * @var integer
     */
    private $codRetencao;

    /**
     * @var integer
     */
    private $codServico;

    /**
     * @var integer
     */
    private $valorDeclarado;

    /**
     * @var integer
     */
    private $valorDeducao;

    /**
     * @var integer
     */
    private $valorLancado;

    /**
     * @var integer
     */
    private $aliquota;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota
     */
    private $fkArrecadacaoRetencaoNota;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\Servico
     */
    private $fkEconomicoServico;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codNota
     *
     * @param integer $codNota
     * @return RetencaoServico
     */
    public function setCodNota($codNota)
    {
        $this->codNota = $codNota;
        return $this;
    }

    /**
     * Get codNota
     *
     * @return integer
     */
    public function getCodNota()
    {
        return $this->codNota;
    }

    /**
     * Set numServico
     *
     * @param integer $numServico
     * @return RetencaoServico
     */
    public function setNumServico($numServico)
    {
        $this->numServico = $numServico;
        return $this;
    }

    /**
     * Get numServico
     *
     * @return integer
     */
    public function getNumServico()
    {
        return $this->numServico;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return RetencaoServico
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return RetencaoServico
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
     * Set codRetencao
     *
     * @param integer $codRetencao
     * @return RetencaoServico
     */
    public function setCodRetencao($codRetencao)
    {
        $this->codRetencao = $codRetencao;
        return $this;
    }

    /**
     * Get codRetencao
     *
     * @return integer
     */
    public function getCodRetencao()
    {
        return $this->codRetencao;
    }

    /**
     * Set codServico
     *
     * @param integer $codServico
     * @return RetencaoServico
     */
    public function setCodServico($codServico)
    {
        $this->codServico = $codServico;
        return $this;
    }

    /**
     * Get codServico
     *
     * @return integer
     */
    public function getCodServico()
    {
        return $this->codServico;
    }

    /**
     * Set valorDeclarado
     *
     * @param integer $valorDeclarado
     * @return RetencaoServico
     */
    public function setValorDeclarado($valorDeclarado)
    {
        $this->valorDeclarado = $valorDeclarado;
        return $this;
    }

    /**
     * Get valorDeclarado
     *
     * @return integer
     */
    public function getValorDeclarado()
    {
        return $this->valorDeclarado;
    }

    /**
     * Set valorDeducao
     *
     * @param integer $valorDeducao
     * @return RetencaoServico
     */
    public function setValorDeducao($valorDeducao)
    {
        $this->valorDeducao = $valorDeducao;
        return $this;
    }

    /**
     * Get valorDeducao
     *
     * @return integer
     */
    public function getValorDeducao()
    {
        return $this->valorDeducao;
    }

    /**
     * Set valorLancado
     *
     * @param integer $valorLancado
     * @return RetencaoServico
     */
    public function setValorLancado($valorLancado)
    {
        $this->valorLancado = $valorLancado;
        return $this;
    }

    /**
     * Get valorLancado
     *
     * @return integer
     */
    public function getValorLancado()
    {
        return $this->valorLancado;
    }

    /**
     * Set aliquota
     *
     * @param integer $aliquota
     * @return RetencaoServico
     */
    public function setAliquota($aliquota)
    {
        $this->aliquota = $aliquota;
        return $this;
    }

    /**
     * Get aliquota
     *
     * @return integer
     */
    public function getAliquota()
    {
        return $this->aliquota;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoRetencaoNota
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota $fkArrecadacaoRetencaoNota
     * @return RetencaoServico
     */
    public function setFkArrecadacaoRetencaoNota(\Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota $fkArrecadacaoRetencaoNota)
    {
        $this->codNota = $fkArrecadacaoRetencaoNota->getCodNota();
        $this->inscricaoEconomica = $fkArrecadacaoRetencaoNota->getInscricaoEconomica();
        $this->timestamp = $fkArrecadacaoRetencaoNota->getTimestamp();
        $this->codRetencao = $fkArrecadacaoRetencaoNota->getCodRetencao();
        $this->fkArrecadacaoRetencaoNota = $fkArrecadacaoRetencaoNota;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoRetencaoNota
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\RetencaoNota
     */
    public function getFkArrecadacaoRetencaoNota()
    {
        return $this->fkArrecadacaoRetencaoNota;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoServico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\Servico $fkEconomicoServico
     * @return RetencaoServico
     */
    public function setFkEconomicoServico(\Urbem\CoreBundle\Entity\Economico\Servico $fkEconomicoServico)
    {
        $this->codServico = $fkEconomicoServico->getCodServico();
        $this->fkEconomicoServico = $fkEconomicoServico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoServico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\Servico
     */
    public function getFkEconomicoServico()
    {
        return $this->fkEconomicoServico;
    }
}
