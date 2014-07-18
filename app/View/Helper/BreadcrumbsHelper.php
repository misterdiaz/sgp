<?php
/**
 * Breadcrumbs helper
 * Allows to generate and display breadcrumbs with a convenient syntax
 *
 * It uses a <ul><li> syntax but can be extended and protected method overriden to
 * generate the markup adapted to your situation
 * 
 */
class BreadcrumbsHelper extends AppHelper {
/**
 * Helpers needed
 *
 * @var array
 */
	public $helpers = array('Html');
 
/**
 * Separator string to use between each crumb
 * Set an empty string to not use a text separator
 *
 * @var string
 */
	public $separator = ' &gt; ';
 
/**
 * Breadcrumbs array
 *
 * @var array
 */
	protected $_breadcrumbs = array();
 
/**
 * Adds a crumb to the list and disable the link if it is the current page
 *
 * @param string $label Text for link
 * @param mixed $link URL for link (if empty it won't be a link)
 * @return Instance of the helper to allow chained calls
 */
	public function addCrumb($label, $link = null) {
		if (!empty($label)) {
			if (!is_null($link) && Router::url($link) == $this->here) {
				$link = null;
			}
			$this->_breadcrumbs[] = compact('label', 'link');
		}
		return $this;
	}
 
/**
 * Gets the breadcrumbs list
 *
 * @param mixed $home True to include a link to the homepage, or false, or the
 *	name of the link to the homepage
 * @param boolean $reset If true the breadcrumbs list will also be cleared
 * @return string Markup of the list
 */
	public function getCrumbs($home = true, $reset = true) {
		$markup = '';
		$breadcrumbs = $this->_breadcrumbs;
		if ($home) {
			if ($home === true) {
				$home = __('Home', true);
			}
			array_unshift($breadcrumbs, array('label' => $home, 'link' => '/'));
		}
		if (!empty($breadcrumbs)) {
			foreach ($breadcrumbs as $breadcrumb) {
				$markup .= $this->_crumbMarkup($breadcrumb);
			}
			$markup = $this->_wrapCrumbs($markup);
 
			if ($reset) {
				$this->_breadcrumbs = array();
			}
		}
		return $markup;
	}
 
/**
 * Generates the markup for a crumb element
 * 
 * @param array $breadcrumb Breadcrumb information, containing a label and a link (optional)
 * @return string Markup for this single breadcrumb
 */
	protected function _crumbMarkup($breadcrumb) {
		return $this->Html->tag(
			'li',
			empty($breadcrumb['link'])
				? $this->Html->tag('strong', $breadcrumb['label']) . $this->separator
				: $this->Html->link($breadcrumb['label'], $breadcrumb['link']) . $this->separator
		);
	}
 
/**
 * Wraps the markup for crumbs in an element
 *
 * @param string $markup
 * @return string
 */
	protected function _wrapCrumbs($markup) {
		if (!empty($this->separator)) {
			$posSeparatorToRemove = strrpos($markup, $this->separator);
			$markup = substr($markup, 0, $posSeparatorToRemove) . substr($markup, $posSeparatorToRemove + strlen($this->separator));
		}
		return $this->Html->tag('ul', $markup, array('class' => 'breadcrumbs'));
	}
 
}