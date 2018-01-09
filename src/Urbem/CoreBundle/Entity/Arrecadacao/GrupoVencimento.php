<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * GrupoVencimento
 */
class GrupoVencimento
{
    /**
     * PK
     * @var integer
     */
    private $codGrupo;

    /**
     * PK
     * @var integer
     */
    private $codVencimento;

    /**
     * PK
     * @var string
     */
    private $anoExercicio;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var \DateTime
     */
    private $dataVencimentoParcelaUnica;

    /**
     * @var integer
     */
    private $limiteInicial;

    /**
     * @var integer
     */
    private $limiteFinal;

    /**
     * @var boolean
     */
    private $utilizarUnica;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Desconto
     */
    private $fkArrecadacaoDescontos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\VencimentoParcela
     */
    private $fkArrecadacaoVencimentoParcelas;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\CalendarioFiscal
     */
    private $fkArrecadacaoCalendarioFiscal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoDescontos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoVencimentoParcelas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return GrupoVencimento
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
     * Set codVencimento
     *
     * @param integer $codVencimento
     * @return GrupoVencimento
     */
    public function setCodVencimento($codVencimento)
    {
        $this->codVencimento = $codVencimento;
        return $this;
    }

    /**
     * Get codVencimento
     *
     * @return integer
     */
    public function getCodVencimento()
    {
        return $this->codVencimento;
    }

    /**
     * Set anoExercicio
     *
     * @param string $anoExercicio
     * @return GrupoVencimento
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
     * Set descricao
     *
     * @param string $descricao
     * @return GrupoVencimento
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set dataVencimentoParcelaUnica
     *
     * @param \DateTime $dataVencimentoParcelaUnica
     * @return GrupoVencimento
     */
    public function setDataVencimentoParcelaUnica(\DateTime $dataVencimentoParcelaUnica)
    {
        $this->dataVencimentoParcelaUnica = $dataVencimentoParcelaUnica;
        return $this;
    }

    /**
     * Get dataVencimentoParcelaUnica
     *
     * @return \DateTime
     */
    public function getDataVencimentoParcelaUnica()
    {
        return $this->dataVencimentoParcelaUnica;
    }

    /**
     * Set limiteInicial
     *
     * @param integer $limiteInicial
     * @return GrupoVencimento
     */
    public function setLimiteInicial($limiteInicial)
    {
        $this->limiteInicial = $limiteInicial;
        return $this;
    }

    /**
     * Get limiteInicial
     *
     * @return integer
     */
    public function getLimiteInicial()
    {
        return $this->limiteInicial;
    }

    /**
     * Set limiteFinal
     *
     * @param integer $limiteFinal
     * @return GrupoVencimento
     */
    public function setLimiteFinal($limiteFinal)
    {
        $this->limiteFinal = $limiteFinal;
        return $this;
    }

    /**
     * Get limiteFinal
     *
     * @return integer
     */
    public function getLimiteFinal()
    {
        return $this->limiteFinal;
    }

    /**
     * Set utilizarUnica
     *
     * @param boolean $utilizarUnica
     * @return GrupoVencimento
     */
    public function setUtilizarUnica($utilizarUnica)
    {
        $this->utilizarUnica = $utilizarUnica;
        return $this;
    }

    /**
     * Get utilizarUnica
     *
     * @return boolean
     */
    public function getUtilizarUnica()
    {
        return $this->utilizarUnica;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desconto $fkArrecadacaoDesconto
     * @return GrupoVencimento
     */
    public function addFkArrecadacaoDescontos(\Urbem\CoreBundle\Entity\Arrecadacao\Desconto $fkArrecadacaoDesconto)
    {
        if (false === $this->fkArrecadacaoDescontos->contains($fkArrecadacaoDesconto)) {
            $fkArrecadacaoDesconto->setFkArrecadacaoGrupoVencimento($this);
            $this->fkArrecadacaoDescontos->add($fkArrecadacaoDesconto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Desconto $fkArrecadacaoDesconto
     */
    public function removeFkArrecadacaoDescontos(\Urbem\CoreBundle\Entity\Arrecadacao\Desconto $fkArrecadacaoDesconto)
    {
        $this->fkArrecadacaoDescontos->removeElement($fkArrecadacaoDesconto);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoDescontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Desconto
     */
    public function getFkArrecadacaoDescontos()
    {
        return $this->fkArrecadacaoDescontos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoVencimentoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\VencimentoParcela $fkArrecadacaoVencimentoParcela
     * @return GrupoVencimento
     */
    public function addFkArrecadacaoVencimentoParcelas(\Urbem\CoreBundle\Entity\Arrecadacao\VencimentoParcela $fkArrecadacaoVencimentoParcela)
    {
        if (false === $this->fkArrecadacaoVencimentoParcelas->contains($fkArrecadacaoVencimentoParcela)) {
            $fkArrecadacaoVencimentoParcela->setFkArrecadacaoGrupoVencimento($this);
            $this->fkArrecadacaoVencimentoParcelas->add($fkArrecadacaoVencimentoParcela);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoVencimentoParcela
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\VencimentoParcela $fkArrecadacaoVencimentoParcela
     */
    public function removeFkArrecadacaoVencimentoParcelas(\Urbem\CoreBundle\Entity\Arrecadacao\VencimentoParcela $fkArrecadacaoVencimentoParcela)
    {
        $this->fkArrecadacaoVencimentoParcelas->removeElement($fkArrecadacaoVencimentoParcela);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoVencimentoParcelas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\VencimentoParcela
     */
    public function getFkArrecadacaoVencimentoParcelas()
    {
        return $this->fkArrecadacaoVencimentoParcelas;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoCalendarioFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CalendarioFiscal $fkArrecadacaoCalendarioFiscal
     * @return GrupoVencimento
     */
    public function setFkArrecadacaoCalendarioFiscal(\Urbem\CoreBundle\Entity\Arrecadacao\CalendarioFiscal $fkArrecadacaoCalendarioFiscal)
    {
        $this->codGrupo = $fkArrecadacaoCalendarioFiscal->getCodGrupo();
        $this->anoExercicio = $fkArrecadacaoCalendarioFiscal->getAnoExercicio();
        $this->fkArrecadacaoCalendarioFiscal = $fkArrecadacaoCalendarioFiscal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkArrecadacaoCalendarioFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\CalendarioFiscal
     */
    public function getFkArrecadacaoCalendarioFiscal()
    {
        return $this->fkArrecadacaoCalendarioFiscal;
    }
}
