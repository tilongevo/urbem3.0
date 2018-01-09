<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * TabelaConversao
 */
class TabelaConversao
{
    /**
     * PK
     * @var integer
     */
    private $codTabela;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var string
     */
    private $nomeTabela;

    /**
     * @var string
     */
    private $parametro1;

    /**
     * @var string
     */
    private $parametro2;

    /**
     * @var string
     */
    private $parametro3;

    /**
     * @var string
     */
    private $parametro4;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversaoValores
     */
    private $fkArrecadacaoTabelaConversaoValoreses;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\ArrecadacaoModulos
     */
    private $fkArrecadacaoArrecadacaoModulos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoTabelaConversaoValoreses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTabela
     *
     * @param integer $codTabela
     * @return TabelaConversao
     */
    public function setCodTabela($codTabela)
    {
        $this->codTabela = $codTabela;
        return $this;
    }

    /**
     * Get codTabela
     *
     * @return integer
     */
    public function getCodTabela()
    {
        return $this->codTabela;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return TabelaConversao
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return TabelaConversao
     */
    public function setCodModulo($codModulo)
    {
        $this->codModulo = $codModulo;
        return $this;
    }

    /**
     * Get codModulo
     *
     * @return integer
     */
    public function getCodModulo()
    {
        return $this->codModulo;
    }

    /**
     * Set nomeTabela
     *
     * @param string $nomeTabela
     * @return TabelaConversao
     */
    public function setNomeTabela($nomeTabela)
    {
        $this->nomeTabela = $nomeTabela;
        return $this;
    }

    /**
     * Get nomeTabela
     *
     * @return string
     */
    public function getNomeTabela()
    {
        return $this->nomeTabela;
    }

    /**
     * Set parametro1
     *
     * @param string $parametro1
     * @return TabelaConversao
     */
    public function setParametro1($parametro1)
    {
        $this->parametro1 = $parametro1;
        return $this;
    }

    /**
     * Get parametro1
     *
     * @return string
     */
    public function getParametro1()
    {
        return $this->parametro1;
    }

    /**
     * Set parametro2
     *
     * @param string $parametro2
     * @return TabelaConversao
     */
    public function setParametro2($parametro2 = null)
    {
        $this->parametro2 = $parametro2;
        return $this;
    }

    /**
     * Get parametro2
     *
     * @return string
     */
    public function getParametro2()
    {
        return $this->parametro2;
    }

    /**
     * Set parametro3
     *
     * @param string $parametro3
     * @return TabelaConversao
     */
    public function setParametro3($parametro3 = null)
    {
        $this->parametro3 = $parametro3;
        return $this;
    }

    /**
     * Get parametro3
     *
     * @return string
     */
    public function getParametro3()
    {
        return $this->parametro3;
    }

    /**
     * Set parametro4
     *
     * @param string $parametro4
     * @return TabelaConversao
     */
    public function setParametro4($parametro4 = null)
    {
        $this->parametro4 = $parametro4;
        return $this;
    }

    /**
     * Get parametro4
     *
     * @return string
     */
    public function getParametro4()
    {
        return $this->parametro4;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoTabelaConversaoValores
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversaoValores $fkArrecadacaoTabelaConversaoValores
     * @return TabelaConversao
     */
    public function addFkArrecadacaoTabelaConversaoValoreses(\Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversaoValores $fkArrecadacaoTabelaConversaoValores)
    {
        if (false === $this->fkArrecadacaoTabelaConversaoValoreses->contains($fkArrecadacaoTabelaConversaoValores)) {
            $fkArrecadacaoTabelaConversaoValores->setFkArrecadacaoTabelaConversao($this);
            $this->fkArrecadacaoTabelaConversaoValoreses->add($fkArrecadacaoTabelaConversaoValores);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoTabelaConversaoValores
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversaoValores $fkArrecadacaoTabelaConversaoValores
     */
    public function removeFkArrecadacaoTabelaConversaoValoreses(\Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversaoValores $fkArrecadacaoTabelaConversaoValores)
    {
        $this->fkArrecadacaoTabelaConversaoValoreses->removeElement($fkArrecadacaoTabelaConversaoValores);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoTabelaConversaoValoreses
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversaoValores
     */
    public function getFkArrecadacaoTabelaConversaoValoreses()
    {
        return $this->fkArrecadacaoTabelaConversaoValoreses;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoArrecadacaoModulos
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ArrecadacaoModulos $fkArrecadacaoArrecadacaoModulos
     * @return TabelaConversao
     */
    public function setFkArrecadacaoArrecadacaoModulos(\Urbem\CoreBundle\Entity\Arrecadacao\ArrecadacaoModulos $fkArrecadacaoArrecadacaoModulos)
    {
        $this->codModulo = $fkArrecadacaoArrecadacaoModulos->getCodModulo();
        $this->fkArrecadacaoArrecadacaoModulos = $fkArrecadacaoArrecadacaoModulos;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoArrecadacaoModulos
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\ArrecadacaoModulos
     */
    public function getFkArrecadacaoArrecadacaoModulos()
    {
        return $this->fkArrecadacaoArrecadacaoModulos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%d - %s/%s', $this->codTabela, $this->nomeTabela, $this->exercicio);
    }
}
