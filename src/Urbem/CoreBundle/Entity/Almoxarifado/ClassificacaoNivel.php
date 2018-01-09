<?php
 
namespace Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * ClassificacaoNivel
 */
class ClassificacaoNivel
{
    /**
     * PK
     * @var integer
     */
    private $codCatalogo;

    /**
     * PK
     * @var integer
     */
    private $nivel;

    /**
     * PK
     * @var integer
     */
    private $codClassificacao;

    /**
     * PK
     * @var integer
     */
    private $codNivel;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoNiveis
     */
    private $fkAlmoxarifadoCatalogoNiveis;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao
     */
    private $fkAlmoxarifadoCatalogoClassificacao;


    /**
     * Set codCatalogo
     *
     * @param integer $codCatalogo
     * @return ClassificacaoNivel
     */
    public function setCodCatalogo($codCatalogo)
    {
        $this->codCatalogo = $codCatalogo;
        return $this;
    }

    /**
     * Get codCatalogo
     *
     * @return integer
     */
    public function getCodCatalogo()
    {
        return $this->codCatalogo;
    }

    /**
     * Set nivel
     *
     * @param integer $nivel
     * @return ClassificacaoNivel
     */
    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
        return $this;
    }

    /**
     * Get nivel
     *
     * @return integer
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * Set codClassificacao
     *
     * @param integer $codClassificacao
     * @return ClassificacaoNivel
     */
    public function setCodClassificacao($codClassificacao)
    {
        $this->codClassificacao = $codClassificacao;
        return $this;
    }

    /**
     * Get codClassificacao
     *
     * @return integer
     */
    public function getCodClassificacao()
    {
        return $this->codClassificacao;
    }

    /**
     * Set codNivel
     *
     * @param integer $codNivel
     * @return ClassificacaoNivel
     */
    public function setCodNivel($codNivel)
    {
        $this->codNivel = $codNivel;
        return $this;
    }

    /**
     * Get codNivel
     *
     * @return integer
     */
    public function getCodNivel()
    {
        return $this->codNivel;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoNiveis
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoNiveis $fkAlmoxarifadoCatalogoNiveis
     * @return ClassificacaoNivel
     */
    public function setFkAlmoxarifadoCatalogoNiveis(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoNiveis $fkAlmoxarifadoCatalogoNiveis)
    {
        $this->nivel = $fkAlmoxarifadoCatalogoNiveis->getNivel();
        $this->codCatalogo = $fkAlmoxarifadoCatalogoNiveis->getCodCatalogo();
        $this->fkAlmoxarifadoCatalogoNiveis = $fkAlmoxarifadoCatalogoNiveis;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCatalogoNiveis
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoNiveis
     */
    public function getFkAlmoxarifadoCatalogoNiveis()
    {
        return $this->fkAlmoxarifadoCatalogoNiveis;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAlmoxarifadoCatalogoClassificacao
     *
     * @param \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao $fkAlmoxarifadoCatalogoClassificacao
     * @return ClassificacaoNivel
     */
    public function setFkAlmoxarifadoCatalogoClassificacao(\Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao $fkAlmoxarifadoCatalogoClassificacao)
    {
        $this->codClassificacao = $fkAlmoxarifadoCatalogoClassificacao->getCodClassificacao();
        $this->codCatalogo = $fkAlmoxarifadoCatalogoClassificacao->getCodCatalogo();
        $this->fkAlmoxarifadoCatalogoClassificacao = $fkAlmoxarifadoCatalogoClassificacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAlmoxarifadoCatalogoClassificacao
     *
     * @return \Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao
     */
    public function getFkAlmoxarifadoCatalogoClassificacao()
    {
        return $this->fkAlmoxarifadoCatalogoClassificacao;
    }
}
