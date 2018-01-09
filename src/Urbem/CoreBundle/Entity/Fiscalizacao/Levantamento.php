<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * Levantamento
 */
class Levantamento
{
    /**
     * PK
     * @var integer
     */
    private $codProcesso;

    /**
     * PK
     * @var string
     */
    private $competencia;

    /**
     * @var integer
     */
    private $receitaDeclarada;

    /**
     * @var integer
     */
    private $receitaEfetiva;

    /**
     * @var integer
     */
    private $issPago;

    /**
     * @var integer
     */
    private $issDevido;

    /**
     * @var integer
     */
    private $issDevolver;

    /**
     * @var integer
     */
    private $issPagar;

    /**
     * @var integer
     */
    private $totalDevolver;

    /**
     * @var integer
     */
    private $totalPagar;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento
     */
    private $fkFiscalizacaoProcessoLevantamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoCorrecao
     */
    private $fkFiscalizacaoLevantamentoCorrecoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoAcrescimo
     */
    private $fkFiscalizacaoLevantamentoAcrescimos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoLevantamentoCorrecoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoLevantamentoAcrescimos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codProcesso
     *
     * @param integer $codProcesso
     * @return Levantamento
     */
    public function setCodProcesso($codProcesso)
    {
        $this->codProcesso = $codProcesso;
        return $this;
    }

    /**
     * Get codProcesso
     *
     * @return integer
     */
    public function getCodProcesso()
    {
        return $this->codProcesso;
    }

    /**
     * Set competencia
     *
     * @param string $competencia
     * @return Levantamento
     */
    public function setCompetencia($competencia)
    {
        $this->competencia = $competencia;
        return $this;
    }

    /**
     * Get competencia
     *
     * @return string
     */
    public function getCompetencia()
    {
        return $this->competencia;
    }

    /**
     * Set receitaDeclarada
     *
     * @param integer $receitaDeclarada
     * @return Levantamento
     */
    public function setReceitaDeclarada($receitaDeclarada)
    {
        $this->receitaDeclarada = $receitaDeclarada;
        return $this;
    }

    /**
     * Get receitaDeclarada
     *
     * @return integer
     */
    public function getReceitaDeclarada()
    {
        return $this->receitaDeclarada;
    }

    /**
     * Set receitaEfetiva
     *
     * @param integer $receitaEfetiva
     * @return Levantamento
     */
    public function setReceitaEfetiva($receitaEfetiva)
    {
        $this->receitaEfetiva = $receitaEfetiva;
        return $this;
    }

    /**
     * Get receitaEfetiva
     *
     * @return integer
     */
    public function getReceitaEfetiva()
    {
        return $this->receitaEfetiva;
    }

    /**
     * Set issPago
     *
     * @param integer $issPago
     * @return Levantamento
     */
    public function setIssPago($issPago)
    {
        $this->issPago = $issPago;
        return $this;
    }

    /**
     * Get issPago
     *
     * @return integer
     */
    public function getIssPago()
    {
        return $this->issPago;
    }

    /**
     * Set issDevido
     *
     * @param integer $issDevido
     * @return Levantamento
     */
    public function setIssDevido($issDevido)
    {
        $this->issDevido = $issDevido;
        return $this;
    }

    /**
     * Get issDevido
     *
     * @return integer
     */
    public function getIssDevido()
    {
        return $this->issDevido;
    }

    /**
     * Set issDevolver
     *
     * @param integer $issDevolver
     * @return Levantamento
     */
    public function setIssDevolver($issDevolver)
    {
        $this->issDevolver = $issDevolver;
        return $this;
    }

    /**
     * Get issDevolver
     *
     * @return integer
     */
    public function getIssDevolver()
    {
        return $this->issDevolver;
    }

    /**
     * Set issPagar
     *
     * @param integer $issPagar
     * @return Levantamento
     */
    public function setIssPagar($issPagar)
    {
        $this->issPagar = $issPagar;
        return $this;
    }

    /**
     * Get issPagar
     *
     * @return integer
     */
    public function getIssPagar()
    {
        return $this->issPagar;
    }

    /**
     * Set totalDevolver
     *
     * @param integer $totalDevolver
     * @return Levantamento
     */
    public function setTotalDevolver($totalDevolver)
    {
        $this->totalDevolver = $totalDevolver;
        return $this;
    }

    /**
     * Get totalDevolver
     *
     * @return integer
     */
    public function getTotalDevolver()
    {
        return $this->totalDevolver;
    }

    /**
     * Set totalPagar
     *
     * @param integer $totalPagar
     * @return Levantamento
     */
    public function setTotalPagar($totalPagar)
    {
        $this->totalPagar = $totalPagar;
        return $this;
    }

    /**
     * Get totalPagar
     *
     * @return integer
     */
    public function getTotalPagar()
    {
        return $this->totalPagar;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoLevantamentoCorrecao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoCorrecao $fkFiscalizacaoLevantamentoCorrecao
     * @return Levantamento
     */
    public function addFkFiscalizacaoLevantamentoCorrecoes(\Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoCorrecao $fkFiscalizacaoLevantamentoCorrecao)
    {
        if (false === $this->fkFiscalizacaoLevantamentoCorrecoes->contains($fkFiscalizacaoLevantamentoCorrecao)) {
            $fkFiscalizacaoLevantamentoCorrecao->setFkFiscalizacaoLevantamento($this);
            $this->fkFiscalizacaoLevantamentoCorrecoes->add($fkFiscalizacaoLevantamentoCorrecao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoLevantamentoCorrecao
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoCorrecao $fkFiscalizacaoLevantamentoCorrecao
     */
    public function removeFkFiscalizacaoLevantamentoCorrecoes(\Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoCorrecao $fkFiscalizacaoLevantamentoCorrecao)
    {
        $this->fkFiscalizacaoLevantamentoCorrecoes->removeElement($fkFiscalizacaoLevantamentoCorrecao);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoLevantamentoCorrecoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoCorrecao
     */
    public function getFkFiscalizacaoLevantamentoCorrecoes()
    {
        return $this->fkFiscalizacaoLevantamentoCorrecoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoLevantamentoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoAcrescimo $fkFiscalizacaoLevantamentoAcrescimo
     * @return Levantamento
     */
    public function addFkFiscalizacaoLevantamentoAcrescimos(\Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoAcrescimo $fkFiscalizacaoLevantamentoAcrescimo)
    {
        if (false === $this->fkFiscalizacaoLevantamentoAcrescimos->contains($fkFiscalizacaoLevantamentoAcrescimo)) {
            $fkFiscalizacaoLevantamentoAcrescimo->setFkFiscalizacaoLevantamento($this);
            $this->fkFiscalizacaoLevantamentoAcrescimos->add($fkFiscalizacaoLevantamentoAcrescimo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoLevantamentoAcrescimo
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoAcrescimo $fkFiscalizacaoLevantamentoAcrescimo
     */
    public function removeFkFiscalizacaoLevantamentoAcrescimos(\Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoAcrescimo $fkFiscalizacaoLevantamentoAcrescimo)
    {
        $this->fkFiscalizacaoLevantamentoAcrescimos->removeElement($fkFiscalizacaoLevantamentoAcrescimo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoLevantamentoAcrescimos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\LevantamentoAcrescimo
     */
    public function getFkFiscalizacaoLevantamentoAcrescimos()
    {
        return $this->fkFiscalizacaoLevantamentoAcrescimos;
    }

    /**
     * OneToOne (owning side)
     * Set FiscalizacaoProcessoLevantamento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento $fkFiscalizacaoProcessoLevantamento
     * @return Levantamento
     */
    public function setFkFiscalizacaoProcessoLevantamento(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento $fkFiscalizacaoProcessoLevantamento)
    {
        $this->codProcesso = $fkFiscalizacaoProcessoLevantamento->getCodProcesso();
        $this->competencia = $fkFiscalizacaoProcessoLevantamento->getCompetencia();
        $this->fkFiscalizacaoProcessoLevantamento = $fkFiscalizacaoProcessoLevantamento;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFiscalizacaoProcessoLevantamento
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoLevantamento
     */
    public function getFkFiscalizacaoProcessoLevantamento()
    {
        return $this->fkFiscalizacaoProcessoLevantamento;
    }
}
