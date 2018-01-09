<?php
 
namespace Urbem\CoreBundle\Entity\Administracao;

/**
 * RelatorioAcao
 */
class RelatorioAcao
{
    /**
     * PK
     * @var integer
     */
    private $codRelatorio;

    /**
     * PK
     * @var integer
     */
    private $codModulo;

    /**
     * PK
     * @var integer
     */
    private $codGestao;

    /**
     * PK
     * @var integer
     */
    private $codAcao;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Relatorio
     */
    private $fkAdministracaoRelatorio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Administracao\Acao
     */
    private $fkAdministracaoAcao;


    /**
     * Set codRelatorio
     *
     * @param integer $codRelatorio
     * @return RelatorioAcao
     */
    public function setCodRelatorio($codRelatorio)
    {
        $this->codRelatorio = $codRelatorio;
        return $this;
    }

    /**
     * Get codRelatorio
     *
     * @return integer
     */
    public function getCodRelatorio()
    {
        return $this->codRelatorio;
    }

    /**
     * Set codModulo
     *
     * @param integer $codModulo
     * @return RelatorioAcao
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
     * Set codGestao
     *
     * @param integer $codGestao
     * @return RelatorioAcao
     */
    public function setCodGestao($codGestao)
    {
        $this->codGestao = $codGestao;
        return $this;
    }

    /**
     * Get codGestao
     *
     * @return integer
     */
    public function getCodGestao()
    {
        return $this->codGestao;
    }

    /**
     * Set codAcao
     *
     * @param integer $codAcao
     * @return RelatorioAcao
     */
    public function setCodAcao($codAcao)
    {
        $this->codAcao = $codAcao;
        return $this;
    }

    /**
     * Get codAcao
     *
     * @return integer
     */
    public function getCodAcao()
    {
        return $this->codAcao;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoRelatorio
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Relatorio $fkAdministracaoRelatorio
     * @return RelatorioAcao
     */
    public function setFkAdministracaoRelatorio(\Urbem\CoreBundle\Entity\Administracao\Relatorio $fkAdministracaoRelatorio)
    {
        $this->codGestao = $fkAdministracaoRelatorio->getCodGestao();
        $this->codModulo = $fkAdministracaoRelatorio->getCodModulo();
        $this->codRelatorio = $fkAdministracaoRelatorio->getCodRelatorio();
        $this->fkAdministracaoRelatorio = $fkAdministracaoRelatorio;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoRelatorio
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Relatorio
     */
    public function getFkAdministracaoRelatorio()
    {
        return $this->fkAdministracaoRelatorio;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkAdministracaoAcao
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao
     * @return RelatorioAcao
     */
    public function setFkAdministracaoAcao(\Urbem\CoreBundle\Entity\Administracao\Acao $fkAdministracaoAcao)
    {
        $this->codAcao = $fkAdministracaoAcao->getCodAcao();
        $this->fkAdministracaoAcao = $fkAdministracaoAcao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkAdministracaoAcao
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Acao
     */
    public function getFkAdministracaoAcao()
    {
        return $this->fkAdministracaoAcao;
    }
}
