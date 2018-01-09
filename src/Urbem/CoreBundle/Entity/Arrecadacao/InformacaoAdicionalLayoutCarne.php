<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * InformacaoAdicionalLayoutCarne
 */
class InformacaoAdicionalLayoutCarne
{
    /**
     * PK
     * @var integer
     */
    private $codModelo;

    /**
     * PK
     * @var integer
     */
    private $codInformacao;

    /**
     * @var integer
     */
    private $ordem;

    /**
     * @var integer
     */
    private $posicaoInicial;

    /**
     * @var integer
     */
    private $largura;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne
     */
    private $fkArrecadacaoModeloCarne;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicional
     */
    private $fkArrecadacaoInformacaoAdicional;


    /**
     * Set codModelo
     *
     * @param integer $codModelo
     * @return InformacaoAdicionalLayoutCarne
     */
    public function setCodModelo($codModelo)
    {
        $this->codModelo = $codModelo;
        return $this;
    }

    /**
     * Get codModelo
     *
     * @return integer
     */
    public function getCodModelo()
    {
        return $this->codModelo;
    }

    /**
     * Set codInformacao
     *
     * @param integer $codInformacao
     * @return InformacaoAdicionalLayoutCarne
     */
    public function setCodInformacao($codInformacao)
    {
        $this->codInformacao = $codInformacao;
        return $this;
    }

    /**
     * Get codInformacao
     *
     * @return integer
     */
    public function getCodInformacao()
    {
        return $this->codInformacao;
    }

    /**
     * Set ordem
     *
     * @param integer $ordem
     * @return InformacaoAdicionalLayoutCarne
     */
    public function setOrdem($ordem)
    {
        $this->ordem = $ordem;
        return $this;
    }

    /**
     * Get ordem
     *
     * @return integer
     */
    public function getOrdem()
    {
        return $this->ordem;
    }

    /**
     * Set posicaoInicial
     *
     * @param integer $posicaoInicial
     * @return InformacaoAdicionalLayoutCarne
     */
    public function setPosicaoInicial($posicaoInicial)
    {
        $this->posicaoInicial = $posicaoInicial;
        return $this;
    }

    /**
     * Get posicaoInicial
     *
     * @return integer
     */
    public function getPosicaoInicial()
    {
        return $this->posicaoInicial;
    }

    /**
     * Set largura
     *
     * @param integer $largura
     * @return InformacaoAdicionalLayoutCarne
     */
    public function setLargura($largura)
    {
        $this->largura = $largura;
        return $this;
    }

    /**
     * Get largura
     *
     * @return integer
     */
    public function getLargura()
    {
        return $this->largura;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoModeloCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne $fkArrecadacaoModeloCarne
     * @return InformacaoAdicionalLayoutCarne
     */
    public function setFkArrecadacaoModeloCarne(\Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne $fkArrecadacaoModeloCarne)
    {
        $this->codModelo = $fkArrecadacaoModeloCarne->getCodModelo();
        $this->fkArrecadacaoModeloCarne = $fkArrecadacaoModeloCarne;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoModeloCarne
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\ModeloCarne
     */
    public function getFkArrecadacaoModeloCarne()
    {
        return $this->fkArrecadacaoModeloCarne;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoInformacaoAdicional
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicional $fkArrecadacaoInformacaoAdicional
     * @return InformacaoAdicionalLayoutCarne
     */
    public function setFkArrecadacaoInformacaoAdicional(\Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicional $fkArrecadacaoInformacaoAdicional)
    {
        $this->codInformacao = $fkArrecadacaoInformacaoAdicional->getCodInformacao();
        $this->fkArrecadacaoInformacaoAdicional = $fkArrecadacaoInformacaoAdicional;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoInformacaoAdicional
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\InformacaoAdicional
     */
    public function getFkArrecadacaoInformacaoAdicional()
    {
        return $this->fkArrecadacaoInformacaoAdicional;
    }
}
