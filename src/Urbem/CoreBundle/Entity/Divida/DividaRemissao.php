<?php
 
namespace Urbem\CoreBundle\Entity\Divida;

/**
 * DividaRemissao
 */
class DividaRemissao
{
    /**
     * PK
     * @var integer
     */
    private $codInscricao;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $codNorma;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var \DateTime
     */
    private $dtRemissao;

    /**
     * @var string
     */
    private $observacao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Divida\RemissaoProcesso
     */
    private $fkDividaRemissaoProcesso;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Divida\DividaAtiva
     */
    private $fkDividaDividaAtiva;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Normas\Norma
     */
    private $fkNormasNorma;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;


    /**
     * Set codInscricao
     *
     * @param integer $codInscricao
     * @return DividaRemissao
     */
    public function setCodInscricao($codInscricao)
    {
        $this->codInscricao = $codInscricao;
        return $this;
    }

    /**
     * Get codInscricao
     *
     * @return integer
     */
    public function getCodInscricao()
    {
        return $this->codInscricao;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return DividaRemissao
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
     * Set codNorma
     *
     * @param integer $codNorma
     * @return DividaRemissao
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
     * Set numcgm
     *
     * @param integer $numcgm
     * @return DividaRemissao
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
     * Set dtRemissao
     *
     * @param \DateTime $dtRemissao
     * @return DividaRemissao
     */
    public function setDtRemissao(\DateTime $dtRemissao)
    {
        $this->dtRemissao = $dtRemissao;
        return $this;
    }

    /**
     * Get dtRemissao
     *
     * @return \DateTime
     */
    public function getDtRemissao()
    {
        return $this->dtRemissao;
    }

    /**
     * Set observacao
     *
     * @param string $observacao
     * @return DividaRemissao
     */
    public function setObservacao($observacao = null)
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
     * ManyToOne (inverse side)
     * Set fkNormasNorma
     *
     * @param \Urbem\CoreBundle\Entity\Normas\Norma $fkNormasNorma
     * @return DividaRemissao
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
     * ManyToOne (inverse side)
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     * @return DividaRemissao
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->numcgm = $fkAdministracaoUsuario->getNumcgm();
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * OneToOne (inverse side)
     * Set DividaRemissaoProcesso
     *
     * @param \Urbem\CoreBundle\Entity\Divida\RemissaoProcesso $fkDividaRemissaoProcesso
     * @return DividaRemissao
     */
    public function setFkDividaRemissaoProcesso(\Urbem\CoreBundle\Entity\Divida\RemissaoProcesso $fkDividaRemissaoProcesso)
    {
        $fkDividaRemissaoProcesso->setFkDividaDividaRemissao($this);
        $this->fkDividaRemissaoProcesso = $fkDividaRemissaoProcesso;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkDividaRemissaoProcesso
     *
     * @return \Urbem\CoreBundle\Entity\Divida\RemissaoProcesso
     */
    public function getFkDividaRemissaoProcesso()
    {
        return $this->fkDividaRemissaoProcesso;
    }

    /**
     * OneToOne (owning side)
     * Set DividaDividaAtiva
     *
     * @param \Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva
     * @return DividaRemissao
     */
    public function setFkDividaDividaAtiva(\Urbem\CoreBundle\Entity\Divida\DividaAtiva $fkDividaDividaAtiva)
    {
        $this->exercicio = $fkDividaDividaAtiva->getExercicio();
        $this->codInscricao = $fkDividaDividaAtiva->getCodInscricao();
        $this->fkDividaDividaAtiva = $fkDividaDividaAtiva;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkDividaDividaAtiva
     *
     * @return \Urbem\CoreBundle\Entity\Divida\DividaAtiva
     */
    public function getFkDividaDividaAtiva()
    {
        return $this->fkDividaDividaAtiva;
    }
}
