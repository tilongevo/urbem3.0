<?php
 
namespace Urbem\CoreBundle\Entity\Monetario;

/**
 * RegraConversaoMoeda
 */
class RegraConversaoMoeda
{
    /**
     * PK
     * @var integer
     */
    private $codMoeda;

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
     * @var \Urbem\CoreBundle\Entity\Monetario\Moeda
     */
    private $fkMonetarioMoeda;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Funcao
     */
    private $fkAdministracaoFuncao;


    /**
     * Set codMoeda
     *
     * @param integer $codMoeda
     * @return RegraConversaoMoeda
     */
    public function setCodMoeda($codMoeda)
    {
        $this->codMoeda = $codMoeda;
        return $this;
    }

    /**
     * Get codMoeda
     *
     * @return integer
     */
    public function getCodMoeda()
    {
        return $this->codMoeda;
    }

    /**
     * Set codFuncao
     *
     * @param integer $codFuncao
     * @return RegraConversaoMoeda
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
     * @return RegraConversaoMoeda
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
     * @return RegraConversaoMoeda
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
     * @return RegraConversaoMoeda
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
     * Set MonetarioMoeda
     *
     * @param \Urbem\CoreBundle\Entity\Monetario\Moeda $fkMonetarioMoeda
     * @return RegraConversaoMoeda
     */
    public function setFkMonetarioMoeda(\Urbem\CoreBundle\Entity\Monetario\Moeda $fkMonetarioMoeda)
    {
        $this->codMoeda = $fkMonetarioMoeda->getCodMoeda();
        $this->fkMonetarioMoeda = $fkMonetarioMoeda;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkMonetarioMoeda
     *
     * @return \Urbem\CoreBundle\Entity\Monetario\Moeda
     */
    public function getFkMonetarioMoeda()
    {
        return $this->fkMonetarioMoeda;
    }
}
