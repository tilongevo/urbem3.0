<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ConfrontacaoDiversa
 */
class ConfrontacaoDiversa
{
    /**
     * PK
     * @var integer
     */
    private $codConfrontacao;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao
     */
    private $fkImobiliarioConfrontacao;


    /**
     * Set codConfrontacao
     *
     * @param integer $codConfrontacao
     * @return ConfrontacaoDiversa
     */
    public function setCodConfrontacao($codConfrontacao)
    {
        $this->codConfrontacao = $codConfrontacao;
        return $this;
    }

    /**
     * Get codConfrontacao
     *
     * @return integer
     */
    public function getCodConfrontacao()
    {
        return $this->codConfrontacao;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return ConfrontacaoDiversa
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ConfrontacaoDiversa
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
     * OneToOne (owning side)
     * Set ImobiliarioConfrontacao
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao
     * @return ConfrontacaoDiversa
     */
    public function setFkImobiliarioConfrontacao(\Urbem\CoreBundle\Entity\Imobiliario\Confrontacao $fkImobiliarioConfrontacao)
    {
        $this->codConfrontacao = $fkImobiliarioConfrontacao->getCodConfrontacao();
        $this->codLote = $fkImobiliarioConfrontacao->getCodLote();
        $this->fkImobiliarioConfrontacao = $fkImobiliarioConfrontacao;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImobiliarioConfrontacao
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Confrontacao
     */
    public function getFkImobiliarioConfrontacao()
    {
        return $this->fkImobiliarioConfrontacao;
    }
}
