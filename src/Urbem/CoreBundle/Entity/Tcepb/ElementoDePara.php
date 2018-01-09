<?php
 
namespace Urbem\CoreBundle\Entity\Tcepb;

/**
 * ElementoDePara
 */
class ElementoDePara
{
    /**
     * PK
     * @var string
     */
    private $estrutural;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codConta;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcepb\ElementoTribunal
     */
    private $fkTcepbElementoTribunal;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    private $fkOrcamentoContaDespesa;


    /**
     * Set estrutural
     *
     * @param string $estrutural
     * @return ElementoDePara
     */
    public function setEstrutural($estrutural)
    {
        $this->estrutural = $estrutural;
        return $this;
    }

    /**
     * Get estrutural
     *
     * @return string
     */
    public function getEstrutural()
    {
        return $this->estrutural;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ElementoDePara
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
     * Set codConta
     *
     * @param integer $codConta
     * @return ElementoDePara
     */
    public function setCodConta($codConta)
    {
        $this->codConta = $codConta;
        return $this;
    }

    /**
     * Get codConta
     *
     * @return integer
     */
    public function getCodConta()
    {
        return $this->codConta;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkTcepbElementoTribunal
     *
     * @param \Urbem\CoreBundle\Entity\Tcepb\ElementoTribunal $fkTcepbElementoTribunal
     * @return ElementoDePara
     */
    public function setFkTcepbElementoTribunal(\Urbem\CoreBundle\Entity\Tcepb\ElementoTribunal $fkTcepbElementoTribunal)
    {
        $this->estrutural = $fkTcepbElementoTribunal->getEstrutural();
        $this->exercicio = $fkTcepbElementoTribunal->getExercicio();
        $this->fkTcepbElementoTribunal = $fkTcepbElementoTribunal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcepbElementoTribunal
     *
     * @return \Urbem\CoreBundle\Entity\Tcepb\ElementoTribunal
     */
    public function getFkTcepbElementoTribunal()
    {
        return $this->fkTcepbElementoTribunal;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkOrcamentoContaDespesa
     *
     * @param \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa
     * @return ElementoDePara
     */
    public function setFkOrcamentoContaDespesa(\Urbem\CoreBundle\Entity\Orcamento\ContaDespesa $fkOrcamentoContaDespesa)
    {
        $this->exercicio = $fkOrcamentoContaDespesa->getExercicio();
        $this->codConta = $fkOrcamentoContaDespesa->getCodConta();
        $this->fkOrcamentoContaDespesa = $fkOrcamentoContaDespesa;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkOrcamentoContaDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    public function getFkOrcamentoContaDespesa()
    {
        return $this->fkOrcamentoContaDespesa;
    }
}
