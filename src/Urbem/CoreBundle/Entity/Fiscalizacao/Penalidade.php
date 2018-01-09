<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * Penalidade
 */
class Penalidade
{
    /**
     * PK
     * @var integer
     */
    private $codPenalidade;

    /**
     * @var integer
     */
    private $codTipoPenalidade;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var string
     */
    private $nomPenalidade;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDocumento
     */
    private $fkFiscalizacaoPenalidadeDocumento;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta
     */
    private $fkFiscalizacaoPenalidadeMulta;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade
     */
    private $fkFiscalizacaoInfracaoPenalidades;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixa
     */
    private $fkFiscalizacaoPenalidadeBaixas;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDesconto
     */
    private $fkFiscalizacaoPenalidadeDescontos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\TipoPenalidade
     */
    private $fkFiscalizacaoTipoPenalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFiscalizacaoInfracaoPenalidades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoPenalidadeBaixas = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoPenalidadeDescontos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPenalidade
     *
     * @param integer $codPenalidade
     * @return Penalidade
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
     * Set codTipoPenalidade
     *
     * @param integer $codTipoPenalidade
     * @return Penalidade
     */
    public function setCodTipoPenalidade($codTipoPenalidade)
    {
        $this->codTipoPenalidade = $codTipoPenalidade;
        return $this;
    }

    /**
     * Get codTipoPenalidade
     *
     * @return integer
     */
    public function getCodTipoPenalidade()
    {
        return $this->codTipoPenalidade;
    }

    /**
     * Set codNorma
     *
     * @param integer $codNorma
     * @return Penalidade
     */
    public function setCodNorma($codNorma)
    {
        $this->codNorma = $codNorma;
        return $this;
    }

    /**
     * Get codNorma
     *
     * @return integer
     */
    public function getCodNorma()
    {
        return $this->codNorma;
    }

    /**
     * Set nomPenalidade
     *
     * @param string $nomPenalidade
     * @return Penalidade
     */
    public function setNomPenalidade($nomPenalidade)
    {
        $this->nomPenalidade = $nomPenalidade;
        return $this;
    }

    /**
     * Get nomPenalidade
     *
     * @return string
     */
    public function getNomPenalidade()
    {
        return $this->nomPenalidade;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoInfracaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade $fkFiscalizacaoInfracaoPenalidade
     * @return Penalidade
     */
    public function addFkFiscalizacaoInfracaoPenalidades(\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade $fkFiscalizacaoInfracaoPenalidade)
    {
        if (false === $this->fkFiscalizacaoInfracaoPenalidades->contains($fkFiscalizacaoInfracaoPenalidade)) {
            $fkFiscalizacaoInfracaoPenalidade->setFkFiscalizacaoPenalidade($this);
            $this->fkFiscalizacaoInfracaoPenalidades->add($fkFiscalizacaoInfracaoPenalidade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoInfracaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade $fkFiscalizacaoInfracaoPenalidade
     */
    public function removeFkFiscalizacaoInfracaoPenalidades(\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade $fkFiscalizacaoInfracaoPenalidade)
    {
        $this->fkFiscalizacaoInfracaoPenalidades->removeElement($fkFiscalizacaoInfracaoPenalidade);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoInfracaoPenalidades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\InfracaoPenalidade
     */
    public function getFkFiscalizacaoInfracaoPenalidades()
    {
        return $this->fkFiscalizacaoInfracaoPenalidades;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoPenalidadeBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixa $fkFiscalizacaoPenalidadeBaixa
     * @return Penalidade
     */
    public function addFkFiscalizacaoPenalidadeBaixas(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixa $fkFiscalizacaoPenalidadeBaixa)
    {
        if (false === $this->fkFiscalizacaoPenalidadeBaixas->contains($fkFiscalizacaoPenalidadeBaixa)) {
            $fkFiscalizacaoPenalidadeBaixa->setFkFiscalizacaoPenalidade($this);
            $this->fkFiscalizacaoPenalidadeBaixas->add($fkFiscalizacaoPenalidadeBaixa);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoPenalidadeBaixa
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixa $fkFiscalizacaoPenalidadeBaixa
     */
    public function removeFkFiscalizacaoPenalidadeBaixas(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixa $fkFiscalizacaoPenalidadeBaixa)
    {
        $this->fkFiscalizacaoPenalidadeBaixas->removeElement($fkFiscalizacaoPenalidadeBaixa);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoPenalidadeBaixas
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeBaixa
     */
    public function getFkFiscalizacaoPenalidadeBaixas()
    {
        return $this->fkFiscalizacaoPenalidadeBaixas;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoPenalidadeDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDesconto $fkFiscalizacaoPenalidadeDesconto
     * @return Penalidade
     */
    public function addFkFiscalizacaoPenalidadeDescontos(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDesconto $fkFiscalizacaoPenalidadeDesconto)
    {
        if (false === $this->fkFiscalizacaoPenalidadeDescontos->contains($fkFiscalizacaoPenalidadeDesconto)) {
            $fkFiscalizacaoPenalidadeDesconto->setFkFiscalizacaoPenalidade($this);
            $this->fkFiscalizacaoPenalidadeDescontos->add($fkFiscalizacaoPenalidadeDesconto);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoPenalidadeDesconto
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDesconto $fkFiscalizacaoPenalidadeDesconto
     */
    public function removeFkFiscalizacaoPenalidadeDescontos(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDesconto $fkFiscalizacaoPenalidadeDesconto)
    {
        $this->fkFiscalizacaoPenalidadeDescontos->removeElement($fkFiscalizacaoPenalidadeDesconto);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoPenalidadeDescontos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDesconto
     */
    public function getFkFiscalizacaoPenalidadeDescontos()
    {
        return $this->fkFiscalizacaoPenalidadeDescontos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkFiscalizacaoTipoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\TipoPenalidade $fkFiscalizacaoTipoPenalidade
     * @return Penalidade
     */
    public function setFkFiscalizacaoTipoPenalidade(\Urbem\CoreBundle\Entity\Fiscalizacao\TipoPenalidade $fkFiscalizacaoTipoPenalidade)
    {
        $this->codTipoPenalidade = $fkFiscalizacaoTipoPenalidade->getCodTipo();
        $this->fkFiscalizacaoTipoPenalidade = $fkFiscalizacaoTipoPenalidade;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkFiscalizacaoTipoPenalidade
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\TipoPenalidade
     */
    public function getFkFiscalizacaoTipoPenalidade()
    {
        return $this->fkFiscalizacaoTipoPenalidade;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return Penalidade
     */
    public function setFkNormasNorma(\Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma)
    {
        $this->codNorma = $fkNormasNorma->getCodNorma();
        $this->fkNormasNorma = $fkNormasNorma;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkNormasNorma
     *
     * @return \Urbem\CoreBundle\Entity\Normas\Norma
     */
    public function getFkNormasNorma()
    {
        return $this->fkNormasNorma;
    }

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoPenalidadeDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDocumento $fkFiscalizacaoPenalidadeDocumento
     * @return Penalidade
     */
    public function setFkFiscalizacaoPenalidadeDocumento(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDocumento $fkFiscalizacaoPenalidadeDocumento)
    {
        $fkFiscalizacaoPenalidadeDocumento->setFkFiscalizacaoPenalidade($this);
        $this->fkFiscalizacaoPenalidadeDocumento = $fkFiscalizacaoPenalidadeDocumento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoPenalidadeDocumento
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeDocumento
     */
    public function getFkFiscalizacaoPenalidadeDocumento()
    {
        return $this->fkFiscalizacaoPenalidadeDocumento;
    }

    /**
     * OneToOne (inverse side)
     * Set FiscalizacaoPenalidadeMulta
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta $fkFiscalizacaoPenalidadeMulta
     * @return Penalidade
     */
    public function setFkFiscalizacaoPenalidadeMulta(\Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta $fkFiscalizacaoPenalidadeMulta)
    {
        $fkFiscalizacaoPenalidadeMulta->setFkFiscalizacaoPenalidade($this);
        $this->fkFiscalizacaoPenalidadeMulta = $fkFiscalizacaoPenalidadeMulta;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkFiscalizacaoPenalidadeMulta
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\PenalidadeMulta
     */
    public function getFkFiscalizacaoPenalidadeMulta()
    {
        return $this->fkFiscalizacaoPenalidadeMulta;
    }
}
