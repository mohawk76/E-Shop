<?php

namespace AnvilPHP;

final class Pagination implements \AnvilPHP\HTMLGenerators\printerHTML
{
    /**
     * @var int total number elements
     */
    private $totalItems = 0;
    /**
     * @var int Current page
     */
    private $page = 1;
    /**
     * @var int total number elements on page
     */
    private $itemsPerPage = 10;
    /**
     * @var int total number links to other pages on page
     */
    private $numLinks = 3;
    /**
     * @var string Adress url
     */
    private $url = '';
    /**
     * @var string result text
     */
    private $text = 'Pokazano od {start} do {end} z {total} elementów ({pages} stron)';
    /**
     * @var string Text link to first page
     */
    private $textFirstPage = '&lt;&lt; ';
    /**
     * @var string text link to last page
     */
    private $textLastPage = '&gt;&gt;';
    /**
     * @var string Text link to next page
     */
    private $textNextPage = '&gt;';
    /**
     * @var string Text link to previous page
     */
    private $textPrevPage = '&lt;';
    /**
     * @var string left separator
     */
    private $separatorLeft = ' .... ';
    /**
     * @var string right separator
     */
    private $separatorRight = ' .... ';
    /**
     * @var int total number pages
     */
    private $numPages;
    /**
     * @var string Title link to first page
     */
    private $titleFirstPage = '';
    /**
     * @var string Title link to previous page
     */
    private $titlePrevPage = '';
    /**
     * @var string Title link to x page
     */
    private $titleXPage = '';
    /**
     * @var string Title link to next page
     */
    private $titleNextPage = '';
    /**
     * @var string Title link to last page
     */
    private $titleLastPage = '';
 
    /**
     * Creates Pagination
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }
 
    /**
	 * Gets total items
     * @return int
     */
    public function getTotalItems()
    {
        return $this->totalItems;
    }
 
    /**
	 * Sets how many items is in database
     * @param int $totalItems
     */
    public function setTotalItems($totalItems)
    {
        $this->totalItems = $totalItems;
    }
 
    /**
	 * Gets number of page
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }
 
    /**
	 * Sets current page
     * @param int $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }
 
    /**
	 * Gets how many items can be loaded on page
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->itemsPerPage;
    }
 
    /**
	 * Sets how many items can be loaded on page
     * @param int $itemsPerPage
     */
    public function setItemsPerPage($itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;
    }
 
    /**
	 * Gets how many links can be loaded on page
     * @return int
     */
    public function getNumLinks()
    {
        return $this->numLinks;
    }
 
    /**
	 * Sets how many links can be loaded on page
     * @param int $numLinks
     */
    public function setNumLinks($numLinks)
    {
        $this->numLinks = $numLinks;
    }
 
    /**
	 * Gets URL
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
 
    /**
	 * Sets URL
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
 
    /**
	 * Gets result text
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
 
    /**
	 * Sets result text
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }
 
    /**
	 * Gets first page link text
     * @return string
     */
    public function getTextFirstPage()
    {
        return $this->textFirstPage;
    }
 
    /**
	 * Sets first page link text
     * @param string $textFirstPage
     */
    public function setTextFirstPage($textFirstPage)
    {
        $this->textFirstPage = $textFirstPage;
    }
 
    /**
	 * Gets last page link text
     * @return string
     */
    public function getTextLastPage()
    {
        return $this->textLastPage;
    }
 
    /**
	 * Sets last page link text
     * @param string $textLastPage
     */
    public function setTextLastPage($textLastPage)
    {
        $this->textLastPage = $textLastPage;
    }
 
    /**
	 * Gets next page link text
     * @return string
     */
    public function getTextNextPage()
    {
        return $this->textNextPage;
    }
 
    /**
	 * Sets next page link text
     * @param string $textNextPage
     */
    public function setTextNextPage($textNextPage)
    {
        $this->textNextPage = $textNextPage;
    }
 
    /**
	 * Gets previous page link text
     * @return string
     */
    public function getTextPrevPage()
    {
        return $this->textPrevPage;
    }
 
    /**
	 * Sets previous page link text
     * @param string $textPrevPage
     */
    public function setTextPrevPage($textPrevPage)
    {
        $this->textPrevPage = $textPrevPage;
    }
 
    /**
	 * Gets left separator
     * @return string
     */
    public function getSeparatorLeft()
    {
        return $this->separatorLeft;
    }
 
    /**
	 * Sets left separator
     * @param string $separatorLeft
     */
    public function setSeparatorLeft($separatorLeft)
    {
        $this->separatorLeft = $separatorLeft;
    }
 
    /**
	 * Gets right separator
     * @return string
     */
    public function getSeparatorRight()
    {
        return $this->separatorRight;
    }
 
    /**
	 * Sets right separator
     * @param string $separatorRight
     */
    public function setSeparatorRight($separatorRight)
    {
        $this->separatorRight = $separatorRight;
    }
 
    /**
	 * Gets total number pages
     * @return int
     */
    public function getNumPages()
    {
        return $this->numPages;
    }
 
    /**
	 * Sets total number pages
     * @param int $numPages
     */
    public function setNumPages($numPages)
    {
        $this->numPages = $numPages;
    }
 
    /**
	 * Gets title link first page
     * @return string
     */
    public function getTitleFirstPage()
    {
        return $this->titleFirstPage;
    }
 
    /**
	 * Sets title link first page
     * @param string $titleFirstPage
     */
    public function setTitleFirstPage($titleFirstPage)
    {
        $this->titleFirstPage = $titleFirstPage;
    }
 
    /**
	 * Gets title link last page
     * @return string
     */
    public function getTitlePrevPage()
    {
        return $this->titlePrevPage;
    }
 
    /**
	 * Sets title link last page
     * @param string $titlePrevPage
     */
    public function setTitlePrevPage($titlePrevPage)
    {
        $this->titlePrevPage = $titlePrevPage;
    }
 
    /**
	 * Gets title link X page
     * @return string
     */
    public function getTitleXPage()
    {
        return $this->titleXPage;
    }
 
    /**
	 * Sets title link X page
     * @param string $titleXPage
     */
    public function setTitleXPage($titleXPage)
    {
        $this->titleXPage = $titleXPage;
    }
 
    /**
	 * Gets title link next page
     * @return string
     */
    public function getTitleNextPage()
    {
        return $this->titleNextPage;
    }
 
    /**
	 * Sets title link next page
     * @param string $titleNextPage
     */
    public function setTitleNextPage($titleNextPage)
    {
        $this->titleNextPage = $titleNextPage;
    }
 
    /**
	 * Gets title link last page
     * @return string
     */
    public function getTitleLastPage()
    {
        return $this->titleLastPage;
    }
  
    /**
	 * Sets title link last page
     * @param string $titleLastPage
     */
    public function setTitleLastPage($titleLastPage)
    {
        $this->titleLastPage = $titleLastPage;
    }
 
	/**
	 * Return html code for Pagination
	 * @return string
	 */
    private function getResult()
    {
 
        $numPages = ceil($this->totalItems / $this->itemsPerPage);
 
		if($this->page != 1 && $this->page > $numPages || $numPages==0)
		{
			return "";
		}
		
        $output = '';
 
        if ($this->page > 1) 
		{
            if ($this->textFirstPage) 
			{
                $firstUrl = str_replace('{page}', 1, $this->url);
                $output .= '<a class="pagination-link" title="' . $this->titleFirstPage . '" href="' . $firstUrl . '">' . $this->textFirstPage . '</a>';
            }
            if ($this->textPrevPage) 
			{
                $prevUrl = str_replace('{page}', $this->page - 1, $this->url);
                $output .= '<a class="pagination-link" title="' . $this->titlePrevPage . '" href="' . $prevUrl . '">' . $this->textPrevPage . '</a> ';
            }
        }
 
 
        if ($numPages > 1) 
		{
            if ($numPages <= $this->numLinks) 
			{
                $start = 1;
                $end = $numPages;
            }
			else 
			{
                $start = $this->page - floor($this->numLinks / 2);
                $end = $this->page + floor($this->numLinks / 2);
 
                if ($start < 1) 
					{
                    $end += abs($start) + 1;
                    $start = 1;
                }
 
                if ($end > $numPages) {
                    $start -= ($end - $numPages);
                    $end = $numPages;
                }
            }
 
            if ($start > 1) 
			{
                $output .= $this->separatorLeft;
            }
 
            for ($i = $start; $i <= $end; $i++) 
			{
                if ($this->page == $i) {
                    $output .= ' <span>' . $i . '</span> ';
                } 
				else 
				{
                    $output .= ' <a class="pagination-link" title="' . str_replace('{page}', $i, $this->titleXPage) . '" href="' . str_replace('{page}', $i, $this->url) . '">' . $i . '</a> ';
                }
            }
 
            if ($end < $numPages) 
			{
                if (strpos($this->separatorRight, '{all_pages}') !== false)
				{
                    $output .= str_replace('{all_pages}', '<a class="pagination-link" title="' . str_replace('{page}', $numPages, $this->titleXPage) . '" href="' . str_replace('{page}', $numPages, $this->url) . '">' . $numPages . '</a>', $this->separatorRight);
                }
				else
				{
                    $output .= str_replace('{pages}', $numPages, $this->separatorRight);
                }
            }
        }
 
        if ($this->page < $numPages) 
		{
            if ($this->textNextPage) 
			{
				$output .= '<a class="pagination-link" title="' . $this->titleNextPage . '" href="' . str_replace('{page}', $this->page + 1, $this->url) . '">' . $this->textNextPage . '</a> ';
			}
			if ($this->textLastPage) 
			{
				$output .= '<a class="pagination-link" title="' . $this->titleLastPage . '" href="' . str_replace('{page}', $numPages, $this->url) . '">' . $this->textLastPage . '</a> ';
			}
		}
 
        $find = array(
            '{start}',
            '{end}',
            '{total}',
            '{pages}'
        );
 
        $replace = array(
            ($this->totalItems) ? (($this->page - 1) * $this->itemsPerPage) + 1 : 0,
            ((($this->page - 1) * $this->itemsPerPage) > ($this->totalItems - $this->itemsPerPage)) ? $this->totalItems : ((($this->page - 1) * $this->itemsPerPage) + $this->itemsPerPage),
            $this->totalItems,
            $numPages
        );
 
        $this->numPages = $numPages;
 
        return ($output ? '<div class="pagination-links">' . $output . '</div>' : '') . '<div class="pagination-result">' . str_replace($find, $replace, $this->text) . '</div>';
    }
	
	public function printHTML() 
	{
		print($this->getResult());
	}
	
	public function __toString() 
	{
		return $this->getResult();
	}
}