<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ImovelFoto
 */
class ImovelFoto
{
    /**
     * PK
     * @var integer
     */
    private $inscricaoMunicipal;

    /**
     * PK
     * @var integer
     */
    private $codFoto;

    /**
     * @var string
     */
    private $descricao;

    /**
     * @var string
     */
    private $foto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    private $fkImobiliarioImovel;


    /**
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return ImovelFoto
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * Set codFoto
     *
     * @param integer $codFoto
     * @return ImovelFoto
     */
    public function setCodFoto($codFoto)
    {
        $this->codFoto = $codFoto;
        return $this;
    }

    /**
     * Get codFoto
     *
     * @return integer
     */
    public function getCodFoto()
    {
        return $this->codFoto;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return ImovelFoto
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
     * Set foto
     *
     * @param string $foto
     * @return ImovelFoto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel
     * @return ImovelFoto
     */
    public function setFkImobiliarioImovel(\Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel)
    {
        $this->inscricaoMunicipal = $fkImobiliarioImovel->getInscricaoMunicipal();
        $this->fkImobiliarioImovel = $fkImobiliarioImovel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    public function getFkImobiliarioImovel()
    {
        return $this->fkImobiliarioImovel;
    }
}
