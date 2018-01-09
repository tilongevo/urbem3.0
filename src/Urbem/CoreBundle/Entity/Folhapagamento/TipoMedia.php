<?php
 
namespace Urbem\CoreBundle\Entity\Folhapagamento;

/**
 * TipoMedia
 */
class TipoMedia
{
    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $codigo;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $observacao;

    /**
     * @var integer
     */
    private $codFuncao;

    /**
     * @var integer
     */
    private $codBiblioteca;

    /**
     * @var integer
     */
    private $codModulo;

    /**
     * @var string
     */
    private $desdobramento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoConfiguracaoMedia
     */
    private $fkFolhapagamentoTipoEventoConfiguracaoMedias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkFolhapagamentoTipoEventoConfiguracaoMedias = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoMedia
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
     * Set codigo
     *
     * @param string $codigo
     * @return TipoMedia
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get codigo
     *
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return TipoMedia
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
     * Set observacao
     *
     * @param string $observacao
     * @return TipoMedia
     */
    public function setObservacao($observacao)
    {
        $this->observacao = $observacao;
        return $this;
    }

    /**
     * Get observacao
     *
     * @return string
     */
    public function getObservacao()
    {
        return $this->observacao;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return TipoMedia
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
     * Set codBiblioteca
     *
     * @param integer $codBiblioteca
     * @return TipoMedia
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
     * Set codModulo
     *
     * @param integer $codModulo
     * @return TipoMedia
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
     * Set desdobramento
     *
     * @param string $desdobramento
     * @return TipoMedia
     */
    public function setDesdobramento($desdobramento)
    {
        $this->desdobramento = $desdobramento;
        return $this;
    }

    /**
     * Get desdobramento
     *
     * @return string
     */
    public function getDesdobramento()
    {
        return $this->desdobramento;
    }

    /**
     * OneToMany (owning side)
     * Add FolhapagamentoTipoEventoConfiguracaoMedia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoConfiguracaoMedia $fkFolhapagamentoTipoEventoConfiguracaoMedia
     * @return TipoMedia
     */
    public function addFkFolhapagamentoTipoEventoConfiguracaoMedias(\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoConfiguracaoMedia $fkFolhapagamentoTipoEventoConfiguracaoMedia)
    {
        if (false === $this->fkFolhapagamentoTipoEventoConfiguracaoMedias->contains($fkFolhapagamentoTipoEventoConfiguracaoMedia)) {
            $fkFolhapagamentoTipoEventoConfiguracaoMedia->setFkFolhapagamentoTipoMedia($this);
            $this->fkFolhapagamentoTipoEventoConfiguracaoMedias->add($fkFolhapagamentoTipoEventoConfiguracaoMedia);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove FolhapagamentoTipoEventoConfiguracaoMedia
     *
     * @param \Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoConfiguracaoMedia $fkFolhapagamentoTipoEventoConfiguracaoMedia
     */
    public function removeFkFolhapagamentoTipoEventoConfiguracaoMedias(\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoConfiguracaoMedia $fkFolhapagamentoTipoEventoConfiguracaoMedia)
    {
        $this->fkFolhapagamentoTipoEventoConfiguracaoMedias->removeElement($fkFolhapagamentoTipoEventoConfiguracaoMedia);
    }

    /**
     * OneToMany (owning side)
     * Get fkFolhapagamentoTipoEventoConfiguracaoMedias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoConfiguracaoMedia
     */
    public function getFkFolhapagamentoTipoEventoConfiguracaoMedias()
    {
        return $this->fkFolhapagamentoTipoEventoConfiguracaoMedias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoFuncao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Funcao $fkAdministracaoFuncao
     * @return TipoMedia
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
}
