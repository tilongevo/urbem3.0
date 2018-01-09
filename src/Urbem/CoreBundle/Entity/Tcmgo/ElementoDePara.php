<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * ElementoDePara
 */
class ElementoDePara
{
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
     * @var string
     */
    private $estrutural;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    private $fkOrcamentoContaDespesa;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Tcmgo\ElementoTribunal
     */
    private $fkTcmgoElementoTribunal;


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
     * ManyToOne (inverse side)
     * Set fkTcmgoElementoTribunal
     *
     * @param \Urbem\CoreBundle\Entity\Tcmgo\ElementoTribunal $fkTcmgoElementoTribunal
     * @return ElementoDePara
     */
    public function setFkTcmgoElementoTribunal(\Urbem\CoreBundle\Entity\Tcmgo\ElementoTribunal $fkTcmgoElementoTribunal)
    {
        $this->estrutural = $fkTcmgoElementoTribunal->getEstrutural();
        $this->fkTcmgoElementoTribunal = $fkTcmgoElementoTribunal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkTcmgoElementoTribunal
     *
     * @return \Urbem\CoreBundle\Entity\Tcmgo\ElementoTribunal
     */
    public function getFkTcmgoElementoTribunal()
    {
        return $this->fkTcmgoElementoTribunal;
    }

    /**
     * OneToOne (owning side)
     * Set OrcamentoContaDespesa
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
     * OneToOne (owning side)
     * Get fkOrcamentoContaDespesa
     *
     * @return \Urbem\CoreBundle\Entity\Orcamento\ContaDespesa
     */
    public function getFkOrcamentoContaDespesa()
    {
        return $this->fkOrcamentoContaDespesa;
    }
}
