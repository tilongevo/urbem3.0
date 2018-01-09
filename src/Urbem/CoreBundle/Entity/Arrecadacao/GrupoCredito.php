<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * GrupoCredito
 */
class GrupoCredito
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
    private $codModulo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\CalendarioFiscal
     */
    private $fkArrecadacaoCalendarioFiscal;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\RegraDesoneracaoGrupo
     */
    private $fkArrecadacaoRegraDesoneracaoGrupo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AcrescimoGrupo
     */
    private $fkArrecadacaoAcrescimoGrupos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CalculoGrupoCredito
     */
    private $fkArrecadacaoCalculoGrupoCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo
     */
    private $fkArrecadacaoAtributoGrupos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Permissao
     */
    private $fkArrecadacaoPermissoes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalGrupo
     */
    private $fkFiscalizacaoProcessoFiscalGrupos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CreditoGrupo
     */
    private $fkArrecadacaoCreditoGrupos;

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
        $this->fkArrecadacaoAcrescimoGrupos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoCalculoGrupoCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoAtributoGrupos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoPermissoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkFiscalizacaoProcessoFiscalGrupos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkArrecadacaoCreditoGrupos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codGrupo
     *
     * @param integer $codGrupo
     * @return GrupoCredito
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
     * @return GrupoCredito
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return GrupoCredito
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
     * Set descricao
     *
     * @param string $descricao
     * @return GrupoCredito
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
     * OneToMany (owning side)
     * Add ArrecadacaoAcrescimoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AcrescimoGrupo $fkArrecadacaoAcrescimoGrupo
     * @return GrupoCredito
     */
    public function addFkArrecadacaoAcrescimoGrupos(\Urbem\CoreBundle\Entity\Arrecadacao\AcrescimoGrupo $fkArrecadacaoAcrescimoGrupo)
    {
        if (false === $this->fkArrecadacaoAcrescimoGrupos->contains($fkArrecadacaoAcrescimoGrupo)) {
            $fkArrecadacaoAcrescimoGrupo->setFkArrecadacaoGrupoCredito($this);
            $this->fkArrecadacaoAcrescimoGrupos->add($fkArrecadacaoAcrescimoGrupo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAcrescimoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AcrescimoGrupo $fkArrecadacaoAcrescimoGrupo
     */
    public function removeFkArrecadacaoAcrescimoGrupos(\Urbem\CoreBundle\Entity\Arrecadacao\AcrescimoGrupo $fkArrecadacaoAcrescimoGrupo)
    {
        $this->fkArrecadacaoAcrescimoGrupos->removeElement($fkArrecadacaoAcrescimoGrupo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAcrescimoGrupos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AcrescimoGrupo
     */
    public function getFkArrecadacaoAcrescimoGrupos()
    {
        return $this->fkArrecadacaoAcrescimoGrupos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoCalculoGrupoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CalculoGrupoCredito $fkArrecadacaoCalculoGrupoCredito
     * @return GrupoCredito
     */
    public function addFkArrecadacaoCalculoGrupoCreditos(\Urbem\CoreBundle\Entity\Arrecadacao\CalculoGrupoCredito $fkArrecadacaoCalculoGrupoCredito)
    {
        if (false === $this->fkArrecadacaoCalculoGrupoCreditos->contains($fkArrecadacaoCalculoGrupoCredito)) {
            $fkArrecadacaoCalculoGrupoCredito->setFkArrecadacaoGrupoCredito($this);
            $this->fkArrecadacaoCalculoGrupoCreditos->add($fkArrecadacaoCalculoGrupoCredito);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCalculoGrupoCredito
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CalculoGrupoCredito $fkArrecadacaoCalculoGrupoCredito
     */
    public function removeFkArrecadacaoCalculoGrupoCreditos(\Urbem\CoreBundle\Entity\Arrecadacao\CalculoGrupoCredito $fkArrecadacaoCalculoGrupoCredito)
    {
        $this->fkArrecadacaoCalculoGrupoCreditos->removeElement($fkArrecadacaoCalculoGrupoCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCalculoGrupoCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CalculoGrupoCredito
     */
    public function getFkArrecadacaoCalculoGrupoCreditos()
    {
        return $this->fkArrecadacaoCalculoGrupoCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoAtributoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo $fkArrecadacaoAtributoGrupo
     * @return GrupoCredito
     */
    public function addFkArrecadacaoAtributoGrupos(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo $fkArrecadacaoAtributoGrupo)
    {
        if (false === $this->fkArrecadacaoAtributoGrupos->contains($fkArrecadacaoAtributoGrupo)) {
            $fkArrecadacaoAtributoGrupo->setFkArrecadacaoGrupoCredito($this);
            $this->fkArrecadacaoAtributoGrupos->add($fkArrecadacaoAtributoGrupo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoAtributoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo $fkArrecadacaoAtributoGrupo
     */
    public function removeFkArrecadacaoAtributoGrupos(\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo $fkArrecadacaoAtributoGrupo)
    {
        $this->fkArrecadacaoAtributoGrupos->removeElement($fkArrecadacaoAtributoGrupo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoAtributoGrupos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\AtributoGrupo
     */
    public function getFkArrecadacaoAtributoGrupos()
    {
        return $this->fkArrecadacaoAtributoGrupos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Permissao $fkArrecadacaoPermissao
     * @return GrupoCredito
     */
    public function addFkArrecadacaoPermissoes(\Urbem\CoreBundle\Entity\Arrecadacao\Permissao $fkArrecadacaoPermissao)
    {
        if (false === $this->fkArrecadacaoPermissoes->contains($fkArrecadacaoPermissao)) {
            $fkArrecadacaoPermissao->setFkArrecadacaoGrupoCredito($this);
            $this->fkArrecadacaoPermissoes->add($fkArrecadacaoPermissao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoPermissao
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Permissao $fkArrecadacaoPermissao
     */
    public function removeFkArrecadacaoPermissoes(\Urbem\CoreBundle\Entity\Arrecadacao\Permissao $fkArrecadacaoPermissao)
    {
        $this->fkArrecadacaoPermissoes->removeElement($fkArrecadacaoPermissao);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoPermissoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Permissao
     */
    public function getFkArrecadacaoPermissoes()
    {
        return $this->fkArrecadacaoPermissoes;
    }

    /**
     * OneToMany (owning side)
     * Add FiscalizacaoProcessoFiscalGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalGrupo $fkFiscalizacaoProcessoFiscalGrupo
     * @return GrupoCredito
     */
    public function addFkFiscalizacaoProcessoFiscalGrupos(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalGrupo $fkFiscalizacaoProcessoFiscalGrupo)
    {
        if (false === $this->fkFiscalizacaoProcessoFiscalGrupos->contains($fkFiscalizacaoProcessoFiscalGrupo)) {
            $fkFiscalizacaoProcessoFiscalGrupo->setFkArrecadacaoGrupoCredito($this);
            $this->fkFiscalizacaoProcessoFiscalGrupos->add($fkFiscalizacaoProcessoFiscalGrupo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FiscalizacaoProcessoFiscalGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalGrupo $fkFiscalizacaoProcessoFiscalGrupo
     */
    public function removeFkFiscalizacaoProcessoFiscalGrupos(\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalGrupo $fkFiscalizacaoProcessoFiscalGrupo)
    {
        $this->fkFiscalizacaoProcessoFiscalGrupos->removeElement($fkFiscalizacaoProcessoFiscalGrupo);
    }

    /**
     * OneToMany (owning side)
     * Get fkFiscalizacaoProcessoFiscalGrupos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Fiscalizacao\ProcessoFiscalGrupo
     */
    public function getFkFiscalizacaoProcessoFiscalGrupos()
    {
        return $this->fkFiscalizacaoProcessoFiscalGrupos;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoCreditoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CreditoGrupo $fkArrecadacaoCreditoGrupo
     * @return GrupoCredito
     */
    public function addFkArrecadacaoCreditoGrupos(\Urbem\CoreBundle\Entity\Arrecadacao\CreditoGrupo $fkArrecadacaoCreditoGrupo)
    {
        if (false === $this->fkArrecadacaoCreditoGrupos->contains($fkArrecadacaoCreditoGrupo)) {
            $fkArrecadacaoCreditoGrupo->setFkArrecadacaoGrupoCredito($this);
            $this->fkArrecadacaoCreditoGrupos->add($fkArrecadacaoCreditoGrupo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCreditoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CreditoGrupo $fkArrecadacaoCreditoGrupo
     */
    public function removeFkArrecadacaoCreditoGrupos(\Urbem\CoreBundle\Entity\Arrecadacao\CreditoGrupo $fkArrecadacaoCreditoGrupo)
    {
        $this->fkArrecadacaoCreditoGrupos->removeElement($fkArrecadacaoCreditoGrupo);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCreditoGrupos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\CreditoGrupo
     */
    public function getFkArrecadacaoCreditoGrupos()
    {
        return $this->fkArrecadacaoCreditoGrupos;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkArrecadacaoArrecadacaoModulos
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ArrecadacaoModulos $fkArrecadacaoArrecadacaoModulos
     * @return GrupoCredito
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
     * OneToOne (inverse side)
     * Set ArrecadacaoCalendarioFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\CalendarioFiscal $fkArrecadacaoCalendarioFiscal
     * @return GrupoCredito
     */
    public function setFkArrecadacaoCalendarioFiscal(\Urbem\CoreBundle\Entity\Arrecadacao\CalendarioFiscal $fkArrecadacaoCalendarioFiscal)
    {
        $fkArrecadacaoCalendarioFiscal->setFkArrecadacaoGrupoCredito($this);
        $this->fkArrecadacaoCalendarioFiscal = $fkArrecadacaoCalendarioFiscal;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoCalendarioFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\CalendarioFiscal
     */
    public function getFkArrecadacaoCalendarioFiscal()
    {
        return $this->fkArrecadacaoCalendarioFiscal;
    }

    /**
     * OneToOne (inverse side)
     * Set ArrecadacaoRegraDesoneracaoGrupo
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\RegraDesoneracaoGrupo $fkArrecadacaoRegraDesoneracaoGrupo
     * @return GrupoCredito
     */
    public function setFkArrecadacaoRegraDesoneracaoGrupo(\Urbem\CoreBundle\Entity\Arrecadacao\RegraDesoneracaoGrupo $fkArrecadacaoRegraDesoneracaoGrupo)
    {
        $fkArrecadacaoRegraDesoneracaoGrupo->setFkArrecadacaoGrupoCredito($this);
        $this->fkArrecadacaoRegraDesoneracaoGrupo = $fkArrecadacaoRegraDesoneracaoGrupo;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkArrecadacaoRegraDesoneracaoGrupo
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\RegraDesoneracaoGrupo
     */
    public function getFkArrecadacaoRegraDesoneracaoGrupo()
    {
        return $this->fkArrecadacaoRegraDesoneracaoGrupo;
    }

    /**
     * @return string
     */
    public function getCodigoComposto()
    {
        return sprintf('%s/%s', $this->codGrupo, $this->anoExercicio);
    }

    /**
     * @return string
     */
    public function getCodGrupoCredito()
    {
        return sprintf('%s~%s', $this->codGrupo, $this->anoExercicio);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s - %s', $this->codGrupo, $this->anoExercicio, $this->descricao);
    }
}
