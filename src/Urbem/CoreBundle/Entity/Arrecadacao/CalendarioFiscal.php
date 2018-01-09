<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * CalendarioFiscal
 */
class CalendarioFiscal
{
    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * @var integer
     */
    private $valorMinimo;

    /**
     * @var integer
     */
    private $valorMinimoLancamento;

    /**
     * @var integer
     */
    private $valorMinimoParcela;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito
     */
    private $fkArrecadacaoGrupoCredito;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCalendarioValor
     */
    private $fkArrecadacaoAtributoCalendarioValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento
     */
    private $fkArrecadacaoGrupoVencimentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoAtributoCalendarioValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoGrupoVencimentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return CalendarioFiscal
     */
    public function setCodGrupo($codGrupo)
    {
        $this->codGrupo = $codGrupo;
        return $this;
    }

    /**
     * Get codGrupo
     *
     * @return integer
     */
    public function getCodGrupo()
    {
        return $this->codGrupo;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return CalendarioFiscal
     */
    public function setAnoExercicio($anoExercicio)
    {
        $this->anoExercicio = $anoExercicio;
        return $this;
    }

    /**
     * Get anoExercicio
     *
     * @return string
     */
    public function getAnoExercicio()
    {
        return $this->anoExercicio;
    }

    /**
     * Set valorMinimo
     *
     * @param integer $valorMinimo
     * @return CalendarioFiscal
     */
    public function setValorMinimo($valorMinimo)
    {
        $this->valorMinimo = $valorMinimo;
        return $this;
    }

    /**
     * Get valorMinimo
     *
     * @return integer
     */
    public function getValorMinimo()
    {
        return $this->valorMinimo;
    }

    /**
     * Set valorMinimoLancamento
     *
     * @param integer $valorMinimoLancamento
     * @return CalendarioFiscal
     */
    public function setValorMinimoLancamento($valorMinimoLancamento)
    {
        $this->valorMinimoLancamento = $valorMinimoLancamento;
        return $this;
    }

    /**
     * Get valorMinimoLancamento
     *
     * @return integer
     */
    public function getValorMinimoLancamento()
    {
        return $this->valorMinimoLancamento;
    }

    /**
     * Set valorMinimoParcela
     *
     * @param integer $valorMinimoParcela
     * @return CalendarioFiscal
     */
    public function setValorMinimoParcela($valorMinimoParcela)
    {
        $this->valorMinimoParcela = $valorMinimoParcela;
        return $this;
    }

    /**
     * Get valorMinimoParcela
     *
     * @return integer
     */
    public function getValorMinimoParcela()
    {
        return $this->valorMinimoParcela;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAtributoCalendarioValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoCalendarioValor $fkArrecadacaoAtributoCalendarioValor
     * @return CalendarioFiscal
     */
    public function addFkArrecadacaoAtributoCalendarioValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCalendarioValor $fkArrecadacaoAtributoCalendarioValor)
    {
        if (false === $this->fkArrecadacaoAtributoCalendarioValores->contains($fkArrecadacaoAtributoCalendarioValor)) {
            $fkArrecadacaoAtributoCalendarioValor->setFkArrecadacaoCalendarioFiscal($this);
            $this->fkArrecadacaoAtributoCalendarioValores->add($fkArrecadacaoAtributoCalendarioValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAtributoCalendarioValor
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoCalendarioValor $fkArrecadacaoAtributoCalendarioValor
     */
    public function removeFkArrecadacaoAtributoCalendarioValores(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCalendarioValor $fkArrecadacaoAtributoCalendarioValor)
    {
        $this->fkArrecadacaoAtributoCalendarioValores->removeElement($fkArrecadacaoAtributoCalendarioValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAtributoCalendarioValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoCalendarioValor
     */
    public function getFkArrecadacaoAtributoCalendarioValores()
    {
        return $this->fkArrecadacaoAtributoCalendarioValores;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoGrupoVencimento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento $fkArrecadacaoGrupoVencimento
     * @return CalendarioFiscal
     */
    public function addFkArrecadacaoGrupoVencimentos(\Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento $fkArrecadacaoGrupoVencimento)
    {
        if (false === $this->fkArrecadacaoGrupoVencimentos->contains($fkArrecadacaoGrupoVencimento)) {
            $fkArrecadacaoGrupoVencimento->setFkArrecadacaoCalendarioFiscal($this);
            $this->fkArrecadacaoGrupoVencimentos->add($fkArrecadacaoGrupoVencimento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoGrupoVencimento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento $fkArrecadacaoGrupoVencimento
     */
    public function removeFkArrecadacaoGrupoVencimentos(\Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento $fkArrecadacaoGrupoVencimento)
    {
        $this->fkArrecadacaoGrupoVencimentos->removeElement($fkArrecadacaoGrupoVencimento);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoGrupoVencimentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\GrupoVencimento
     */
    public function getFkArrecadacaoGrupoVencimentos()
    {
        return $this->fkArrecadacaoGrupoVencimentos;
    }

    /**
     * OneToOne (owning side)
     * Set ArrecadacaoGrupoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito $fkArrecadacaoGrupoCredito
     * @return CalendarioFiscal
     */
    public function setFkArrecadacaoGrupoCredito(\Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito $fkArrecadacaoGrupoCredito)
    {
        $this->codGrupo = $fkArrecadacaoGrupoCredito->getCodGrupo();
        $this->anoExercicio = $fkArrecadacaoGrupoCredito->getAnoExercicio();
        $this->fkArrecadacaoGrupoCredito = $fkArrecadacaoGrupoCredito;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoGrupoCredito
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito
     */
    public function getFkArrecadacaoGrupoCredito()
    {
        return $this->fkArrecadacaoGrupoCredito;
    }
}
