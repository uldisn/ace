<?php

class TbAceHrMenu extends TbMenu
{
    public $dropdownCssClass = 'light-blue';
	protected function renderMenuItem($item)
	{
		if (isset($item['icon'])) {
			if (strpos($item['icon'], 'icon') === false && strpos($item['icon'], 'fa') === false) {
				$item['icon'] = 'icon-' . implode(' icon-', explode(' ', $item['icon']));
			}

			$item['label'] = '<i class="' . $item['icon'] . '"></i> ' . $item['label'];
		}

		if (!isset($item['linkOptions'])) {
			$item['linkOptions'] = array();
		}

		if (isset($item['items']) && !empty($item['items'])) {
			if (empty($item['url'])) {
				$item['url'] = '#';
			}

			if (isset($item['linkOptions']['class'])) {
				$item['linkOptions']['class'] .= ' dropdown-toggle';
			} else {
				$item['linkOptions']['class'] = 'dropdown-toggle';
			}

			$item['linkOptions']['data-toggle'] = 'dropdown';
			$item['label'] .= ' <i class="icon-caret-down"></i>';
		}

		if (isset($item['url'])) {
			return CHtml::link($item['label'], $item['url'], $item['linkOptions']);
		} else {
			return $item['label'];
		}
	}    
    
	/**
	 *### .getDropdownCssClass()
	 *
	 * Returns the dropdown css class.
	 *
	 * @return string the class name
	 */
	public function getDropdownCssClass()
	{
		return $this->dropdownCssClass;
	}    
}
