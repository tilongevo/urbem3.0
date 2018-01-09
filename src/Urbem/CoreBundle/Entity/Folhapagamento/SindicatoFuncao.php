<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * SindicatoFuncao
 */
class SindicatoFuncao
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var integer
     */
    private $codBiblioteca;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Folhapagamento\Sindicato
     */
    private $fkFolhapagamentoSindicato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncao;


    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return SindicatoFuncao
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return SindicatoFuncao
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return SindicatoFuncao
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
     * @return SindicatoFuncao
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
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return SindicatoFuncao
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
     * OneToOne (owning side)
     * Set FolhapagamentoSindicato
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\Sindicato $fkFolhapagamentoSindicato
     * @return SindicatoFuncao
     */
    public function setFkFolhapagamentoSindicato(\Urbem\CoreBundle\Entity\Folhapagamento\Sindicato $fkFolhapagamentoSindicato)
    {
        $this->numcgm = $fkFolhapagamentoSindicato->getNumcgm();
        $this->fkFolhapagamentoSindicato = $fkFolhapagamentoSindicato;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkFolhapagamentoSindicato
     *
     * @return \Urbem\CoreBundle\Entity\Folhapagamento\Sindicato
     */
    public function getFkFolhapagamentoSindicato()
    {
        return $this->fkFolhapagamentoSindicato;
    }
}
