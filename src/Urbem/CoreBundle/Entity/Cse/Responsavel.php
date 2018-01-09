<?php
 
namespace Urbem\CoreBundle\Entity\Cse;

/**
 * Responsavel
 */
class Responsavel
{
    /**
     * PK
     * @var integer
     */
    private $codCidadao;

    /**
     * PK
     * @var integer
     */
    private $codDomicilio;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DatePK
     */
    private $dtInclusao;

    /**
     * @var integer
     */
    private $numcgm;

    /**
     * @var integer
     */
    private $vlAluguel = 0;

    /**
     * @var integer
     */
    private $vlPrestacaoHabitacional = 0;

    /**
     * @var integer
     */
    private $vlAlimentacao = 0;

    /**
     * @var integer
     */
    private $vlAgua = 0;

    /**
     * @var integer
     */
    private $vlLuz = 0;

    /**
     * @var integer
     */
    private $vlTransporte = 0;

    /**
     * @var integer
     */
    private $vlRemedio = 0;

    /**
     * @var integer
     */
    private $vlGas = 0;

    /**
     * @var integer
     */
    private $vlDespesasDiversas = 0;

    /**
     * @var integer
     */
    private $numDependentes = 0;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio
     */
    private $fkCseCidadaoDomicilio;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dtInclusao = new \Urbem\CoreBundle\Helper\DatePK;
    }

    /**
     * Set codCidadao
     *
     * @param integer $codCidadao
     * @return Responsavel
     */
    public function setCodCidadao($codCidadao)
    {
        $this->codCidadao = $codCidadao;
        return $this;
    }

    /**
     * Get codCidadao
     *
     * @return integer
     */
    public function getCodCidadao()
    {
        return $this->codCidadao;
    }

    /**
     * Set codDomicilio
     *
     * @param integer $codDomicilio
     * @return Responsavel
     */
    public function setCodDomicilio($codDomicilio)
    {
        $this->codDomicilio = $codDomicilio;
        return $this;
    }

    /**
     * Get codDomicilio
     *
     * @return integer
     */
    public function getCodDomicilio()
    {
        return $this->codDomicilio;
    }

    /**
     * Set dtInclusao
     *
     * @param \Urbem\CoreBundle\Helper\DatePK $dtInclusao
     * @return Responsavel
     */
    public function setDtInclusao(\Urbem\CoreBundle\Helper\DatePK $dtInclusao)
    {
        $this->dtInclusao = $dtInclusao;
        return $this;
    }

    /**
     * Get dtInclusao
     *
     * @return \Urbem\CoreBundle\Helper\DatePK
     */
    public function getDtInclusao()
    {
        return $this->dtInclusao;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Responsavel
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
     * Set vlAluguel
     *
     * @param integer $vlAluguel
     * @return Responsavel
     */
    public function setVlAluguel($vlAluguel)
    {
        $this->vlAluguel = $vlAluguel;
        return $this;
    }

    /**
     * Get vlAluguel
     *
     * @return integer
     */
    public function getVlAluguel()
    {
        return $this->vlAluguel;
    }

    /**
     * Set vlPrestacaoHabitacional
     *
     * @param integer $vlPrestacaoHabitacional
     * @return Responsavel
     */
    public function setVlPrestacaoHabitacional($vlPrestacaoHabitacional)
    {
        $this->vlPrestacaoHabitacional = $vlPrestacaoHabitacional;
        return $this;
    }

    /**
     * Get vlPrestacaoHabitacional
     *
     * @return integer
     */
    public function getVlPrestacaoHabitacional()
    {
        return $this->vlPrestacaoHabitacional;
    }

    /**
     * Set vlAlimentacao
     *
     * @param integer $vlAlimentacao
     * @return Responsavel
     */
    public function setVlAlimentacao($vlAlimentacao)
    {
        $this->vlAlimentacao = $vlAlimentacao;
        return $this;
    }

    /**
     * Get vlAlimentacao
     *
     * @return integer
     */
    public function getVlAlimentacao()
    {
        return $this->vlAlimentacao;
    }

    /**
     * Set vlAgua
     *
     * @param integer $vlAgua
     * @return Responsavel
     */
    public function setVlAgua($vlAgua)
    {
        $this->vlAgua = $vlAgua;
        return $this;
    }

    /**
     * Get vlAgua
     *
     * @return integer
     */
    public function getVlAgua()
    {
        return $this->vlAgua;
    }

    /**
     * Set vlLuz
     *
     * @param integer $vlLuz
     * @return Responsavel
     */
    public function setVlLuz($vlLuz)
    {
        $this->vlLuz = $vlLuz;
        return $this;
    }

    /**
     * Get vlLuz
     *
     * @return integer
     */
    public function getVlLuz()
    {
        return $this->vlLuz;
    }

    /**
     * Set vlTransporte
     *
     * @param integer $vlTransporte
     * @return Responsavel
     */
    public function setVlTransporte($vlTransporte)
    {
        $this->vlTransporte = $vlTransporte;
        return $this;
    }

    /**
     * Get vlTransporte
     *
     * @return integer
     */
    public function getVlTransporte()
    {
        return $this->vlTransporte;
    }

    /**
     * Set vlRemedio
     *
     * @param integer $vlRemedio
     * @return Responsavel
     */
    public function setVlRemedio($vlRemedio)
    {
        $this->vlRemedio = $vlRemedio;
        return $this;
    }

    /**
     * Get vlRemedio
     *
     * @return integer
     */
    public function getVlRemedio()
    {
        return $this->vlRemedio;
    }

    /**
     * Set vlGas
     *
     * @param integer $vlGas
     * @return Responsavel
     */
    public function setVlGas($vlGas)
    {
        $this->vlGas = $vlGas;
        return $this;
    }

    /**
     * Get vlGas
     *
     * @return integer
     */
    public function getVlGas()
    {
        return $this->vlGas;
    }

    /**
     * Set vlDespesasDiversas
     *
     * @param integer $vlDespesasDiversas
     * @return Responsavel
     */
    public function setVlDespesasDiversas($vlDespesasDiversas)
    {
        $this->vlDespesasDiversas = $vlDespesasDiversas;
        return $this;
    }

    /**
     * Get vlDespesasDiversas
     *
     * @return integer
     */
    public function getVlDespesasDiversas()
    {
        return $this->vlDespesasDiversas;
    }

    /**
     * Set numDependentes
     *
     * @param integer $numDependentes
     * @return Responsavel
     */
    public function setNumDependentes($numDependentes)
    {
        $this->numDependentes = $numDependentes;
        return $this;
    }

    /**
     * Get numDependentes
     *
     * @return integer
     */
    public function getNumDependentes()
    {
        return $this->numDependentes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Responsavel
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * OneToOne (owning side)
     * Set CseCidadaoDomicilio
     *
     * @param \Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio $fkCseCidadaoDomicilio
     * @return Responsavel
     */
    public function setFkCseCidadaoDomicilio(\Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio $fkCseCidadaoDomicilio)
    {
        $this->codCidadao = $fkCseCidadaoDomicilio->getCodCidadao();
        $this->codDomicilio = $fkCseCidadaoDomicilio->getCodDomicilio();
        $this->dtInclusao = $fkCseCidadaoDomicilio->getDtInclusao();
        $this->fkCseCidadaoDomicilio = $fkCseCidadaoDomicilio;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkCseCidadaoDomicilio
     *
     * @return \Urbem\CoreBundle\Entity\Cse\CidadaoDomicilio
     */
    public function getFkCseCidadaoDomicilio()
    {
        return $this->fkCseCidadaoDomicilio;
    }
}
