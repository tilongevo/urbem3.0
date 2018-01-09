<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * LoteArquivo
 */
class LoteArquivo
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var string
     */
    private $md5sum;

    /**
     * @var string
     */
    private $header;

    /**
     * @var string
     */
    private $footer;

    /**
     * @var string
     */
    private $nomArquivo;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Arrecadacao\Lote
     */
    private $fkArrecadacaoLote;


    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteArquivo
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
     * Set exercicio
     *
     * @param string $exercicio
     * @return LoteArquivo
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
     * Set md5sum
     *
     * @param string $md5sum
     * @return LoteArquivo
     */
    public function setMd5sum($md5sum)
    {
        $this->md5sum = $md5sum;
        return $this;
    }

    /**
     * Get md5sum
     *
     * @return string
     */
    public function getMd5sum()
    {
        return $this->md5sum;
    }

    /**
     * Set header
     *
     * @param string $header
     * @return LoteArquivo
     */
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }

    /**
     * Get header
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * Set footer
     *
     * @param string $footer
     * @return LoteArquivo
     */
    public function setFooter($footer)
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * Get footer
     *
     * @return string
     */
    public function getFooter()
    {
        return $this->footer;
    }

    /**
     * Set nomArquivo
     *
     * @param string $nomArquivo
     * @return LoteArquivo
     */
    public function setNomArquivo($nomArquivo)
    {
        $this->nomArquivo = $nomArquivo;
        return $this;
    }

    /**
     * Get nomArquivo
     *
     * @return string
     */
    public function getNomArquivo()
    {
        return $this->nomArquivo;
    }

    /**
     * OneToOne (owning side)
     * Set ArrecadacaoLote
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote
     * @return LoteArquivo
     */
    public function setFkArrecadacaoLote(\Urbem\CoreBundle\Entity\Arrecadacao\Lote $fkArrecadacaoLote)
    {
        $this->exercicio = $fkArrecadacaoLote->getExercicio();
        $this->codLote = $fkArrecadacaoLote->getCodLote();
        $this->fkArrecadacaoLote = $fkArrecadacaoLote;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkArrecadacaoLote
     *
     * @return \Urbem\CoreBundle\Entity\Arrecadacao\Lote
     */
    public function getFkArrecadacaoLote()
    {
        return $this->fkArrecadacaoLote;
    }
}
