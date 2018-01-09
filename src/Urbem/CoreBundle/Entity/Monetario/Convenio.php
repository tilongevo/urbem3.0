<?php

namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * Convenio
 */
class Convenio
{
    /**
     * PK
     * @var integer
     */
    private $codConvenio;

    /**
     * @var integer
     */
    private $numConvenio;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $taxaBancaria;

    /**
     * @var integer
     */
    private $cedente;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Monetario\ConvenioFichaCompensacao
     */
    private $fkMonetarioConvenioFichaCompensacao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    private $fkArrecadacaoCarnes;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio
     */
    private $fkMonetarioContaCorrenteConvenios;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\Credito
     */
    private $fkMonetarioCreditos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\Carteira
     */
    private $fkMonetarioCarteiras;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\TipoConvenio
     */
    private $fkMonetarioTipoConvenio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoCarnes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioContaCorrenteConvenios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioCreditos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkMonetarioCarteiras = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConvenio
     *
     * @param integer $codConvenio
     * @return Convenio
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
     * Set numConvenio
     *
     * @param integer $numConvenio
     * @return Convenio
     */
    public function setNumConvenio($numConvenio)
    {
        $this->numConvenio = $numConvenio;
        return $this;
    }

    /**
     * Get numConvenio
     *
     * @return integer
     */
    public function getNumConvenio()
    {
        return $this->numConvenio;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return Convenio
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set taxaBancaria
     *
     * @param string $taxaBancaria
     * @return Convenio
     */
    public function setTaxaBancaria($taxaBancaria = null)
    {
        $this->taxaBancaria = $taxaBancaria;
        return $this;
    }

    /**
     * Get taxaBancaria
     *
     * @return string
     */
    public function getTaxaBancaria()
    {
        return $this->taxaBancaria;
    }

    /**
     * Set cedente
     *
     * @param integer $cedente
     * @return Convenio
     */
    public function setCedente($cedente = null)
    {
        $this->cedente = $cedente;
        return $this;
    }

    /**
     * Get cedente
     *
     * @return integer
     */
    public function getCedente()
    {
        return $this->cedente;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne
     * @return Convenio
     */
    public function addFkArrecadacaoCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne)
    {
        if (false === $this->fkArrecadacaoCarnes->contains($fkArrecadacaoCarne)) {
            $fkArrecadacaoCarne->setFkMonetarioConvenio($this);
            $this->fkArrecadacaoCarnes->add($fkArrecadacaoCarne);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoCarne
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne
     */
    public function removeFkArrecadacaoCarnes(\Urbem\CoreBundle\Entity\Arrecadacao\Carne $fkArrecadacaoCarne)
    {
        $this->fkArrecadacaoCarnes->removeElement($fkArrecadacaoCarne);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoCarnes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\Carne
     */
    public function getFkArrecadacaoCarnes()
    {
        return $this->fkArrecadacaoCarnes;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioContaCorrenteConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio $fkMonetarioContaCorrenteConvenio
     * @return Convenio
     */
    public function addFkMonetarioContaCorrenteConvenio(\Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio $fkMonetarioContaCorrenteConvenio)
    {
        if (false === $this->fkMonetarioContaCorrenteConvenios->contains($fkMonetarioContaCorrenteConvenio)) {
            $fkMonetarioContaCorrenteConvenio->setFkMonetarioConvenio($this);
            $this->fkMonetarioContaCorrenteConvenios->add($fkMonetarioContaCorrenteConvenio);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioContaCorrenteConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio $fkMonetarioContaCorrenteConvenio
     */
    public function removeFkMonetarioContaCorrenteConvenio(\Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio $fkMonetarioContaCorrenteConvenio)
    {
        $this->fkMonetarioContaCorrenteConvenios->removeElement($fkMonetarioContaCorrenteConvenio);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioContaCorrenteConvenios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio
     */
    public function getFkMonetarioContaCorrenteConvenios()
    {
        return $this->fkMonetarioContaCorrenteConvenios;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito
     * @return Convenio
     */
    public function addFkMonetarioCreditos(\Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito)
    {
        if (false === $this->fkMonetarioCreditos->contains($fkMonetarioCredito)) {
            $fkMonetarioCredito->setFkMonetarioConvenio($this);
            $this->fkMonetarioCreditos->add($fkMonetarioCredito);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioCredito
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito
     */
    public function removeFkMonetarioCreditos(\Urbem\CoreBundle\Entity\Monetario\Credito $fkMonetarioCredito)
    {
        $this->fkMonetarioCreditos->removeElement($fkMonetarioCredito);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioCreditos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\Credito
     */
    public function getFkMonetarioCreditos()
    {
        return $this->fkMonetarioCreditos;
    }

    /**
     * OneToMany (owning side)
     * Add MonetarioCarteira
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Carteira $fkMonetarioCarteira
     * @return Convenio
     */
    public function addFkMonetarioCarteiras(\Urbem\CoreBundle\Entity\Monetario\Carteira $fkMonetarioCarteira)
    {
        if (false === $this->fkMonetarioCarteiras->contains($fkMonetarioCarteira)) {
            $fkMonetarioCarteira->setFkMonetarioConvenio($this);
            $this->fkMonetarioCarteiras->add($fkMonetarioCarteira);
        }

        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove MonetarioCarteira
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Carteira $fkMonetarioCarteira
     */
    public function removeFkMonetarioCarteiras(\Urbem\CoreBundle\Entity\Monetario\Carteira $fkMonetarioCarteira)
    {
        $this->fkMonetarioCarteiras->removeElement($fkMonetarioCarteira);
    }

    /**
     * OneToMany (owning side)
     * Get fkMonetarioCarteiras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Monetario\Carteira
     */
    public function getFkMonetarioCarteiras()
    {
        return $this->fkMonetarioCarteiras;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioTipoConvenio
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\TipoConvenio $fkMonetarioTipoConvenio
     * @return Convenio
     */
    public function setFkMonetarioTipoConvenio(\Urbem\CoreBundle\Entity\Monetario\TipoConvenio $fkMonetarioTipoConvenio)
    {
        $this->codTipo = $fkMonetarioTipoConvenio->getCodTipo();
        $this->fkMonetarioTipoConvenio = $fkMonetarioTipoConvenio;

        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioTipoConvenio
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\TipoConvenio
     */
    public function getFkMonetarioTipoConvenio()
    {
        return $this->fkMonetarioTipoConvenio;
    }

    /**
     * OneToOne (inverse side)
     * Set MonetarioConvenioFichaCompensacao
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\ConvenioFichaCompensacao $fkMonetarioConvenioFichaCompensacao
     * @return Convenio
     */
    public function setFkMonetarioConvenioFichaCompensacao(\Urbem\CoreBundle\Entity\Monetario\ConvenioFichaCompensacao $fkMonetarioConvenioFichaCompensacao)
    {
        $fkMonetarioConvenioFichaCompensacao->setFkMonetarioConvenio($this);
        $this->fkMonetarioConvenioFichaCompensacao = $fkMonetarioConvenioFichaCompensacao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkMonetarioConvenioFichaCompensacao
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\ConvenioFichaCompensacao
     */
    public function getFkMonetarioConvenioFichaCompensacao()
    {
        return $this->fkMonetarioConvenioFichaCompensacao;
    }

    /**
    *
    * @return string
    */
    public function __toString()
    {
        return (string) $this->numConvenio;
    }
}
