<?php
namespace Ariadne\Mapping\Element\Field;

/**
 * Mapping for string type
 *
 * @author dstendardi
 */
class String extends Semantic
{
    /**
     * Set to analyzed for the field to be indexed and searchable after being broken down into token using an analyzer. not_analyzed means that its still searchable, but does not go through any analysis process or broken down into tokens. no means that it won’t be searchable at all. Defaults to analyzed.
     *
     * @var string
     */
    protected $index = 'analyzed';

    /**
     * Possible values are no, yes, with_offsets, with_positions, with_positions_offsets. Defaults to no.
     *
     * @var string
     */
    protected $termVector = 'no';

    /**
     * Boolean value if norms should be omitted or not. Defaults to false.
     *
     * @var boolean
     */
    protected $omitNorms = false;

    /**
     * Boolean value if term freq and positions should be omitted. Defaults to false.
     *
     * @var boolean
     */
    protected $omitTermFreqAndPositions = false;

    /**
     * The analyzer used to analyze the text contents when analyzed during indexing and when searching using a query string. Defaults to the globally configured analyzer.
     *
     * @var string
     */
    protected $analyser;

    /**
     * The analyzer used to analyze the text contents when analyzed during indexing.
     *
     * @var string
     */
    protected $indexAnalyser;

    /**
     * The analyzer used to analyze the field when part of a query string.
     *
     * @var string
     */
    protected $searchAnalyser;

    /**
     * @return the $type
     */
    public function getType()
    {
        return 'string';
    }

    /**
     * @return the $termVector
     */
    public function getTermVector()
    {
        return $this->termVector;
    }

    /**
     * @param string $termVector
     */
    public function setTermVector($termVector)
    {
        $this->termVector = $termVector;
    }

    /**
     * @return the $omitNorms
     */
    public function getOmitNorms()
    {
        return $this->omitNorms;
    }

    /**
     * @param boolean $omitNorms
     */
    public function setOmitNorms($omitNorms)
    {
        $this->omitNorms = $omitNorms;
    }

    /**
     * @return the $omitTermFreqAndPositions
     */
    public function getOmitTermFreqAndPositions()
    {
        return $this->omitTermFreqAndPositions;
    }

    /**
     * @param boolean $omitTermFreqAndPositions
     */
    public function setOmitTermFreqAndPositions($omitTermFreqAndPositions)
    {
        $this->omitTermFreqAndPositions = $omitTermFreqAndPositions;
    }

    /**
     * @return the $analyser
     */
    public function getAnalyser()
    {
        return $this->analyser;
    }

    /**
     * @param string $analyser
     */
    public function setAnalyser($analyser)
    {
        $this->analyser = $analyser;
    }

    /**
     * @return the $indexAnalyser
     */
    public function getIndexAnalyser()
    {
        return $this->indexAnalyser;
    }

    /**
     * @param string $indexAnalyser
     */
    public function setIndexAnalyser($indexAnalyser)
    {
        $this->indexAnalyser = $indexAnalyser;
    }

    /**
     * @return the $searchAnalyser
     */
    public function getSearchAnalyser()
    {
        return $this->searchAnalyser;
    }

    /**
     * @param string $searchAnalyser
     */
    public function setSearchAnalyser($searchAnalyser)
    {
        $this->searchAnalyser = $searchAnalyser;
    }
}