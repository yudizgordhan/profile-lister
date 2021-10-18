<?php
namespace Yudiz\Freelancer\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Event\ObserverInterface;

class Topmenulink implements ObserverInterface
{
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\UrlInterface $urlBuilder
    ) {
        $this->_scopeConfig = $scopeConfig;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Check config for some flag to determine if original plugins should run
     */
    public function isDisabled()
    {
        $scopeConfigvalue = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->_scopeConfig->getValue('freelancer/general/enable', $scopeConfigvalue);
    }

    /**
     * @param EventObserver $observer
     * @return $this
     */
    public function execute(EventObserver $observer)
    {
        if ($this->isDisabled()) {
            $menu = $observer->getMenu();
            $tree = $menu->getTree();
            $data = [
                'name'      => __('Freelancers'), // Link Lable
                'id'        => 'freelancer_top_menu_link', //unique-id-here
                'url'       => $this->urlBuilder->getUrl('freelancer/lists/'),
                'is_active' => false //(expression to determine if menu item is selected or not) (true/false)
            ];
            $node = new Node($data, 'id', $tree, $menu);
            $menu->addChild($node);
            return $this;
        }
    }
}
