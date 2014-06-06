<?php

Yii::import('bootstrap.widgets.TbBaseMenu');

/**
 * Bootstrap menu.
 *
 * @see <http://twitter.github.com/bootstrap/components.html#navs>
 *
 * @package booster.widgets.navigation
 */
class TbAceMenu extends TbBaseMenu
{
	// Menu types.
	const TYPE_TABS = 'tabs';
	const TYPE_PILLS = 'pills';
	const TYPE_LIST = 'list';

	/**
	 * @var string the menu type.
	 *
	 * Valid values are 'tabs', 'pills', or 'list'.
	 */
	public $type;

	/**
	 * @var string|array the scrollspy target or configuration.
	 */
	public $scrollspy;

	/**
	 * @var boolean indicates whether the menu should appear vertically stacked.
	 */
	public $stacked = false;

	/**
	 * @var boolean indicates whether dropdowns should be dropups instead.
	 */
	public $dropup = false;

	/**
	 *### .init()
	 *
	 * Initializes the widget.
	 */
	public function init()
	{   
        
        if(isset($this->htmlOptions['id']))
			$this->id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$this->id;
		
        if(isset($this->getController()->menu_route)){
            $route = $this->getController()->menu_route;
        }else{
            $route=$this->getController()->getRoute();
        }
		$this->items=$this->normalizeItems($this->items,$route,$hasActiveChild);

		$classes = array('nav');

		$validTypes = array(self::TYPE_TABS, self::TYPE_PILLS, self::TYPE_LIST);

		if (isset($this->type) && in_array($this->type, $validTypes)) {
			$classes[] = 'nav-' . $this->type;
		}

		if ($this->stacked && $this->type !== self::TYPE_LIST) {
			$classes[] = 'nav-stacked';
		}

		if ($this->dropup === true) {
			$classes[] = 'dropup';
		}

		if (isset($this->scrollspy)) {
			$scrollspy = is_string($this->scrollspy) ? array('target' => $this->scrollspy) : $this->scrollspy;
			$this->widget('bootstrap.widgets.TbScrollSpy', $scrollspy);
		}

		if (!empty($classes)) {
			$classes = implode(' ', $classes);
			if (isset($this->htmlOptions['class'])) {
				$this->htmlOptions['class'] .= ' ' . $classes;
			} else {
				$this->htmlOptions['class'] = $classes;
			}
		}
	}

	/**
	 *### .getDividerCssClass()
	 *
	 * Returns the divider css class.
	 *
	 * @return string the class name
	 */
	public function getDividerCssClass()
	{
		return (isset($this->type) && $this->type === self::TYPE_LIST) ? 'divider' : 'divider-vertical';
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
		return '';
	}

	/**
	 *### .isVertical()
	 *
	 * Returns whether this is a vertical menu.
	 *
	 * @return boolean the result
	 */
	public function isVertical()
	{
		return isset($this->type) && $this->type === self::TYPE_LIST;
	}

	/**
	 *### .renderMenu()
	 *
	 * Renders the menu items.
	 *
	 * @param array $items menu items. Each menu item will be an array with at least two elements: 'label' and 'active'.
	 * It may have three other optional elements: 'items', 'linkOptions' and 'itemOptions'.
	 */
	protected function renderMenu($items)
	{
		$n = count($items);
//        $route=$this->getController()->getRoute();
//        var_dump($route);exit;
		if ($n > 0) {
			echo CHtml::openTag('ul', $this->htmlOptions);

			$count = 0;
			foreach ($items as $item) {
				$count++;

				if (isset($item['divider'])) {
					echo '<li class="' . $this->getDividerCssClass() . '"></li>';
				} else {
					$options = isset($item['itemOptions']) ? $item['itemOptions'] : array();
					$classes = array();

					if ($item['active'] && $this->activeCssClass != '') {
						$classes[] = $this->activeCssClass;
					}

					if ($count === 1 && $this->firstItemCssClass !== null) {
						$classes[] = $this->firstItemCssClass;
					}

					if ($count === $n && $this->lastItemCssClass !== null) {
						$classes[] = $this->lastItemCssClass;
					}

					if ($this->itemCssClass !== null) {
						$classes[] = $this->itemCssClass;
					}

					if (isset($item['items'])) {
						$classes[] = $this->getDropdownCssClass();
					}

					if (isset($item['disabled'])) {
						$classes[] = 'disabled';
					}

					if (!empty($classes)) {
						$classes = implode(' ', $classes);
						if (!empty($options['class'])) {
							$options['class'] .= ' ' . $classes;
						} else {
							$options['class'] = $classes;
						}
					}

                    /**
                     * submenu
                     */
                    $item_is_active = FALSE;
                    $submenu = FALSE;
					if (isset($item['items']) && !empty($item['items'])) {
                        foreach($item['items'] as $submenu_item){
                            $submenu_item_class = '';                            
                            if(isset($submenu_item['active']) && $submenu_item['active']){
                                $item_is_active = TRUE;
                                $submenu_item_class = ' class="active"';
                                $submenu_item['icon'] = 'icon-double-angle-right';
                            }
                            $submenu .= '<li'.$submenu_item_class.'>'.$this->renderSubMenuItem($submenu_item).'</li>';
                        }
					}
                    
                    //main menu active
                    if ($item_is_active) {
                        if (!empty($options['class'])) {
                            $options['class'] .= ' active open' . $classes;
                        } else {
                            $options['class'] = 'active open';
                        }
                    }
                    
                    //OUTPUT
                    echo CHtml::openTag('li', $options);

					$menu = $this->renderMenuItem($item);

					if (isset($this->itemTemplate) || isset($item['template'])) {
						$template = isset($item['template']) ? $item['template'] : $this->itemTemplate;
						echo strtr($template, array('{menu}' => $menu));
					} else {
						echo $menu;
					}

                    if($submenu){
                        echo '<ul class="submenu">'.$submenu.'</ul>';
                    }
					echo '</li>';
				}
			}

			echo '</ul>';
		}
	}
    
    
	/**
	 *### .renderMenuItem()
	 *
	 * Renders the content of a menu item.
	 * Note that the container and the sub-menus are not rendered here.
	 *
	 * @param array $item the menu item to be rendered. Please see {@link items} on what data might be in the item.
	 *
	 * @return string the rendered item
	 */
	protected function renderMenuItem($item)
	{
        $item['label'] = '<span class="menu-text">' . $item['label'] . '</span>';
		if (isset($item['icon'])) {
			if (strpos($item['icon'], 'icon') === false) {
				$pieces = explode(' ', $item['icon']);
				$item['icon'] = 'icon-' . implode(' icon-', $pieces);
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

            //fixed for ACE
			//$item['linkOptions']['data-toggle'] = 'dropdown';
            
            //fixed for ACE
			$item['label'] .= ' <b class="arrow icon-angle-down"></b>';
		}

		if (isset($item['url'])) {
			return CHtml::link($item['label'], $item['url'], $item['linkOptions']);
		} else {
			return $item['label'];
		}
	}
	/**
	 *### .renderSubMenuItem()
	 *
	 * Renders the content of a submenu item.
	 * Note that the container and the sub-menus are not rendered here.
	 *
	 * @param array $item the menu item to be rendered. Please see {@link items} on what data might be in the item.
	 *
	 * @return string the rendered item
	 */
	protected function renderSubMenuItem($item)
	{

		if (isset($item['icon'])) {
			if (strpos($item['icon'], 'icon') === false) {
				$pieces = explode(' ', $item['icon']);
				$item['icon'] = 'icon-' . implode(' icon-', $pieces);
			}

			$item['label'] = '<i class="' . $item['icon'] . '"></i> ' . $item['label'];
		}

		if (!isset($item['linkOptions'])) {
			$item['linkOptions'] = array();
		}

		if (isset($item['url'])) {
			return CHtml::link($item['label'], $item['url'], $item['linkOptions']);
		} else {
			return $item['label'];
		}
	}
    
}
