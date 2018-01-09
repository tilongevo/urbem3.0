<?php
 
namespace Urbem\CoreBundle\Entity\Fiscalizacao;

/**
 * PenalidadeMulta
 */
class PenalidadeMulta
{
    /**
     * PK
     * @var integer
     */
    private $codPenalidade;

    /**
     * @var integer
     */
    private $codIndicador;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var integer
     */
    private $codBiblioteca;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * @var integer
     */
    private $codUnidade;

    /**
     * @var integer
     */
    private $codGrandeza;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade
     */
    private $fkFiscalizacaoPenalidade;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico
     */
    private $fkMonetarioIndicadorEconomico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    private $fkAdministracaoUnidadeMedida;


    /**
     * Set codPenalidade
     *
     * @param integer $codPenalidade
     * @return PenalidadeMulta
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
     * Set codIndicador
     *
     * @param integer $codIndicador
     * @return PenalidadeMulta
     */
    public function setCodIndicador($codIndicador)
    {
        $this->codIndicador = $codIndicador;
        return $this;
    }

    /**
     * Get codIndicador
     *
     * @return integer
     */
    public function getCodIndicador()
    {
        return $this->codIndicador;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return PenalidadeMulta
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
     * Set codBiblioteca
     *
     * @param integer $codBiblioteca
     * @return PenalidadeMulta
     */
    public function setCodBiblioteca($codBiblioteca)
    {
        $this->codBiblioteca = $codBiblioteca;
        return $this;
    }

    /**
     * Get codBiblioteca
     *
     * @return integer
     */
    public function getCodBiblioteca()
    {
        return $this->codBiblioteca;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return PenalidadeMulta
     */
    public function setCodFuncao($codFuncao)
    {
        $this->codFuncao = $codFuncao;
        return $this;
    }

    /**
     * Get codFuncao
     *
     * @return integer
     */
    public function getCodFuncao()
    {
        return $this->codFuncao;
    }

    /**
     * Set codUnidade
     *
     * @param integer $codUnidade
     * @return PenalidadeMulta
     */
    public function setCodUnidade($codUnidade)
    {
        $this->codUnidade = $codUnidade;
        return $this;
    }

    /**
     * Get codUnidade
     *
     * @return integer
     */
    public function getCodUnidade()
    {
        return $this->codUnidade;
    }

    /**
     * Set codGrandeza
     *
     * @param integer $codGrandeza
     * @return PenalidadeMulta
     */
    public function setCodGrandeza($codGrandeza)
    {
        $this->codGrandeza = $codGrandeza;
        return $this;
    }

    /**
     * Get codGrandeza
     *
     * @return integer
     */
    public function getCodGrandeza()
    {
        return $this->codGrandeza;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkMonetarioIndicadorEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico $fkMonetarioIndicadorEconomico
     * @return PenalidadeMulta
     */
    public function setFkMonetarioIndicadorEconomico(\Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico $fkMonetarioIndicadorEconomico)
    {
        $this->codIndicador = $fkMonetarioIndicadorEconomico->getCodIndicador();
        $this->fkMonetarioIndicadorEconomico = $fkMonetarioIndicadorEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkMonetarioIndicadorEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico
     */
    public function getFkMonetarioIndicadorEconomico()
    {
        return $this->fkMonetarioIndicadorEconomico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return PenalidadeMulta
     */
    public function setFkAdministracaoFuncao(\Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao)
    {
        $this->codModulo = $fkAdministracaoFuncao->getCodModulo();
        $this->codBiblioteca = $fkAdministracaoFuncao->getCodBiblioteca();
        $this->codFuncao = $fkAdministracaoFuncao->getCodFuncao();
        $this->fkAdministracaoFuncao = $fkAdministracaoFuncao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoFuncao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    public function getFkAdministracaoFuncao()
    {
        return $this->fkAdministracaoFuncao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoUnidadeMedida
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida
     * @return PenalidadeMulta
     */
    public function setFkAdministracaoUnidadeMedida(\Urbem\CoreBundle\Entity\Administracao\UnidadeMedida $fkAdministracaoUnidadeMedida)
    {
        $this->codUnidade = $fkAdministracaoUnidadeMedida->getCodUnidade();
        $this->codGrandeza = $fkAdministracaoUnidadeMedida->getCodGrandeza();
        $this->fkAdministracaoUnidadeMedida = $fkAdministracaoUnidadeMedida;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUnidadeMedida
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\UnidadeMedida
     */
    public function getFkAdministracaoUnidadeMedida()
    {
        return $this->fkAdministracaoUnidadeMedida;
    }

    /**
     * OneToOne (owning side)
     * Set FiscalizacaoPenalidade
     *
     * @param \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade
     * @return PenalidadeMulta
     */
    public function setFkFiscalizacaoPenalidade(\Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade $fkFiscalizacaoPenalidade)
    {
        $this->codPenalidade = $fkFiscalizacaoPenalidade->getCodPenalidade();
        $this->fkFiscalizacaoPenalidade = $fkFiscalizacaoPenalidade;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFiscalizacaoPenalidade
     *
     * @return \Urbem\CoreBundle\Entity\Fiscalizacao\Penalidade
     */
    public function getFkFiscalizacaoPenalidade()
    {
        return $this->fkFiscalizacaoPenalidade;
    }
}
